<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/25/17
 * Time: 11:31 PM
 */

if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
    include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id, $parent, $max_num_page;
$title                     = get_the_title();
$link                      = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code               = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$discount_text             = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type               = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$description               = get_post_meta( $coupon_id, 'coupon_details_description', true );
$deal_text                 = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$never_expire              = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_coupon_image_id      = get_post_meta( $coupon_id, 'coupon_details_coupon-image-input', true );
$wpcd_show_print           = get_post_meta( $coupon_id, 'coupon_details_coupon-image-print', true );
$wpcd_image_width          = get_post_meta( $coupon_id, 'coupon_details_coupon-image-width', true );
$wpcd_image_height         = get_post_meta( $coupon_id, 'coupon_details_coupon-image-height', true );
$wpcd_coupon_template      = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
$wpcd_template_five_theme  = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true );
$wpcd_template_six_theme   = get_post_meta( $coupon_id, 'coupon_details_template-six-theme', true );
$coupon_hover_text         = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text           = get_option( 'wpcd_deal-hover-text' );
$no_expiry                 = get_option( 'wpcd_no-expiry-message' );
$expire_text               = get_option( 'wpcd_expire-text' );
$expired_text              = get_option( 'wpcd_expired-text' );
$hide_coupon_text          = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text  = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text          = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag          = get_option( 'wpcd_coupon-title-tag', 'h1' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$coupon_share              = get_option( 'wpcd_coupon-social-share' );
$wpcd_eight_btn_text       = get_option( 'wpcd_eight-button-text' );
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );
$dt_coupon_type_name       = get_option( 'wpcd_dt-coupon-type-text' );
$dt_deal_type_name         = get_option( 'wpcd_dt-deal-type-text' );
$featured_img_url          = get_the_post_thumbnail_url( get_the_ID(), 'large' );
$coupon_thumbnail          = wpcd_coupon_thumbnail_img( $coupon_id );
$wpcd_coupon_image_src     = wp_get_attachment_image_src( $wpcd_coupon_image_id, 'full' );
$today                     = date( 'd-m-Y' );
$expire_date_format        = date( "m/d/Y", strtotime( $expire_date ) );
$template                  = new WPCD_Template_Loader();
$button_class              = 'wpcd-btn-' . $coupon_id;

$dt_coupon_type_name       = ( !empty( $dt_coupon_type_name ) ) ? $dt_coupon_type_name : __( 'Coupon', 'wpcd-coupon' );
$dt_deal_type_name         = ( !empty( $dt_deal_type_name ) ) ? $dt_deal_type_name : __( 'Deal', 'wpcd-coupon' );
$expire_text               = ( !empty( $expire_text ) ) ? $expire_text : __( 'Expires On: ', 'wpcd-coupon' );
$expired_text              = ( !empty( $expired_text ) ) ? $expired_text : __( 'Expired On: ', 'wpcd-coupon' );
$no_expiry                 = ( !empty( $no_expiry ) ) ? $no_expiry : __( "Doesn't expire", 'wpcd-coupon' );
$coupon_code               = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) );
$deal_text                 = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wpcd-coupon' ) );
$coupon_hover_text         = ( ! empty( $coupon_hover_text ) ) ? $coupon_hover_text : __( 'Click To Copy Coupon', 'wpcd-coupon' );
$deal_hover_text           = ( !empty( $deal_hover_text ) ) ? $deal_hover_text : __( 'Click Here To Get This Deal' );
$wpcd_eight_btn_text       = ( !empty( $wpcd_eight_btn_text ) ) ? $wpcd_eight_btn_text : __( 'GET THE DEAL', 'wpcd-coupon' );


if( ! $link && WPCD_Amp::wpcd_amp_is() ) $link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
    $expire_date = date( $expireDateFormatFun, $expire_date );
} elseif ( ! empty( $expire_date ) ) {
    $expire_date = date( $expireDateFormatFun, strtotime( $expire_date ) );
}

if ( $wpcd_text_to_show == 'description' ) {
    $wpcd_custom_text = $description;
} else {
    if ( empty( $wpcd_custom_text ) ) {
        $wpcd_custom_text = __("Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon');
    }
}

if ( is_array( $wpcd_coupon_image_src ) ) {
    $wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
    $wpcd_coupon_image_src = '';
}

include( 'header-category__premium_only.php' );
?>
<?php if ( $coupon_type === 'Image' ): ?>
<?php 
    include('coupon_type__image.php'); 
    if ( WPCD_Amp::wpcd_amp_is() ) {
        WPCD_Amp::instance()->setCss( 'shortcode_image' );
    } 
?>
<?php else: ?>
<!--- Template Eight start -->
    <div class="wpcd-new-grid-container wpcd-coupon-id-<?php echo $coupon_id; ?> wpcd_item"
         wpcd-data-search="<?php echo $title; ?>">
        <div class="wpcd-new-grid-one">
            <div class="wpcd-new-discount-text">
                <?php echo $discount_text; ?>
            </div>

            <?php if ( $coupon_type == 'Coupon' ) { ?>
                <div class="wpcd-new-coupon-type">
                    <?php echo $dt_coupon_type_name; ?>
                </div>
            <?php } elseif ( $coupon_type == 'Deal' ) { ?>
                <div class="wpcd-new-deal-type">
                    <?php echo $dt_deal_type_name; ?>
                </div>
            <?php }
            ?>
            <?php
            if ( $coupon_type == 'Coupon' ) {
                if ( $show_expiration == 'Show' ) {
                    if ( ! empty( $expire_date ) ) {
                        if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                            <p class="wpcd-new-expire-text">
                                <?php echo $expire_text . ' ' . $expire_date; ?>
                            </p>
                        <?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                            <p class="wpcd-new-expired-text">
                                <?php echo $expired_text . ' ' . $expire_date; ?>
                            </p>
                        <?php }
                    } else { ?>
                        <p class="wpcd-new-expire-text">
                            <?php echo $no_expiry; ?>
                        </p>
                    <?php }
                } else {
                    echo '';
                }

            } elseif ( $coupon_type == 'Deal' ) {
                if ( $show_expiration == 'Show' ) {
                    if ( ! empty( $expire_date ) ) {
                        if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                            <p class="wpcd-new-expire-text">
                                <?php echo $expire_text . ' ' . $expire_date; ?>
                            </p>
                        <?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                            <p class="wpcd-new-expired-text">
                                <?php echo $expired_text . ' ' . $expire_date; ?>
                            </p>
                        <?php }
                    } else { ?>
                        <p class="wpcd-new-expire-text">
                            <?php echo $no_expiry; ?>
                        </p>
                    <?php }
                } else {
                    echo '';
                }
            } ?>
        </div> <!-- End of grid-one -->

        <div class="wpcd-new-grid-two">
            <?php
            if ('on' === $disable_coupon_title_link) { ?>
                <<?php echo esc_html($coupon_title_tag); ?> class="wpcd-new-title">
                    <?php echo $title; ?>
                </<?php echo esc_html($coupon_title_tag); ?>> <?php
            } else { ?>
                <<?php echo esc_html($coupon_title_tag); ?> class="wpcd-new-title">
                    <a href="<?php echo esc_url($link); ?>" target="_blank" rel="nofollow">
                        <?php echo $title; ?>
                    </a>
                </<?php echo esc_html( $coupon_title_tag ); ?>>
      <?php } ?>
    <div class="wpcd-coupon-description">
        <span class="wpcd-full-description"><?php echo $description; ?></span>
        <span class="wpcd-short-description"></span>
        <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
            <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
            <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
        <?php endif; ?>
    </div>
    </div> <!-- End of grid-two -->
    <div class="wpcd-new-grid-three wpcd_template_eight_archive_button">
        <?php if ( $coupon_type === 'Coupon' ): ?>
            <?php if ( $hide_coupon === 'Yes' && ! WPCD_Amp::wpcd_amp_is() ): ?>
                <?php
                $template->get_template_part( 'hide-coupon3__premium_only' );
                ?>
            <?php else: ?>
                <a class="wpcd-new-coupon-code <?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip" rel="nofollow" href="<?php echo esc_url( $link ); ?>" target="_blank" data-clipboard-text="<?php echo $coupon_code; ?>" 
                title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                 echo $coupon_hover_text;
                             }
                         ?>">
                   <?php echo $coupon_code; ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>
        <a class="wpcd-new-goto-button masterTooltip" rel="nofollow" href="<?php echo esc_url( $link ); ?>" target="_blank" title="<?php echo $deal_hover_text; ?>" >
           <?php echo $deal_text; ?>
        </a>
    </div><!-- End of grid-three -->
    <script type="text/javascript">
        var clip = new Clipboard('.<?php echo $button_class; ?>');
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
    <!--- Template Eight End -->
<?php endif; ?>
<?php include('footer-category__premium_only.php'); ?>
