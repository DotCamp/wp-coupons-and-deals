<div class="wpcd-share-buttons-container">
    <div class="col-md-12 row">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank" class="wpcd-btn-social wpcd-btn-xs wpcd-btn-facebook"><i class="wpcd-facebook-f"><img class="wpcd-svg" src="<?php echo WPCD_Plugin::instance()->plugin_assets.'svg/facebook-f.svg'; ?>"/></i></a>
        <a href="https://plus.google.com/share?url=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank" class="wpcd-btn-social wpcd-btn-xs wpcd-btn-google-plus"><i class="wpcd-google-plus-g"><img class="wpcd-svg" src="<?php echo WPCD_Plugin::instance()->plugin_assets.'svg/google-plus-g.svg'; ?>"/></i></a>
        <a href="http://twitter.com/share?text=<?php echo the_title(); ?> Coupon&url=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank" class="wpcd-btn-social wpcd-btn-xs wpcd-btn-twitter"><i class="wpcd-twitter"><img class="wpcd-svg" src="<?php echo WPCD_Plugin::instance()->plugin_assets.'svg/twitter.svg'; ?>"/></i></a>
    </div>
</div>