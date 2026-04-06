<?php
function wpcd_get_template_eight( $attributes ){
     $couponType = isset($attributes['couponType']) ? $attributes['couponType'] : 'default';
     $discount = isset($attributes['discount']) ? $attributes['discount'] : '';
     $title = isset($attributes['title']) ? $attributes['title'] : '';
     $description = isset($attributes['description']) ? $attributes['description'] : '';
     $code = isset($attributes['code']) ? $attributes['code'] : '';
     $couponDealLabel = isset($attributes['couponDealLabel']) ? $attributes['couponDealLabel'] : '';
     $expirationDate = isset($attributes['expirationDate']) ? $attributes['expirationDate'] : '';
     $doesNotExpireText = isset($attributes['doesNotExpireText']) ? $attributes['doesNotExpireText'] : '';
     $isDoesNotExpire = isset($attributes['isDoesNotExpire']) ? $attributes['isDoesNotExpire'] : false;
     $dealButtonText = isset($attributes['dealButtonText']) ? $attributes['dealButtonText'] : '';
     $couponCodeBorder = get_border_css($attributes['codeBorder']);
     $expirationDate = !empty($expirationDate) ? (new DateTime($expirationDate))->format('d-m-Y') : '';
     $titleStyles = array(
          'font-size' => is_value_empty($attributes['titleFontSize']) ? '21px' : $attributes['titleFontSize'],
          'color' => empty($attributes['titleColor']) ? '#000000' : $attributes['titleColor'],
     );
     $discountBgColor = get_background_color_var($attributes, 'discountBgColor', 'discountBgGradientColor');
     $discountStyles = array(
          'font-size' => empty($attributes['discountFontSize']) ? '20px' : $attributes['discountFontSize'],
          'color' => empty($attributes['discountColor']) ? '#000000' : $attributes['discountColor'],
          'background-color' => $discountBgColor,
     );

     $dealLabelBgColor = get_background_color_var($attributes, 'couponDealLabelBackgroundColor', 'couponDealLabelGradientBackground');
     $couponDealLabelStyles = array(
          'font-size' => empty($attributes['couponDealLabelFontSize']) ? '12px' : $attributes['couponDealLabelFontSize'],
          'color' => empty($attributes['couponDealLabelColor']) ? '#ffffff' : $attributes['couponDealLabelColor'],
          'background-color' => empty($dealLabelBgColor) ? '#56b151' : $dealLabelBgColor,
     );

     $descriptionStyles = array(
          'font-size' => empty($attributes['descriptionFontSize']) ? '16px' : $attributes['descriptionFontSize'],
          'color' => empty($attributes['descriptionColor']) ? '#000000' : $attributes['descriptionColor'],
     );

     $codeHoverBgColor = get_background_color_var($attributes, 'codeHoverBackgroundColor', 'codeHoverGradientBackground');
     $codeHoverStyles = array(
          '--wpcd-coupon-code-bg-hover-color' => $codeHoverBgColor,
          "--wpcd-coupon-code-hover-color" => isset($attributes['codeHoverColor']) ? $attributes['codeHoverColor'] : '',
     );
     $codeBgColor = get_background_color_var($attributes, 'codeBackgroundColor', 'codeGradientBackground');
     $borderStyle = isset($attributes['hideCoupon']) && $attributes['hideCoupon'] ? '2px solid #56b151' : '2px dashed #ccc';
     $codeStyles = array_merge($codeHoverStyles, array(
          "--wpcd-coupon-code-button-text" => isset($attributes['couponCodeButtonText']) ? '"' . $attributes['couponCodeButtonText'] . '"' : '',
          'font-size' => empty($attributes['codeFontSize']) ? "" : $attributes['codeFontSize'],
          '--wpcd-coupon-code-color' => empty($attributes['codeColor']) ? '' : $attributes['codeColor'],
          '--wpcd-coupon-code-bg-color' => empty($codeBgColor) ? '#fafafa' : $codeBgColor,
          'border-top-left-radius' => empty($attributes['codeBorderRadius']['topLeft']) ? '2px' : $attributes['codeBorderRadius']['topLeft'],
          'border-top-right-radius' => empty($attributes['codeBorderRadius']['topRight']) ? '2px' : $attributes['codeBorderRadius']['topRight'],
          'border-bottom-left-radius' => empty($attributes['codeBorderRadius']['bottomLeft']) ? '2px' : $attributes['codeBorderRadius']['bottomLeft'],
          'border-bottom-right-radius' => empty($attributes['codeBorderRadius']['bottomRight']) ? '2px' : $attributes['codeBorderRadius']['bottomRight'],
          'border-top' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'top')) ? ($couponType === 'deal' ? '2px solid #56b151' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'top'),
          'border-left' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'left')) ? ($couponType === 'deal' ? '2px solid #56b151' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'left'),
          'border-right' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'right')) ? ($couponType === 'deal' ? '2px solid #56b151' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'right'),
          'border-bottom' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'bottom')) ? ($couponType === 'deal' ? '2px solid #56b151' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'bottom'),
     ));

     $dealButtonStyles = array_merge($codeHoverStyles, array(
          "--wpcd-deal-button-text" => isset($attributes['dealButtonText']) ? '"' . $attributes['dealButtonText'] . '"' : '',
          'font-size' => empty($attributes['dealButtonFontSize']) ? "" : $attributes['dealButtonFontSize'],
          '--wpcd-coupon-code-color' => empty($attributes['dealButtonColor']) ? '#ffffff' : $attributes['dealButtonColor'],
          '--wpcd-coupon-code-bg-color' => empty($codeBgColor) ? '#56b151' : $codeBgColor,
          'border-top-left-radius' => empty($attributes['dealButtonBorderRadius']['topLeft']) ? '2px' : $attributes['dealButtonBorderRadius']['topLeft'],
          'border-top-right-radius' => empty($attributes['dealButtonBorderRadius']['topRight']) ? '2px' : $attributes['dealButtonBorderRadius']['topRight'],
          'border-bottom-left-radius' => empty($attributes['dealButtonBorderRadius']['bottomLeft']) ? '2px' : $attributes['dealButtonBorderRadius']['bottomLeft'],
          'border-bottom-right-radius' => empty($attributes['dealButtonBorderRadius']['bottomRight']) ? '2px' : $attributes['dealButtonBorderRadius']['bottomRight'],
          'border-top' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'top')) ? '2px solid #56b151' : get_single_side_border_value($couponCodeBorder, 'top'),
          'border-left' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'left')) ? '2px solid #56b151' : get_single_side_border_value($couponCodeBorder, 'left'),
          'border-right' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'right')) ? '2px solid #56b151' : get_single_side_border_value($couponCodeBorder, 'right'),
          'border-bottom' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'bottom')) ? '2px solid #56b151' : get_single_side_border_value($couponCodeBorder, 'bottom'),
          'margin-top' => '20px',
     ));
     $expirationDateStyles = array(
          '--wpcd-coupon-expiration-date-font-size' => empty($attributes['expirationDateFontSize']) ? '14px' : $attributes['expirationDateFontSize'],
          '--wpcd-coupon-expired-date-font-size' => empty($attributes['expiredDateFontSize']) ? '14px' : $attributes['expiredDateFontSize'],
          '--wpcd-coupon-expiration-date-color' => empty($attributes['expirationDateColor']) ? 'green' : $attributes['expirationDateColor'],
          '--wpcd-coupon-expired-date-color' => empty($attributes['expiredDateColor']) ? 'red' : $attributes['expiredDateColor'],
     );
     $separator_color = empty($attributes['separatorColor']) ? 'none' : '1px dashed ' . $attributes['separatorColor'];
     $separator_styles = array(
          'border' =>  $separator_color,
     );
     $navigationAttrs = array();
     if (!isset($attributes['hideCoupon']) || !$attributes['hideCoupon']) {
          $navigationAttrs = array(
               'rel' => 'nofollow noopener',
               'target' => '_blank',
          );
     }
     ob_start();
     ?>
     <div class="wpcd-coupon-inner__wrapper">
          <div class="wpcd-coupon-discount-wrapper">
               <div class="wpcd-coupon-discount-inner__wrapper">
                    <div class="wpcd-coupon-discount" style="<?php echo esc_attr(generate_css_string($discountStyles)); ?>"><?php echo esc_html($discount); ?></div>
                    <div class="wpcd-coupon-name" style="<?php echo esc_attr(generate_css_string($couponDealLabelStyles)); ?>"><?php echo esc_html($couponDealLabel); ?></div>
                    <div class="wpcd-coupon-expiration-date<?php echo $isDoesNotExpire ? ' wpcd-coupon-does-not-expire' : ''; ?>" style="<?php echo esc_attr(generate_css_string($expirationDateStyles)); ?>">
                         <?php if (!$isDoesNotExpire) : ?>
                              <span><?php esc_html_e('Expire On ', 'wp-coupons-and-deals'); ?></span>
                              <span><?php echo esc_html($expirationDate); ?></span>
                         <?php else : ?>
                              <span><?php echo esc_html($doesNotExpireText); ?></span>
                         <?php endif; ?>
                    </div>
               </div>
          </div>

          <div class="wpcd-coupon-details-wrapper">
               <div class="wpcd-coupon-header" style="<?php echo esc_attr(generate_css_string($separator_styles)); ?>">
                    <div class="wpcd-coupon-title-wrapper">
                         <h3 class="wpcd-coupon-title" style="<?php echo esc_attr(generate_css_string($titleStyles)); ?>"><?php echo esc_html($title); ?></h3>
                    </div>
               </div>
               <div class="wpcd-coupon-content" style="width:100%">
                    <div class="wpcd-coupon-description" style="<?php echo esc_attr(generate_css_string($descriptionStyles)); ?>">
                         <p><?php echo esc_html($description); ?></p>
                    </div>
               </div>
          </div>
          <div class="wpcd-coupon-code">
               <a
                    style="<?php echo esc_attr(generate_css_string($codeStyles)); ?>"
                    <?php foreach ($navigationAttrs as $attr => $value) {
                         echo esc_attr($attr) . '="' . esc_attr($value) . '" ';
                    } ?>
                    href="<?php echo esc_url($attributes['navigationLink']); ?>"
                    class="wpcd-coupon-button<?php echo isset($attributes['hideCoupon']) && $attributes['hideCoupon'] ? ' wpcd-popup-button' : ''; ?>"
                    title="<?php esc_attr_e('Click To Copy Coupon', 'wp-coupons-and-deals'); ?>"
               >
                    <span><?php echo esc_html($code); ?></span>
               </a>
               <a rel="nofollow noopener" target="_blank" href="<?php echo esc_url($attributes['navigationLink']); ?>" class="wpcd-coupon-button" style="<?php echo esc_attr(generate_css_string($dealButtonStyles)); ?>" title="<?php esc_attr_e('Click To Claim This Deal', 'wp-coupons-and-deals'); ?>">
                    <span><?php echo esc_html($dealButtonText); ?></span>
               </a>
          </div>
     </div>
     <?php
     return ob_get_clean();
}