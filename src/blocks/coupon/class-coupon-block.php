<?php

namespace Ultimate_Blocks_Pro\Src\Blocks\Coupon;

use Ultimate_Blocks_Pro\Inc\Common\Base\Pro_Block;
use Ultimate_Blocks_Pro as NS;
use Ultimate_Blocks_Pro;

use function esc_html__;

/**
 * Coupon block.
 */
class Coupon_Block extends Pro_Block {
	/**
	 * Get block classes.
	 *
	 * @param array $attributes - block attributes.
	 * @return string Generated block classess.
	 */
	public static function get_classes( $attributes ) {

		$classes = join(
			' ',
			array(
				! Ultimate_Blocks_Pro\CSS_Generator\is_value_empty( isset($attributes['padding']) ? $attributes['padding'] : array() ) ? 'has-padding' : '',
				! Ultimate_Blocks_Pro\CSS_Generator\is_value_empty( isset($attributes['margin']) ? $attributes['margin'] : array() ) ? 'has-margin' : '',
			)
		);
		return $classes;
	}
	/**
	 * Renders the custom button block on the server.
	 *
	 * @param array    $attributes The block attributes.
	 * @param string   $content    The block content.
	 * @param WP_Block $block      The block object.
	 * @return string  Returns the HTML content for the custom button block.
	 */
	public function render_coupon_block( $attributes, $content ) {
		$classes = $this->get_classes( $attributes );
		$content = str_replace('class="wp-block-ub-coupon', 'class="wp-block-ub-coupon ' . esc_attr($classes) . '', $content );
		return $content;
	}
	/**
	 * Main registration logic for the pro block.
	 *
	 * @return void
	 */
	protected function register_logic() {
		register_block_type_from_metadata(
			NS\ULTIMATE_BLOCKS_PRO_DIR . 'inc/blocks/coupon/block.json', array(
				'render_callback' => array( $this, 'render_coupon_block' ),
			)
		);

		wp_register_script(
			'ub-coupon-frontend-script',
			plugins_url( 'coupon/front.js', dirname( __FILE__ ) ),
			array(),
			uniqid(),
			false
		);
	}

	/**
	 * Get block name.
	 * @return string block name
	 */
	public function get_block_name() {
		return 'ub/coupon';
	}

	/**
	 * Short description for the pro block.
	 * @return string block description
	 */
	public function get_block_description() {
		return esc_html__( 'Enhance engagement and sales by easily displaying enticing discounts.' );
	}
}
