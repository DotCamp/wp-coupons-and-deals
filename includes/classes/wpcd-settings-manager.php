<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings Manager Class
 * 
 * Centralizes all plugin settings and option handling
 * Provides type safety and default values
 *
 * @since 3.3.0
 */
class WPCD_Settings_Manager {

	/**
	 * Settings cache
	 */
	private static $cache = array();

	/**
	 * Default settings with their types
	 */
	const SETTINGS = array(
		// General Settings
		'wpcd_hide-expired-coupon' => array(
			'type' => 'boolean',
			'default' => false,
			'sanitize' => 'sanitize_text_field'
		),
		'wpcd_enable-stats-count' => array(
			'type' => 'boolean',
			'default' => false,
			'sanitize' => 'sanitize_text_field'
		),
		'wpcd_popup-goto-link' => array(
			'type' => 'boolean',
			'default' => true,
			'sanitize' => 'sanitize_text_field'
		),
		'wpcd_form-shortcode-enable-thrash' => array(
			'type' => 'boolean',
			'default' => true,
			'sanitize' => 'sanitize_text_field'
		),
		'wpcd_form-shortcode-split-form' => array(
			'type' => 'string',
			'default' => 'split',
			'sanitize' => 'sanitize_text_field'
		),
		'wpcd_archive-munu-categories' => array(
			'type' => 'string',
			'default' => 'category',
			'sanitize' => 'sanitize_text_field'
		),
		'wpcd_review_notify' => array(
			'type' => 'string',
			'default' => 'no',
			'sanitize' => 'sanitize_text_field'
		),
		'wpcd_expire_date_converted' => array(
			'type' => 'string',
			'default' => '',
			'sanitize' => 'sanitize_text_field'
		),
		'wpcd_create-edit-import-allowed-roles' => array(
			'type' => 'array',
			'default' => array( 'administrator' ),
			'sanitize' => 'wpcd_sanitize_roles_array'
		),
		// Add more settings as needed
	);

	/**
	 * Get a setting value
	 *
	 * @param string $key The setting key
	 * @param mixed $default Optional default value to override
	 * @return mixed The setting value
	 */
	public static function get( $key, $default = null ) {
		// Check cache first
		if ( isset( self::$cache[ $key ] ) ) {
			return self::$cache[ $key ];
		}

		// Get setting config
		$config = self::get_setting_config( $key );
		
		if ( ! $config ) {
			// Unknown setting, return provided default or null
			return $default !== null ? $default : null;
		}

		// Get option value
		$value = get_option( $key, $config['default'] );

		// Convert value based on type
		$value = self::convert_value( $value, $config['type'] );

		// Cache the value
		self::$cache[ $key ] = $value;

		return $value;
	}

	/**
	 * Set a setting value
	 *
	 * @param string $key The setting key
	 * @param mixed $value The value to set
	 * @return bool True if successful
	 */
	public static function set( $key, $value ) {
		$config = self::get_setting_config( $key );
		
		if ( ! $config ) {
			return false;
		}

		// Sanitize value
		$value = self::sanitize_value( $value, $config );

		// Update option
		$result = update_option( $key, $value );

		// Clear cache
		if ( isset( self::$cache[ $key ] ) ) {
			unset( self::$cache[ $key ] );
		}

		return $result;
	}

	/**
	 * Check if a boolean setting is enabled
	 *
	 * @param string $key The setting key
	 * @return bool True if enabled
	 */
	public static function is_enabled( $key ) {
		$value = self::get( $key );
		
		// Handle various truthy values
		return $value === true || $value === 'on' || $value === '1' || $value === 1;
	}

	/**
	 * Get setting configuration
	 *
	 * @param string $key The setting key
	 * @return array|false Setting config or false if not found
	 */
	private static function get_setting_config( $key ) {
		return isset( self::SETTINGS[ $key ] ) ? self::SETTINGS[ $key ] : false;
	}

	/**
	 * Convert value to proper type
	 *
	 * @param mixed $value The value to convert
	 * @param string $type The target type
	 * @return mixed Converted value
	 */
	private static function convert_value( $value, $type ) {
		switch ( $type ) {
			case 'boolean':
				return $value === 'on' || $value === '1' || $value === true || $value === 1;
			
			case 'integer':
				return intval( $value );
			
			case 'float':
				return floatval( $value );
			
			case 'array':
				return is_array( $value ) ? $value : array();
			
			case 'string':
			default:
				return strval( $value );
		}
	}

	/**
	 * Sanitize value based on config
	 *
	 * @param mixed $value The value to sanitize
	 * @param array $config The setting config
	 * @return mixed Sanitized value
	 */
	private static function sanitize_value( $value, $config ) {
		if ( isset( $config['sanitize'] ) && is_callable( $config['sanitize'] ) ) {
			return call_user_func( $config['sanitize'], $value );
		}

		// Default sanitization based on type
		switch ( $config['type'] ) {
			case 'boolean':
				return $value ? 'on' : 'off';
			
			case 'integer':
				return intval( $value );
			
			case 'float':
				return floatval( $value );
			
			case 'array':
				return is_array( $value ) ? $value : array();
			
			case 'string':
			default:
				return sanitize_text_field( $value );
		}
	}

	/**
	 * Clear settings cache
	 */
	public static function clear_cache() {
		self::$cache = array();
	}

	/**
	 * Get all settings with their values
	 *
	 * @return array All settings
	 */
	public static function get_all() {
		$settings = array();
		
		foreach ( self::SETTINGS as $key => $config ) {
			$settings[ $key ] = self::get( $key );
		}
		
		return $settings;
	}

	/**
	 * Reset a setting to its default value
	 *
	 * @param string $key The setting key
	 * @return bool True if successful
	 */
	public static function reset( $key ) {
		$config = self::get_setting_config( $key );
		
		if ( ! $config ) {
			return false;
		}

		return self::set( $key, $config['default'] );
	}

	/**
	 * Bulk update settings
	 *
	 * @param array $settings Array of key => value pairs
	 * @return array Results array with key => success status
	 */
	public static function bulk_update( $settings ) {
		$results = array();
		
		foreach ( $settings as $key => $value ) {
			$results[ $key ] = self::set( $key, $value );
		}
		
		return $results;
	}
}

/**
 * Custom sanitization function for roles array
 */
if ( ! function_exists( 'wpcd_sanitize_roles_array' ) ) {
	function wpcd_sanitize_roles_array( $roles ) {
		if ( ! is_array( $roles ) ) {
			return array( 'administrator' );
		}
		
		$sanitized = array();
		$valid_roles = wp_roles()->get_names();
		
		foreach ( $roles as $role ) {
			if ( isset( $valid_roles[ $role ] ) ) {
				$sanitized[] = $role;
			}
		}
		
		return ! empty( $sanitized ) ? $sanitized : array( 'administrator' );
	}
}