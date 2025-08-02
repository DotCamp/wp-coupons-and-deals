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

		while ( $wpcd_coupon->have_posts() ) {

			$wpcd_coupon->the_post();

			global $coupon_id;
			$coupon_id = get_the_ID();

			// Track view if statistics enabled
			WPCD_Statistics_Tracker::track_view( $coupon_id );

			// Get coupon details
			$coupon_type     = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
			$coupon_template = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );

			// Handle image type coupons
			if ( $coupon_type === 'Image' ) {
				$output = self::render_image_coupon( $coupon_id );
				wp_reset_postdata();
				return $output;
			}

			// Check if coupon should be hidden due to expiration
			if ( WPCD_Template_Factory::should_hide_expired_coupon( $coupon_id, $coupon_template ) ) {
				continue;
			}

			// Render the coupon using template factory
			$output = WPCD_Template_Factory::render_template( 'shortcode', $coupon_template );
		}

		wp_reset_postdata();

		return $output;
	}

	/**
	 * Render image type coupon
	 *
	 * @param int $coupon_id The coupon ID
	 * @return string Rendered output
	 *
	 * @since 3.3.0
	 */
	private static function render_image_coupon( $coupon_id ) {
		$template = new WPCD_Template_Loader();
		
		ob_start();
		$template->get_template_part( 'shortcode-image' );
		$output = ob_get_clean();

		if ( WPCD_Amp::wpcd_amp_is() ) {
			WPCD_Amp::instance()->setCss( 'shortcode_image' );
		}

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
		// Initialize variables
		$output = '';
		$paged = 1;
		$wpcd_data_taxonomy = 'all';
		$wpcd_data_search = '';
		$is_ajax = isset( $_POST['action'] ) && $_POST['action'] == WPCD_Constants::AJAX_CATEGORY_ACTION;

		// Parse shortcode attributes
		$a = shortcode_atts( array(
			'count'   => WPCD_Constants::DEFAULT_COUPON_COUNT,
			'temp'    => '',
			'sortby'  => WPCD_Constants::DEFAULT_SORT_ORDER,
			'exclude' => ''
		), $atts );

		// Get taxonomy settings
		$taxonomy_data = self::get_taxonomy_settings();
		$wpcd_coupon_taxonomy = $taxonomy_data['taxonomy'];
		$wpcd_term_field_name = $taxonomy_data['field_name'];

		// Handle AJAX request
		if ( $is_ajax ) {
			WPCD_Validation_Utility::validate_ajax_request();
			
			// Process AJAX parameters
			$ajax_params = self::process_archive_ajax_params( $a, $wpcd_term_field_name, $wpcd_coupon_taxonomy );
			$a = $ajax_params['attributes'];
			$paged = $ajax_params['paged'];
			$wpcd_data_taxonomy = $ajax_params['taxonomy'];
			$wpcd_data_search = $ajax_params['search'];
			
			// Handle invalid search
			if ( $wpcd_data_search === false ) {
				$output = '<p>' . __( 'Sorry, no coupons/deals found.', WPCD_Constants::TEXT_DOMAIN ) . '</p>';
				echo json_encode( $output );
				wp_die();
			}
		} else {
			// Handle regular request
			wp_enqueue_script( 'wpcd-main-js' );
			
			// Get parameters from URL
			$url_params = self::process_archive_url_params( $wpcd_term_field_name, $wpcd_coupon_taxonomy );
			$paged = $url_params['paged'];
			$wpcd_data_taxonomy = $url_params['taxonomy'];
		}

		// Build query args using Query Builder
		$args = WPCD_Query_Builder::build_complete_query(
			$a,
			$paged,
			$wpcd_data_taxonomy,
			$wpcd_coupon_taxonomy,
			$wpcd_data_search
		);

		// Get template info
		$template_info = WPCD_Template_Factory::get_template_info( WPCD_Constants::TEMPLATE_TYPE_ARCHIVE, $a['temp'] );
		$coupon_template = $template_info['template'];
		$argcss = $template_info['css'];

		// Execute query and render results
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) :
			// Set up global variables
			global $parent, $max_num_page, $current_url;
			$max_num_page = $the_query->max_num_pages;
			$current_url = get_permalink();

			// Handle non-AJAX wrapper
			if ( ! $is_ajax && ! WPCD_Amp::wpcd_amp_is() ) {
				$output = self::render_archive_wrapper( $a, $wpcd_coupon_taxonomy, $wpcd_data_taxonomy );
			}

			// Render coupons
			$output .= self::render_archive_coupons( $the_query, $coupon_template );

			wp_reset_postdata();
		else :
			$output .= '<p>' . __( 'Sorry, no coupons/deals found.', WPCD_Constants::TEXT_DOMAIN ) . '</p>';
		endif;

		// Handle AJAX response
		if ( $is_ajax ) {
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

        $condition = '!=';
        if (isset($atts['imgcoupons'])) {
            $condition = (strpos($atts['imgcoupons'], 'yes') !== false) ? '==' : '!=';
        }

        if (empty($a['temp'])) {
            $args['meta_query'] = array(
                array(
                    'key' => 'coupon_details_coupon-type',
                    'value' => 'Image',
                    'compare' => $condition
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
		// This is now handled by WPCD_Statistics_Tracker::ajax_track_click()
		WPCD_Statistics_Tracker::ajax_track_click();
	}

	/**
	 * Get taxonomy settings based on admin configuration
	 *
	 * @return array Taxonomy data
	 *
	 * @since 3.3.0
	 */
	private static function get_taxonomy_settings() {
		$archive_category_setting = WPCD_Settings_Manager::get( WPCD_Constants::SETTING_ARCHIVE_MENU_CATEGORIES );

		if ( $archive_category_setting == 'vendor' ) {
			return array(
				'terms'      => get_terms( WPCD_Constants::TAXONOMY_VENDOR ),
				'taxonomy'   => WPCD_Constants::TAXONOMY_VENDOR,
				'field_name' => 'wpcd_vendor'
			);
		}

		return array(
			'terms'      => get_terms( WPCD_Constants::TAXONOMY_CATEGORY ),
			'taxonomy'   => WPCD_Constants::TAXONOMY_CATEGORY,
			'field_name' => 'wpcd_category'
		);
	}

	/**
	 * Process AJAX parameters for archive shortcode
	 *
	 * @param array $attributes Shortcode attributes
	 * @param string $term_field_name Term field name
	 * @param string $taxonomy Taxonomy name
	 * @return array Processed parameters
	 *
	 * @since 3.3.0
	 */
	private static function process_archive_ajax_params( $attributes, $term_field_name, $taxonomy ) {
		$result = array(
			'attributes' => $attributes,
			'paged'      => 1,
			'taxonomy'   => 'all',
			'search'     => ''
		);

		// Update attributes from POST
		$result['attributes']['temp'] = WPCD_Validation_Utility::get_post_value( 'coupon_template', 'string', $attributes['temp'] );
		$result['attributes']['count'] = WPCD_Validation_Utility::get_post_value( 'coupon_items_count', 'int', $attributes['count'] );
		$result['attributes']['sortby'] = WPCD_Validation_Utility::get_post_value( 'coupon_sortby', 'string', $attributes['sortby'] );
		$result['attributes']['exclude'] = WPCD_Validation_Utility::get_post_value( 'coupon_exclude_cat', 'string', $attributes['exclude'] );

		// Get page number
		$result['paged'] = WPCD_Validation_Utility::get_post_value( 'wpcd_page_num', 'int', 1 );

		// Get taxonomy term
		$term = WPCD_Validation_Utility::get_post_value( $term_field_name, 'string' );
		if ( $term ) {
			$validated_term = WPCD_Validation_Utility::validate_taxonomy_term( $term, $taxonomy );
			if ( $validated_term ) {
				$result['taxonomy'] = $validated_term;
			}
		}

		// Get search text
		$search_text = WPCD_Validation_Utility::get_post_value( 'search_text', 'string' );
		if ( $search_text && trim( $search_text ) === $search_text ) {
			$result['search'] = $search_text;
		} elseif ( $search_text ) {
			// Invalid search (has whitespace)
			$result['search'] = false;
		}

		return $result;
	}

	/**
	 * Process URL parameters for archive shortcode
	 *
	 * @param string $term_field_name Term field name
	 * @param string $taxonomy Taxonomy name
	 * @return array Processed parameters
	 *
	 * @since 3.3.0
	 */
	private static function process_archive_url_params( $term_field_name, $taxonomy ) {
		$result = array(
			'paged'    => 1,
			'taxonomy' => 'all'
		);

		// Get page number
		$result['paged'] = WPCD_Validation_Utility::get_query_value( 'wpcd_page_num', 'int', 1 );

		// Get taxonomy term
		$term = WPCD_Validation_Utility::get_query_value( $term_field_name, 'string' );
		if ( $term ) {
			$validated_term = WPCD_Validation_Utility::validate_taxonomy_term( $term, $taxonomy );
			if ( $validated_term ) {
				$result['taxonomy'] = $validated_term;
			}
		}

		return $result;
	}

	/**
	 * Render archive wrapper HTML
	 *
	 * @param array $attributes Shortcode attributes
	 * @param string $taxonomy Taxonomy name
	 * @param string $taxonomy_value Taxonomy value
	 * @return string HTML output
	 *
	 * @since 3.3.0
	 */
	private static function render_archive_wrapper( $attributes, $taxonomy, $taxonomy_value ) {
		global $post;
		$page_url = get_page_link( $post->ID );
		
		$data_attrs = array(
			'wpcd-data-coupon_template="' . esc_attr( $attributes['temp'] ) . '"',
			'wpcd-data-coupon_items_count="' . absint( $attributes['count'] ) . '"',
			'wpcd-data-coupon_sortby="' . esc_attr( $attributes['sortby'] ) . '"',
			'wpcd-data-coupon_exclude_cat="' . esc_attr( $attributes['exclude'] ) . '"',
			'wpcd-data-coupon_page_url="' . esc_url( $page_url ) . '"',
			esc_attr( $taxonomy ) . '="' . esc_attr( $taxonomy_value ) . '"'
		);

		if ( infinity_scroll_in_archive() ) {
			$data_attrs[] = 'wpcd-data-infinity_scroll_in_archive="1"';
		}

		return '<div id="wpcd_coupon_template" ' . implode( ' ', $data_attrs ) . '></div>';
	}

	/**
	 * Render archive coupons
	 *
	 * @param WP_Query $query The query object
	 * @param string $template_name Template name
	 * @return string HTML output
	 *
	 * @since 3.3.0
	 */
	private static function render_archive_coupons( $query, $template_name ) {
		global $parent, $coupon_id;
		
		$output = '';
		$num_posts = $query->post_count;
		$i = 1;

		while ( $query->have_posts() ) : $query->the_post();
			$coupon_id = get_the_ID();
			
			// Track view
			WPCD_Statistics_Tracker::track_view( $coupon_id );

			// Determine parent context
			$parent = self::get_parent_context( $i, $num_posts );

			// Render template
			$template = new WPCD_Template_Loader();
			ob_start();
			$template->get_template_part( $template_name );
			$output .= ob_get_clean();
			
			$i++;
		endwhile;

		return $output;
	}

	/**
	 * Get parent context for template rendering
	 *
	 * @param int $position Current position
	 * @param int $total Total items
	 * @return string Parent context
	 *
	 * @since 3.3.0
	 */
	private static function get_parent_context( $position, $total ) {
		if ( $position == 1 && $total !== 1 ) {
			return 'header';
		} elseif ( $total == 1 ) {
			return 'headerANDfooter';
		} elseif ( $position == $total ) {
			return 'footer';
		}
		return '';
	}
}
