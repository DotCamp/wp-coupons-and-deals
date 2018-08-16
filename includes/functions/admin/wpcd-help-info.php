<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Little help text that is shown on the coupon inserter popup.
 *
 * @since 1.0
 */
function wpcd_help_info() { ?>

    <div>
        <i><?php echo __( 'From the list, select the coupon you want to insert then click on Insert Coupon Shortcode button. 	If you have not created any coupons,', 'wpcd-coupon' ); ?>
            <a href="<?php echo get_admin_url() . 'post-new.php?post_type=wpcd_coupons'; ?>" target="_blank">
				<?php echo __( 'create one', 'wpcd-coupon' ); ?>
            </a>
			<?php echo __( 'or', 'wpcd-coupon' ); ?>
            <a href="<?php echo get_admin_url() . 'edit.php?post_type=wpcd_coupons'; ?>" target="_blank">
				<?php echo __( 'manage your coupons', 'wpcd-coupon' ); ?>
            </a>.
        </i>

        <p><?php if ( wcad_fs()->is_not_paying() ) {
				echo '<a href="' . wcad_fs()->get_upgrade_url() . '">' .
				     __( 'Upgrade to Pro!', 'wp-coupons-and-deals' ) .
				     '</a>';
				echo __( ' to insert category, vendor, archive shortcodes, and many more features!', 'wpcd-coupon' );
			} ?></p>
    </div>

<?php }
