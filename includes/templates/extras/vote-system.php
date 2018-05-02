<?php
    global $coupon_id;
    $up_votes = array_filter( explode( ",", get_post_meta( $coupon_id, "_up", true ) ) );
    $down_votes = array_filter( explode( ",", get_post_meta( $coupon_id, "_down", true ) ) );
    $all_votes = array_merge( $up_votes,$down_votes );
    if( !empty( $all_votes ) )
        $percentage = ceil( count( $up_votes ) / count( $all_votes ) * 100 );
    else
        $percentage = 100;
?>
<div class="vote-wrapper">
    <a class="vote-up" href="#" data-id = "<?php echo $coupon_id; ?>">
        <span class="wpcd-tooltip"><?php echo __( 'It works!', 'wpcd-coupon' ); ?></span>
        <i class="fas fa-thumbs-up"></i>
    </a>
    <span class="vote-percent" data-id="<?php echo $coupon_id ?>"><?php echo $percentage; ?>% Success</span>
    <a class="vote-down" href="#" data-id = "<?php echo $coupon_id; ?>">
        <span class="wpcd-tooltip"><?php echo __( 'It doesn\'t!', 'wpcd-coupon'); ?></span>
        <i class="fas fa-thumbs-down"></i>
    </a>
</div>