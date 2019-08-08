<?php
/*
 * Coupon Type Image
 */

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;
?>
<div class="wpcd-coupon-image-wrapper">
<?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
    <style>
        .wpcd-coupon-image {
            text-align: center;
            margin: 0px auto;
        }

        .wpcd-coupon-image div {
            padding: 10px;
            border: 2px dashed #000000;
            display: inline-block;
        }

        .wpcd-coupon-image img {
            max-width: 100%;
            max-height: 100%;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            padding: 10px;
            border: 2px dashed #000000;
        }

        .coupon-image-print-link {
            font-size: 16px;
            display: inline-block;
            color: blue;
            line-height: 26px;
            cursor: pointer;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            text-decoration: underline;
        }

        .coupon-image-print-link:hover {
            color: blue !important;
            text-decoration: underline;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }
    </style>
<?php endif; ?>
    <div class="wpcd-coupon-image"
         style="width: <?php echo $wpcd_image_width; ?>; height: <?php echo $wpcd_image_height; ?>">
        <a href="<?php echo $link; ?>" target="<?php echo $target; ?>">
            <img src="<?php echo $wpcd_coupon_image_src; ?>"
                 alt="<?php _e('Coupon image not uploaded', 'wpcd-coupon'); ?>">
            <?php 
                if( WPCD_Amp::wpcd_amp_is() ) {
                    echo '<div>' . __('Coupon image not uploaded', 'wpcd-coupon') . '</div>';
                }
            ?>
        </a>
    </div>
<?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
    <?php if ( $wpcd_show_print != 'No' ): ?>
        <div style="text-align:center">
            <a class="coupon-image-print-link"
               onclick="wpcd_print_coupon_img('<?php echo $wpcd_coupon_image_src; ?>')"><?php _e('Click To Print', 'wpcd-coupon'); ?></a>
        </div>
        <script>
            function wpcd_print_coupon_img(url) {
                if (!url) return;
                var win = window.open("");
                win.document.write('<img style="max-width:100%" src="' + url + '" onload="window.print();window.close()" />');
                win.focus()
            }
        </script>
    <?php endif; ?>
<?php endif; ?>
</div>
