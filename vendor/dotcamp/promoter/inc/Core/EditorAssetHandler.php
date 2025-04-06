<?php
/**
 * Editor asset handler.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core;

use DotCamp\Promoter\Utils\PromoterAsset;
use function wp_enqueue_script;
use function wp_enqueue_style;
use function wp_localize_script;

/**
 * Editor asset handler.
 *
 * This class will be responsible for handling all fronted assets including registration, enqueue and localization operations.
 */
class EditorAssetHandler {
	/**
	 * Registered handlers.
	 *
	 * @var array
	 */
	private $registered_assets;
	/**
	 * Class constructor.
	 *
	 * @param Array<PromoterAsset> $promoter_assets Promoter assets.
	 */
	public function __construct( $promoter_assets ) {
		$this->registered_assets = $this->register_assets_to_handler( $promoter_assets );
	}

	/**
	 * Enqueue registered assets.
	 *
	 * @param string $asset_handler_name Asset handler name.
	 * @return bool Enqueue status.
	 */
	public function enqueue_registered_asset( $asset_handler_name ) {
		$target_asset = $this->registered_assets[ $asset_handler_name ];

		$enqueue_status = false;
		if ( isset( $target_asset ) ) {
			$asset_type    = $target_asset->asset_type;
			$handle_name   = $target_asset->handle_name;
			$asset_url     = $target_asset->asset_url;
			$asset_deps    = $target_asset->asset_deps;
			$asset_version = $target_asset->version;

			if ( PromoterAsset::TYPE_JS === $asset_type ) {
				wp_enqueue_script( $handle_name, $asset_url, $asset_deps, $asset_version, true );
			} elseif ( PromoterAsset::TYPE_CSS === $asset_type ) {
				wp_enqueue_style( $handle_name, $asset_url, $asset_deps, $asset_version );
			}

			$enqueue_status = true;
		}

		return $enqueue_status;
	}

	/**
	 * Get registered asset.
	 *
	 * @param string $asset_handler_name Asset handler name.
	 * @return PromoterAsset|null Registered asset, null if not found.
	 */
	public function get_registered_asset( $asset_handler_name ) {
		return $this->registered_assets[ $asset_handler_name ];
	}

	/**
	 * Add script data.
	 *
	 * @param string $script_handle Script handle.
	 * @param string $data_object_id Data object id.
	 * @param array  $data Data.
	 */
	public function add_script_data( $script_handle, $data_object_id, $data ) {
		$target_asset = $this->registered_assets[ $script_handle ];

		if ( isset( $target_asset ) ) {
			wp_localize_script( $script_handle, $data_object_id, $data );
		}
	}

	/**
	 * Register assets.
	 *
	 * @param Array<PromoterAsset> $promoter_assets Promoter assets.
	 *
	 * @return Array<PromoterAsset> Registered assets.
	 */
	private function register_assets_to_handler( $promoter_assets ) {
		$registered = array();
		foreach ( $promoter_assets as $promoter_asset ) {
			$asset_type  = $promoter_asset->asset_type;
			$handle_name = $promoter_asset->handle_name;

			if ( in_array( $asset_type, array( PromoterAsset::TYPE_JS, PromoterAsset::TYPE_CSS ), true ) ) {
				$registered[ $handle_name ] = $promoter_asset;
			}
		}

		return $registered;
	}
}
