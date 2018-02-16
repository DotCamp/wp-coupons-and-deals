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
$title                    = get_the_title();
$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
$discount_text            = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$link                     = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code              = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$deal_text                = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text        = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text          = get_option( 'wpcd_deal-hover-text' );
$button_class             = 'wpcd-btn-' . $coupon_id;
$no_expiry                = get_option( 'wpcd_no-expiry-message' );
$expire_text              = get_option( 'wpcd_expire-text' );
$expired_text             = get_option( 'wpcd_expired-text' );
$hide_coupon_text         = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text         = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag         = get_option( 'wpcd_coupon-title-tag', 'h1' );
$show_expiration          = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                    = date( 'd-m-Y' );
$expire_date              = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$hide_coupon              = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_template_five_theme = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true );
$wpcd_coupon_thumbnail    = get_the_post_thumbnail_url( $coupon_id );

$wpcd_text_to_show = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text  = get_option( 'wpcd_custom-text' );
$wpcd_dummy_coupon_img   = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}

wp_enqueue_script( 'wpcd-clipboardjs' );

?>

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
            <img src="<?php echo empty( $wpcd_coupon_thumbnail ) ? $wpcd_dummy_coupon_img : $wpcd_coupon_thumbnail; ?>"
                 alt="image">
        </div>

        <div class="wpcd-template-five-texts">
            <<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-widget-title">
                <a href="<?php echo $link; ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
            </<?php echo esc_html( $coupon_title_tag ); ?>>
            <div class="wpcd-coupon-description">
                <span class="wpcd-full-description"><?php echo $description; ?></span>
                <span class="wpcd-short-description"></span>
                <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
                <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
            </div>
        </div>
    </div>

    <div class="extra-wpcd-template-five-holder">
        <div class="wpcd-template-five-exp" style="background-color: <?php echo $wpcd_template_five_theme; ?>">
            <!-- <p>Expires On: 12/31/17</p> -->
			<?php
			if ( $show_expiration !== 'Hide' ) { ?>
                <div class="with-expiration1 <?php echo empty( trim( $expire_date ) ) ? 'hidden' : ''; ?>">
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
                <div class="wpcd-coupon-five-expire without-expiration1 <?php echo empty( trim( $expire_date ) ) ? '' : 'hidden'; ?>">
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
		<?php if ( $coupon_type == 'Coupon' ): ?>
			<?php if ( $hide_coupon === 'Yes' ): ?>
				<?php
				$template = new WPCD_Template_Loader();
				$template->get_template_part( 'hide-coupon2__premium_only' );
				?>
			<?php else: ?>
                <div class="wpcd-coupon-code">
                    <a class="wpcd-template-five-btn masterTooltip <?php echo $button_class; ?>"
                       href="<?php echo $link; ?>" target="_blank"
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
			<?php endif; ?>
		<?php elseif ( $coupon_type == 'Deal' ): ?>
            <div class="wpcd-deal-code">
                <a class="wpcd-template-five-btn masterTooltip" href="<?php echo $link; ?>" target="_blank"
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
		<?php else: ?>

		<?php endif; ?>

    </div>
    <script type="text/javascript">
        var clip = new Clipboard('.<?php echo $button_class; ?>');
    </script>
</div>
