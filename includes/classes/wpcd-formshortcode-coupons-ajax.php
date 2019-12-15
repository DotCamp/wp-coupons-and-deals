<?php

class WPCD_Formshortcode_Coupons_Ajax extends WPCD_Ajax_Base {

	/**
	 * @inheritDoc
	 */
	public function logic() {
		global $wpdb;

		$current_user_ID = ( $this->_c()-> wp_get_current_user() )->ID;

		$query = $wpdb->prepare( "SELECT ID, post_status, post_title, 
       MAX(CASE WHEN (meta.meta_key= 'coupon_details_coupon-type') THEN meta.meta_value ELSE NULL END) as coupon_type ,
       MAX(CASE WHEN (meta.meta_key= 'coupon_details_coupon-title') THEN meta.meta_value ELSE NULL END) as coupon_title 
from $wpdb->posts as posts inner JOIN $wpdb->postmeta as meta  on posts.ID = meta.post_id where posts.post_type = %s and posts.post_status in ('publish', 'draft', 'pending') and meta.meta_key in ('coupon_details_coupon-type', 'coupon_details_coupon-title') and posts.post_author=%d group by posts.ID",
			WPCD_Plugin::CUSTOM_POST_TYPE, $current_user_ID );

		$results = $wpdb->get_results( $query );

		echo json_encode( $results );

		die();
	}
}