<?php

/**
 * Builds the coupon preview meta box.
 *
 * @since 2.0
 */

$post_id                  = get_the_ID();
$title                    = get_the_title();
$description              = get_post_meta( $post_id, 'coupon_details_description', true );
$coupon_thumbnail         = get_the_post_thumbnail_url( $post_id );
$coupon_type              = get_post_meta( $post_id, 'coupon_details_coupon-type', true );
$discount_text            = get_post_meta( $post_id, 'coupon_details_discount-text', true );
$second_discount_text     = get_post_meta( $post_id, 'coupon_details_second-discount-text', true );
$third_discount_text      = get_post_meta( $post_id, 'coupon_details_third-discount-text', true );
$link                     = get_post_meta( $post_id, 'coupon_details_link', true );
$coupon_code              = get_post_meta( $post_id, 'coupon_details_coupon-code-text', true );
$second_coupon_code       = get_post_meta( $post_id, 'coupon_details_second-coupon-code-text', true );
$third_coupon_code        = get_post_meta( $post_id, 'coupon_details_third-coupon-code-text', true );
$deal_text                = get_post_meta( $post_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text        = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text          = get_option( 'wpcd_deal-hover-text' );
$button_class             = '.wpcd-btn-' . $post_id;
$no_expiry                = get_option( 'wpcd_no-expiry-message' );
$expire_text              = get_option( 'wpcd_expire-text' );
$expired_text             = get_option( 'wpcd_expired-text' );
$hide_coupon_text         = get_option( 'wpcd_hidden-coupon-text' );
$hide_coupon_button_color = get_option( 'wpcd_hidden-coupon-button-color' );
$hidden_coupon_hover_text = get_option( 'wpcd_hidden-coupon-hover-text' );
$show_expiration          = get_post_meta( $post_id, 'coupon_details_show-expiration', true );
$today                    = date( 'd-m-Y' );
$time_now                 = time();
$expire_date              = get_post_meta( $post_id, 'coupon_details_expire-date', true );
$second_expire_date       = get_post_meta( $post_id, 'coupon_details_second-expire-date', true );
$third_expire_date        = get_post_meta( $post_id, 'coupon_details_third-expire-date', true );
$expire_time              = get_post_meta( $post_id, 'coupon_details_expire-time', true );
$expireDateFormat         = get_option( 'wpcd_expiry-date-format' );
$expire_date_format       = date( "m/d/Y", strtotime( $expire_date ) );
$hide_coupon              = get_post_meta( $post_id, 'coupon_details_hide-coupon', true );
$coupon_image_id          = get_post_meta( $post_id, 'coupon_details_coupon-image-input', true );
$coupon_image_src         = wp_get_attachment_image_src( $coupon_image_id, 'full' );
$wpcd_template_five_theme = get_post_meta( $post_id, 'coupon_details_template-five-theme', true );
$wpcd_template_six_theme  = get_post_meta( $post_id, 'coupon_details_template-six-theme', true );
$wpcd_dummy_coupon_img   = WPCD_Plugin::instance()->plugin_assets . 'admin/img/coupon-200x200.png';
$wpcd_text_to_show        = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text         = get_option( 'wpcd_custom-text' );

/** Alternative Template variables */
global $coupon_id;
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$coupon_title_tag          = get_option( 'wpcd_coupon-title-tag', 'h1' );
$dt_coupon_type_name       = get_option( 'wpcd_dt-coupon-type-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}
?>

<style>
	.wpcd-coupon-button-type .coupon-code-wpcd .get-code-wpcd {
		background-color: <?php echo $hide_coupon_button_color; ?>;
	}

	.wpcd-coupon-button-type .coupon-code-wpcd .get-code-wpcd:after {
		border-left-color: <?php echo $hide_coupon_button_color; ?>;
	}
</style>
<span class="wpcd-default-img"
	  default-img="<?php echo WPCD_Plugin::instance()->plugin_assets . 'img/icon-128x128.png'; ?>"
	  style="display:none;">

</span>

<!-- Default Preview -->
<div class="wpcd-coupon-preview wpcd-coupon wpcd-coupon-default wpcd-coupon-id-<?php echo $post_id; ?>">
	<div class="wpcd-col-1-8">
		<div class="wpcd-coupon-discount-text">
			<?php if ( ! empty( $discount_text ) ) {
				echo $discount_text;
			} else {
				echo __( 'Discount Text', 'wpcd-coupon' );
			} ?>
		</div>
		<div class="coupon-type">
			<?php if ( ! empty( $coupon_type ) ) {
				echo $coupon_type;
			} else {
				echo __( 'Coupon', 'wpcd-coupon' );
			} ?>
		</div>
	</div>
	<div class="wpcd-coupon-content wpcd-col-7-8">
		<div class="wpcd-coupon-header">
			<div class="wpcd-col-3-4">
				<div class="wpcd-coupon-title"><?php if ( ! empty( $title ) ) {
						echo $title;
					} else {
						echo __( 'Sample Coupon Code', 'wpcd-coupon' );
					} ?>
				</div>
			</div>
			<div class="wpcd-col-1-4">
				<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
					<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
					   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
					   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
						   echo $hidden_coupon_hover_text;
					   } else {
						   _e( 'Click Here to Show Code', 'wpcd-coupon' );
					   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>">
						<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $coupon_code ) ) {
								echo $coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?></span>
						<span class="get-code-wpcd">
							<?php
							if ( ! empty( $hide_coupon_text ) ) {
								echo $hide_coupon_text;
							} else {
								echo __( 'Show Code', 'wpcd-coupon' );
							}
							?>
						</span>
					</a>
				</div>
				<div class="wpcd-coupon-not-hidden">
					<div class="wpcd-coupon-code">
						<button class="wpcd-btn masterTooltip wpcd-coupon-button"
								title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
								data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
									echo $coupon_code;
								} else {
									echo __( 'COUPONCODE', 'wpcd-coupon' );
								} ?>">
							<span class="wpcd_coupon_icon"></span> <span
									class="coupon-code-button"><?php if ( ! empty( $coupon_code ) ) {
									echo $coupon_code;
								} else {
									echo __( 'COUPONCODE', 'wpcd-coupon' );
								} ?></span>
						</button>
					</div>
					<div class="wpcd-deal-code">
						<button class="wpcd-btn masterTooltip wpcd-deal-button"
								title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
								data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
									echo $deal_text;
								} else {
									echo __( 'Claim This Deal', 'wpcd-coupon' );
								} ?>">
							<span class="wpcd_deal_icon"></span><span
									class="deal-code-button"><?php if ( ! empty( $deal_text ) ) {
									echo $deal_text;
								} else {
									echo __( 'Claim This Deal', 'wpcd-coupon' );
								} ?></span>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="wpcd-extra-content">
			<div class="wpcd-col-3-4">
				<div class="wpcd-coupon-description">
					<?php if ( ! empty( $description ) ) {
						echo $description;
					} else {
						echo __( 'This is the description of the coupon code. Additional details of what the coupon or deal is.', 'wpcd-coupon' );
					} ?>
				</div>
			</div>
			<div class="wpcd-col-1-4">
				<?php
				if ( $show_expiration !== 'Hide' ) { ?>
					<div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
						<div class="wpcd-coupon-expire expire-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? 'hidden' : ''; ?>">
							<?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?>
						</div>
						<div class="wpcd-coupon-expired expired-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? 'hidden' : ''; ?>">
							<?php
							if ( ! empty( $expired_text ) ) {
								echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
							} else {
								echo __( 'Expired on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?>
						</div>
					</div>
					<div class="wpcd-coupon-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
						<?php if ( ! empty( $no_expiry ) ) {
							echo $no_expiry;
						} else {
							echo __( "Doesn't expire", 'wpcd-coupon' );
						} ?>
					</div>
					<?php
				} else {
					echo '';
				} ?>
			</div>
		</div>
	</div>
</div>
<!-- Alternative Preview -->
<div class="admin-wpcd-new-grid-container wpcd-coupon-preview wpcd-coupon-alternative">
	<div class="admin-wpcd-new-grid-one">
		<div class="admin-wpcd-new-discount-text wpcd-coupon-discount-text">
		   <?php echo $discount_text; ?>
		</div>
		<div class="coupon-type">
			<?php if ( ! empty( $coupon_type ) ) {
				echo $coupon_type;
			} else {
				echo __( 'Coupon', 'wpcd-coupon' );
			} ?>
		</div>
		<?php
		if ( $show_expiration == 'Show' ) {
			if ( ! empty( $expire_date ) ) {
				if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
					<p class="admin-wpcd-new-expire-text expiration-date">
						<?php echo $expire_text . ' ' . $expire_date; ?>
					</p> <?php
				} elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
					<p class="admin-wpcd-new-expire-text expiration-date">
						<?php echo $expired_text . ' ' . $expire_date; ?>
					</p> <?php
				}
			} else { ?>
				<p class="admin-wpcd-new-expire-text expiration-date">
					<?php echo $no_expiry; ?>
				</p> <?php
			}
		} else {
			echo '';
		} ?>
   </div> <!-- End of grid-one -->
   <div class="admin-wpcd-new-grid-two">
	   <?php
		if ( 'on' === $disable_coupon_title_link ) { ?>
			<<?php echo esc_html( $coupon_title_tag ); ?> class="admin-wpcd-new-title wpcd-coupon-title">
				<?php echo $title; ?>
			</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
		} else { ?>
			<<?php echo esc_html( $coupon_title_tag ); ?> class="admin-wpcd-new-title wpcd-coupon-title">
				<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
			</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
		}
	   ?>
		<div class="wpcd-coupon-description">
			<span class="wpcd-full-description"><?php echo $description; ?></span>
			<span class="wpcd-short-description"></span>
			<a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
			<a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
		</div>
	</div> <!-- End of grid-two -->
	<div class="admin-wpcd-new-grid-three">
		<a class="admin-wpcd-new-coupon-code masterTooltip coupon-code-button" rel="nofollow" href="#" target="_blank" data-clipboard-text="<?php echo $coupon_code; ?>" title="<?php echo $coupon_hover_text; ?>">
			<?php echo $coupon_code; ?>
		</a>
		<a class="admin-wpcd-new-goto-button" rel="nofollow" href="<?php echo esc_url( $link ); ?>" target="_blank">
		   GO TO THE DEAL
		</a>
	</div><!-- End of grid-three -->
	<script type="text/javascript">
		var clip = new Clipboard('.<?php echo $button_class; ?>');
	</script>
</div><!-- Alternative Preview -->

<!-- Template One Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-one">
	<div class="wpcd-col-one-1-8">
		<?php if ( has_post_thumbnail() ) { ?>
			<figure>
				<img class="wpcd-coupon-one-img wpcd-get-fetured-img" src="<?php echo $coupon_thumbnail; ?>">
			</figure>
		<?php } else { ?>
			<figure>
				<img class="wpcd-coupon-one-img wpcd-get-fetured-img"
					 src="<?php echo WPCD_Plugin::instance()->plugin_assets . 'img/icon-128x128.png'; ?>">
			</figure>
		<?php } ?>
	</div>
	<div class="wpcd-col-one-7-8">
		<h4 class="wpcd-coupon-one-title"><?php if ( ! empty( $title ) ) {
				echo $title;
			} else {
				echo __( 'Sample Coupon Code', 'wpcd-coupon' );
			} ?></h4>
		<div id="clear"></div>
		<div class="wpcd-coupon-description">
			<?php if ( ! empty( $description ) ) {
				echo $description;
			} else {
				echo __( 'This is the description of the coupon code. Additional details of what the coupon or deal is.', 'wpcd-coupon' );
			} ?>
		</div>
	</div>
	<div class="wpcd-col-one-1-4">
		<div class="wpcd-coupon-one-discount-text">
			<?php if ( ! empty( $discount_text ) ) {
				echo $discount_text;
			} else {
				echo __( 'Discount Text', 'wpcd-coupon' );
			} ?>
		</div>
		<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
			<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
			   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
			   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
				   echo $hidden_coupon_hover_text;
			   } else {
				   _e( 'Click Here to Show Code', 'wpcd-coupon' );
			   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>">
				<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $coupon_code ) ) {
						echo $coupon_code;
					} else {
						echo __( 'COUPONCODE', 'wpcd-coupon' );
					} ?></span>
				<span class="get-code-wpcd">
					<?php
					if ( ! empty( $hide_coupon_text ) ) {
						echo $hide_coupon_text;
					} else {
						echo __( 'Show Code', 'wpcd-coupon' );
					}
					?>
				</span>
			</a>
		</div>
		<div class="wpcd-coupon-not-hidden">
			<div class="wpcd-coupon-code">
				<button class="wpcd-btn masterTooltip wpcd-coupon-button"
						title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
						data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
							echo $coupon_code;
						} else {
							echo __( 'COUPONCODE', 'wpcd-coupon' );
						} ?>">
					<span class="wpcd_coupon_icon"></span> <span
							class="coupon-code-button"><?php if ( ! empty( $coupon_code ) ) {
							echo $coupon_code;
						} else {
							echo __( 'COUPONCODE', 'wpcd-coupon' );
						} ?></span>
				</button>
			</div>
			<div class="wpcd-deal-code">
				<button class="wpcd-btn masterTooltip wpcd-deal-button"
						title="<?php __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
						data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
							echo $deal_text;
						} else {
							echo __( 'Claim This Deal', 'wpcd-coupon' );
						} ?>">
					<span class="wpcd_deal_icon"></span><span
							class="deal-code-button"><?php if ( ! empty( $deal_text ) ) {
							echo $deal_text;
						} else {
							echo __( 'Claim This Deal', 'wpcd-coupon' );
						} ?></span>
				</button>
			</div>
		</div>
		<?php
		if ( $show_expiration !== 'Hide' ) { ?>
			<div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
				<div class="wpcd-coupon-one-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? 'hidden' : ''; ?>">
					<?php
					if ( ! empty( $expire_text ) ) {
						echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
					} else {
						echo __( 'Expires on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
					}
					?>
				</div>
				<div class="wpcd-coupon-one-expired expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? 'hidden' : ''; ?>">
					<?php
					if ( ! empty( $expired_text ) ) {
						echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
					} else {
						echo __( 'Expired on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
					}
					?>
				</div>
			</div>
			<div class="wpcd-coupon-one-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
				<?php if ( ! empty( $no_expiry ) ) {
					echo $no_expiry;
				} else {
					echo __( "Doesn't expire", 'wpcd-coupon' );
				} ?>
			</div>
			<?php
		} else {
			echo '';
		}
		?>
		<div id="clear"></div>
	</div>
	<div id="clear"></div>
</div>

<!-- Template Two Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-two">
	<div class="wpcd-col-two-1-4">
		<?php if ( has_post_thumbnail() ) { ?>
			<figure>
				<img class="wpcd-coupon-two-img wpcd-get-fetured-img" src="<?php echo $coupon_thumbnail; ?>">
			</figure>
		<?php } else { ?>
			<figure>
				<img class="wpcd-coupon-two-img wpcd-get-fetured-img"
					 src="<?php echo WPCD_Plugin::instance()->plugin_assets . 'img/icon-128x128.png'; ?>">
			</figure>
		<?php } ?>
		<div class="wpcd-coupon-two-discount-text">
			<?php if ( ! empty( $discount_text ) ) {
				echo $discount_text;
			} else {
				echo __( 'Discount Text', 'wpcd-coupon' );
			} ?>
		</div>
	</div>
	<div class="wpcd-col-two-3-4">
		<div class="wpcd-coupon-two-header">
			<div>
				<h4><?php if ( ! empty( $title ) ) {
						echo $title;
					} else {
						echo __( 'Sample Coupon Code', 'wpcd-coupon' );
					} ?></h4>
			</div>
		</div>
		<div class="wpcd-coupon-two-info">
			<div class="wpcd-coupon-two-title">
				<b class="expires-on">
					<span><?php
						if ( ! empty( $expire_text ) ) {
							echo $expire_text;
						} else {
							echo __( 'Expires on: ', 'wpcd-coupon' );
						}
						?>
					</span>
					<span class="wpcd-coupon-two-countdown" id="clock_two_<?php echo $post_id; ?>"></span>
				</b>
				<?php if ( ! $expire_date ) {
					//$expire_date        = date( 'd/m/Y' );
					$expire_date_format = date( 'd/m/Y' );
				} ?>
				<script type="text/javascript">
					var hasDate = "<?php echo empty( $expire_date ) ? 'no' : 'yes';?>";
					if (hasDate === 'no')
						jQuery('#clock_two_<?php echo $post_id; ?>').hide();

					var $clock = jQuery('#clock_two_<?php echo $post_id; ?>').countdown('<?php echo $expire_date_format . ' ' . $expire_time; ?>', function (event) {
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
						jQuery(this).html(event.strftime(format));

						if (event.offset.weeks == 0 && event.offset.totalDays == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds == 0) {
							jQuery(this).addClass('wpcd-countdown-expired').html('<?php echo __( 'This offer has expired!', 'wpcd-coupon' ); ?>');
						} else {
							jQuery(this).html(event.strftime(format));
							jQuery('#clock_two_<?php echo $post_id; ?>').removeClass('wpcd-countdown-expired');
						}
					});

					jQuery("#expire-time").change(function () {
						jQuery('#clock_two_<?php echo $post_id; ?>').show();
						var coup_date = jQuery("#expire-date").val();
						if (coup_date.indexOf("-") >= 0) {
							var dateAr = coup_date.split('-');
							coup_date = dateAr[1] + '/' + dateAr[0] + '/' + dateAr[2];
						}
						selectedDate = coup_date + ' ' + jQuery("#expire-time").val();
						$clock.countdown(selectedDate.toString());
					});
				</script>
				<b class="never-expire" style="display: none;">
					<?php if ( ! empty( $no_expiry ) ) : ?>
							<b><?php echo $no_expiry; ?></b>
					<?php else : ?>
							<b><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></b>
					<?php endif; ?>
				</b>
			</div>
			<div class="wpcd-coupon-two-coupon">
				<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
					<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
					   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
					   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
						   echo $hidden_coupon_hover_text;
					   } else {
						   _e( 'Click Here to Show Code', 'wpcd-coupon' );
					   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>">
						<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $coupon_code ) ) {
								echo $coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?></span>
						<span class="get-code-wpcd">
							<?php
							if ( ! empty( $hide_coupon_text ) ) {
								echo $hide_coupon_text;
							} else {
								echo __( 'Show Code', 'wpcd-coupon' );
							}
							?>
						</span>
					</a>
				</div>
				<div class="wpcd-coupon-not-hidden">
					<div class="wpcd-coupon-code">
						<button class="wpcd-btn masterTooltip wpcd-coupon-button"
								title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
								data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
									echo $coupon_code;
								} else {
									echo __( 'COUPONCODE', 'wpcd-coupon' );
								} ?>">
							<span class="wpcd_coupon_icon"></span> <span
									class="coupon-code-button"><?php if ( ! empty( $coupon_code ) ) {
									echo $coupon_code;
								} else {
									echo __( 'COUPONCODE', 'wpcd-coupon' );
								} ?></span>
						</button>
					</div>
					<div class="wpcd-deal-code">
						<button class="wpcd-btn masterTooltip wpcd-deal-button"
								title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
								data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
									echo $deal_text;
								} else {
									echo __( 'Claim This Deal', 'wpcd-coupon' );
								} ?>">
							<span class="wpcd_deal_icon"></span><span
									class="deal-code-button"><?php if ( ! empty( $deal_text ) ) {
									echo $deal_text;
								} else {
									echo __( 'Claim This Deal', 'wpcd-coupon' );
								} ?></span>
						</button>
					</div>
				</div>
			</div>
			<div id="clear"></div>
		</div>
		<div id="clear"></div>
		<div class="wpcd-coupon-description">
			<?php if ( ! empty( $description ) ) {
				echo $description;
			} else {
				echo __( 'This is the description of the coupon code. You can add additional details about the coupon here, what the coupon or deal is.', 'wpcd-coupon' );
			} ?>
		</div>
	</div>
</div>

<!-- Template Three Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-three">
	<div class="wpcd-coupon-three-content">
		<h4 class="wpcd-coupon-three-title"><?php if ( ! empty( $title ) ) {
				echo $title;
			} else {
				echo __( 'Sample Coupon Code', 'wpcd-coupon' );
			} ?></h4>
		<div class="wpcd-coupon-description">
			<?php if ( ! empty( $description ) ) {
				echo $description;
			} else {
				echo __( 'This is the description of the coupon code. You can add additional details about the coupon here, what the coupon or deal is.', 'wpcd-coupon' );
			} ?>
		</div>
	</div>
	<div class="wpcd-coupon-three-info">
		<div class="wpcd-coupon-three-info-left">
			<?php
			if ( $show_expiration !== 'Hide' ) { ?>
				<div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
					<div class="wpcd-coupon-three-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-three-expire-text"><?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?></p>
					</div>
					<div class="wpcd-coupon-three-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-three-expired">
							<?php
							if ( ! empty( $expired_text ) ) {
								echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
							} else {
								echo __( 'Expired on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?>
						</p>
					</div>
				</div>
				<div class="wpcd-coupon-three-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
					<?php if ( ! empty( $no_expiry ) ) { ?>
						<p><?php echo $no_expiry; ?></p>
					<?php } else { ?>
						<p><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></p>
					<?php }
					?>
				</div>
				<?php
			} else {
				echo '';
			}
			?>
		</div>
		<div class="wpcd-coupon-three-coupon">
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
				   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
				   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
					   echo $hidden_coupon_hover_text;
				   } else {
					   _e( 'Click Here to Show Code', 'wpcd-coupon' );
				   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $coupon_code ) ) {
							echo $coupon_code;
						} else {
							echo __( 'COUPONCODE', 'wpcd-coupon' );
						} ?></span>
					<span class="get-code-wpcd">
						<?php
						if ( ! empty( $hide_coupon_text ) ) {
							echo $hide_coupon_text;
						} else {
							echo __( 'Show Code', 'wpcd-coupon' );
						}
						?>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<button class="wpcd-btn masterTooltip wpcd-coupon-button"
							title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
							data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
								echo $coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?>">
						<span class="wpcd_coupon_icon"></span> <span
								class="coupon-code-button"><?php if ( ! empty( $coupon_code ) ) {
								echo $coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?></span>
					</button>
				</div>
				<div class="wpcd-deal-code">
					<button class="wpcd-btn masterTooltip wpcd-deal-button"
							title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
							data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?>">
						<span class="wpcd_deal_icon"></span><span
								class="deal-code-button"><?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Template Four Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-four">
	<div class="wpcd-coupon-four-content">
		<h4 class="wpcd-coupon-four-title"><?php if ( ! empty( $title ) ) {
				echo $title;
			} else {
				echo __( 'Sample Coupon Code', 'wpcd-coupon' );
			} ?></h4>
		<div class="wpcd-coupon-description">
			<?php if ( ! empty( $description ) ) {
				echo $description;
			} else {
				echo __( 'This is the description of the coupon code. You can add additional details about the coupon here, what the coupon or deal is.', 'wpcd-coupon' );
			} ?>
		</div>
	</div>

	<!-- start first coupon -->
	<div class="wpcd-coupon-four-info">
		<div class="wpcd-coupon-four-coupon">

			<div class="wpcd-four-discount-text"><?php echo $discount_text; ?></div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
				   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
				   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
					   echo $hidden_coupon_hover_text;
				   } else {
					   _e( 'Click Here to Show Code', 'wpcd-coupon' );
				   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $coupon_code ) ) {
							echo $coupon_code;
						} else {
							echo __( 'COUPONCODE', 'wpcd-coupon' );
						} ?></span>
					<span class="get-code-wpcd">
						<?php
						if ( ! empty( $hide_coupon_text ) ) {
							echo $hide_coupon_text;
						} else {
							echo __( 'Show Code', 'wpcd-coupon' );
						}
						?>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<button class="wpcd-btn masterTooltip wpcd-coupon-button"
							title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
							data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
								echo $coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?>">
						<span class="wpcd_coupon_icon"></span> <span
								class="coupon-code-button"><?php if ( ! empty( $coupon_code ) ) {
								echo $coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?></span>
					</button>
				</div>
				<div class="wpcd-deal-code">
					<button class="wpcd-btn masterTooltip wpcd-deal-button"
							title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
							data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?>">
						<span class="wpcd_deal_icon"></span><span
								class="deal-code-button"><?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?></span>
					</button>
				</div>
			</div>
		</div>
		<div class="wpcd-coupon-four-info-left">
			<?php
			if ( $show_expiration !== 'Hide' ) { ?>
				<div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
					<div class="wpcd-coupon-four-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-four-expire-text"><?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?></p>
					</div>
					<div class="wpcd-coupon-four-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-four-expired">
							<?php
							if ( ! empty( $expired_text ) ) {
								echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
							} else {
								echo __( 'Expired on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?>
						</p>
					</div>
				</div>
				<div class="wpcd-coupon-four-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
					<?php if ( ! empty( $no_expiry ) ) { ?>
						<p><?php echo $no_expiry; ?></p>
					<?php } else { ?>
						<p><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></p>
					<?php }
					?>
				</div>
			<?php } else {
				echo '';
			}
			?>
		</div>
	</div>
	<!-- end first coupon -->

	<!-- start second coupon -->
	<div class="wpcd-coupon-four-info">
		<div class="wpcd-coupon-four-coupon">
			<div class="wpcd-four-discount-text"><?php echo $second_discount_text; ?></div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
				   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
				   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
					   echo $hidden_coupon_hover_text;
				   } else {
					   _e( 'Click Here to Show Code', 'wpcd-coupon' );
				   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $second_coupon_code ) ) {
							echo $second_coupon_code;
						} else {
							echo __( 'COUPONCODE', 'wpcd-coupon' );
						} ?></span>
					<span class="get-code-wpcd">
						<?php
						if ( ! empty( $hide_coupon_text ) ) {
							echo $hide_coupon_text;
						} else {
							echo __( 'Show Code', 'wpcd-coupon' );
						}
						?>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<button class="wpcd-btn masterTooltip wpcd-coupon-button"
							title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
							data-clipboard-text="<?php if ( ! empty( $second_coupon_code ) ) {
								echo $second_coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?>">
						<span class="wpcd_coupon_icon"></span> <span
								class="coupon-code-button"><?php if ( ! empty( $second_coupon_code ) ) {
								echo $second_coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?></span>
					</button>
				</div>
				<div class="wpcd-deal-code">
					<button class="wpcd-btn masterTooltip wpcd-deal-button"
							title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
							data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?>">
						<span class="wpcd_deal_icon"></span><span
								class="deal-code-button"><?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?></span>
					</button>
				</div>
			</div>
		</div>
		<div class="wpcd-coupon-four-info-left">
			<?php
			if ( $show_expiration !== 'Hide' ) { ?>
				<div class="with-expiration-4-2 <?php echo empty( $second_expire_date ) ? 'hidden' : ''; ?>">
					<div class="wpcd-coupon-four-expire expire-text-block2 <?php echo strtotime( $second_expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-four-expire-text"><?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text . ' ' . '<span class="expiration-date">' . $second_expire_date . '</span>';;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $second_expire_date . '</span>';
							}
							?></p>
					</div>
					<div class="wpcd-coupon-four-expire expired-text-block2 <?php echo strtotime( $second_expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-four-expired">
							<?php
							if ( ! empty( $expired_text ) ) {
								echo $expired_text . ' ' . '<span class="expiration-date">' . $second_expire_date . '</span>';;
							} else {
								echo __( 'Expired on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $second_expire_date . '</span>';
							}
							?>
						</p>
					</div>
				</div>
				<div class="wpcd-coupon-four-expire without-expiration-4-2 <?php echo empty( $second_expire_date ) ? '' : 'hidden'; ?>">
					<?php if ( ! empty( $no_expiry ) ) { ?>
						<p><?php echo $no_expiry; ?></p>
					<?php } else { ?>
						<p><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></p>
					<?php }
					?>
				</div>
				<?php
			} else {
				echo '';
			}
			?>
		</div>
	</div>
	<!-- end second coupon -->

	<!-- start third coupon -->
	<div class="wpcd-coupon-four-info">
		<div class="wpcd-coupon-four-coupon">
			<div class="wpcd-four-discount-text"><?php echo $third_discount_text; ?></div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
				   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
				   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
					   echo $hidden_coupon_hover_text;
				   } else {
					   _e( 'Click Here to Show Code', 'wpcd-coupon' );
				   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $third_coupon_code ) ) {
							echo $third_coupon_code;
						} else {
							echo __( 'COUPONCODE', 'wpcd-coupon' );
						} ?></span>
					<span class="get-code-wpcd">
						<?php
						if ( ! empty( $hide_coupon_text ) ) {
							echo $hide_coupon_text;
						} else {
							echo __( 'Show Code', 'wpcd-coupon' );
						}
						?>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<button class="wpcd-btn masterTooltip wpcd-coupon-button"
							title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
							data-clipboard-text="<?php if ( ! empty( $third_coupon_code ) ) {
								echo $third_coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?>">
						<span class="wpcd_coupon_icon"></span> <span
								class="coupon-code-button"><?php if ( ! empty( $third_coupon_code ) ) {
								echo $third_coupon_code;
							} else {
								echo __( 'COUPONCODE', 'wpcd-coupon' );
							} ?></span>
					</button>
				</div>
				<div class="wpcd-deal-code">
					<button class="wpcd-btn masterTooltip wpcd-deal-button"
							title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
							data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?>">
						<span class="wpcd_deal_icon"></span><span
								class="deal-code-button"><?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?></span>
					</button>
				</div>
			</div>
		</div>
		<div class="wpcd-coupon-four-info-left">
			<?php
			if ( $show_expiration !== 'Hide' ) { ?>
				<div class="with-expiration-4-3 <?php echo empty( $third_expire_date ) ? 'hidden' : ''; ?>">
					<div class="wpcd-coupon-four-expire expire-text-block3 <?php echo strtotime( $third_expire_date ) >= strtotime( $today ); ?>">
						<p class="wpcd-coupon-four-expire-text"><?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text . ' ' . '<span class="expiration-date">' . $third_expire_date . '</span>';;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $third_expire_date . '</span>';
							}
							?></p>
					</div>
					<div class="wpcd-coupon-four-expire expired-text-block3 <?php echo strtotime( $third_expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-four-expired">
							<?php
							if ( ! empty( $expired_text ) ) {
								echo $expired_text . ' ' . '<span class="expiration-date">' . $third_expire_date . '</span>';;
							} else {
								echo __( 'Expired on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $third_expire_date . '</span>';
							}
							?>
						</p>
					</div>
				</div>
				<div class="wpcd-coupon-four-expire without-expiration-4-3 <?php echo empty( $third_expire_date ) ? '' : 'hidden'; ?>">
					<?php if ( ! empty( $no_expiry ) ) { ?>
						<p><?php echo $no_expiry; ?></p>
					<?php } else { ?>
						<p><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></p>
					<?php }
					?>
				</div>
				<?php
			} else {
				echo '';
			}
			?>
		</div>
	</div>
	<!-- end third coupon -->
</div>

<!-- Template Five Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-five">
	<div class="wpcd-template-five" style="border-color: <?php echo $wpcd_template_five_theme; ?>">
		<div class="wpcd-template-five-holder">
			<div class="wpcd-template-five-percent-off">
				<p class="wpcd-coupon-five-discount-text">
					<?php if ( ! empty( $discount_text ) ) {
						echo $discount_text;
					} else {
						echo __( 'Discount Text', 'wpcd-coupon' );
					} ?>
				</p>
			</div>
			<div class="wpcd-template-five-pro-img">
				<img data-src="<?php echo $wpcd_dummy_coupon_img; ?>"
					 src="<?php echo empty( $coupon_thumbnail ) ? $wpcd_dummy_coupon_img : $coupon_thumbnail; ?>"
					 alt="Coupon">
			</div>

			<div class="wpcd-template-five-texts">
				<h2 class="wpcd-coupon-five-title"><?php if ( ! empty( $title ) ) {
						echo $title;
					} else {
						echo __( 'Sample Coupon Code', 'wpcd-coupon' );
					} ?></h2>
				<p class="wpcd-coupon-description"><?php if ( ! empty( $description ) ) {
						echo $description;
					} else {
						echo __( 'This is the description of the coupon code. You can add additional details about the coupon here, what the coupon or deal is.', 'wpcd-coupon' );
					} ?></p>
			</div>
		</div>

		<div class="extra-wpcd-template-five-holder">
			<div class="wpcd-template-five-exp" style="background-color: <?php echo $wpcd_template_five_theme; ?>">
				<!-- <p>Expires On: 12/31/17</p> -->
				<div class="with-expiration1 <?php echo( empty( $expire_date ) ? 'hidden' : '' );
				echo( $show_expiration !== 'Hide' ? '' : ' hide-expire-preview' ); ?> ">
					<div class="wpcd-coupon-five-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-five-expire-text"><?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?></p>
					</div>
					<div class="wpcd-coupon-five-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-five-expired">
							<?php
							if ( ! empty( $expired_text ) ) {
								echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';;
							} else {
								echo __( 'Expired on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?>
						</p>
					</div>
				</div>
				<div class="wpcd-coupon-five-expire without-expiration1 <?php echo( empty( $expire_date ) ? '' : 'hidden' );
				echo( $show_expiration !== 'Hide' ? '' : ' hide-expire-preview' ); ?>">
					<?php if ( ! empty( $no_expiry ) ) { ?>
						<p><?php echo $no_expiry; ?></p>
					<?php } else { ?>
						<p><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></p>
					<?php }
					?>
				</div>
			</div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
				   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
				   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
					   echo $hidden_coupon_hover_text;
				   } else {
					   _e( 'Click Here to Show Code', 'wpcd-coupon' );
				   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $coupon_code ) ) {
							echo $coupon_code;
						} else {
							echo __( 'COUPONCODE', 'wpcd-coupon' );
						} ?></span>
					<span class="get-code-wpcd" style="background-color: <?php echo $wpcd_template_five_theme; ?>">
						<?php
						if ( ! empty( $hide_coupon_text ) ) {
							echo $hide_coupon_text;
						} else {
							echo __( 'Show Code', 'wpcd-coupon' );
						}
						?>
						<div style="border-left-color: <?php echo $wpcd_template_five_theme; ?>"></div>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<a class="wpcd-template-five-btn masterTooltip" href="#"
					   title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
					   data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
						   echo $coupon_code;
					   } else {
						   echo __( 'COUPONCODE', 'wpcd-coupon' );
					   } ?>" style="border-color: <?php echo $wpcd_template_five_theme; ?>">
						<p class="coupon-code-button"
						   style="color: <?php echo $wpcd_template_five_theme; ?>"><?php echo( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) ); ?></p>
					</a>
				</div>
				<div class="wpcd-deal-code">
					<a class="wpcd-template-five-btn masterTooltip" href="#"
					   title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
					   data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
						   echo $deal_text;
					   } else {
						   echo __( 'Claim This Deal', 'wpcd-coupon' );
					   } ?>" style="border-color: <?php echo $wpcd_template_five_theme; ?>">
						<p class="deal-code-button" style="color: <?php echo $wpcd_template_five_theme; ?>">
							<?php if ( ! empty( $deal_text ) ) {
								echo $deal_text;
							} else {
								echo __( 'Claim This Deal', 'wpcd-coupon' );
							} ?>
						</p>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Template Six Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-six" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
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
				<h2 class="wpcd-coupon-six-title"><?php if ( ! empty( $title ) ) {
						echo $title;
					} else {
						echo __( 'Sample Coupon Code', 'wpcd-coupon' );
					} ?>
				</h2>
				<p class="wpcd-coupon-description"><?php if ( ! empty( $description ) ) {
						echo $description;
					} else {
						echo __( 'This is the description of the coupon code. You can add additional details about the coupon here, what the coupon or deal is.', 'wpcd-coupon' );
					} ?>
				</p>
			</div>
			<div class="exp" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
				<p>
					<b class="expires-on">
						<?php
						if ( ! empty( $expire_text ) ) {
							echo $expire_text;
						} else {
							echo __( 'Expires on: ', 'wpcd-coupon' );
						}
						?>
						
					<span class="wpcd-coupon-six-countdown" id="clock_six_<?php echo $post_id; ?>"></span>
						<?php if ( ! $expire_date ) {
								$expire_date_format = date( 'd/m/Y' );
						} ?>
						<script type="text/javascript">
							var hasDate = "<?php echo empty( $expire_date ) ? 'no' : 'yes';?>";
							if (hasDate === 'no')
								jQuery('#clock_six_<?php echo $post_id; ?>').hide();

							var $clock2 = jQuery('#clock_six_<?php echo $post_id; ?>').countdown('<?php echo $expire_date_format . ' ' . $expire_time; ?>', function (event) {
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
								jQuery(this).html(event.strftime(format));

								if (event.offset.weeks == 0 && event.offset.totalDays == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds == 0) {
									jQuery(this).addClass('wpcd-countdown-expired').html('<?php echo __( 'This offer has expired!', 'wpcd-coupon' ); ?>');
								} else {
									jQuery(this).html(event.strftime(format));
									jQuery('#clock_six_<?php echo $post_id; ?>').removeClass('wpcd-countdown-expired');
								}
							});

							jQuery("#expire-time").change(function () {
								jQuery('#clock_six_<?php echo $post_id; ?>').show();
								var coup_date = jQuery("#expire-date").val();
								if (coup_date.indexOf("-") >= 0) {
									var dateAr = coup_date.split('-');
									coup_date = dateAr[1] + '/' + dateAr[0] + '/' + dateAr[2];
								}
								selectedDate = coup_date + ' ' + jQuery("#expire-time").val();
								$clock2.countdown(selectedDate.toString());
							});
						</script>
					</b>
					<b class="never-expire" style="display: none;">
						<?php if ( ! empty( $no_expiry ) ) : ?>
								<b><?php echo $no_expiry; ?></b>
						<?php else : ?>
								<b><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></b>
						<?php endif; ?>

					</b>
					
				</p>
			</div>
		</div>
		<div class="wpcd-coupon-six-img-and-btn">
			<div class="item-img">
				<img data-src="<?php echo $wpcd_dummy_coupon_img; ?>"
					 src="<?php echo empty( $coupon_thumbnail ) ? $wpcd_dummy_coupon_img : $coupon_thumbnail; ?>"
					 alt="Coupon">
			</div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<div class="wpcd-btn-wrap">
					<a data-type="code" data-coupon-id="<?php echo $post_id; ?>" href=""
					   class="coupon-button coupon-code-wpcd masterTooltip" id="coupon-button-<?php echo $post_id; ?>"
					   title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
						   echo $hidden_coupon_hover_text;
					   } else {
						   _e( 'Click Here to Show Code', 'wpcd-coupon' );
					   } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>"
					   style="border-color: <?php echo $wpcd_template_six_theme; ?>">
					<span class="code-text-wpcd" rel="nofollow"><?php if ( ! empty( $coupon_code ) ) {
							echo $coupon_code;
						} else {
							echo __( 'COUPONCODE', 'wpcd-coupon' );
						} ?></span>
						<span class="get-code-wpcd" style="background-color: <?php echo $wpcd_template_six_theme; ?>">
						<?php
						if ( ! empty( $hide_coupon_text ) ) {
							echo $hide_coupon_text;
						} else {
							echo __( 'Show Code', 'wpcd-coupon' );
						}
						?>
							<div style="border-left-color: <?php echo $wpcd_template_six_theme; ?>"></div>
					</span>
					</a>
				</div>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code wpcd-btn-wrap">
					<a class="wpcd-template-six-btn masterTooltip" href="#"
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
				<div class="wpcd-deal-code wpcd-btn-wrap">
					<a class="wpcd-template-six-btn masterTooltip" href="#"
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
			</div>
		</div>
	</div>
</div>

<!-- Template Seven Preview -->
<section class="admin_wpcd_seven">
 	<div class="wpcd-coupon-preview admin_wpcd_container wpcd-coupon-seven">
 		<div class="admin_wpcd_couponBox">
 			<div class="admin_wpcd_percentAndPic">
 				<div class="admin_wpcd_percentOff">
 					<p><?php echo $discount_text; ?></p>
 				</div>
 				<div class="admin_wpcd_productPic">
 					<img src="http://rdironworks.com/wp-content/uploads/2017/12/dummy-200x200.png" alt="Product-pic">
 				</div>
 			</div>
 
 			<div class="admin_wpcd_headingAndExpire">
 				<div class="admin_wpcd_heading">
 				<?php
 					if ( 'on' === $disable_coupon_title_link ) { ?>
 						<<?php echo esc_html( $coupon_title_tag ); ?> class="admin_wpcd-new-title">
 							<?php echo $title; ?>
 						</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
 					} else { ?>
 						<<?php echo esc_html( $coupon_title_tag ); ?> class="admin_wpcd-new-title">
 							<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
 						</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
 	
 					}?>
 					<p><?php echo wpautop( $description, false );?></p>
 					<div class="admin_wpcd_expire"><p>Expires on: 6 weeks 5 days 02 hours 10 minutes 05 seconds</p></div>
 				</div>		
 			</div>
 			<div class="admin_wpcd_buttonSociaLikeDislike">
 				<div class="admin_wpcd_btn">
 					<a href="#" title="wpcd10">wpcd10</a>
 				</div>
 			</div>
 		</div>
 	</div>
 </section>

<!-- Image Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-image">
	<img style="max-width:100%;" src="<?php echo is_array( $coupon_image_src ) ? $coupon_image_src[0] : ''; ?>"
		 alt="<?php _e( 'Coupon image not uploaded', 'wpcd-coupon' ); ?>">
</div>

<!-- Info -->
<p>
	<i><strong><?php echo __( 'Note:', 'wpcd-coupon' ); ?></strong> <?php echo __( 'This is just to show how the coupon will look. Click to copy functionality, showing hidden coupon will not work here, but it will work on posts, pages where you put the shortcode.', 'wpcd-coupon' ); ?>
	</i></p>
