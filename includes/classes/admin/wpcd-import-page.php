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
			'manage_options',
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

		global $import_page;

		// Add style to the welcome page only.
		if ( $hook != $import_page ) {
			return;
		}
		wp_enqueue_style( 'wpcd-admin-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/' . WPCD_Assets::wpcd_version_correct( 'dir' ) . 'admin' . WPCD_Assets::wpcd_version_correct( 'suffix' ) . '.css', false );
		wp_enqueue_script( 'wpcd-admin-js', WPCD_Plugin::instance()->plugin_assets . 'admin/js/admin.js', array(
			'jquery',
			'jquery-ui-datepicker',
			'wp-color-picker'
		), WPCD_Plugin::PLUGIN_VERSION, false );

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