<?php 
// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 

/**
 * This fetchs the coupon image from featured or category or dummy
 *
 * @since 2.3
 */
function wpcd_coupon_thumbnail_img( $coupon_id, $not_featured = false ) {
	$coupon = get_post( $coupon_id );
	$coupon_img = WPCD_Plugin::instance()->plugin_dir_uri . 'assets/img/coupon-200x200.png';
	
	if( ! $not_featured && $coupon && has_post_thumbnail( $coupon ) ) {
		return get_the_post_thumbnail_url( $coupon_id );
	}

	if ( $coupon ) {

		$featured_image_setting = get_option( 'wpcd_featured-image' );
		
		if ( $featured_image_setting == 'vendor' ) {
			$terms = get_the_terms( $coupon_id, 'wpcd_coupon_vendor' );
		} else {
			$terms = get_the_terms( $coupon_id, 'wpcd_coupon_category' );
		}		
		  
		$max_count = -1;
		
		if ( $terms && ! is_wp_error( $terms ) ) {
	    	foreach ( $terms as $term ) {
	    		if ( $max_count < $term->count ) {
	        		$max_count = $term->count;
	        		$term_meta = get_option( 'taxonomy_term_'.$term->term_id );
	        		if ( empty( $term_meta ) || empty( $term_meta['image_id'] ) )
	          			continue;
	        		else {
	          			$attachment = wp_get_attachment_image_src( $term_meta['image_id'], 'full' );
	          			if ( is_array( $attachment ) ) {
							$coupon_img = $attachment[0];
						}
	        		}
	      		}
	    	}
		}
		
	}

	return $coupon_img;

}