<?php

class WPCD_Formshortcode_Coupons_Ajax extends WPCD_Ajax_Base {

	/**
	 * @inheritDoc
	 */
	public function logic() {
		if ( filter_var( $this->_c()->check_ajax_referer( 'wpcd_shortcode_form', 'nonce', false ),
			FILTER_VALIDATE_BOOLEAN ) ) {
			if ( isset( $_GET['coupons'] ) ) {
				$coupons_query = sanitize_text_field( $_GET['coupons'] );

				switch ( $coupons_query ) {
					case 'thrash':
						if ( isset( $_GET['coupon_id'] ) ) {
							$coupon_id = sanitize_text_field( $_GET['coupon_id'] );
							$this->thrash_a_coupon( $coupon_id );
						} else {
							$this->setError( __( 'Bad request, check request and try again',
								WPCD_Plugin::TEXT_DOMAIN ) );
						}
						break;
					case 'single':
						if ( isset( $_GET['coupon_id'] ) ) {
							$coupon_id = sanitize_text_field( $_GET['coupon_id'] );
							$this->get_a_coupon( $coupon_id );
						} else {
							$this->setError( __( 'Bad request, check request and try again',
								WPCD_Plugin::TEXT_DOMAIN ) );
						}
						break;
					default:
						$user_id = $this->_c()->wp_get_current_user()->ID;
						$this->get_all_user_coupons( $user_id );
						break;
				}
			}
		} else {
			$this->setError( __( 'You are not authorized to fetch coupons, refresh page and try again',
				WPCD_Plugin::TEXT_DOMAIN ) );

		}

		$this->getResponseJSON( true );
		die();
	}

	/**
	 * thrash current user's coupon
	 *
	 * @param int $coupon_id coupon id
	 */
	private function thrash_a_coupon( $coupon_id ) {
		$is_thrash_enabled = get_option( 'wpcd_form-shortcode-enable-thrash', '' ) === 'on';
		if ( $this->is_current_user_original_author( $coupon_id ) && $is_thrash_enabled ) {
			$result = $this->_c()->wp_delete_post( $coupon_id );
			if ( $result ) {
				$this->setData( 'message', __( 'Coupon deleted', WPCD_Plugin::TEXT_DOMAIN ) );
				$this->setData( 'id', $coupon_id );
			} else {
				$this->setError( __( 'An error occured, try again later', WPCD_Plugin::TEXT_DOMAIN ) );
			}
		} else {
			$this->setError( __( 'You are not authorized to fetch coupons, refresh page and try again',
				WPCD_Plugin::TEXT_DOMAIN ) );
		}
	}

	/**
	 * check if current user is the original author of the given post
	 *
	 * @param int $post_id post id
	 *
	 * @return bool current user is original author or not
	 */
	private function is_current_user_original_author( $post_id ) {
		$current_user = $this->_c()->wp_get_current_user()->ID;
		$post_author  = $this->_c()->get_post( $post_id )->post_author;

		return $current_user == $post_author;
	}

	/**
	 * fetch a single coupon
	 *
	 * @param int $coupon_id coupon post id
	 */
	private function get_a_coupon( $coupon_id ) {
		$coupon       = [];
		$coupon['ID'] = $coupon_id;

		if ( $this->is_current_user_original_author( $coupon_id ) ) {
			// coupon meta fetch
			$post_meta = $this->_c()->get_post_meta( $coupon_id );
			$coupon    = array_merge( $coupon, $post_meta );

			$post_meta_prefix = 'coupon_details_';
			foreach ( array_keys( $coupon ) as $key ) {
				if ( strpos( $key, $post_meta_prefix ) === 0 ) {
					$new_key            = str_replace( $post_meta_prefix, '', $key );
					$coupon[ $new_key ] = $coupon[ $key ][0];
					unset( $coupon[ $key ] );
				}
			}

			// coupon taxonomy fetch
			$custom_taxonomy = wp_get_post_terms( $coupon_id, WPCD_Plugin::CUSTOM_TAXONOMY );
			$vendor_taxonomy = wp_get_post_terms( $coupon_id, WPCD_Plugin::VENDOR_TAXONOMY );

			$coupon['terms'][ WPCD_Plugin::CUSTOM_TAXONOMY ] = $this->filter_tax( $custom_taxonomy, 'name' );
			$coupon['terms'][ WPCD_Plugin::VENDOR_TAXONOMY ] = $this->filter_tax( $vendor_taxonomy, 'name' );

			// coupon thumbnail url fetch
			$coupon['featured_url'] = $this->_c()->get_the_post_thumbnail_url( $coupon_id );

			// coupon attachment image url fetch
			$coupon_attachment_id         = $coupon['coupon-image-input'];
			$coupon['coupon-image-input-url'] = wp_get_attachment_image_url( $coupon_attachment_id );

			$coupon['wpcd_description'] = $coupon['description'];
			unset($coupon['description']);

			// setting coupon data
			$this->setData( 'data', $coupon );
		} else {
			$this->setError( __( 'You are not authorized to fetch this coupon', WPCD_Plugin::TEXT_DOMAIN ) );
		}
	}

	/**
	 * filter the taxonomy array so that only 'name' fields of the terms will be returned
	 *
	 * @param array $tax_array source array
	 * @param string $key key
	 *
	 * @return array filtered array
	 */
	private function filter_tax( $tax_array, $key ) {
		$temp_array = [];
		foreach ( $tax_array as $tax ) {

			$temp_array[] = $tax->$key;
		}

		return $temp_array;
	}

	/**
	 * ajax logic for getting all current users' coupons
	 *
	 * @param int $user_id current user id
	 */
	private function get_all_user_coupons( $user_id ) {
		global $wpdb;

		$query = $wpdb->prepare( "SELECT ID, post_status, post_title, 
       MAX(CASE WHEN (meta.meta_key= 'coupon_details_coupon-type') THEN meta.meta_value ELSE NULL END) as coupon_type ,
       MAX(CASE WHEN (meta.meta_key= 'coupon_details_coupon-title') THEN meta.meta_value ELSE NULL END) as coupon_title 
from $wpdb->posts as posts inner JOIN $wpdb->postmeta as meta  on posts.ID = meta.post_id where posts.post_type = %s and posts.post_status in ('publish', 'draft', 'pending') and meta.meta_key in ('coupon_details_coupon-type', 'coupon_details_coupon-title') and posts.post_author=%d group by posts.ID",
			WPCD_Plugin::CUSTOM_POST_TYPE, $user_id );

		$results = $wpdb->get_results( $query );

		foreach ( $results as $r ) {
			$terms = [];
			$terms['category']    = wp_get_post_terms( $r->ID, WPCD_Plugin::CUSTOM_TAXONOMY);
			$terms['vendor']    = wp_get_post_terms( $r->ID, WPCD_Plugin::VENDOR_TAXONOMY);
			$r->terms = $terms;
		}

		$this->setData( 'data', $results );
	}

}