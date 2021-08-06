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
$second_coupon_code        = get_post_meta( $coupon_id, 'coupon_details_second-coupon-code-text', true );
$third_coupon_code         = get_post_meta( $coupon_id, 'coupon_details_third-coupon-code-text', true );
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

$coupon_code               = ( ! empty( $coupon_code ) ? $coupon_code : __( 'COUPONCODE', 'wp-coupons-and-deals' ) );
$second_coupon_code        = ( ! empty( $second_coupon_code ) ? $second_coupon_code : __( 'COUPONCODE', 'wp-coupons-and-deals' ) );
$third_coupon_code         = ( ! empty( $third_coupon_code ) ? $third_coupon_code : __( 'COUPONCODE', 'wp-coupons-and-deals' ) );

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

$archive_category_setting = get_option( 'wpcd_archive-munu-categories' );
if( $archive_category_setting == 'vendor' ) {
    $wpcd_coupon_taxonomy = WPCD_Plugin::VENDOR_TAXONOMY;
    $wpcd_term_field_name = 'wpcd_vendor';
} else {
    $wpcd_coupon_taxonomy = WPCD_Plugin::CUSTOM_TAXONOMY;
    $wpcd_term_field_name = 'wpcd_category';
}

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wp-coupons-and-deals' );
	}
}

$wpcd_show_coupon_popup = ! empty( $_GET['wpcd_coupon'] ) && $_GET['wpcd_coupon'] == $coupon_id;


if ( isset( $_POST['wpcd_page_num'] ) && ! empty( $_POST['wpcd_page_num'] ) && absint( $_POST['wpcd_page_num'] ) == $_POST['wpcd_page_num'] ) {
    $wpcd_page_num = '&wpcd_page_num=' . absint( $_POST['wpcd_page_num'] );
} elseif ( isset( $_GET['wpcd_page_num'] ) && ! empty( $_GET['wpcd_page_num'] ) && absint( $_GET['wpcd_page_num'] ) == $_GET['wpcd_page_num'] ) {
    $wpcd_page_num = '&wpcd_page_num=' . absint( $_GET['wpcd_page_num'] );
} else {
    $wpcd_page_num = '';
}

if ( isset( $_POST[$wpcd_term_field_name] ) && ! empty( $_POST[$wpcd_term_field_name] ) && sanitize_text_field( $_POST[$wpcd_term_field_name] ) === $_POST[$wpcd_term_field_name] ) {
    $wpcd_data_taxonomy = '&' . esc_attr( $wpcd_term_field_name ) . '=' . esc_attr( $_POST[$wpcd_term_field_name] );
} elseif ( isset( $_GET[$wpcd_term_field_name] ) && ! empty( $_GET[$wpcd_term_field_name] ) && sanitize_text_field( $_GET[$wpcd_term_field_name] ) === $_GET[$wpcd_term_field_name] ) {
    $wpcd_data_taxonomy = '&' . esc_attr( $wpcd_term_field_name ) . '=' . esc_attr( $_GET[$wpcd_term_field_name] );
} else {
    $wpcd_data_taxonomy = '';
}
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
          $coupon_code = $second_coupon_code;
          $link = $link_second;
        } 
        if ( $wpcd_template_four_number_iter == 3 ) {
          $coupon_code = $third_coupon_code;
          $link = $link_third;
        }
    ?>

    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-id-<?php echo absint( $new_coupon_id ); ?> wpcd-coupon-button-type">
        <a data-type="code" data-coupon-id="<?php echo absint( $new_coupon_id ); ?>"
           href="?wpcd_coupon=<?php echo absint( $new_coupon_id ); echo ( absint( $wpcd_template_four_number_iter ) ) ? '&wpcd_num_coupon='. absint( $wpcd_template_four_number_iter ) : '';?>" class="coupon-button coupon-code-wpcd masterTooltip"
           id="coupon-button-<?php echo absint( $new_coupon_id ); ?>" title="<?php if ( ! empty( $hidden_coupon_hover_text ) ) {
      echo esc_attr( $hidden_coupon_hover_text );
    } else {
      _e( 'Click Here to Show Code', 'wp-coupons-and-deals' );
    } ?>" data-position="top center" data-inverted="" data-aff-url="<?php echo esc_url( $link ); ?>"
           onClick="return wpcd_openCouponAffLink( this, '<?php echo absint( $new_coupon_id ); ?>', '<?php echo absint( $wpcd_template_four_number_iter ); ?>' )" target="_blank">
            <span class="code-text-wpcd" rel="nofollow"><?php echo esc_html( $coupon_code ); ?></span>
            <span class="get-code-wpcd">
        <?php
        if ( ! empty( $hide_coupon_text ) ) {
          echo esc_html( $hide_coupon_text );
        } else {
          echo __( 'Show Code', 'wp-coupons-and-deals' );
        }

        ?>
        </span>

        </a>
    </div>

<?php elseif ( $wpcd_coupon_template === 'Template Five' ): ?>

    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden <?php echo esc_attr( $button_class ); ?>">
      <a data-type="code" data-coupon-id="<?php echo absint( $new_coupon_id ); ?>"
           href="<?php echo $wpcd_show_coupon_popup ? 'javascript:void(0)' : '?wpcd_coupon=' . absint( $new_coupon_id ) . $wpcd_data_taxonomy . absint( $wpcd_page_num ); ?>"
           target="_blank"
           class="coupon-button coupon-code-wpcd <?php echo $wpcd_show_coupon_popup ? '' : 'masterTooltip'; ?> <?php echo esc_attr( $button_class ); ?>"
           id="coupon-button-<?php echo absint( $new_coupon_id ); ?>"
           title="<?php if ( $wpcd_show_coupon_popup ) {
		   } else if ( ! empty( $hidden_coupon_hover_text ) ) {
			   echo esc_html( $hidden_coupon_hover_text );
		   } else {
			   _e( 'Click Here to Show Code', 'wp-coupons-and-deals' );
		   } ?>"
           data-position="top center"
           data-inverted=""
           data-aff-url="<?php echo esc_url( $link ); ?>"
           onClick="return wpcd_openCouponAffLink( this, '<?php echo absint( $new_coupon_id ); ?>', '<?php echo esc_attr( $wpcd_term_field_name );?>' )"
           data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
			   echo esc_html( $coupon_code );
		   } else {
			   echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
		   } ?>">
        <span class="code-text-wpcd" rel="nofollow"
              style="<?php echo $wpcd_show_coupon_popup ? 'text-align: center;' : ''; ?>"><?php if ( ! empty( $coupon_code ) ) {
		        echo esc_html( $coupon_code );
	        } else {
		        echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
	        } ?></span>
              <span class="get-code-wpcd <?php echo $wpcd_show_coupon_popup ? 'hidden' : ''; ?>">
                  <div class="square_wpcd" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>"></div>
                  <span>
                    <?php
                    if ( ! empty( $hide_coupon_text ) ) {
                      echo esc_html( $hide_coupon_text );
                    } else {
                      echo __( 'Show Code', 'wp-coupons-and-deals' );
                    }
                    ?>
                  </span>
                  <div class="rectangle_wpcd" style="border-left-color: <?php echo sanitize_hex_color( $wpcd_template_five_theme ); ?>"></div>
              </span>
        </a>
    </div>

<?php elseif ( $wpcd_coupon_template === 'Template Six' ): ?>

    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden">
        <div class="wpcd-btn-wrap">
            <a data-type="code" data-coupon-id="<?php echo absint( $new_coupon_id ); ?>"
               href="<?php echo $wpcd_show_coupon_popup ? 'javascript:void(0)' : '?wpcd_coupon=' . absint( $new_coupon_id ) . $wpcd_data_taxonomy . absint( $wpcd_page_num ); ?>"
               href=""
               class="coupon-button coupon-code-wpcd <?php echo $wpcd_show_coupon_popup ? '' : 'masterTooltip'; ?> <?php echo esc_attr( $button_class ); ?>"
               id="coupon-button-<?php echo absint( $new_coupon_id ); ?>"
               title="<?php if ( $wpcd_show_coupon_popup ) {
			   } else if ( ! empty( $hidden_coupon_hover_text ) ) {
				   echo esc_attr( $hidden_coupon_hover_text);
			   } else {
				   _e( 'Click Here to Show Code', 'wp-coupons-and-deals' );
			   } ?>"
               data-position="top center"
               data-inverted=""
               data-aff-url="<?php echo esc_url( $link ); ?>"
               onClick="return wpcd_openCouponAffLink( this, '<?php echo absint( $new_coupon_id ); ?>', '<?php echo esc_atr( $wpcd_term_field_name );?>' )"
               style="border-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>">
            <span class="code-text-wpcd" rel="nofollow"
                  style="<?php echo $wpcd_show_coupon_popup ? 'width: 100%; text-align: center;' : ''; ?>"><?php if ( ! empty( $coupon_code ) ) {
		            echo esc_html( $coupon_code );
	            } else {
		            echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
	            } ?></span>
                    <span class="get-code-wpcd <?php echo $wpcd_show_coupon_popup ? 'hidden' : ''; ?>">
                        <div class="square_wpcd" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>"></div>
                        <span>
                          <?php
                          if ( ! empty( $hide_coupon_text ) ) {
                            echo esc_html( $hide_coupon_text );
                          } else {
                            echo __( 'Show Code', 'wp-coupons-and-deals' );
                          }
                          ?>
                        </span>
                        <div class="rectangle_wpcd" style="border-left-color: <?php echo sanitize_hex_color( $wpcd_template_six_theme ); ?>"></div>
                    </span>
            </a>
        </div>
    </div>
<?php elseif ( $wpcd_coupon_template === 'Template Seven' ): 
      ?>
    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden <?php echo esc_attr( $button_class ); ?>">
      <a data-type="code" data-coupon-id="<?php echo absint( $new_coupon_id ); ?>"
           href="<?php echo $wpcd_show_coupon_popup ? 'javascript:void(0)' : '?wpcd_coupon=' . absint( $new_coupon_id ); ?>"
           target="_blank"
           class="coupon-button coupon-code-wpcd <?php echo $wpcd_show_coupon_popup ? '' : 'masterTooltip'; ?> <?php echo esc_attr( $button_class ); ?>"
           id="coupon-button-<?php echo absint( $new_coupon_id ); ?>"
           title="<?php if ( $wpcd_show_coupon_popup ) {
       } else if ( ! empty( $hidden_coupon_hover_text ) ) {
         echo esc_attr( $hidden_coupon_hover_text );
       } else {
         _e( 'Click Here to Show Code', 'wp-coupons-and-deals' );
       } ?>"
           data-position="top center"
           data-inverted=""
           data-aff-url="<?php echo esc_url( $link ); ?>"
           onClick="return wpcd_openCouponAffLink(this, '<?php echo absint( $new_coupon_id ); ?>')"
           data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
         echo esc_attr( $coupon_code );
       } else {
         echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
       } ?>">
        <span class="code-text-wpcd" rel="nofollow"
              style="<?php echo $wpcd_show_coupon_popup ? 'text-align: center;' : ''; ?>"><?php if ( ! empty( $coupon_code ) ) {
            echo esc_html( $coupon_code );
          } else {
            echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
          } ?>
        </span>
        <span class="get-code-wpcd <?php echo $wpcd_show_coupon_popup ? 'hidden' : ''; ?>">
            <div class="square_wpcd" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_seven_theme ); ?>"></div>
            <span>
              <?php
              if ( ! empty( $hide_coupon_text ) ) {
                echo esc_html( $hide_coupon_text );
              } else {
                echo __( 'Show Code', 'wp-coupons-and-deals' );
              }
              ?>
            </span>
            <div class="rectangle_wpcd" style="border-left-color: <?php echo sanitize_hex_color( $wpcd_template_seven_theme ); ?>"></div>
        </span>
        </a>
    </div>
<?php elseif ( $wpcd_coupon_template === 'Template Eight' ): 
      ?>
    <div class="coupon-code-wpcd coupon-detail wpcd-coupon-button-type wpcd-coupon-hidden <?php echo esc_attr( $button_class ); ?>">
      <a data-type="code" data-coupon-id="<?php echo absint( $new_coupon_id ); ?>"
           href="<?php echo $wpcd_show_coupon_popup ? 'javascript:void(0)' : '?wpcd_coupon=' . absint( $new_coupon_id ); ?>"
           target="_blank"
           class="coupon-button coupon-code-wpcd <?php echo $wpcd_show_coupon_popup ? '' : 'masterTooltip'; ?> <?php echo esc_attr( $button_class ); ?>"
           id="coupon-button-<?php echo absint( $new_coupon_id ); ?>"
           title="<?php if ( $wpcd_show_coupon_popup ) {
       } else if ( ! empty( $hidden_coupon_hover_text ) ) {
         echo esc_html( $hidden_coupon_hover_text );
       } else {
         _e( 'Click Here to Show Code', 'wp-coupons-and-deals' );
       } ?>"
           data-position="top center"
           data-inverted=""
           data-aff-url="<?php echo esc_url( $link ); ?>"
           onClick="return wpcd_openCouponAffLink(this, '<?php echo absint( $new_coupon_id ); ?>')"
           data-clipboard-text="<?php if ( ! empty( $coupon_code ) ) {
         echo esc_html( $coupon_code );
       } else {
         echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
       } ?>">
        <span class="code-text-wpcd" rel="nofollow"
              style="<?php echo $wpcd_show_coupon_popup ? 'text-align: center;' : ''; ?>"><?php if ( ! empty( $coupon_code ) ) {
            echo esc_html( $coupon_code );
          } else {
            echo __( 'COUPONCODE', 'wp-coupons-and-deals' );
          } ?>
        </span>
        <span class="get-code-wpcd <?php echo $wpcd_show_coupon_popup ? 'hidden' : ''; ?>">
            <div class="square_wpcd" style="background-color: <?php echo sanitize_hex_color( $wpcd_template_eight_theme ); ?>"></div>
            <span>
              <?php
              if ( ! empty( $hide_coupon_text ) ) {
                echo esc_html( $hide_coupon_text );
              } else {
                echo __( 'Show Code', 'wp-coupons-and-deals' );
              }
              ?>
            </span>
            <div class="rectangle_wpcd" style="border-left-color: <?php echo sanitize_hex_color( $wpcd_template_eight_theme ); ?>"></div>
            <div style="border-left-color: <?php echo sanitize_hex_color( $wpcd_template_eight_theme ); ?>"></div>
        </span>
        </a>
    </div>
<?php else: ?>


<?php endif; ?>

    <!-- Coupon Popup -->
    <?php 
      if( isset( $wpcd_template_four_number_iter ) && ! empty( $wpcd_template_four_number_iter ) ) {
          $wpcd_num_coupon = $wpcd_template_four_number_iter;
        } else {
          $wpcd_num_coupon = '';
        }
    ?>
    <section id="wpcd_coupon_popup_<?php echo esc_attr( $new_coupon_id.$wpcd_num_coupon ); ?>" class="wpcd_coupon_popup_wr" style="display:none">
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
                    <p><?php echo wp_kses_post( $wpcd_custom_text ); ?></p>
                </div>
                <div class="wpcd_coupon_popup_copy_code_wr">
                    <span class="wpcd_coupon_popup_copy_code_span"><?php echo esc_html( $coupon_code ); ?></span>
                    <span class="wpcd_coupon_top_copy_span wpcd_coupon_top_copy_span_<?php echo absint( $new_coupon_id ); ?>"
                          data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>"><?php if ( ! empty( $copy_button_text ) ) {
							echo esc_html( $copy_button_text );
						} else {
							echo __( 'Copy', 'wp-coupons-and-deals' );
						} ?></span>
                    <span id="coupon_code_<?php echo absint( $new_coupon_id ); ?>"
                          style="display:none;"><?php echo esc_html( $coupon_code) ; ?></span>
                </div>
				<?php
				$copy_button_text = get_option( 'wpcd_copy-button-text' );
				$after_copy_text  = get_option( 'wpcd_after-copy-text' );

				if ( ! empty( $copy_button_text ) ) {
					$button_text = $copy_button_text;
				} else {
					$button_text = __( 'Copy', 'wp-coupons-and-deals' );
				}

				if ( ! empty( $after_copy_text ) ) {
					$after_copy = $after_copy_text;
				} else {
					$after_copy = __( 'Copied', 'wp-coupons-and-deals' );
				}
				?>
                <script type="text/javascript">

                    var clip = new Clipboard('.wpcd_coupon_top_copy_span_<?php echo absint( $new_coupon_id ); ?>');
                    clip.on("success", function () {

                        document.querySelector('.wpcd_coupon_top_copy_span_<?php echo absint( $new_coupon_id ); ?>').innerText = '<?php echo wp_strip_all_tags( $after_copy ); ?>';
                        setTimeout(function () {
                            document.querySelector('.wpcd_coupon_top_copy_span_<?php echo absint( $new_coupon_id ); ?>').innerText = '<?php echo wp_strip_all_tags( $button_text ); ?>';
                        }, 500);

                    });
                </script>
	            <?php if ( $wpcd_enable_goto_button === 'on' ) { ?>
                    <a target="<?php echo esc_attr( $target ); ?>" rel="nofollow" class="wpcd_popup-go-link" href="<?php echo esc_url( $link ); ?>">
			            <?php

			            if ( ! empty( $wpcd_custom_goto ) ) {
				            echo esc_html( $wpcd_custom_goto );
			            } else {
				            echo __( 'Go to Offer', 'wp-coupons-and-deals' );
			            }

			            ?>
                    </a>
	            <?php } ?>
            </div>
        </div>
    </section>


<?php if ( isset( $_GET['wpcd_coupon'] ) && $_GET['wpcd_coupon'] != '' && $_GET['wpcd_coupon'] == $new_coupon_id ) { 
    if( isset( $_GET['wpcd_num_coupon'] ) && ! empty( $_GET['wpcd_num_coupon'] )) {
      $wpcd_num_coupon = (int) $_GET['wpcd_num_coupon'];
    } else {
      $wpcd_num_coupon = '';
    }
?>
    <script type="text/javascript">
        function open_wpcd_popup(id) {
            jQuery("#wpcd_coupon_popup_" + id).fadeIn();
        }

        open_wpcd_popup("<?php echo esc_attr( $new_coupon_id.$wpcd_num_coupon ); ?>");
    </script>

<?php } ?>
