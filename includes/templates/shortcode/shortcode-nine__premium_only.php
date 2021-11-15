<?php

/**
 *
 * This exits from the script if it's accessed
 * directly from somewhere else.
 *
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * This is the default Shortcode template.
 *
 * @since 1.2
 */
global $coupon_id;
$title = get_the_title();
$description = get_post_meta($coupon_id, 'coupon_details_description', true);
$discount_text = get_post_meta($coupon_id, 'coupon_details_discount-text', true);
$coupon_type = get_post_meta($coupon_id, 'coupon_details_coupon-type', true);
$link = get_post_meta($coupon_id, 'coupon_details_link', true);
$coupon_code = get_post_meta($coupon_id, 'coupon_details_coupon-code-text', true);
$show_print_links = get_option('wpcd_coupon-print-link');
$deal_text = get_post_meta($coupon_id, 'coupon_details_deal-button-text', true);
$show_expiration = get_post_meta($coupon_id, 'coupon_details_show-expiration', true);
$expire_date = get_post_meta($coupon_id, 'coupon_details_expire-date', true);
$expireDateFormat = get_option('wpcd_expiry-date-format');
$hide_coupon = get_post_meta($coupon_id, 'coupon_details_hide-coupon', true);
$coupon_hover_text = get_option('wpcd_coupon-hover-text');
$deal_hover_text = get_option('wpcd_deal-hover-text');
$no_expiry = get_option('wpcd_no-expiry-message');
$expire_text = get_option('wpcd_expire-text');
$expired_text = get_option('wpcd_expired-text');
$hide_coupon_text = get_option('wpcd_hidden-coupon-text');
$hidden_coupon_hover_text = get_option('wpcd_hidden-coupon-hover-text');
$copy_button_text = get_option('wpcd_copy-button-text');
$coupon_title_tag = get_option('wpcd_coupon-title-tag', 'h1');
$coupon_share = get_option('wpcd_coupon-social-share');
$dt_coupon_type_name = get_option('wpcd_dt-coupon-type-text');
$dt_deal_type_name = get_option('wpcd_dt-deal-type-text');
$disable_coupon_title_link = get_option('wpcd_disable-coupon-title-link');
$wpcd_text_to_show = get_option('wpcd_text-to-show');
$wpcd_custom_text = get_option('wpcd_custom-text');
$wpcd_eight_btn_text = get_option('wpcd_eight-button-text');
$today = date('d-m-Y');
$button_class = 'wpcd-btn-' . $coupon_id;

$dt_coupon_type_name = (!empty($dt_coupon_type_name)) ? $dt_coupon_type_name : __('Coupon', 'wp-coupons-and-deals');
$dt_deal_type_name = (!empty($dt_deal_type_name)) ? $dt_deal_type_name : __('Deal', 'wp-coupons-and-deals');
$expire_text = (!empty($expire_text)) ? $expire_text : __('Expires On: ', 'wp-coupons-and-deals');
$expired_text = (!empty($expired_text)) ? $expired_text : __('Expired On: ', 'wp-coupons-and-deals');
$no_expiry = (!empty($no_expiry)) ? $no_expiry : __("Doesn't expire", 'wp-coupons-and-deals');
$coupon_code = (!empty($coupon_code) ? $coupon_code : __('COUPONCODE', 'wp-coupons-and-deals'));
$deal_text = (!empty($deal_text) ? $deal_text : __('Claim This Deal', 'wp-coupons-and-deals'));
$coupon_hover_text = (!empty($coupon_hover_text)) ? $coupon_hover_text : __('Click To Copy Coupon', 'wp-coupons-and-deals');
$deal_hover_text = (!empty($deal_hover_text)) ? $deal_hover_text : __('Click Here To Get This Deal');
$wpcd_eight_btn_text = (!empty($wpcd_eight_btn_text)) ? $wpcd_eight_btn_text : __('GET THE DEAL', 'wp-coupons-and-deals');

$wpcd_template_eight_theme = get_post_meta($coupon_id, 'coupon_details_template-eight-theme', true);

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank";

if ($wpcd_text_to_show == 'description') {
    $wpcd_custom_text = $description;
} else if (empty($wpcd_custom_text)) {
    $wpcd_custom_text = __("Click on 'Copy' to Copy the Coupon Code.", 'wp-coupons-and-deals');
}
if (!$link && WPCD_Amp::wpcd_amp_is()) $link = "#";

$expireDateFormatFun = wpcd_getExpireDateFormatFun($expireDateFormat);
if (!empty($expire_date) && (string)(int)$expire_date == $expire_date) {
    $expire_date = date($expireDateFormatFun, $expire_date);
}

wp_enqueue_script('wpcd-clipboardjs');
$template = new WPCD_Template_Loader();

$wpcd_uniq_attr = '';
if (function_exists('wpcd_uniq_attr') && !WPCD_Amp::wpcd_amp_is() &&
    !empty($show_print_links) && $show_print_links == 'on') {
    $wpcd_uniq_attr = wpcd_uniq_attr(10);
}

?>

<!-- Template Nine Preview -->
<div class="wpcd-coupon-preview wpcd-coupon-nine">

    <div class="wpcd-coupon-content wpcd-col-2-8">
        <div class="wpcd-coupon-nine-header">
            <div class="wpcd-col-1-2 firstDiv">
                <<?= esc_html($coupon_title_tag); ?> class="wpcd-coupon-title">
                <a href="<?php echo esc_url($link); ?>" target="_blank" rel="nofollow"><?= esc_html($title) ?></a>
            </<?= esc_html($coupon_title_tag); ?>>
        </div>

        <div class="wpcd-col-1-2 second-div">
            <?php
            if ($hide_coupon == 'Yes' && !WPCD_Amp::wpcd_amp_is()) {
                $template->get_template_part('hide-coupon__premium_only');

            } else { ?>
                <div class="wpcd-coupon-not-hidden">
                    <div class="wpcd-coupon-code wpcd-col-2-4">
                        <a rel="nofollow" href="<?php echo esc_url($link); ?>"
                           class="<?php echo 'wpcd-btn-' . absint($coupon_id); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           target="<?php echo esc_attr($target); ?>"
                           title="<?php if (!WPCD_Amp::wpcd_amp_is()) {
                               if (!empty($coupon_hover_text)) {
                                   echo esc_attr($coupon_hover_text);
                               } else {
                                   echo __("Click To Copy Coupon", 'wp-coupons-and-deals');
                               }
                           }
                           ?>"
                           data-clipboard-text="<?php echo esc_attr($coupon_code); ?>">
                                    <span class="wpcd_coupon_icon">
                                    	<img class=""
                                             src="<?php echo esc_url(WPCD_Plugin::instance()->plugin_assets . 'img/coupon-code-24.png') ?>"
                                             style="width: 100%;height: 100%;">
                                    </span>

                            <?php echo esc_html($coupon_code); ?>
                        </a>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
</div><!-- End of Template Nine Preview -->
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function () {
        var clip = new ClipboardJS('.<?php echo esc_attr($button_class); ?>');
    });

</script>

<?php
if (!WPCD_Amp::wpcd_amp_is() && !empty($show_print_links) && $show_print_links == 'on') {
//    wpcd_coupon_print_link($wpcd_uniq_attr);
}
?>
