<?php
global $coupon_id;
$enable_stats              = get_option('wpcd_enable-stats-count');
$link                      = get_post_meta($coupon_id, 'coupon_details_link', true);
$coupon_hover_text         = get_option('wpcd_coupon-hover-text');
$coupon_code               = get_post_meta($coupon_id, 'coupon_details_coupon-code-text', true);
$linkTarget                = get_option("wpcd_coupon-link-target");
$coupon_type               = get_post_meta($coupon_id, 'coupon_details_coupon-type', true);

$target = ($linkTarget == "on") ? "_self" : "_blank" ;

//Coupon vote
if ( isset($enable_stats) && $enable_stats == "on" ){
    $btn_class_name = $coupon_type == 'Deal'? "wpcd-deal-button": "wpcd-coupon-button";
    ?>
    <a rel="nofollow"
        class="wpcd-btn-<?php echo $coupon_id; ?> masterTooltip wpcd-btn <?php echo $btn_class_name ?>  wpcd-coupon-click-link"
        data-id="<?php echo $coupon_id; ?>" 
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
        <?php if ($coupon_type == 'Deal') {
            ?>
            <span class="wpcd_deal_icon">
                <img class="" src="<?php echo WPCD_Plugin::instance()->plugin_assets?>img/deal-24.png" style="width: 100%;height: 100%;" >
            </span><?php echo $deal_text; ?>
            <?php
        } else {
            ?>
            <span class="wpcd_coupon_icon">
                <img class="" src="<?php echo WPCD_Plugin::instance()->plugin_assets?>img/coupon-code-24.png" style="width: 100%;height: 100%;" >
            </span>
            <?php
        }
        echo $coupon_code; ?>
    </a>
    
<?php
} else {

}
?>