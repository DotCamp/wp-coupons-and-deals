<?php

/**
 * front end coupon submit short-code
 * Class WPCD_Form_Shortcode
 */
class WPCD_Form_Shortcode extends WPCD_Short_Code_Base {

	public function add() {

		$fields = WPCD_Meta_Boxes_Fields_Pro__Premium_Only::getFields();


		// including the necessary js files for front end display
		$pure_path      = '/js/formShortcode.bundle.js';
		$asset_uri_path = WPCD_Plugin::instance()->plugin_assets . $pure_path;
		$asset_dir_path = WPCD_Plugin::instance()->plugin_dir_path . '/assets' . $pure_path;
		$version        = filemtime( $asset_dir_path );

		$this->_c()->add_action( 'wp_enqueue_scripts', function () use ( $asset_uri_path, $version, $fields ) {

			wp_enqueue_script( 'form_shortcode_script', $asset_uri_path, array(), $version, true );

			wp_enqueue_style( 'form_shortcode_style', 'https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css' );

			// send fields as a localized script to front end
			wp_localize_script( 'form_shortcode_script', 'formShortcodeFields', $fields );
		} );

		parent::add();
	}

	public function logic( $attrs ) {

		return "<div id='form_shortcode'></div>";
	}
}