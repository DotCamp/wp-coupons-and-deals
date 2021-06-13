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
			__( 'WP Coupons and Deals: Import Coupons', 'wpcd-coupon' ),
			__( 'Import Coupons (Pro)', 'wpcd-coupon' ),
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

		$template = new WPCD_Template_Loader();

		ob_start();

		$template->get_template_part( 'import-page' );

		$output = ob_get_clean();

		echo $output;
	}

}
