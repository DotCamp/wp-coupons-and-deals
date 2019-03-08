<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 9/10/17
 * Time: 8:43 PM
 */

global $coupon_id, $num_coupon;

$title                    = get_the_title();
$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
$discount_text            = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$featured_img_url         = get_the_post_thumbnail_url( get_the_ID(), 'large' );
$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$link                     = get_post_meta( $coupon_id, 'coupon_details_link', true );
$link_second              = get_post_meta( $coupon_id, 'coupon_details_second-link', true );
$link_third               = get_post_meta( $coupon_id, 'coupon_details_third-link', true );
$coupon_code              = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$coupon_code_second       = get_post_meta( $coupon_id, 'coupon_details_second-coupon-code-text', true );
$coupon_code_third        = get_post_meta( $coupon_id, 'coupon_details_third-coupon-code-text', true );
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
$show_expiration          = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                    = date( 'd-m-Y' );
$expire_date              = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$hide_coupon              = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );

$wpcd_text_to_show       = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text        = get_option( 'wpcd_custom-text' );
$wpcd_enable_goto_button = get_option( 'wpcd_popup-goto-link' );
$wpcd_custom_goto        = get_option( 'wpcd_popup-goto-custom-text' );

$new_coupon_id            = $coupon_id;
$wpcd_coupon_template     = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
$wpcd_template_five_theme = get_post_meta( $coupon_id, 'coupon_details_template-five-theme', true );
$wpcd_coupon_thumbnail    = $featured_img_url;
$wpcd_template_six_theme  = get_post_meta( $coupon_id, 'coupon_details_template-six-theme', true );
$wpcd_template_seven_theme  = get_post_meta( $coupon_id, 'coupon_details_template-seven-theme', true );
$wpcd_template_eight_theme  = get_post_meta( $coupon_id, 'coupon_details_template-eight-theme', true );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}

$wpcd_show_coupon_popup = ! empty( $_GET['wpcd_coupon'] ) && $_GET['wpcd_coupon'] == $coupon_id;
echo $coupon_template;
?>


<?php if ( $wpcd_coupon_template === 'Template Four' ): ?>

    <?php 
        // getting of link and coupon code for each button
        if ( ! function_exists('wpcdCheckNumberCouponDeal')) {
          function wpcdCheckNumberCouponDeal() {
            static $wpcd_template_four_number_iter;
            if ( $wpcd_template_four_number_iter == 1 ) {
              $wpcd_template_four_number_iter = 2;
            } elseif ( $wpcd_template_four_number_iter == 2 ) {
              $wpcd_template_four_number_iter = 3;
            } else {
              $wpcd_template_four_number_iter = 1;
            }
            return $wpcd_template_four_number_iter;
          }
        }

        $wpcd_template_four_number_iter = wpcdCheckNumberCouponDeal();
        if ( $wpcd_template_four_number_iter == 2 ) {
          $coupon_code = $coupon_code_second;
          $link = $link_second;
        } 
        if ( $wpcd_template_four_number_iter == 3 ) {
          $coupon_code = $coupon_code_third;
          $link = $link_third;
        }
    ?>

    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-id-<?php echo $new_coupon_id; ?> wpcd-coupon-button-type">
        <a data-type="code" data-coupon-id="<?php echo $new_coupon_id; ?>"
           href="?wpcd_coupon=<?php echo $new_coupon_id; echo ( $wpcd_template_four_number_iter ) ? '&wpcd_num_coupon='.$wpcd_template_four_number_iter : '';?>" class="coupon-button coupon-code-wpcd masterTooltip"
           id="coupon-button-<?php echo $new_coupon_id; ?>" title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
      echo $hidden_coupon_hover_text;
    } else {
      _e( 'Click Here to Show Code', 'wpcd-coupon' );
    } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo $link; ?>"
           onClick="return wpcdOpenCouponAffLink(this, '<?php echo $new_coupon_id; ?>', '<?php echo $wpcd_template_four_number_iter; ?>')" target="_blank">
            <span class="code-text-wpcd" rel="nofollow"><?php echo $coupon_code; ?></span>
            <span class="get-code-wpcd">
        <?php
        if ( ! empty( $hide_coupon_text ) ) {
          echo $hide_coupon_text;
        } else {
          echo __( 'Show Code', 'wpcd-coupon' );
        }

        ?>
        </span>

        </a>
    </div>

<?php elseif ( $wpcd_coupon_template === 'Template Five' ): ?>

    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden <?php echo $button_class; ?>">
      <a data-type="code" data-coupon-id="<?php echo $new_coupon_id; ?>"
           href="<?php echo $wpcd_show_coupon_popup ? 'javascript:void(0)' : '?wpcd_coupon=' . $new_coupon_id; ?>"
           target="_blank"
           class="coupon-button coupon-code-wpcd <?php echo $wpcd_show_coupon_popup ? '' : 'masterTooltip'; ?> <?php echo $button_class; ?>"
           id="coupon-button-<?php echo $new_coupon_id; ?>"
           title="<?php if ( $wpcd_show_coupon_popup ) {
		   } else if ( ! empty( $hidden_coupon_hover_text ) ) {
			   echo $hidden_coupon_hover_text;
		   } else {
			   _e( 'Click Here to Show Code', 'wpcd-coupon' );
		   } ?>"
           data-position="top center"
           data-inverted=""
           data-aff-url="<?php echo $link; ?>"
           onClick="return wpcdOpenCouponAffLink(this, '<?php echo $new_coupon_id; ?>')"
           data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
			   echo $coupon_code;
		   } else {
			   echo __( 'COUPONCODE', 'wpcd-coupon' );
		   } ?>">
        <span class="code-text-wpcd" rel="nofollow"
              style="<?php echo $wpcd_show_coupon_popup ? 'text-align: center;' : ''; ?>"><?php if ( ! empty( $coupon_code ) ) {
		        echo $coupon_code;
	        } else {
		        echo __( 'COUPONCODE', 'wpcd-coupon' );
	        } ?></span>
              <span class="get-code-wpcd <?php echo $wpcd_show_coupon_popup ? 'hidden' : ''; ?>">
                  <div class="square_wpcd" style="background-color: <?php echo $wpcd_template_five_theme; ?>"></div>
                  <span>
                    <?php
                    if ( ! empty( $hide_coupon_text ) ) {
                      echo $hide_coupon_text;
                    } else {
                      echo __( 'Show Code', 'wpcd-coupon' );
                    }
                    ?>
                  </span>
                  <div class="rectangle_wpcd" style="border-left-color: <?php echo $wpcd_template_five_theme; ?>"></div>
              </span>
        </a>
    </div>

<?php elseif ( $wpcd_coupon_template === 'Template Six' ): ?>

    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
        <div class="wpcd-btn-wrap">
            <a data-type="code" data-coupon-id="<?php echo $new_coupon_id; ?>"
               href="<?php echo $wpcd_show_coupon_popup ? 'javascript:void(0)' : '?wpcd_coupon=' . $new_coupon_id; ?>"
               href=""
               class="coupon-button coupon-code-wpcd <?php echo $wpcd_show_coupon_popup ? '' : 'masterTooltip'; ?> <?php echo $button_class; ?>"
               id="coupon-button-<?php echo $new_coupon_id; ?>"
               title="<?php if ( $wpcd_show_coupon_popup ) {
			   } else if ( ! empty( $hidden_coupon_hover_text ) ) {
				   echo $hidden_coupon_hover_text;
			   } else {
				   _e( 'Click Here to Show Code', 'wpcd-coupon' );
			   } ?>"
               data-position="top center"
               data-inverted=""
               data-aff-url="<?php echo $link; ?>"
               onClick="return wpcdOpenCouponAffLink(this, '<?php echo $new_coupon_id; ?>')"
               style="border-color: <?php echo $wpcd_template_six_theme; ?>">
            <span class="code-text-wpcd" rel="nofollow"
                  style="<?php echo $wpcd_show_coupon_popup ? 'display: inline-block; width: 100%; text-align: center;' : ''; ?>"><?php if ( ! empty( $coupon_code ) ) {
		            echo $coupon_code;
	            } else {
		            echo __( 'COUPONCODE', 'wpcd-coupon' );
	            } ?></span>
                    <span class="get-code-wpcd <?php echo $wpcd_show_coupon_popup ? 'hidden' : ''; ?>">
                        <div class="square_wpcd" style="background-color: <?php echo $wpcd_template_six_theme; ?>"></div>
                        <span>
                          <?php
                          if ( ! empty( $hide_coupon_text ) ) {
                            echo $hide_coupon_text;
                          } else {
                            echo __( 'Show Code', 'wpcd-coupon' );
                          }
                          ?>
                        </span>
                        <div class="rectangle_wpcd" style="border-left-color: <?php echo $wpcd_template_six_theme; ?>"></div>
                    </span>
            </a>
        </div>
    </div>
<?php elseif ( $wpcd_coupon_template === 'Template Seven' ): 
      ?>
    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden <?php echo $button_class; ?>">
      <a data-type="code" data-coupon-id="<?php echo $new_coupon_id; ?>"
           href="<?php echo $wpcd_show_coupon_popup ? 'javascript:void(0)' : '?wpcd_coupon=' . $new_coupon_id; ?>"
           target="_blank"
           class="coupon-button coupon-code-wpcd <?php echo $wpcd_show_coupon_popup ? '' : 'masterTooltip'; ?> <?php echo $button_class; ?>"
           id="coupon-button-<?php echo $new_coupon_id; ?>"
           title="<?php if ( $wpcd_show_coupon_popup ) {
       } else if ( ! empty( $hidden_coupon_hover_text ) ) {
         echo $hidden_coupon_hover_text;
       } else {
         _e( 'Click Here to Show Code', 'wpcd-coupon' );
       } ?>"
           data-position="top center"
           data-inverted=""
           data-aff-url="<?php echo $link; ?>"
           onClick="return wpcdOpenCouponAffLink(this, '<?php echo $new_coupon_id; ?>')"
           data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
         echo $coupon_code;
       } else {
         echo __( 'COUPONCODE', 'wpcd-coupon' );
       } ?>">
        <span class="code-text-wpcd" rel="nofollow"
              style="<?php echo $wpcd_show_coupon_popup ? 'text-align: center;' : ''; ?>"><?php if ( ! empty( $coupon_code ) ) {
            echo $coupon_code;
          } else {
            echo __( 'COUPONCODE', 'wpcd-coupon' );
          } ?>
        </span>
        <span class="get-code-wpcd <?php echo $wpcd_show_coupon_popup ? 'hidden' : ''; ?>">
            <div class="square_wpcd" style="background-color: <?php echo $wpcd_template_seven_theme; ?>"></div>
            <span>
              <?php
              if ( ! empty( $hide_coupon_text ) ) {
                echo $hide_coupon_text;
              } else {
                echo __( 'Show Code', 'wpcd-coupon' );
              }
              ?>
            </span>
            <div class="rectangle_wpcd" style="border-left-color: <?php echo $wpcd_template_seven_theme; ?>"></div>
        </span>
        </a>
    </div>
<?php elseif ( $wpcd_coupon_template === 'Template Eight' ): 
      ?>
    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden <?php echo $button_class; ?>">
      <a data-type="code" data-coupon-id="<?php echo $new_coupon_id; ?>"
           href="<?php echo $wpcd_show_coupon_popup ? 'javascript:void(0)' : '?wpcd_coupon=' . $new_coupon_id; ?>"
           target="_blank"
           class="coupon-button coupon-code-wpcd <?php echo $wpcd_show_coupon_popup ? '' : 'masterTooltip'; ?> <?php echo $button_class; ?>"
           id="coupon-button-<?php echo $new_coupon_id; ?>"
           title="<?php if ( $wpcd_show_coupon_popup ) {
       } else if ( ! empty( $hidden_coupon_hover_text ) ) {
         echo $hidden_coupon_hover_text;
       } else {
         _e( 'Click Here to Show Code', 'wpcd-coupon' );
       } ?>"
           data-position="top center"
           data-inverted=""
           data-aff-url="<?php echo $link; ?>"
           onClick="return wpcdOpenCouponAffLink(this, '<?php echo $new_coupon_id; ?>')"
           data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
         echo $coupon_code;
       } else {
         echo __( 'COUPONCODE', 'wpcd-coupon' );
       } ?>">
        <span class="code-text-wpcd" rel="nofollow"
              style="<?php echo $wpcd_show_coupon_popup ? 'text-align: center;' : ''; ?>"><?php if ( ! empty( $coupon_code ) ) {
            echo $coupon_code;
          } else {
            echo __( 'COUPONCODE', 'wpcd-coupon' );
          } ?>
        </span>
        <span class="get-code-wpcd <?php echo $wpcd_show_coupon_popup ? 'hidden' : ''; ?>">
            <div class="square_wpcd" style="background-color: <?php echo $wpcd_template_eight_theme; ?>"></div>
            <span>
              <?php
              if ( ! empty( $hide_coupon_text ) ) {
                echo $hide_coupon_text;
              } else {
                echo __( 'Show Code', 'wpcd-coupon' );
              }
              ?>
            </span>
            <div class="rectangle_wpcd" style="border-left-color: <?php echo $wpcd_template_eight_theme; ?>"></div>
                <div style="border-left-color: <?php echo $wpcd_template_eight_theme; ?>"></div>
        </span>
        </a>
    </div>
<?php else: ?>


<?php endif; ?>

    <!-- Coupon Popup -->
    <?php 
      if( $wpcd_template_four_number_iter ) {
          $wpcd_num_coupon = $wpcd_template_four_number_iter;
        } else {
          $wpcd_num_coupon = '';
        }
    ?>
    <section id="wpcd_coupon_popup_<?php echo $new_coupon_id.$wpcd_num_coupon; ?>" class="wpcd_coupon_popup_wr" style="display:none">
        <div class="wpcd_coupon_popup_layer"></div>
        <div class="wpcd_coupon_popup_inner">
            <div class="wpcd_coupon_popup_top_head">
                <p class="wpcd_coupon_popup_title">
					<?php echo get_the_title( $new_coupon_id ) ?>
                </p>
                <span class="wpcd_coupon_popup_close">&times;</span>
            </div>
            <div class="wpcd_coupon_popup_copy_main">
                <div class="wpcd_coupon_popup_copy_text">
                    <p><?php echo $wpcd_custom_text; ?></p>
                </div>
                <div class="wpcd_coupon_popup_copy_code_wr">
                    <span class="wpcd_coupon_popup_copy_code_span"><?php echo $coupon_code; ?></span>
                    <span class="wpcd_coupon_top_copy_span wpcd_coupon_top_copy_span_<?php echo $new_coupon_id; ?>"
                          data-clipboard-text="<?php echo $coupon_code; ?>"><?php if ( ! empty( $copy_button_text ) ) {
							echo $copy_button_text;
						} else {
							echo __( 'Copy', 'wpcd-coupon' );
						} ?></span>
                    <span id="coupon_code_<?php echo $new_coupon_id; ?>"
                          style="display:none;"><?php echo $coupon_code; ?></span>
                </div>
				<?php
				$copy_button_text = get_option( 'wpcd_copy-button-text' );
				$after_copy_text  = get_option( 'wpcd_after-copy-text' );

				if ( ! empty( $copy_button_text ) ) {
					$button_text = $copy_button_text;
				} else {
					$button_text = __( 'Copy', 'wpcd-coupon' );
				}

				if ( ! empty( $after_copy_text ) ) {
					$after_copy = $after_copy_text;
				} else {
					$after_copy = __( 'Copied', 'wpcd-coupon' );
				}
				?>
                <script type="text/javascript">

                    var clip = new Clipboard('.wpcd_coupon_top_copy_span_<?php echo $new_coupon_id; ?>');
                    clip.on("success", function () {

                        document.querySelector('.wpcd_coupon_top_copy_span_<?php echo $new_coupon_id; ?>').innerText = '<?php echo $after_copy; ?>';
                        setTimeout(function () {
                            document.querySelector('.wpcd_coupon_top_copy_span_<?php echo $new_coupon_id; ?>').innerText = '<?php echo $button_text; ?>';
                        }, 500);

                    });
                </script>
	            <?php if ( $wpcd_enable_goto_button === 'on' ) { ?>
                    <a target="_blank" rel="nofollow" class="wpcd_popup-go-link" href="<?php echo $link; ?>">
			            <?php

			            if ( ! empty( $wpcd_custom_goto ) ) {
				            echo $wpcd_custom_goto;
			            } else {
				            echo __( 'Go to Offer', 'wpcd-coupon' );
			            }

			            ?>
                    </a>
	            <?php } ?>
            </div>
        </div>
    </section>


<?php if ( isset( $_GET['wpcd_coupon'] ) && $_GET['wpcd_coupon'] != '' && $_GET['wpcd_coupon'] == $new_coupon_id ) { 
    if( $_GET['wpcd_num_coupon'] ) {
      $wpcd_num_coupon = $_GET['wpcd_num_coupon'];
    } else {
      $wpcd_num_coupon = '';
    }
?>
    <script type="text/javascript">
        function open_wpcd_popup(id) {
            jQuery("#wpcd_coupon_popup_" + id).fadeIn();
        }

        open_wpcd_popup("<?php echo $new_coupon_id.$wpcd_num_coupon; ?>");
    </script>

<?php } ?>
