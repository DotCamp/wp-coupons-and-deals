<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shows the shortcodes after coupon is published.
 *
 * @since 2.3.2
 */
class WPCD_Help_Metabox {

	private $screens = array(
		'wpcd_coupons',
	);
	private $fields = array();

	/**
	 * Class construct method.
	 *
	 * @since 2.3.2
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 *
	 * @since 2.3.2
	 */
	public function add_meta_boxes() {
		global $post;

		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'help',
				__( 'Help', 'wp-coupons-and-deals' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'side',
				'low'
			);
		}

	}

	/**
	 * Generates the HTML for the meta box
	 *
	 * @param object $post WordPress post object
	 *
	 * @since 2.3.2
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'shortcodes_data', 'shortcodes_nonce' );
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 *
	 * @since 2.3.2
	 */
	public function generate_fields( $post ) {
		echo '<p style="font-size: 14px;">' . __( 'If you have any questions or confusions, please check our ', 'wp-coupons-and-deals' ) . '<a target="_blank" href="https://wpcouponsdeals.com/knowledgebase/">' . __( 'Knowledgebase', 'wp-coupons-and-deals' ) . '</a>' . __( ' or', 'wp-coupons-and-deals' ) . '<a target="_blank" href="https://wpcouponsdeals.com/contact-us/">' . __( ' contact us', 'wp-coupons-and-deals' ) . '</a>.</p>';
		echo 
		'
		<p>Other Tools By Me:</p>
		<ol>
			<li><a target="_blank" href="https://wordpress.org/plugins/wp-table-builder/">WP Table Builder</a> - Drag and Drop Table Builder.</li>
			<li><a target="_blank" href="https://wordpress.org/plugins/ultimate-blocks/">Ultimate Blocks</a> - Custom Gutenberg Blocks.</li>
			<li><a target="_blank" href="https://wordpress.org/themes/groundwp/">GroundWP</a> - Block Theme For Site Building.</li>
		</ol>';
	}

}
