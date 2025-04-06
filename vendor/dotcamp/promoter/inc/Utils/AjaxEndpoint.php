<?php
/**
 * Ajax endpoint class.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Utils;

use function add_action;
use function check_ajax_referer;
use function current_user_can;
use function get_admin_url;
use function sanitize_text_field;
use function wp_create_nonce;
use function wp_send_json_error;

/**
 * Ajax endpoint class.
 */
abstract class AjaxEndpoint {
	/**
	 * Action name.
	 *
	 * @var string
	 * @private
	 */
	private $action_name;

	/**
	 * Class constructor.
	 *
	 * @param string $action_name Action name.
	 */
	public function __construct( $action_name ) {
		$this->action_name = $action_name;
	}

	/**
	 * Initialize endpoint.
	 *
	 * @return void
	 */
	public function initialize_endpoint() {
		add_action( 'wp_ajax_' . $this->get_action_name(), array( $this, 'handle_request_main' ) );
	}

	/**
	 * Handle main request.
	 *
	 * This is the main entry point for the incoming ajax requests.
	 *
	 * @return void
	 */
	public function handle_request_main() {
		if ( $this->check_referrer() ) {
			// phpcs:ignore
			if ( $this->check_required_params( $_REQUEST ) ) {
				// phpcs:ignore
				$this->handle_request( $this->sanitize_parameters( $_REQUEST ) );
			} else {
				wp_send_json_error(
					array(
						'message' => 'Missing required request parameters.',
					)
				);

			}
		} else {
			wp_send_json_error(
				array(
					'message' => 'You are not authorized to use this endpoint.',
				)
			);
		}
	}

	/**
	 * Sanitize parameters.
	 *
	 * This function will only send back the required parameters and sanitize them.
	 *
	 * @param array $request Request.
	 *
	 * @return array Sanitized parameters.
	 */
	private function sanitize_parameters( $request ) {
		$required_params = $this->required_paramaters();

		return array_reduce(
			$required_params,
			function ( $carry, $param ) use ( $request ) {
				$carry[ $param ] = sanitize_text_field( $request[ $param ] );

				return $carry;
			},
			array()
		);
	}

	/**
	 * Check required parameters.
	 *
	 * @param array $request Request.
	 *
	 * @return bool True if all required parameters are present, false otherwise.
	 */
	private function check_required_params( $request ) {
		$required_params = $this->required_paramaters();

		foreach ( $required_params as $param ) {
			if ( ! isset( $request[ $param ] ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check ajax requests referrer.
	 *
	 * @return bool True if referrer is valid, false otherwise.
	 */
	private function check_referrer() {
		return current_user_can( $this->user_capability() ) && check_ajax_referer( $this->get_action_name(), false, false );
	}

	/**
	 * Get ajax action name.
	 *
	 * @return string Action name.
	 */
	public function get_action_name() {
		return $this->action_name;
	}

	/**
	 * Generate nonce.
	 *
	 * @return string Nonce.
	 */
	public function generate_nonce() {
		return wp_create_nonce( $this->get_action_name() );
	}

	/**
	 * Get ajax url.
	 *
	 * @return string Ajax url.
	 */
	public function get_ajax_url() {
		return get_admin_url( null, 'admin-ajax.php' );
	}

	/**
	 * Required parameters for the endpoint.
	 *
	 * @return array Required parameters..
	 */
	abstract public function required_paramaters();

	/**
	 * User capability required for the endpoint.
	 *
	 * @return string User capability.
	 */
	abstract public function user_capability();

	/**
	 * Handle request.
	 *
	 * @param array $request_parameters Request parameters.
	 *
	 * @return void
	 */
	abstract public function handle_request( $request_parameters );
}
