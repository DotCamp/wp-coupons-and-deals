<?php
// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPCD_Import_Page_Pro extends WPCD_Import_Page {

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
			__( 'Import Coupons', 'wp-coupons-and-deals' ),
            WPCD_Plugin::ALLOWED_ROLE_META_CAP,
			'wpcd_coupon_import',
			array( $this, 'import_page' )
		);
	}

	/**
	 * Content for Import Page.
	 *
	 * @since 2.3.2
	 */
	public function import_page() {

		$template = new WPCD_Template_Loader();

		ob_start();

		$template->get_template_part( 'import-page__premium_only' );

		$output = ob_get_clean();

		echo $output; //look at includes/templates/extras/import-page__premium_only
	}

}
