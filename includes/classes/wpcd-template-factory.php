<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Template Factory Class
 * 
 * Handles template selection and rendering for coupons
 * Eliminates code duplication across shortcode implementations
 *
 * @since 3.3.0
 */
class WPCD_Template_Factory {

	/**
	 * Template mappings for shortcode templates
	 */
	const TEMPLATE_MAPPINGS = array(
		'shortcode' => array(
			'Template One'   => array( 'template' => 'shortcode-one__premium_only', 'css' => 'shortcode_one' ),
			'Template Two'   => array( 'template' => 'shortcode-two__premium_only', 'css' => 'shortcode_two' ),
			'Template Three' => array( 'template' => 'shortcode-three__premium_only', 'css' => 'shortcode_three' ),
			'Template Four'  => array( 'template' => 'shortcode-four__premium_only', 'css' => 'shortcode_four' ),
			'Template Five'  => array( 'template' => 'shortcode-five__premium_only', 'css' => 'shortcode_five' ),
			'Template Six'   => array( 'template' => 'shortcode-six__premium_only', 'css' => 'shortcode_six' ),
			'Template Seven' => array( 'template' => 'shortcode-seven__premium_only', 'css' => 'shortcode_seven' ),
			'Template Eight' => array( 'template' => 'shortcode-eight__premium_only', 'css' => 'shortcode_eight' ),
			'Template Nine'  => array( 'template' => 'shortcode-nine__premium_only', 'css' => 'shortcode_nine' ),
			'Default'        => array( 'template' => 'shortcode-default', 'css' => 'shortcode_default' )
		),
		'archive' => array(
			''       => array( 'template' => 'shortcode-archive__premium_only', 'css' => 'archive_not_temp' ),
			'one'    => array( 'template' => 'shortcode-archive-one__premium_only', 'css' => 'archive_one' ),
			'two'    => array( 'template' => 'shortcode-archive-two__premium_only', 'css' => 'archive_two' ),
			'three'  => array( 'template' => 'shortcode-archive-three__premium_only', 'css' => 'archive_three' ),
			'seven'  => array( 'template' => 'shortcode-archive-seven__premium_only', 'css' => 'archive_seven' ),
			'eight'  => array( 'template' => 'shortcode-archive-eight__premium_only', 'css' => 'archive_eight' ),
			'default' => array( 'template' => 'shortcode-archive-default__premium_only', 'css' => 'archive_default' )
		),
		'category' => array(
			''       => array( 'template' => 'shortcode-category__premium_only', 'css' => 'archive_not_temp' ),
			'one'    => array( 'template' => 'shortcode-category-one__premium_only', 'css' => 'archive_one' ),
			'two'    => array( 'template' => 'shortcode-category-two__premium_only', 'css' => 'archive_two' ),
			'three'  => array( 'template' => 'shortcode-category-three__premium_only', 'css' => 'archive_three' ),
			'seven'  => array( 'template' => 'shortcode-category-seven__premium_only', 'css' => 'archive_seven' ),
			'eight'  => array( 'template' => 'shortcode-category-eight__premium_only', 'css' => 'archive_eight' ),
			'default' => array( 'template' => 'shortcode-category-default__premium_only', 'css' => 'archive_default' )
		)
	);

	/**
	 * Get template info based on type and template name
	 *
	 * @param string $type The type of template (shortcode, archive, category)
	 * @param string $template_name The template name
	 * @return array Template info with 'template' and 'css' keys
	 */
	public static function get_template_info( $type, $template_name ) {
		// Check if premium features are available
		$has_premium = wcad_fs()->is_plan__premium_only( 'pro' ) || wcad_fs()->can_use_premium_code();
		
		// For shortcode type with no premium, always return default
		if ( $type === 'shortcode' && ! $has_premium ) {
			return self::TEMPLATE_MAPPINGS['shortcode']['Default'];
		}
		
		// Check if the type exists in mappings
		if ( ! isset( self::TEMPLATE_MAPPINGS[ $type ] ) ) {
			return self::get_default_template_info( $type );
		}
		
		$mappings = self::TEMPLATE_MAPPINGS[ $type ];
		
		// Check if template exists in mappings
		if ( isset( $mappings[ $template_name ] ) ) {
			return $mappings[ $template_name ];
		}
		
		// Return default for the type
		return self::get_default_template_info( $type );
	}

	/**
	 * Get default template info for a type
	 *
	 * @param string $type The template type
	 * @return array Default template info
	 */
	private static function get_default_template_info( $type ) {
		$defaults = array(
			'shortcode' => self::TEMPLATE_MAPPINGS['shortcode']['Default'],
			'archive'   => self::TEMPLATE_MAPPINGS['archive']['default'],
			'category'  => self::TEMPLATE_MAPPINGS['category']['default']
		);
		
		return isset( $defaults[ $type ] ) ? $defaults[ $type ] : array( 'template' => '', 'css' => '' );
	}

	/**
	 * Render a template and return the output
	 *
	 * @param string $type The type of template
	 * @param string $template_name The template name
	 * @param WPCD_Template_Loader $loader Optional template loader instance
	 * @return string The rendered template output
	 */
	public static function render_template( $type, $template_name, $loader = null ) {
		// Get template info
		$template_info = self::get_template_info( $type, $template_name );
		
		// Create loader if not provided
		if ( ! $loader ) {
			$loader = new WPCD_Template_Loader();
		}
		
		// Start output buffering
		ob_start();
		
		// Load the template
		$loader->get_template_part( $template_info['template'] );
		
		// Get the output
		$output = ob_get_clean();
		
		// Handle AMP styles
		if ( WPCD_Amp::wpcd_amp_is() ) {
			self::handle_amp_styles( $type, $template_info['css'] );
		}
		
		return $output;
	}

	/**
	 * Handle AMP styles for templates
	 *
	 * @param string $type The template type
	 * @param string $css_class The CSS class to load
	 */
	private static function handle_amp_styles( $type, $css_class ) {
		// Always load common styles
		WPCD_Amp::instance()->setCss( 'shortcode_common' );
		
		// Load archive common styles for archive types
		if ( in_array( $type, array( 'archive', 'category' ) ) ) {
			WPCD_Amp::instance()->setCss( 'archive_common' );
		}
		
		// Handle special case for archive default template
		if ( $css_class === 'archive_default' ) {
			WPCD_Amp::instance()->setCss( 'shortcode_five' );
			WPCD_Amp::instance()->setCss( 'shortcode_six' );
			WPCD_Amp::instance()->setCss( 'shortcode_default' );
		} else {
			WPCD_Amp::instance()->setCss( $css_class );
		}
		
		// Load user stylesheets
		global $coupon_id;
		$coupon_template = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );
		$user_stylesheets = WPCD_Assets::wpcd_stylesheets( true, $coupon_id, $coupon_template );
		WPCD_Amp::instance()->setCss( $user_stylesheets, false );
	}

	/**
	 * Check if a coupon should be hidden based on expiration
	 *
	 * @param int $coupon_id The coupon ID
	 * @param string $coupon_template The template name
	 * @return bool True if coupon should be hidden
	 */
	public static function should_hide_expired_coupon( $coupon_id, $coupon_template = '' ) {
		$hide_expired_option = get_option( 'wpcd_hide-expired-coupon' );
		
		if ( empty( $hide_expired_option ) || $hide_expired_option !== 'on' ) {
			return false;
		}
		
		$today = date( 'd-m-Y' );
		$expire_date = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
		
		if ( empty( $expire_date ) ) {
			return false;
		}
		
		// Convert to timestamp if needed
		if ( (string) (int) $expire_date != $expire_date ) {
			$expire_date = strtotime( $expire_date );
		}
		
		// Special handling for Template Four
		if ( $coupon_template === 'Template Four' ) {
			$second_expire = get_post_meta( $coupon_id, 'coupon_details_second-expire-date', true );
			$third_expire = get_post_meta( $coupon_id, 'coupon_details_third-expire-date', true );
			
			// Convert dates if needed
			if ( ! empty( $second_expire ) && (string) (int) $second_expire != $second_expire ) {
				$second_expire = strtotime( $second_expire );
			}
			if ( ! empty( $third_expire ) && (string) (int) $third_expire != $third_expire ) {
				$third_expire = strtotime( $third_expire );
			}
			
			// Hide only if all dates are expired
			return $expire_date < strtotime( $today ) && 
			       $second_expire < strtotime( $today ) && 
			       $third_expire < strtotime( $today );
		}
		
		// For other templates, check single expire date
		return $expire_date < strtotime( $today );
	}
}