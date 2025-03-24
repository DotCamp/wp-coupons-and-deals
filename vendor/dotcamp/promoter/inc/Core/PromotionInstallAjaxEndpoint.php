<?php
/**
 * Promotion install ajax endpoint.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core;

use DotCamp\Promoter\Utils\AjaxEndpoint;
use DotCamp\Promoter\Utils\PromotionUpgraderSkin;
use Plugin_Upgrader;
use function activate_plugin;
use function is_plugin_active;
use function is_wp_error;
use function plugins_api;
use function wp_send_json_error;
use function wp_send_json_success;

/**
 * Promotion install ajax endpoint.
 *
 * This ajax endpoint will handle install operations for selected promotions.
 */
class PromotionInstallAjaxEndpoint extends AjaxEndpoint {
	/**
	 * Promoter core instance.
	 *
	 * @var PromoterCore
	 */
	private $promoter_core_instance;

	/**
	 * Add promoter core instance for further usage.
	 *
	 * @param PromoterCore $promoter_core_instance Promoter core instance.
	 *
	 * @return void
	 */
	public function add_promoter_core_instance( $promoter_core_instance ) {
		$this->promoter_core_instance = $promoter_core_instance;
	}


	/**
	 * Required parameters for the endpoint.
	 *
	 * @return array Required parameters..
	 */
	public function required_paramaters() {
		return array( 'promotionTargetId' );
	}

	/**
	 * User capability required for the endpoint.
	 *
	 * @return string User capability.
	 */
	public function user_capability() {
		return 'manage_options';
	}

	/**
	 * Handle request.
	 *
	 * @param array $request_parameters Request parameters.
	 *
	 * @return void
	 */
	public function handle_request( $request_parameters ) {
		$promotion_target_id  = $request_parameters['promotionTargetId'];
		$available_promotions = $this->promoter_core_instance->get_available_promotions();

		$promotion = array_filter(
			$available_promotions,
			function ( $promotion ) use ( $promotion_target_id ) {
				return $promotion->promotion_target_id === $promotion_target_id;
			}
		);

		// Check if the promotion exists.
		if ( empty( $promotion ) ) {
			wp_send_json_error( array( 'message' => 'Promotion not found' ) );
		}

		// Check if the promotion is already installed.
		if ( is_plugin_active( $promotion_target_id ) ) {
			wp_send_json_error( array( 'message' => 'Promotion already installed' ) );
		}

		$promotion_slug = dirname( $promotion_target_id );

		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/misc.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$plugin_remote_info = plugins_api( 'plugin_information', array( 'slug' => $promotion_slug ) );

		$upgrader = new Plugin_Upgrader( new PromotionUpgraderSkin() );
		$status   = $upgrader->install( $plugin_remote_info->download_link );

		if ( is_wp_error( $status ) || ! $status ) {
			wp_send_json_error( array( 'message' => 'Failed to install promotion' ) );
		} else {
			activate_plugin( $promotion_target_id, '', false, true );
			wp_send_json_success( array( 'message' => 'Promotion installed successfully' ) );
		}
	}
}
