<?php
/*
 * Header for Category Grid Templates
 */
if ( $parent == 'header' || $parent == 'headerANDfooter' ):
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_cat_vend_action' ):
        ?>
        <section class="wpcd_archive_section wpcd_clearfix wpcd_archive_section_grid">
        <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
            <div class="wpcd_coupon_archive_container_main">
                <div class="wpcd_coupon_archive_container">
                <?php endif; ?>
    <?php endif;?>
	<?php if( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_cat_vend_action' || !infinity_scroll_in_archive() ) {
        echo '<ul id="wpcd_coupon_ul" class="wpcd_clearfix">';
    } ?>
<?php endif;
