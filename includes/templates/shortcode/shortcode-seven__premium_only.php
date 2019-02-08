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
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$dt_coupon_type_name       = get_option( 'wpcd_dt-coupon-type-text' );
$dt_deal_type_name         = get_option( 'wpcd_dt-deal-type-text' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );
$never_expire              = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$expire_date_format        = date( "m/d/Y", strtotime( $expire_date ) );
$expire_time               = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$post_id                   = get_the_ID();

$dt_coupon_type_name = ( !empty( $dt_coupon_type_name ) ) ? $dt_coupon_type_name : __( 'Coupon', 'wpcd-coupon' );
$dt_deal_type_name = ( !empty( $dt_deal_type_name ) ) ? $dt_deal_type_name : __( 'Deal', 'wpcd-coupon' );
$expire_text = ( !empty( $expire_text ) ) ? $expire_text : __( 'Expires On: ', 'wpcd-coupon' );
$expired_text = ( !empty( $expired_text ) ) ? $expired_text : __( 'Expired On: ', 'wpcd-coupon' );
$no_expiry = ( !empty( $no_expiry ) ) ? $no_expiry : __( "Doesn't expire", 'wpcd-coupon' );
$coupon_hover_text = ( ! empty( $coupon_hover_text ) ) ? $coupon_hover_text : __( 'Click To Copy Coupon', 'wpcd-coupon' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}

wp_enqueue_script( 'wpcd-clipboardjs' );
$template = new WPCD_Template_Loader();

?>
<section class="wpcd_seven wpcd_seven_shortcode">
	<div class="wpcd_seven_container">
		<div class="wpcd_seven_couponBox">
			<div class="wpcd_seven_percentAndPic">
				<div class="wpcd_seven_percentOff">
					<p><?php echo $discount_text; ?></p>
				</div>
				<div class="wpcd_seven_productPic">
					<img src="http://rdironworks.com/wp-content/uploads/2017/12/dummy-200x200.png" alt="Product-pic">
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
			<div class="wpcd_seven_buttonSociaLikeDislike">
				<div class="wpcd_seven_btn">
					<a href="#" title="<?php echo $coupon_code; ?>"><?php echo $coupon_code; ?></a>
				</div>
			</div>
				<div class="wpcd_seven_expire_correct_box">
					<div class="wpcd_seven_expire">
						<p>
							<?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' );
							}
							?>
							<span class="wpcd-coupon-seven-countdown" id="clock_seven_<?php echo $post_id; ?>"></span>
							
							<?php if ( ! $expire_date ) {
									$expire_date_format = date( 'd/m/Y' );
							} ?>
							<script type="text/javascript">
								
								var hasDate = "<?php echo empty( $expire_date ) ? 'no' : 'yes';?>";
								if (hasDate === 'no')
									jQuery('#clock_seven_<?php echo $post_id; ?>').hide();
								var $clock2 = jQuery('#clock_seven_<?php echo $post_id; ?>').countdown('<?php echo $expire_date_format . ' ' . $expire_time; ?>', function (event) {
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
									$clock2.countdown(selectedDate.toString());
								});
							</script>	
							<b class="never-expire" style="display: none;">
								<?php if ( ! empty( $no_expiry ) ) : ?>
										<b><?php echo $no_expiry; ?></b>
								<?php else : ?>
										<b><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></b>
								<?php endif; ?>

							</b>
						</p>
					</div><!-- End of class wpcd_seven_expire -->
				</div>
			<div class="wpcd_seven_couponBox_both"></div>
		</div>
	</div>
</section>