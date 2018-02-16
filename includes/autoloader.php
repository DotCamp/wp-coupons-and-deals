<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoloads classes.
 *
 * @since 1.0
 */
class WPCD_Autoloader {

	/**
	 * Registers Autoloader.
	 *
	 * @since 1.0
	 *
	 * @param boolean $prepend
	 */
	public static function register( $prepend = false ) {

		if ( version_compare( phpversion(), '5.3.0', '>=' ) ) {
			spl_autoload_register( array( new self, 'autoload' ), true, $prepend );
		} else {
			spl_autoload_register( array( new self, 'autoload' ) );
		}

	}

	/**
	 * Handles autoloading of classes.
	 *
	 * @param string $class
	 */
	public static function autoload( $class ) {

		if ( 0 !== strpos( $class, 'WPCD_' ) ) {
			return;
		}

		$file_name = str_replace(
			array( 'WPCD_', '_' ),
			array( '', '-' ),
			strtolower( $class )
		);

		if ( is_file( $file = trailingslashit( dirname( plugin_dir_path( __FILE__ ) ) ) . 'includes/classes/' . $file_name . '.php' ) ) {
			require_once $file;
		} elseif ( is_file( $file = trailingslashit( dirname( plugin_dir_path( __FILE__ ) ) ) . 'includes/classes/admin/' . $file_name . '.php' ) ) {
			require_once $file;
		}

	}
}
