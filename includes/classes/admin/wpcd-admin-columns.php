<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * Check if the necessary class exists, if not
 * then we are requiring the file that holds the
 * class we need.
 *
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * This class adds custom column to the custom
 * post type list screen.
 *
 * @since 1.0
 *
 */
class WPCD_Admin_Columns extends WP_List_Table {

	/**
	 * Initializing the admin columns.
	 *
	 * @since 1.0
	 */
	public static function wpcd_columns_init() {
		/**
		 * This filter adds the column to the custom
		 * post type admin screen.
		 *
		 * @since 1.0
		 */
		add_filter( 'manage_edit-wpcd_coupons_columns', array( __CLASS__, 'wpcd_list_columns' ) );

		/**
		 * Setting up the columns to be sortable by orders.
		 *
		 * @since 1.0
		 */
		add_action( 'pre_get_posts', array( __CLASS__, 'setting_orderby' ) );

		/**
		 * Custom column cases we'll use to create the
		 * columns we'll add.
		 *
		 * @since 1.0
		 */
		add_action( 'manage_posts_custom_column', array( __CLASS__, 'wpcd_columns_cases' ), 10, 2 );

		/**
		 * Making the columns sortable.
		 *
		 * @since 1.0
		 */
		add_filter( 'manage_edit-wpcd_coupons_sortable_columns', array( __CLASS__, 'wpcd_column_sortable' ), 10, 2 );

		if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {

			/**
			 * Adding custom columns to Coupon Category list.
			 *
			 * @since 2.2
			 */
			add_filter( 'manage_edit-wpcd_coupon_category_columns', array(
				__CLASS__,
				'wpcd_custom_taxonomy_columns__premium_only'
			), 10, 2 );

            /**
             * Adding custom field to get Coupon type.
             * @since 2.2
             */
            add_action('wpcd_coupon_category_add_form_fields',
                array(
                    __CLASS__,
                    'add_coupon_type_field'
                ), 10);

            /**
             * Adding custom field to get Coupon type.
             * @since 2.2
             */
            add_action('wpcd_coupon_category_edit_form_fields',
                array(
                    __CLASS__,
                    'edit_coupon_type_field'
                ), 10);

            /**
             * create coupon type fields.
             * @since 2.2
             */
            add_action('create_wpcd_coupon_category',
                array(
                    __CLASS__,
                    'save_coupon_type_fields'
                ), 10);

            /**
             * create coupon type fields.
             * @since 2.2
             */
            add_action('edited_wpcd_coupon_category',
                array(
                    __CLASS__,
                    'save_coupon_type_fields'
                ), 10);

			/**
			 * Adding content to custom columns in Coupon Category List.
			 *
			 * @since 2.2
			 */
			add_filter( 'manage_wpcd_coupon_category_custom_column', array(
				__CLASS__,
				'wpcd_custom_taxonomy_columns_content__premium_only'
			), 10, 3 );
                        
            /**
			 * Adding custom columns to Coupon Category list.
			 *
			 * @since 2.7.0
			 */
			add_filter( 'manage_edit-wpcd_coupon_vendor_columns', array(
				__CLASS__,
				'wpcd_vendor_taxonomy_columns__premium_only'
			), 10, 2 );
                        
            /**
			 * Adding content to custom columns in Coupon Category List.
			 *
			 * @since 2.7.0
			 */
			add_filter( 'manage_wpcd_coupon_vendor_custom_column', array(
				__CLASS__,
				'wpcd_vendor_taxonomy_columns_content__premium_only'
			), 10, 3 );
		}

	}

	/*
	* This function sets up the columns.
	* Adding the custom fields to the columns.
	*
	* @since 1.0
	* @param array $columns
	*/
	public static function wpcd_list_columns( $columns ) {

		/**
		 * This is an array of all the columns for the
		 * custom coupon post type admin screen.
		 *
		 * @since 1.0
		 */
		$wpcd_columns = array();

		if ( isset( $columns['cb'] ) ) {
			$wpcd_columns['cb'] = $columns['cb'];
		}

		if ( isset( $columns['title'] ) ) {
			$wpcd_columns['title'] = __( 'Title', 'wp-coupons-and-deals' );
		}

		if ( isset( $columns['author'] ) ) {
			$wpcd_columns['author'] = $columns['author'];
		}

		/**
		 * Adding custom fields data to the column array
		 *
		 * @since 1.0
		 */
		$wpcd_columns['coupon_type'] = __( 'Coupon Type', 'wp-coupons-and-deals' );
		$wpcd_columns['coupon_category']  = __( 'Category', 'wp-coupons-and-deals' );
        $wpcd_columns['coupon_vendor']    = __( 'Vendor','wp-coupons-and-deals' );
		$wpcd_columns['id']               = __( 'ID', 'wp-coupons-and-deals' );
		$wpcd_columns['coupon_shortcode'] = __( 'Shortcodes', 'wp-coupons-and-deals' );
		$wpcd_columns['coupon_expire']    = __( 'Expires', 'wp-coupons-and-deals' );

		if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
			$enable_stats = get_option('wpcd_enable-stats-count');
			if (! empty( $enable_stats ) && $enable_stats == 'on') {
				$wpcd_columns['coupon_view_count']    = __( 'Viewed Count', 'wp-coupons-and-deals' );
				$wpcd_columns['coupon_click_count']    = __( 'Clicked Count', 'wp-coupons-and-deals' );
			}
		}

		/**
		 *
		 * This filters the columns headers.
		 * Using an array of the column headers.
		 *
		 */
		if ( has_filter( 'wpcd_filter_coupon_list_columns' ) ) {

			/**
			 * This will filter the admin coupon list columns headers.
			 *
			 * @param array $wpcd_columns an array of column headers.
			 *
			 */
			$wpcd_columns = apply_filters( 'wpcd_filter_coupon_list_columns', $wpcd_columns, $columns );
		}

		/**
		 * Returning columns.
		 *
		 * @since 1.0
		 */
		return $wpcd_columns;
	}

	/**
	 * This adds the custom meta data to columns.
	 *
	 * @since 1.0
	 *
	 * @param $column
	 * @param $post_id
	 */
	public static function wpcd_columns_cases( $column, $post_id ) {

		/**
		 *
		 * This contains data from the current post in the loop.
		 * This allows us to use data from the post.
		 *
		 * @since 1.0
		 */
		global $post;

		/**
		 * Showing the custom fields in columns for corresponding
		 * post meta data from individual posts.
		 *
		 * @since 1.0
		 */
		switch ( $column ) {


			case 'id':
				echo absint( $post_id );
				break;

			case 'coupon_category':
				$terms = get_the_terms( $post_id, 'wpcd_coupon_category' );
				if ( ! empty( $terms ) ) {
					$out = array();

					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array(
								'wpcd_coupon_category' => $term->slug,
								'post_type'            => $post->post_type
							), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'cpt_coupon_category', 'display' ) )
						);
					}

					echo join( ', ', $out );

				} else {

					_e( 'No Category', 'wp-coupons-and-deals' );

				}
				break;
                                
            case 'coupon_vendor':
                $terms = get_the_terms( $post_id, 'wpcd_coupon_vendor' );
				if ( ! empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array(
								'wpcd_coupon_vendor' => $term->slug,
								'post_type'            => $post->post_type
							), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'cpt_coupon_vendor', 'display' ) )
						);
					}
					echo join( ', ', $out );
				} else {
					_e( 'No Vendor', 'wp-coupons-and-deals' );
				}
				break;

			case 'coupon_shortcode':
				$coupon_type = get_post_meta( $post_id, 'coupon_details_coupon-type', true );
				if ( $coupon_type === 'Image' ) {
					echo "[wpcd_coupon id=" . absint( $post_id ) . "]";
				} else {
					$shortcode      = "[wpcd_coupon id=" . $post_id . "]";
					$code_shortcode = "[wpcd_code id=" . $post_id . "]";
					echo wp_kses( $shortcode . ' <br><br> ' . $code_shortcode, array('br' => array()) );
				}
				break;

			case 'coupon_details_coupon-code':
				$coupon_code = get_post_meta( $post_id, 'coupon_details_coupon-code-text', true );
				echo esc_html( $coupon_code);
				break;

			case 'coupon_details_description':
				$description = get_post_meta( $post_id, 'coupon_details_description', true );
				echo esc_html( $description );
				break;

			case 'coupon_details_link':
				$link = get_post_meta( $post_id, 'coupon_details_link', true );
				echo esc_url( $link );
				break;

			case 'coupon_type':
				$coupon_type = get_post_meta( $post_id, 'coupon_details_coupon-type', true );
				echo esc_html( $coupon_type );
				break;

			case 'coupon_expire':
				$today  = date( 'd-m-Y' );
				$expire = get_post_meta( $post_id, 'coupon_details_expire-date', true );
                $expireDateFormat = get_option( 'wpcd_expiry-date-format' );
                $expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
				if ( ! empty ( $expire ) ) {
                    if ( (string)(int)$expire != $expire ) {
                        $expire =  strtotime( $expire );
                    }
					if ( $expire  >= strtotime( $today ) ) {
						echo date( $expireDateFormatFun, $expire );
					} elseif ( $expire < strtotime( $today ) ) {
						echo __( 'Expired', 'wp-coupons-and-deals' );
					}
				} else {
					echo __( "Doesn't Expire", 'wp-coupons-and-deals' );
				}
				break;
			case 'coupon_view_count':
				$view_count = get_post_meta( $post_id, 'coupon_view_count', true );				
				echo (isset($view_count) && is_numeric($view_count))? $view_count: 0;
				break;
			case 'coupon_click_count':
				$click_count = get_post_meta( $post_id, 'coupon_click_count', true );
				echo (isset($click_count) && is_numeric($click_count))? $click_count: 0;
				break;
		}

		/**
		 * Filtering the coupon list column information.
		 *
		 * @since 1.0
		 */
		if ( has_filter( 'wpcd_filter_column_cases' ) ) {

			/**
			 * This filters the admin coupon list columns information
			 * for custom coupon post type.
			 *
			 * @since 1.0
			 *
			 * @param string $column data to display in the admin columns.
			 * @param int    $post_id id of the custom coupon post.
			 *
			 */
			apply_filters( 'wpcd_filter_column_cases', $column, $post_id );
		}
	}

	/**
	 * This will make custom column sortable.
	 *
	 * @since 1.0
	 *
	 * @param array $columns array of the custom columns.
	 *
	 * @return array $columns
	 *
	 */
	public static function wpcd_column_sortable( $columns ) {

		/**
		 * Adding the custom fields to columns array.
		 *
		 * @since 1.0
		 */
		$columns['coupon_details_link']        = 'coupon_details_link';
		$columns['coupon_details_coupon-code'] = 'coupon_details_coupon-code';
		$columns['coupon_type']                = 'coupon_details_coupon-type';
		$columns['coupon_expire']              = 'coupon_details_expire-date';

		/**
		 * Returning the columns array after adding the custom fields.
		 *
		 * @since 1.0
		 */
		return $columns;
	}

	/**
	 * Setting the columns sorting order.
	 *
	 * @param $query
	 *
	 * @since 1.0
	 */
	public static function setting_orderby( $query ) {

		$orderby = $query->get( 'orderby' );

		if ( 'coupon_details_coupon-type' == $orderby ) {
			$query->set( 'meta_key', 'coupon_details_coupon-type' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'coupon_details_coupon-code' == $orderby ) {
			$query->set( 'meta_key', 'coupon_details_coupon-code-text' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'coupon_details_link' == $orderby ) {
			$query->set( 'meta_key', 'coupon_details_link' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'coupon_details_expire-date' == $orderby ) {
			$query->set( 'meta_key', 'coupon_details_expire-date' );
			$query->set( 'orderby', 'meta_value' );
		}

	}

	/**
	 * Custom coloumns for Coupon Category page.
	 *
	 * @param $columns
	 *
	 * @return array
	 * @since 2.2
	 */
	public static function wpcd_custom_taxonomy_columns__premium_only( $columns ) {

		$columns = array(
			'cb'                 => '<input type="checkbox" />',
			'name'               => __( 'Name', 'wp-coupons-and-deals' ),
			'slug'               => __( 'Slug', 'wp-coupons-and-deals' ),
			'posts'              => __( 'Posts', 'wp-coupons-and-deals' ),
			'wpcd_cat_shortcode' => __( 'Shortcode', 'wp-coupons-and-deals' )
		);

		return $columns;
	}

    /**
     * create custom Category.
     * @since 2.2
     */
    public static function add_coupon_type_field($taxonomy)
    {
        wp_nonce_field('category_meta_new', 'category_meta_new_nonce');
        ?>
        <label for='type'>Type</label>
        <select name="type">
            <option value="image">Image</option>
            <option value="coupon">Coupon</option>
            <option value="deals">Deals</option>
        </select>
        <p class='type'>Enter category type </p>
        <?php
        return $taxonomy;
    }

    /**
     * edit custom Category.
     * @since 2.2
     */
    public static function edit_coupon_type_field($taxonomy)
    {
        $type = get_option('wpcd_coupon_category_' . $taxonomy->term_id . '_type');
        wp_nonce_field('category_meta_new', 'category_meta_new_nonce');
        ?>
        <label for='type'>Type</label>
        <select name="type">
            <option <?= ($type == 'image') ? 'selected' : '' ?> value="image">Image</option>
            <option <?= ($type == 'coupon') ? 'selected' : '' ?> value="coupon">Coupon</option>
            <option <?= ($type == 'deals') ? 'selected' : '' ?> value="deals">Deals</option>
        </select>
        <p class='type'>Enter category type </p>
        <?php
        return $taxonomy;
    }

    /**
     * Custom field save Coupon type.
     * @since 2.2
     */
    public static function save_coupon_type_fields($term_id)
    {
        if (!empty($_POST['type'])) {
            update_option('wpcd_coupon_category_' . $term_id . '_type', $_POST['type']);
        } elseif (!empty($category_imageUrl)) {
            delete_option('wpcd_coupon_category_' . $term_id . '_type');
        }
    }

	/**
	 * Content for custom taxonomy columns.
	 *
	 * @param $content
	 * @param $column_name
	 * @param $term_id
	 *
	 * @return string
	 *
	 * @since 2.2
	 */
	public static function Wpcd_custom_taxonomy_columns_content__premium_only( $content, $column_name, $term_id ) {

		if ( 'wpcd_cat_id' == $column_name ) {
			$content = $term_id;
		}

		if ( 'wpcd_cat_shortcode' == $column_name ) {
			$content = '[wpcd_coupons_loop cat=' . $term_id . ']';
		}

		return $content;
	}
        
        /**
	 * Custom coloumns for Coupon Vendor page.
	 *
	 * @param $columns
	 *
	 * @return array
	 * @since 2.6.3
	 */
	public static function wpcd_vendor_taxonomy_columns__premium_only( $columns ) {

		$columns = array(
			'cb'                 => '<input type="checkbox" />',
			'name'               => __( 'Name', 'wp-coupons-and-deals' ),
			'slug'               => __( 'Slug', 'wp-coupons-and-deals' ),
			'posts'              => __( 'Posts', 'wp-coupons-and-deals' ),
			'wpcd_vend_shortcode' => __( 'Shortcode', 'wp-coupons-and-deals' )
		);

		return $columns;
	}
        
        /**
	 * Content for vendor taxonomy columns.
	 *
	 * @param $content
	 * @param $column_name
	 * @param $term_id
	 *
	 * @return string
	 *
	 * @since 2.6.3
	 */
	public static function Wpcd_vendor_taxonomy_columns_content__premium_only( $content, $column_name, $term_id ) {
               
		if ( 'wpcd_vend_id' == $column_name ) {
			$content = $term_id;
		}

		if ( 'wpcd_vend_shortcode' == $column_name ) {
			$content = '[wpcd_coupons_loop vend=' . $term_id . ']';
		}

		return $content;
	}
}
