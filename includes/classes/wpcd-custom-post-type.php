<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPCD Custom Post type
 * This class is used to register a new post type.
 *
 * @since 1.0
 * @author Imtiaz Rayhan
 */
class WPCD_Custom_Post_Type {

	/**
	 * This is the name of the custom post type.
	 *
	 * @var string
	 * @since 1.0
	 */
	protected $post_type;

	/**
	 * Sets up the default values and registers
	 * the custom post type.
	 *
	 * @param string $custom_post_type The name of the custom post type.
	 *
	 * @since 1.0
	 */
	public function __construct( $custom_post_type ) {

		// Sets the variables for the custom post type.
		$this->post_type = $custom_post_type;
		add_filter( 'enter_title_here', array( $this, 'wpcd_change_enter_title' ) );

	}

	/**
	 * This function will generate post type labels.
	 *
	 * @param $name_singular
	 * @param $name_plural
	 * @param $t_domain
	 *
	 * @return array
	 * @since 1.0
	 */
	public static function post_type_labels( $name_singular, $name_plural, $t_domain ) {

		/**
		 * These are the labels for custom post type.
		 * When we register the custom post type we
		 * will use these.
		 *
		 * @since 1.0
		 */
		$labels = array(
			'name'               => sprintf( esc_html__( '%s', $t_domain ), $name_plural ),
			'singular_name'      => sprintf( esc_html__( '%s', $t_domain ), $name_singular ),
			'menu_name'          => sprintf( esc_html__( '%s', $t_domain ), $name_plural ),
			'name_admin_bar'     => sprintf( esc_html__( '%s', $t_domain ), $name_plural ),
			'add_new'            => sprintf( esc_html__( 'Add New %s', $t_domain ), $name_singular ),
			'add_new_item'       => sprintf( esc_html__( 'Add New %s', $t_domain ), $name_singular ),
			'edit_item'          => sprintf( esc_html__( 'Edit %s', $t_domain ), $name_singular ),
			'new_item'           => sprintf( esc_html__( 'New %s', $t_domain ), $name_singular ),
			'view_item'          => sprintf( esc_html__( 'View %s', $t_domain ), $name_singular ),
			'search_items'       => sprintf( esc_html__( 'Search %s', $t_domain ), $name_plural ),
			'not_found'          => sprintf( esc_html__( 'No %s found', $t_domain ), $name_plural ),
			'not_found_in_trash' => sprintf( esc_html__( 'No %s found in Trash', $t_domain ), $name_plural ),
		);

		return $labels;
	}

	/**
	 * This function holds the argument and
	 * registers the custom post type with WordPress
	 *
	 * @param $post_type
	 * @param $name_singular
	 * @param $labels
	 * @param $t_domain
	 *
	 * @since 1.0
	 */
	public static function post_type_register( $post_type, $name_singular, $labels, $t_domain ) {

		/**
		 * Arguments for the custom post type.
		 * These will be used when we register the
		 * custom post type with WordPress.
		 *
		 * @since 1.0
		 */
		$args = array(
			'labels'             => $labels,
			'description'        => sprintf( esc_html__( '%s Custom Post Type', $t_domain ), $name_singular ),
			'supports'           => array( 'title', 'thumbnail' ),
			'public'             => false,
			'publicly_queriable' => true,
			'show_ui'            => true,
			'menu_position'      => 55,
			'menu_icon'          => WPCD_Plugin::instance()->plugin_assets . 'img/coupon24.png',
			'has_archive'        => true,
			'show_in_menu'       => true,
			'capability_type'    => 'post',
			'show_in_nav_menus'  => false,
		);

        $args['capabilities'] = array(
            'edit_post' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'read_post' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'delete_post' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'edit_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'edit_others_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'delete_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'publish_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'read_private_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'read' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'delete_private_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'delete_published_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'delete_others_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'edit_private_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'edit_published_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'create_posts' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
        );

		/**
		 * WordPress function to register the custom
		 * post type using our post type name and arguments.
		 *
		 * @since 1.0
		 */
		register_post_type( $post_type, $args );
	}

	/**
	 * Changes the 'Enter title here' text.
	 *
	 * @param $input
	 *
	 * @since 2.0
	 */
	function wpcd_change_enter_title( $input ) {

		if ( is_admin() && 'wpcd_coupons' === get_post_type() ) {
			return __( 'Enter Coupon title here', 'wpcd-coupon' );
		}

		return $input;

	}
}
