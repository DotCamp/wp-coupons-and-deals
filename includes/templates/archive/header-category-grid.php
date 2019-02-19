<?php
/*
 * Header for Category Grid Templates
 */
if ( $parent == 'header' || $parent == 'headerANDfooter' ): ?>
    <section class="wpcd_archive_section wpcd_clearfix">
    	<?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
	        <div class="wpcd_coupon_archive_container_main">
	            <div class="wpcd_coupon_loader wpcd_coupon_hidden_loader">
	                <img src="<?php echo WPCD_Plugin::instance()->plugin_assets . 'img/loading.gif'; ?>">
	            </div>
	            <div id="wpcd_coupon_archive_container">
	    <?php endif; ?>
        <ul id="wpcd_coupon_ul" class="wpcd_clearfix">
<?php endif;