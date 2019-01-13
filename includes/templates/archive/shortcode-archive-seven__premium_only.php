<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/25/17
 * Time: 11:31 PM
 */
/**
 *
 * This exits from the script if it's accessed
 * directly from somewhere else.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
	include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id, $max_num_page;
$title                    = get_the_title();
$link                     = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code              = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$featured_img_url         = get_the_post_thumbnail_url( get_the_ID(), 'large' );
$coupon_thumbnail          = wpcd_coupon_thumbnail_img( $coupon_id );
$discount_text            = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
$deal_text                = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text        = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text          = get_option( 'wpcd_deal-hover-text' );
$button_class             = 'wpcd-btn-' . $coupon_id;
$no_expiry                = get_option( 'wpcd_no-expiry-message' );
$expire_text              = get_option( 'wpcd_expire-text' );
$expired_text             = get_option( 'wpcd_expired-text' );
$hide_coupon_text         = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text         = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag         = get_option( 'wpcd_coupon-title-tag', 'h1' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$coupon_share             = get_option( 'wpcd_coupon-social-share' );
$show_expiration          = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                    = date( 'd-m-Y' );
$expire_date              = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expire_date_format       = date( "m/d/Y", strtotime( $expire_date ) );
$never_expire             = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$expire_time              = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$hide_coupon              = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_coupon_image_id     = get_post_meta( $coupon_id, 'coupon_details_coupon-image-input', true );
$wpcd_coupon_image_src    = wp_get_attachment_image_src( $wpcd_coupon_image_id, 'full' );
$wpcd_show_print          = get_post_meta( $coupon_id, 'coupon_details_coupon-image-print', true );
$wpcd_image_width         = get_post_meta( $coupon_id, 'coupon_details_coupon-image-width', true );
$wpcd_image_height        = get_post_meta( $coupon_id, 'coupon_details_coupon-image-height', true );
$disable_menu             = get_option( 'wpcd_disable-menu-archive-code' );
$template                 = new WPCD_Template_Loader();
$coupon_categories        = get_the_terms( $coupon_id, 'wpcd_coupon_category' );
$coupon_categories_class  = '';
$post_id                   = get_the_ID();

if($coupon_categories && count($coupon_categories) > 0){
    foreach($coupon_categories as $category){
        $coupon_categories_class .= ' '.$category->slug;
    }
}

if ( is_array( $wpcd_coupon_image_src ) ) {
	$wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
	$wpcd_coupon_image_src = '';
}

$wpcd_coupon_template     = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
$wpcd_template_five_theme = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true );
$wpcd_coupon_thumbnail    = $featured_img_url;
$wpcd_template_six_theme  = get_post_meta( $coupon_id, 'coupon_details_template-six-theme', true );
$wpcd_dummy_coupon_img    = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';
$wpcd_text_to_show        = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text         = get_option( 'wpcd_custom-text' );
$dt_coupon_type_name 	  = get_option( 'wpcd_dt-coupon-type-text' );
$dt_deal_type_name 	      = get_option( 'wpcd_dt-deal-type-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}

/*
 * to build the parent elment
 * header and in the bottom footer
 */
global $parent;
include('header-default.php');
?>
<?php if ( $coupon_type === 'Image' ): ?>
    <div class="wpcd-coupon-image-wrapper">
        <style>
            .wpcd-coupon-image {
                text-align: center;
                margin: 0px auto;
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
        <div class="wpcd-coupon-image"
             style="width: <?php echo $wpcd_image_width; ?>; height: <?php echo $wpcd_image_height; ?>">
            <a href="<?php echo $link; ?>" target="_blank">
                <img src="<?php echo $wpcd_coupon_image_src; ?>"
                     alt="<?php _e( 'Coupon image not uploaded', 'wpcd-coupon' ); ?>">
            </a>
        </div>

		<?php if ( $wpcd_show_print != 'No' ): ?>
            <div style="text-align:center">
                <a class="coupon-image-print-link"
                   onclick="wpcd_print_coupon_img('<?php echo $wpcd_coupon_image_src; ?>')"><?php _e( 'Click To Print', 'wpcd-coupon' ); ?></a>
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
    </div>
<?php else: ?>
    <!--  Template Seven Start -->
    <section class="wpcd_seven wpcd-coupon-id-<?php echo $coupon_id; ?> wpcd_item <?php echo $coupon_categories_class; ?>"
             wpcd-data-search="<?php echo $title;?>">
        <div class="wpcd_seven_container">
            <div class="wpcd_seven_couponBox">
                <div class="wpcd_seven_percentAndPic">
                    <div class="wpcd_seven_percentOff">
                        <p><?php echo $discount_text; ?></p>
                    </div>

                    <div class="wpcd_seven_productPic">
                        <?php if($coupon_thumbnail): ?>
                        <a href="<?php echo $link; ?>" target="_blank">
                            <img src="<?php echo $coupon_thumbnail; ?>"
                                 alt="<?php _e( 'Coupon image not uploaded', 'wpcd-coupon' ); ?>" alt="Product-pic">
                        </a>
                        <?php else: ?>
                        <img src="http://rdironworks.com/wp-content/uploads/2017/12/dummy-200x200.png" alt="Product-pic">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="wpcd_seven_headingAndExpire">
                    <div class="wpcd_seven_heading">
                        <?php
                        if ( 'on' === $disable_coupon_title_link ) { ?>
                        <<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-new-title">
                        <?php echo $title; ?>
                    </<?php echo esc_html( $coupon_title_tag ); ?>> <?php
                    } else { ?>
                    <<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-new-title">
                    <a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
                </<?php echo esc_html( $coupon_title_tag ); ?>> <?php
                }?>
                <p><?php echo wpautop( $description, false );?></p>
                <div class="wpcd_seven_expire">
                    <p>
                        <?php if ( $expire_date ):?>
                        <?php
                        if ( ! empty( $expire_text ) ) {
                            echo $expire_text;
                        } else {
                            echo __( 'Expires on: ', 'wpcd-coupon' );
                        }
                        ?>
                        <span class="wpcd-coupon-seven-countdown" id="clock_seven_<?php echo $post_id; ?>"></span>

                        <?php if ( ! $expire_date ) {
                            $expire_date_format = date( 'd/m/Y' );
                        } ?>
                        <script type="text/javascript">

                            var hasDate = "<?php echo empty( $expire_date ) ? 'no' : 'yes';?>";
                            if (hasDate === 'no')
                                jQuery('#clock_seven_<?php echo $post_id; ?>').hide();
                            var $clock2 = jQuery('#clock_seven_<?php echo $post_id; ?>').countdown('<?php echo $expire_date_format . ' ' . $expire_time; ?>', function (event) {
                                var format = '%M <?php echo __( 'minutes', 'wpcd-coupon' ); ?> %S <?php echo __( 'seconds', 'wpcd-coupon' ); ?>';
                                if (event.offset.hours > 0) {
                                    format = "%H <?php echo __( 'hours', 'wpcd-coupon' ); ?> %M <?php echo __( 'minutes', 'wpcd-coupon' ); ?> %S <?php echo __( 'seconds', 'wpcd-coupon' ); ?>";
                                }
                                if (event.offset.totalDays > 0) {
                                    format = "%-d <?php echo __( 'day', 'wpcd-coupon' ); ?>%!d " + format;
                                }
                                if (event.offset.weeks > 0) {
                                    format = "%-w <?php echo __( 'week', 'wpcd-coupon' ); ?>%!w " + format;
                                }
                                jQuery(this).html(event.strftime(format));
                                if (event.offset.weeks == 0 && event.offset.totalDays == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds == 0) {
                                    jQuery(this).addClass('wpcd-countdown-expired').html('<?php echo __( 'This offer has expired!', 'wpcd-coupon' ); ?>');
                                } else {
                                    jQuery(this).html(event.strftime(format));
                                    jQuery('#clock_seven_<?php echo $post_id; ?>').removeClass('wpcd-countdown-expired');
                                }
                            });
                            jQuery("#expire-time").change(function () {
                                jQuery('#clock_seven_<?php echo $post_id; ?>').show();
                                var coup_date = jQuery("#expire-date").val();
                                if (coup_date.indexOf("-") >= 0) {
                                    var dateAr = coup_date.split('-');
                                    coup_date = dateAr[1] + '/' + dateAr[0] + '/' + dateAr[2];
                                }
                                selectedDate = coup_date + ' ' + jQuery("#expire-time").val();
                                $clock2.countdown(selectedDate.toString());
                            });
                        </script>
                        <?php else :?>
                        <span class="never-expire">
                            <?php if ( ! empty( $no_expiry ) ) : ?>
                                <b><?php echo $no_expiry; ?></b>
                            <?php else : ?>
                                <b><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></b>
                            <?php endif; ?>

                        </span>
                        <?php endif; ?>
                    </p>
                </div><!-- End of class wpcd_seven_expire -->
            </div>
        </div>
        <?php if ( ! empty( $coupon_code ) ) : ?>
        <div class="wpcd_seven_buttonSociaLikeDislike">
            <div class="wpcd_seven_btn">
                <a href="<?php echo $link; ?>" title="<?php echo $coupon_code; ?>"><?php echo $coupon_code; ?></a>
            </div>
        </div>
        <?php endif; ?>
    </section>

	 <!--  Template Seven End -->
<?php endif; ?>
<?php include('footer-default.php'); ?>