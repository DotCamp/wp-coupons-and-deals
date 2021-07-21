<?php
/**
 * Shortcode template three.
 */

global $coupon_id, $num_coupon;
$title                	   = get_the_title();
$description          	   = get_post_meta( $coupon_id, 'coupon_details_description', true );
$coupon_thumbnail     	   = get_the_post_thumbnail_url( $coupon_id );
$coupon_type          	   = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$discount_text        	   = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$second_discount_text 	   = get_post_meta( $coupon_id, 'coupon_details_second-discount-text', true );
$third_discount_text  	   = get_post_meta( $coupon_id, 'coupon_details_third-discount-text', true );
$link                 	   = get_post_meta( $coupon_id, 'coupon_details_link', true );
$second_link          	   = get_post_meta( $coupon_id, 'coupon_details_second-link', true );
$third_link                = get_post_meta( $coupon_id, 'coupon_details_third-link', true );
$coupon_code               = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$second_coupon_code        = get_post_meta( $coupon_id, 'coupon_details_second-coupon-code-text', true );
$third_coupon_code         = get_post_meta( $coupon_id, 'coupon_details_third-coupon-code-text', true );
$show_print_links          = get_option( 'wpcd_coupon-print-link' );
$deal_text                 = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$second_deal_text          = get_post_meta( $coupon_id, 'coupon_details_second-deal-button-text', true );
$third_deal_text           = get_post_meta( $coupon_id, 'coupon_details_third-deal-button-text', true );
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
$coupon_share 			   = get_option( 'wpcd_coupon-social-share' );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                     = date( 'd-m-Y' );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$second_expire_date        = get_post_meta( $coupon_id, 'coupon_details_second-expire-date', true );
$third_expire_date         = get_post_meta( $coupon_id, 'coupon_details_third-expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );

$coupon_code               = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) );
$second_coupon_code        = ( ! empty( $second_coupon_code ) ? $second_coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) );
$third_coupon_code         = ( ! empty( $third_coupon_code ) ? $third_coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) );
$deal_text                 = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wpcd-coupon' ) );
$second_deal_text          = ( ! empty( $second_deal_text ) ? $second_deal_text : __( 'Claim This Deal', 'wpcd-coupon' ) );
$third_deal_text           = ( ! empty( $third_deal_text ) ? $third_deal_text : __( 'Claim This Deal', 'wpcd-coupon' ) );

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else if ( empty( $wpcd_custom_text ) ) {
	$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
}
if( ! $link && WPCD_Amp::wpcd_amp_is() ) $link = "#";
if( ! $second_link && WPCD_Amp::wpcd_amp_is() ) $second_link = "#";
if( ! $third_link && WPCD_Amp::wpcd_amp_is() ) $third_link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
	$expire_date = date( $expireDateFormatFun, $expire_date );
} elseif ( ! empty( $expire_date ) ) {
	$expire_date = date( $expireDateFormatFun, strtotime( $expire_date ) );
}
if ( ! empty( $second_expire_date ) && (string)(int)$second_expire_date == $second_expire_date ) {
	$second_expire_date = date( $expireDateFormatFun, $second_expire_date );
} elseif ( ! empty( $second_expire_date ) ) {
	$second_expire_date = date( $expireDateFormatFun, strtotime( $second_expire_date ) );
}
if ( ! empty( $third_expire_date ) && (string)(int)$third_expire_date == $third_expire_date ) {
	$third_expire_date = date( $expireDateFormatFun, $third_expire_date );
} elseif ( !empty( $third_expire_date ) ) {
	$third_expire_date = date( $expireDateFormatFun, strtotime( $third_expire_date ) );
}

$template = new WPCD_Template_Loader();

$wpcd_uniq_attr = '';
$wpcd_uniq_attr_data = '';
if( function_exists( 'wpcd_uniq_attr' ) && ! WPCD_Amp::wpcd_amp_is() &&
    ! empty( $show_print_links ) && $show_print_links == 'on' ) {
    $wpcd_uniq_attr = wpcd_uniq_attr( 10 );
    $wpcd_uniq_attr_data = 'data-unic-attr="' . esc_attr( $wpcd_uniq_attr ) . '"';
}
/*
I took the class wpcd-coupon-id-<?php echo $coupon_id; ?> and put it to each one in hide-coupon file.
*/
?>
<div class="wpcd-coupon-four wpcd-coupon-id-<?php echo absint( $coupon_id ); ?>" <?php echo $wpcd_uniq_attr_data;?>>
    <div class="wpcd-coupon-four-content">
		<div class="wpcd-coupon-four-title">
			<?php
				if ( 'on' === $disable_coupon_title_link ) { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<?php echo esc_html( $title ); ?>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
			 	<?php } else { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<a href="<?php echo esc_url( $link) ; ?>" target="<?php echo esc_attr( $target ); ?>" rel="nofollow"><?php echo esc_html( $title ); ?></a>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
				<?php } 
			?>
		</div>
        <div class="wpcd-coupon-description">
            <span class="wpcd-full-description"><?php echo wp_kses_post( $description ); ?></span>
            <span class="wpcd-short-description"></span>
            <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
	            <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
	            <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
	        <?php endif; ?>
        </div>
    </div>
    <!-- Start First Coupon -->
    <div class="wpcd-coupon-four-info">
        <div class="wpcd-coupon-four-coupon">
			<?php 
			if ( $coupon_type == 'Coupon' ) {
				if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
					?>
                    <div class="wpcd-four-discount-text"><?php echo esc_html( $discount_text ); ?></div> <?php
					if ( $hide_coupon == 'Yes' && ! WPCD_Amp::wpcd_amp_is() ) {
						$template->get_template_part( 'hide-coupon2__premium_only' );
					} else { ?>
                        <div class="wpcd-coupon-code">
                            <a rel="nofollow"
                               class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                               target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $link ); ?>"
                               title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
		                                   		if ( ! empty( $coupon_hover_text ) ) {
												    echo esc_attr( $coupon_hover_text );
											    } else {
												    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
											    }
		                                    }
	                            		?>"
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
                           class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $link ); ?>"
                           title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
	                                   		if ( ! empty( $coupon_hover_text ) ) {
											    echo esc_attr( $coupon_hover_text );
										    } else {
											    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
										    }
	                                    }
                            		?>"
                           data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>">
                            <span class="wpcd_coupon_icon">
                            	<img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png' ) ?>" style="width: 100%;height: 100%;" >
                            </span>

                            <?php echo esc_html( $coupon_code ); ?>
                        </a>
                    </div>
				<?php }
			} elseif ( $coupon_type == 'Deal' ) { ?>
                <div class="wpcd-four-discount-text"><?php echo esc_html( $discount_text ); ?></div>
                <div class="wpcd-coupon-code">
                    <a rel="nofollow"
                       class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id ); ?> wpcd-btn masterTooltip wpcd-deal-button"
                       title="<?php if ( ! empty( $deal_hover_text ) ) {
									    echo esc_attr( $deal_hover_text );
								    } else {
									    echo __( "Click Here To Get This Deal", 'wpcd-coupon' );
								    } ?>" 
					   href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
                        <span class="wpcd_deal_icon">
                        	<img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/deal-24.png' ) ?>" style="width: 100%;height: 100%;" >
                        </span><?php echo esc_html( $deal_text ); ?>
                    </a>
                </div>
			<?php } ?>
        </div>
		<?php
		if ( $coupon_type == 'Coupon' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $expire_date ) ) {
					if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p>
								<?php
								if ( ! empty( $expire_text ) ) {
									echo esc_html( $expire_text ) . ' ' . strtotime( $expire_date ) ? $expire_date : '';
								} else {
									echo __( 'Expires on: ', 'wpcd-coupon' ) . strtotime( $expire_date ) ? $expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p class="wpcd-coupon-four-expired">
								<?php
								if ( ! empty( $expired_text ) ) {
									echo esc_html( $expired_text ) . ' ' . strtotime( $expire_date ) ? $expire_date : '';
								} else {
									echo __( 'Expired on: ', 'wpcd-coupon' ) . strtotime( $expire_date ) ? $expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php }
				} else { ?>
                    <div class="wpcd-coupon-four-expire">
						<?php if ( ! empty( $no_expiry ) ) { ?>
                            <p><?php echo esc_html( $no_expiry ); ?></p>
						<?php } else {
							echo '<p>' . __( "Doesn't expire", 'wpcd-coupon' ) . '</p>';
						}
						?>
                    </div>
				<?php }
			} else {
				echo '';
			}
		} elseif ( $coupon_type == 'Deal' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $expire_date ) ) {
					if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p>
								<?php
								if ( ! empty( $expire_text ) ) {
									echo esc_attr( $expire_text ) . ' ' . strtotime( $expire_date ) ? $expire_date : '';
								} else {
									echo __( 'Expires on: ', 'wpcd-coupon' ) . strtotime( $expire_date ) ? $expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p class="wpcd-coupon-four-expired">
								<?php
								if ( ! empty( $expired_text ) ) {
									echo esc_attr( $expired_text ) . ' ' . strtotime( $expire_date ) ? $expire_date : '';
								} else {
									echo __( 'Expired on: ', 'wpcd-coupon' ) . strtotime( $expire_date ) ? $expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php }
				} else { ?>
                    <div class="wpcd-coupon-four-expire">
						<?php if ( ! empty( $no_expiry ) ) { ?>
                            <p><?php echo esc_html( $no_expiry ); ?></p>
						<?php } else {
							echo '<p>' . __( "Doesn't expire", 'wpcd-coupon' ) . '</p>';
						}
						?>
                    </div>
				<?php }
			} else {
				echo '';
			}
		} ?>
        <script type="text/javascript">
            var clip = new Clipboard('.<?php echo esc_attr( $button_class ); ?>');
        </script>
    </div>
    <!-- End First Coupon -->

    <!-- Start Second Coupon -->
    <div class="wpcd-coupon-four-info">
        <div class="wpcd-coupon-four-coupon">
			<?php 
			if ( $coupon_type == 'Coupon' ) {
				if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
				?>
                <div class="wpcd-four-discount-text"><?php echo esc_html( $second_discount_text ); ?></div> <?php
				$num_coupon = 2;
					if ( $hide_coupon == 'Yes' && ! WPCD_Amp::wpcd_amp_is() ) {
						$template = new WPCD_Template_Loader();
						$template->get_template_part( 'hide-coupon2__premium_only' );
						$num_coupon = 0;
					} else { ?>
                <div class="wpcd-coupon-code">
                    <a rel="nofollow"
                       class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id . '_' . $num_coupon ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                       target="<?php echo esc_attr( $target ); ?>" href="<?php echo_url( $second_link ); ?>"
                       title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                   		if ( ! empty( $coupon_hover_text ) ) {
										    echo esc_attr( $coupon_hover_text );
									    } else {
										    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
									    }
                                    }
                        		?>"
                       data-clipboard-text="<?php echo esc_attr( $second_coupon_code ); ?>">
                        <span class="wpcd_coupon_icon">
                        	<img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png') ?>" style="width: 100%;height: 100%;" >
                        </span> <?php echo esc_html( $second_coupon_code ); ?>
                    </a>
                </div>
			<?php }
			} else { ?>
                <div class="wpcd-coupon-code">
                    <a rel="nofollow"
                       class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id . '_' . $num_coupon ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                       target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $second_link ); ?>"
                       title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                   		if ( ! empty( $coupon_hover_text ) ) {
										    echo esc_attr( $coupon_hover_text );
									    } else {
										    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
									    }
                                    }
                        		?>"
                       data-clipboard-text="<?php echo esc_attr( $second_coupon_code ); ?>">
                        <span class="wpcd_coupon_icon">
                        	<img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png' ) ?>" style="width: 100%;height: 100%;" >
                        </span>

                        <?php echo esc_html( $second_coupon_code ); ?>
                    </a>
                </div>
			<?php } ?>
                <script type="text/javascript">
                    var clip = new Clipboard('.<?php echo esc_attr( $button_class . '_' . $num_coupon ); ?>');
                </script>
			<?php } elseif ( $coupon_type == 'Deal' ) { ?>
                <div class="wpcd-four-discount-text"><?php echo esc_html( $discount_text ); ?></div>
                <div class="wpcd-coupon-code">
                    <a rel="nofollow"
                       class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id . '_' . $num_coupon ); ?> wpcd-btn masterTooltip wpcd-deal-button"
                       title="<?php if ( ! empty( $deal_hover_text ) ) {
									   	echo esc_attr( $deal_hover_text );
								    } else {
									   echo __( "Click Here To Get This Deal", 'wpcd-coupon' );
								    } ?>" 
					   href="<?php echo esc_url( $second_link ); ?>" target="<?php echo esc_attr( $target ); ?>">
                        <span class="wpcd_deal_icon">
                        	<img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/deal-24.png' ) ?>" style="width: 100%;height: 100%;" >
                        </span><?php echo esc_html( $second_deal_text ); ?>
                    </a>
                </div>
			<?php } ?>
        </div>
		<?php
		if ( $coupon_type == 'Coupon' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $second_expire_date ) ) {
					if ( strtotime( $second_expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p>
								<?php
								if ( ! empty( $expire_text ) ) {
									echo esc_html( $expire_text ) . ' ' . strtotime( $second_expire_date ) ? $second_expire_date : '';
								} else {
									echo __( 'Expires on: ', 'wpcd-coupon' ) . strtotime( $second_expire_date ) ? $second_expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php } elseif ( strtotime( $second_expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p class="wpcd-coupon-four-expired">
								<?php
								if ( ! empty( $expired_text ) ) {
									echo esc_html( $expired_text ) . ' ' . strtotime( $second_expire_date ) ? $second_expire_date : '';
								} else {
									echo __( 'Expired on: ', 'wpcd-coupon' ) . strtotime( $second_expire_date ) ? $second_expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php }
				} else { ?>
                    <div class="wpcd-coupon-four-expire">
						<?php if ( ! empty( $no_expiry ) ) { ?>
                            <p><?php echo esc_html( $no_expiry ); ?></p>
						<?php } else {
							echo '<p>' . __( "Doesn't expire", 'wpcd-coupon' ) . '</p>';
						}
						?>
                    </div>
				<?php }
			} else {
				echo '';
			}
		} elseif ( $coupon_type == 'Deal' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $second_expire_date ) ) {
					if ( strtotime( $second_expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p>
								<?php
								if ( ! empty( $expire_text ) ) {
									echo esc_html( $expire_text ) . ' ' . strtotime( $second_expire_date ) ? $second_expire_date : '';
								} else {
									echo __( 'Expires on: ', 'wpcd-coupon' ) . strtotime( $second_expire_date ) ? $second_expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php } elseif ( strtotime( $second_expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p class="wpcd-coupon-four-expired">
								<?php
								if ( ! empty( $expired_text ) ) {
									echo esc_html( $expired_text ) . ' ' . strtotime( $second_expire_date ) ? $second_expire_date : '';
								} else {
									echo __( 'Expired on: ', 'wpcd-coupon' ) . strtotime( $second_expire_date ) ? $second_expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php }
				} else { ?>
                    <div class="wpcd-coupon-four-expire">
						<?php if ( ! empty( $no_expiry ) ) { ?>
                            <p><?php echo esc_html( $no_expiry ); ?></p>
						<?php } else {
							echo '<p>' . __( "Doesn't expire", 'wpcd-coupon' ) . '</p>';
						}
						?>
                    </div>
				<?php }
			} else {
				echo '';
			}
		} ?>
    </div>
    <!-- End Second Coupon -->

    <!-- Start Third Coupon -->
    <div class="wpcd-coupon-four-info">
        <div class="wpcd-coupon-four-coupon">
			<?php 
			if ( $coupon_type == 'Coupon' ) {
				if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
				?>
                	<div class="wpcd-four-discount-text"><?php echo esc_html( $third_discount_text ); ?></div> <?php
					$num_coupon = 3;
					if ( $hide_coupon == 'Yes' && ! WPCD_Amp::wpcd_amp_is() ) {
						$template = new WPCD_Template_Loader();
						$template->get_template_part( 'hide-coupon2__premium_only' );
					} else { ?>
                		<div class="wpcd-coupon-code">
                    	<a rel="nofollow"
                       class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id . '_' . $num_coupon ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                       target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $third_link ); ?>"
                       title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                   		if ( ! empty( $coupon_hover_text ) ) {
										    echo esc_attr( $coupon_hover_text );
									    } else {
										    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
									    }
                                    }
                        		?>"
                       data-clipboard-text="<?php echo esc_attr( $third_coupon_code ); ?>">
                            <span class="wpcd_coupon_icon">
                                <img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png' ) ?>" style="width: 100%;height: 100%;" >
                            </span>

                            <?php echo esc_html( $third_coupon_code ); ?>
                    	</a>
                </div>
			<?php }
			} else { ?>
                <div class="wpcd-coupon-code">
                    <a rel="nofollow"
                       class="<?php echo esc_html( 'wpcd-btn-' . $coupon_id . '_' . $num_coupon ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                       target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $third_link ); ?>"
                       title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                   		if ( ! empty( $coupon_hover_text ) ) {
										    echo esc_attr( $coupon_hover_text );
									    } else {
										    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
									    }
                                    }
                        		?>"
                       data-clipboard-text="<?php echo esc_attr( $third_coupon_code ); ?>">
                        <span class="wpcd_coupon_icon">
                        	<img class="" src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png' ) ?>" style="width: 100%;height: 100%;" >
                        </span>
                        <?php echo esc_html( $third_coupon_code ); ?>
                    </a>
                </div>
			<?php } ?>
                <script type="text/javascript">
                    var clip = new Clipboard('.<?php echo esc_attr( $button_class . '_' . $num_coupon) ; ?>');
                </script>
			<?php } elseif ( $coupon_type == 'Deal' ) { ?>
                <div class="wpcd-four-discount-text"><?php echo esc_html( $discount_text ); ?></div>
                <div class="wpcd-coupon-code">
                    <a rel="nofollow"
                       class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id ); ?> wpcd-btn masterTooltip wpcd-deal-button"
                       title="<?php if ( ! empty( $deal_hover_text ) ) {
								   	echo esc_attr( $deal_hover_text );
							    } else {
								    echo __( "Click Here To Get This Deal", 'wpcd-coupon' );
							    } ?>" 
					   href="<?php echo esc_url( $third_link ); ?>" target="<?php echo esc_attr( $target ); ?>">
                        <span class="wpcd_deal_icon">
                        	<img class="" src="<?php echo url( WPCD_Plugin::instance()->plugin_assets . 'img/deal-24.png') ?>" style="width: 100%;height: 100%;" >
                        </span><?php echo esc_html( $third_deal_text ); ?>
                    </a>
                </div>
			<?php } ?>
        </div>
		<?php
		if ( $coupon_type == 'Coupon' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $third_expire_date ) ) {
					if ( strtotime( $third_expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p>
								<?php
								if ( ! empty( $expire_text ) ) {
									echo esc_html( $expire_text ) . ' ' . strtotime( $third_expire_date ) ? $third_expire_date : '';
								} else {
									echo __( 'Expires on: ', 'wpcd-coupon' ) . strtotime( $third_expire_date ) ? $third_expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php } elseif ( strtotime( $third_expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p class="wpcd-coupon-four-expired">
								<?php
								if ( ! empty( $expired_text ) ) {
									echo esc_html( $expired_text ) . ' ' . strtotime( $third_expire_date ) ? $third_expire_date : '';
								} else {
									echo __( 'Expired on: ', 'wpcd-coupon' ) . strtotime( $third_expire_date ) ? $third_expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php }
				} else { ?>
                    <div class="wpcd-coupon-four-expire">
						<?php if ( ! empty( $no_expiry ) ) { ?>
                            <p><?php echo esc_html( $no_expiry ); ?></p>
						<?php } else {
							echo '<p>' . __( "Doesn't expire", 'wpcd-coupon' ) . '</p>';
						}
						?>
                    </div>
				<?php }
			} else {
				echo '';
			}

		} elseif ( $coupon_type == 'Deal' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $third_expire_date ) ) {
					if ( strtotime( $third_expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p>
								<?php
								if ( ! empty( $expire_text ) ) {
									echo esc_html( $expire_text ) . ' ' . strtotime( $third_expire_date ) ? $third_expire_date : '';
								} else {
									echo __( 'Expires on: ', 'wpcd-coupon' ) . strtotime( $third_expire_date ) ? $third_expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php } elseif ( strtotime( $third_expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-four-expire">
                            <p class="wpcd-coupon-four-expired">
								<?php
								if ( ! empty( $expired_text ) ) {
									echo esc_html( $expired_text ) . ' ' . strtotime( $third_expire_date ) ? $third_expire_date : '';
								} else {
									echo __( 'Expired on: ', 'wpcd-coupon' ) . strtotime( $third_expire_date ) ? $third_expire_date : '';
								}
								?>
                            </p>
                        </div>
					<?php }
				} else { ?>
                    <div class="wpcd-coupon-four-expire">
						<?php if ( ! empty( $no_expiry ) ) { ?>
                            <p><?php echo esc_html( $no_expiry ); ?></p>
						<?php } else {
							echo '<p>' . __( "Doesn't expire", 'wpcd-coupon' ) . '</p>';
						}
						?>
                    </div>
				<?php }
			} else {
				echo '';
			}
		}
		$num_coupon = 0;
		?>

    </div>
    <!-- End Third Coupon -->
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
