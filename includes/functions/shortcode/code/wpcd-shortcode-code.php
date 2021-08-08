<?php
// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds the Coupon Code.
 *
 * @since 1.4
 */
function wpcd_shortcode_code() {

	global $coupon_id;
	$coupon_id                = get_the_ID();
	$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
	$link                     = get_post_meta( $coupon_id, 'coupon_details_link', true );
	$coupon_code              = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
	$deal_text                = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
	$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
	$coupon_hover_text        = get_option( 'wpcd_coupon-hover-text' );
	$deal_hover_text          = get_option( 'wpcd_deal-hover-text' );
	$button_class             = '.wpcd-code-btn-' . $coupon_id;
	$hide_coupon_text         = get_option( 'wpcd_hidden-coupon-text' );
	$hidden_coupon_hover_text = get_option( 'wpcd_hidden-coupon-hover-text' );
	$copy_button_text         = get_option( 'wpcd_copy-button-text' );
	$hide_coupon              = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
	$hide_coupon_button_color = get_option( 'wpcd_hidden-coupon-button-color' );

	$wpcd_text_to_show = get_option( 'wpcd_text-to-show' );
	$wpcd_custom_text  = get_option( 'wpcd_custom-text' );
    
    $coupon_code               = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wp-coupons-and-deals' ) );
    $deal_text                 = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wp-coupons-and-deals' ) );

	if ( $wpcd_text_to_show == 'description' ) {
		$wpcd_custom_text = $description;
	} else {
		if ( empty( $wpcd_custom_text ) ) {
			$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wp-coupons-and-deals' );
		}
	}
	if ( $coupon_type == 'Coupon' ) {

		if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {

			if ( $hide_coupon == 'Yes' ) {

				$template = new WPCD_Template_Loader();
				$template->get_template_part( 'hide-coupon__premium_only' );

			} else { ?>

                <div class="wpcd-coupon-code">
                    <a rel="nofollow"
                       class="<?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                       title="<?php
					   if ( ! empty( $coupon_hover_text ) ) {
						   echo esc_attr( $coupon_hover_text );
					   } else {
						   echo __( "Click To Copy Coupon", 'wp-coupons-and-deals' );
					   }
					   ?>" href="<?php echo esc_url( $link ); ?>" target="_blank"
                       data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>">
                        <span class="wpcd_coupon_icon">
                            <img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png' )?>" style="width: 100%;height: 100%;" >
                        </span> <?php echo esc_html( $coupon_code ); ?>
                        <span id="coupon_code_<?php echo absint( $coupon_id ); ?>"
                              style="display:none;"><?php echo esc_html( $coupon_code ); ?></span>
                    </a>
                </div>

			<?php } ?>
            <script type="text/javascript">
				window.addEventListener('DOMContentLoaded', function() {
					var clip = new ClipboardJS('.wpcd-btn-<?php echo absint( $coupon_id ); ?>');
				});
            </script>
		<?php } else {
			?>
            <div class="wpcd-coupon-code">
                <a rel="nofollow"
                   class="<?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                   title="<?php
				   if ( ! empty( $coupon_hover_text ) ) {
					   echo esc_attr( $coupon_hover_text );
				   } else {
					   echo __( "Click To Copy Coupon", 'wp-coupons-and-deals' );
				   }
				   ?>" href="<?php echo esc_url( $link ); ?>" target="_blank"
                   data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>">
                    <span class="wpcd_coupon_icon">
                        <img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png')?>" style="width: 100%;height: 100%;" >
                    </span> <?php echo esc_html( $coupon_code ); ?>
                    <span id="coupon_code_<?php echo absint( $coupon_id ); ?>"
                          style="display:none;"><?php echo esc_html( $coupon_code ); ?></span>
                </a>
            </div>
			<script type="text/javascript">
				window.addEventListener('DOMContentLoaded', function() {
					var clip = new ClipboardJS('.wpcd-btn-<?php echo absint( $coupon_id ); ?>');
				});
            </script>
		<?php }
	} elseif ( $coupon_type == 'Deal' ) {
		?>
        <div class="wpcd-coupon-code">
            <a rel="nofollow" class="<?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> wpcd-btn masterTooltip wpcd-deal-button"
               title="<?php
			   if ( ! empty( $deal_hover_text ) ) {
				   echo esc_attr( $deal_hover_text );
			   } else {
				   echo __( "Click Here To Get This Deal", 'wp-coupons-and-deals' );
			   }
			   ?>" href="<?php echo esc_attr( $link ); ?>" target="_blank">
                <span class="wpcd_deal_icon">
                    <img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/deal-24.png' )?>" style="width: 100%;height: 100%;" >
                </span><?php echo esc_html( $deal_text ); ?>
            </a>
        </div>
	<?php } ?>


	<?php
}
