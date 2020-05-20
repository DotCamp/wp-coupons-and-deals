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
global $coupon_id;
$title                     = get_the_title();
$description               = get_post_meta( $coupon_id, 'coupon_details_description', true );
$discount_text             = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type               = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
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
$coupon_share              = get_option( 'wpcd_coupon-social-share' );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                     = date( 'd-m-Y' );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$dt_coupon_type_name 	   = get_option( 'wpcd_dt-coupon-type-text' );
$dt_deal_type_name 	  	   = get_option( 'wpcd_dt-deal-type-text' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );

$coupon_code               = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) );
$deal_text                 = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wpcd-coupon' ) );

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ($wpcd_text_to_show == 'description' ) {
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

wp_enqueue_script( 'wpcd-clipboardjs' );
$template = new WPCD_Template_Loader();

$wpcd_uniq_attr = '';
$wpcd_uniq_attr_data = '';
if( function_exists( 'wpcd_uniq_attr' ) && ! WPCD_Amp::wpcd_amp_is() &&
    ! empty( $show_print_links ) && $show_print_links == 'on' ) {
    $wpcd_uniq_attr = wpcd_uniq_attr( 10 );
    $wpcd_uniq_attr_data = 'data-unic-attr="' . $wpcd_uniq_attr . '"';
}

?>

<div class="wpcd-coupon wpcd-coupon-default wpcd-coupon-id-<?php echo $coupon_id; ?>" <?php echo $wpcd_uniq_attr_data;?>>
    <div class="wpcd-col-1-8">
        <div class="wpcd-coupon-discount-text">
			<?php echo $discount_text; ?>
        </div>
		<?php if ( $coupon_type == 'Coupon' ) { ?>
            <div class="coupon-type">
				<?php
					if ( !empty( $dt_coupon_type_name ) ) {
						echo $dt_coupon_type_name;
					} else {
						echo __( 'Coupon', 'wpcd-coupon' );
					}
				?>
            </div>
		<?php } elseif ( $coupon_type == 'Deal' ) { ?>
		<div class="deal-type">
			<?php
				if ( !empty( $dt_deal_type_name ) ) {
					echo $dt_deal_type_name;
				} else {
					echo __( 'Deal', 'wpcd-coupon' );
				}
			?>
		</div>
		<?php } ?>
    </div>
    <div class="wpcd-coupon-content wpcd-col-7-8">
        <div class="wpcd-coupon-header">
            <div class="wpcd-col-3-4">
				<?php
					if ( 'on' === $disable_coupon_title_link ) { ?>
						<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
							<?php echo $title; ?>
                		</<?php echo esc_html( $coupon_title_tag ); ?>>
			 		<?php } else { ?>
						<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
							<a href="<?php echo $link; ?>" target="<?php echo $target; ?>" rel="nofollow"><?php echo $title; ?></a>
                		</<?php echo esc_html( $coupon_title_tag ); ?>>
					<?php } 
				?>
            </div>
            <div class="wpcd-col-1-4">
				<?php if ( $coupon_type == 'Coupon' ) {
					if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
						if ( $hide_coupon == 'Yes' && ! WPCD_Amp::wpcd_amp_is() ) {
							$template->get_template_part( 'hide-coupon__premium_only' );

						} else { ?>
                            <div class="wpcd-coupon-code">
                                <a rel="nofollow" href="<?php echo $link; ?>"
                                   class="<?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                                   target="<?php echo $target; ?>"
                                   title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
			                                   		if ( ! empty( $coupon_hover_text ) ) {
													    echo $coupon_hover_text;
												    } else {
													    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
												    }
			                                    }
                                    		?>"
                                   data-clipboard-text="<?php echo $coupon_code; ?>">
                                    <span class="wpcd_coupon_icon">
                                    	<img class="" src="<?php echo WPCD_Plugin::instance()->plugin_assets?>img/coupon-code-24.png" style="width: 100%;height: 100%;" >
                                    </span>

                                    <?php echo $coupon_code; ?>
                                </a>
                            </div>
						<?php }
					} else { ?>
                        <div class="wpcd-coupon-code">
                            <a rel="nofollow" href="<?php echo $link; ?>"
                               class="<?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                               target="<?php echo $target; ?>"
                               title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
		                                   		if ( ! empty( $coupon_hover_text ) ) {
												    echo $coupon_hover_text;
											    } else {
												    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
											    }
		                                    }
	                            		?>"
                               data-clipboard-text="<?php echo $coupon_code; ?>">
                                <span class="wpcd_coupon_icon">
                                	<img class="" src="<?php echo WPCD_Plugin::instance()->plugin_assets?>img/coupon-code-24.png" style="width: 100%;height: 100%;" >
                                </span>

                                <?php echo $coupon_code; ?>
                            </a>
                        </div>

					<?php }

				} elseif ( $coupon_type == 'Deal' ) { ?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow" class="<?php echo 'wpcd-btn-' . $coupon_id; ?> wpcd-btn masterTooltip wpcd-deal-button"
                           title="<?php if ( ! empty( $deal_hover_text ) ) {
							   echo $deal_hover_text;
						   } else {
							   echo __( "Click Here To Get This Deal", 'wpcd-coupon' );
						   } ?>" href="<?php echo $link; ?>" target="<?php echo $target; ?>">
                            <span class="wpcd_deal_icon">
                            	<img class="" src="<?php echo WPCD_Plugin::instance()->plugin_assets?>img/deal-24.png" style="width: 100%;height: 100%;" >
                            </span><?php echo $deal_text; ?>
                        </a>
                    </div>

				<?php } ?>
            </div>

        </div>
        <div class="wpcd-extra-content">
            <div class="wpcd-col-3-4">
                <div class="wpcd-coupon-description">
                    <span class="wpcd-full-description"><?php echo $description; ?></span>
                    <span class="wpcd-short-description"></span>
                    <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
	                    <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
	                    <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
	                <?php endif; ?>
                </div>
            </div>
            <div class="wpcd-col-1-4">
				<?php
				if ( $coupon_type == 'Coupon' ) {
					if ( $show_expiration == 'Show' ) {
						if ( ! empty( $expire_date ) ) {
							if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                                <div class="wpcd-coupon-expire">
									<?php
									if ( ! empty( $expire_text ) ) {
										echo $expire_text . ' ' . $expire_date;
									} else {
										echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date;
									}
									?>
                                </div>
							<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                                <div class="wpcd-coupon-expired">
									<?php
									if ( ! empty( $expired_text ) ) {
										echo $expired_text . ' ' . $expire_date;
									} else {
										echo __( 'Expired on: ', 'wpcd-coupon' ) . $expire_date;
									}
									?>
                                </div>
							<?php }
						} else { ?>
                            <div class="wpcd-coupon-expire">
								<?php if ( ! empty( $no_expiry ) ) {
									echo $no_expiry;
								} else {
									echo __( "Doesn't expire", 'wpcd-coupon' );
								} ?>
                            </div>
						<?php }
					} else {
						echo '';
					}

				} elseif ( $coupon_type == 'Deal' ) {
					if ( $show_expiration == 'Show' ) {
						if ( ! empty( $expire_date ) ) {
							if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                                <div class="wpcd-coupon-expire">
									<?php
									if ( ! empty( $expire_text ) ) {
										echo $expire_text . ' ' . $expire_date;
									} else {
										echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date;
									}
									?>
                                </div>
							<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                                <div class="wpcd-coupon-expired">
									<?php
									if ( ! empty( $expired_text ) ) {
										echo $expired_text . ' ' . $expire_date;
									} else {
										echo __( 'Expired on: ', 'wpcd-coupon' ) . $expire_date;
									}
									?>
                                </div>
							<?php }

						} else { ?>

                            <div class="wpcd-coupon-expire">

								<?php if ( ! empty( $no_expiry ) ) {
									echo $no_expiry;
								} else {
									echo __( "Doesn't expire", 'wpcd-coupon' );
								}
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
    <script type="text/javascript">
        var clip = new Clipboard('.<?php echo $button_class; ?>');
    </script>
    <div class="clearfix"></div>
    <?php
    	if( ! WPCD_Amp::wpcd_amp_is() ):
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
