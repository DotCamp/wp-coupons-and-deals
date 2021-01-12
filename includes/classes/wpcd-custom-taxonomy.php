<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPCD Custom Taxonomy
 * This class is used to register a new taxonomy.
 *
 * @since 1.0
 * @author Imtiaz Rayhan
 */
class WPCD_Custom_Taxonomy {

	/**
	 * This generates the lables for custom taxonomy.
	 *
	 * @param $taxonomy_singular
	 * @param $taxonomy_plural
	 * @param $t_domain
	 *
	 * @return array
	 */
	public static function taxonomy_labels( $taxonomy_singular, $taxonomy_plural, $t_domain ) {

		/**
		 * Labels for the custom taxonomy.
		 *
		 * @since 1.0
		 */
		$labels = array(
			'name'                       => sprintf( esc_html__( '%s', $t_domain ), $taxonomy_singular ),
			'singular_name'              => sprintf( esc_html__( '%s', $t_domain ), $taxonomy_plural ),
			'search_items'               => sprintf( esc_html__( 'Search %s', $t_domain ), $taxonomy_plural ),
			'all_items'                  => sprintf( esc_html__( 'All %s', $t_domain ), $taxonomy_plural ),
			'parent_item'                => sprintf( esc_html__( 'Parent %s', $t_domain ), $taxonomy_plural ),
			'parent_item_colon'          => sprintf( esc_html__( 'Parent %s:', $t_domain ), $taxonomy_plural ),
			'edit_item'                  => sprintf( esc_html__( 'Edit %s', $t_domain ), $taxonomy_singular ),
			'update_item'                => sprintf( esc_html__( 'Update %s', $t_domain ), $taxonomy_plural ),
			'add_new_item'               => sprintf( esc_html__( 'Add New %s', $t_domain ), $taxonomy_singular ),
			'new_item_name'              => sprintf( esc_html__( 'New %s Name', $t_domain ), $taxonomy_singular ),
			'menu_name'                  => sprintf( esc_html__( '%s', $t_domain ), $taxonomy_plural ),
			'popular_items'              => sprintf( esc_html__( 'Popular %s', $t_domain ), $taxonomy_plural ),
			'separate_items_with_commas' => sprintf( esc_html__( 'Separate %s with commas', $t_domain ), $taxonomy_plural ),
			'add_or_remove_items'        => sprintf( esc_html__( 'Add or remove %s', $t_domain ), $taxonomy_singular ),
			'choose_from_most_used'      => sprintf( esc_html__( 'Choose from the most used %s', $t_domain ), $taxonomy_plural ),
		);

		return $labels;

	}

	/**
	 * This function holds the arguments and
	 * registers the custom taxonomy with WordPress.
	 *
	 * @param $taxonomy
	 * @param $post_types
	 * @param $labels
	 * @param $slug
	 */
	public static function register_taxonomy( $taxonomy, $post_types, $labels, $slug ) {

		/**
		 * Arguments for the custom taxonomy.
		 * These will be used when we register the
		 * custom custom taxonomy with WordPress.
		 *
		 * @since 1.0
		 */
		$args = array(
			'labels'            => $labels,
			'public'            => false,
			'show_in_nav_menus' => false,
			'show_ui'           => true,
			'show_tagcloud'     => false,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => $slug, 'with_front' => true ),
			'query_var'         => true
		);

		$args['capabilities'] = array(
            'manage_terms' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'edit_terms' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'delete_terms' => WPCD_Plugin::ALLOWED_ROLE_META_CAP,
            'assign_terms' => WPCD_Plugin::ALLOWED_ROLE_META_CAP
        );

		/**
		 * Registers the taxonomy with WordPress.
		 *
		 * @since 1.0
		 */
		register_taxonomy( $taxonomy, array( $post_types ), $args );

	}

}
