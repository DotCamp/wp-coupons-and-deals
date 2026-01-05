<?php
/**
 * Plugin Name: WP Coupons and Deals
 * Plugin URI: https://wpcouponsdeals.com/
 * Version: 3.2.4
 * Description: Best WordPress Coupon Plugin. Generate more affiliate sales with coupon codes and deals.
 * Author: WP Coupons and Deals
 * Author URI: https://wpcouponsdeals.com/
 * Author Email: irayhan.asif@gmail.com
 * Text Domain: wp-coupons-and-deals
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
if ( ! function_exists( 'wpcd_load_languages' ) ) {
	function wpcd_load_languages() {
		load_plugin_textdomain( 'wp-coupons-and-deals', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
} else {
	deactivate_plugins( plugin_basename( __FILE__ ) );
	wp_die( 'Please deactivate the free version of the plugin before activating the pro version.' );
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
					'is_require_payment' => true,
				),
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


/**
 * convert all expire_dates in timestamp format
 */
add_action( 'upgrader_process_complete', 'wpcd_expire_date_convert_run', 10, 2 );
function wpcd_expire_date_convert_run( $instance, $extras ) {
    if(
        'plugin' !== $extras[ 'type' ] ||
        'update' !== $extras[ 'action' ] ||
        plugin_basename( __FILE__ ) !== $extras[ 'plugin' ]
    ) {
        return;
    }
    wpcd_expire_date_convert();
}

function wpcd_expire_date_convert() {
    if( get_option('wpcd_expire_date_converted' ) ) return;

    global $wpdb;
    $coupons_id = $wpdb->get_results("SELECT id FROM $wpdb->posts WHERE post_type = 'wpcd_coupons'", ARRAY_A);

    if($coupons_id && is_array($coupons_id)) {
        foreach ($coupons_id as $id) {
            if($id && is_array($id) && array_key_exists( 'id', $id )) {
                $coupon_id = $id['id'];

                expire_data_convert($coupon_id, 'coupon_details_expire-date');
                expire_data_convert($coupon_id, 'coupon_details_second-expire-date');
                expire_data_convert($coupon_id, 'coupon_details_third-expire-date');
            }
        }
    }

    function expire_data_convert($coupon_id, $meta_name) {
        $expire_date = get_post_meta( $coupon_id, $meta_name, true );

        if ( ! empty($expire_date) && (string) (int) $expire_date != $expire_date ) {
            $expire_date = strtotime( $expire_date );

            update_post_meta( $coupon_id, $meta_name, $expire_date );
        }
    }

    add_option('wpcd_expire_date_converted', '1');
}

function wpcd_add_duplicate_link( $actions, $post ) {
    if ( $post->post_type === 'wpcd_coupons' && current_user_can('edit_posts') ) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url( admin_url( 'admin.php?action=wpcd_duplicate_coupon&post=' . $post->ID ), 'wpcd-duplicate-coupon_' . $post->ID ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
    }
    return $actions;
}
add_filter( 'post_row_actions', 'wpcd_add_duplicate_link', 10, 2 );

function wpcd_duplicate_coupon_action() {
    // Check if user is logged in and has permission
    if (!is_user_logged_in()) {
        wp_die(__('You must be logged in to perform this action.', 'wp-coupons-and-deals'));
    }

    // Check user capability
    if (!current_user_can('edit_posts')) {
        wp_die(__('You do not have permission to duplicate coupons.', 'wp-coupons-and-deals'));
    }

    // Verify nonce token
    if (!isset($_GET['post']) || !isset($_GET['_wpnonce'])) {
        wp_die(__('Security check failed. No coupon to duplicate has been supplied.', 'wp-coupons-and-deals'));
    }

    $post_id = absint($_GET['post']);
    
    // Verify nonce
    if (!wp_verify_nonce($_GET['_wpnonce'], 'wpcd-duplicate-coupon_' . $post_id)) {
        wp_die(__('Security check failed. Invalid nonce token.', 'wp-coupons-and-deals'));
    }

    // Check if user can edit this specific post
    if (!current_user_can('edit_post', $post_id)) {
        wp_die(__('You do not have permission to duplicate this coupon.', 'wp-coupons-and-deals'));
    }

    $post = get_post($post_id);

    if (!isset($post) || $post == null) {
        wp_die(__('Failed to duplicate: Post not found.', 'wp-coupons-and-deals'));
    }

    // Verify post type is wpcd_coupons
    if ($post->post_type !== 'wpcd_coupons') {
        wp_die(__('Invalid post type. Only coupons can be duplicated.', 'wp-coupons-and-deals'));
    }

    $args = array(
        'post_title'     => $post->post_title . ' (Duplicate)',
        'post_type'      => $post->post_type,
        'post_status'    => 'draft',
    );
    
    $new_post_id = wp_insert_post($args);
    
    if (is_wp_error($new_post_id)) {
        wp_die(__('Failed to create duplicate coupon.', 'wp-coupons-and-deals'));
    }
    
    // Duplicate post meta
    $post_meta_data = get_post_meta($post_id);
    foreach ($post_meta_data as $key => $values) {
        foreach ($values as $value) {
            add_post_meta($new_post_id, $key, $value);
        }
    }

    // Duplicate post taxonomies
    $taxonomies = get_object_taxonomies($post->post_type);
    foreach ($taxonomies as $taxonomy) {
        $terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
        wp_set_object_terms($new_post_id, $terms, $taxonomy);
    }
    
    // Redirect to the edit screen for the new draft post
    wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
    exit;
}
add_action('admin_action_wpcd_duplicate_coupon', 'wpcd_duplicate_coupon_action');

// Initialize promoter.
require_once dirname( __FILE__ ) . '/vendor/autoload.php';
$default_promotions = \DotCamp\Promoter\Promoter::generate_default_promotions(__FILE__, 'WP Coupons and Deals', 'wp-coupons-and-deals/wp-coupons-deals.php');
\DotCamp\Promoter\Promoter::add_promotions($default_promotions, __FILE__);
