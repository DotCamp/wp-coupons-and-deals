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
	 * @param boolean $prepend
	 *
	 * @since 1.0
	 *
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

		// easy autoload for premium only files, just adding Pro suffix to class name will make sure the file with the __premium_only suffix will be called. This will make sure we don't need to require premium files implicitly in the future
		if ( filter_var( preg_match( '/^.+(-pro)$/', $file_name ), FILTER_VALIDATE_BOOLEAN ) === true ) {
			$pro_file = $file_name . '__premium_only';
			if ( is_file( $file = trailingslashit( dirname( plugin_dir_path( __FILE__ ) ) ) . 'includes/classes/' . $pro_file . '.php' ) ) {
				require_once $file;
			} elseif ( is_file( $file = trailingslashit( dirname( plugin_dir_path( __FILE__ ) ) ) . 'includes/classes/admin/' . $pro_file . '.php' ) ) {
				require_once $file;
			}

		}

		if ( is_file( $file = trailingslashit( dirname( plugin_dir_path( __FILE__ ) ) ) . 'includes/classes/' . $file_name . '.php' ) ) {
			require_once $file;
		} elseif ( is_file( $file = trailingslashit( dirname( plugin_dir_path( __FILE__ ) ) ) . 'includes/classes/admin/' . $file_name . '.php' ) ) {
			require_once $file;
		}

	}
}
