<?php

/**
 * Builds the coupon preview meta box.
 *
 * @since 2.0
 */
if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
	include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

$post_id                  	   = get_the_ID();
$title                    	   = get_the_title();
$description              	   = get_post_meta( $post_id, 'coupon_details_description', true );
$coupon_thumbnail         	   = wpcd_coupon_thumbnail_img( $post_id );
$coupon_thumbnail_not_featured = wpcd_coupon_thumbnail_img( $post_id, true );
$coupon_type              	   = get_post_meta( $post_id, 'coupon_details_coupon-type', true );
$discount_text            	   = get_post_meta( $post_id, 'coupon_details_discount-text', true );
$second_discount_text     	   = get_post_meta( $post_id, 'coupon_details_second-discount-text', true );
$third_discount_text      	   = get_post_meta( $post_id, 'coupon_details_third-discount-text', true );
$link                     	   = get_post_meta( $post_id, 'coupon_details_link', true );
$coupon_code              	   = get_post_meta( $post_id, 'coupon_details_coupon-code-text', true );
$second_coupon_code       	   = get_post_meta( $post_id, 'coupon_details_second-coupon-code-text', true );
$third_coupon_code        	   = get_post_meta( $post_id, 'coupon_details_third-coupon-code-text', true );
$deal_text                	   = get_post_meta( $post_id, 'coupon_details_deal-button-text', true );
$second_deal_text          	   = get_post_meta( $post_id, 'coupon_details_second-deal-button-text', true );
$third_deal_text           	   = get_post_meta( $post_id, 'coupon_details_third-deal-button-text', true );
$coupon_hover_text        	   = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text          	   = get_option( 'wpcd_deal-hover-text' );
$button_class             	   = '.wpcd-btn-' . $post_id;
$no_expiry                	   = get_option( 'wpcd_no-expiry-message' );
$expire_text              	   = get_option( 'wpcd_expire-text' );
$expired_text             	   = get_option( 'wpcd_expired-text' );
$hide_coupon_text         	   = get_option( 'wpcd_hidden-coupon-text' );
$hide_coupon_button_color 	   = get_option( 'wpcd_hidden-coupon-button-color' );
$hidden_coupon_hover_text 	   = get_option( 'wpcd_hidden-coupon-hover-text' );
$show_expiration          	   = get_post_meta( $post_id, 'coupon_details_show-expiration', true );
$today                    	   = date( 'd-m-Y' );
$time_now                 	   = time();
$expire_date              	   = get_post_meta( $post_id, 'coupon_details_expire-date', true );
$second_expire_date       	   = get_post_meta( $post_id, 'coupon_details_second-expire-date', true );
$third_expire_date        	   = get_post_meta( $post_id, 'coupon_details_third-expire-date', true );
$expire_time              	   = get_post_meta( $post_id, 'coupon_details_expire-time', true );
$expireDateFormat         	   = get_option( 'wpcd_expiry-date-format' );
$hide_coupon              	   = get_post_meta( $post_id, 'coupon_details_hide-coupon', true );
$coupon_image_id          	   = get_post_meta( $post_id, 'coupon_details_coupon-image-input', true );
$coupon_image_src         	   = wp_get_attachment_image_src( $coupon_image_id, 'full' );
$wpcd_template_five_theme 	   = get_post_meta( $post_id, 'coupon_details_template-five-theme', true );
$wpcd_template_six_theme  	   = get_post_meta( $post_id, 'coupon_details_template-six-theme', true );
$wpcd_template_seven_theme     = get_post_meta( $post_id, 'coupon_details_template-seven-theme', true );
$wpcd_template_eight_theme     = get_post_meta( $post_id, 'coupon_details_template-eight-theme', true );
$wpcd_dummy_coupon_img         = WPCD_Plugin::instance()->plugin_assets . 'admin/img/coupon-200x200.png';
$wpcd_text_to_show        	   = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text              = get_option( 'wpcd_custom-text' );
$wpcd_eight_btn_text           = get_option( 'wpcd_eight-button-text' );

/** Alternative Template Variables */
global $coupon_id;
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$coupon_title_tag          = get_option( 'wpcd_coupon-title-tag', 'h1' );
$dt_coupon_type_name       = get_option( 'wpcd_dt-coupon-type-text' );

/** Seven Template Variables */
$never_expire              = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );


if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}

if ( $expireDateFormat == 'mm/dd/yy' ) {
	$expireDateFormatFun = 'm/d/Y';
} elseif ( $expireDateFormat == 'yy/mm/dd' ) {
	$expireDateFormatFun = 'Y/m/d';
} else {
	$expireDateFormatFun = 'd-m-Y';
}
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
$expire_date_format = date( "m/d/Y", strtotime( $expire_date ) );

/** Setting Default Values if Empty */
$title = ( !empty( $title ) ) ? $title : __( 'Sample Coupon Title' );
$description = ( !empty( $description ) ) ? $description : __( 'This is the description of the coupon code. Additional details of what the coupon or deal is.' );
$coupon_type = ( !empty( $coupon_type ) ) ? $coupon_type : __( 'Coupon' );
$coupon_code = ( !empty( $coupon_code ) ) ? $coupon_code : __( 'COUPONCODE' );
$second_coupon_code = ( !empty( $second_coupon_code ) ) ? $second_coupon_code : __( 'COUPONCODE' );
$third_coupon_code = ( !empty( $third_coupon_code ) ) ? $third_coupon_code : __( 'COUPONCODE' );
$discount_text = ( !empty( $discount_text ) ) ? $discount_text : __( 'Discount Text' );
$second_discount_text = ( !empty( $second_discount_text ) ) ? $second_discount_text : __( 'Discount Text' );
$third_discount_text = ( !empty( $third_discount_text ) ) ? $third_discount_text : __( 'Discount Text' );
$discount_text = ( !empty( $discount_text ) ) ? $discount_text : __( 'Discount Text' );
$deal_text = ( !empty( $deal_text ) ) ? $deal_text : __( 'Claim This Deal' );
$second_deal_text = ( !empty( $second_deal_text ) ) ? $second_deal_text : __( 'Claim This Deal' );
$third_deal_text = ( !empty( $third_deal_text ) ) ? $third_deal_text : __( 'Claim This Deal' );
$coupon_hover_text = ( !empty( $coupon_hover_text ) ) ? $coupon_hover_text : __( 'Click To Copy Coupon' );
$deal_hover_text = ( !empty( $deal_hover_text ) ) ? $deal_hover_text : __( 'Click Here To Get This Deal' );
$no_expiry = ( !empty( $no_expiry ) ) ? $no_expiry : __( "Doesn't Expire" );
$expire_text = ( !empty( $expire_text ) ) ? $expire_text : __( 'Expires on: ' );
$expired_text = ( !empty( $expired_text ) ) ? $expired_text : __( 'Expired on: ' );
$hide_coupon_text = ( !empty( $hide_coupon_text ) ) ? $hide_coupon_text : __( 'Show Code' );
$hidden_coupon_hover_text = ( !empty( $hidden_coupon_hover_text ) ) ? $hidden_coupon_hover_text : __( 'Click Here to Show Code' );
$wpcd_eight_btn_text = ( !empty( $wpcd_eight_btn_text ) ) ? $wpcd_eight_btn_text : __( 'GET THE DEAL', 'wpcd-coupon' );

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
			<?php echo $discount_text; ?>
		</div>
		<div class="coupon-type">
			<?php echo $coupon_type; ?>
		</div>
	</div>
	<div class="wpcd-coupon-content wpcd-col-7-8">
		<div class="wpcd-coupon-header">
			<div class="wpcd-col-3-4">
				<div class="wpcd-coupon-title">
					<?php echo $title; ?>
				</div>
			</div>
			<div class="wpcd-col-1-4">
				<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
					<a  data-type="code"
						data-coupon-id="<?php echo $post_id; ?>"
						href=""
					   	class="coupon-button coupon-code-wpcd masterTooltip"
						id="coupon-button-<?php echo $post_id; ?>"
					   	title="<?php echo $hidden_coupon_hover_text; ?>"
						data-position="top center"
						data-inverted=""
						data-aff-url="<?php echo $link; ?>">
						<span class="code-text-wpcd" rel="nofollow">
							<?php echo $coupon_code; ?>
						</span>
						<span class="get-code-wpcd">
							<?php echo $hide_coupon_text; ?>
						</span>
					</a>
				</div>
				<div class="wpcd-coupon-not-hidden">
					<div class="wpcd-coupon-code">
						<button
							class="wpcd-btn masterTooltip wpcd-coupon-button"
							title="<?php echo $coupon_hover_text; ?>"
							data-clipboard-text="<?php echo $coupon_code; ?>">
							<span class="wpcd_coupon_icon"></span>
							<span class="coupon-code-button">
								<?php echo $coupon_code; ?>
							</span>
						</button>
					</div>
					<div class="wpcd-deal-code">
						<button
							class="wpcd-btn masterTooltip wpcd-deal-button"
							title="<?php echo $deal_hover_text; ?>"
							data-clipboard-text="<?php echo $deal_text; ?>">
							<span class="wpcd_deal_icon"></span>
							<span class="deal-code-button">
								<?php echo $deal_text; ?>
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="wpcd-extra-content">
			<div class="wpcd-col-3-4">
				<div class="wpcd-coupon-description">
					<?php echo $description; ?>
				</div>
			</div>
			<div class="wpcd-col-1-4">
                <div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
                    <div class="wpcd-coupon-expire expire-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? 'hidden' : ''; ?>">
                        <?php echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>'; ?>
                    </div>
                    <div class="wpcd-coupon-expired expired-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? 'hidden' : ''; ?>">
                        <?php echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>'; ?>
                    </div>
                </div>
                <div class="wpcd-coupon-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
                    <?php echo $no_expiry; ?>
                </div>
			</div>
		</div>
	</div>
</div><!-- End of Default Preview -->

<!-- Template One Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-one">
	<div class="wpcd-col-one-1-8">
		<figure>
			<img class="wpcd-coupon-one-img wpcd-get-fetured-img"
                 data-src="<?php echo $coupon_thumbnail_not_featured; ?>"
                 src="<?php echo $coupon_thumbnail; ?>">
		</figure>
	</div>
	<div class="wpcd-col-one-7-8">
		<h4 class="wpcd-coupon-one-title">
			<?php echo $title; ?>
		</h4>
		<div id="clear"></div>
		<div class="wpcd-coupon-description">
			<?php echo $description; ?>
		</div>
	</div>
	<div class="wpcd-col-one-1-4">
		<div class="wpcd-coupon-one-discount-text">
			<?php echo $discount_text; ?>
		</div>
		<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
			<a 	data-type="code"
				data-coupon-id="<?php echo $post_id; ?>"
				href=""
			   	class="coupon-button coupon-code-wpcd masterTooltip"
				id="coupon-button-<?php echo $post_id; ?>"
			   	title="<?php echo $hidden_coupon_hover_text; ?>"
				data-position="top center"
				data-inverted=""
				data-aff-url="<?php echo $link; ?>">
				<span class="code-text-wpcd" rel="nofollow">
					<?php echo $coupon_code; ?>
				</span>
				<span class="get-code-wpcd">
					<?php echo $hide_coupon_text; ?>
				</span>
			</a>
		</div>
		<div class="wpcd-coupon-not-hidden">
			<div class="wpcd-coupon-code">
				<button
					class="wpcd-btn masterTooltip wpcd-coupon-button"
					title="<?php echo $coupon_hover_text; ?>"
					data-clipboard-text="<?php echo $coupon_code;?>">
					<span class="wpcd_coupon_icon"></span>
					<span class="coupon-code-button"
						><?php echo $coupon_code; ?>
					</span>
				</button>
			</div>
			<div class="wpcd-deal-code">
				<button
					class="wpcd-btn masterTooltip wpcd-deal-button"
					title="<?php echo $deal_hover_text; ?>"
					data-clipboard-text="<?php echo $deal_text; ?>">
					<span class="wpcd_deal_icon"></span>
					<span class="deal-code-button">
						<?php echo $deal_text; ?>
					</span>
				</button>
			</div>
		</div>
			<div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
				<div class="wpcd-coupon-one-expire expire-text-block1 <?php echo strtotime( $expire_date ) <= strtotime( $today ) ? 'hidden' : ''; ?>">
					<?php echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';?>
				</div>
				<div class="wpcd-coupon-one-expired expired-text-block1 <?php echo strtotime( $expire_date ) > strtotime( $today ) ? 'hidden' : ''; ?>">
					<?php echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';?>
				</div>
			</div>
			<div class="wpcd-coupon-one-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
				<?php echo $no_expiry; ?>
			</div>
		<div id="clear"></div>
	</div>
	<div id="clear"></div>
</div><!-- End of Template One Preview -->

<!-- Template Two Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-two">
	<div class="wpcd-col-two-1-4">
			<figure>
				<img class="wpcd-coupon-two-img wpcd-get-fetured-img"
                     data-src="<?php echo $coupon_thumbnail_not_featured; ?>"
                     src="<?php echo $coupon_thumbnail; ?>">
			</figure>
		<div class="wpcd-coupon-two-discount-text">
			<?php echo $discount_text; ?>
		</div>
	</div>
	<div class="wpcd-col-two-3-4">
		<div class="wpcd-coupon-two-header">
			<div>
				<h4 class="wpcd-coupon-title"><?php echo $title; ?></h4>
			</div>
		</div>
		<div class="wpcd-coupon-two-info">
			<div class="wpcd-coupon-two-title">
				<b class="expires-on" <?php echo empty( $expire_date ) ? 'style="display:none"' : ''; ?>>
					<span >
						<?php echo $expire_text; ?>
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
				<b class="never-expire" <?php echo empty( $expire_date ) ? '' : 'style="display:none"'; ?>>
					<b><?php echo $no_expiry; ?></b>
				</b>
			</div>
			<div class="wpcd-coupon-two-coupon">
				<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
					<a
						data-type="code"
						data-coupon-id="<?php echo $post_id; ?>"
						href=""
						class="coupon-button coupon-code-wpcd masterTooltip"
						id="coupon-button-<?php echo $post_id; ?>"
						title="<?php echo $hidden_coupon_hover_text; ?>"
						data-position="top center"
						data-inverted=""
						data-aff-url="<?php echo $link; ?>">
						<span class="code-text-wpcd" rel="nofollow">
							<?php echo $coupon_code; ?>
						</span>
						<span class="get-code-wpcd">
							<?php echo $hide_coupon_text; ?>
						</span>
					</a>
				</div>
				<div class="wpcd-coupon-not-hidden">
					<div class="wpcd-coupon-code">
						<button
							class="wpcd-btn masterTooltip wpcd-coupon-button"
							title="<?php echo $coupon_hover_text; ?>"
							data-clipboard-text="<?php echo $coupon_code; ?>">
							<span class="wpcd_coupon_icon"></span>
							<span class="coupon-code-button">
								<?php echo $coupon_code; ?>
							</span>
						</button>
					</div>
					<div class="wpcd-deal-code">
						<button
							class="wpcd-btn masterTooltip wpcd-deal-button"
							title="<?php echo $deal_hover_text; ?>"
							data-clipboard-text="<?php echo $deal_text; ?>">
							<span class="wpcd_deal_icon"></span>
							<span class="deal-code-button">
								<?php echo $deal_text; ?>
							</span>
						</button>
					</div>
				</div>
			</div>
			<div id="clear"></div>
		</div>
		<div id="clear"></div>
		<div class="wpcd-coupon-description">
			<?php echo $description; ?>
		</div>
	</div>
</div><!-- End of Template Two Preview -->

<!-- Template Three Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-three">
	<div class="wpcd-coupon-three-content">
		<h4 class="wpcd-coupon-three-title">
			<?php echo $title; ?>
		</h4>
		<div class="wpcd-coupon-description">
			<?php echo $description; ?>
		</div>
	</div>
	<div class="wpcd-coupon-three-info">
		<div class="wpcd-coupon-three-info-left">
            <div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
                <div class="wpcd-coupon-three-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
                    <p class="wpcd-coupon-three-expire-text">
                        <?php echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';
                        ?>
                    </p>
                </div>
                <div class="wpcd-coupon-three-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
                    <p class="wpcd-coupon-three-expired">
                        <?php echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>'; ?>
                    </p>
                </div>
            </div>
            <div class="wpcd-coupon-three-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
                <p><?php echo $no_expiry; ?></p>
            </div>
		</div>
		<div class="wpcd-coupon-three-coupon">
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a
					data-type="code"
					data-coupon-id="<?php echo $post_id; ?>"
					href=""
					class="coupon-button coupon-code-wpcd masterTooltip"
					id="coupon-button-<?php echo $post_id; ?>"
					title="<?php echo $hidden_coupon_hover_text; ?>"
					data-position="top center"
					data-inverted=""
					data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow">
						<?php echo $coupon_code; ?>
					</span>
					<span class="get-code-wpcd">
						<?php echo $hide_coupon_text; ?>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<button
						class="wpcd-btn masterTooltip wpcd-coupon-button"
						title="<?php echo __( 'Click Here To Copy Coupon', 'wpcd-coupon' ); ?>"
						data-clipboard-text="<?php echo $coupon_code; ?>">
						<span class="wpcd_coupon_icon"></span>
						<span class="coupon-code-button">
							<?php echo $coupon_code; ?>
						</span>
					</button>
				</div>
				<div class="wpcd-deal-code">
					<button
						class="wpcd-btn masterTooltip wpcd-deal-button"
						title="<?php echo $deal_hover_text; ?>"
						data-clipboard-text="<?php echo $deal_text; ?>">
						<span class="wpcd_deal_icon"></span>
						<span class="deal-code-button">
							<?php echo $deal_text; ?>
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div><!-- End of Template Three Preview -->

<!-- Template Four Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-four">
	<div class="wpcd-coupon-four-content">
		<h4 class="wpcd-coupon-four-title">
			<?php echo $title; ?>
		</h4>
		<div class="wpcd-coupon-description">
			<?php echo $description; ?>
		</div>
	</div>

	<!-- start first coupon -->
	<div class="wpcd-coupon-four-info">
		<div class="wpcd-coupon-four-coupon">
			<div class="wpcd-four-discount-text">
				<?php echo $discount_text; ?>
			</div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a
					data-type="code"
					data-coupon-id="<?php echo $post_id; ?>"
					href=""
					class="coupon-button coupon-code-wpcd masterTooltip"
					id="coupon-button-<?php echo $post_id; ?>"
					title="<?php echo $hidden_coupon_hover_text; ?>"
					data-position="top center"
					data-inverted=""
					data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow">
						<?php echo $coupon_code; ?>
					</span>
					<span class="get-code-wpcd">
						<?php echo $hide_coupon_text; ?>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<button
						class="wpcd-btn masterTooltip wpcd-coupon-button"
						title="<?php echo $coupon_hover_text; ?>"
						data-clipboard-text="<?php echo $coupon_code; ?>">
						<span class="wpcd_coupon_icon"></span>
						<span class="coupon-code-button">
							<?php echo $coupon_code; ?>
						</span>
					</button>
				</div>
				<div class="wpcd-deal-code">
					<button
						class="wpcd-btn masterTooltip wpcd-deal-button"
						title="<?php echo $deal_hover_text; ?>"
						data-clipboard-text="<?php echo $deal_text; ?>">
						<span class="wpcd_deal_icon"></span>
						<span class="deal-code-button">
							<?php echo $deal_text; ?>
						</span>
					</button>
				</div>
			</div>
		</div>
		<div class="wpcd-coupon-four-info-left">
            <div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
                <div class="wpcd-coupon-four-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
                    <p class="wpcd-coupon-four-expire-text">
                        <?php echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>'; ?>
                    </p>
                </div>
                <div class="wpcd-coupon-four-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
                    <p class="wpcd-coupon-four-expired">
                        <?php echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>'; ?>
                    </p>
                </div>
            </div>
            <div class="wpcd-coupon-four-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
                <p><?php echo $no_expiry; ?></p>
            </div>
		</div>
	</div>
	<!-- end first coupon -->

	<!-- start second coupon -->
	<div class="wpcd-coupon-four-info">
		<div class="wpcd-coupon-four-coupon">
			<div class="wpcd-four-discount-text"><?php echo $second_discount_text; ?></div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a
					data-type="code"
					data-coupon-id="<?php echo $post_id; ?>"
					href=""
					class="coupon-button coupon-code-wpcd masterTooltip"
					id="coupon-button-<?php echo $post_id; ?>"
					title="<?php echo $hidden_coupon_hover_text; ?>"
					data-position="top center"
					data-inverted=""
					data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow">
						<?php echo $second_coupon_code; ?>
					</span>
					<span class="get-code-wpcd">
						<?php echo $hide_coupon_text; ?>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<button
						class="wpcd-btn masterTooltip wpcd-coupon-button"
						title="<?php echo $coupon_hover_text; ?>"
						data-clipboard-text="<?php echo $second_coupon_code; ?>">
						<span class="wpcd_coupon_icon"></span>
						<span class="coupon-code-button">
							<?php echo $second_coupon_code; ?>
						</span>
					</button>
				</div>
				<div class="wpcd-deal-code">
					<button
						class="wpcd-btn masterTooltip wpcd-deal-button"
						title="<?php echo $deal_hover_text; ?>"
						data-clipboard-text="<?php echo $second_deal_text; ?>">
						<span class="wpcd_deal_icon"></span>
						<span class="deal-code-button">
							<?php echo $second_deal_text; ?>
						</span>
					</button>
				</div>
			</div>
		</div>
		<div class="wpcd-coupon-four-info-left">
            <div class="with-expiration-4-2 <?php echo empty( $second_expire_date ) ? 'hidden' : ''; ?>">
                <div class="wpcd-coupon-four-expire expire-text-block2 <?php echo strtotime( $second_expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
                    <p class="wpcd-coupon-four-expire-text">
                        <?php echo $expire_text . ' ' . '<span class="expiration-date">' . $second_expire_date . '</span>'; ?>
                    </p>
                </div>
                <div class="wpcd-coupon-four-expire expired-text-block2 <?php echo strtotime( $second_expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
                    <p class="wpcd-coupon-four-expired">
                        <?php echo $expired_text . ' ' . '<span class="expiration-date">' . $second_expire_date . '</span>'; ?>
                    </p>
                </div>
            </div>
            <div class="wpcd-coupon-four-expire without-expiration-4-2 <?php echo empty( $second_expire_date ) ? '' : 'hidden'; ?>">
                <p><?php echo $no_expiry; ?></p>
            </div>
		</div>
	</div>
	<!-- end second coupon -->

	<!-- start third coupon -->
	<div class="wpcd-coupon-four-info">
		<div class="wpcd-coupon-four-coupon">
			<div class="wpcd-four-discount-text"><?php echo $third_discount_text; ?></div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a
					data-type="code"
					data-coupon-id="<?php echo $post_id; ?>"
					href=""
					class="coupon-button coupon-code-wpcd masterTooltip"
					id="coupon-button-<?php echo $post_id; ?>"
					title="<?php echo $hidden_coupon_hover_text; ?>"
					data-position="top center"
					data-inverted=""
					data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow">
						<?php echo $third_coupon_code; ?>
					</span>
					<span class="get-code-wpcd">
						<?php echo $hide_coupon_text; ?>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<button
						class="wpcd-btn masterTooltip wpcd-coupon-button"
						title="<?php echo $coupon_hover_text; ?>"
						data-clipboard-text="<?php echo $third_coupon_code; ?>">
						<span class="wpcd_coupon_icon"></span>
						<span class="coupon-code-button">
							<?php echo $third_coupon_code; ?>
						</span>
					</button>
				</div>
				<div class="wpcd-deal-code">
					<button
						class="wpcd-btn masterTooltip wpcd-deal-button"
						title="<?php echo $deal_hover_text; ?>"
						data-clipboard-text="<?php echo $third_deal_text; ?>">
						<span class="wpcd_deal_icon"></span>
						<span class="deal-code-button">
							<?php echo $third_deal_text; ?>
						</span>
					</button>
				</div>
			</div>
		</div>
		<div class="wpcd-coupon-four-info-left">
            <div class="with-expiration-4-3 <?php echo empty( $third_expire_date ) ? 'hidden' : ''; ?>">
                <div class="wpcd-coupon-four-expire expire-text-block3 <?php echo strtotime( $third_expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
                    <p class="wpcd-coupon-four-expire-text">
                        <?php echo $expire_text . ' ' . '<span class="expiration-date">' . $third_expire_date . '</span>';?>
                    </p>
                </div>
                <div class="wpcd-coupon-four-expire expired-text-block3 <?php echo strtotime( $third_expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
                    <p class="wpcd-coupon-four-expired">
                        <?php echo $expired_text . ' ' . '<span class="expiration-date">' . $third_expire_date . '</span>'; ?>
                    </p>
                </div>
            </div>
            <div class="wpcd-coupon-four-expire without-expiration-4-3 <?php echo empty( $third_expire_date ) ? '' : 'hidden'; ?>">
                <p><?php echo $no_expiry; ?></p>
            </div>
		</div>
	</div>
	<!-- end third coupon -->
</div><!-- End of Template Four Preview -->

<!-- Template Five Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-five">
	<div class="wpcd-template-five" style="border-color: <?php echo $wpcd_template_five_theme; ?>">
		<div class="wpcd-template-five-holder">
			<div class="wpcd-template-five-percent-off">
				<p class="wpcd-coupon-five-discount-text">
					<?php echo $discount_text; ?>
				</p>
			</div>
			<div class="wpcd-template-five-pro-img">
				<img data-src="<?php echo $coupon_thumbnail_not_featured; ?>"
					 src="<?php echo $coupon_thumbnail; ?>"
					 alt="Coupon">
			</div>

			<div class="wpcd-template-five-texts">
				<h2 class="wpcd-coupon-five-title">
					<?php echo $title; ?></h2>
				<div class="wpcd-coupon-description">
					<?php echo $description; ?>
				</div>
			</div>
		</div>

		<div class="extra-wpcd-template-five-holder">
			<div class="wpcd-template-five-exp" style="background-color: <?php echo $wpcd_template_five_theme; ?>">
				<!-- <p>Expires On: 12/31/17</p> -->
				<div class="with-expiration1 <?php echo( empty( $expire_date ) ? 'hidden' : '' );
				echo( $show_expiration !== 'Hide' ? '' : ' hide-expire-preview' ); ?> ">
					<div class="wpcd-coupon-five-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-five-expire-text">
							<?php echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';?>
						</p>
					</div>
					<div class="wpcd-coupon-five-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
						<p class="wpcd-coupon-five-expired">
							<?php echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>'; ?>
						</p>
					</div>
				</div>
				<div class="wpcd-coupon-five-expire without-expiration1 <?php echo( empty( $expire_date ) ? '' : 'hidden' );
				echo( $show_expiration !== 'Hide' ? '' : ' hide-expire-preview' ); ?>">
					<p><?php echo $no_expiry; ?></p>
				</div>
			</div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<a
					data-type="code"
					data-coupon-id="<?php echo $post_id; ?>"
					href=""
					class="coupon-button coupon-code-wpcd masterTooltip"
					id="coupon-button-<?php echo $post_id; ?>"
					title="<?php echo $hidden_coupon_hover_text; ?>"
					data-position="top center"
					data-inverted=""
					data-aff-url="<?php echo $link; ?>">
					<span class="code-text-wpcd" rel="nofollow">
						<?php echo $coupon_code; ?>
					</span>
					<span class="get-code-wpcd">
						<div class="square_wpcd" style="background-color: <?php echo $wpcd_template_five_theme; ?>"></div>
						<span>
							<?php echo $hide_coupon_text; ?>
						</span>
						<div class="rectangle_wpcd" style="border-left-color: <?php echo $wpcd_template_five_theme; ?>"></div>
					</span>
				</a>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code">
					<a
						class="wpcd-template-five-btn masterTooltip"
						href="#"
					   	title="<?php echo $coupon_hover_text; ?>"
						data-clipboard-text="<?php echo $coupon_code; ?>"
						style="border-color: <?php echo $wpcd_template_five_theme; ?>">
						<p class="coupon-code-button" style="color: <?php echo $wpcd_template_five_theme; ?>">
							<?php echo $coupon_code; ?>
						</p>
					</a>
				</div>
				<div class="wpcd-deal-code">
					<a
						class="wpcd-template-five-btn masterTooltip"
						href="#"
					   	title="<?php echo $deal_hover_text; ?>"
						data-clipboard-text="<?php echo $deal_text; ?>"
						style="border-color: <?php echo $wpcd_template_five_theme; ?>">
						<p class="deal-code-button" style="color: <?php echo $wpcd_template_five_theme; ?>">
							<?php echo $deal_text; ?>
						</p>
					</a>
				</div>
			</div>
		</div>
	</div>
</div><!-- End of Template Five Preview -->

<!-- Template Six Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-six" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
	<div class="wpcd-coupon-six-holder">
		<div class="wpcd-coupon-six-percent-off">
			<div class="wpcd-for-ribbon">
				<div class="wpcd-ribbon" style="background-color: <?php echo $wpcd_template_six_theme; ?>">
					<div class="wpcd-ribbon-before"
						 style="border-left-color: <?php echo $wpcd_template_six_theme; ?>"></div>
					<p class="wpcd-coupon-six-discount-text">
						<?php echo $discount_text; ?>
					</p>
					<div class="wpcd-ribbon-after" style="border-right-color: <?php echo $wpcd_template_six_theme; ?>"></div>
				</div>
			</div>
		</div>
		<div class="wpcd-coupon-six-texts">
			<div class="texts">
				<h2 class="wpcd-coupon-six-title">
					<?php echo $title; ?>
				</h2>
				<div class="wpcd-coupon-description">
					<?php echo $description; ?>
				</div>
			</div>
			<div class="exp" style="border-color: <?php echo $wpcd_template_six_theme; ?>">
				<p>
					<b class="expires-on"  <?php echo empty( $expire_date ) ? 'style="display:none"' : ''; ?>>
						<?php echo $expire_text; ?>
						<span class="wpcd-coupon-six-countdown" id="clock_six_<?php echo $post_id; ?>"></span>
						<?php if ( ! $expire_date ) {
								$expire_date_format = date( 'd/m/Y' );
						} ?>
						<script type="text/javascript">
							var hasDate = "<?php echo empty( $expire_date ) ? 'no' : 'yes';?>";
							if (hasDate === 'no')
								jQuery('#clock_six_<?php echo $post_id; ?>').hide();

							var $clock6 = jQuery('#clock_six_<?php echo $post_id; ?>').countdown('<?php echo $expire_date_format . ' ' . $expire_time; ?>', function (event) {
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
								$clock6.countdown(selectedDate.toString());
							});
						</script>
					</b>
					<b class="never-expire" <?php echo empty( $expire_date ) ? '' : 'style="display:none"'; ?>>
						<b><?php echo $no_expiry; ?></b>
					</b>
				</p>
			</div>
		</div>
		<div class="wpcd-coupon-six-img-and-btn">
			<div class="item-img">
				<img data-src="<?php echo $coupon_thumbnail_not_featured; ?>"
					 src="<?php echo $coupon_thumbnail; ?>"
					 alt="Coupon">
			</div>
			<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
				<div class="wpcd-btn-wrap">
					<a
						data-type="code"
						data-coupon-id="<?php echo $post_id; ?>"
						href=""
						class="coupon-button coupon-code-wpcd masterTooltip"
						id="coupon-button-<?php echo $post_id; ?>"
						title="<?php echo $hidden_coupon_hover_text; ?>"
						data-position="top center"
						data-inverted=""
						data-aff-url="<?php echo $link; ?>"
					   	style="border-color: <?php echo $wpcd_template_six_theme; ?>">
						<span class="code-text-wpcd" rel="nofollow">
							<?php echo $coupon_code; ?>
						</span>
						<span class="get-code-wpcd">
							<div class="square_wpcd" style="background-color: <?php echo $wpcd_template_six_theme; ?>"></div>
							<span>
								<?php echo $hide_coupon_text; ?>
							</span>
							<div class="rectangle_wpcd" style="border-left-color: <?php echo $wpcd_template_six_theme; ?>"></div>
						</span>
					</a>
				</div>
			</div>
			<div class="wpcd-coupon-not-hidden">
				<div class="wpcd-coupon-code wpcd-btn-wrap">
					<a
						class="wpcd-template-six-btn masterTooltip"
						href="#"
					   	title="<?php echo $coupon_hover_text; ?>"
						data-clipboard-text="<?php echo $coupon_code; ?>"
						style="border-color: <?php echo $wpcd_template_six_theme; ?>">
						<span class="coupon-code-button" style="border-color: <?php echo $wpcd_template_six_theme; ?>; color: <?php echo $wpcd_template_six_theme; ?>">
							  <?php echo $coupon_code; ?>
						</span>
					</a>
				</div>
				<div class="wpcd-deal-code wpcd-btn-wrap">
					<a
						class="wpcd-template-six-btn masterTooltip"
						href="#"
					   	title="<?php echo $deal_hover_text; ?>"
						data-clipboard-text="<?php echo $deal_text; ?>"
						style="border-color: <?php echo $wpcd_template_six_theme; ?>">
						<span class="deal-code-button" style="border-color: <?php echo $wpcd_template_six_theme; ?>;color: <?php echo $wpcd_template_six_theme; ?>">
							<?php echo $deal_text; ?>
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div><!-- End of Template Six Preview -->

<!-- Template Seven Preview -->
<section class="admin_wpcd_seven admin_wpcd_seven_shortcode">
	<div class="wpcd-coupon-preview wpcd-coupon-seven admin_wpcd_seven_container">
		<div class="admin_wpcd_seven_couponBox" style="border-color: <?php echo $wpcd_template_seven_theme; ?>">
			<div class="admin_wpcd_seven_percentAndPic">
				<div class="admin_wpcd_seven_percentOff" style="background-color: <?php echo $wpcd_template_seven_theme; ?>; border-color: <?php echo $wpcd_template_seven_theme; ?>;">
					<p>
						<?php echo $discount_text; ?>
					</p>
				</div>
				<div class="admin_wpcd_seven_productPic">
					<!-- <img src="http://rdironworks.com/wp-content/uploads/2017/12/dummy-200x200.png" alt="Product-pic"> -->
					<img data-src="<?php echo $coupon_thumbnail_not_featured; ?>"
					 src="<?php echo $coupon_thumbnail; ?>"
					 alt="Coupon">
				</div>
			</div>
			<div class="admin_wpcd_seven_headingAndExpire">
				<div class="admin_wpcd_seven_heading">
                    <h2 class="admin_wpcd_seven_new_title">
                        <?php echo $title; ?>
                    </h2>
					<p>
						<?php echo '<div class="wpcd-coupon-description">' . $description . '</div>';?>
					</p>
				</div>
			</div>
			<div class="admin_wpcd_seven_buttonSociaLikeDislike">
				<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
					<a
						data-type="code"
						data-coupon-id="<?php echo $post_id; ?>"
						href=""
						class="coupon-button coupon-code-wpcd masterTooltip"
						id="coupon-button-<?php echo $post_id; ?>"
						title="<?php echo $hidden_coupon_hover_text; ?>"
						data-position="top center"
						data-inverted=""
						data-aff-url="<?php echo $link; ?>">
						<span class="code-text-wpcd" rel="nofollow">
							<?php echo $coupon_code; ?>
						</span>
						<span class="get-code-wpcd">
							<div class="square_wpcd" style="background-color: <?php echo $wpcd_template_seven_theme; ?>"></div>
							<span>
								<?php echo $hide_coupon_text; ?>
							</span>
							<div class="rectangle_wpcd" style="border-left-color: <?php echo $wpcd_template_seven_theme; ?>"></div>
						</span>
					</a>
				</div>
				<div class="wpcd-coupon-not-hidden">
					<div class="wpcd-coupon-code">
		                <div class="admin_wpcd_seven_btn">
		                    <a class="masterTooltip coupon-code-button"
		                    	href="#"
			                    title="<?php echo $coupon_hover_text; ?>"
								data-clipboard-text="<?php echo $coupon_code; ?>"
			                    data-title-ab="<?php echo $coupon_code; ?>"
			                    style="background-color: <?php echo $wpcd_template_seven_theme; ?>; border-color: <?php echo $wpcd_template_seven_theme; ?>; color: <?php echo $wpcd_template_seven_theme; ?>;"><?php echo $coupon_code; ?>
		                    </a>
		                </div>
					</div>
					<div class="wpcd-deal-code">
		                <div class="admin_wpcd_seven_btn">
		                    <a class="masterTooltip deal-code-button"
		                    	href="#"
			                    title="<?php echo $deal_hover_text; ?>"
								data-clipboard-text="<?php echo $deal_text; ?>"
			                    data-title-ab="<?php echo $deal_text; ?>" style="background-color: <?php echo $wpcd_template_seven_theme; ?>; border-color: <?php echo $wpcd_template_seven_theme; ?>; color: <?php echo $wpcd_template_seven_theme; ?>;"><?php echo $deal_text; ?>
			                </a>
		                </div>
					</div>
				</div>
			</div>


				<div class="admin_wpcd_seven_expire_correct_box">
					<div class="admin_wpcd_seven_expire" style="border-color:">
						<p>
                            <b class="expires-on"  <?php echo empty( $expire_date ) ? 'style="display:none"' : ''; ?>>
                                <?php echo $expire_text; ?>
                                <span class="wpcd-coupon-seven-countdown" data-countdown_coupon="<?php echo $expire_date_format . ' ' . $expire_time; ?>" id="clock_seven_<?php echo $post_id; ?>"></span>
                                <?php if ( ! $expire_date ) {
                                        $expire_date_format = date( 'd/m/Y' );
                                } ?>
                                <script type="text/javascript">
                                    var hasDate = "<?php echo empty( $expire_date ) ? 'no' : 'yes';?>";
                                    if (hasDate === 'no')
                                        jQuery('#clock_seven_<?php echo $post_id; ?>').hide();
                                    var $clock7 = jQuery('#clock_seven_<?php echo $post_id; ?>').countdown('<?php echo $expire_date_format . ' ' . $expire_time; ?>', function (event) {
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
                                            jQuery('#clock_seven_<?php echo $post_id; ?>').removeClass('wpcd-countdown-expired');
                                        }
                                    });

                                    jQuery("#expire-time").change(function () {
                                        jQuery('#clock_seven_<?php echo $post_id; ?>').show();
                                        var coup_date = jQuery("#expire-date").val();
                                        if (coup_date.indexOf("-") >= 0) {
                                            var dateAr = coup_date.split('-');
                                            coup_date = dateAr[1] + '/' + dateAr[0] + '/' + dateAr[2];
                                        }
                                        selectedDate = coup_date + ' ' + jQuery("#expire-time").val();
                                        $clock7.countdown(selectedDate.toString());
                                    });
                                </script>
                            </b>
							<b class="never-expire" <?php echo empty( $expire_date ) ? '' : 'style="display:none"'; ?>>
								<b><?php echo $no_expiry; ?></b>
							</b>
						</p>
					</div>
					<!-- End of class wpcd_seven_expire -->
				</div>
			<div class="admin_wpcd_seven_couponBox_both"></div>
		</div>
	</div>
</section><!-- End of Template Seven Preview -->

<!-- Template Eight Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-eight admin-wpcd-new-grid-container">
	<div class="admin-wpcd-new-grid-one">
		<div class="admin-wpcd-new-discount-text wpcd-coupon-discount-text">
			<?php echo $discount_text; ?>
		</div>
		<div class="coupon-type" style="background-color: <?php echo $wpcd_template_eight_theme; ?>">
			<?php echo $coupon_type; ?>
		</div>
        <div class="with-expiration1 <?php echo empty( $expire_date ) ? 'hidden' : ''; ?>">
            <div class="wpcd-coupon-three-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
                <p class="wpcd-coupon-three-expire-text">
                    <?php echo $expire_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';
                    ?>
                </p>
            </div>
            <div class="wpcd-coupon-three-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
                <p class="wpcd-coupon-three-expired">
                    <?php echo $expired_text . ' ' . '<span class="expiration-date">' . $expire_date . '</span>'; ?>
                </p>
            </div>
        </div>
        <div class="wpcd-coupon-three-expire without-expiration1 <?php echo empty( $expire_date ) ? '' : 'hidden'; ?>">
            <p><?php echo $no_expiry; ?></p>
        </div>
   </div> <!-- End of grid-one -->
   <div class="admin-wpcd-new-grid-two">
	   <?php

	    if ( empty( $coupon_title_tag ) ) {
			if ( 'on' === $disable_coupon_title_link ) { ?>
				<<?php echo esc_html( $coupon_title_tag ); ?> class="admin-wpcd-new-title wpcd-coupon-title">
					<?php echo $title; ?>
				</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
			} else { ?>
				<<?php echo esc_html( $coupon_title_tag ); ?> class="admin-wpcd-new-title wpcd-coupon-title">
					<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
				</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
			}
		}
		else { ?>
			<<?php echo esc_html( $coupon_title_tag ); ?> class="admin-wpcd-new-title wpcd-coupon-title">
				<?php echo $title; ?>
			</<?php echo esc_html( $coupon_title_tag ); ?>> <?php

		}
	   ?>
		<div class="wpcd-coupon-description">
			<?php echo $description; ?>
		</div>
	</div> <!-- End of grid-two -->
	<div class="admin-wpcd-new-grid-three">
		<div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
			<a
				data-type="code"
				data-coupon-id="<?php echo $post_id; ?>"
				href=""
				class="coupon-button coupon-code-wpcd masterTooltip"
				id="coupon-button-<?php echo $post_id; ?>"
				title="<?php echo $hidden_coupon_hover_text; ?>"
				data-position="top center"
				data-inverted=""
				data-aff-url="<?php echo $link; ?>">
				<span class="code-text-wpcd" rel="nofollow">
					<?php echo $coupon_code; ?>
				</span>
				<span class="get-code-wpcd">
					<div class="square_wpcd" style="background-color: <?php echo $wpcd_template_eight_theme; ?>"></div>
					<span>
						<?php echo $hide_coupon_text; ?>
					</span>
					<div class="rectangle_wpcd" style="border-left-color: <?php echo $wpcd_template_eight_theme; ?>"></div>
				</span>
			</a>
		</div>
		<div class="wpcd-coupon-not-hidden">
			<div class="wpcd-coupon-code">
				<a class="admin-wpcd-new-coupon-code masterTooltip coupon-code-button" rel="nofollow" href="#" target="_blank" data-clipboard-text="<?php echo $coupon_code; ?>" title="<?php echo $coupon_hover_text; ?>" onmouseover="this.style.borderColor='<?php echo $wpcd_template_eight_theme; ?>';" onmouseout="this.style.borderColor='#cdcdcd';">
					<?php echo $coupon_code; ?>
				</a>
			</div>
		</div>

		<a class="admin-wpcd-new-goto-button masterTooltip" rel="nofollow" href="<?php echo esc_url( $link ); ?>" target="_blank" title="<?php echo $deal_hover_text; ?>" style="background-color: <?php echo $wpcd_template_eight_theme; ?>">
		   <?php echo $deal_text; ?>
		</a>
	</div><!-- End of grid-three -->
</div><!-- End of Template Eight Preview -->

<!-- Image Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-image">
	<img style="max-width:100%;" src="<?php echo is_array( $coupon_image_src ) ? $coupon_image_src[0] : ''; ?>"
		 alt="<?php _e( 'Coupon image not uploaded', 'wpcd-coupon' ); ?>">
</div>

<!-- Info -->
<p>
	<i><strong><?php echo __( 'Note:', 'wpcd-coupon' ); ?></strong> <?php echo __( 'This is just to show how the coupon will look. Click to copy functionality, showing hidden coupon will not work here, but it will work on posts, pages where you put the shortcode.', 'wpcd-coupon' ); ?>
	</i></p>
