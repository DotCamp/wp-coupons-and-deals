<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/25/17
 * Time: 11:31 PM
 */
if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
	include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id, $parent, $max_num_page;
$title                     = get_the_title();
$link                      = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code               = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$coupon_thumbnail          = wpcd_coupon_thumbnail_img( $coupon_id );
$link_thumbnail            = get_option('wpcd_coupon-link-featured-img'); 
$discount_text             = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type               = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$description               = get_post_meta( $coupon_id, 'coupon_details_description', true );
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
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$expire_time               = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$never_expire              = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_coupon_image_id      = get_post_meta( $coupon_id, 'coupon_details_coupon-image-input', true );
$wpcd_coupon_image_src     = wp_get_attachment_image_src( $wpcd_coupon_image_id, 'full' );
$wpcd_show_print           = get_post_meta( $coupon_id, 'coupon_details_coupon-image-print', true );
$wpcd_image_width          = get_post_meta( $coupon_id, 'coupon_details_coupon-image-width', true );
$wpcd_image_height         = get_post_meta( $coupon_id, 'coupon_details_coupon-image-height', true );
$template                  = new WPCD_Template_Loader();

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ( is_array( $wpcd_coupon_image_src ) ) {
	$wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
	$wpcd_coupon_image_src = '';
}

$wpcd_coupon_template     = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
$wpcd_template_five_theme = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true );
$wpcd_template_six_theme  = get_post_meta( $coupon_id, 'coupon_details_template-six-theme', true );
$wpcd_dummy_coupon_img    = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';

$wpcd_text_to_show = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text  = get_option( 'wpcd_custom-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else if ( empty( $wpcd_custom_text ) ) {
	$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wp-coupons-and-deals' );
}
if( ! $link && WPCD_Amp::wpcd_amp_is() ) $link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
    $expire_date = date( $expireDateFormatFun, $expire_date );
} elseif ( ! empty( $expire_date ) ) {
    $expire_date = date( $expireDateFormatFun, strtotime( $expire_date ) );
}
$expire_date_format = date( "m/d/Y", strtotime( $expire_date ) );

$coupon_code = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wp-coupons-and-deals' ) );
$deal_text = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wp-coupons-and-deals' ) );
$coupon_hover_text = ( ! empty( $coupon_hover_text ) ) ? $coupon_hover_text : __( 'Click To Copy Coupon', 'wp-coupons-and-deals' );
$deal_hover_text = ( !empty( $deal_hover_text ) ) ? $deal_hover_text : __( 'Click Here To Get This Deal' );

include('header-category__premium_only.php');
?>
<?php
$wpcd_uniq_attr = '';
if( $coupon_type !== 'Image' && function_exists( 'wpcd_uniq_attr' ) && ! WPCD_Amp::wpcd_amp_is() &&
    ! empty( $show_print_links ) && $show_print_links == 'on' ) {
    $wpcd_uniq_attr = wpcd_uniq_attr( 10 );
}
?>
<?php if ( $coupon_type === 'Image' ): ?>
<?php 
    include('coupon_type__image.php'); 
    if ( WPCD_Amp::wpcd_amp_is() ) {
        WPCD_Amp::instance()->setCss( 'shortcode_image' );
    } 
?>
<?php elseif ( $wpcd_coupon_template === 'Template Five' ): ?>
    <!-- Template Five -->
        <div class="wpcd-template-five wpcd-coupon-id-<?php echo absint( $coupon_id ); ?> wpcd_item" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>" <?php echo $wpcd_uniq_attr ? 'data-unic-attr="' . esc_attr( $wpcd_uniq_attr ) . '"' : '';?>>
            <div class="wpcd-template-five-holder">
                <div class="wpcd-template-five-percent-off">
                    <p class="wpcd-coupon-five-discount-text">
                        <?php echo $discount_text ? esc_html($discount_text) : __( 'Discount Text', 'wp-coupons-and-deals' ); ?>
                    </p>
                </div>
                <div class="wpcd-template-five-pro-img">
                    <?php
                        if ($link_thumbnail == "on"):
                            echo "<a href='" . esc_url( $link) . "' rel='nofollow' target='" . esc_attr( $target ) . "'><img src='" . esc_url( $coupon_thumbnail ) . "' alt='" . esc_attr( $title ) . "'>";
                        else:
                            echo "<img src='" . esc_url( $coupon_thumbnail ) . "' alt='" . esc_attr( $title ) . "'>";
                        endif;
                     ?>
                </div>

                <div class="wpcd-template-five-texts">
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
            </div>

            <div class="extra-wpcd-template-five-holder">
                <div class="wpcd-template-five-exp" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>">
                    <!-- <p>Expires On: 12/31/17</p> -->
					<?php
					if ( $show_expiration !== 'Hide' ) { ?>
                        <div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
                            <div class="wpcd-coupon-five-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
                                <p class="wpcd-coupon-five-expire-text"><?php
                                    echo ( $expire_text ? esc_html( $expire_text ) : __( 'Expires on:', 'wp-coupons-and-deals' ) ) . ' ' .
                                        '<span class="expiration-date">' . date( $expireDateFormatFun, strtotime( $expire_date ) ) . '</span>';
									?></p>
                            </div>
                            <div class="wpcd-coupon-five-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
                                <p class="wpcd-coupon-five-expired">
									<?php
                                    echo ( $expired_text ? esc_html( $expired_text ) : __( 'Expired on:', 'wp-coupons-and-deals' ) ) . ' ' .
                                        '<span class="expiration-date">' . date( $expireDateFormatFun, strtotime( $expire_date ) ) . '</span>';
									?>
                                </p>
                            </div>
                        </div>
                        <div class="wpcd-coupon-five-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
                            <p>
                                <?php
                                echo $no_expiry ? esc_html( $no_expiry ) : __( "Doesn't expire", 'wp-coupons-and-deals' );
                                ?>
                            </p>
                        </div>
						<?php
					} else {
						echo '';
					}
					?>
                </div>
				<?php if ( $coupon_type == 'Coupon' ): ?>
					<?php if ( $hide_coupon === 'Yes'  && ! WPCD_Amp::wpcd_amp_is() ): ?>
						<?php
						$template->get_template_part( 'hide-coupon2__premium_only' );
						?>
					<?php else: ?>
                        <div class="wpcd-coupon-code">
                            <a class="wpcd-template-five-btn masterTooltip <?php echo esc_attr( $button_class ); ?>"
                               href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
                               title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                                echo esc_attr( $coupon_hover_text );
                                            }
                                        ?>"
                               data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
								   echo esc_attr( $coupon_code );
							   } else {
								   echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
							   } ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>">
                                <p class="coupon-code-button"
                                   style="color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>"><?php echo( ! empty( $coupon_code ) ? esc_html( $coupon_code ) : __( 'COUPONCODE', 'wp-coupons-and-deals' ) ); ?></p>
                            </a>
                        </div>
					<?php endif; ?>
				<?php elseif ( $coupon_type == 'Deal' ): ?>
                    <div class="wpcd-deal-code">
                        <a class="wpcd-template-five-btn masterTooltip" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
                           title="<?php echo __( 'Click Here To Get this deal', 'wp-coupons-and-deals' ); ?>"
                           data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
							   echo esc_attr( $deal_text );
						   } else {
							   echo __( 'Claim This Deal', 'wp-coupons-and-deals' );
						   } ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>">
                            <p class="deal-code-button" style="color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>">
								<?php if ( ! empty( $deal_text ) ) {
									echo esc_html( $deal_text );
								} else {
									echo __( 'Claim This Deal', 'wp-coupons-and-deals' );
								} ?>
                            </p>
                        </a>
                    </div>
				<?php else: ?>

				<?php endif; ?>

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
	<?php elseif ( $wpcd_coupon_template === 'Template Six' ): ?>
        <!-- Template Six -->
        <div class="wpcd-coupon-six wpcd-coupon-id-<?php echo absint( $coupon_id ); ?> wpcd_item" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>" <?php echo $wpcd_uniq_attr ? 'data-unic-attr="' . esc_attr( $wpcd_uniq_attr ) . '"' : '';?>>
            <div class="wpcd-coupon-six-holder">
                <div class="wpcd-coupon-six-percent-off">
                    <div class="wpcd-for-ribbon">
                        <div class="wpcd-ribbon" style="background-color: <?php echo sanitize_hex_color ( $wpcd_template_six_theme ); ?>; border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>">
                            <div class="wpcd-ribbon-before"
                                 style="border-left-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>"></div>
                            <p class="wpcd-coupon-six-discount-text">
								<?php if ( ! empty( $discount_text ) ) {
									echo esc_html( $discount_text );
								} else {
									echo __( '70% OFF', 'wp-coupons-and-deals' );
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
                                        echo $expire_text ? esc_html( $expire_text ) : __( 'Expires on: ', 'wp-coupons-and-deals' );
                                    ?>
                                </b> <span class="wpcd-coupon-six-countdown clock_six_<?php echo absint( $coupon_id ); ?>"></span>
                                <?php if ( $expire_date ) : ?>
                                    <script type="text/javascript">
                                        if (jQuery('.clock_six_<?php echo absint( $coupon_id ); ?>').length === 1) {
                                            var clockClass = '.clock_six_<?php echo absint( $coupon_id ); ?>';
                                            var $clock2 = jQuery('.clock_six_<?php echo absint( $coupon_id ); ?>').countdown('<?php echo strtotime( $expire_date_format . ' ' . $expire_time ) ? ($expire_date_format . ' ' . $expire_time ) : ''; ?>', function (event) {
                                                var format = '%M <?php echo __( 'minutes', 'wp-coupons-and-deals' ); ?> %S <?php echo __( 'seconds', 'wp-coupons-and-deals' ); ?>';
                                                if (event.offset.hours > 0) {
                                                    format = "%H <?php echo __( 'hours', 'wp-coupons-and-deals' ); ?> %M <?php echo __( 'minutes', 'wp-coupons-and-deals' ); ?> %S <?php echo __( 'seconds', 'wp-coupons-and-deals' ); ?>";
                                                }
                                                if (event.offset.totalDays > 0) {
                                                    format = "%-d <?php echo __( 'day', 'wp-coupons-and-deals' ); ?>%!d " + format;
                                                }
                                                if (event.offset.weeks > 0) {
                                                    format = "%-w <?php echo __( 'week', 'wp-coupons-and-deals' ); ?>%!w " + format;
                                                }
                                                jQuery(clockClass).html(event.strftime(format));

                                                if (event.offset.weeks == 0 && event.offset.totalDays == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds == 0) {
                                                    jQuery(clockClass).addClass('wpcd-countdown-expired').html('<?php echo __( 'This offer has expired!', 'wp-coupons-and-deals' ); ?>');
                                                } else {
                                                    jQuery(clockClass).html(event.strftime(format));
                                                    jQuery('.clock_six_<?php echo absint( $coupon_id ); ?>').removeClass('wpcd-countdown-expired');
                                                }
                                            });
                                        }

                                        jQuery("#expire-time").change(function () {
                                            jQuery('.clock_six_<?php echo absint( $coupon_id ); ?>').show();
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
                                <?php echo $no_expiry ? esc_html( $no_expiry ) : __( "Doesn't expire", 'wp-coupons-and-deals' ); ?>
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
							<?php if ( $hide_coupon === 'Yes'  && ! WPCD_Amp::wpcd_amp_is()): ?>
								<?php
								$template = new WPCD_Template_Loader();
								$template->get_template_part( 'hide-coupon2__premium_only' );
								?>
							<?php else: ?>
                                <div class="wpcd-coupon-code wpcd-btn-wrap">
                                    <a class="wpcd-template-six-btn masterTooltip <?php echo esc_attr( $button_class ); ?>"
                                       target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $link ); ?>"
                                       title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                                        echo esc_attr( $coupon_hover_text );
                                                    }
                                                ?>"
                                       data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
										   echo esc_attr( $coupon_code );
									   } else {
										   echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
									   } ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>; color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>">
                                        <span class="coupon-code-button"><?php echo( ! empty( $coupon_code ) ? esc_attr( $coupon_code ) : __( 'COUPONCODE', 'wp-coupons-and-deals' ) ); ?></span>
                                    </a>
                                </div>
							<?php endif; ?>
						<?php elseif ( $coupon_type === 'Deal' ): ?>
                            <div class="wpcd-deal-code wpcd-btn-wrap">
                                <a class="wpcd-template-six-btn masterTooltip" target="<?php echo esc_url( $target ); ?>"
                                   href="<?php echo esc_url( $link ); ?>"
                                   title="<?php echo __( 'Click Here To Get this deal', 'wp-coupons-and-deals' ); ?>"
                                   data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
									   echo esc_attr( $deal_text );
								   } else {
									   echo __( 'Claim This Deal', 'wp-coupons-and-deals' );
								   } ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>; color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>">
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
	<?php else: ?>
        <div class="wpcd-coupon wpcd-coupon-default wpcd-coupon-id-<?php echo absint( $coupon_id ); ?> wpcd_item" <?php echo $wpcd_uniq_attr ? 'data-unic-attr="' . esc_attr( $wpcd_uniq_attr ) . '"' : '';?>>
            <div class="wpcd-col-1-8">
                <div class="wpcd-coupon-discount-text">
					<?php echo str_replace( " ", "<br>", esc_html( $discount_text ) ); ?>
                </div>
				<?php if ( $coupon_type == 'Coupon' ) { ?>
                    <div class="coupon-type">
						<?php echo __( 'Coupon', 'wp-coupons-and-deals' ) ?>
                    </div>
				<?php } elseif ( $coupon_type == 'Deal' ) { ?>
                    <div class="deal-type">
						<?php echo __( 'Deal', 'wp-coupons-and-deals' ); ?>
                    </div>
				<?php } ?>
            </div>
            <div class="wpcd-coupon-content wpcd-col-7-8">
                <div class="wpcd-coupon-header">
                    <div class="wpcd-col-3-4">
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
                    </div>
                    <div class="wpcd-col-1-4">
						<?php if ( $coupon_type == 'Coupon' ) {
						if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {

    						if ( $hide_coupon == 'Yes'  && ! WPCD_Amp::wpcd_amp_is() ) {

    							$template = new WPCD_Template_Loader();

    							$template->get_template_part( 'hide-coupon__premium_only' );

    						} else { ?>
                                <div class="wpcd-coupon-code">
                                    <a rel="nofollow"
                                       class="<?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                                       title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                                        echo esc_attr( $coupon_hover_text );
                                                    }
                                                ?>" 
                                       href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
                                       data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>">
                                        <span class="wpcd_coupon_icon">
                                            <img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png' ) ?>" style="width: 100%;height: 100%;" >
                                        </span>

                                        <?php echo esc_html( $coupon_code ); ?>
                                    </a>
                                </div>
    						<?php }
						} else { ?>
                            <div class="wpcd-coupon-code">
                                <a rel="nofollow"
                                   class="<?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                                   title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                                    echo esc_attr( $coupon_hover_text );
                                                }
                                            ?>" 
                                   href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
                                   data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>">
                                    <span class="wpcd_coupon_icon">
                                        <img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png') ?>" style="width: 100%;height: 100%;" >
                                    </span>

                                    <?php echo esc_html( $coupon_code ); ?>
                                </a>
                            </div>
						<?php } ?>
                            <script type="text/javascript">
                                window.addEventListener('DOMContentLoaded', function() {
                                    var clip = new ClipboardJS('.wpcd-btn-<?php echo absint( $coupon_id ); ?>');
                                });
                            </script>
						<?php } elseif ( $coupon_type == 'Deal' ) { ?>
                            <div class="wpcd-coupon-code">
                                <a rel="nofollow"
                                   class="<?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> wpcd-btn masterTooltip wpcd-deal-button"
                                   title="<?php if ( ! empty( $deal_hover_text ) ) {
									   echo esc_attr( $deal_hover_text );
								   } else {
									   echo __( "Click Here To Get This Deal", 'wp-coupons-and-deals' );
								   } ?>" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
                                    <span class="wpcd_deal_icon">
                                        <img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/deal-24.png' )?>" style="width: 100%;height: 100%;" >
                                    </span><?php echo esc_html( $deal_text ); ?>
                                </a>
                            </div>
						<?php } elseif ( $coupon_type == 'Deal' ) { ?>
                            <div class="wpcd-coupon-code">
                                <a rel="nofollow"
                                   class="<?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> wpcd-btn masterTooltip wpcd-deal-button"
                                   title="<?php if ( ! empty( $deal_hover_text ) ) {
									   echo esc_attr( $deal_hover_text );
								   } else {
									   echo __( "Click Here To Get This Deal", 'wp-coupons-and-deals' );
								   } ?>" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
                                    <span class="wpcd_deal_icon">
                                        <img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/deal-24.png' ) ?>" style="width: 100%;height: 100%;" >
                                    </span><?php echo esc_html( $deal_text ); ?>
                                </a>
                            </div>
						<?php } ?>
                    </div>
                </div>
                <div class="wpcd-extra-content">
                    <div class="wpcd-col-3-4">
                        <div class="wpcd-coupon-description">
                            <span class="wpcd-full-description"><?php echo wp_kses_post( $description ); ?></span>
                            <span class="wpcd-short-description"></span>
                            <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                                <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wp-coupons-and-deals' ); ?></a>
                                <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wp-coupons-and-deals' ); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="wpcd-col-1-4">
						<?php
						if ( $coupon_type == 'Coupon' ) {
							if ( $show_expiration == 'Show' ) {
                                                            $never_expire = ($wpcd_coupon_template == 'Template Two')
                                                                          ? $never_expire: '';
								if ( ! empty( $expire_date )  && $never_expire != 'on') {
									if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                                        <div class="wpcd-coupon-expire">
                                            <?php
                                                echo ( $expire_text ? esc_html( $expire_text ) : __( 'Expires on:', 'wp-coupons-and-deals' ) ) . ' ' .
                                                date( $expireDateFormatFun, strtotime( $expire_date ) );
                                            ?>
                                        </div>
									<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                                        <div class="wpcd-coupon-expired">
                                            <?php
                                                echo ( $expired_text ? esc_html( $expired_text ) : __( 'Expired on:', 'wp-coupons-and-deals' ) ) . ' ' .
                                                date( $expireDateFormatFun, strtotime( $expire_date ) );
                                            ?>
                                        </div>
									<?php }
								} else { ?>
                                    <div class="wpcd-coupon-expire">
										<?php
                                            echo $no_expiry ? esc_html( $no_expiry ) : __( "Doesn't expire", 'wp-coupons-and-deals' );
                                        ?>
                                    </div>
								<?php }
							} else {
								echo '';
							}

						} elseif ( $coupon_type == 'Deal' ) {
							if ( $show_expiration == 'Show' ) {
                                                                  $never_expire = ($wpcd_coupon_template == 'Template Two')
                                                                  ? $never_expire: '';
							if ( ! empty( $expire_date )  && $never_expire != 'on') {
									if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                                        <div class="wpcd-coupon-expire">
											<?php
                                                echo ( $expire_text ? esc_html( $expire_text ) : __( 'Expires on:', 'wp-coupons-and-deals' ) ) . ' ' .
                                                date( $expireDateFormatFun, strtotime( $expire_date ) );
											?>
                                        </div>
									<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                                        <div class="wpcd-coupon-expired">
											<?php
                                                echo ( $expired_text ? esc_html( $expired_text ) : __( 'Expired on:', 'wp-coupons-and-deals' ) ) . ' ' .
                                                date( $expireDateFormatFun, strtotime( $expire_date ) );
											?>
                                        </div>
									<?php }

								} else { ?>

                                    <div class="wpcd-coupon-expire">
										<?php
                                            echo $no_expiry ? esc_html( $no_expiry ) : __( "Doesn't expire", 'wp-coupons-and-deals' );
										?>
                                    </div>

								<?php }
							} else {
								echo '';
							}
						} ?>
                    </div>
                </div>
            </div>
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
	<?php endif; ?>
    <?php
        if( ! WPCD_Amp::wpcd_amp_is() && ! empty( $show_print_links ) && $show_print_links == 'on') {
            wpcd_coupon_print_link( $wpcd_uniq_attr );
        }
    ?>
<?php include('footer-category__premium_only.php'); ?>