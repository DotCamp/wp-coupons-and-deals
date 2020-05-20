<?php

/**
 *
 * This exits from the script if it's accessed
 * directly from somewhere else.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This is the default Shortcode template.
 *
 * @since 2.3
 */

global $coupon_id;

$wpcd_coupon_image_id  = get_post_meta( $coupon_id, 'coupon_details_coupon-image-input', true );
$wpcd_coupon_image_src = wp_get_attachment_image_src( $wpcd_coupon_image_id, 'full' );
$wpcd_link             = get_post_meta( $coupon_id, 'coupon_details_link', true );
$wpcd_show_print       = get_post_meta( $coupon_id, 'coupon_details_coupon-image-print', true );
$wpcd_image_width      = get_post_meta( $coupon_id, 'coupon_details_coupon-image-width', true );
$wpcd_image_height     = get_post_meta( $coupon_id, 'coupon_details_coupon-image-height', true );

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ( is_array( $wpcd_coupon_image_src ) ) {
	$wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
	$wpcd_coupon_image_src = '';
}
?>

<div class="wpcd-coupon-image-wrapper">
<?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
    <style>
        .wpcd-coupon-image {
            text-align: center;
            margin: 0px auto;
        }

        .wpcd-coupon-image img {
            display: inline-block;
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
        <a href="<?php echo $wpcd_link; ?>" target="<?php echo $target; ?>">
            <img class="wpcd_coupon_img" src="<?php echo $wpcd_coupon_image_src; ?>"
                 alt="<?php _e( 'Coupon image not uploaded', 'wpcd-coupon' ); ?>">
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
               onclick="wpcd_print_coupon_img('<?php echo $wpcd_coupon_image_src; ?>')"><?php _e( 'Click To Print', 'wpcd-coupon' ); ?></a>
        </div>
        <script>
            function wpcd_print_coupon_img( url ) {
                if ( ! url ) return;

                if( ! Boolean( window.chrome ) ) {
                    let win = window.open( "" );

                    setTimeout( function () {
                        win.document.write( '<img style="max-width:100%" src="' + url + '" onload="window.print();window.close()" />' );
                        win.focus();
                    }, 500 );
                } else {
                    document.body.innerHTML = '<img style="max-width:100%" src="' + url + '" />';
                    setTimeout( function () {
                        window.print();
                        window.location.reload( true );
                    }, 500 );
                }
            }
        </script>
	<?php endif; ?>
<?php endif; ?>
</div>