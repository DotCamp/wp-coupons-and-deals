<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Statistics Tracker Class
 * 
 * Centralizes all coupon statistics tracking
 * Handles view counts, click counts, and other metrics
 *
 * @since 3.3.0
 */
class WPCD_Statistics_Tracker {

	/**
	 * Meta key constants
	 */
	const META_VIEW_COUNT = 'coupon_view_count';
	const META_CLICK_COUNT = 'coupon_click_count';

	/**
	 * Track a coupon view
	 *
	 * @param int $coupon_id The coupon ID
	 * @return int|false The new view count or false if stats disabled
	 */
	public static function track_view( $coupon_id ) {
		// Check if statistics are enabled
		if ( ! WPCD_Settings_Manager::is_enabled( 'wpcd_enable-stats-count' ) ) {
			return false;
		}

		// Validate coupon ID
		if ( ! self::is_valid_coupon( $coupon_id ) ) {
			return false;
		}

		// Get current count
		$current_count = self::get_view_count( $coupon_id );

		// Increment count
		$new_count = $current_count + 1;

		// Update meta
		update_post_meta( $coupon_id, self::META_VIEW_COUNT, $new_count );

		// Allow hooks for tracking
		do_action( 'wpcd_coupon_view_tracked', $coupon_id, $new_count );

		return $new_count;
	}

	/**
	 * Track a coupon click
	 *
	 * @param int $coupon_id The coupon ID
	 * @return int|false The new click count or false if invalid
	 */
	public static function track_click( $coupon_id ) {
		// Validate coupon ID
		if ( ! self::is_valid_coupon( $coupon_id ) ) {
			return false;
		}

		// Get current count
		$current_count = self::get_click_count( $coupon_id );

		// Increment count
		$new_count = $current_count + 1;

		// Update meta
		update_post_meta( $coupon_id, self::META_CLICK_COUNT, $new_count );

		// Allow hooks for tracking
		do_action( 'wpcd_coupon_click_tracked', $coupon_id, $new_count );

		return $new_count;
	}

	/**
	 * Get view count for a coupon
	 *
	 * @param int $coupon_id The coupon ID
	 * @return int The view count
	 */
	public static function get_view_count( $coupon_id ) {
		$count = get_post_meta( $coupon_id, self::META_VIEW_COUNT, true );
		
		// Ensure we return a valid integer
		return empty( $count ) || ! is_numeric( $count ) ? 0 : intval( $count );
	}

	/**
	 * Get click count for a coupon
	 *
	 * @param int $coupon_id The coupon ID
	 * @return int The click count
	 */
	public static function get_click_count( $coupon_id ) {
		$count = get_post_meta( $coupon_id, self::META_CLICK_COUNT, true );
		
		// Ensure we return a valid integer
		return empty( $count ) || ! is_numeric( $count ) ? 0 : intval( $count );
	}

	/**
	 * Get all statistics for a coupon
	 *
	 * @param int $coupon_id The coupon ID
	 * @return array Statistics array
	 */
	public static function get_statistics( $coupon_id ) {
		return array(
			'views' => self::get_view_count( $coupon_id ),
			'clicks' => self::get_click_count( $coupon_id ),
			'ctr' => self::calculate_ctr( $coupon_id )
		);
	}

	/**
	 * Calculate click-through rate for a coupon
	 *
	 * @param int $coupon_id The coupon ID
	 * @return float CTR percentage
	 */
	public static function calculate_ctr( $coupon_id ) {
		$views = self::get_view_count( $coupon_id );
		$clicks = self::get_click_count( $coupon_id );

		if ( $views === 0 ) {
			return 0.0;
		}

		return round( ( $clicks / $views ) * 100, 2 );
	}

	/**
	 * Reset statistics for a coupon
	 *
	 * @param int $coupon_id The coupon ID
	 * @param string $type Type of stats to reset ('views', 'clicks', or 'all')
	 * @return bool Success status
	 */
	public static function reset_statistics( $coupon_id, $type = 'all' ) {
		if ( ! self::is_valid_coupon( $coupon_id ) ) {
			return false;
		}

		switch ( $type ) {
			case 'views':
				delete_post_meta( $coupon_id, self::META_VIEW_COUNT );
				break;
			
			case 'clicks':
				delete_post_meta( $coupon_id, self::META_CLICK_COUNT );
				break;
			
			case 'all':
			default:
				delete_post_meta( $coupon_id, self::META_VIEW_COUNT );
				delete_post_meta( $coupon_id, self::META_CLICK_COUNT );
				break;
		}

		do_action( 'wpcd_statistics_reset', $coupon_id, $type );

		return true;
	}

	/**
	 * Get top performing coupons
	 *
	 * @param string $metric The metric to sort by ('views', 'clicks', 'ctr')
	 * @param int $limit Number of coupons to return
	 * @return array Array of coupon IDs and their metrics
	 */
	public static function get_top_coupons( $metric = 'views', $limit = 10 ) {
		global $wpdb;

		$meta_key = $metric === 'clicks' ? self::META_CLICK_COUNT : self::META_VIEW_COUNT;

		$results = $wpdb->get_results( $wpdb->prepare(
			"SELECT p.ID, pm.meta_value as count 
			FROM {$wpdb->posts} p
			INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
			WHERE p.post_type = %s 
			AND p.post_status = 'publish'
			AND pm.meta_key = %s
			ORDER BY CAST(pm.meta_value AS UNSIGNED) DESC
			LIMIT %d",
			WPCD_Plugin::CUSTOM_POST_TYPE,
			$meta_key,
			$limit
		) );

		$coupons = array();
		
		foreach ( $results as $result ) {
			$coupon_data = array(
				'id' => $result->ID,
				'title' => get_the_title( $result->ID ),
				$metric => intval( $result->count )
			);

			// Add CTR if sorting by it
			if ( $metric === 'ctr' ) {
				$coupon_data['ctr'] = self::calculate_ctr( $result->ID );
				$coupon_data['views'] = self::get_view_count( $result->ID );
				$coupon_data['clicks'] = self::get_click_count( $result->ID );
			}

			$coupons[] = $coupon_data;
		}

		// Sort by CTR if needed
		if ( $metric === 'ctr' ) {
			usort( $coupons, function( $a, $b ) {
				return $b['ctr'] <=> $a['ctr'];
			} );
			$coupons = array_slice( $coupons, 0, $limit );
		}

		return $coupons;
	}

	/**
	 * Validate if a post is a valid coupon
	 *
	 * @param int $coupon_id The post ID
	 * @return bool True if valid coupon
	 */
	private static function is_valid_coupon( $coupon_id ) {
		if ( ! is_numeric( $coupon_id ) ) {
			return false;
		}

		$post = get_post( $coupon_id );
		
		return $post && $post->post_type === WPCD_Plugin::CUSTOM_POST_TYPE;
	}

	/**
	 * AJAX handler for tracking clicks
	 */
	public static function ajax_track_click() {
		// Verify nonce
		if ( ! check_ajax_referer( 'wpcd-security-nonce', 'security', false ) ) {
			wp_send_json_error( 'Invalid security token' );
		}

		// Get and validate coupon ID
		$coupon_id = isset( $_POST['coupon_id'] ) ? intval( $_POST['coupon_id'] ) : 0;

		if ( ! $coupon_id ) {
			wp_send_json_error( 'Invalid coupon ID' );
		}

		// Track the click
		$new_count = self::track_click( $coupon_id );

		if ( $new_count === false ) {
			wp_send_json_error( 'Failed to track click' );
		}

		wp_send_json_success( array(
			'message' => 'Click tracked successfully',
			'click_count' => $new_count
		) );
	}

	/**
	 * Initialize AJAX handlers
	 */
	public static function init() {
		add_action( 'wp_ajax_wpcd_track_click', array( __CLASS__, 'ajax_track_click' ) );
		add_action( 'wp_ajax_nopriv_wpcd_track_click', array( __CLASS__, 'ajax_track_click' ) );
	}
}