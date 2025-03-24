<?php
/**
 * Promoter core class.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core;

use DotCamp\Promoter\Promotion;
use DotCamp\Promoter\Utils\AjaxEndpoint;
use function add_action;
use function esc_html;
use function esc_url;

/**
 * Promoter core class.
 */
class PromoterCore {
	/**
	 * Editor script handle name.
	 *
	 * @var string
	 * @private
	 */
	private $editor_script_handle_name;

	/**
	 * Editor asset handler.
	 *
	 * @var EditorAssetHandler
	 * @private
	 */
	private $editor_asset_handler;

	/**
	 * Promotion manager instance.
	 *
	 * @var PromotionManager
	 */
	private $promotion_manager;

	/**
	 * Editor data object id.
	 *
	 * @var string
	 * @private
	 */
	private $editor_data_object_id = 'dotcampPromoterEditorData';

	/**
	 * Editor styles handle name.
	 *
	 * @var string
	 * @private
	 */
	private $editor_styles_handle_name;

	/**
	 * Blacklist ajax endpoint.
	 *
	 * @var AjaxEndpoint
	 * @private
	 */
	private $blacklist_ajax_endpoint;

	/**
	 * Install ajax endpoint.
	 *
	 * @var AjaxEndpoint
	 * @private
	 */
	private $install_ajax_endpoint;

	/**
	 * Blacklist manager.
	 *
	 * @var PromotionBlacklistManager
	 * @private
	 */
	private $blacklist_manager;

	/**
	 * Class constructor.
	 *
	 * @param PromotionManager          $promotion_manager Promotion manager.
	 * @param string                    $editor_script_handle_name Editor script handle name.
	 * @param EditorAssetHandler        $editor_asset_handler Editor asset handler.
	 * @param string                    $editor_styles_handle_name Editor styles handle name.
	 * @param AjaxEndpoint              $blacklist_ajax_endpoint Blacklist ajax endpoint.
	 * @param AjaxEndpoint              $install_ajax_endpoint Promotion install ajax endpoint.
	 * @param PromotionBlacklistManager $blacklist_manager Blacklist manager.
	 */
	public function __construct( $promotion_manager, $editor_script_handle_name, $editor_asset_handler, $editor_styles_handle_name, $blacklist_ajax_endpoint, $install_ajax_endpoint, $blacklist_manager ) {
		$this->promotion_manager         = $promotion_manager;
		$this->editor_script_handle_name = $editor_script_handle_name;
		$this->editor_styles_handle_name = $editor_styles_handle_name;
		$this->editor_asset_handler      = $editor_asset_handler;
		$this->blacklist_ajax_endpoint   = $blacklist_ajax_endpoint;
		$this->install_ajax_endpoint     = $install_ajax_endpoint;
		$this->blacklist_manager         = $blacklist_manager;

		$this->initialize_ajax_endpoints();

		add_action( 'enqueue_block_editor_assets', array( $this, 'editor_assets' ) );
	}

	/**
	 * Add new promotions.
	 *
	 * @param Array<Promotion> $new_promotions New promotions to add.
	 */
	public function add_promotions( $new_promotions ) {
		$this->promotion_manager->add_promotions( $new_promotions );
	}

	/**
	 * Get available promotions.
	 *
	 * @return Array<Promotion> Available promotions.
	 */
	public function get_available_promotions() {
		return $this->promotion_manager->get_available_promotions();
	}

	/**
	 * Initialize ajax endpoints.
	 *
	 * @return void
	 */
	private function initialize_ajax_endpoints() {
		$this->blacklist_ajax_endpoint->initialize_endpoint();
		$this->install_ajax_endpoint->initialize_endpoint();
	}

	/**
	 * Set editor related data for scripts.
	 *
	 * @return array Editor data.
	 */
	private function prepare_editor_data() {
		// Prepare promotions data for frontend.
		$promotions_data = array_reduce(
			$this->promotion_manager->get_available_promotions(),
			function ( $data, $promotion ) {
				$link_href = $promotion->link_href;

				$data[] = array(
					'promoterPluginId'  => esc_html( $promotion->promoter_plugin_id ),
					'promoterPlugin'    => esc_html( $promotion->promoter_plugin_name ),
					'promotionTarget'   => esc_html( $promotion->promotion_target_name ),
					'promotionTargetId' => esc_html( $promotion->promotion_target_id ),
					'description'       => esc_html( $promotion->description ),
					'blocksToUse'       => array_map( 'esc_html', $promotion->blocks_to_use ),
					'linkHref'          => is_null( $link_href ) ? $link_href : esc_url( $promotion->link_href ),
					'linkLabel'         => esc_html( $promotion->link_label ),
				);

				return $data;
			},
			array()
		);

		// Prepare ajax data for frontend.
		$ajax_data = array(
			'blacklist' => array(
				'action' => $this->blacklist_ajax_endpoint->get_action_name(),
				'nonce'  => $this->blacklist_ajax_endpoint->generate_nonce(),
				'url'    => $this->blacklist_ajax_endpoint->get_ajax_url(),
			),
			'install'   => array(
				'action' => $this->install_ajax_endpoint->get_action_name(),
				'nonce'  => $this->install_ajax_endpoint->generate_nonce(),
				'url'    => $this->install_ajax_endpoint->get_ajax_url(),
			),
		);

		// Prepare blacklist data for frontend.
		$blacklist      = $this->blacklist_manager->get_blacklist();
		$blacklist_data = array_reduce(
			$blacklist->get_blacklist_items(),
			function ( $data, $blacklist_item ) {
				$data[] = array(
					'blockId'           => $blacklist_item->block_id,
					'promotionPluginId' => $blacklist_item->promotion_plugin_id,
				);

				return $data;
			},
			array()
		);

		return array(
			'promotions' => $promotions_data,
			'ajax'       => $ajax_data,
			'blacklist'  => $blacklist_data,
		);
	}

	/**
	 * Enqueue editor assets.
	 */
	public function editor_assets() {
		if ( current_user_can( 'manage_options' ) ) {
			$this->editor_asset_handler->enqueue_registered_asset( $this->editor_script_handle_name );
			$this->editor_asset_handler->enqueue_registered_asset( $this->editor_styles_handle_name );
			$this->editor_asset_handler->add_script_data( $this->editor_script_handle_name, $this->editor_data_object_id, $this->prepare_editor_data() );
		}
	}
}
