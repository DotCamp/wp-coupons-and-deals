<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * When clicked this button inserts the coupon shortcode.
 *
 * @since 1.0
 */
function wpcd_shortcode_insert_button() {
	if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) { ?>
        <div class="wpcd_shortcode_insert-bt">
            <input type="button" id="coupon-submit" onclick="wpcd_couponInsert();"
                   class="button-primary" value="Insert Coupon Shortcode" name="submit"/>
        </div>
	<?php } else { ?>
        <div class="wpcd_shortcode_insert-bt">
            <input type="button" id="coupon-submit" onclick="wpcd_couponInsertFree();"
                   class="button-primary" value="Insert Coupon Shortcode" name="submit"/>
        </div>
	<?php }
}
