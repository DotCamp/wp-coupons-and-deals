<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPCD_Welcome_Page
 *
 * Adds the welcome page.
 *
 * @since 2.0
 */
class WPCD_Welcome_Page {

	/**
	 * Initializing actions.
	 *
	 * @since 2.0
	 */
	public static function init() {

		add_action( 'admin_menu', array( __CLASS__, 'wpcd_welcome_menu_page' ) );
		//add_action( 'admin_init', array( __CLASS__, 'wpcd_safe_welcome_redirect' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wpcd_styles' ) );
		add_action( 'admin_head', array( __CLASS__, 'remove_menu_entry' ) );

	}

	/**
	 * Setting activation transient.
	 *
	 * @since 2.0
	 */
	public static function wpcd_welcome_activate() {

		set_transient( '_wpcd_redirect_welcome', true, 30 );

	}

	/**
	 * Setting deactivation transient.
	 *
	 * @since 2.0
	 */
	public static function wpcd_welcome_deactivate() {

		delete_transient( '_wpcd_redirect_welcome' );

	}

	/**
	 * Setting redirect.
	 *
	 * @since 2.0
	 */
	public static function wpcd_safe_welcome_redirect() {

		// Bail if no activation redirect transient is present.
		//if ( ! get_transient( '_wpcd_redirect_welcome' ) ) {
		//	return;
		//}

		// Delete the redirect transient.
		//delete_transient( '_wpcd_redirect_welcome' );

		// Bail if activating from network or bulk sites.
		//if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		//	return;
		//}

		// Redirect to Welcome Page.
		//wp_safe_redirect( add_query_arg( array( 'page' => 'wpcd_welcome_menu_page' ), admin_url( 'index.php' ) ) );

	}

	/**
	 * Menu item of the page.
	 *
	 * @since 2.0
	 */
	public static function wpcd_welcome_menu_page() {

		global $wpcd_sub_menu;

		$wpcd_sub_menu = add_submenu_page(
			'index.php', // The slug name for the parent menu (or the file name of a standard WordPress admin page).
			__( 'WP Coupons and Deals', 'wpcd-coupon' ), // The text to be displayed in the title tags of the page when the menu is selected.
			__( 'WP Coupons and Deals', 'wpcd-coupon' ), // The text to be used for the menu.
			'read', // The capability required for this menu to be displayed to the user.
			'wpcd_welcome_menu_page', // The slug name to refer to this menu by (should be unique for this menu).
			array(
				__CLASS__,
				'wpcd_welcome_page_content'
			) // The function to be called to output the content for this page.
		);

	}

	/**
	 * Welcome page content.
	 *
	 * @since 2.0
	 */
	public static function wpcd_welcome_page_content() {

		require_once( WPCD_Plugin::instance()->plugin_includes . 'functions/admin/wpcd-welcome-page-content.php' );

	}

	/**
	 * Necessary styles.
	 *
	 * @param $hook
	 *
	 * @since 2.0
	 */
	public static function wpcd_styles( $hook ) {

		global $wpcd_sub_menu;

		// Add style to the welcome page only.
		if ( $hook != $wpcd_sub_menu ) {
			return;
		}
		// Welcome page styles.
		wp_enqueue_style(
			'wpcd_welcome_style',
			WPCD_Plugin::instance()->plugin_assets . 'admin/css/welcome.css',
			array(),
			WPCD_Plugin::PLUGIN_VERSION,
			'all'
		);

		wp_enqueue_style( 'wpcd-admin-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/admin.css', false );
	}

	/**
	 * Removes the menu item.
	 *
	 * @since 2.0
	 */
	static function remove_menu_entry() {

		remove_submenu_page( 'index.php', 'wpcd_welcome_menu_page' );

	}

}