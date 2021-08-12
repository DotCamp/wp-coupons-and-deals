<?php
// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPCD_Import_Page {

	/**
	 * WPCD_Import_Page_Pro constructor.
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );

		/**
		 * Load stylesheets and scripts.
		 *
		 * @since 2.3.2
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_stylesheet_script' ) );

	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item() {

		global $import_page;
		/**
		 * Adding the import page under our main menu item.
		 *
		 * @since 2.3.2
		 */
		$import_page = add_submenu_page(
			'edit.php?post_type=wpcd_coupons',
			__( 'WP Coupons and Deals: Import Coupons', 'wp-coupons-and-deals' ),
			__( 'Import Coupons (Pro)', 'wp-coupons-and-deals' ),
            WPCD_Plugin::ALLOWED_ROLE_META_CAP,
			'wpcd_coupon_import',
			array( $this, 'import_page' )
		);

	}

	/**
	 * Loads the stylesheets on the settings page.
	 *
	 * @param $hook
	 *
	 * @since 2.3.2
	 */
	public function load_stylesheet_script( $hook ) {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'wpcd_coupons' == $screen->post_type ) {

			global $import_page;

			// Add style to the welcome page only.
			if ( $hook != $import_page ) {
				return;
			}

			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
		}
	}

	/**
	 * Content for Import Page.
	 *
	 * @since 2.3.2
	 */
	public function import_page() {
		echo '<div class="wrap">
		<h2>' . __( 'Import Coupons from CSV or XML File', 'wp-coupons-and-deals' ) . '</h2></div>
		<p style="font-size: 16px;">' . __( 'This is a Pro Version feature and only available to Pro Version users. It lets you add bulk of coupons at once from CSV or XML file.', 'wp-coupons-and-deals' ) . '</p>
		<p style="font-size: 16px;"><a href="' . esc_url( wcad_fs()->get_upgrade_url() ) . '">' . __( 'Upgrade to Pro!', 'wp-coupons-and-deals' ) . '</a>' . __( ' or ', 'wp-coupons-and-deals' ) .'<a href="' . esc_url( wcad_fs()->get_trial_url() ) . '">' . __( 'Start Free Trial!', 'wp-coupons-and-deals' )   . '</a>' . __( ' to start using this feature.', 'wp-coupons-and-deals' ) . '</p>
		<p style="font-size: 16px;">' . __( 'Alternatively, you can ', 'wp-coupons-and-deals' ) . '<a href="https://wpcouponsdeals.com/wp-coupons-and-deals-features/">' . __( 'check out Pro Features', 'wp-coupons-and-deals' ) . '</a>' . __( ' and see how it can protect your affiliate sales, generate more revenue.', 'wp-coupons-and-deals' ) . '</p>';
	}

}
