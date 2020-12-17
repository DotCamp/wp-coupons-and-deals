<?php
/*
 * Header for Category Templates
 */
if ( $parent == 'header' || $parent == 'headerANDfooter' ):
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_cat_vend_action' ):
        ?>
    <section class="wpcd_archive_section wpcd_clearfix">
    	<?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
	        <div class="wpcd_coupon_archive_container_main">
	            <div class="wpcd_coupon_archive_container">
	    <?php endif; ?>
    <?php endif;?>
<?php endif;
