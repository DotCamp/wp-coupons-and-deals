<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/25/17
 * Time: 11:31 PM
 */

if ( !function_exists( 'wpcd_coupon_thumbnail_img' ) ) {
	include WPCD_Plugin::instance()->plugin_includes . 'functions/wpcd-coupon-thumbnail-img.php';
}

global $coupon_id, $parent;
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
$coupon_share = get_option( 'wpcd_coupon-social-share' );
$show_expiration          = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                    = date( 'd-m-Y' );
$expire_date              = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expire_date_format       = date( "m/d/Y", strtotime( $expire_date ) );
$expire_time              = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$never_expire             = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$hide_coupon              = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_coupon_image_id     = get_post_meta( $coupon_id, 'coupon_details_coupon-image-input', true );
$wpcd_coupon_image_src    = wp_get_attachment_image_src( $wpcd_coupon_image_id, 'full' );
$wpcd_show_print          = get_post_meta( $coupon_id, 'coupon_details_coupon-image-print', true );
$wpcd_image_width         = get_post_meta( $coupon_id, 'coupon_details_coupon-image-width', true );
$wpcd_image_height        = get_post_meta( $coupon_id, 'coupon_details_coupon-image-height', true );
$template = new WPCD_Template_Loader();

if ( is_array( $wpcd_coupon_image_src ) ) {
	$wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
	$wpcd_coupon_image_src = '';
}

$wpcd_coupon_template     = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
$wpcd_template_five_theme = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true ); // the color of five theme
$wpcd_coupon_thumbnail    = $featured_img_url;
$wpcd_template_six_theme  = get_post_meta( $coupon_id, 'coupon_details_template-six-theme', true ); // the color of the theme six
$wpcd_dummy_coupon_img   = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';

$wpcd_text_to_show = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text  = get_option( 'wpcd_custom-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}


if ( $parent == 'header' || $parent == 'headerANDfooter' ): ?>
<section class="wpcd_archive_section wpcd_clearfix">
	<?php endif; ?>

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
    
    <!--- Template three start -->
            
        
<div class="wpcd-coupon-three wpcd-coupon-id-<?php echo $coupon_id; ?>">
    <div class="wpcd-coupon-three-content">
		<div  class="wpcd-coupon-three-title">
			<?php
				if ( 'on' === $disable_coupon_title_link ) { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<?php echo $title; ?>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
			 	<?php } else { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<a href="<?php echo $link; ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
				<?php } 
			?>
		</div>
		<div class="wpcd-coupon-description">
            <span class="wpcd-full-description"><?php echo $description; ?></span>
            <span class="wpcd-short-description"></span>
            <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
            <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
        </div>
    </div>
    <div class="wpcd-coupon-three-info">
		<?php
		if ( $coupon_type == 'Coupon' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $expire_date ) ) {
					if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-three-expire">
                            <p>
								<?php
								if ( ! empty( $expire_text ) ) {
									echo $expire_text . ' ' . $expire_date;
								} else {
									echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date;
								}
								?>
                            </p>
                        </div>
					<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-three-expire">
                            <p class="wpcd-coupon-three-expired">
								<?php
								if ( ! empty( $expired_text ) ) {
									echo $expired_text . ' ' . $expire_date;
								} else {
									echo __( 'Expired on: ', 'wpcd-coupon' ) . $expire_date;
								}
								?>
                            </p>
                        </div>
					<?php }
				} else { ?>
                    <div class="wpcd-coupon-three-expire">
						<?php if ( ! empty( $no_expiry ) ) { ?>
                            <p><?php echo $no_expiry; ?></p>
						<?php } else {
							echo '<p>' . __( "Doesn't expire", 'wpcd-coupon' ) . '</p>';
						}
						?>
                    </div>
				<?php }
			} else {
				echo '';
			}

		} elseif ( $coupon_type == 'Deal' ) {
			if ( $show_expiration == 'Show' ) {
				if ( ! empty( $expire_date ) ) {
					if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-three-expire">
                            <p>
								<?php
								if ( ! empty( $expire_text ) ) {
									echo $expire_text . ' ' . $expire_date;
								} else {
									echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date;
								}
								?>
                            </p>
                        </div>
					<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>
                        <div class="wpcd-coupon-three-expire">
                            <p class="wpcd-coupon-three-expired">
								<?php
								if ( ! empty( $expired_text ) ) {
									echo $expired_text . ' ' . $expire_date;
								} else {
									echo __( 'Expired on: ', 'wpcd-coupon' ) . $expire_date;
								}
								?>
                            </p>
                        </div>
					<?php }

				} else { ?>

                    <div class="wpcd-coupon-three-expire">

						<?php if ( ! empty( $no_expiry ) ) { ?>
                            <p><?php echo $no_expiry; ?></p>
						<?php } else {
							echo '<p>' . __( "Doesn't expire", 'wpcd-coupon' ) . '</p>';
						}
						?>
                    </div>

				<?php }
			} else {
				echo '';
			}
		} ?>
        <div class="wpcd-coupon-three-coupon">
			<?php 
			if ( $coupon_type == 'Coupon' ) {
				if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
					if ( $hide_coupon == 'Yes' ) {
						$template->get_template_part( 'hide-coupon__premium_only' );
					} else { ?>
                        <div class="wpcd-coupon-code">
                            <a rel="nofollow" href="<?php echo $link; ?>"
                               class="<?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                               target="_blank" href="<?php echo $link; ?>"
                               title="<?php if ( ! empty( $coupon_hover_text ) ) {
								   echo $coupon_hover_text;
							   } else {
								   echo __( "Click To Copy Coupon", 'wpcd-coupon' );
							   } ?>"
                               data-clipboard-text="<?php echo $coupon_code; ?>">
                                <span class="wpcd_coupon_icon"></span> <?php echo $coupon_code; ?>
                                <span id="coupon_code_<?php echo $coupon_id; ?>"
                                      style="display:none;"><?php echo $coupon_code; ?></span>
                            </a>
                        </div>
					<?php }
				} else { ?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow" href="<?php echo $link; ?>"
                           class="<?php echo 'wpcd-btn-' . $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           target="_blank" href="<?php echo $link; ?>"
                           title="<?php if ( ! empty( $coupon_hover_text ) ) {
							   echo $coupon_hover_text;
						   } else {
							   echo __( "Click To Copy Coupon", 'wpcd-coupon' );
						   } ?>"
                           data-clipboard-text="<?php echo $coupon_code; ?>">
                            <span class="wpcd_coupon_icon"></span> <?php echo $coupon_code; ?>
                            <span id="coupon_code_<?php echo $coupon_id; ?>"
                                  style="display:none;"><?php echo $coupon_code; ?></span>
                        </a>
                    </div>
				<?php }
			} elseif ( $coupon_type == 'Deal' ) { ?>
                <div class="wpcd-coupon-code">
                    <a rel="nofollow"
                       class="<?php echo 'wpcd-btn-' . $coupon_id; ?> wpcd-btn masterTooltip wpcd-deal-button"
                       title="<?php if ( ! empty( $deal_hover_text ) ) {
						   echo $deal_hover_text;
					   } else {
						   echo __( "Click Here To Get This Deal", 'wpcd-coupon' );
					   } ?>" href="<?php echo $link; ?>" target="_blank        ">
                        <span class="wpcd_deal_icon"></span><?php echo $deal_text; ?>
                    </a>
                </div>
			<?php } ?>
        </div>
    </div>
    <script type="text/javascript">
        var clip = new Clipboard('.<?php echo $button_class; ?>');
    </script>
    <div class="clearfix"></div>
    <?php
    if ( $coupon_share === 'on' ) {
	    $template->get_template_part('social-share');
    }
    $template->get_template_part('vote-system');
    ?>
</div>
        
	 <!--  Template three End --><?php endif; ?>


	<?php if ( $parent == 'footer' || $parent == 'headerANDfooter' ): ?>
    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix">
		<?php
		global $max_num_page;
		$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $max_num_page,
			'prev_next' => true,
			'prev_text' => __( '« Prev', 'wpcd-coupon' ),
			'next_text' => __( 'Next »', 'wpcd-coupon' ),
		) );
		?>
    </div>
</section>

<?php endif; ?>            
