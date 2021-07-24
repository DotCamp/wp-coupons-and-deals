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

if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
    include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

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
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$coupon_share              = get_option( 'wpcd_coupon-social-share' );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                     = date( 'd-m-Y' );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_template_five_theme  = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true );
$coupon_thumbnail     	   = wpcd_coupon_thumbnail_img($coupon_id);
$link_thumbnail            = get_option('wpcd_coupon-link-featured-img'); 
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );
$wpcd_dummy_coupon_img     = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';

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

<div class="wpcd-template-five wpcd-coupon-id-<?php echo absint( $coupon_id ); ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>" <?php echo $wpcd_uniq_attr_data;?>>
    <div class="wpcd-template-five-holder">
        <div class="wpcd-template-five-percent-off">
            <p class="wpcd-coupon-five-discount-text">
				<?php if ( ! empty( $discount_text ) ) {
					echo esc_html( $discount_text );
				} else {
					echo __( 'Discount Text', 'wpcd-coupon' );
				} ?>
            </p>
        </div>
        <div class="wpcd-template-five-pro-img">
            <?php
                if ($link_thumbnail == "on"):
                    echo "<a href='" . esc_url( $link ) . "' rel='nofollow' target='" . esc_attr( $target ) . "'><img src='" . esc_url( $coupon_thumbnail ) . "' alt='" . esc_attr( $title ) . "'></a>";
                else:
                    echo "<img src='" . esc_url( $coupon_thumbnail ) . "' alt='" . esc_attr( $title ) . "'>";
                endif;
            ?>
        </div>

        <div class="wpcd-template-five-texts">
            <?php
				if ( 'on' === $disable_coupon_title_link ) { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<?php echo esc_attr( $title ); ?>
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
                <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
	                <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
	                <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
	            <?php endif; ?>
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
								echo __( 'Expires on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?></p>
                    </div>
                    <div class="wpcd-coupon-five-expire expired-text-block1 <?php echo strtotime( $expire_date ) < strtotime( $today ) ? '' : 'hidden'; ?>">
                        <p class="wpcd-coupon-five-expired">
							<?php
							if ( ! empty( $expired_text ) ) {
								echo esc_html( $expired_text ) . ' ' . '<span class="expiration-date">' . $expire_date . '</span>';
							} else {
								echo __( 'Expired on: ', 'wpcd-coupon' ) . '<span class="expiration-date">' . $expire_date . '</span>';
							}
							?>
                        </p>
                    </div>
                </div>
                <div class="wpcd-coupon-five-expire without-expiration1 <?php echo empty( trim( $expire_date ) ) ? '' : 'hidden'; ?>">
					<?php if ( ! empty( $no_expiry ) ) { ?>
                        <p><?php echo esc_html( $no_expiry ); ?></p>
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
			<?php if ( $hide_coupon === 'Yes' && ! WPCD_Amp::wpcd_amp_is() ): ?>
				<?php
				$template->get_template_part( 'hide-coupon2__premium_only' );
				?>
			<?php else: ?>
                <div class="wpcd-coupon-code">
                    <a class="wpcd-template-five-btn masterTooltip <?php echo esc_attr( $button_class ); ?>"
                       href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" rel="nofollow"
                       title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                   		if ( ! empty( $coupon_hover_text ) ) {
										    echo esc_attr( $coupon_hover_text );
									    } else {
										    echo __( "Click To Copy Coupon", 'wpcd-coupon' );
									    }
                                    }
                        		?>"
                       data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
						   echo esc_attr( $coupon_code );
					   } else {
						   echo __( 'COUPONCODE', 'wpcd-coupon' );
					   } ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ) ; ?>">
                        <p class="coupon-code-button"
                           style="color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>"><?php echo( ! empty( $coupon_code ) ? esc_html( $coupon_code) : __( 'COUPONCODE', 'wpcd-coupon' ) ); ?></p>
                    </a>
                </div>
			<?php endif; ?>
		<?php elseif ( $coupon_type == 'Deal' ): ?>
            <div class="wpcd-deal-code">
                <a class="wpcd-template-five-btn masterTooltip" rel="nofollow" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
                   title="<?php echo __( 'Click Here To Get this deal', 'wpcd-coupon' ); ?>"
                   data-clipboard-text="<?php if ( ! empty( $deal_text ) ) {
					   echo esc_attr( $deal_text );
				   } else {
					   echo __( 'Claim This Deal', 'wpcd-coupon' );
				   } ?>" style="border-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>">
                    <p class="deal-code-button" style="color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>">
						<?php if ( ! empty( $deal_text ) ) {
							echo esc_html( $deal_text );
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
        if( typeof Clipboard === "function" ) {
            let clip = new Clipboard('.<?php echo esc_attr( $button_class ); ?>');
        }
    </script>
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
