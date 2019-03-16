<?php
/**
*
* This exits from the script if it's accessed
* directly from somewhere else.
*
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* This is the default Shortcode template.
*
* @since 1.2
*/
if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
	include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id;
$title                     = get_the_title();
$description               = get_post_meta( $coupon_id, 'coupon_details_description', true );
$coupon_thumbnail          = wpcd_coupon_thumbnail_img( $coupon_id );
$discount_text             = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type               = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
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
$coupon_share              = get_option( 'wpcd_coupon-social-share' );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                     = date( 'd-m-Y' );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$dt_coupon_type_name       = get_option( 'wpcd_dt-coupon-type-text' );
$dt_deal_type_name         = get_option( 'wpcd_dt-deal-type-text' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );
$never_expire              = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$expire_time               = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$wpcd_template_seven_theme = get_post_meta( $coupon_id, 'coupon_details_template-seven-theme', true );
$post_id                   = get_the_ID();

$dt_coupon_type_name = ( !empty( $dt_coupon_type_name ) ) ? $dt_coupon_type_name : __( 'Coupon', 'wpcd-coupon' );
$dt_deal_type_name = ( !empty( $dt_deal_type_name ) ) ? $dt_deal_type_name : __( 'Deal', 'wpcd-coupon' );
$expire_text = ( !empty( $expire_text ) ) ? $expire_text : __( 'Expires On: ', 'wpcd-coupon' );
$expired_text = ( !empty( $expired_text ) ) ? $expired_text : __( 'Expired On: ', 'wpcd-coupon' );
$no_expiry = ( !empty( $no_expiry ) ) ? $no_expiry : __( "Doesn't expire", 'wpcd-coupon' );
$coupon_hover_text = ( ! empty( $coupon_hover_text ) ) ? $coupon_hover_text : __( 'Click To Copy Coupon', 'wpcd-coupon' );
$deal_hover_text = ( !empty( $deal_hover_text ) ) ? $deal_hover_text : __( 'Click Here To Get This Deal' );

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

wp_enqueue_script( 'wpcd-clipboardjs' );
$template = new WPCD_Template_Loader();

?>
<section class="wpcd_seven wpcd_seven_shortcode">
	<div class="wpcd_seven_container">
		<div class="wpcd_seven_couponBox" style="border-color: <?php echo $wpcd_template_seven_theme; ?>">
			<div class="wpcd_seven_percentAndPic">
				<div class="wpcd_seven_percentOff" style="background-color: <?php echo $wpcd_template_seven_theme; ?>; border-color: <?php echo $wpcd_template_seven_theme; ?>;">
					<p><?php echo $discount_text; ?></p>
				</div>
				<div class="wpcd_seven_productPic">
					<!-- <img src="http://rdironworks.com/wp-content/uploads/2017/12/dummy-200x200.png" alt="Product-pic"> -->
					<img src="<?php echo $coupon_thumbnail; ?>" alt="Coupon">
				</div>
			</div>
			<div class="wpcd_seven_headingAndExpire">
				<div class="wpcd_seven_heading">
				<?php
					if ( 'on' === $disable_coupon_title_link ) { ?>
						<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-new-title">
							<?php echo $title; ?>
						</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
					} else { ?>
						<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-new-title">
							<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
						</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
					}?>
					<p><?php echo wpautop( $description, false );?></p>
				</div>		
			</div>
                <?php if ($coupon_type == 'Coupon') : ?>
                    <?php if (!empty($coupon_code)) : ?>
                        <div class="wpcd_seven_buttonSociaLikeDislike">
                        	<?php if ( $hide_coupon === 'Yes' && ! WPCD_Amp::wpcd_amp_is() ): ?>
								<?php
								$template->get_template_part( 'hide-coupon2__premium_only' );
								?>
							<?php else: ?>
	                        	<div class="wpcd_seven_btn">
	                                <a class="masterTooltip" 
	                                	href="<?php echo $link; ?>"
	                                	title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
		                                                 if ( ! empty( $coupon_hover_text ) ) {
		                                                     echo $coupon_hover_text;
		                                                 } else {
		                                                     echo __( "Click To Copy Coupon", 'wpcd-coupon' );
		                                                 }
		                                             }
		                                        ?>"
										data-clipboard-text="<?php echo $coupon_code; ?>"
			                    		data-title-ab="<?php echo $coupon_code; ?>" 
	                                 	style="background-color: <?php echo $wpcd_template_seven_theme; ?>; border-color: <?php echo $wpcd_template_seven_theme; ?>; color: <?php echo $wpcd_template_seven_theme; ?>"><?php echo $coupon_code; ?>
	                                </a>
	                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($coupon_type == 'Deal') : ?>
                    <?php if (!empty($deal_text)) : ?>
                        <div class="wpcd_seven_buttonSociaLikeDislike">
                            <div class="wpcd_seven_btn">
                                <a class="masterTooltip" 
                                	href="<?php echo $link; ?>"
                                 	title="<?php echo $deal_hover_text; ?>"
									data-clipboard-text="<?php echo $deal_text; ?>"
			                    	data-title-ab="<?php echo $deal_text; ?>" 
			                    	style="background-color: <?php echo $wpcd_template_seven_theme; ?>; border-color: <?php echo $wpcd_template_seven_theme; ?>; color: <?php echo $wpcd_template_seven_theme; ?>"><?php echo $deal_text; ?>
			                    </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
				<div class="wpcd_seven_expire_correct_box">
					<div class="wpcd_seven_expire">
						<p>
							<?php if( ! empty( trim( $expire_date ) ) && $never_expire != 'on' ) : ?>
								<?php if( ! WPCD_Amp::wpcd_amp_is() ) { ?>
									<?php
									if ( ! empty( $expire_text ) ) {
										echo $expire_text;
									} else {
										echo __( 'Expires on: ', 'wpcd-coupon' );
									}
									?>
									<span class="wpcd-coupon-seven-countdown" data-countdown_coupon="<?php echo $expire_date_format . ' ' . $expire_time; ?>" id="clock_seven_<?php echo $post_id; ?>"></span>
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
								<b class="never-expire">
									<?php if ( ! empty( $no_expiry ) ) : ?>
											<b><?php echo $no_expiry; ?></b>
									<?php else : ?>
											<b><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></b>
									<?php endif; ?>
								</b>
							<?php endif; ?> 
						</p>
					</div><!-- End of class wpcd_seven_expire -->
				</div>
			<div class="wpcd_seven_couponBox_both"></div>
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
	</div>
</section>