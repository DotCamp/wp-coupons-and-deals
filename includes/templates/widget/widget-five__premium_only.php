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
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                     = date( 'd-m-Y' );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_template_five_theme  = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true );
$wpcd_coupon_thumbnail     = get_the_post_thumbnail_url( $coupon_id );
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );
$wpcd_dummy_coupon_img     = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else if ( empty( $wpcd_custom_text ) ) {
	$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wp-coupons-and-deals' );
}

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
	$expire_date = date( $expireDateFormatFun, $expire_date );
} elseif ( ! empty( $expire_date ) ) {
	$expire_date = date( $expireDateFormatFun, strtotime( $expire_date ) );
}

wp_enqueue_script( 'wpcd-clipboardjs' );

?>

<div class="wpcd-template-five wpcd-widget" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>">
    <div class="wpcd-template-five-holder">
        <div class="wpcd-template-five-percent-off">
            <p class="wpcd-coupon-five-discount-text">
				<?php if ( ! empty( $discount_text ) ) {
					echo esc_html( $discount_text );
				} else {
					echo __( 'Discount Text', 'wp-coupons-and-deals' );
				} ?>
            </p>
        </div>
        <div class="wpcd-template-five-pro-img">
            <img src="<?php echo empty( $wpcd_coupon_thumbnail ) ? esc_url( $wpcd_dummy_coupon_img ) : esc_url( $wpcd_coupon_thumbnail ); ?>"
                 alt="image">
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
                <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wp-coupons-and-deals' ); ?></a>
                <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wp-coupons-and-deals' ); ?></a>
            </div>
        </div>
    </div>

    <div class="extra-wpcd-template-five-holder">
        <div class="wpcd-template-five-exp" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>">
			<?php
			if ( $show_expiration !== 'Hide' ) { ?>
                <div class="with-expiration1 <?php echo empty( trim( $expire_date ) ) ? 'hidden' : ''; ?>">
                    <div class="wpcd-coupon-five-expire expire-text-block1 <?php echo strtotime( $expire_date ) >= strtotime( $today ) ? '' : 'hidden'; ?>">
                        <p class="wpcd-coupon-five-expire-text"><?php
							if ( ! empty( $expire_text ) ) {
								echo esc_html( $expire_text ) . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';
							} else {
								echo __( 'Expires on: ', 'wp-coupons-and-deals' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?></p>
                    </div>
                    <div class="wpcd-coupon-five-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
                        <p class="wpcd-coupon-five-expired">
							<?php
							if ( ! empty( $expired_text ) ) {
								echo esc_html( $expired_text ) . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';
							} else {
								echo __( 'Expired on: ', 'wp-coupons-and-deals' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?>
                        </p>
                    </div>
                </div>
                <div class="wpcd-coupon-five-expire without-expiration1 <?php echo empty( trim( $expire_date ) ) ? '' : 'hidden'; ?>">
					<?php if ( ! empty( $no_expiry ) ) { ?>
                        <p><?php echo esc_html( $no_expiry ); ?></p>
					<?php } else { ?>
                        <p><?php echo __( "Doesn't expire", 'wp-coupons-and-deals' ); ?></p>
					<?php }
					?>
                </div>
				<?php
			} else {
				echo '';
			}
			?>
        </div>
		<?php if ( $coupon_type == 'Coupon' ): ?>
			<?php if ( $hide_coupon === 'Yes' ): ?>
				<?php
				$template = new WPCD_Template_Loader();
				$template->get_template_part( 'hide-coupon2__premium_only' );
				?>
			<?php else: ?>
                <div class="wpcd-coupon-code">
                    <a class="wpcd-template-five-btn masterTooltip <?php echo esc_attr( $button_class ); ?>"
                       href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
                       title="<?php echo __( 'Click Here To Copy Coupon', 'wp-coupons-and-deals' ); ?>"
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
                <a class="wpcd-template-five-btn masterTooltip" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_url( $target ); ?>"
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
        var clip = new Clipboard('.<?php echo esc_attr( $button_class ); ?>');
    </script>
    <div class="clearfix"></div>
    <?php
        $template = new WPCD_Template_Loader();
        $template->get_template_part('vote-system');
    ?>
</div>
