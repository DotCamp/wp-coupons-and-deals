<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/25/17
 * Time: 11:31 PM
 */
/**
 *
 * This exits from the script if it's accessed
 * directly from somewhere else.
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
    include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id, $max_num_page;
$title                     = get_the_title();
$link                      = get_post_meta($coupon_id, 'coupon_details_link', true);
$coupon_code               = get_post_meta($coupon_id, 'coupon_details_coupon-code-text', true);
$coupon_thumbnail          = wpcd_coupon_thumbnail_img( $coupon_id );
$link_thumbnail            = get_option('wpcd_coupon-link-featured-img'); 
$discount_text             = get_post_meta($coupon_id, 'coupon_details_discount-text', true);
$coupon_type               = get_post_meta($coupon_id, 'coupon_details_coupon-type', true);
$description               = get_post_meta($coupon_id, 'coupon_details_description', true);
$deal_text                 = get_post_meta($coupon_id, 'coupon_details_deal-button-text', true);
$coupon_hover_text         = get_option('wpcd_coupon-hover-text');
$deal_hover_text           = get_option('wpcd_deal-hover-text');
$button_class              = 'wpcd-btn-' . $coupon_id;
$no_expiry                 = get_option('wpcd_no-expiry-message');
$never_expire              = get_post_meta($coupon_id, 'coupon_details_never-expire-check', true);
$expire_text               = get_option('wpcd_expire-text');
$expired_text              = get_option('wpcd_expired-text');
$hide_coupon_text          = get_option('wpcd_hidden-coupon-text');
$hidden_coupon_hover_text  = get_option('wpcd_hidden-coupon-hover-text');
$copy_button_text          = get_option('wpcd_copy-button-text');
$coupon_title_tag          = get_option('wpcd_coupon-title-tag', 'h1');
$disable_coupon_title_link = get_option('wpcd_disable-coupon-title-link');
$hide_featured_image       = get_option('wpcd_hide-archive-thumbnail');
$coupon_share              = get_option('wpcd_coupon-social-share');
$show_expiration           = get_post_meta($coupon_id, 'coupon_details_show-expiration', true);
$today                     = date('d-m-Y');
$expire_date               = get_post_meta($coupon_id, 'coupon_details_expire-date', true);
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$hide_coupon               = get_post_meta($coupon_id, 'coupon_details_hide-coupon', true);
$wpcd_coupon_image_id      = get_post_meta($coupon_id, 'coupon_details_coupon-image-input', true);
$wpcd_coupon_image_src     = wp_get_attachment_image_src($wpcd_coupon_image_id, 'full');
$wpcd_show_print           = get_post_meta($coupon_id, 'coupon_details_coupon-image-print', true);
$disable_menu              = get_option('wpcd_disable-menu-archive-code');
$coupon_categories         = get_the_terms($coupon_id, 'wpcd_coupon_category');
$coupon_categories_class   = '';

$coupon_code               = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wpcd-coupon' ) );
$deal_text                 = ( ! empty( $deal_text ) ? $deal_text : __( 'Claim This Deal', 'wpcd-coupon' ) );

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ($coupon_categories && count($coupon_categories) > 0) {
    foreach ($coupon_categories as $category) {
        $coupon_categories_class .= ' ' . $category->slug;
    }
}

$template = new WPCD_Template_Loader();
if (is_array($wpcd_coupon_image_src)) {
    $wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
    $wpcd_coupon_image_src = '';
}

$wpcd_text_to_show = get_option('wpcd_text-to-show');
$wpcd_custom_text = get_option('wpcd_custom-text');

if ($wpcd_text_to_show == 'description') {
    $wpcd_custom_text = $description;
} else {
    if (empty($wpcd_custom_text)) {
        $wpcd_custom_text = __("Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon');
    }
}
if( ! $link && WPCD_Amp::wpcd_amp_is() ) $link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
    $expire_date = date( $expireDateFormatFun, $expire_date );
} elseif ( ! empty( $expire_date ) ) {
    $expire_date = date( $expireDateFormatFun, strtotime( $expire_date ) );
}

$wpcd_coupon_template = get_post_meta($coupon_id, 'coupon_details_coupon-template', true);



/*
 * to build the parent elment
 * header and in the bottom footer
 */
global $parent;
include('header-grid__premium_only.php');
?>
    <li class="wpcd_coupon_li wpcd-coupon-id-<?php echo $coupon_id; ?> wpcd_item <?php echo $coupon_categories_class; ?>"
        wpcd-data-search="<?php echo $title;?>">
        <?php
        if ($hide_featured_image != 'on') {
        if (!empty($coupon_thumbnail)) { ?>
        <?php 
        if ($link_thumbnail == "on"): 
            echo "<a href='{$link}' target='{$target}'>";
        endif; ?>
            <div class="wpcd_coupon_li_top_wr"
             style="background-image:url('<?php echo esc_url($coupon_thumbnail); ?>')">
            <?php if( WPCD_Amp::wpcd_amp_is() ) { ?>
                <?php
                if ($link_thumbnail == "on"):
                    echo "<a href='{$link}' target='{$target}'><img class='wpcd_archive_coupon_feature_image' src='$coupon_thumbnail' style='width: 100%;height: 100%;' ></a>";
                else:
                    echo "<img class='wpcd_archive_coupon_feature_image' src='$coupon_thumbnail' style='width: 100%;height: 100%;' >";
                endif;
                ?>
                <img class="wpcd_archive_coupon_feature_image" src="<?php echo esc_url($coupon_thumbnail); ?>" style="width: 100%;height: 100%;" >
            <?php } ?>
             </div>
        <?php 
        if ($link_thumbnail == "on"): 
            echo "</a>";
        endif; 
        ?>
        
        <?php } else { ?>
            <div class="wpcd_coupon_li_top_wr"></div>
        <?php } ?>
            <?php } ?>
            <div class="wpcd_coupon_li_content">
                <?php
                if ('on' === $disable_coupon_title_link) { ?>
                <<?php echo esc_html($coupon_title_tag); ?> class="wpcd-coupon-title">
                <?php echo $title; ?>
            </<?php echo esc_html($coupon_title_tag); ?>>
            <?php } else { ?>
            <<?php echo esc_html($coupon_title_tag); ?> class="wpcd-coupon-title">
            <a href="<?php echo $link; ?>" target="<?php echo $target; ?>" rel="nofollow"><?php echo $title; ?></a>
        </<?php echo esc_html($coupon_title_tag); ?>>
    <?php }
    ?>
        <div class="wpcd_coupon_li_top_btn_wr wpcd_clearfix <?php echo($coupon_type === 'Image' ? 'hidden' : ''); ?>">
            <?php if ($discount_text) { ?>
                <div class="wpcd_coupon_li_top_discount_left"><?php echo $discount_text; ?></div>
                <?php
            }
            if ($coupon_type == 'Coupon') {
            if ( $hide_coupon == 'Yes' && ! WPCD_Amp::wpcd_amp_is() ) { ?>

                <div class="wpcd-coupon-code wpcd_btn_wr">
                    <?php $template->get_template_part('hide-coupon__premium_only'); ?>
                </div>

            <?php } else { ?>
                <div class="wpcd-coupon-code wpcd_btn_wr">
                        <a rel="nofollow"
                           class="wpcd-btn-<?php echo $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           href="<?php echo $link; ?>" 
                           title="<?php if( !WPCD_Amp::wpcd_amp_is() ) {
                                            if ( ! empty( $coupon_hover_text ) ) {
                                                echo $coupon_hover_text;
                                            } else {
                                                echo __( "Click To Copy Coupon", 'wpcd-coupon' );
                                            }
                                        }
                                    ?>"
                           target="<?php echo $target; ?>"
                           data-clipboard-text="<?php echo $coupon_code; ?>">
                            <span class="wpcd_coupon_icon">
                                <img class="" src="<?php echo WPCD_Plugin::instance()->plugin_assets?>img/coupon-code-24.png" style="width: 100%;height: 100%;" >
                            </span> <?php echo $coupon_code; ?>
                            <span id="coupon_code_<?php echo $coupon_id; ?>" class="coupon_code_amp" style="display:none;"><?php echo $coupon_code; ?></span>
                        </a>
                </div>
            <?php } ?>

                <script type="text/javascript">
                    var clip = new Clipboard('.<?php echo $button_class; ?>');
                </script>

            <?php } elseif ($coupon_type == 'Deal') { ?>
                <div class="wpcd-coupon-code wpcd_btn_wr">
                        <a rel="nofollow"
                           class="wpcd-btn-<?php echo $coupon_id; ?> wpcd-btn masterTooltip wpcd-deal-button"
                           title="<?php if ( ! empty( $deal_hover_text ) ) {
                                            echo $deal_hover_text;
                                        } else {
                                            echo __( "Click Here To Get This Deal", 'wpcd-coupon' );
                                        }
                                    ?>" 
                           href="<?php echo $link; ?>"
                           target="<?php echo $target; ?>">
                            <span class="wpcd_deal_icon">
                                <img class="" src="<?php echo WPCD_Plugin::instance()->plugin_assets?>img/deal-24.png" style="width: 100%;height: 100%;" >
                            </span><?php echo $deal_text; ?>
                        </a>
                </div>
            <?php } ?>

        </div>
        <div class="wpcd_coupon_li_inner <?php echo($coupon_type === 'Image' ? 'hidden' : ''); ?>">
            <?php if ($description) { ?>
                <div class="wpcd_coupon_li_description">
                    <div class="wpcd-coupon-description">
                        <span class="wpcd-full-description"><?php echo $description; ?></span>
                        <span class="wpcd-short-description"></span>
                        <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                            <a href="#"
                               class="wpcd-more-description"><?php echo __('More', 'wpcd-coupon'); ?></a>
                            <a href="#"
                           class="wpcd-less-description"><?php echo __('Less', 'wpcd-coupon'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($show_expiration == 'Show') {
                $never_expire = ($wpcd_coupon_template == 'Template Two' || $wpcd_coupon_template == 'Template Six') ? $never_expire : '';
                if (!empty($expire_date) && $never_expire != 'on') { ?>
                    <div class="wpcd_coupon_li_bottom wpcd_clearfix">

                        <?php if (strtotime($expire_date) >= strtotime($today)) { ?>

                            <?php if (!empty($expire_text)) { ?>
                                <p class="wpcd-coupon-loop-expire"><?php echo $expire_text . $expire_date; ?></p>
                            <?php } else { ?>
                                <p class="wpcd-coupon-loop-expire"><?php echo __('Expires on: ', 'wpcd-coupon') . $expire_date ?></p>
                            <?php } ?>

                        <?php } elseif (strtotime($expire_date) < strtotime($today)) { ?>

                            <?php if (!empty($expired_text)) { ?>
                                <p class="wpcd-coupon-loop-expired"><?php echo $expired_text . $expire_date; ?></p>
                            <?php } else { ?>
                                <p class="wpcd-coupon-loop-expired"><?php echo __('Expired on: ', 'wpcd-coupon') . $expire_date; ?></p>
                            <?php } ?>

                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="wpcd_coupon_li_bottom wpcd_clearfix">

                        <?php if (!empty($no_expiry)) { ?>
                            <?php echo $no_expiry; ?>
                        <?php } else { ?>
                            <p class='wpcd-coupon-loop-expire'><?php echo __("Doesn't expire", 'wpcd-coupon'); ?></p>
                        <?php } ?>

                    </div>
                <?php } ?>
            <?php } ?>
        </div> <!-- wpcd_coupon_li_inner-->
        <div class="clearfix"></div>
        <?php if( !WPCD_Amp::wpcd_amp_is() ):?>
            <div class="wpcd-li-footer">
                <?php
                if ($coupon_share === 'on') {
                    $template->get_template_part('social-share');
                }
                $template->get_template_part('vote-system');
                ?>
            </div>
        <?php endif; ?>
        </div>
    </li>
<?php include('footer-grid__premium_only.php'); ?>