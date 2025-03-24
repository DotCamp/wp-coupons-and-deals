<?php
/**
 * Upgrader skin for promotion install operations.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Utils;

use WP_Error;
use WP_Upgrader_Skin;
use function esc_html;

require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skin.php';

/**
 * Upgrader skin for promotion install operations.
 */
class PromotionUpgraderSkin extends WP_Upgrader_Skin {
	/**
	 * Errors array.
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Displays a message about the update.
	 *
	 * @param string $feedback Message data.
	 * @param mixed  ...$args Optional text replacements.
	 *
	 * @since 2.8.0
	 * @since 5.9.0 Renamed `$string` (a PHP reserved keyword) to `$feedback` for PHP 8 named parameter support.
	 */
	public function feedback( $feedback, ...$args ) {
		// Keep it quiet.
	}

	/**
	 * Displays an error message about the update.
	 *
	 * @param string|WP_Error $errors Errors.
	 *
	 * @since 2.8.0
	 */
	public function error( $errors ) {
		if ( is_wp_error( $errors ) && $errors->has_errors() ) {
			foreach ( $errors->get_error_messages() as $error_message ) {
				$this->errors[] = $error_message;
			}
		}
	}


	/**
	 * Action to perform following an update.
	 *
	 * @since 2.8.0
	 */
	public function after() {
		if ( count( $this->errors ) > 0 ) {
			header( 'Content-Type: text/plain-text' );

			echo esc_html( join( ',', $this->errors ) );
			die();
		}
	}

	/**
	 * Displays a form to the user to request for their FTP/SSH details in order
	 * to connect to the filesystem.
	 *
	 * @param bool|WP_Error $error Optional. Whether the current request has failed to connect,
	 *                                                    or an error object. Default false.
	 * @param string        $context Optional. Full path to the directory that is tested
	 *                                                           for being writable. Default empty.
	 * @param bool          $allow_relaxed_file_ownership Optional. Whether to allow Group/World writable. Default false.
	 *
	 * @return bool True on success, false on failure.
	 * @since 4.6.0 The `$context` parameter default changed from `false` to an empty string.
	 *
	 * @see request_filesystem_credentials()
	 *
	 * @since 2.8.0
	 */
	public function request_filesystem_credentials( $error = false, $context = '', $allow_relaxed_file_ownership = false ) {
		return true;
	}

	/**
	 * Displays the footer following the update process.
	 *
	 * @since 2.8.0
	 */
	public function footer() {
		// Keep it quiet.
	}

	/**
	 * Displays the header before the update process.
	 *
	 * @since 2.8.0
	 */
	public function header() {
		// Keep it quiet.
	}
}
