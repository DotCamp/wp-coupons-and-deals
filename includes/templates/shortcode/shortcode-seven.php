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
 <section class="wpcd_seven">
 	<div class="wpcd_container">
 		<div class="wpcd_couponBox">
 			<div class="wpcd_percentAndPic">
 				<div class="wpcd_percentOff">
 					<p><?php echo $discount_text; ?></p>
 				</div>
 				<div class="wpcd_productPic">
 					<img src="http://rdironworks.com/wp-content/uploads/2017/12/dummy-200x200.png" alt="Product-pic">
 				</div>
 			</div>
 			<div class="wpcd_headingAndExpire">
 				<div class="wpcd_heading">
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
 					<div class="wpcd_expire">
 						<p>
 						<?php if( ! empty( $expire_date ) && $never_expire != 'on' ): ?>
 							<span class="wpcd-coupon-two-countdown-text">
 								<?php
 								if ( ! empty( $expire_text ) ) {
 									echo $expire_text;
 								} else {
 									echo __( 'Expires on: ', 'wpcd-coupon' );
 								}
 								?>
 							</span>
 							<span class="wpcd-coupon-two-countdown test"
 								data-countdown_coupon="<?php echo $expire_date_format . ' ' . $expire_time; ?>"
 								id="clock_<?php echo $coupon_id; ?>"></span>
 						<?php else : ?>
 							<span style="color: green;">
 								<?php if ( ! empty( $no_expiry ) ) {
 									echo $no_expiry;
 								} else {
 									echo __( "Doesn't expire", 'wpcd-coupon' );
 								} ?>
 							</span>    
 						<?php endif; ?>
 						</p>
 					</div>
 				</div>
 			</div>
 			<div class="wpcd_buttonSociaLikeDislike">
 				<div class="wpcd_btn">
 					<a href="#" title="wpcd10">wpcd10</a>
 				</div>
 			</div>
 		</div>
 	</div>
</section>