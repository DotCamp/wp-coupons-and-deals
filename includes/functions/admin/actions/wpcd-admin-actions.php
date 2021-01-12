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

// Import CSV using Ajax to function call.
add_action('wp_ajax_wpcd_process_import', 'wpcd_import_process_php');

function wpcd_import_process_php() {
    $params = json_decode( file_get_contents( 'php://input' ) );

	$wpcd_coupon_templates = array( 'Template One', 'Template Two',
                                    'Template Three', 'Template Four',
                                    'Template Five', 'Template Six',
                                    'Template Seven', 'Template Eight' );
	$wpcd_coupon_data = json_decode( stripslashes( $params->post_var ) );

    $nonce_ajax = stripslashes( $params->nonce_ajax );
	// wp_send_json($wpcd_coupon_data);
	if( ! wp_verify_nonce( $nonce_ajax, 'wpcd-script-nonce' ) ) {
		wp_die();
	} else {
		if ( $wpcd_coupon_data->title != '' ) {
			$args = array(
				'post_type'    => 'wpcd_coupons',
				'post_title'   => $wpcd_coupon_data->title,
				'post_content' => '',
				'post_status'  => 'publish',
			);
			$post_id = wp_insert_post( $args );
			if ( ! is_wp_error( $post_id ) ) {
                if ( ! empty( $wpcd_coupon_data->expiry_date ) ) {
                    $expyry_data = wpcd_datetotime( sanitize_text_field( $wpcd_coupon_data->expiry_date ) ) ?
                                    wpcd_datetotime( sanitize_text_field( $wpcd_coupon_data->expiry_date ) ) : "";
                }
                if ( empty( $expyry_data ) ) $expyry_data = "";
                if ( ! empty( $wpcd_coupon_data->expiry_time ) ) {
                    $expiry_time = strtotime( sanitize_text_field( $wpcd_coupon_data->expiry_time ) );
                    if ( ! empty( $expiry_time ) ) {
                        $expiry_time = date( 'g:i a', $expiry_time );
                    }
                }
                if ( empty( $expiry_time ) ) $expiry_time = "";
				add_post_meta( $post_id, 'coupon_details_coupon-type', 'Coupon', true );
				add_post_meta( $post_id, 'coupon_details_coupon-code-text', $wpcd_coupon_data->coupon_code, true );
				add_post_meta( $post_id, 'coupon_details_link', $wpcd_coupon_data->link, true );
				add_post_meta( $post_id, 'coupon_details_description', $wpcd_coupon_data->wpcd_description, true );
				add_post_meta( $post_id, 'coupon_details_discount-text', $wpcd_coupon_data->discount_text, true );
				add_post_meta( $post_id, 'coupon_details_show-expiration', 'Show', true );
				add_post_meta( $post_id, 'coupon_details_expire-date', $expyry_data, true );
				add_post_meta( $post_id, 'coupon_details_expire-time', $expiry_time, true );
				add_post_meta( $post_id, 'coupon_details_hide-coupon', $wpcd_coupon_data->hide_coupon, true );
				add_post_meta( $post_id, 'coupon_details_coupon-template', $wpcd_coupon_data->default_coupon_template, true );

				// Theme Color for only template Five and Six
				$theme_color = $wpcd_coupon_data->theme_color;
				if ( $wpcd_coupon_data->default_coupon_template == 'Template Five' ):
					add_post_meta( $post_id, 'coupon_details_template-five-theme', $theme_color );
				elseif( $wpcd_coupon_data->default_coupon_template == 'Template Six'):
					add_post_meta( $post_id, 'coupon_details_template-six-theme', $theme_color );
				elseif( $wpcd_coupon_data->default_coupon_template == 'Template Seven'):
					add_post_meta( $post_id, 'coupon_details_template-seven-theme', $theme_color );
				elseif( $wpcd_coupon_data->default_coupon_template == 'Template Eight'):
					add_post_meta( $post_id, 'coupon_details_template-eight-theme', $theme_color );
				endif;
				if ( $wpcd_coupon_data->category != '' && $wpcd_coupon_data->category != ' ' ) {
					wp_set_object_terms( $post_id, $wpcd_coupon_data->category, 'wpcd_coupon_category' );
				}
				if ( $wpcd_coupon_data->vendor != '' && $wpcd_coupon_data->vendor != ' ' ) {
					wp_set_object_terms( $post_id, $wpcd_coupon_data->vendor, 'wpcd_coupon_vendor' );
				}
			} else {
				wp_send_json($post_id->get_error_message() . __( ' | On Line Number1', 'wpcd-coupon' ) . $wpcd_coupon_data->coupon_count . '<br />');
			}

		} else {
			wp_send_json(__( 'Error | On Line Number 2', 'wpcd-coupon' ) . $wpcd_coupon_data->coupon_count . '<br />');
		}
        $wpcd_coupon_data->success = 'success';
		wp_send_json( $wpcd_coupon_data ); // sends all the data back to js
	}

} // End of wpcd_import_process_php
