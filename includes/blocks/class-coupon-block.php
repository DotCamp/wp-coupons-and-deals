<?php


/**
 * Coupon block.
 */
class Coupon_Block {
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->register_logic();
	}
	
	/**
	 * Renders the custom button block on the server.
	 *
	 * @param array    $attributes The block attributes.
	 * @param string   $content    The block content.
	 * @param WP_Block $block      The block object.
	 * @return string  Returns the HTML content for the custom button block.
	 */
	public function render_coupon_block( $attributes, $_, $block ) {
		$template = isset($attributes['template']) ? $attributes['template'] : 'default';
		$classes = array(
			'wpcd-coupon-wrapper',
			'wpcd-coupon-' . (isset($attributes['template']) ? $attributes['template'] : 'template-default') . '',
		);
		$classes[] = 'wp-block-wpcd-coupon';
		if(!empty( isset($attributes['padding']) ? $attributes['padding'] : array() ))
		{
			$classes[] = 'has-padding';
		}
		if (!empty( isset($attributes['margin']) ? $attributes['margin'] : array() )) {
			$classes[] = 'has-margin';
		}
		if (isset($attributes['hideCoupon']) && $attributes['hideCoupon'] && $attributes['couponType'] !== 'deal') {
			$classes[] = 'wpcd-coupon-hidden';
		}
		if (isset($attributes['couponType']) && $attributes['couponType'] === 'deal') {
			$classes[] = 'wpcd-coupon-type-deal';
		}
		$wrapperBorder = get_border_css($attributes['wrapperBorder']);

		$paddingObj = get_spacing_css($attributes['padding']);
		$marginObj = get_spacing_css($attributes['margin']);
		$default_border = array(
			'template-default' => '2px dashed #000000',
			'template-one' => '1px solid #d1d1d1',
			'template-two' => '1px solid #d1d1d1',
			'template-three' => '1px solid #d1d1d1',
			'template-four' => '1px solid #d1d1d1',
			'template-five' => '2px solid #18e06e',
			'template-six' => '2px solid #18e06e',
			'template-seven' => '2px solid #9b59b6',
			'template-eight' => '1px solid #d1d1d1',
			'template-nine' => '2px dashed #000000',
		);
		$wrapper_gradient_color = isset($attributes['wrapperGradientBackground']) ? $attributes['wrapperGradientBackground'] : '';
		$default_padding = isset($attributes['template']) && $attributes['template'] === 'template-three' || $attributes['template'] === 'template-four' ? '0': '25px';
		$wrapperStyles = array(
			'background-color' => isset($attributes['wrapperBackgroundColor']) ? $attributes['wrapperBackgroundColor'] : $wrapper_gradient_color,
			'padding-top' => !empty($paddingObj) && isset($paddingObj['top']) ? $paddingObj['top'] : $default_padding,
			'padding-right' => !empty($paddingObj) && isset($paddingObj['right']) ? $paddingObj['right'] : $default_padding,
			'padding-bottom' => !empty($paddingObj) && isset($paddingObj['bottom']) ? $paddingObj['bottom'] : $default_padding,
			'padding-left' => !empty($paddingObj) && isset($paddingObj['left']) ? $paddingObj['left'] : $default_padding,
			'margin-top' => !empty($marginObj) && isset($marginObj['top']) ? $marginObj['top'] : "",
			'margin-right' => !empty($marginObj) && isset($marginObj['right']) ? $marginObj['right'] : "",
			'margin-bottom' => !empty($marginObj) && isset($marginObj['bottom']) ? $marginObj['bottom'] : "",
			'margin-left' => !empty($marginObj) && isset($marginObj['left']) ? $marginObj['left'] : "",
			'border-top-left-radius' => !empty($attributes['wrapperBorderRadius']) && isset($attributes['wrapperBorderRadius']['topLeft']) ? $attributes['wrapperBorderRadius']['topLeft'] : "",
			'border-top-right-radius' => !empty($attributes['wrapperBorderRadius']) && isset($attributes['wrapperBorderRadius']['topRight']) ? $attributes['wrapperBorderRadius']['topRight'] : "",
			'border-bottom-left-radius' => !empty($attributes['wrapperBorderRadius']) && isset($attributes['wrapperBorderRadius']['bottomLeft']) ? $attributes['wrapperBorderRadius']['bottomLeft'] : "",
			'border-bottom-right-radius' => !empty($attributes['wrapperBorderRadius']) && isset($attributes['wrapperBorderRadius']['bottomRight']) ? $attributes['wrapperBorderRadius']['bottomRight'] : "",
			'border-top' => !is_value_empty(get_single_side_border_value($wrapperBorder, 'top')) ? get_single_side_border_value($wrapperBorder, 'top') : $default_border[$attributes['template']],
			'border-left' => !is_value_empty(get_single_side_border_value($wrapperBorder, 'left')) ? get_single_side_border_value($wrapperBorder, 'left') : $default_border[$attributes['template']],
			'border-right' => !is_value_empty(get_single_side_border_value($wrapperBorder, 'right')) ? get_single_side_border_value($wrapperBorder, 'right') : $default_border[$attributes['template']],
			'border-bottom' => !is_value_empty(get_single_side_border_value($wrapperBorder, 'bottom')) ? get_single_side_border_value($wrapperBorder, 'bottom') : $default_border[$attributes['template']],
		);
		$separator_color = empty($attributes['separatorColor']) ? '#cccccc' : $attributes['separatorColor'];
		$separator_styles = array(
			'--wpcd-coupon-separator-color' =>  $separator_color,
		);
		if($template === 'template-one'){
			$wrapperStyles = array_merge($wrapperStyles, $separator_styles);
		}
		$block_attributes = get_block_wrapper_attributes(
			array('class' => join(' ', $classes),
			'style' => generate_css_string($wrapperStyles),
			'data-expired_date_text' => isset($attributes['expiredDateText']) ? $attributes['expiredDateText'] : '',
			'data-expiration_date' => isset($attributes['expirationDate']) ? $attributes['expirationDate'] : '',
			'data-coupon_code' => isset($attributes['code']) ? $attributes['code'] : '',
			'data-coupon_id' => isset($attributes['couponId']) ? $attributes['couponId'] : '',
			)
		);
		$templates = array(
			'default' => $this->generate_coupon_html($attributes),
			'template-one' => $this->generate_template_one_html($attributes),
			'template-two' => $this->generate_template_two_html($attributes),
			'template-three' => $this->generate_template_three_html($attributes),
			'template-four' => $this->generate_template_four_html($attributes),
			'template-five' => $this->generate_template_five_html($attributes),
			'template-six' => $this->generate_template_six_html($attributes),
			'template-seven' => $this->generate_template_seven_html($attributes),
			'template-eight' => $this->generate_template_eight_html($attributes),
			'template-nine' => $this->generate_template_nine_html($attributes),
		);

		if (wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code()) {
			$block_html = isset($templates[$template]) ? $templates[$template] : $templates['default'];
		} else {
			$block_html = $templates['default'];
		}

		return sprintf( 
			'<div %1$s>
				%2$s
				%3$s
			</div>', 
			$block_attributes, 
			$block_html,
			isset($attributes['hideCoupon']) && $attributes['hideCoupon'] ? $this->generate_hidden_coupon_html( $attributes ) : ''
		);
	}
	/**
	 * Generates the HTML for the coupon block based on the coupon type.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_coupon_html( $attributes ) {
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
		$separator_color = empty($attributes['separatorColor']) ? '#d1d1d1' : $attributes['separatorColor'];
		$separator_styles = array(
			'border-bottom' => '1px dashed ' . $separator_color,
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
				</div>
			</div>

			<div class="wpcd-coupon-details-wrapper">
				<div class="wpcd-coupon-header" style="<?php echo esc_attr(generate_css_string($separator_styles)); ?>">
					<div class="wpcd-coupon-title-wrapper">
						<h3 class="wpcd-coupon-title" style="<?php echo esc_attr(generate_css_string($titleStyles)); ?>"><?php echo esc_html($title); ?></h3>
					</div>
					<div class="wpcd-coupon-code">
						<?php if ($couponType !== 'deal') : ?>
							<a
								style="<?php echo esc_attr(generate_css_string($codeStyles)); ?>"
								<?php foreach ($navigationAttrs as $attr => $value) {
									echo esc_attr($attr) . '="' . esc_attr($value) . '" ';
								} ?>
								href="<?php echo esc_url($attributes['navigationLink']); ?>"
								class="wpcd-coupon-button<?php echo isset($attributes['hideCoupon']) && $attributes['hideCoupon'] ? ' wpcd-popup-button' : ''; ?>"
								title="<?php esc_attr_e('Click To Copy Coupon', 'wp-coupons-and-deals'); ?>"
							>
								<span class="wpcd-coupon-icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
										<g fill="currentColor">
											<path fill-rule="evenodd" d="M8.128 9.155a3.751 3.751 0 1 1 .713-1.321l1.136.656a.75.75 0 0 1 .222 1.104l-.006.007a.75.75 0 0 1-1.032.157a1.421 1.421 0 0 0-.113-.072l-.92-.531Zm-4.827-3.53a2.25 2.25 0 0 1 3.994 2.063a.756.756 0 0 0-.122.23a2.25 2.25 0 0 1-3.872-2.293Zm10.047 2.647a5.073 5.073 0 0 0-3.428 3.57c-.101.387-.158.79-.165 1.202a1.415 1.415 0 0 1-.707 1.201l-.96.554a3.751 3.751 0 1 0 .734 1.309l13.729-7.926a.75.75 0 0 0-.181-1.374l-.803-.215a5.25 5.25 0 0 0-2.894.05l-5.325 1.629Zm-9.223 7.03a2.25 2.25 0 1 0 2.25 3.897a2.25 2.25 0 0 0-2.25-3.897ZM12 12.75a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
											<path d="M16.372 12.615a.75.75 0 0 1 .75 0l5.43 3.135a.75.75 0 0 1-.182 1.374l-.802.215a5.25 5.25 0 0 1-2.894-.051l-5.147-1.574a.75.75 0 0 1-.156-1.367l3-1.732Z"/>
										</g>
									</svg>
								</span>
								<span><?php echo esc_html($code); ?></span>
							</a>
						<?php else : ?>
							<a rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr(generate_css_string($codeStyles)); ?>" title="<?php esc_attr_e('Click To Claim This Deal', 'wp-coupons-and-deals'); ?>">
								<span><?php echo esc_html($dealButtonText); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
				<div class="wpcd-coupon-content" style="width:100%">
					<div class="wpcd-coupon-description" style="<?php echo esc_attr(generate_css_string($descriptionStyles)); ?>">
						<p><?php echo esc_html($description); ?></p>
					</div>
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
		</div>
		<?php
		return ob_get_clean();
	}
	/**
	 * Generates the HTML for the hidden coupon block.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_hidden_coupon_html( $attributes ) {
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
	/**
	 * Generates the HTML for template one based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_one_html( $attributes ) {
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
		$coupon_default_image = 'http://wp-coupon-and-deals.local/wp-content/plugins/wp-coupons-and-deals/assets/img/coupon-200x200.png';
		$image_url = isset( $attributes['couponImage']['url'] ) ? $attributes['couponImage']['url'] : $coupon_default_image;
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
	/**
	 * Generates the HTML for template two based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_two_html( $attributes ) {
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
		$separator_color = empty($attributes['separatorColor']) ? '#cccccc' : $attributes['separatorColor'];
		$separator_styles = array(
			'border-top' => '1px solid ' . $separator_color,
			'border-bottom' => '1px solid ' . $separator_color,
		);
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
		$coupon_default_image = 'http://wp-coupon-and-deals.local/wp-content/plugins/wp-coupons-and-deals/assets/img/coupon-200x200.png';
		$image_url = isset( $attributes['couponImage']['url'] ) ? $attributes['couponImage']['url'] : $coupon_default_image;

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
					<div class="wpcd-coupon-image-wrapper">
						<figure class="wpcd-coupon-two-image">
							<img src="<?php echo $image_url ?>" />
						</figure>
							<div class="wpcd-coupon-discount-wrapper">
						<div class="wpcd-coupon-discount-inner__wrapper">
							<div class="wpcd-coupon-discount" style="<?php echo esc_attr( generate_css_string( $discountStyles ) ); ?>"><?php echo esc_html( $discount ); ?></div>
						</div>
					</div>
					</div>
					<div class="wpcd-coupon-content-wrapper">
						<div class="wpcd-coupon-title-wrapper">
							<h3 class="wpcd-coupon-title" style="<?php echo esc_attr( generate_css_string( $titleStyles ) ); ?>"><?php echo esc_html( $title ); ?></h3>
						</div>
						<div class="wpcd-coupon-content" style="<?php echo esc_attr( generate_css_string( $separator_styles ) ); ?>">
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
						</div>
						<div class="wpcd-coupon-description" style="<?php echo esc_attr( generate_css_string( $descriptionStyles ) ); ?>">
							<p><?php echo esc_html( $description ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		
		return ob_get_clean();
	}
	/**
	 * Generates the HTML for template three based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_three_html( $attributes ) {
		$couponType = isset($attributes['couponType']) ? $attributes['couponType'] : 'default';
		$title = isset($attributes['title']) ? $attributes['title'] : '';
		$description = isset($attributes['description']) ? $attributes['description'] : '';
		$code = isset($attributes['code']) ? $attributes['code'] : '';
		$expirationDate = isset($attributes['expirationDate']) ? $attributes['expirationDate'] : '';
		$doesNotExpireText = isset($attributes['doesNotExpireText']) ? $attributes['doesNotExpireText'] : '';
		$isDoesNotExpire = isset($attributes['isDoesNotExpire']) ? $attributes['isDoesNotExpire'] : false;
		$dealButtonText = isset($attributes['dealButtonText']) ? $attributes['dealButtonText'] : '';
		$couponCodeBorder = get_border_css($attributes['codeBorder']);
		$separator_color = empty($attributes['separatorColor']) ? '#cccccc' : $attributes['separatorColor'];
		$separator_styles = array(
			'border-top' => '1px dashed ' . $separator_color,
		);
		$expirationDate = !empty($expirationDate) ? (new DateTime($expirationDate))->format('d/m/Y') : '';

		$titleStyles = array(
			'font-size' => is_value_empty($attributes['titleFontSize']) ? '21px' : $attributes['titleFontSize'],
			'color' => empty($attributes['titleColor']) ? '#000000' : $attributes['titleColor'],
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
				<div class="wpcd-coupon-content-wrapper">
					<div class="wpcd-coupon-content-title-wrapper">
						<div class="wpcd-coupon-title-wrapper">
							<h3 class="wpcd-coupon-title" style="<?php echo esc_attr( generate_css_string( $titleStyles ) ); ?>"><?php echo esc_html( $title ); ?></h3>
						</div>
						<div class="wpcd-coupon-description" style="<?php echo esc_attr( generate_css_string( $descriptionStyles ) ); ?>">
							<p><?php echo esc_html( $description ); ?></p>
						</div>
					</div>
					<div class="wpcd-coupon-content" style="<?php echo esc_attr( generate_css_string( $separator_styles ) ); ?>">
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
					</div>
				</div>
			</div>
		</div>
		<?php
		
		return ob_get_clean();
	}
	/**
	 * Generates the HTML for template three based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_four_html( $attributes ) {
		$couponType = isset($attributes['couponType']) ? $attributes['couponType'] : 'default';
		$title = isset($attributes['title']) ? $attributes['title'] : '';
		$description = isset($attributes['description']) ? $attributes['description'] : '';
		$code = isset($attributes['code']) ? $attributes['code'] : '';
		$expirationDate = isset($attributes['expirationDate']) ? $attributes['expirationDate'] : '';
		$secondCode = isset($attributes['secondCode']) ? $attributes['secondCode'] : '';
		$secondExpirationDate = isset($attributes['secondExpirationDate']) ? $attributes['secondExpirationDate'] : '';
		$thirdCode = isset($attributes['thirdCode']) ? $attributes['thirdCode'] : '';
		$thirdExpirationDate = isset($attributes['thirdExpirationDate']) ? $attributes['thirdExpirationDate'] : '';
		$doesNotExpireText = isset($attributes['doesNotExpireText']) ? $attributes['doesNotExpireText'] : '';
		$isDoesNotExpire = isset($attributes['isDoesNotExpire']) ? $attributes['isDoesNotExpire'] : false;
		$dealButtonText = isset($attributes['dealButtonText']) ? $attributes['dealButtonText'] : '';
		$secondDealButtonText = isset($attributes['secondDealButtonText']) ? $attributes['secondDealButtonText'] : '';
		$thirdDealButtonText = isset($attributes['thirdDealButtonText']) ? $attributes['thirdDealButtonText'] : '';
		$discount = isset($attributes['discount']) ? $attributes['discount'] : '';
		$secondDiscount = isset($attributes['secondDiscount']) ? $attributes['secondDiscount'] : '';
		$thirdDiscount = isset($attributes['thirdDiscount']) ? $attributes['thirdDiscount'] : '';

		$couponCodeBorder = get_border_css($attributes['codeBorder']);
		$separator_color = empty($attributes['separatorColor']) ? '#cccccc' : $attributes['separatorColor'];
		$separator_styles = array(
			'border-top' => '1px dashed ' . $separator_color,
		);
		$discountBgColor = get_background_color_var($attributes, 'discountBgColor', 'discountBgGradientColor');
		$discountStyles = array(
			'font-size' => empty($attributes['discountFontSize']) ? '20px' : $attributes['discountFontSize'],
			'color' => empty($attributes['discountColor']) ? '#000000' : $attributes['discountColor'],
			'background-color' => $discountBgColor,
		);
		$expirationDate = !empty($expirationDate) ? (new DateTime($expirationDate))->format('d-m-Y') : '';
		$secondExpirationDate = !empty($secondExpirationDate) ? (new DateTime($secondExpirationDate))->format('d-m-Y') : '';
		$thirdExpirationDate = !empty($thirdExpirationDate) ? (new DateTime($thirdExpirationDate))->format('d-m-Y') : '';

		$titleStyles = array(
			'font-size' => is_value_empty($attributes['titleFontSize']) ? '21px' : $attributes['titleFontSize'],
			'color' => empty($attributes['titleColor']) ? '#000000' : $attributes['titleColor'],
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
				<div class="wpcd-coupon-content-wrapper">
					<div class="wpcd-coupon-content-title-wrapper">
						<div class="wpcd-coupon-title-wrapper">
							<h3 class="wpcd-coupon-title" style="<?php echo esc_attr( generate_css_string( $titleStyles ) ); ?>"><?php echo esc_html( $title ); ?></h3>
						</div>
						<div class="wpcd-coupon-description" style="<?php echo esc_attr( generate_css_string( $descriptionStyles ) ); ?>">
							<p><?php echo esc_html( $description ); ?></p>
						</div>
					</div>
					<div class="wpcd-coupon-content" style="<?php echo esc_attr( generate_css_string( $separator_styles ) ); ?>">
						<div class="wpcd-coupon-content-inner-wrapper">
							<div class="wpcd-coupon-discount-wrapper">
								<div class="wpcd-coupon-discount-inner__wrapper">
									<div class="wpcd-coupon-discount" style="<?php echo esc_attr(generate_css_string($discountStyles)); ?>"><?php echo esc_html($discount); ?></div>
								</div>
							</div>
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
						</div>
						<div class="wpcd-coupon-content-inner-wrapper">
							<div class="wpcd-coupon-discount-wrapper">
								<div class="wpcd-coupon-discount-inner__wrapper">
									<div class="wpcd-coupon-discount" style="<?php echo esc_attr(generate_css_string($discountStyles)); ?>"><?php echo esc_html($secondDiscount); ?></div>
								</div>
							</div>
							<div class="wpcd-coupon-expiration-date<?php echo $isDoesNotExpire ? ' wpcd-coupon-does-not-expire' : ''; ?>" style="<?php echo esc_attr( generate_css_string( $expirationDateStyles ) ); ?>">
								<?php if ( ! $isDoesNotExpire ) : ?>
									<span><?php esc_html_e( 'Expire On: ', 'wp-coupons-and-deals' ); ?></span>
									<span><?php echo esc_html( $secondExpirationDate ); ?></span>
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
										href="<?php echo esc_url( $attributes['secondNavigationLink'] ); ?>"
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
										<span><?php echo esc_html( $secondCode ); ?></span>
									</a>
								<?php else : ?>
									<a rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr( generate_css_string( $codeStyles ) ); ?>" title="<?php esc_attr_e( 'Click To Claim This Deal', 'wp-coupons-and-deals' ); ?>">
										<span><?php echo esc_html( $secondDealButtonText ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						</div>
						<div class="wpcd-coupon-content-inner-wrapper">
							<div class="wpcd-coupon-discount-wrapper">
								<div class="wpcd-coupon-discount-inner__wrapper">
									<div class="wpcd-coupon-discount" style="<?php echo esc_attr(generate_css_string($discountStyles)); ?>"><?php echo esc_html($thirdDiscount); ?></div>
								</div>
							</div>
							<div class="wpcd-coupon-expiration-date<?php echo $isDoesNotExpire ? ' wpcd-coupon-does-not-expire' : ''; ?>" style="<?php echo esc_attr( generate_css_string( $expirationDateStyles ) ); ?>">
								<?php if ( ! $isDoesNotExpire ) : ?>
									<span><?php esc_html_e( 'Expire On: ', 'wp-coupons-and-deals' ); ?></span>
									<span><?php echo esc_html( $thirdExpirationDate ); ?></span>
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
										href="<?php echo esc_url( $attributes['thirdNavigationLink'] ); ?>"
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
										<span><?php echo esc_html( $thirdCode ); ?></span>
									</a>
								<?php else : ?>
									<a rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr( generate_css_string( $codeStyles ) ); ?>" title="<?php esc_attr_e( 'Click To Claim This Deal', 'wp-coupons-and-deals' ); ?>">
										<span><?php echo esc_html( $thirdDealButtonText ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		
		return ob_get_clean();
	}
	/**
	 * Generates the HTML for template six based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_five_html( $attributes ) {
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
		$coupon_default_image = 'http://wp-coupon-and-deals.local/wp-content/plugins/wp-coupons-and-deals/assets/img/coupon-200x200.png';
		$image_url = isset( $attributes['couponImage']['url'] ) ? $attributes['couponImage']['url'] : $coupon_default_image;

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
							<a rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr( generate_css_string( $codeStyles ) ); ?>" title="<?php esc_attr_e( 'Click To Claim This Deal', 'wp-coupons-and-deals' ); ?>">
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
	/**
	 * Generates the HTML for template six based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_six_html( $attributes ) {
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
		$separator_color = empty($attributes['separatorColor']) ? '#18e06e' : $attributes['separatorColor'];
		$separator_styles = array(
			'border-top' => '1px dashed ' . $separator_color,
			'border-bottom' => '1px dashed ' . $separator_color,
		);
		$expirationDate = !empty($expirationDate) ? (new DateTime($expirationDate))->format('d/m/Y') : '';

		$titleStyles = array(
			'font-size' => is_value_empty($attributes['titleFontSize']) ? '21px' : $attributes['titleFontSize'],
			'color' => empty($attributes['titleColor']) ? '#000000' : $attributes['titleColor'],
		);

		$discountBgColor = get_background_color_var($attributes, 'discountBgColor', 'discountBgGradientColor');
		$discountStyles = array(
			'font-size' => empty($attributes['discountFontSize']) ? '30px' : $attributes['discountFontSize'],
			'color' => empty($attributes['discountColor']) ? '#ffffff' : $attributes['discountColor'],
			'--wpcd-discount-background-color' => $discountBgColor,
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
		$borderStyle = "2px solid #18e06e";
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
		$coupon_default_image = 'http://wp-coupon-and-deals.local/wp-content/plugins/wp-coupons-and-deals/assets/img/coupon-200x200.png';
		$image_url = isset( $attributes['couponImage']['url'] ) ? $attributes['couponImage']['url'] : $coupon_default_image;

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
						<div class="wpcd-coupon-content" style="<?php echo esc_attr( generate_css_string( $separator_styles ) ); ?>">
							<div class="wpcd-coupon-expiration-date<?php echo $isDoesNotExpire ? ' wpcd-coupon-does-not-expire' : ''; ?>" style="<?php echo esc_attr( generate_css_string( $expirationDateStyles ) ); ?>">
								<?php if ( ! $isDoesNotExpire ) : ?>
									<span><?php esc_html_e( 'Expire On: ', 'wp-coupons-and-deals' ); ?></span>
									<span><?php echo esc_html( $expirationDate ); ?></span>
								<?php else : ?>
									<span><?php echo esc_html( $doesNotExpireText ); ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="wpcd-coupon-image-wrapper">
						<figure class="wpcd-coupon-two-image">
							<img src="<?php echo $image_url ?>" />
						</figure>
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
								<a rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr( generate_css_string( $codeStyles ) ); ?>" title="<?php esc_attr_e( 'Click To Claim This Deal', 'wp-coupons-and-deals' ); ?>">
									<span><?php echo esc_html( $dealButtonText ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		
		return ob_get_clean();
	}
	/**
	 * Generates the HTML for template two based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_seven_html( $attributes ) {
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
		$separator_color = empty($attributes['separatorColor']) ? '#000000' : $attributes['separatorColor'];
		$separator_styles = array(
			'border-top' => '1px dashed ' . $separator_color,
			'border-bottom' => '1px dashed ' . $separator_color,
		);
		$expirationDate = !empty($expirationDate) ? (new DateTime($expirationDate))->format('d/m/Y') : '';

		$titleStyles = array(
			'font-size' => is_value_empty($attributes['titleFontSize']) ? '21px' : $attributes['titleFontSize'],
			'color' => empty($attributes['titleColor']) ? '#000000' : $attributes['titleColor'],
		);

		$discountBgColor = get_background_color_var($attributes, 'discountBgColor', 'discountBgGradientColor');
		$discountStyles = array(
			'font-size' => empty($attributes['discountFontSize']) ? '24px' : $attributes['discountFontSize'],
			'color' => empty($attributes['discountColor']) ? '#ffffff' : $attributes['discountColor'],
			'--wpcd-discount-background-color' => $discountBgColor,
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
		$borderStyle = '2px solid #9b59b6';
		$codeStyles = array_merge($codeHoverStyles, array(
			"--wpcd-coupon-code-button-text" => isset($attributes['couponCodeButtonText']) ? '"' . $attributes['couponCodeButtonText'] . '"' : '',
			'font-size' => empty($attributes['codeFontSize']) ? "" : $attributes['codeFontSize'],
			'--wpcd-coupon-code-color' => empty($attributes['codeColor']) ? '' : $attributes['codeColor'],
			'--wpcd-coupon-code-bg-color' => get_background_color_var($attributes, 'codeBackgroundColor', 'codeGradientBackground'),
			'border-top-left-radius' => empty($attributes['codeBorderRadius']['topLeft']) ? '2px' : $attributes['codeBorderRadius']['topLeft'],
			'border-top-right-radius' => empty($attributes['codeBorderRadius']['topRight']) ? '2px' : $attributes['codeBorderRadius']['topRight'],
			'border-bottom-left-radius' => empty($attributes['codeBorderRadius']['bottomLeft']) ? '2px' : $attributes['codeBorderRadius']['bottomLeft'],
			'border-bottom-right-radius' => empty($attributes['codeBorderRadius']['bottomRight']) ? '2px' : $attributes['codeBorderRadius']['bottomRight'],
			'border-top' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'top')) ? ($couponType === 'deal' ? '2px solid #9b59b6' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'top'),
			'border-left' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'left')) ? ($couponType === 'deal' ? '2px solid #9b59b6' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'left'),
			'border-right' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'right')) ? ($couponType === 'deal' ? '2px solid #9b59b6' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'right'),
			'border-bottom' => is_value_empty(get_single_side_border_value($couponCodeBorder, 'bottom')) ? ($couponType === 'deal' ? '2px solid #9b59b6' : $borderStyle) : get_single_side_border_value($couponCodeBorder, 'bottom'),
		));
		$expirationDateStyles = array(
			'--wpcd-coupon-expiration-date-font-size' => empty($attributes['expirationDateFontSize']) ? '14px' : $attributes['expirationDateFontSize'],
			'--wpcd-coupon-expired-date-font-size' => empty($attributes['expiredDateFontSize']) ? '14px' : $attributes['expiredDateFontSize'],
			'--wpcd-coupon-expiration-date-color' => empty($attributes['expirationDateColor']) ? '#000000' : $attributes['expirationDateColor'],
			'--wpcd-coupon-expired-date-color' => empty($attributes['expiredDateColor']) ? 'red' : $attributes['expiredDateColor'],
		);
		$coupon_default_image = 'http://wp-coupon-and-deals.local/wp-content/plugins/wp-coupons-and-deals/assets/img/coupon-200x200.png';
		$image_url = isset( $attributes['couponImage']['url'] ) ? $attributes['couponImage']['url'] : $coupon_default_image;

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
					<div class="wpcd-coupon-image-wrapper">
						<div class="wpcd-coupon-discount-wrapper">
							<div class="wpcd-coupon-discount-inner__wrapper">
								<div class="wpcd-coupon-discount" style="<?php echo esc_attr( generate_css_string( $discountStyles ) ); ?>"><?php echo esc_html( $discount ); ?></div>
							</div>
						</div>
						<figure class="wpcd-coupon-seven-image">
							<img src="<?php echo $image_url ?>" />
						</figure>
					</div>
					<div class="wpcd-coupon-content-wrapper">
						<div class="wpcd-coupon-title-wrapper">
							<h3 class="wpcd-coupon-title" style="<?php echo esc_attr( generate_css_string( $titleStyles ) ); ?>"><?php echo esc_html( $title ); ?></h3>
						</div>
						<div class="wpcd-coupon-description" style="<?php echo esc_attr( generate_css_string( $descriptionStyles ) ); ?>">
							<p><?php echo esc_html( $description ); ?></p>
						</div>
						<div class="wpcd-coupon-content" style="<?php echo esc_attr( generate_css_string( $separator_styles ) ); ?>">
							<div class="wpcd-coupon-expiration-date<?php echo $isDoesNotExpire ? ' wpcd-coupon-does-not-expire' : ''; ?>" style="<?php echo esc_attr( generate_css_string( $expirationDateStyles ) ); ?>">
								<?php if ( ! $isDoesNotExpire ) : ?>
									<span><?php esc_html_e( 'Expire On: ', 'wp-coupons-and-deals' ); ?></span>
									<span><?php echo esc_html( $expirationDate ); ?></span>
								<?php else : ?>
									<span><?php echo esc_html( $doesNotExpireText ); ?></span>
								<?php endif; ?>
							</div>
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
								data-coupon_code="<?php echo isset($attributes['code']) ? esc_attr($attributes['code']) : ''; ?>"
							>
								<span><?php echo esc_html( $code ); ?></span>
							</a>
						<?php else : ?>
							<a  data-coupon_code="<?php echo isset($attributes['dealButtonText']) ? esc_attr($attributes['dealButtonText']) : ''; ?>" rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr( generate_css_string( $codeStyles ) ); ?>" title="<?php esc_attr_e( 'Click To Claim This Deal', 'wp-coupons-and-deals' ); ?>">
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
	/**
	 * Generates the HTML for the coupon block based on the coupon type.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_eight_html( $attributes ) {
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
				<a rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr(generate_css_string($dealButtonStyles)); ?>" title="<?php esc_attr_e('Click To Claim This Deal', 'wp-coupons-and-deals'); ?>">
					<span><?php echo esc_html($dealButtonText); ?></span>
				</a>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
	/**
	 * Generates the HTML for template nine based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_nine_html( $attributes ) {
		$couponType = isset($attributes['couponType']) ? $attributes['couponType'] : 'default';
		$title = isset($attributes['title']) ? $attributes['title'] : '';
		$code = isset($attributes['code']) ? $attributes['code'] : '';
		$dealButtonText = isset($attributes['dealButtonText']) ? $attributes['dealButtonText'] : '';
		$couponCodeBorder = get_border_css($attributes['codeBorder']);
		$titleStyles = array(
			'font-size' => is_value_empty($attributes['titleFontSize']) ? '21px' : $attributes['titleFontSize'],
			'color' => empty($attributes['titleColor']) ? '#000000' : $attributes['titleColor'],
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
			<div class="wpcd-coupon-title-wrapper">
				<h3 class="wpcd-coupon-title" style="<?php echo esc_attr(generate_css_string($titleStyles)); ?>"><?php echo esc_html($title); ?></h3>
			</div>
			<div class="wpcd-coupon-code">
				<?php if ($couponType !== 'deal') : ?>
					<a
						style="<?php echo esc_attr(generate_css_string($codeStyles)); ?>"
						<?php foreach ($navigationAttrs as $attr => $value) {
							echo esc_attr($attr) . '="' . esc_attr($value) . '" ';
						} ?>
						href="<?php echo esc_url($attributes['navigationLink']); ?>"
						class="wpcd-coupon-button<?php echo isset($attributes['hideCoupon']) && $attributes['hideCoupon'] ? ' wpcd-popup-button' : ''; ?>"
						title="<?php esc_attr_e('Click To Copy Coupon', 'wp-coupons-and-deals'); ?>"
					>
						<span class="wpcd-coupon-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<g fill="currentColor">
									<path fill-rule="evenodd" d="M8.128 9.155a3.751 3.751 0 1 1 .713-1.321l1.136.656a.75.75 0 0 1 .222 1.104l-.006.007a.75.75 0 0 1-1.032.157a1.421 1.421 0 0 0-.113-.072l-.92-.531Zm-4.827-3.53a2.25 2.25 0 0 1 3.994 2.063a.756.756 0 0 0-.122.23a2.25 2.25 0 0 1-3.872-2.293Zm10.047 2.647a5.073 5.073 0 0 0-3.428 3.57c-.101.387-.158.79-.165 1.202a1.415 1.415 0 0 1-.707 1.201l-.96.554a3.751 3.751 0 1 0 .734 1.309l13.729-7.926a.75.75 0 0 0-.181-1.374l-.803-.215a5.25 5.25 0 0 0-2.894.05l-5.325 1.629Zm-9.223 7.03a2.25 2.25 0 1 0 2.25 3.897a2.25 2.25 0 0 0-2.25-3.897ZM12 12.75a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
									<path d="M16.372 12.615a.75.75 0 0 1 .75 0l5.43 3.135a.75.75 0 0 1-.182 1.374l-.802.215a5.25 5.25 0 0 1-2.894-.051l-5.147-1.574a.75.75 0 0 1-.156-1.367l3-1.732Z"/>
								</g>
							</svg>
						</span>
						<span><?php echo esc_html($code); ?></span>
					</a>
				<?php else : ?>
					<a rel="nofollow noopener" target="_blank" class="wpcd-coupon-button" style="<?php echo esc_attr(generate_css_string($codeStyles)); ?>" title="<?php esc_attr_e('Click To Claim This Deal', 'wp-coupons-and-deals'); ?>">
						<span><?php echo esc_html($dealButtonText); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
	/**
	 * Main registration logic for the pro block.
	 *
	 * @return void
	 */
	protected function register_logic() {
		register_block_type_from_metadata(
			WPCD_Plugin::instance()->plugin_dir_path . 'build/block.json', array(
				'render_callback' => array( $this, 'render_coupon_block' ),
			)
		);
	}
}
new Coupon_Block();