<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Query Builder Class
 * 
 * Handles building WP_Query arguments for coupons
 * Reduces code duplication in query building
 *
 * @since 3.3.0
 */
class WPCD_Query_Builder {

	/**
	 * Build base query args
	 *
	 * @param array $params Query parameters
	 * @return array Query args
	 */
	public static function build_base_args( $params = array() ) {
		$defaults = array(
			'post_type'      => WPCD_Plugin::CUSTOM_POST_TYPE,
			'post_status'    => 'publish',
			'order'          => 'DESC',
			'posts_per_page' => 9,
			'paged'          => 1
		);

		return wp_parse_args( $params, $defaults );
	}

	/**
	 * Add taxonomy query
	 *
	 * @param array $args Existing query args
	 * @param string $taxonomy Taxonomy name
	 * @param mixed $terms Term(s)
	 * @param string $field Field to query by
	 * @return array Modified args
	 */
	public static function add_taxonomy_query( $args, $taxonomy, $terms, $field = 'slug' ) {
		if ( empty( $terms ) || $terms === 'all' ) {
			return $args;
		}

		if ( ! isset( $args['tax_query'] ) ) {
			$args['tax_query'] = array();
		}

		$args['tax_query'][] = array(
			'taxonomy' => $taxonomy,
			'field'    => $field,
			'terms'    => $terms,
		);

		return $args;
	}

	/**
	 * Add search query
	 *
	 * @param array $args Existing query args
	 * @param string $search_term Search term
	 * @return array Modified args
	 */
	public static function add_search_query( $args, $search_term ) {
		if ( ! empty( $search_term ) ) {
			$args['s'] = $search_term;
		}
		return $args;
	}

	/**
	 * Add sorting options
	 *
	 * @param array $args Existing query args
	 * @param string $sortby Sort option
	 * @return array Modified args
	 */
	public static function add_sorting( $args, $sortby ) {
		switch ( $sortby ) {
			case 'oldest':
				$args['order'] = 'ASC';
				break;
			
			case 'expired-first':
				$args['order'] = 'ASC';
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'coupon_details_expire-date';
				break;
			
			case 'expired-last':
				$args['order'] = 'DESC';
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'coupon_details_expire-date';
				break;
			
			default:
				// 'newest' is default, already set in base args
				break;
		}

		return $args;
	}

	/**
	 * Add meta query to exclude image coupons
	 *
	 * @param array $args Existing query args
	 * @param bool $include Whether to include image coupons
	 * @return array Modified args
	 */
	public static function add_image_coupon_filter( $args, $include = false ) {
		$compare = $include ? '=' : '!=';

		if ( ! isset( $args['meta_query'] ) ) {
			$args['meta_query'] = array();
		}

		$args['meta_query'][] = array(
			'key'     => 'coupon_details_coupon-type',
			'value'   => 'Image',
			'compare' => $compare
		);

		return $args;
	}

	/**
	 * Add expired coupon filter
	 *
	 * @param array $args Existing query args
	 * @return array Modified args
	 */
	public static function add_expired_filter( $args ) {
		if ( ! WPCD_Settings_Manager::is_enabled( 'wpcd_hide-expired-coupon' ) ) {
			return $args;
		}

		$today = strtotime( date( 'd-m-Y' ) );

		$expired_query = array(
			'relation' => 'OR',
			array(
				'key'     => 'coupon_details_expire-date',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'coupon_details_expire-date',
				'value'   => '',
				'compare' => '='
			),
			array(
				'key'     => 'coupon_details_expire-date',
				'value'   => $today,
				'compare' => '>',
				'type'    => 'numeric'
			)
		);

		if ( ! isset( $args['meta_query'] ) ) {
			$args['meta_query'] = $expired_query;
		} else {
			// Ensure relation is set
			if ( ! isset( $args['meta_query']['relation'] ) ) {
				$args['meta_query'] = array_merge( array( 'relation' => 'AND' ), $args['meta_query'] );
			}
			$args['meta_query'][] = $expired_query;
		}

		return $args;
	}

	/**
	 * Add exclude categories filter
	 *
	 * @param array $args Existing query args
	 * @param string $exclude Comma-separated term IDs to exclude
	 * @return array Modified args
	 */
	public static function add_exclude_categories( $args, $exclude ) {
		if ( empty( $exclude ) ) {
			return $args;
		}

		$exclude_arr = explode( ',', $exclude );
		$exclude_categories = array();

		foreach ( $exclude_arr as $item ) {
			if ( is_numeric( $item ) ) {
				$term = get_term( $item );
				if ( $term && ! is_wp_error( $term ) ) {
					if ( ! isset( $exclude_categories[ $term->taxonomy ] ) ) {
						$exclude_categories[ $term->taxonomy ] = array();
					}
					$exclude_categories[ $term->taxonomy ][] = intval( $item );
				}
			}
		}

		if ( empty( $exclude_categories ) ) {
			return $args;
		}

		if ( ! isset( $args['tax_query'] ) ) {
			$args['tax_query'] = array();
		}

		// Ensure relation is set
		if ( ! empty( $args['tax_query'] ) && ! isset( $args['tax_query']['relation'] ) ) {
			$args['tax_query'] = array_merge( array( 'relation' => 'AND' ), $args['tax_query'] );
		}

		foreach ( $exclude_categories as $taxonomy_name => $term_ids ) {
			$args['tax_query'][] = array(
				'taxonomy' => $taxonomy_name,
				'field'    => 'term_id',
				'terms'    => $term_ids,
				'operator' => 'NOT IN',
			);
		}

		return $args;
	}

	/**
	 * Build query for specific post IDs
	 *
	 * @param array $args Existing query args
	 * @param string $ids Comma-separated post IDs
	 * @return array Modified args
	 */
	public static function add_post_ids_filter( $args, $ids ) {
		if ( empty( $ids ) ) {
			return $args;
		}

		$post_ids = array_map( 'intval', explode( ',', $ids ) );
		$args['post__in'] = $post_ids;

		// Remove posts_per_page when using specific IDs
		unset( $args['posts_per_page'] );

		return $args;
	}

	/**
	 * Build complete query args from parameters
	 *
	 * @param array $params Parameters including count, sortby, exclude, etc.
	 * @param int $paged Page number
	 * @param string $taxonomy_term Taxonomy term to filter by
	 * @param string $taxonomy_name Taxonomy name
	 * @param string $search_term Search term
	 * @return array Complete query args
	 */
	public static function build_complete_query( $params, $paged = 1, $taxonomy_term = '', $taxonomy_name = '', $search_term = '' ) {
		// Start with base args
		$args = self::build_base_args( array(
			'posts_per_page' => isset( $params['count'] ) ? $params['count'] : 9,
			'paged'          => $paged
		) );

		// Add taxonomy filter
		if ( ! empty( $taxonomy_term ) && ! empty( $taxonomy_name ) ) {
			$args = self::add_taxonomy_query( $args, $taxonomy_name, $taxonomy_term );
		}

		// Add search
		if ( ! empty( $search_term ) ) {
			$args = self::add_search_query( $args, $search_term );
		}

		// Add sorting
		if ( isset( $params['sortby'] ) ) {
			$args = self::add_sorting( $args, $params['sortby'] );
		}

		// Add image filter if no template specified
		if ( empty( $params['temp'] ) ) {
			$args = self::add_image_coupon_filter( $args, false );
		}

		// Add expired filter
		$args = self::add_expired_filter( $args );

		// Add exclude categories
		if ( isset( $params['exclude'] ) ) {
			$args = self::add_exclude_categories( $args, $params['exclude'] );
		}

		return $args;
	}
}