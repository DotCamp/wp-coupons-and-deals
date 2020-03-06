<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shows the coupon_preview after coupon is published.
 *
 * @since 2.0
 */
class WPCD_Preview_Metabox {

	private $screens = array(
		'wpcd_coupons',
	);
	private $fields = array();

	/**
	 * add meta box support for the application
	 */
	public function add_meta_boxes() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes_callback' ) );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 *
	 * @since 2.0
	 */
	public function add_meta_boxes_callback() {

		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'coupon_preview',
				__( 'Coupon Preview', 'wpcd-coupon' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'normal',
				'low'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 *
	 * @param object $post WordPress post object
	 *
	 * @since 2.0
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'coupon_preview_data', 'coupon_preview_nonce' );
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 *
	 * @since 2.0
	 */
	public function generate_fields( $post ) {

		$output = '';

		ob_start();

		include WPCD_Plugin::instance()->plugin_includes . 'functions/admin/wpcd-preview-metabox.php';

		$output .= ob_get_clean();

		echo $output;
	}

}
