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

			add_action( 'wp_ajax_wpcd_coupons_category_action', array( __CLASS__, 'wpcd_coupons_archive_func__premium_only' ) );
        	add_action( 'wp_ajax_nopriv_wpcd_coupons_category_action', array( __CLASS__, 'wpcd_coupons_archive_func__premium_only' ) );

			add_action( 'wp_ajax_wpcd_coupons_cat_vend_action', array( __CLASS__, 'wpcd_coupons_loop_func__premium_only' ) );
        	add_action( 'wp_ajax_nopriv_wpcd_coupons_cat_vend_action', array( __CLASS__, 'wpcd_coupons_loop_func__premium_only' ) );
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
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Four' ) {

					ob_start();
					$template->get_template_part( 'shortcode-four__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Five' ) {

					ob_start();
					$template->get_template_part( 'shortcode-five__premium_only' );
					$output = ob_get_clean();

				} else if ( $coupon_template == 'Template Six' ) {

					ob_start();
					$template->get_template_part( 'shortcode-six__premium_only' );
					$output = ob_get_clean();

				} else if ( $coupon_template == 'Template Seven' ) {
					 
					ob_start();
					$template->get_template_part( 'shortcode-seven__premium_only' );
 					$output = ob_get_clean();
 					
 				} else if ( $coupon_template == 'Template Eight' ) {

					ob_start();
					$template->get_template_part( 'shortcode-eight__premium_only' );
					$output = ob_get_clean();

				}  else {

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
		$output = "";
		$paged = 1;
		$wpcd_data_category = 'all';
		$wpcd_amp_page_indicate = false;
		$a = array();
		if ( !isset($_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ) {

			wp_enqueue_script( 'wpcd-main-js' );
			$a = shortcode_atts( array(
				'count' => '9',
				'temp'  => ''
			), $atts );
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		} 

			
		if ( isset( $_POST['coupon_template'] ) && !empty( $_POST['coupon_template'] ) ) {
			$a['temp'] = sanitize_text_field( $_POST['coupon_template'] );
		} 

		if ( isset( $_POST['coupon_items_count'] ) && !empty( $_POST['coupon_items_count'] ) ) {
			$a['count'] = sanitize_text_field( $_POST['coupon_items_count'] );
		}

		if ( isset( $_POST['page_num'] ) && !empty( $_POST['page_num'] ) ) {
			$paged = (int)( $_POST['page_num'] );
		} elseif( isset( $_GET['wpcd_amp_p_num'] ) && !empty( $_GET['wpcd_amp_p_num'] ) ) {
			$paged = (int)( $_GET['wpcd_amp_p_num'] );
		}

		if ( isset( $_POST['wpcd_category'] ) && !empty( $_POST['wpcd_category'] ) ) {
			$wpcd_data_category = sanitize_text_field( $_POST['wpcd_category'] );
		} elseif ( isset( $_GET['wpcd_category'] ) && !empty( $_GET['wpcd_category'] ) ) {
			$wpcd_data_category = sanitize_text_field( $_GET['wpcd_category'] );
		}
			
		

		if ( isset( $wpcd_data_category ) && $wpcd_data_category != 'all' &&  $wpcd_data_category != '' && ( ! isset($_POST['search_text']) || empty($_POST['search_text']) ) ) {
			$args = array(
				'post_type'      => 'wpcd_coupons',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'tax_query'      => array(
					array(
						'taxonomy' => 'wpcd_coupon_category',
						'field'    => 'slug',
						'terms'    => $wpcd_data_category,
					),
				),
				'paged'          => $paged
			);
		} elseif ( isset( $_POST['search_text']) && !empty( $_POST['search_text'] ) ) {
			$search_text = $_POST['search_text'] ;
			$args = array(
				'post_type'		 => 'wpcd_coupons',
				'order'			 => 'DESC',
				'posts_per_page' => $a['count'],
				'paged'			 => $paged,
				's'				 => $search_text,
			);
		} else {
			$args = array(
				'post_type'      => 'wpcd_coupons',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'paged'          => $paged,
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

			$argcss = array();
			if ( $temp == '' ) { // vertical style.
            	$argcss = 'not_temp';
            	$coupon_template = 'shortcode-archive__premium_only';
			} else {
                switch ($temp) {
                    case 'one':
                    	$argcss = 'one';
                    	$coupon_template = 'shortcode-archive-one__premium_only';
                        break;
                    case 'two':
                    	$argcss = 'two';
                        $coupon_template = 'shortcode-archive-two__premium_only';
                        break;
                    case 'three':
                    	$argcss = 'three';
                        $coupon_template = 'shortcode-archive-three__premium_only';
                        break;
                    case 'seven':
                    	$argcss = 'seven';
                        $coupon_template = 'shortcode-archive-seven__premium_only';
                        break;
                    case 'eight':
                    	$argcss = 'eight';
                        $coupon_template = 'shortcode-archive-eight__premium_only';
                        break;
                    default :
                    	$argcss = 'default';
                        $coupon_template = 'shortcode-archive-default__premium_only';
                        break;
                }
			}
			if ( WPCD_Amp::wpcd_amp_is() ) {
				WPCD_Amp::instance()->setCss( 'common' );
        		WPCD_Amp::instance()->setCss( $argcss );
			}
				
			if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ) {
				global $post;
				$wpcd_data_coupon_page_url = get_page_link( $post->ID );
				$output = '<div id="wpcd_coupon_template" wpcd-data-coupon_template="'.$temp.'" wpcd-data-coupon_items_count="'.$a["count"].'" wpcd-data-coupon_page_url="'.$wpcd_data_coupon_page_url.'" wpcd-data_category="'.$wpcd_data_category.'"></div>';
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

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'wpcd_coupons_category_action' ) {
			echo json_encode( $output );
			die();
		}
		
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
            'vend'  => '',
			'temp'  => ''
		), $atts );

		global $args;
		$output = "";

		$id  = $a['id'];
		$cat = $a['cat'];
        $vend = $a['vend'];

		//template system
		$temp = $a['temp'];


		$paged = 1;
		if ( isset( $_POST['page_num'] ) && !empty( $_POST['page_num'] ) ) {
			$paged = (int)( $_POST['page_num'] );
		} elseif ( isset( $_GET['wpcd_amp_p_num'] ) && !empty( $_GET['wpcd_amp_p_num'] ) ) {
			$paged = (int)( $_GET['wpcd_amp_p_num'] );
		}

		if ( isset( $_POST['coupon_template'] ) && !empty( $_POST['coupon_template'] ) ) {
			$temp = sanitize_text_field( $_POST['coupon_template'] );
		} 

		if ( isset( $_POST['wpcd_data_category_coupons'] ) && !empty( $_POST['wpcd_data_category_coupons'] ) ) {
			$cat = sanitize_text_field( $_POST['wpcd_data_category_coupons'] );
		} 

		if ( isset( $_POST['wpcd_data_vendor_coupons'] ) && !empty( $_POST['wpcd_data_vendor_coupons'] ) ) {
			$vend = sanitize_text_field( $_POST['wpcd_data_vendor_coupons'] );
		} 

		if ( $temp == '' ) { // vertical style
        	$argcss = 'not_temp';
			$coupon_template = 'shortcode-category__premium_only';
		} else {  
			switch ($temp) {
				case 'one':
					$argcss = 'one';
					$coupon_template = 'shortcode-category-one__premium_only';
					break;
                case 'two':
                	$argcss = 'two';
                    $coupon_template = 'shortcode-category-two__premium_only';
                    break;
                case 'three':
                	$argcss = 'three';
                    $coupon_template = 'shortcode-category-three__premium_only';
                    break;
                case 'seven':
                    $argcss = 'seven';
                    $coupon_template = 'shortcode-category-seven__premium_only';
                    break;
                case 'eight':
                    $argcss = 'eight';
                    $coupon_template = 'shortcode-category-eight__premium_only';
                    break;
				default :
                    $argcss = 'default';
					$coupon_template = 'shortcode-category-default__premium_only';		
					break;						
			}
		}
		if ( WPCD_Amp::wpcd_amp_is() ) {
			WPCD_Amp::instance()->setCss( 'common' );
    		WPCD_Amp::instance()->setCss( $argcss );
    	}

		if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ) {
			global $post;
			$wpcd_data_coupon_page_url = get_page_link( $post->ID );
			$output = '<div id="wpcd_coupon_template" wpcd-data-coupon_template="'.$temp.'" wpcd-data-coupon_items_count="'.$a["count"].'" wpcd-data-coupon_page_url="'.$wpcd_data_coupon_page_url.'" wpcd-data_category_coupons="'.$cat.'" wpcd-data_vendor_coupons="'.$vend.'"></div>';
		}
                
		if ( $cat || $vend) {
			$args  = array(
				'post_type'      => 'wpcd_coupons',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'tax_query'      => array(
					array(
						'taxonomy' => ($cat) ? 'wpcd_coupon_category' : 'wpcd_coupon_vendor',
						'field'    => 'term_id',
						'terms'    => ($cat) ? $cat : $vend,
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

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'wpcd_coupons_cat_vend_action' ) {
			echo json_encode( $output );
			die();
		}

		return $output;

	}

}