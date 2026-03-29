<?
function wpcd_get_hidden_coupon_template( $attributes ) {
     $title = isset($attributes['title']) ? $attributes['title'] : '';
     $description = isset($attributes['description']) ? $attributes['description'] : '';
     $code = isset($attributes['code']) ? $attributes['code'] : '';
     $couponPopupCopyButtonText = isset($attributes['couponPopupCopyButtonText']) ? $attributes['couponPopupCopyButtonText'] : '';
     $navigationLink = isset($attributes['navigationLink']) ? $attributes['navigationLink'] : false;
     $couponPopupOfferText = isset($attributes['couponPopupOfferText']) ? $attributes['couponPopupOfferText'] : '';
     $fieldBgColor = isset($attributes['couponPopupCodeFieldBackgroundColor']) ? $attributes['couponPopupCodeFieldBackgroundColor'] : '';
     $couponPopupFieldBorder = get_border_css($attributes['couponPopupCodeFieldBorder']);
     $copyButtonBgColor = get_background_color_var(
          $attributes,
          'couponPopupCopyButtonBgColor',
          'couponPopupCopyButtonBgGradient'
     );
     $couponPopupCopyButtonStyles = array(
          'background-color' => is_value_empty($copyButtonBgColor) ? '#56b151' : $copyButtonBgColor,
          'color' => is_value_empty(isset($attributes['couponPopupCopyButtonColor']) ? $attributes['couponPopupCopyButtonColor'] : '') ? '#ffffff' : $attributes['couponPopupCopyButtonColor'],
     );
     $couponPopupCodeFieldStyles = array(
          'background-color' => empty($fieldBgColor) ? '#beffb9' : $fieldBgColor,
          'color' => isset($attributes['couponPopupCodeFieldColor']) ? $attributes['couponPopupCodeFieldColor'] : '',
          'border-top' => is_value_empty(get_single_side_border_value($couponPopupFieldBorder, 'top')) ? '2px dashed #56b151' : get_single_side_border_value($couponPopupFieldBorder, 'top'),
          'border-left' => is_value_empty(get_single_side_border_value($couponPopupFieldBorder, 'left')) ? '2px dashed #56b151' : get_single_side_border_value($couponPopupFieldBorder, 'left'),
          'border-right' => is_value_empty(get_single_side_border_value($couponPopupFieldBorder, 'right')) ? '2px dashed #56b151' : get_single_side_border_value($couponPopupFieldBorder, 'right'),
          'border-bottom' => is_value_empty(get_single_side_border_value($couponPopupFieldBorder, 'bottom')) ? '2px dashed #56b151' : get_single_side_border_value($couponPopupFieldBorder, 'bottom'),
     );
     $offerButtonBgColor = get_background_color_var(
          $attributes,
          'couponPopupOfferButtonBgColor',
          'couponPopupOfferButtonBgGradient'
     );
     $couponPopupOfferButtonStyles = array(
          'background-color' => is_value_empty($offerButtonBgColor) ? '#56b151' : $offerButtonBgColor,
          'color' => !is_value_empty(isset($attributes['couponPopupOfferButtonColor']) ? $attributes['couponPopupOfferButtonColor'] : '') ? $attributes['couponPopupOfferButtonColor'] : '#ffffff',
     );
     ob_start();
     ?>
     <div id="<?php echo esc_attr($attributes['couponId']); ?>" class="wpcd-coupon-popup">
          <div class="wpcd-coupon-popup-inner_wrapper">
               <div class="wpcd-coupon-popup-header">
                    <p class="wpcd-coupon-popup-title"><?php echo esc_html($title); ?></p>
                    <span class="wpcd-coupon-popup-close-button">×</span>
               </div>
               <div class="wpcd-coupon-popup-content">
                    <p class="wpcd-coupon-popup-description"><?php echo esc_html($description); ?></p>
                    <div class="wpcd-coupon-popup-code-wrapper" style="<?php echo esc_attr(generate_css_string($couponPopupCodeFieldStyles)); ?>">
                         <span class="wpcd-coupon-popup-code"><?php echo esc_html($code); ?></span>
                         <span class="wpcd-coupon-button" style="<?php echo esc_attr(generate_css_string($couponPopupCopyButtonStyles)); ?>">
                              <?php echo esc_html($couponPopupCopyButtonText); ?>
                         </span>
                    </div>
                    <a href="<?php echo esc_url($navigationLink); ?>" rel="nofollow noopener" target="_blank" class="wpcd-coupon-go-to-offer" style="<?php echo esc_attr(generate_css_string($couponPopupOfferButtonStyles)); ?>">
                         <?php echo esc_html($couponPopupOfferText); ?>
                    </a>
               </div>
          </div>
     </div>
     <?php
     return ob_get_clean();
}