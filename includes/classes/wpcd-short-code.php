<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class builds the short code that
 * will be used to display coupon codes
 * on the front end.
 *
 * @since 1.0
 * @author Imtiaz Rayhan
 */
class WPCD_Short_Code {

	/**
	 * Class constructor.
	 * Adds the function to register the shortcode with WordPress.
	 *
	 * @since 1.0
	 */
	public static function init() {

		/**
		 * Shortcode register function.
		 *
		 * @since 1.0
		 */
		add_shortcode( 'wpcd_coupon', array( __CLASS__, 'wpcd_coupon' ) );
		add_shortcode( 'wpcd_code', array( __CLASS__, 'wpcd_coupon_code' ) );
		if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
			add_shortcode( 'wpcd_coupons', array( __CLASS__, 'wpcd_coupons_archive_func__premium_only' ) );
			add_shortcode( 'wpcd_coupons_loop', array( __CLASS__, 'wpcd_coupons_loop_func__premium_only' ) );
		}

	}

	/**
	 * Shortcode attributes and arguments to build the shortcode.
	 *
	 * @param $atts array shortcode attributes.
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	public static function wpcd_coupon( $atts ) {

		global $wpcd_atts;
		global $wpcd_coupon;

		/**
		 * These are the shortcode attributes.
		 *
		 * @since 1.0
		 */
		$wpcd_atts = shortcode_atts(
			array(
				'id'    => '',
				'total' => '-1',
			), $atts, 'wpcd_coupon'
		);

		/**
		 * Arguments to be used for a custom Query.
		 *
		 * @since 1.0
		 */
		$wpcd_arg = array(
			'p'              => esc_attr( $wpcd_atts['id'] ),
			'posts_per_page' => esc_attr( $wpcd_atts['total'] ),
			'post_type'      => 'wpcd_coupons',
			'post_status'    => 'publish',
		);

		/**
		 * New custom query to get post and post data
		 * from the custom coupon post type.
		 *
		 * @since 1.0
		 */
		$wpcd_coupon = new WP_Query( $wpcd_arg );
		$output      = '';

		//Hide expired coupon feature
		$today               = date( 'd-m-Y' );
		$hide_expired_coupon = get_option( 'wpcd_hide-expired-coupon' );

		while ( $wpcd_coupon->have_posts() ) {

			$wpcd_coupon->the_post();

			global $coupon_id;

			$template = new WPCD_Template_Loader();

			$coupon_id       = get_the_ID();
			$expire_date     = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
			$coupon_template = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
			$coupon_type     = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );

			if ( $coupon_type === 'Image' ) {
				ob_start();

				$template->get_template_part( 'shortcode-image' );

				$output = ob_get_clean();

				wp_reset_postdata();

				return $output;
			}

			// Hide expired coupon feature (default is Not to hide).
			if ( ! empty( $hide_expired_coupon ) || $hide_expired_coupon == "on" ) {
				$expire_date = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
				if ( ! empty( $expire_date ) ) {
					if ( $coupon_template !== 'Template Four' ) {
						if ( strtotime( $expire_date ) < strtotime( $today ) ) {
							continue;
						}
					} else {
						$second_expire_date = get_post_meta( $coupon_id, 'coupon_details_second-expire-date', true );
						$third_expire_date  = get_post_meta( $coupon_id, 'coupon_details_third-expire-date', true );
						if ( strtotime( $expire_date ) < strtotime( $today ) &&
							strtotime( $second_expire_date ) < strtotime( $today ) &&
							strtotime( $third_expire_date ) < strtotime( $today ) ) {
							continue;
						}
					}
				}
			}

			if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {

				if ( $coupon_template == 'Template One' ) {

					ob_start();

					$template->get_template_part( 'shortcode-one__premium_only' );

					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Two' ) {

					ob_start();

					$template->get_template_part( 'shortcode-two__premium_only' );

					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Three' ) {

					ob_start();

					$template->get_template_part( 'shortcode-three__premium_only' );

					// Return Variables.
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Four' ) {

					ob_start();

					$template->get_template_part( 'shortcode-four__premium_only' );

					// Return Variables.
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Five' ) {

					ob_start();

					$template->get_template_part( 'shortcode-five__premium_only' );

					// Return Variables.
					$output = ob_get_clean();

				} else if ( $coupon_template == 'Template Six' ) {

					ob_start();

					$template->get_template_part( 'shortcode-six__premium_only' );

					// Return Variables.
					$output = ob_get_clean();

				} else {

					ob_start();

					$template->get_template_part( 'shortcode-default' );

					$output = ob_get_clean();
				}
			} else {

				ob_start();

				$template->get_template_part( 'shortcode-default' );

				$output = ob_get_clean();

			}

		}

		wp_reset_postdata();

		return $output;

	}

	/**
	 * Builds the only coupon code shortcode.
	 *
	 * @param $atts
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	public static function wpcd_coupon_code( $atts ) {

		global $wpcd_code_atts;
		global $wpcd_coupon_code;

		/**
		 * These are the shortcode attributes.
		 *
		 * @since 1.4
		 */
		$wpcd_code_atts = shortcode_atts(
			array(
				'id'    => '',
				'total' => '-1'
			), $atts, 'wpcd_code'
		);

		/**
		 * Arguments to be used for a custom Query.
		 *
		 * @since 1.4
		 */
		$wpcd_code_arg = array(
			'p'              => esc_attr( $wpcd_code_atts['id'] ),
			'posts_per_page' => esc_attr( $wpcd_code_atts['total'] ),
			'post_type'      => 'wpcd_coupons',
			'post_status'    => 'publish',
		);

		/**
		 * New custom query to get post and post data
		 * from the custom coupon post type.
		 *
		 * @since 1.4
		 */
		$wpcd_coupon_code = new WP_Query( $wpcd_code_arg );

		$template = new WPCD_Template_Loader();

		ob_start();

		$template->get_template_part( 'shortcode-code' );

		// Return Variables
		return ob_get_clean();

	}

	/**
	 * Shortcode for the coupon archive page.
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function wpcd_coupons_archive_func__premium_only( $atts ) {

		wp_enqueue_script( 'wpcd-main-js' );

		$a = shortcode_atts( array(
			'count' => '9',
			'temp'  => ''
		), $atts );

		$output = "";

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		if ( isset( $_GET['wpcd_category'] ) && $_GET['wpcd_category'] != '' ) {
			$args = array(
				'post_type'      => 'wpcd_coupons',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'tax_query'      => array(
					array(
						'taxonomy' => 'wpcd_coupon_category',
						'field'    => 'slug',
						'terms'    => $_GET['wpcd_category'],
					),
				),
				'paged'          => $paged
			);
		} else {
			$args = array(
				'post_type'      => 'wpcd_coupons',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'paged'          => $paged
			);
		}

		if ( empty( $a['temp'] ) ) {
			$args['meta_query'] = array(
				array(
					'key'     => 'coupon_details_coupon-type',
					'value'   => 'Image',
					'compare' => '!='
				)
			);
		}

		// exclude expired coupons if hide expired coupon setting is enabled.
		$expired_coupons = array();
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			$today               = date( 'd-m-Y' );
			$hide_expired_coupon = get_option( 'wpcd_hide-expired-coupon' );

			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $coupon_id;
				$coupon_id               = get_the_ID();
				$expire_date             = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
				$current_coupon_template = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
				$coupon_type             = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );	

				if ( ! empty( $hide_expired_coupon ) || $hide_expired_coupon == "on" ) {
					$expire_date = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
					if ( ! empty( $expire_date ) ) {
						if ( $current_coupon_template !== 'Template Four' ) {
							if ( strtotime( $expire_date ) < strtotime( $today ) ) {
								array_push( $expired_coupons, $coupon_id );
								continue;
							}
						} else {
							$second_expire_date = get_post_meta( $coupon_id, 'coupon_details_second-expire-date', true );
							$third_expire_date  = get_post_meta( $coupon_id, 'coupon_details_third-expire-date', true );
							if ( strtotime( $expire_date ) < strtotime( $today ) &&
								strtotime( $second_expire_date ) < strtotime( $today ) &&
								strtotime( $third_expire_date ) < strtotime( $today ) ) {
								array_push( $expired_coupons, $coupon_id );
								continue;
							}
						}
					}
				}
			}
			wp_reset_postdata();
		}

		if ( count( $expired_coupons ) > 0 ) {
			$args['post__not_in'] = $expired_coupons;
		}
		$the_query = new WP_Query( $args );
		
		if ( $the_query->have_posts() ) :

			/**
			 * $parent -> print the header and footer of the parent element
			 * $max_num_page -> used in pagination
			 * $coupon_template -> the name of template
			 * $num_posts -> number of posts
			 * $current_url -> return the Url of the current post
			 */
			global $parent, $max_num_page, $current_url;
			$num_posts    = $the_query->post_count;
			$i            = 1;
			$max_num_page = $the_query->max_num_pages;
			$current_url  = get_permalink();

			// template system.
			$temp = $a['temp'];
			if ( $temp === '' ) { 
				// vertical style.
				$coupon_template = 'shortcode-archive__premium_only';
			} else {
				$coupon_template = 'shortcode-archive-default__premium_only';
			}

			// the loop.
			while ( $the_query->have_posts() ) : $the_query->the_post();
				global $coupon_id;
				$coupon_id = get_the_ID();
				$parent = "";

				// check to print header or footer.
				if ( $i == 1 && $num_posts !==1 ) {
					$parent = 'header';
                                } elseif ($num_posts ==1){
                                    // means there's only one coupon 
                                    // So, it should print the header and footer in this time
                                    $parent = 'headerANDfooter';
                                } elseif ( $i == $num_posts ) {
					$parent = 'footer';
				}

				$template  = new WPCD_Template_Loader();
				ob_start();
				$template->get_template_part( $coupon_template );
				$output .= ob_get_clean();
				$i ++;
			endwhile;
			// end of the loop.
			wp_reset_postdata();
		else :
			$output .= '<p>' . __( 'Sorry, no coupons/deals found.', 'wpcd-coupon' ) . '</p>';
		endif;

		return $output;

	}

	/**
	 * Coupon loop shortcode to specific posts or posts from a category.
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function wpcd_coupons_loop_func__premium_only( $atts ) {

		wp_enqueue_script( 'wpcd-main-js' );
		$a = shortcode_atts( array(
			'count' => 9,
			'id'    => '',
			'cat'   => '',
			'temp'  => ''
		), $atts );

		global $args;
		$output = "";

		$id  = $a['id'];
		$cat = $a['cat'];

		//template system
		$temp = $a['temp'];
		if ( $temp == '' ) { // vertical style
			$coupon_template = 'shortcode-category__premium_only';
		} else {
			$coupon_template = 'shortcode-category-default__premium_only';
		}

		if ( $cat ) {
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args  = array(
				'post_type'      => 'wpcd_coupons',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'tax_query'      => array(
					array(
						'taxonomy' => 'wpcd_coupon_category',
						'field'    => 'term_id',
						'terms'    => $cat,
					),
				),
				'paged'          => $paged
			);
		} else {
			if ( $id ) {
				$posts_in = array_map( 'intval', explode( ',', $id ) );
				$args     = array(
					'post_type'   => 'wpcd_coupons',
					'post_status' => 'publish',
					'post__in'    => $posts_in
				);
			}
		}

		if ( empty( $temp ) ) {
			$args['meta_query'] = array(
				array(
					'key'     => 'coupon_details_coupon-type',
					'value'   => 'Image',
					'compare' => '!='
				)
			);
		}

		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) :

			/**
			 * $parent -> print the header and footer of the parent element
			 * $max_num_page -> used in pagination
			 * $coupon_template -> the name of template
			 * $num_posts -> number of posts
			 */
			global $parent, $max_num_page;
			$max_num_page = $the_query->max_num_pages;
			$num_posts    = $the_query->post_count;
			$i            = 1;

			//Hide expired coupon feature
			$today               = date( 'd-m-Y' );
			$hide_expired_coupon = get_option( 'wpcd_hide-expired-coupon' );

			while ( $the_query->have_posts() ) : $the_query->the_post();
				global $coupon_id;
				$parent = "";

				// check to print header or footer.
				if ( $i == 1 && $num_posts !==1 ) {
					$parent = 'header';
                } elseif ( $num_posts == 1 ){
                    $parent = 'headerANDfooter';
                } elseif ( $i == $num_posts ) {
					$parent = 'footer';
				}

				$template  = new WPCD_Template_Loader();
				$coupon_id = get_the_ID();

				//Hide expired coupon feature (default is Not to hide)
				if ( ! empty( $hide_expired_coupon ) || $hide_expired_coupon == "on" ) {
					$expire_date = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
					if ( ! empty( $expire_date ) ) {
						if ( strtotime( $expire_date ) < strtotime( $today ) ) {
							continue;
						}
					}
				}

				ob_start();
				$template->get_template_part( $coupon_template );
				$output .= ob_get_clean();

				$i ++;

			endwhile;
			// end of the loop
			wp_reset_postdata();
		else :
			$output .= '<p>' . __( 'Sorry, no coupons/deals found.', 'wpcd-coupon' ) . '</p>';
		endif;

		return $output;

	}

}