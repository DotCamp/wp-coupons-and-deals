<?php
global $coupon_id;
$coupon_vote = get_option( 'wpcd_coupon-vote-system' );

//Coupon vote
if ( $coupon_vote == "on" ){
    $up_votes = array_filter( explode( ",", get_post_meta( $coupon_id, "_up", true ) ) );
    $down_votes = array_filter( explode( ",", get_post_meta( $coupon_id, "_down", true ) ) );
    $all_votes = array_merge( $up_votes,$down_votes );
    if( !empty( $all_votes ) )
        $percentage = ceil( count( $up_votes ) / count( $all_votes ) * 100 );
    else
        $percentage = 100;
    ?>
    <div class="wpcd-vote-wrapper">
        <a class="wpcd-vote-up" href="#" data-id = "<?php echo $coupon_id; ?>"><span class="wpcd-tooltip"><?php echo __( 'It works.', 'wpcd-coupon' ); ?></span><div class="wpcd-thumbs-up"><img class="wpcd-svg" src="<?php echo WPCD_Plugin::instance()->plugin_assets.'svg/thumbs-up.svg'; ?>"/></div></a>
    <span class="wpcd-vote-percent" data-id="<?php echo $coupon_id ?>"><?php echo $percentage; ?>% <?php echo __( 'Success', 'wpcd-coupon' ); ?></span>
    <a class="wpcd-vote-down" href="#" data-id = "<?php echo $coupon_id; ?>">
        <span class="wpcd-tooltip"><?php echo __( 'It doesn\'t!', 'wpcd-coupon'); ?></span>
        <div class="wpcd-thumbs-down">
            <img class="wpcd-svg" src="<?php echo WPCD_Plugin::instance()->plugin_assets.'svg/thumbs-down.svg'; ?>"/>
        </div>
    </a>
    </div>
<?php
}
?>