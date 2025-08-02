<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Validation Utility Class
 * 
 * Centralizes all validation, sanitization, and security checks
 * Reduces code duplication across the plugin
 *
 * @since 3.3.0
 */
class WPCD_Validation_Utility {

	/**
	 * Validate and sanitize AJAX request
	 *
	 * @param string $nonce_action The nonce action to verify
	 * @param string $nonce_field The nonce field name
	 * @return bool True if valid, dies on failure
	 */
	public static function validate_ajax_request( $nonce_action = 'wpcd-security-nonce', $nonce_field = 'security' ) {
		// Check if AJAX request
		if ( ! wp_doing_ajax() ) {
			return false;
		}

		// Verify nonce
		if ( ! check_ajax_referer( $nonce_action, $nonce_field, false ) ) {
			wp_die( __( 'Security check failed', 'wp-coupons-and-deals' ) );
		}

		return true;
	}

	/**
	 * Sanitize and validate shortcode attributes
	 *
	 * @param array $atts Raw attributes
	 * @param array $defaults Default values
	 * @return array Sanitized attributes
	 */
	public static function sanitize_shortcode_atts( $atts, $defaults ) {
		$sanitized = array();

		foreach ( $defaults as $key => $default ) {
			if ( isset( $atts[ $key ] ) ) {
				$sanitized[ $key ] = self::sanitize_by_type( $atts[ $key ], $default );
			} else {
				$sanitized[ $key ] = $default;
			}
		}

		return $sanitized;
	}

	/**
	 * Sanitize value based on type of default
	 *
	 * @param mixed $value Value to sanitize
	 * @param mixed $default Default value (used for type detection)
	 * @return mixed Sanitized value
	 */
	private static function sanitize_by_type( $value, $default ) {
		if ( is_int( $default ) ) {
			return intval( $value );
		} elseif ( is_bool( $default ) ) {
			return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
		} elseif ( is_array( $default ) ) {
			return is_array( $value ) ? array_map( 'sanitize_text_field', $value ) : array();
		} else {
			return sanitize_text_field( $value );
		}
	}

	/**
	 * Validate and sanitize POST data
	 *
	 * @param string $key The POST key
	 * @param string $type The expected type (string, int, bool, array)
	 * @param mixed $default Default value if not set
	 * @return mixed Sanitized value
	 */
	public static function get_post_value( $key, $type = 'string', $default = null ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			return $default;
		}

		$value = $_POST[ $key ];

		switch ( $type ) {
			case 'int':
			case 'integer':
				return intval( $value );
			
			case 'bool':
			case 'boolean':
				return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			
			case 'array':
				return is_array( $value ) ? array_map( 'sanitize_text_field', $value ) : array();
			
			case 'email':
				return sanitize_email( $value );
			
			case 'url':
				return esc_url_raw( $value );
			
			case 'textarea':
				return sanitize_textarea_field( $value );
			
			case 'html':
				return wp_kses_post( $value );
			
			case 'string':
			default:
				return sanitize_text_field( $value );
		}
	}

	/**
	 * Validate and sanitize GET data
	 *
	 * @param string $key The GET key
	 * @param string $type The expected type
	 * @param mixed $default Default value if not set
	 * @return mixed Sanitized value
	 */
	public static function get_query_value( $key, $type = 'string', $default = null ) {
		if ( ! isset( $_GET[ $key ] ) ) {
			return $default;
		}

		$value = $_GET[ $key ];

		// Use same sanitization as POST
		$_POST[ $key ] = $value;
		$result = self::get_post_value( $key, $type, $default );
		unset( $_POST[ $key ] );

		return $result;
	}

	/**
	 * Validate coupon ID
	 *
	 * @param mixed $coupon_id The coupon ID to validate
	 * @return int|false Valid coupon ID or false
	 */
	public static function validate_coupon_id( $coupon_id ) {
		$coupon_id = intval( $coupon_id );

		if ( $coupon_id <= 0 ) {
			return false;
		}

		$post = get_post( $coupon_id );
		
		if ( ! $post || $post->post_type !== WPCD_Plugin::CUSTOM_POST_TYPE ) {
			return false;
		}

		return $coupon_id;
	}

	/**
	 * Validate taxonomy term
	 *
	 * @param string $term Term slug or ID
	 * @param string $taxonomy Taxonomy name
	 * @param string $field Field to check (slug, id, name)
	 * @return mixed Valid term or false
	 */
	public static function validate_taxonomy_term( $term, $taxonomy, $field = 'slug' ) {
		if ( empty( $term ) ) {
			return false;
		}

		$term_obj = get_term_by( $field, $term, $taxonomy );

		return ( $term_obj && ! is_wp_error( $term_obj ) ) ? $term : false;
	}

	/**
	 * Validate date format
	 *
	 * @param string $date Date string
	 * @param string $format Expected format
	 * @return string|false Valid date or false
	 */
	public static function validate_date( $date, $format = 'd-m-Y' ) {
		$d = DateTime::createFromFormat( $format, $date );
		return $d && $d->format( $format ) === $date ? $date : false;
	}

	/**
	 * Validate and sanitize color value
	 *
	 * @param string $color Color value
	 * @return string Sanitized color or empty string
	 */
	public static function sanitize_color( $color ) {
		// Check for hex color
		if ( preg_match( '/^#[a-f0-9]{6}$/i', $color ) ) {
			return $color;
		}

		// Check for hex color without hash
		if ( preg_match( '/^[a-f0-9]{6}$/i', $color ) ) {
			return '#' . $color;
		}

		// Check for RGB/RGBA
		if ( preg_match( '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/i', $color ) ) {
			return $color;
		}

		return '';
	}

	/**
	 * Validate user capability
	 *
	 * @param string $capability The capability to check
	 * @param int $user_id Optional user ID (defaults to current user)
	 * @return bool True if user has capability
	 */
	public static function user_can( $capability, $user_id = null ) {
		if ( $user_id === null ) {
			return current_user_can( $capability );
		}

		$user = get_user_by( 'id', $user_id );
		
		if ( ! $user ) {
			return false;
		}

		return $user->has_cap( $capability );
	}

	/**
	 * Validate and sanitize array of IDs
	 *
	 * @param mixed $ids String of comma-separated IDs or array
	 * @return array Array of valid IDs
	 */
	public static function sanitize_id_array( $ids ) {
		if ( is_string( $ids ) ) {
			$ids = explode( ',', $ids );
		}

		if ( ! is_array( $ids ) ) {
			return array();
		}

		return array_filter( array_map( 'intval', $ids ), function( $id ) {
			return $id > 0;
		} );
	}

	/**
	 * Escape output based on context
	 *
	 * @param mixed $value Value to escape
	 * @param string $context Context (html, attr, url, js)
	 * @return string Escaped value
	 */
	public static function escape_output( $value, $context = 'html' ) {
		switch ( $context ) {
			case 'attr':
				return esc_attr( $value );
			
			case 'url':
				return esc_url( $value );
			
			case 'js':
				return esc_js( $value );
			
			case 'textarea':
				return esc_textarea( $value );
			
			case 'html':
			default:
				return esc_html( $value );
		}
	}

	/**
	 * Batch validate and sanitize an array of values
	 *
	 * @param array $data Data to validate
	 * @param array $rules Validation rules (key => type)
	 * @return array Sanitized data
	 */
	public static function batch_sanitize( $data, $rules ) {
		$sanitized = array();

		foreach ( $rules as $key => $type ) {
			if ( isset( $data[ $key ] ) ) {
				$sanitized[ $key ] = self::sanitize_by_rule( $data[ $key ], $type );
			}
		}

		return $sanitized;
	}

	/**
	 * Sanitize by rule type
	 *
	 * @param mixed $value Value to sanitize
	 * @param string $type Rule type
	 * @return mixed Sanitized value
	 */
	private static function sanitize_by_rule( $value, $type ) {
		switch ( $type ) {
			case 'int':
				return intval( $value );
			
			case 'bool':
				return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			
			case 'email':
				return sanitize_email( $value );
			
			case 'url':
				return esc_url_raw( $value );
			
			case 'color':
				return self::sanitize_color( $value );
			
			case 'id_array':
				return self::sanitize_id_array( $value );
			
			default:
				return sanitize_text_field( $value );
		}
	}
}