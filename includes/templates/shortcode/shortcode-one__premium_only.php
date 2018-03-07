<?php
/**
 * Shortcode template One.
 *
 * @since 2.3
 */
if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
	include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id;
$title                    = get_the_title();
$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
$coupon_thumbnail         = wpcd_coupon_thumbnail_img( $coupon_id );
$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$discount_text            = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$link                     = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code              = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$deal_text                = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text        = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text          = get_option( 'wpcd_deal-hover-text' );
$button_class             = '.wpcd-btn-' . $coupon_id;
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

$wpcd_text_to_show = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text  = get_option( 'wpcd_custom-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}
$template = new WPCD_Template_Loader();
?>

<div class="wpcd-coupon-one wpcd-coupon-id-<?php echo $coupon_id; ?>">
    <div class="wpcd-col-one-1-8">
            <figure>
                <img class="wpcd-coupon-one-img" src="<?php echo $coupon_thumbnail; ?>">
            </figure>
    </div>
    <div class="wpcd-col-one-7-8">
		<div class="wpcd-coupon-one-title">
			<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
                <a href="<?php echo $link; ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
			</<?php echo esc_html( $coupon_title_tag ); ?>>
		</div>
        <div id="clear"></div>
        <div class="wpcd-coupon-description">
            <span class="wpcd-full-description"><?php echo $description; ?></span>
            <span class="wpcd-short-description"></span>
            <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
            <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
        </div>
    </div>
    <div class="wpcd-col-one-1-4">
        <div class="wpcd-coupon-one-discount-text">
			<?php echo $discount_text; ?>
        </div>
		<?php if ( $coupon_type == 'Coupon' ) {
			if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->is_trial() ) {

				if ( $hide_coupon == 'Yes' ) {

					$template->get_template_part( 'hide-coupon__premium_only' );

				} else { ?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow" href="<?php echo $link; ?>"
                           class="<?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           target="_blank" href="<?php echo $link; ?>"
                           title="<?php if ( ! empty( $coupon_hover_text ) ) {
							   echo $coupon_hover_text;
						   } else {
							   echo __( "Click To Copy Coupon", 'wpcd-coupon' );
						   } ?>"
                           data-clipboard-text="<?php echo $coupon_code; ?>">
                            <span class="wpcd_coupon_icon"></span> <?php echo $coupon_code; ?>
                            <span id="coupon_code_<?php echo $coupon_id; ?>"
                                  style="display:none;"><?php echo $coupon_code; ?></span>
                        </a>
                    </div>
				<?php }
			} else { ?>
                <div class="wpcd-coupon-code">
                    <a rel="nofollow" href="<?php echo $link; ?>"
                       class="<?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                       target="_blank" href="<?php echo $link; ?>"
                       title="<?php if ( ! empty( $coupon_hover_text ) ) {
						   echo $coupon_hover_text;
					   } else {
						   echo __( "Click To Copy Coupon", 'wpcd-coupon' );
					   } ?>"
                       data-clipboard-text="<?php echo $coupon_code; ?>">
                        <span class="wpcd_coupon_icon"></span> <?php echo $coupon_code; ?>
                        <span id="coupon_code_<?php echo $coupon_id; ?>"
                              style="display:none;"><?php echo $coupon_code; ?></span>
                    </a>
                </div>
			<?php }
		} elseif ( $coupon_type == 'Deal' ) { ?>
            <div class="wpcd-coupon-code">
                <a rel="nofollow"
                   class="<?php echo 'wpcd-btn-' . $coupon_id; ?> wpcd-btn masterTooltip wpcd-deal-button"
                   title="<?php if ( ! empty( $deal_hover_text ) ) {
					   echo $deal_hover_text;
				   } else {
					   echo __( "Click Here To Get This Deal", 'wpcd-coupon' );
				   } ?>" href="<?php echo $link; ?>" target="_blank        ">
                    <span class="wpcd_deal_icon"></span><?php echo $deal_text; ?>
                </a>
            </div>
		<?php } ?>
		<?php
		if ( $coupon_type == 'Coupon' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $expire_date ) ) {
					if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-one-expire">
							<?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text . ' ' . $expire_date;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date;
							}
							?>
                        </div>
					<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-one-expired">
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
                    <div class="wpcd-coupon-one-expire">
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
                        <div class="wpcd-coupon-one-expire">
							<?php
							if ( ! empty( $expire_text ) ) {
								echo $expire_text . ' ' . $expire_date;
							} else {
								echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date;
							}
							?>
                        </div>
					<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-one-expired">
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

                    <div class="wpcd-coupon-one-expire">

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
        <div id="clear"></div>
    </div>
    <div id="clear"></div>
    <script type="text/javascript">
        var clip = new Clipboard('<?php echo $button_class; ?>');
    </script>
    <?php 
        $template->get_template_part('social-share');
    ?>
</div>