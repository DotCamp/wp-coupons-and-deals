<?php
/**
 * Plugin Name: WP Coupons and Deals
 * Plugin URI: https://wpcouponsdeals.com/
 * Version: 2.5.0.1
 * Description: Best WordPress Coupon Plugin. Generate more affiliate sales with coupon codes and deals.
 * Author: Imtiaz Rayhan
 * Author URI: http://imtiazrayhan.com/
 * Author Email: irayhan.asif@gmail.com
 * Text Domain: wpcd-coupon
 * License: GPLv2 or later
 *
 * @package wpcd_coupon
 * @author Imtiaz Rayhan
 */

// If accessed directly, exit.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Loading translation.
 */
function wpcd_load_languages() {
	load_plugin_textdomain( 'wpcd-coupon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'wpcd_load_languages' );
// Loading SDK.
if ( ! function_exists( 'wcad_fs' ) ) {
	/**
	 * Configure freemius
	 */
	function wcad_fs() {
		global  $wcad_fs;

		if ( ! isset( $wcad_fs ) ) {
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/includes/sdk/freemius/start.php';
			$wcad_fs = fs_dynamic_init( array(
				'id'                  => '1200',
				'slug'                => 'wp-coupons-and-deals',
				'type'                => 'plugin',
				'public_key'          => 'pk_76752add3b978f15fe1e4a18cf2bc',
				'is_premium'          => true,
				'has_addons'          => false,
				'has_paid_plans'      => true,
				'trial'               => array(
					'days'               => 14,
					'is_require_payment' => false,
				),
				'has_affiliation'     => 'selected',
				'menu'                => array(
					'slug'           => 'edit.php?post_type=wpcd_coupons',
					'first-path'     => 'index.php?page=wpcd_welcome_menu_page',
					'support'        => false,
				),

			) );
		}

		return $wcad_fs;
	}

		// Init SDK.
		wcad_fs();
		// Signal that SDK was initiated.
		do_action( 'wcad_fs_loaded' );
}

// Requiring the main plugin file.
require_once dirname( __FILE__ ) . '/includes/main.php';
// Instantiating the main class plugin.
WPCD_Plugin::instance();
// Initialing hooks, functions, classes.
WPCD_Plugin::init();
register_activation_hook( __FILE__, array( 'WPCD_Plugin', 'wpcd_activate' ) );
register_deactivation_hook( __FILE__, array( 'WPCD_Plugin', 'wpcd_deactivate' ) );
