<?php
function wpcd_get_template_five( $attributes ){
     $couponType = isset($attributes['couponType']) ? $attributes['couponType'] : 'default';
     $discount = isset($attributes['discount']) ? $attributes['discount'] : '';
     $title = isset($attributes['title']) ? $attributes['title'] : '';
     $description = isset($attributes['description']) ? $attributes['description'] : '';
     $code = isset($attributes['code']) ? $attributes['code'] : '';
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
          'font-size' => empty($attributes['discountFontSize']) ? '30px' : $attributes['discountFontSize'],
          'color' => empty($attributes['discountColor']) ? '#000000' : $attributes['discountColor'],
          'background-color' => $discountBgColor,
          'border' => '2px dashed #000000',
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
     $borderStyle = "2px dashed #18e06e";
     $codeStyles = array_merge($codeHoverStyles, array(
          "--wpcd-coupon-code-button-text" => isset($attributes['couponCodeButtonText']) ? '"' . $attributes['couponCodeButtonText'] . '"' : '',
          'font-size' => empty($attributes['codeFontSize']) ? "" : $attributes['codeFontSize'],
          '--wpcd-coupon-code-color' => empty($attributes['codeColor']) ? '' : $attributes['codeColor'],
          '--wpcd-coupon-code-bg-color' => get_background_color_var($attributes, 'codeBackgroundColor', 'codeGradientBackground'),
          'border-top-left-radius' => empty($attributes['codeBorderRadius']['topLeft']) ? '2px' : $attributes['codeBorderRadius']['topLeft'],
          'border-top-right-radius' => empty($attributes['codeBorderRadius']['topRight']) ? '2px' : $attributes['codeBorderRadius']['topRight'],
          'border-bottom-left-radius' => empty($attributes['codeBorderRadius']['bottomLeft']) ? '2px' : $attributes['codeBorderRadius']['bottomLeft'],
          'border-bottom-right-radius' => empty($attributes['codeBorderRadius']['bottomRight']) ? '2px' : $attributes['codeBorderRadius']['bottomRight'],
          'border-top' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'top')) ? ($couponType === 'deal' ? '2px solid #56b151' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'top'),
          'border-left' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'left')) ? ($couponType === 'deal' ? '2px solid #56b151' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'left'),
          'border-right' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'right')) ? ($couponType === 'deal' ? '2px solid #56b151' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'right'),
          'border-bottom' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'bottom')) ? ($couponType === 'deal' ? '2px solid #56b151' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'bottom'),
     ));
     $expirationDateStyles = array(
          '--wpcd-coupon-expiration-date-font-size' => empty($attributes['expirationDateFontSize']) ? '14px' : $attributes['expirationDateFontSize'],
          '--wpcd-coupon-expired-date-font-size' => empty($attributes['expiredDateFontSize']) ? '14px' : $attributes['expiredDateFontSize'],
          '--wpcd-coupon-expiration-date-color' => empty($attributes['expirationDateColor']) ? '#ffffff' : $attributes['expirationDateColor'],
          '--wpcd-coupon-expired-date-color' => empty($attributes['expiredDateColor']) ? 'red' : $attributes['expiredDateColor'],
     );
     $coupon_default_image =  WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';
     $image_url = !empty( $attributes['couponImage']['url'] ) ? $attributes['couponImage']['url'] : $coupon_default_image;

     $navigationAttrs = array();
     if (!isset($attributes['hideCoupon']) || !$attributes['hideCoupon']) {
          $navigationAttrs = array(
               'rel' => 'nofollow noopener',
               'target' => '_blank',
          );
     }
     ob_start();
     ?>
     <div class="wpcd-coupon-inner__wrapper wpcd-coupon-columns">
          <div class="wpcd-coupon-details-wrapper wpcd-coupon-column-1">
               <div class="wpcd-coupon-header">
                    <div class="wpcd-coupon-discount-wrapper">
                         <div class="wpcd-coupon-discount-inner__wrapper">
                              <div class="wpcd-coupon-discount" style="<?php echo esc_attr( generate_css_string( $discountStyles ) ); ?>"><?php echo esc_html( $discount ); ?></div>
                         </div>
                    </div>
                    <div class="wpcd-coupon-content-wrapper">
                         <div class="wpcd-coupon-title-wrapper">
                              <h3 class="wpcd-coupon-title" style="<?php echo esc_attr( generate_css_string( $titleStyles ) ); ?>"><?php echo esc_html( $title ); ?></h3>
                              <div class="wpcd-coupon-description" style="<?php echo esc_attr( generate_css_string( $descriptionStyles ) ); ?>">
                                   <p><?php echo esc_html( $description ); ?></p>
                              </div>
                         </div>
                    </div>
                    <div class="wpcd-coupon-image-wrapper">
                         <figure class="wpcd-coupon-two-image">
                              <img src="<?php echo $image_url ?>" />
                         </figure>
                    </div>
               </div>
               <div class="wpcd-coupon-footer">
                    <div class="wpcd-coupon-expiration-date<?php echo $isDoesNotExpire ? ' wpcd-coupon-does-not-expire' : ''; ?>" style="<?php echo esc_attr( generate_css_string( $expirationDateStyles ) ); ?>">
                         <?php if ( ! $isDoesNotExpire ) : ?>
                              <span><?php esc_html_e( 'Expire On: ', 'wp-coupons-and-deals' ); ?></span>
                              <span><?php echo esc_html( $expirationDate ); ?></span>
                         <?php else : ?>
                              <span><?php echo esc_html( $doesNotExpireText ); ?></span>
                         <?php endif; ?>
                    </div>
                    <div class="wpcd-coupon-code">
                         <?php if ( $couponType !== 'deal' ) : ?>
                              <a
                                   style="<?php echo esc_attr( generate_css_string( $codeStyles ) ); ?>"
                                   <?php foreach ( $navigationAttrs as $attr => $value ) {
                                        echo esc_attr( $attr ) . '="' . esc_attr( $value ) . '" ';
                                   } ?>
                                   href="<?php echo esc_url( $attributes['navigationLink'] ); ?>"
                                   class="wpcd-coupon-button<?php echo isset( $attributes['hideCoupon'] ) && $attributes['hideCoupon'] ? ' wpcd-popup-button' : ''; ?>"
                                   title="<?php esc_attr_e( 'Click To Copy Coupon', 'wp-coupons-and-deals' ); ?>"
                              >
                                   <span><?php echo esc_html( $code ); ?></span>
                              </a>
                         <?php else : ?>
                              <a rel="nofollow noopener" target="_blank" href="<?php echo esc_url( $attributes['navigationLink'] ); ?>" class="wpcd-coupon-button" style="<?php echo esc_attr( generate_css_string( $codeStyles ) ); ?>" title="<?php esc_attr_e( 'Click To Claim This Deal', 'wp-coupons-and-deals' ); ?>">
                                   <span><?php echo esc_html( $dealButtonText ); ?></span>
                              </a>
                         <?php endif; ?>
                    </div>
               </div>
          </div>
     </div>
     <?php
     
     return ob_get_clean();
}