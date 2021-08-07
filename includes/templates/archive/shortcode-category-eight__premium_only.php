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
$show_print_links          = get_option( 'wpcd_coupon-print-link' );
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

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

$dt_coupon_type_name       = ( !empty( $dt_coupon_type_name ) ) ? $dt_coupon_type_name : __( 'Coupon', 'wp-coupons-and-deals' );
$dt_deal_type_name         = ( !empty( $dt_deal_type_name ) ) ? $dt_deal_type_name : __( 'Deal', 'wp-coupons-and-deals' );
$expire_text               = ( !empty( $expire_text ) ) ? $expire_text : __( 'Expires On: ', 'wp-coupons-and-deals' );
$expired_text              = ( !empty( $expired_text ) ) ? $expired_text : __( 'Expired On: ', 'wp-coupons-and-deals' );
$no_expiry                 = ( !empty( $no_expiry ) ) ? $no_expiry : __( "Doesn't expire", 'wp-coupons-and-deals' );
$coupon_code               = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wp-coupons-and-deals' ) );
$deal_text                 = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wp-coupons-and-deals' ) );
$coupon_hover_text         = ( ! empty( $coupon_hover_text ) ) ? $coupon_hover_text : __( 'Click To Copy Coupon', 'wp-coupons-and-deals' );
$deal_hover_text           = ( !empty( $deal_hover_text ) ) ? $deal_hover_text : __( 'Click Here To Get This Deal' );
$wpcd_eight_btn_text       = ( !empty( $wpcd_eight_btn_text ) ) ? $wpcd_eight_btn_text : __( 'GET THE DEAL', 'wp-coupons-and-deals' );


if( ! $link && WPCD_Amp::wpcd_amp_is() ) $link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
    $expire_date = date( $expireDateFormatFun, $expire_date );
}

if ( $wpcd_text_to_show == 'description' ) {
    $wpcd_custom_text = $description;
} else if ( empty( $wpcd_custom_text ) ) {
    $wpcd_custom_text = __("Click on 'Copy' to Copy the Coupon Code.", 'wp-coupons-and-deals');
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
<?php
    $wpcd_uniq_attr = '';
    $wpcd_uniq_attr_data = '';
    if( function_exists( 'wpcd_uniq_attr' ) && ! WPCD_Amp::wpcd_amp_is() &&
        ! empty( $show_print_links ) && $show_print_links == 'on' ) {
        $wpcd_uniq_attr = wpcd_uniq_attr( 10 );
        $wpcd_uniq_attr_data = 'data-unic-attr="' . esc_attr( $wpcd_uniq_attr ) . '"';
    }
?>
<!--- Template Eight start -->
    <div class="wpcd-new-grid-container wpcd-coupon-id-<?php echo absint( $coupon_id ); ?> wpcd_item"
         wpcd-data-search="<?php echo esc_attr( $title ); ?>" <?php echo $wpcd_uniq_attr_data;?>>
        <div class="wpcd-new-grid-one">
            <div class="wpcd-new-discount-text">
                <?php echo esc_html( $discount_text ); ?>
            </div>

            <?php if ( $coupon_type == 'Coupon' ) { ?>
                <div class="wpcd-new-coupon-type">
                    <?php echo esc_html( $dt_coupon_type_name ); ?>
                </div>
            <?php } elseif ( $coupon_type == 'Deal' ) { ?>
                <div class="wpcd-new-deal-type">
                    <?php echo esc_html( $dt_deal_type_name ); ?>
                </div>
            <?php }
            ?>
            <?php
            if ( $coupon_type == 'Coupon' ) {
                if ( $show_expiration == 'Show' ) {
                    if ( ! empty( $expire_date ) ) {
                        if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                            <p class="wpcd-new-expire-text">
                                <?php echo esc_html( $expire_text ) . ' ' . date( $expireDateFormatFun, strtotime( $expire_date ) ); ?>
                            </p>
                        <?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                            <p class="wpcd-new-expired-text">
                                <?php echo esc_html( $expired_text ) . ' ' . date( $expireDateFormatFun, strtotime( $expire_date ) ); ?>
                            </p>
                        <?php }
                    } else { ?>
                        <p class="wpcd-new-expire-text">
                            <?php echo esc_html( $no_expiry ); ?>
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
                                <?php echo esc_html( $expire_text ) . ' ' . date( $expireDateFormatFun, strtotime( $expire_date ) ); ?>
                            </p>
                        <?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                            <p class="wpcd-new-expired-text">
                                <?php echo esc_html( $expired_text ) . ' ' . date( $expireDateFormatFun, strtotime( $expire_date ) ); ?>
                            </p>
                        <?php }
                    } else { ?>
                        <p class="wpcd-new-expire-text">
                            <?php echo esc_html( $no_expiry ); ?>
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
                    <?php echo esc_html( $title ); ?>
                </<?php echo esc_html($coupon_title_tag); ?>> <?php
            } else { ?>
                <<?php echo esc_html($coupon_title_tag); ?> class="wpcd-new-title">
                    <a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr( $target ); ?>" rel="nofollow">
                        <?php echo esc_html( $title ); ?>
                    </a>
                </<?php echo esc_html( $coupon_title_tag ); ?>>
      <?php } ?>
    <div class="wpcd-coupon-description">
        <span class="wpcd-full-description"><?php echo wp_kses_post( $description ); ?></span>
        <span class="wpcd-short-description"></span>
        <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
            <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wp-coupons-and-deals' ); ?></a>
            <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wp-coupons-and-deals' ); ?></a>
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
                <a class="wpcd-new-coupon-code <?php echo 'wpcd-btn-' . absint( $coupon_id ); ?> masterTooltip" rel="nofollow" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>" 
                title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                 echo esc_attr( $coupon_hover_text );
                             }
                         ?>">
                   <?php echo esc_html( $coupon_code ); ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>
        <a class="wpcd-new-goto-button masterTooltip" rel="nofollow" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" title="<?php echo esc_attr( $deal_hover_text ); ?>" >
           <?php echo esc_html( $deal_text ); ?>
        </a>
    </div><!-- End of grid-three -->
    <script type="text/javascript">
        var clip = new Clipboard('.<?php echo esc_attr( $button_class) ; ?>');
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
    <?php
        if( ! WPCD_Amp::wpcd_amp_is() && ! empty( $show_print_links ) && $show_print_links == 'on') {
            wpcd_coupon_print_link( $wpcd_uniq_attr );
        }
    ?>
<?php endif; ?>
<?php include('footer-category__premium_only.php'); ?>
