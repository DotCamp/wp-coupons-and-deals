<?php
function wpcd_get_template_one( $attributes ){
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
     $expirationDate = !empty($expirationDate) ? (new DateTime($expirationDate))->format('d/m/Y') : '';

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

     $descriptionStyles = array(
          'font-size' => empty($attributes['descriptionFontSize']) ? '16px' : $attributes['descriptionFontSize'],
          'color' => empty($attributes['descriptionColor']) ? '#000000' : $attributes['descriptionColor'],
     );

     $codeHoverBgColor = get_background_color_var($attributes, 'codeHoverBackgroundColor', 'codeHoverGradientBackground');
     $codeHoverStyles = array(
          '--wpcd-coupon-code-bg-hover-color' => $codeHoverBgColor,
          "--wpcd-coupon-code-hover-color" => isset($attributes['codeHoverColor']) ? $attributes['codeHoverColor'] : '',
     );
     $borderStyle = isset($attributes['hideCoupon']) && $attributes['hideCoupon'] ? '2px solid #56b151' : '2px dashed #ccc';
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
          '--wpcd-coupon-expiration-date-color' => empty($attributes['expirationDateColor']) ? 'green' : $attributes['expirationDateColor'],
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
                    <figure class="wpcd-coupon-one-image">
                         <img src="<?php echo $image_url ?>" />
                    </figure>
                    <div class="wpcd-coupon-content-wrapper">
                         <div class="wpcd-coupon-title-wrapper">
                              <h3 class="wpcd-coupon-title" style="<?php echo esc_attr( generate_css_string( $titleStyles ) ); ?>"><?php echo esc_html( $title ); ?></h3>
                         </div>
                         <div class="wpcd-coupon-description" style="<?php echo esc_attr( generate_css_string( $descriptionStyles ) ); ?>">
                              <p><?php echo esc_html( $description ); ?></p>
                         </div>
                    </div>
               </div>
          </div>
          <div class="wpcd-coupon-column-2">
               <div class="wpcd-coupon-content">
                    <div class="wpcd-coupon-discount-wrapper">
                         <div class="wpcd-coupon-discount-inner__wrapper">
                              <div class="wpcd-coupon-discount" style="<?php echo esc_attr( generate_css_string( $discountStyles ) ); ?>"><?php echo esc_html( $discount ); ?></div>
                         </div>
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
                                   <span class="wpcd-coupon-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                             <g fill="currentColor">
                                                  <path fill-rule="evenodd" d="M8.128 9.155a3.751 3.751 0 1 1 .713-1.321l1.136.656a.75.75 0 0 1 .222 1.104l-.006.007a.75.75 0 0 1-1.032.157a1.421 1.421 0 0 0-.113-.072l-.92-.531Zm-4.827-3.53a2.25 2.25 0 0 1 3.994 2.063a.756.756 0 0 0-.122.23a2.25 2.25 0 0 1-3.872-2.293Zm10.047 2.647a5.073 5.073 0 0 0-3.428 3.57c-.101.387-.158.79-.165 1.202a1.415 1.415 0 0 1-.707 1.201l-.96.554a3.751 3.751 0 1 0 .734 1.309l13.729-7.926a.75.75 0 0 0-.181-1.374l-.803-.215a5.25 5.25 0 0 0-2.894.05l-5.325 1.629Zm-9.223 7.03a2.25 2.25 0 1 0 2.25 3.897a2.25 2.25 0 0 0-2.25-3.897ZM12 12.75a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
                                                  <path d="M16.372 12.615a.75.75 0 0 1 .75 0l5.43 3.135a.75.75 0 0 1-.182 1.374l-.802.215a5.25 5.25 0 0 1-2.894-.051l-5.147-1.574a.75.75 0 0 1-.156-1.367l3-1.732Z"/>
                                             </g>
                                        </svg>
                                   </span>
                                   <span><?php echo esc_html( $code ); ?></span>
                              </a>
                         <?php else : ?>
                              <a rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr( generate_css_string( $codeStyles ) ); ?>" title="<?php esc_attr_e( 'Click To Claim This Deal', 'wp-coupons-and-deals' ); ?>">
                                   <span><?php echo esc_html( $dealButtonText ); ?></span>
                              </a>
                         <?php endif; ?>
                    </div>
                    <div class="wpcd-coupon-expiration-date<?php echo $isDoesNotExpire ? ' wpcd-coupon-does-not-expire' : ''; ?>" style="<?php echo esc_attr( generate_css_string( $expirationDateStyles ) ); ?>">
                         <?php if ( ! $isDoesNotExpire ) : ?>
                              <span><?php esc_html_e( 'Expire On ', 'wp-coupons-and-deals' ); ?></span>
                              <span><?php echo esc_html( $expirationDate ); ?></span>
                         <?php else : ?>
                              <span><?php echo esc_html( $doesNotExpireText ); ?></span>
                         <?php endif; ?>
                    </div>
               </div>
          </div>
     </div>
     <?php
     
     return ob_get_clean();
}