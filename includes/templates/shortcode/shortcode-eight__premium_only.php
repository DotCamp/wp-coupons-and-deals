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
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$coupon_hover_text         = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text           = get_option( 'wpcd_deal-hover-text' );
$no_expiry                 = get_option( 'wpcd_no-expiry-message' );
$expire_text               = get_option( 'wpcd_expire-text' );
$expired_text              = get_option( 'wpcd_expired-text' );
$hide_coupon_text          = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text  = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text          = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag          = get_option( 'wpcd_coupon-title-tag', 'h1' );
$coupon_share              = get_option( 'wpcd_coupon-social-share' );
$dt_coupon_type_name       = get_option( 'wpcd_dt-coupon-type-text' );
$dt_deal_type_name         = get_option( 'wpcd_dt-deal-type-text' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );
$wpcd_eight_btn_text       = get_option( 'wpcd_eight-button-text' );
$today                     = date( 'd-m-Y' );
$button_class              = 'wpcd-btn-' . $coupon_id;

$dt_coupon_type_name = ( !empty( $dt_coupon_type_name ) ) ? $dt_coupon_type_name : __( 'Coupon', 'wpcd-coupon' );
$dt_deal_type_name   = ( !empty( $dt_deal_type_name ) ) ? $dt_deal_type_name : __( 'Deal', 'wpcd-coupon' );
$expire_text         = ( !empty( $expire_text ) ) ? $expire_text : __( 'Expires On: ', 'wpcd-coupon' );
$expired_text        = ( !empty( $expired_text ) ) ? $expired_text : __( 'Expired On: ', 'wpcd-coupon' );
$no_expiry           = ( !empty( $no_expiry ) ) ? $no_expiry : __( "Doesn't expire", 'wpcd-coupon' );
$coupon_code         = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) );
$deal_text           = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wpcd-coupon' ) );
$coupon_hover_text   = ( ! empty( $coupon_hover_text ) ) ? $coupon_hover_text : __( 'Click To Copy Coupon', 'wpcd-coupon' );
$deal_hover_text = ( !empty( $deal_hover_text ) ) ? $deal_hover_text : __( 'Click Here To Get This Deal' );
$wpcd_eight_btn_text = ( !empty( $wpcd_eight_btn_text ) ) ? $wpcd_eight_btn_text : __( 'GET THE DEAL', 'wpcd-coupon' );

$wpcd_template_eight_theme  = get_post_meta( $coupon_id, 'coupon_details_template-eight-theme', true );

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else if ( empty( $wpcd_custom_text ) ) {
	$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
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
    $wpcd_uniq_attr_data = 'data-unic-attr="' . esc_attr( $wpcd_uniq_attr ) . '"';
}

?>

<div class="wpcd-new-grid-container wpcd-coupon-id-<?php echo absint( $coupon_id ); ?>" <?php echo $wpcd_uniq_attr_data;?>>
	<div class="wpcd-new-grid-one">
		<div class="wpcd-new-discount-text">
		   <?php echo esc_html( $discount_text ); ?>
		</div>

		<?php if ( $coupon_type == 'Coupon' ) { ?>
			<div class="wpcd-new-coupon-type" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_eight_theme ); ?>">
				<?php echo esc_html( $dt_coupon_type_name ); ?>
			</div>
		<?php } elseif ( $coupon_type == 'Deal' ) { ?>
			<div class="wpcd-new-deal-type" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_eight_theme ); ?>">
				<?php echo esc_html( $dt_deal_type_name ); ?>
			</div>
		<?php }
		if ( $show_expiration == 'Show' ) {
			if ( ! empty( $expire_date ) ) {
				if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
					<p class="wpcd-new-expire-text">
						<?php echo esc_html( $expire_text ) . ' ' . strtotime( $expire_date ) ? $expire_date : ''; ?>
					</p> <?php
				} elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
					<p class="wpcd-new-expired-text">
						<?php echo esc_html( $expired_text ) . ' ' . strtotime( $expire_date ) ? $expire_date : ''; ?>
					</p> <?php
				}
			} else { ?>
				<p class="wpcd-new-expire-text">
					<?php echo esc_html( $no_expiry ); ?>
				</p> <?php
			}
		} else {
			echo '';
		} ?>
   </div> <!-- End of grid-one -->

   <div class="wpcd-new-grid-two">
	   <?php
		if ( 'on' === $disable_coupon_title_link ) { ?>
			<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-new-title">
				<?php echo esc_html( $title ); ?>
			</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
		} else { ?>
			<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-new-title">
				<a href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" rel="nofollow"><?php echo esc_html( $title ); ?></a>
			</<?php echo esc_html( $coupon_title_tag ); ?>> <?php
		}
	   ?>
		<div class="wpcd-coupon-description">
			<span class="wpcd-full-description"><?php echo wp_kses_post( $description ); ?></span>
			<span class="wpcd-short-description"></span>
			<?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
				<a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
				<a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
			<?php endif; ?>
		</div>
	</div> <!-- End of grid-two -->
	<div class="wpcd-new-grid-three">
		<?php if ( $coupon_type === 'Coupon' ): ?>
			<?php if ( $hide_coupon === 'Yes' && ! WPCD_Amp::wpcd_amp_is() ): ?>
				<?php
				$template->get_template_part( 'hide-coupon2__premium_only' );
				?>
			<?php else: ?>
				<a class="wpcd-new-coupon-code <?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> masterTooltip" 
				   rel="nofollow" href="<?php echo esc_url( $link ); ?>" 
				   target="<?php echo esc_attr( $target ); ?>" 
				   data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>" 
				   title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                    if ( ! empty( $coupon_hover_text ) ) {
                                        echo esc_attr( $coupon_hover_text );
                                    } else {
                                        echo __( "Click To Copy Coupon", 'wpcd-coupon' );
                                    }
                                }
                            ?>" 
		           style="border-color: <?php echo sanitize_hex_color( $wpcd_template_eight_theme ); ?>;">
				   <?php echo esc_html( $coupon_code ); ?>
				</a>
			<?php endif; ?>
		<?php endif; ?>
		<a class="wpcd-new-goto-button masterTooltip" rel="nofollow" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php echo esc_attr( $deal_hover_text ); ?>" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_eight_theme ); ?>">
		   <?php echo esc_html( $deal_text ); ?>
		</a>
	</div><!-- End of grid-three -->
	<script type="text/javascript">
		var clip = new Clipboard('.<?php echo esc_atr( $button_class ); ?>');
	</script>
    <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
	    <div class="wpcd-new-grid-footer">
	    <?php    
	    	if ( $coupon_share === 'on' ) {
	    	    $template->get_template_part('social-share');
	        }
	        $template->get_template_part('vote-system'); 
	    ?>
	    </div>
    <?php endif; ?>
</div>

<?php
    if( ! WPCD_Amp::wpcd_amp_is() && ! empty( $show_print_links ) && $show_print_links == 'on') {
        wpcd_coupon_print_link( $wpcd_uniq_attr );
    }
?>