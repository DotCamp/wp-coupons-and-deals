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
$link_thumbnail            = get_option('wpcd_coupon-link-featured-img'); 
$coupon_type               = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$discount_text             = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$link                      = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code               = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$show_print_links          = get_option( 'wpcd_coupon-print-link' );
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

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else if ( empty( $wpcd_custom_text ) ) {
	$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wp-coupons-and-deals' );
}
if( ! $link && WPCD_Amp::wpcd_amp_is() ) $link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
    $expire_date = date( $expireDateFormatFun, $expire_date );
}
$expire_date_format = date( "m/d/Y", strtotime( $expire_date ) );

$template = new WPCD_Template_Loader();

$wpcd_uniq_attr = '';
$wpcd_uniq_attr_data = '';
if( function_exists( 'wpcd_uniq_attr' ) && ! WPCD_Amp::wpcd_amp_is() &&
    ! empty( $show_print_links ) && $show_print_links == 'on' ) {
    $wpcd_uniq_attr = wpcd_uniq_attr( 10 );
    $wpcd_uniq_attr_data = 'data-unic-attr="' . esc_attr( $wpcd_uniq_attr ) . '"';
}
?>

<div class="wpcd-coupon-six wpcd-coupon-id-<?php echo absint( $coupon_id ); ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>" <?php echo $wpcd_uniq_attr_data;?>>
    <div class="wpcd-coupon-six-holder">
        <div class="wpcd-coupon-six-percent-off">
            <div class="wpcd-for-ribbon">
                <div class="wpcd-ribbon" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>; border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>">
                    <div class="wpcd-ribbon-before"
                         style="border-left-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>"></div>
                    <p class="wpcd-coupon-six-discount-text">
						<?php if ( ! empty( $discount_text ) ) {
							echo esc_html( $discount_text );
						} else {
							echo __( 'Discount', 'wp-coupons-and-deals' );
						} ?>
                    </p>
                    <div class="wpcd-ribbon-after"
                         style="border-right-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>"></div>
                </div>
            </div>
        </div>
        <div class="wpcd-coupon-six-texts">
            <div class="texts">
            <?php
				if ( 'on' === $disable_coupon_title_link ) { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<?php echo esc_html( $title ); ?>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
			 	<?php } else { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<a href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" rel="nofollow"><?php echo esc_html( $title ); ?></a>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
				<?php } 
			?>
                <div class="wpcd-coupon-description">
                    <span class="wpcd-full-description"><?php echo wp_kses_post( $description ); ?></span>
                    <span class="wpcd-short-description"></span>
                    <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                        <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wp-coupons-and-deals' ); ?></a>
                        <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wp-coupons-and-deals' ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="exp" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>">
                    <?php if( ! empty( trim( $expire_date ) ) && $never_expire != 'on' ) : ?>
                        <?php if( !WPCD_Amp::wpcd_amp_is() ) { ?>
                            <b>
                                <?php
                                    echo ( $expire_text ? esc_html( $expire_text ) : __( 'Expires on: ', 'wp-coupons-and-deals' ) );
                                ?>
                            </b>
                            <span class="wpcd-coupon-six-countdown" data-countdown_coupon="<?php echo strtotime( $expire_date_format . ' ' . $expire_time ) ? ($expire_date_format . ' ' . $expire_time) : ''; ?>" id="clock_six_<?php echo absint( $coupon_id ); ?>"></span>
                        <?php } else { 
                                if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                                    <span class="wpcd-coupon-expire">
                                        <?php
                                            echo ( $expire_text ? esc_html( $expire_text ) : __( 'Expires on:', 'wp-coupons-and-deals' ) ) . ' ' .
                                            date( $expireDateFormatFun, strtotime( $expire_date ) );
                                        ?>
                                    </span>
                                <?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                                    <span class="wpcd-coupon-expired">
                                        <?php
                                            echo ( $expired_text ? esc_html( $expired_text ) : __( 'Expired on:', 'wp-coupons-and-deals' ) ) . ' ' .
                                            date( $expireDateFormatFun, strtotime( $expire_date ) );
                                        ?>
                                    </span>
                                <?php } ?>
                            <?php } ?>
                    <?php else : ?>
                        <b>
							<?php
								echo $no_expiry ? esc_html( $no_expiry ) : __( "Doesn't expire", 'wp-coupons-and-deals' );
							?>
						</b>
                    <?php endif; ?> 
            </div>
        </div>
        <div class="wpcd-coupon-six-img-and-btn">
            <div class="item-img">
                <?php
                if ($link_thumbnail == "on"):
                    echo "<a href='" . esc_url( $link ) . "' target='" . esc_attr( $target ) . "'><img src='" . esc_url( $coupon_thumbnail ) . "' alt='Coupon'></a>";
                else:
                    echo "<img src='" . esc_url( $coupon_thumbnail ) . "' alt='Coupon'>";
                endif;
                ?>
            </div>
            <div>
				<?php if ( $coupon_type === 'Coupon' ): ?>
					<?php if ( $hide_coupon === 'Yes' && ! WPCD_Amp::wpcd_amp_is() ): ?>
						<?php
						$template->get_template_part( 'hide-coupon2__premium_only' );
						?>
					<?php else: ?>
                        <div class="wpcd-coupon-code wpcd-btn-wrap">
                            <a class="wpcd-template-six-btn masterTooltip <?php echo esc_attr( $button_class ); ?>" target="<?php echo esc_attr( $target ); ?>" rel="nofollow"
                               href="<?php echo esc_url( $link ); ?>"
                               title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                                if ( ! empty( $coupon_hover_text ) ) {
                                                    echo esc_attr( $coupon_hover_text );
                                                } else {
                                                    echo __( "Click To Copy Coupon", 'wp-coupons-and-deals' );
                                                }
                                            }
                                        ?>"
                               data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
								   echo esc_attr( $coupon_code );
							   } else {
								   echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
							   } ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>; color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>">
                                <span class="coupon-code-button"><?php echo( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wp-coupons-and-deals' ) ); ?></span>
                            </a>
                        </div>
					<?php endif; ?>
				<?php elseif ( $coupon_type === 'Deal' ): ?>
                    <div class="wpcd-deal-code wpcd-btn-wrap">
                        <a class="wpcd-template-six-btn masterTooltip" rel="nofollow" target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $link ); ?>"
                           title="<?php echo __( 'Click Here To Get this deal', 'wp-coupons-and-deals' ); ?>"
                           data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
                            							    echo esc_html( $deal_text );
                            						    } else {
                            							    echo __( 'Claim This Deal', 'wp-coupons-and-deals' );
                            						    } ?>" 
                           style="border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>; color: <?php echo sanitize_Hex_color( $wpcd_template_six_theme ); ?>">
		    			<span class="deal-code-button">
		    				<?php if ( ! empty( $deal_text ) ) {
							    echo esc_html( $deal_text );
						    } else {
							    echo __( 'Claim This Deal', 'wp-coupons-and-deals' );
						    } ?>
		    			</span>
                        </a>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
		window.addEventListener('DOMContentLoaded', function() {
			var clip = new ClipboardJS('.<?php echo esc_attr( $button_class ); ?>');
		});
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

<?php
    if( ! WPCD_Amp::wpcd_amp_is() && ! empty( $show_print_links ) && $show_print_links == 'on') {
        wpcd_coupon_print_link( $wpcd_uniq_attr );
    }
?>