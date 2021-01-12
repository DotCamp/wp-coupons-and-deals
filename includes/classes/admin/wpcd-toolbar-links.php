<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPCD_Toolbar_Links
 *
 * Adds links to admin toolbar
 *
 * @since 2.0
 */
class WPCD_Toolbar_Links {

	/**
	 * WPCD_Toolbar_Links constructor.
	 *
	 * @since 2.0
	 */
	public function __construct() {

		if ( current_user_can( 'manage_options' ) ) {
			add_action( 'admin_bar_menu', array( $this, 'wpcd_toolbar_quick_menu' ), 333 );
		}

	}

	/**
	 * Toolbar quick menu.
	 *
	 * @param $wp_admin_bar
	 *
	 * @since 2.0
	 */
	public function wpcd_toolbar_quick_menu( $wp_admin_bar ) {

		$iconurl = WPCD_Plugin::instance()->plugin_assets . 'img/coupon24.png';

		$iconspan = '<span class="custom-icon" style="
                    float:left; width:24px !important; height:24px !important;
                     margin-left: 5px !important; margin-top: 5px !important; margin-right: 5px !important;
                     background-image:url(' . $iconurl . ');"></span>';

		$title = __( 'Coupons', 'wpcd-coupon' );

		$args = array(
			'id'    => 'wpcd_toolbar',
			'title' => $iconspan . $title,
			'href'  => admin_url() . 'edit.php?post_type=wpcd_coupons',
		);
		$wp_admin_bar->add_node( $args );

		$args = array(
			'id'     => 'wpcd_toolbar_coupons',
			'title'  => __( 'Coupons', 'wpcd-coupon' ),
			'href'   => admin_url() . 'edit.php?post_type=wpcd_coupons',
			'parent' => 'wpcd_toolbar'
		);
		$wp_admin_bar->add_node( $args );

		$args = array(
			'id'     => 'wpcd_toolbar_new',
			'title'  => __( 'Add New Coupon', 'wpcd-coupon' ),
			'href'   => admin_url() . 'post-new.php?post_type=wpcd_coupons',
			'parent' => 'wpcd_toolbar'
		);
		$wp_admin_bar->add_node( $args );

		$args = array(
			'id'     => 'wpcd_toolbar_categories',
			'title'  => __( 'Coupon Categories', 'wpcd-coupon' ),
			'href'   => admin_url() . 'edit-tags.php?taxonomy=wpcd_coupon_category&post_type=wpcd_coupons',
			'parent' => 'wpcd_toolbar'
		);
		$wp_admin_bar->add_node( $args );

        $args = array(
			'id'     => 'wpcd_toolbar_vendors',
			'title'  => __( 'Coupon Vendors', 'wpcd-coupon' ),
			'href'   => admin_url() . 'edit-tags.php?taxonomy=wpcd_coupon_vendor&post_type=wpcd_coupons',
			'parent' => 'wpcd_toolbar'
		);
		$wp_admin_bar->add_node( $args );

		$args = array(
			'id'     => 'wpcd_toolbar_settings',
			'title'  => __( 'Settings', 'wpcd-coupon' ),
			'href'   => admin_url() . 'edit.php?post_type=wpcd_coupons&page=wpcd_coupon_settings',
			'parent' => 'wpcd_toolbar'
		);
		$wp_admin_bar->add_node( $args );

		$args = array(
			'id'  	=> 'wpcd_toolbar_upgrade',
			'title' => __( 'Upgrade to Pro', 'wpcd-coupon' ),
			'href'  => wcad_fs()->get_upgrade_url(),
			'parent' => 'wpcd_toolbar'
		);

		if ( wcad_fs()->is_not_paying() ) {
			$wp_admin_bar->add_node( $args );
		}

		$import_args = array(
			'id'      => 'wpcd_toolbar_import',
			'title'   => __( 'Import Coupons', 'wpcd-coupon' ),
			'href'    => admin_url() . 'edit.php?post_type=wpcd_coupons&page=wpcd_coupon_import',
			'parent'  => 'wpcd_toolbar'
		);

		$wp_admin_bar->add_node( $import_args );

	}

}
