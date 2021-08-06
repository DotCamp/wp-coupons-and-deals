<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shows the shortcodes after coupon is published.
 *
 * @since 2.0
 */
class WPCD_Shortcode_Metabox {

	private $screens = array(
		'wpcd_coupons',
	);
	private $fields = array();

	/**
	 * Class construct method.
	 *
	 * @since 2.0
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 *
	 * @since 2.0
	 */
	public function add_meta_boxes() {
		global $post;

		if ( $post->post_status == 'publish' ) {
			foreach ( $this->screens as $screen ) {
				add_meta_box(
					'shortcodes',
					__( 'Coupon Shortcodes', 'wp-coupons-and-deals' ),
					array( $this, 'add_meta_box_callback' ),
					$screen,
					'side',
					'high'
				);
			}
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
		wp_nonce_field( 'shortcodes_data', 'shortcodes_nonce' );
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 *
	 * @since 2.0
	 */
	public function generate_fields( $post ) {
		$output = '';
		$output .= '<b>' . __( 'Full Coupon', 'wp-coupons-and-deals' ) . ':</b> [wpcd_coupon id=' . absint($post->ID) . ']' . '<br><br>';
		$output .= '<span class="only-coupon-code"><b>' . __( 'Only Coupon Code', 'wp-coupons-and-deals' ) . ':</b> [wpcd_code id=' . absint($post->ID) . ']</span>';

		$arr = array( 'b' => array(), 'span' => array(), 'br' => array() );
		echo wp_kses( $output, $arr );
		
	}

}
