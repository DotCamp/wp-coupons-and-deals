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

			add_action( 'wp_ajax_wpcd_coupons_category_action',
				array( __CLASS__, 'wpcd_coupons_archive_func__premium_only' ) );
			add_action( 'wp_ajax_nopriv_wpcd_coupons_category_action',
				array( __CLASS__, 'wpcd_coupons_archive_func__premium_only' ) );

			add_action( 'wp_ajax_wpcd_coupons_cat_vend_action',
				array( __CLASS__, 'wpcd_coupons_loop_func__premium_only' ) );
			add_action( 'wp_ajax_nopriv_wpcd_coupons_cat_vend_action',
				array( __CLASS__, 'wpcd_coupons_loop_func__premium_only' ) );

			add_action( 'wp_ajax_wpcd_coupon_clicked_action',
				array( __CLASS__, 'wpcd_coupon_clicked_action_func__premium_only' ) );
			add_action( 'wp_ajax_nopriv_wpcd_coupon_clicked_action',
				array( __CLASS__, 'wpcd_coupon_clicked_action_func__premium_only' ) );
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

		$enable_stats = get_option('wpcd_enable-stats-count');

		while ( $wpcd_coupon->have_posts() ) {

			$wpcd_coupon->the_post();

			global $coupon_id;

			$template = new WPCD_Template_Loader();

			$coupon_id       = get_the_ID();
			$expire_date     = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
			$coupon_template = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
			$coupon_type     = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );

			if (! empty( $enable_stats ) && $enable_stats == 'on') {
				$view_count = get_post_meta( $coupon_id, 'coupon_view_count', true );
				if (empty($view_count) || !is_numeric($view_count)) {
					$view_count = 1;
				} else {
					$view_count = intval($view_count) + 1;
				}
				update_post_meta($coupon_id, 'coupon_view_count', $view_count);
			}

			if ( $coupon_type === 'Image' ) {

				ob_start();

				$template->get_template_part( 'shortcode-image' );

				$output = ob_get_clean();

				if ( WPCD_Amp::wpcd_amp_is() ) {
					WPCD_Amp::instance()->setCss( 'shortcode_image' );
				}

				wp_reset_postdata();

				return $output;

			}

			// Hide expired coupon feature (default is Not to hide).
			if ( ! empty( $hide_expired_coupon ) || $hide_expired_coupon == "on" ) {
				$expire_date = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
				if ( ! empty( $expire_date ) ) {
					if ( (string) (int) $expire_date != $expire_date ) {
						$expire_date = strtotime( $expire_date );
					}
					if ( $coupon_template !== 'Template Four' ) {
						if ( $expire_date < strtotime( $today ) ) {
							continue;
						}
					} else {
						$second_expire_date = get_post_meta( $coupon_id, 'coupon_details_second-expire-date', true );
						$third_expire_date  = get_post_meta( $coupon_id, 'coupon_details_third-expire-date', true );
						if ( $expire_date < strtotime( $today ) &&
						     $second_expire_date < strtotime( $today ) &&
						     $third_expire_date < strtotime( $today ) ) {
							continue;
						}
					}
				}
			}

			if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {

				if ( $coupon_template == 'Template One' ) {

					$argcss = 'shortcode_one';
					ob_start();
					$template->get_template_part( 'shortcode-one__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Two' ) {

					$argcss = 'shortcode_two';
					ob_start();
					$template->get_template_part( 'shortcode-two__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Three' ) {

					$argcss = 'shortcode_three';
					ob_start();
					$template->get_template_part( 'shortcode-three__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Four' ) {

					$argcss = 'shortcode_four';
					ob_start();
					$template->get_template_part( 'shortcode-four__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Five' ) {

					$argcss = 'shortcode_five';
					ob_start();
					$template->get_template_part( 'shortcode-five__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Six' ) {

					$argcss = 'shortcode_six';
					ob_start();
					$template->get_template_part( 'shortcode-six__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Seven' ) {

					$argcss = 'shortcode_seven';
					ob_start();
					$template->get_template_part( 'shortcode-seven__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Eight' ) {

					$argcss = 'shortcode_eight';
					ob_start();
					$template->get_template_part( 'shortcode-eight__premium_only' );
					$output = ob_get_clean();

				} elseif ( $coupon_template == 'Template Nine' ) {

					$argcss = 'shortcode_nine';
					ob_start();
					$template->get_template_part( 'shortcode-nine__premium_only' );
					$output = ob_get_clean();

				} else {

					$argcss = 'shortcode_default';
					ob_start();
					$template->get_template_part( 'shortcode-default' );
					$output = ob_get_clean();

				}

			} else {
				$argcss = 'shortcode_default';
				ob_start();
				$template->get_template_part( 'shortcode-default' );
				$output = ob_get_clean();

			}
			if ( WPCD_Amp::wpcd_amp_is() ) {
				WPCD_Amp::instance()->setCss( 'shortcode_common' );
				WPCD_Amp::instance()->setCss( $argcss );
				$user_stylesheets = WPCD_Assets::wpcd_stylesheets( true, $coupon_id, $coupon_template );
				WPCD_Amp::instance()->setCss( $user_stylesheets, false );
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
		$output = ob_get_clean();

		if ( WPCD_Amp::wpcd_amp_is() ) {
			WPCD_Amp::instance()->setCss( 'shortcode_common' );
		}

		wp_reset_postdata();

		return $output;

	}

	/**
	 * Shortcode for the coupon archive page.
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function wpcd_coupons_archive_func__premium_only( $atts ) {

		$output             = "";
		$paged              = 1;
		$wpcd_data_taxonomy = 'all';
		$wpcd_data_search   = '';
		$a                  = shortcode_atts( array(
			'count' => '9',
			'temp'  => '',
			'sortby' => 'newest',
			'exclude' => ''
		), $atts );

		$archive_category_setting = get_option( 'wpcd_archive-munu-categories' );

		if ( $archive_category_setting == 'vendor' ) {
			$terms                = get_terms( 'wpcd_coupon_vendor' );
			$wpcd_coupon_taxonomy = WPCD_Plugin::VENDOR_TAXONOMY;
			$wpcd_term_field_name = 'wpcd_vendor';
		} else {
			$terms                = get_terms( 'wpcd_coupon_category' );
			$wpcd_coupon_taxonomy = WPCD_Plugin::CUSTOM_TAXONOMY;
			$wpcd_term_field_name = 'wpcd_category';
		}

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'wpcd_coupons_category_action' ) {
			if ( ! check_ajax_referer( 'wpcd-security-nonce', 'security' ) ) {
				wp_die();
			}

			if ( isset( $_POST['coupon_template'] ) && ! empty( $_POST['coupon_template'] ) &&
			     sanitize_text_field( $_POST['coupon_template'] ) === $_POST['coupon_template'] ) {
				$a['temp'] = sanitize_text_field( $_POST['coupon_template'] );
			}

			if ( isset( $_POST['coupon_items_count'] ) && ! empty( $_POST['coupon_items_count'] ) &&
			     absint( $_POST['coupon_items_count'] ) == $_POST['coupon_items_count'] ) {
				$a['count'] = absint( $_POST['coupon_items_count'] );
			}

            if ( isset( $_POST['coupon_sortby'] ) && ! empty( $_POST['coupon_sortby'] ) &&
                sanitize_text_field( $_POST['coupon_sortby'] ) === $_POST['coupon_sortby'] ) {
                $a['sortby'] = sanitize_text_field( $_POST['coupon_sortby'] );
            }

            if ( isset( $_POST['coupon_exclude_cat'] ) && ! empty( $_POST['coupon_exclude_cat'] ) &&
                sanitize_text_field( $_POST['coupon_exclude_cat'] ) === $_POST['coupon_exclude_cat'] ) {
                $a['exclude'] = sanitize_text_field( $_POST['coupon_exclude_cat'] );
            }

			if ( isset( $_POST['wpcd_page_num'] ) && ! empty( $_POST['wpcd_page_num'] ) &&
			     absint( $_POST['wpcd_page_num'] ) == $_POST['wpcd_page_num'] ) {
				$paged = absint( $_POST['wpcd_page_num'] );
			}

			if ( isset( $_POST[ $wpcd_term_field_name ] ) && ! empty( $_POST[ $wpcd_term_field_name ] ) &&
			     sanitize_text_field( $_POST[ $wpcd_term_field_name ] ) === $_POST[ $wpcd_term_field_name ] ) {
				if ( get_term_by( 'slug', sanitize_text_field( $_POST[ $wpcd_term_field_name ] ),
					$wpcd_coupon_taxonomy ) ) {
					$wpcd_data_taxonomy = sanitize_text_field( $_POST[ $wpcd_term_field_name ] );
				}
			}

			if ( isset( $_POST['search_text'] ) && ! empty( $_POST['search_text'] ) ) {
				if ( sanitize_text_field( $_POST['search_text'] ) === trim( $_POST['search_text'] ) ) {
					$wpcd_data_search = sanitize_text_field( $_POST['search_text'] );
				} else {
					$output = '<p>' . __( 'Sorry, no coupons/deals found.', 'wp-coupons-and-deals' ) . '</p>';
					echo json_encode( $output );
					wp_die();
				}
			}
		} else {
			wp_enqueue_script( 'wpcd-main-js' );

			if ( isset( $_GET['wpcd_page_num'] ) && ! empty( $_GET['wpcd_page_num'] ) &&
			     absint( $_GET['wpcd_page_num'] ) == $_GET['wpcd_page_num'] ) {
				$paged = absint( $_GET['wpcd_page_num'] );
			}

			if ( isset( $_GET[ $wpcd_term_field_name ] ) && ! empty( $_GET[ $wpcd_term_field_name ] ) &&
			     sanitize_text_field( $_GET[ $wpcd_term_field_name ] ) === $_GET[ $wpcd_term_field_name ] ) {
				if ( get_term_by( 'slug', sanitize_text_field( $_GET[ $wpcd_term_field_name ] ),
					$wpcd_coupon_taxonomy ) ) {
					$wpcd_data_taxonomy = sanitize_text_field( $_GET[ $wpcd_term_field_name ] );
				}
			}
		}

		if ( $wpcd_data_taxonomy != 'all' && $wpcd_data_taxonomy != '' && empty( $wpcd_data_search ) ) {
			$args = array(
				'post_type'      => 'wpcd_coupons',
                'post_status' => 'publish',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'tax_query'      => array(
					array(
						'taxonomy' => $wpcd_coupon_taxonomy,
						'field'    => 'slug',
						'terms'    => $wpcd_data_taxonomy,
					),
				),
				'paged'          => $paged
			);
		} elseif ( ! empty( $wpcd_data_search ) ) {
			$args = array(
				'post_type'      => 'wpcd_coupons',
                'post_status' => 'publish',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'paged'          => $paged,
				's'              => $wpcd_data_search,
			);
		} else {
			$args = array(
				'post_type'      => 'wpcd_coupons',
                'post_status' => 'publish',
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

		// sortby attribute - available options - newest(default), oldest, expire-first, expire-last
		if ( !empty( $a['sortby'])) {
			if ($a['sortby'] == 'oldest' ) {
				$args['order'] = 'ASC';
			} else if ($a['sortby'] == 'expired-first') {
				$args['order'] = 'ASC';
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'coupon_details_expire-date';
			} else if ($a['sortby'] == 'expired-last') {
				$args['order'] = 'DESC';
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'coupon_details_expire-date';
			}
		}

        // template system.
        $temp = $a['temp'];
        $argcss = array();
        if ( $temp == '' ) { // vertical style.
            $argcss          = 'archive_not_temp';
            $coupon_template = 'shortcode-archive__premium_only';
        } else if ( in_array( $temp, array( 'one', 'two', 'three', 'seven', 'eight' ) ) ) {
			$argcss          = 'archive_' . $temp;
			$coupon_template = 'shortcode-archive-' . $temp . '__premium_only';
		} else {
			$argcss          = 'archive_default';
			$coupon_template = 'shortcode-archive-default__premium_only';
        }

		// hide the coupons which is expired
        $hide_expired_coupon = get_option( 'wpcd_hide-expired-coupon' );
        if ( $hide_expired_coupon === "on" ) {
            $today = date( 'd-m-Y' );

            $meta_query_expired = array(
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
                    'value'   => strtotime( $today ),
                    'compare' => '>',
                    'type'    => 'numeric'
                )
            );
            if( ! array_key_exists('meta_query', $args) ) {
                $args['meta_query'] = $meta_query_expired;
            } else {
                $args['meta_query'] = array_merge( [ 'relation' => 'AND' ], $args['meta_query'] );
                array_push( $args['meta_query'], $meta_query_expired );
            }
        }

        // hide the coupons which have excluded categories
        if ( !empty( $a['exclude']) && $a['exclude'] != '' ) {
            $exclude_arr = explode(',', $a['exclude']);
            $exclude_categories = array();
            foreach( $exclude_arr as $item ) {
                if ( is_numeric( $item ) ) {
                    $term = get_term($item);
                    if( $term && ! is_wp_error($term) ) {
                        if( ! array_key_exists( $term->taxonomy, $exclude_categories ) ) {
                            $exclude_categories[$term->taxonomy] = array();
                        }

                        array_push($exclude_categories[$term->taxonomy], $item );
                    }
                }
            }
            if( count( $exclude_categories ) > 0 ) {
                if( ! array_key_exists( 'tax_query', $args ) ) {
                    $args['tax_query'] = array();
                }
                $args['tax_query'] = array_merge(['relation' => 'AND'], $args['tax_query']);

                foreach ( $exclude_categories as $taxonomy_name => $term_ids_arr ) {
                    $add_tax_query = array(
                        array(
                            'taxonomy' => $taxonomy_name,
                            'field'    => 'term_id',
                            'terms'    => $term_ids_arr,
                            'operator' => 'NOT IN',
                        ),
                    );
                    $args['tax_query'] = array_merge($args['tax_query'], $add_tax_query);
                }
            }
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

			if ( WPCD_Amp::wpcd_amp_is() ) {
				WPCD_Amp::instance()->setCss( 'archive_common' );
				WPCD_Amp::instance()->setCss( 'shortcode_common' );
				if ( $argcss == 'archive_default' ) {
					WPCD_Amp::instance()->setCss( 'shortcode_five' );
					WPCD_Amp::instance()->setCss( 'shortcode_six' );
					WPCD_Amp::instance()->setCss( 'shortcode_default' );
				} else {
					WPCD_Amp::instance()->setCss( $argcss );
				}
				$user_stylesheets = WPCD_Assets::wpcd_stylesheets( true );
				WPCD_Amp::instance()->setCss( $user_stylesheets, false );
			}

			if ( ! WPCD_Amp::wpcd_amp_is() && ( ! isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ) ) {
				global $post;
				$wpcd_data_coupon_page_url = get_page_link( $post->ID );
				$output                    = '<div id="wpcd_coupon_template" wpcd-data-coupon_template="' . esc_attr( $temp ) . '" ' . ( infinity_scroll_in_archive() ? 'wpcd-data-infinity_scroll_in_archive="1"' : '' ) . ' wpcd-data-coupon_items_count="' . absint( $a["count"] ) . '" '
				                             . 'wpcd-data-coupon_sortby="' . esc_attr( $a["sortby"] ) . '" ' . 'wpcd-data-coupon_exclude_cat="' . esc_attr( $a["exclude"] ) . '" '
                                            . 'wpcd-data-coupon_page_url="' . esc_url( $wpcd_data_coupon_page_url ) . '" ' . esc_attr( $wpcd_coupon_taxonomy ). '="' . esc_attr( $wpcd_data_taxonomy ) . '"></div>';
			}

			// check enable statistics
			$enable_stats = get_option('wpcd_enable-stats-count');
			// the loop.
			while ( $the_query->have_posts() ) : $the_query->the_post();

				global $coupon_id;
				$coupon_id = get_the_ID();
				$parent    = "";

				if (! empty( $enable_stats ) && $enable_stats == 'on') {
					$view_count = get_post_meta( $coupon_id, 'coupon_view_count', true );
					if (empty($view_count) || !is_numeric($view_count)) {
						$view_count = 1;
					} else {
						$view_count = intval($view_count) + 1;
					}
					update_post_meta($coupon_id, 'coupon_view_count', $view_count);
				}

				// check to print header or footer.
				if ( $i == 1 && $num_posts !== 1 ) {
					$parent = 'header';
				} elseif ( $num_posts == 1 ) {
					// means there's only one coupon
					// So, it should print the header and footer in this time
					$parent = 'headerANDfooter';
				} elseif ( $i == $num_posts ) {
					$parent = 'footer';
				}

				$template = new WPCD_Template_Loader();
				ob_start();
				$template->get_template_part( $coupon_template );
				$output .= ob_get_clean();
				$i ++;

			endwhile;
			// end of the loop.
			wp_reset_postdata();
		else :
			$output .= '<p>' . __( 'Sorry, no coupons/deals found.', 'wp-coupons-and-deals' ) . '</p>';
		endif;

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'wpcd_coupons_category_action' ) {
			echo json_encode( $output );
			wp_die();
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
		$output = "";
		$paged  = 1;

		$a = shortcode_atts( array(
			'count' => 9,
			'id'    => '',
			'cat'   => '',
			'vend'  => '',
			'temp'  => '',
			'sortby' => 'newest'
		), $atts );

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'wpcd_coupons_cat_vend_action' ) {
			if ( ! check_ajax_referer( 'wpcd-security-nonce', 'security' ) ) {
				wp_die();
			}

			if ( isset( $_POST['coupon_template'] ) && ! empty( $_POST['coupon_template'] )
			     && sanitize_text_field( $_POST['coupon_template'] ) === $_POST['coupon_template'] ) {
				$a['temp'] = sanitize_text_field( $_POST['coupon_template'] );
			}

			if ( isset( $_POST['coupon_items_count'] ) && ! empty( $_POST['coupon_items_count'] )
			     && absint( $_POST['coupon_items_count'] ) == $_POST['coupon_items_count'] ) {
				$a['count'] = absint( $_POST['coupon_items_count'] );
			}

            if ( isset( $_POST['coupon_sortby'] ) && ! empty( $_POST['coupon_sortby'] ) &&
                sanitize_text_field( $_POST['coupon_sortby'] ) === $_POST['coupon_sortby'] ) {
                $a['sortby'] = sanitize_text_field( $_POST['coupon_sortby'] );
            }

			if ( isset( $_POST['wpcd_page_num'] ) && ! empty( $_POST['wpcd_page_num'] )
			     && absint( $_POST['wpcd_page_num'] ) == $_POST['wpcd_page_num'] ) {
				$paged = absint( $_POST['wpcd_page_num'] );
			}

			if ( isset( $_POST['wpcd_data_category_coupons'] ) && ! empty( $_POST['wpcd_data_category_coupons'] )
			     && sanitize_text_field( $_POST['wpcd_data_category_coupons'] ) === $_POST['wpcd_data_category_coupons'] ) {
				$a['cat'] = sanitize_text_field( $_POST['wpcd_data_category_coupons'] );
			}

			if ( isset( $_POST['wpcd_data_vendor_coupons'] ) && ! empty( $_POST['wpcd_data_vendor_coupons'] )
			     && sanitize_text_field( $_POST['wpcd_data_vendor_coupons'] ) === $_POST['wpcd_data_vendor_coupons'] ) {
				$a['vend'] = sanitize_text_field( $_POST['wpcd_data_vendor_coupons'] );
			}

			if ( isset( $_POST['wpcd_data_ven_cat_id'] ) && ! empty( $_POST['wpcd_data_ven_cat_id'] )
			     && sanitize_text_field( $_POST['wpcd_data_ven_cat_id'] ) === $_POST['wpcd_data_ven_cat_id'] ) {
				$a['id'] = sanitize_text_field( $_POST['wpcd_data_ven_cat_id'] );
			}
		} else {
			wp_enqueue_script( 'wpcd-main-js' );

			if ( isset( $_GET['wpcd_page_num'] ) && ! empty( $_GET['wpcd_page_num'] )
			     && absint( $_GET['wpcd_page_num'] ) == $_GET['wpcd_page_num'] ) {
				$paged = absint( $_GET['wpcd_page_num'] );
			}
		}

		if ( $a['temp'] == '' ) { // vertical style
			$argcss          = 'archive_not_temp';
			$coupon_template = 'shortcode-category__premium_only';
		} else {
			switch ( $a['temp'] ) {
				case 'one':
					$argcss          = 'archive_one';
					$coupon_template = 'shortcode-category-one__premium_only';
					break;
				case 'two':
					$argcss          = 'archive_two';
					$coupon_template = 'shortcode-category-two__premium_only';
					break;
				case 'three':
					$argcss          = 'archive_three';
					$coupon_template = 'shortcode-category-three__premium_only';
					break;
				case 'seven':
					$argcss          = 'archive_seven';
					$coupon_template = 'shortcode-category-seven__premium_only';
					break;
				case 'eight':
					$argcss          = 'archive_eight';
					$coupon_template = 'shortcode-category-eight__premium_only';
					break;
				default :
					$argcss          = 'archive_default';
					$coupon_template = 'shortcode-category-default__premium_only';
					break;
			}
		}
		if ( WPCD_Amp::wpcd_amp_is() ) {
			WPCD_Amp::instance()->setCss( 'archive_common' );
			WPCD_Amp::instance()->setCss( 'shortcode_common' );
			if ( $argcss == 'archive_default' ) {
				WPCD_Amp::instance()->setCss( 'shortcode_five' );
				WPCD_Amp::instance()->setCss( 'shortcode_six' );
				WPCD_Amp::instance()->setCss( 'shortcode_default' );
			} else {
				WPCD_Amp::instance()->setCss( $argcss );
			}
			$user_stylesheets = WPCD_Assets::wpcd_stylesheets( true );
			WPCD_Amp::instance()->setCss( $user_stylesheets, false );
		}

		if ( ! WPCD_Amp::wpcd_amp_is() && ( ! isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_cat_vend_action' ) ) {
			global $post;

			$wpcd_data_coupon_page_url = get_page_link( $post->ID );
			$output                    = '<div id="wpcd_coupon_template" wpcd-data-coupon_template="' . esc_attr( $a['temp'] ) . '" ' . ( infinity_scroll_in_archive() ? 'wpcd-data-infinity_scroll_in_archive="1"' : '' ) . ' '
			                             . 'wpcd-data-coupon_items_count="' . esc_attr( $a["count"] ) . '" wpcd-data-coupon_sortby="' . esc_attr( $a["sortby"] ) . '" wpcd-data-coupon_page_url="' . esc_url( $wpcd_data_coupon_page_url ) . '" '
			                             . 'wpcd-data_category_coupons="' . esc_attr( $a['cat'] ) . '" wpcd-data_vendor_coupons="' . esc_attr( $a['vend'] ) . '" wpcd-data_ven_cat_id="' . esc_attr( $a['id'] ) . '"></div>';
		}

		if ( $a['cat'] || $a['vend'] ) {
			$args = array(
				'post_type'      => 'wpcd_coupons',
                'post_status' => 'publish',
				'order'          => 'DESC',
				'posts_per_page' => $a['count'],
				'tax_query'      => array(
					array(
						'taxonomy' => ( $a['cat'] ) ? 'wpcd_coupon_category' : 'wpcd_coupon_vendor',
						'field'    => 'term_id',
						'terms'    => ( $a['cat'] ) ? $a['cat'] : $a['vend'],
					),
				),
				'paged'          => $paged
			);
		} else if ( $a['id'] ) {
            $posts_in = array_map( 'intval', explode( ',', $a['id'] ) );
            $args     = array(
                'post_type'   => 'wpcd_coupons',
                'post_status' => 'publish',
                'post__in'    => $posts_in,
                'paged'          => $paged
            );
        } else {
            $args     = array(
                'post_type'   => 'wpcd_coupons',
                'post_status' => 'publish',
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

		// sortby attribute - available options - newest(default), oldest, expire-first, expire-last
		if ( !empty( $a['sortby'])) {
			if ($a['sortby'] == 'oldest' ) {
				$args['order'] = 'ASC';
			} else if ($a['sortby'] == 'expired-first') {
				$args['order'] = 'ASC';
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'coupon_details_expire-date';
			} else if ($a['sortby'] == 'expired-last') {
				$args['order'] = 'DESC';
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'coupon_details_expire-date';
			}
		}

        // hide the coupons which is expired
        $hide_expired_coupon = get_option( 'wpcd_hide-expired-coupon' );
        if ( $hide_expired_coupon === "on" ) {
            $today = date( 'd-m-Y' );

            $meta_query_expired = array(
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
                    'value'   => strtotime( $today ),
                    'compare' => '>',
                    'type'    => 'numeric'
                )
            );

            if( ! array_key_exists('meta_query', $args) ) {
                $args['meta_query'] = $meta_query_expired;
            } else {
                $args['meta_query'] = array_merge( [ 'relation' => 'AND' ], $args['meta_query'] );
                array_push( $args['meta_query'], $meta_query_expired );
            }
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

			$enable_stats = get_option('wpcd_enable-stats-count');

			while ( $the_query->have_posts() ) : $the_query->the_post();

				global $coupon_id;
				$coupon_id = get_the_ID();
				$parent = "";

				// check to print header or footer.
				if ( $i == 1 && $num_posts !== 1 ) {
					$parent = 'header';
				} elseif ( $num_posts == 1 ) {
					$parent = 'headerANDfooter';
				} elseif ( $i == $num_posts ) {
					$parent = 'footer';
				}

				$template  = new WPCD_Template_Loader();

				if (!empty( $enable_stats ) && $enable_stats == 'on') {
					$view_count = get_post_meta( $coupon_id, 'coupon_view_count', true );
					if ( empty($view_count) || !is_numeric($view_count) ) {
						$view_count = 1;
					} else {
						$view_count = intval($view_count) + 1;
					}
					update_post_meta($coupon_id, 'coupon_view_count', $view_count);
				}

				ob_start();
				$template->get_template_part( $coupon_template );
				$output .= ob_get_clean();

				$i ++;

			endwhile;
			// end of the loop
			wp_reset_postdata();
		else :
			$output .= '<p>' . __( 'Sorry, no coupons/deals found.', 'wp-coupons-and-deals' ) . '</p>';
		endif;

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'wpcd_coupons_cat_vend_action' ) {
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
	public static function wpcd_coupon_clicked_action_func__premium_only( $atts ) {
		$coupon_id = $_POST['coupon_id'];
		if (isset($coupon_id) && is_numeric($coupon_id)) {
			$coupon_id = intval($coupon_id);
			$click_count = get_post_meta( $coupon_id, 'coupon_click_count', true );
			if (empty($click_count) || !is_numeric($click_count)) {
				$click_count = 1;
			} else {
				$click_count = intval($click_count) + 1;
			}
			update_post_meta($coupon_id, 'coupon_click_count', $click_count);
			echo "success";
		} else {
			echo 'wrong coupon id';
		}
	}
}
