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
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wpcd_styles' ) );
		add_action( 'admin_head', array( __CLASS__, 'remove_menu_entry' ) );

	}

	/**
	 * Menu item of the page.
	 *
	 * @since 2.0
	 */
	public static function wpcd_welcome_menu_page() {

		global $wpcd_sub_menu;

		$wpcd_sub_menu = add_submenu_page(
			'index.php',
			__( 'WP Coupons and Deals', 'wpcd-coupon' ),
			__( 'WP Coupons and Deals', 'wpcd-coupon' ),
			'read',
			'wpcd_welcome_menu_page',
			array(
				__CLASS__,
				'wpcd_welcome_page_content'
			)
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
			WPCD_Plugin::instance()->plugin_assets . 'admin/css/' . WPCD_Assets::wpcd_version_correct( 'dir' ) . 'welcome' . WPCD_Assets::wpcd_version_correct( 'suffix' ) . '.css',
			array(),
			WPCD_Plugin::PLUGIN_VERSION,
			'all'
		);

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