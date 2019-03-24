<?php
/**
 * Shortcode template two.
 *
 * @since 2.3
 */
if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
	include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}


global $coupon_id;
$title                     = get_the_title();
$description               = get_post_meta( $coupon_id, 'coupon_details_description', true );
$coupon_thumbnail          = wpcd_coupon_thumbnail_img( $coupon_id );
$coupon_type               = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$discount_text             = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$link                      = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code               = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$deal_text                 = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text         = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text           = get_option( 'wpcd_deal-hover-text' );
$button_class              = 'wpcd-btn-' . $coupon_id;
$no_expiry                 = get_option( 'wpcd_no-expiry-message' );
$expire_text               = get_option( 'wpcd_expire-text' );
$expired_text              = get_option( 'wpcd_expired-text' );
$hide_coupon_text          = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text  = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text          = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag          = get_option( 'wpcd_coupon-title-tag', 'h1' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$coupon_share              = get_option( 'wpcd_coupon-social-share' );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                     = date( 'd-m-Y' );
$time_now                  = time();
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expire_time               = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$never_expire              = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_template_six_theme   = get_post_meta( $coupon_id, 'coupon_details_template-six-theme', true );
$wpcd_dummy_coupong_img    = WPCD_Plugin::instance()->plugin_assets . 'assets/img/coupon-200x200.png';
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}
if( ! $link && WPCD_Amp::wpcd_amp_is() ) $link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
    $expire_date = date( $expireDateFormatFun, $expire_date );
} elseif ( ! empty( $expire_date ) ) {
    $expire_date = date( $expireDateFormatFun, strtotime( $expire_date ) );
}
$expire_date_format = date( "m/d/Y", strtotime( $expire_date ) );

$template = new WPCD_Template_Loader();

?>

<div class="wpcd-coupon-six" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
    <div class="wpcd-coupon-six-holder">
        <div class="wpcd-coupon-six-percent-off">
            <div class="wpcd-for-ribbon">
                <div class="wpcd-ribbon" style="background-color: <?php echo $wpcd_template_six_theme; ?>; border-color: <?php echo $wpcd_template_six_theme; ?>">
                    <div class="wpcd-ribbon-before"
                         style="border-left-color: <?php echo $wpcd_template_six_theme; ?>"></div>
                    <p class="wpcd-coupon-six-discount-text">
						<?php if ( ! empty( $discount_text ) ) {
							echo $discount_text;
						} else {
							echo __( 'Discount', 'wpcd-coupon' );
						} ?>
                    </p>
                    <div class="wpcd-ribbon-after"
                         style="border-right-color: <?php echo $wpcd_template_six_theme; ?>"></div>
                </div>
            </div>
        </div>
        <div class="wpcd-coupon-six-texts">
            <div class="texts">
            <?php
				if ( 'on' === $disable_coupon_title_link ) { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<?php echo $title; ?>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
			 	<?php } else { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<a href="<?php echo $link; ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
				<?php } 
			?>
                <div class="wpcd-coupon-description">
                    <span class="wpcd-full-description"><?php echo $description; ?></span>
                    <span class="wpcd-short-description"></span>
                    <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                        <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
                        <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="exp" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
                    <?php if( ! empty( trim( $expire_date ) ) && $never_expire != 'on' ) : ?>
                        <?php if( !WPCD_Amp::wpcd_amp_is() ) { ?>
                            <b>
                                <?php
                                if ( ! empty( $expire_text ) ) {
                                    echo $expire_text;
                                } else {
                                    echo __( 'Expires on: ', 'wpcd-coupon' );
                                }
                                ?>
                            </b>
                            <span class="wpcd-coupon-six-countdown" data-countdown_coupon="<?php echo $expire_date_format . ' ' . $expire_time; ?>" id="clock_six_<?php echo $coupon_id; ?>"></span>
                        <?php } else { 
                                if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                                    <span class="wpcd-coupon-expire">
                                        <?php
                                        if ( ! empty( $expire_text ) ) {
                                            echo $expire_text . ' ' . $expire_date;
                                        } else {
                                            echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date;
                                        }
                                        ?>
                                    </span>
                                <?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                                    <span class="wpcd-coupon-expired">
                                        <?php
                                        if ( ! empty( $expired_text ) ) {
                                            echo $expired_text . ' ' . $expire_date;
                                        } else {
                                            echo __( 'Expired on: ', 'wpcd-coupon' ) . $expire_date;
                                        }
                                        ?>
                                    </span>
                                <?php } ?>
                            <?php } ?>
                    <?php else : ?>

                        <?php if ( ! empty( $no_expiry ) ) : ?>
                            <b><?php echo $no_expiry; ?></b>
                        <?php else : ?>
                            <b><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></b>
                        <?php endif; ?>
                    <?php endif; ?> 
            </div>
        </div>
        <div class="wpcd-coupon-six-img-and-btn">
            <div class="item-img">
                <img src="<?php echo $coupon_thumbnail; ?>" alt="Coupon">
            </div>
            <div>
				<?php if ( $coupon_type === 'Coupon' ): ?>
					<?php if ( $hide_coupon === 'Yes' && ! WPCD_Amp::wpcd_amp_is() ): ?>
						<?php
						$template->get_template_part( 'hide-coupon2__premium_only' );
						?>
					<?php else: ?>
                        <div class="wpcd-coupon-code wpcd-btn-wrap">
                            <a class="wpcd-template-six-btn masterTooltip <?php echo $button_class; ?>" target="_blank" rel="nofollow"
                               href="<?php echo $link; ?>"
                               title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                                if ( ! empty( $coupon_hover_text ) ) {
                                                    echo $coupon_hover_text;
                                                } else {
                                                    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
                                                }
                                            }
                                        ?>"
                               data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
								   echo $coupon_code;
							   } else {
								   echo __( 'COUPONCODE', 'wpcd-coupon' );
							   } ?>" style="border-color: <?php echo $wpcd_template_six_theme; ?>; color: <?php echo $wpcd_template_six_theme; ?>">
                                <span class="coupon-code-button"><?php echo( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) ); ?></span>
                            </a>
                        </div>
					<?php endif; ?>
				<?php elseif ( $coupon_type === 'Deal' ): ?>
                    <div class="wpcd-deal-code wpcd-btn-wrap">
                        <a class="wpcd-template-six-btn masterTooltip" rel="nofollow" target="_blank" href="<?php echo $link; ?>"
                           title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
                           data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
                            							    echo $deal_text;
                            						    } else {
                            							    echo __( 'Claim This Deal', 'wpcd-coupon' );
                            						    } ?>" 
                           style="border-color: <?php echo $wpcd_template_six_theme; ?>; color: <?php echo $wpcd_template_six_theme; ?>">
		    			<span class="deal-code-button">
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
    <div class="clearfix"></div>
    <?php
    if( !WPCD_Amp::wpcd_amp_is() ):
        if ( $coupon_share === 'on' ) {
    	    $template->get_template_part('social-share');
        }
        $template->get_template_part('vote-system');
    endif;
    ?>
</div>