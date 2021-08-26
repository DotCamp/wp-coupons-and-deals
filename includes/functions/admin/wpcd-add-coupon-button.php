<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This adds the coupon inserter button.
 *
 * @since 1.0
 */
function wpcd_add_coupon_button() {

	?>
    <a class='thickbox button wpcd_button_link' id='wpcd_add_shortcode'
       title='<?php echo __( "Insert Coupon Shortcode", "wp-coupons-and-deals" ); ?>'
       href='#TB_inline?width=783&height=400&inlineId=wpcd_coupon_container'><span
                class="wpcd_icon"></span><?php echo __( 'Add Coupon', 'wp-coupons-and-deals' ); ?></a>

	<?php
}
