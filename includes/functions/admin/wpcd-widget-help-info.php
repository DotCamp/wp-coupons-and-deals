<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Little help text that is shown on the coupon widget admin.
 *
 * @since 1.2
 */
function wpcd_widget_help_info() { ?>

    <div class="wpcd_widget_help_info">
        <p><?php _e( 'From the list, select the coupon you want to show on the widget and click on the Save button. 	If you have not created any coupons,', 'wpcd-coupon' ); ?>
            <a href="<?php echo get_admin_url() . 'post-new.php?post_type=wpcd_coupons'; ?>" target="_blank">
				<?php _e( 'create one', 'wpcd-coupon' ); ?>
            </a>
            or
            <a href="<?php echo get_admin_url() . 'edit.php?post_type=wpcd_coupons'; ?>" target="_blank">
				<?php _e( 'manage your coupons', 'wpcd-coupon' ); ?>
            </a>.
        </p>

    </div>

<?php }
