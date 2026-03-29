<?php

if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/default-template.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/default-template.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/hidden_coupon_template.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/hidden_coupon_template.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-one__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-one__premium_only.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-two__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-two__premium_only.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-three__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-three__premium_only.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-four__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-four__premium_only.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-five__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-five__premium_only.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-six__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-six__premium_only.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-seven__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-seven__premium_only.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-eight__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-eight__premium_only.php';
}
if (file_exists(WPCD_Plugin::instance()->plugin_includes . 'blocks/template-nine__premium_only.php')) {
	include WPCD_Plugin::instance()->plugin_includes . 'blocks/template-nine__premium_only.php';
}

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
	 * Checks if the user has a premium plan.
	 *
	 * @return bool True if the user has a premium plan, false otherwise.
	 */
	public function is_premium_user() {
		return wcad_fs()->is_plan__premium_only('pro') || wcad_fs()->can_use_premium_code();
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
		$selected_template = $this->is_premium_user() ? (isset($attributes['template']) ? $attributes['template'] : 'template-default') : 'template-default';

		$classes = array(
			'wpcd-coupon-wrapper',
			'wpcd-coupon-' . $selected_template . '',
		);

		$classes[] = 'wp-block-wpcd-coupon';
		if(!empty( isset($attributes['padding']) ? $attributes['padding'] : array() ))
		{
			$classes[] = 'has-padding';
		}
		if (!empty( isset($attributes['margin']) ? $attributes['margin'] : array() )) {
			$classes[] = 'has-margin';
		}
		if ($this->is_premium_user() && isset($attributes['hideCoupon']) && $attributes['hideCoupon'] && $attributes['couponType'] !== 'deal') {
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
		if( function_exists( 'wpcd_get_default_template' ) ){
			return wpcd_get_default_template($attributes, $this->is_premium_user());
		}
	}
	/**
	 * Generates the HTML for the hidden coupon block.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_hidden_coupon_html( $attributes ) {
		if( function_exists( 'wpcd_get_hidden_coupon_template' ) ){
			return wpcd_get_hidden_coupon_template($attributes);
		}
	}
	/**
	 * Generates the HTML for template one based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_one_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_one' ) ){
			return wpcd_get_template_one($attributes);
		}
	}
	/**
	 * Generates the HTML for template two based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_two_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_two' ) ){
			return wpcd_get_template_two($attributes);
		}
	}
	/**
	 * Generates the HTML for template three based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_three_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_three' ) ){
			return wpcd_get_template_three($attributes);
		}
	}
	/**
	 * Generates the HTML for template three based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_four_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_four' ) ){
			return wpcd_get_template_four($attributes);
		}
	}
	/**
	 * Generates the HTML for template six based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_five_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_five' ) ){
			return wpcd_get_template_five($attributes);
		}
	}
	/**
	 * Generates the HTML for template six based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_six_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_six' ) ){
			return wpcd_get_template_six($attributes);
		}
	}
	/**
	 * Generates the HTML for template two based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_seven_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_seven' ) ){
			return wpcd_get_template_seven($attributes);
		}
	}
	/**
	 * Generates the HTML for the coupon block based on the coupon type.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_eight_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_eight' ) ){
			return wpcd_get_template_eight($attributes);
		}
	}
	/**
	 * Generates the HTML for template nine based on the attributes.
	 *
	 * @param array $attributes The block attributes.
	 * @return string The generated HTML.
	 */
	public function generate_template_nine_html( $attributes ) {
		if(function_exists( 'wpcd_get_template_nine' ) ){
			return wpcd_get_template_nine($attributes);
		}
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