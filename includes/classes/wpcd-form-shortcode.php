<?php

/**
 * front end coupon submit short-code
 * Class WPCD_Form_Shortcode
 */
class WPCD_Form_Shortcode extends WPCD_Short_Code_Base {

	public function add() {
		// pro license check
		if ( $this->isProLicensed() ) {
			// extract form fields
			$fields = WPCD_Meta_Boxes_Fields_Pro__Premium_Only::getFields();

			$preview_metabox = new WPCD_Preview_Metabox();

			// extract coupon preview inline html elements and scripts
			ob_start();

			$preview_metabox->generate_fields( new stdClass() );
			$coupon_preview = ob_get_contents();

			ob_end_clean();

			// removing any script tag from the previews
			$coupon_preview = preg_replace( '#<script(.*?)>(.*?)</script>#is', '', $coupon_preview );

			// splitting the html file into our templates
			$split_html = $this->splitHtml( $coupon_preview, '<!-- :split Preview -->',
				'<!-- End of :split Preview -->',
				[
					'Default',
					'Template One',
					'Template Two',
					'Template Three',
					'Template Four',
					'Template Five',
					'Template Six',
					'Template Seven',
					'Template Eight',
				] );


			// including the necessary js files for front end display
			$js_pure_path      = '/js/formShortcode.bundle.js';
			$js_asset_uri_path = WPCD_Plugin::instance()->plugin_assets . $js_pure_path;
			$js_asset_dir_path = WPCD_Plugin::instance()->plugin_dir_path . '/assets' . $js_pure_path;
			$js_version        = filemtime( $js_asset_dir_path );

			$css_pure_path      = '/admin/css/dist/admin.min.css';
			$css_asset_uri_path = WPCD_Plugin::instance()->plugin_assets . $css_pure_path;
			$css_asset_dir_path = WPCD_Plugin::instance()->plugin_dir_path . '/assets' . $css_pure_path;
			$css_version        = filemtime( $css_asset_dir_path );

			// including necesssary translation strings
			$extras          = new stdClass();
			$extras->strings = [];

			$extras->strings['expire_text']  = $this->_c()->get_option( 'wpcd_expire-text', 'Expires on: ' );
			$extras->strings['expired_text'] = $this->_c()->get_option( 'wpcd_expired-text', 'Expired on: ' );

			// custom taxonomy terms
			$extras->terms = $this->getCouponTerms();

			$batch_translations = [
				'offer_expired_text' => 'This offer has expired!',
				'second'             => 'second',
				'seconds'            => 'seconds',
				'minute'             => 'minute',
				'minutes'            => 'minutes',
				'hour'               => 'hour',
				'hours'              => 'hours',
				'day'                => 'day',
				'days'               => 'days',
				'week'               => 'week',
				'weeks'              => 'weeks',
				'month'              => 'month',
				'months'             => 'months',
				'year'               => 'year',
				'years'              => 'years',
				'submit'             => 'Submit',
				'select_an_image'    => 'Select an image',
				'Add'                => 'Add',
				'set_featured_image' => "Set a featured image",
				'featured_image' => "featured image",
				'use_image' => "use this image"
			];

			$extras->strings = array_merge( $extras->strings,
				$this->get_batch_translations( $batch_translations, WPCD_Plugin::TEXT_DOMAIN ) );


			$protocol         = isset( $_SERVER['https'] ) ? 'https' : 'http';
			$extras->ajax_url = admin_url( 'admin-ajax.php', $protocol );
			$extras->nonce    = wp_create_nonce( 'wpcd_shortcode_form' );


			// enqueue scripts/styles step
			$this->_c()->add_action( 'wp_enqueue_scripts',
				function () use (
					$css_version,
					$css_asset_uri_path,
					$extras,
					$js_asset_uri_path,
					$js_version,
					$fields,
					$split_html
				) {

					//only enqueue necessary files if current post have the short-code
					if ( $this->haveShortcode() ) {
						$this->_c()->wp_enqueue_media();

						$this->_c()->wp_enqueue_script( 'form_shortcode_script', $js_asset_uri_path, array(),
							$js_version,
							true );

						$this->_c()->wp_enqueue_style( 'form_shortcode_style', $css_asset_uri_path, array(),
							$css_version );


						// send fields as a localized script to front end
						$this->_c()->wp_localize_script( 'form_shortcode_script', 'formShortcodeFields', $fields );

						$this->_c()->wp_localize_script( 'form_shortcode_script', 'couponPreview', $split_html );

						$this->_c()->wp_localize_script( 'form_shortcode_script', 'formShortcodeExtras',
							(array) $extras );
					}
				} );

			// add ajax to WordPress hook
			$ajax_hook_nopriv = new WPCD_Formshortcode_Ajax( $this->name, false );
			$ajax_hook_nopriv->add();

			$ajax_hook_priv = new WPCD_Formshortcode_Ajax( $this->name, true );
			$ajax_hook_priv->add();

		}

		parent::add();
	}

	/**
	 * @param $data string raw data to be searched for
	 * @param $split_clause_start string starting split clause
	 * @param $split_clause_end string ending split clause
	 * @param $split_array array array of clauses that will be replaced in ':split' variables in start/end parameters
	 *
	 * @return array array of found matches
	 */
	public function splitHtml( $data, $split_clause_start, $split_clause_end, $split_array ) {
		$result = [];
		foreach ( $split_array as $split ) {
			$temp  = [];
			$start = str_replace( ':split', $split, $split_clause_start );
			$end   = str_replace( ':split', $split, $split_clause_end );
			preg_match( "/$start(.+)$end/s", $data, $temp );
			$result[ $split ] = $temp[1];
		}

		return $result;
	}

	public function logic( $attrs ) {
		$pro_licensed_html = "<div id='form_shortcode'></div>";
		$not_licensed_html = "<div style='background-color: white; padding: 1rem; border-radius: 1rem;'>" . __( 'You need pro license to use this feature.',
				WPCD_Plugin::TEXT_DOMAIN ) . " <a href='https://wpcouponsdeals.com/' style='color:green'>" . __( 'Get one today!!!',
				WPCD_Plugin::TEXT_DOMAIN ) . "</a></div>";

		// pro license check
		return $this->isProLicensed() ? $pro_licensed_html : $not_licensed_html;
	}

	/**
	 * retrieve defined terms for custom coupon type taxonomies
	 * @return array terms array
	 */
	private function getCouponTerms() {
		$terms_filters = [ 'count', 'name', 'parent', 'term_id' ];


		$coupon_categories = get_terms( [ WPCD_Plugin::CUSTOM_TAXONOMY ],
			[ 'hide_empty' => false, 'orderby' => 'term_id', 'order' => 'ASC' ] );
		$vendor_categories = get_terms( [ WPCD_Plugin::VENDOR_TAXONOMY ],
			[ 'hide_empty' => false, 'orderby' => 'term_id', 'order' => 'ASC' ] );

		$coupon_categories = $this->filter_keys( $coupon_categories, $terms_filters );
		$vendor_categories = $this->filter_keys( $vendor_categories, $terms_filters );

		return [
			WPCD_Plugin::CUSTOM_TAXONOMY => $coupon_categories,
			WPCD_Plugin::VENDOR_TAXONOMY => $vendor_categories
		];
	}

	/**
	 * filter the keys of an array
	 *
	 * @param $array object array
	 * @param $filters array filter array
	 *
	 * @return array filtered array
	 */
	private function filter_keys( $array, $filters ) {
		$temp_array = [];
		foreach ( $array as $term ) {
			$filtered_terms = array_filter( (array) $term, function ( $k ) use ( $filters ) {
				return in_array( $k, $filters );
			}, ARRAY_FILTER_USE_KEY );
			$temp_array[]   = $filtered_terms;
		}

		return $temp_array;
	}


	/**
	 * get translation values in batch
	 *
	 * @param $key_array array keys for returned array keys/ values for translation keys
	 * @param $text_domain string text domain name
	 *
	 * @return array array of fetched translation values
	 */
	private function get_batch_translations( $key_array, $text_domain ) {
		$temp_array = [];
		foreach ( $key_array as $key => $value ) {
			$temp_array[ $key ] = __( $value, $text_domain );
		}

		return $temp_array;
	}

	/**
	 * check if the plugin is pro licensed
	 * @return mixed result of operation
	 */
	private function isProLicensed() {
		return $this->_c()->wcad_fs()->is_plan__premium_only( 'pro' );
	}
}