<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adding the path to necessary files.
 *
 * @since 1.0
 */
$path = trailingslashit( dirname( plugin_dir_path( __FILE__ ) ) );

/**
 * Requiring necessary files to add necessary actions.
 *
 * @since 1.0
 */
require_once $path . 'wpcd-add-coupon-button.php';
require_once $path . 'wpcd-help-info.php';
require_once $path . 'wpcd-widget-help-info.php';
require_once $path . 'wpcd-shortcode-insert-button.php';

/**
 * Adding the actions to use them later on
 * building the insert button.
 *
 * @since 1.0
 */
add_action( 'wpcd_add_button', 'wpcd_add_coupon_button', 10, 2 );
add_action( 'wpcd_help_info_div', 'wpcd_help_info', 10, 2 );
add_action( 'wpcd_widget_help_info_display', 'wpcd_widget_help_info', 10, 2 );
add_action( 'wpcd_shortcode_insert_button_div', 'wpcd_shortcode_insert_button', 10, 2 );


function wpcd_post_thumbnail_fallback( $content, $post_id, $thumbnail_id = '' ) {
	global $post_type;
	$script_help = '<script>wpcd_featured_img_func();</script>';

	return $content . $script_help;
}

add_filter( 'admin_post_thumbnail_html', 'wpcd_post_thumbnail_fallback', 10, 3 );