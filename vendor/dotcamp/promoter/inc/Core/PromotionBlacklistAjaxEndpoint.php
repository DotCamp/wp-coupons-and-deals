<?php
/**
 * Promotion blacklist ajax endpoint.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core;

use DotCamp\Promoter\Utils\AjaxEndpoint;
use function wp_send_json_success;

/**
 * Promotion blacklist ajax endpoint.
 *
 * This ajax endpoint will handle blacklist operations for selected promotions.
 */
class PromotionBlacklistAjaxEndpoint extends AjaxEndpoint {
	/**
	 * Promotion blacklist manager.
	 *
	 * @var PromotionBlacklistManager
	 * @private
	 */
	private $promotion_blacklist_manager;

	/**
	 * Class constructor.
	 *
	 * @param string                    $action_name Action name.
	 * @param PromotionBlacklistManager $promotion_blacklist_manager Promotion blacklist manager.
	 */
	public function __construct( $action_name, $promotion_blacklist_manager ) {
		$this->promotion_blacklist_manager = $promotion_blacklist_manager;
		parent::__construct( $action_name );
	}

	/**
	 * Required parameters for the endpoint.
	 *
	 * @return array Required parameters..
	 */
	public function required_paramaters() {
		return array( 'promotionTargetId', 'blockId' );
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
		$block_id         = $request_parameters['blockId'];
		$target_plugin_id = $request_parameters['promotionTargetId'];

		// Not using operation status result as it's not required with current setup.
		$this->promotion_blacklist_manager->add_to_blacklist( $block_id, $target_plugin_id );

		wp_send_json_success( array( 'message' => 'Promotion blacklisted successfully.' ) );
	}
}
