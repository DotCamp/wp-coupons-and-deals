<?php
/**
 * Shortcode template two.
 *
 * @since 2.3
 */

global $coupon_id;
$title                    = get_the_title();
$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
$coupon_thumbnail         = get_the_post_thumbnail_url( $coupon_id );
$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$discount_text            = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$link                     = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code              = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$deal_text                = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text        = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text          = get_option( 'wpcd_deal-hover-text' );
$button_class             = 'wpcd-btn-' . $coupon_id;
$no_expiry                = get_option( 'wpcd_no-expiry-message' );
$expire_text              = get_option( 'wpcd_expire-text' );
$expired_text             = get_option( 'wpcd_expired-text' );
$hide_coupon_text         = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text         = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag         = get_option( 'wpcd_coupon-title-tag', 'h1' );
$show_expiration          = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                    = date( 'd-m-Y' );
$time_now                 = time();
$expire_date              = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expire_time              = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$expire_date_format       = date( 'm/d/Y', strtotime( $expire_date ) );
$never_expire             = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$hide_coupon              = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_template_six_theme  = get_post_meta( $coupon_id, 'coupon_details_template-six-theme', true );
$wpcd_dummy_coupon_img   = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';

$wpcd_text_to_show = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text  = get_option( 'wpcd_custom-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}
?>

<div class="wpcd-coupon-six" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
    <div class="wpcd-coupon-six-holder">
        <div class="wpcd-coupon-six-percent-off">
            <div class="wpcd-for-ribbon">
                <div class="wpcd-ribbon" style="background-color: <?php echo $wpcd_template_six_theme; ?>">
                    <div class="wpcd-ribbon-before"
                         style="border-left-color: <?php echo $wpcd_template_six_theme; ?>"></div>
                    <p class="wpcd-coupon-six-discount-text">
						<?php if ( ! empty( $discount_text ) ) {
							echo $discount_text;
						} else {
							echo __( '70% OFF', 'wpcd-coupon' );
						} ?>
                    </p>
                    <div class="wpcd-ribbon-after"
                         style="border-right-color: <?php echo $wpcd_template_six_theme; ?>"></div>
                </div>
            </div>
        </div>
        <div class="wpcd-coupon-six-texts">
            <div class="texts">
                <<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-widget-title">
                    <a href="<?php echo $link; ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
                </<?php echo esc_html( $coupon_title_tag ); ?>>
                <div class="wpcd-coupon-description">
                    <span class="wpcd-full-description"><?php echo $description; ?></span>
                    <span class="wpcd-short-description"></span>
                    <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
                    <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
                </div>
            </div>
            <div class="exp" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
                <p>
					<?php if( ! empty( trim( $expire_date ) ) && $never_expire != 'on' ) : ?>
						<b>
							<?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' );
							}
							?>
                                                    <span class="wpcd-coupon-six-countdown clock_six_<?php echo $coupon_id; ?>"></span>
						</b> 
					<?php else : ?>
						<?php if ( ! empty( $no_expiry ) ) : ?>
							<b><?php echo $no_expiry; ?></b>
						<?php else : ?>
							<b><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></b>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( $expire_date ) : ?>
                        <script type="text/javascript">
                            if (jQuery('.clock_six_<?php echo $coupon_id; ?>').length === 1) {
                                var clockClass = '.clock_six_<?php echo $coupon_id; ?>';
                                var $clock2 = jQuery('.clock_six_<?php echo $coupon_id; ?>').countdown('<?php echo $expire_date_format . ' ' . $expire_time; ?>', function (event) {
                                    var format = '%M <?php echo __( 'minutes', 'wpcd-coupon' ); ?> %S <?php echo __( 'seconds', 'wpcd-coupon' ); ?>';
                                    if (event.offset.hours > 0) {
                                        format = "%H <?php echo __( 'hours', 'wpcd-coupon' ); ?> %M <?php echo __( 'minutes', 'wpcd-coupon' ); ?> %S <?php echo __( 'seconds', 'wpcd-coupon' ); ?>";
                                    }
                                    if (event.offset.totalDays > 0) {
                                        format = "%-d <?php echo __( 'day', 'wpcd-coupon' ); ?>%!d " + format;
                                    }
                                    if (event.offset.weeks > 0) {
                                        format = "%-w <?php echo __( 'week', 'wpcd-coupon' ); ?>%!w " + format;
                                    }
                                    jQuery(clockClass).html(event.strftime(format));

                                    if (event.offset.weeks == 0 && event.offset.totalDays == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds == 0) {
                                        jQuery(clockClass).addClass('wpcd-countdown-expired').html('<?php echo __( 'This offer has expired!', 'wpcd-coupon' ); ?>');
                                    } else {
                                        jQuery(clockClass).html(event.strftime(format));
                                        jQuery('.clock_six_<?php echo $coupon_id; ?>').removeClass('wpcd-countdown-expired');
                                    }
                                });
                            }

                            jQuery("#expire-time").change(function () {
                                jQuery('.clock_six_<?php echo $coupon_id; ?>').show();
                                var coup_date = jQuery("#expire-date").val();
                                if (coup_date.indexOf("-") >= 0) {
                                    var dateAr = coup_date.split('-');
                                    coup_date = dateAr[1] + '/' + dateAr[0] + '/' + dateAr[2];
                                }
                                selectedDate = coup_date + ' ' + jQuery("#expire-time").val();
                                $clock2.countdown(selectedDate.toString());
                            });
                        </script>
					<?php endif; ?>
                </p>
            </div>
        </div>
        <div class="wpcd-coupon-six-img-and-btn">
            <div class="item-img">
                <img src="<?php echo empty( $coupon_thumbnail ) ? $wpcd_dummy_coupon_img : $coupon_thumbnail; ?>"
                     alt="Coupon">
            </div>
            <div>
				<?php if ( $coupon_type === 'Coupon' ): ?>
					<?php if ( $hide_coupon === 'Yes' ): ?>
						<?php 
						$template = new WPCD_Template_Loader();
						$template->get_template_part( 'hide-coupon2__premium_only' );
						?>
					<?php else: ?>
                        <div class="wpcd-coupon-code wpcd-btn-wrap">
                            <a class="wpcd-template-six-btn masterTooltip <?php echo $button_class; ?>" target="_blank"
                               href="<?php echo $link; ?>"
                               title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
                               data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
								   echo $coupon_code;
							   } else {
								   echo __( 'COUPONCODE', 'wpcd-coupon' );
							   } ?>" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
                                <span class="coupon-code-button"
                                      style="border-color: <?php echo $wpcd_template_six_theme; ?>; color: <?php echo $wpcd_template_six_theme; ?>"><?php echo( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) ); ?></span>
                            </a>
                        </div>
					<?php endif; ?>
				<?php elseif ( $coupon_type === 'Deal' ): ?>
                    <div class="wpcd-deal-code wpcd-btn-wrap">
                        <a class="wpcd-template-six-btn masterTooltip" target="_blank" href="<?php echo $link; ?>"
                           title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
                           data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
							   echo $deal_text;
						   } else {
							   echo __( 'Claim This Deal', 'wpcd-coupon' );
						   } ?>" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
		    			<span class="deal-code-button"
                              style="border-color: <?php echo $wpcd_template_six_theme; ?>;color: <?php echo $wpcd_template_six_theme; ?>">
		    				<?php if ( ! empty( $deal_text ) ) {
							    echo $deal_text;
						    } else {
							    echo __( 'Claim This Deal', 'wpcd-coupon' );
						    } ?>
		    			</span>
                        </a>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var clip = new Clipboard('.<?php echo $button_class; ?>');
    </script>
</div>