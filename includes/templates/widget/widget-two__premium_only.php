<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/18/17
 * Time: 11:30 PM
 */
global $coupon_id;
$title                    = get_the_title();
$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
$coupon_thumbnail         = get_the_post_thumbnail_url( $coupon_id );
$discount_text            = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
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
$expire_time              = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$expire_date_format       = date( "m/d/Y", strtotime( $expire_date ) );
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

?>

<div class="wpcd-coupon wpcd-coupon-two wpcd-widget wpcd-coupon-id-<?php echo $coupon_id; ?>">
    <div class="wpcd-coupon-content wpcd-col-1-1">
        <div class="wpcd-coupon-header">
            <div class="wpcd-col-1-1">
				<?php if ( has_post_thumbnail() ) { ?>
                    <figure>
                        <img class="wpcd-coupon-one-img" src="<?php echo $coupon_thumbnail; ?>">
                    </figure>
				<?php } else { ?>
                    <figure>
                        <img class="wpcd-coupon-one-img"
                             src="<?php echo WPCD_Plugin::instance()->plugin_assets . 'img/icon-128x128.png'; ?>">
                    </figure>
				<?php } ?>
            </div>
            <div class="wpcd-col-1-1">
                <<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-widget-title">
                    <a href="<?php echo $link; ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
                </<?php echo esc_html( $coupon_title_tag ); ?>>
            </div>

            <div class="wpcd-col-1-1">
                <?php if( ! empty( $expire_date ) ): ?>
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
            </div>

        </div>

        <div class="wpcd-extra-content">
            <div class="wpcd-col-1-1">
                <div class="wpcd-coupon-description">
                    <span class="wpcd-full-description"><?php echo $description; ?></span>
                    <span class="wpcd-short-description"></span>
                    <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
                    <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
                </div>
            </div>

            <div class="wpcd-col-1-1">
				<?php
				if ( $coupon_type == 'Coupon' ) {
				if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->is_trial() ) {
				if ( $hide_coupon == 'Yes' ) {

					$template = new WPCD_Template_Loader();

					$template->get_template_part( 'hide-coupon__premium_only' );

				} else { ?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow"
                           class="<?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           title="<?php
						   if ( ! empty( $coupon_hover_text ) ) {
							   echo $coupon_hover_text;
						   } else {
							   echo __( "Click To Copy Coupon", 'wpcd-coupon' );
						   }
						   ?>" href="<?php echo $link; ?>" target="_blank"
                           data-clipboard-text="<?php echo $coupon_code; ?>">
                            <span class="wpcd_coupon_icon"></span> <?php echo $coupon_code; ?>
                            <span id="coupon_code_<?php echo $coupon_id; ?>"
                                  style="display:none;"><?php echo $coupon_code; ?></span>
                        </a>
                    </div>
				<?php }
				} else {
					?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow"
                           class="<?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           title="<?php
						   if ( ! empty( $coupon_hover_text ) ) {
							   echo $coupon_hover_text;
						   } else {
							   echo __( "Click To Copy Coupon", 'wpcd-coupon' );
						   }
						   ?>" href="<?php echo $link; ?>" target="_blank"
                           data-clipboard-text="<?php echo $coupon_code; ?>">
                            <span class="wpcd_coupon_icon"></span> <?php echo $coupon_code; ?>
                            <span id="coupon_code_<?php echo $coupon_id; ?>"
                                  style="display:none;"><?php echo $coupon_code; ?></span>
                        </a>
                    </div>
				<?php } ?>
                    <script type="text/javascript">
                        var clip = new Clipboard('.wpcd-btn-<?php echo $coupon_id; ?>');
                    </script>
				<?php } elseif ( $coupon_type == 'Deal' ) {
				?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow"
                           class="<?php echo 'wpcd-btn-' . $coupon_id; ?> wpcd-btn masterTooltip wpcd-deal-button"
                           title="<?php
						   if ( ! empty( $deal_hover_text ) ) {
							   echo $deal_hover_text;
						   } else {
							   echo __( "Click Here To Get This Deal", 'wpcd-coupon' );
						   }
						   ?>" href="<?php echo $link; ?>" target="_blank">
                            <span class="wpcd_deal_icon"></span><?php echo $deal_text; ?>
                        </a>
                    </div>
				<?php } ?>
            </div>

        </div>
    </div>
</div>