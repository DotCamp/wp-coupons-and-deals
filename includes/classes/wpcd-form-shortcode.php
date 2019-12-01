<?php

/**
 * front end coupon submit short-code
 * Class WPCD_Form_Shortcode
 */
class WPCD_Form_Shortcode extends WPCD_Short_Code_Base {

	public function add() {
		// extract form fields
		$fields = WPCD_Meta_Boxes_Fields_Pro__Premium_Only::getFields();

		$preview_metabox = new WPCD_Preview_Metabox();

		// extract coupon preview inline html elements and scripts
		ob_start();

		$preview_metabox->generate_fields( new stdClass() );
		$coupon_preview = ob_get_contents();

		ob_end_clean();

		// splitting the html file into our templates
		$split_html = $this->splitHtml( $coupon_preview, '<!-- :split Preview -->', '<!-- End of :split Preview -->',
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
		$pure_path      = '/js/formShortcode.bundle.js';
		$asset_uri_path = WPCD_Plugin::instance()->plugin_assets . $pure_path;
		$asset_dir_path = WPCD_Plugin::instance()->plugin_dir_path . '/assets' . $pure_path;
		$version        = filemtime( $asset_dir_path );

		// including necesssary translation strings
		$extras          = new stdClass();
		$extras->strings = [];

		$extras->strings['expire_text']  = $this->_c()->get_option( 'wpcd_expire-text', 'Expires on: ');
		$extras->strings['expired_text'] = $this->_c()->get_option( 'wpcd_expired-text','Expired on: '  );

		$http_type = isset($_SERVER['https'])?'https':'http';
		$extras->ajax_url  = admin_url('admin-ajax.php', $http_type);


		$this->_c()->add_action( 'wp_enqueue_scripts',
			function () use ( $extras, $asset_uri_path, $version, $fields, $split_html ) {

				//only enqueue necessary files if current post have the short-code
				if ( $this->haveShortcode() ) {
					$this->_c()->wp_enqueue_script( 'form_shortcode_script', $asset_uri_path, array(), $version, true );

					$this->_c()->wp_enqueue_style( 'form_shortcode_style',
						'https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css' );

					// send fields as a localized script to front end
					$this->_c()->wp_localize_script( 'form_shortcode_script', 'formShortcodeFields', $fields );

					$this->_c()->wp_localize_script( 'form_shortcode_script', 'couponPreview', $split_html );

					$this->_c()->wp_localize_script( 'form_shortcode_script', 'formShortcodeExtras', (array)$extras );
				}
			} );

		// add ajax to WordPress hook
		$ajax_hook_nopriv = new WPCD_Formshortcode_Ajax($this->name, false);
		$ajax_hook_nopriv->add();

		$ajax_hook_priv = new WPCD_Formshortcode_Ajax($this->name, true);
		$ajax_hook_priv->add();

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

		return "<div id='form_shortcode'></div>";
	}
}