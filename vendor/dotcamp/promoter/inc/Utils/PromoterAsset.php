<?php
/**
 * Asset base class.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Utils;

/**
 * Asset base class.
 *
 * This class will be responsible for all js and css asset information.
 */
class PromoterAsset {
	/**
	 * Asset javascript type.
	 */
	const TYPE_JS = 'js';

	/**
	 * Asset css type.
	 */
	const TYPE_CSS = 'css';

	/**
	 * Asset path.
	 *
	 * @var string
	 */
	public $asset_path;

	/**
	 * Asset url address.
	 *
	 * @var string
	 */
	public $asset_url;

	/**
	 * Asset handle name.
	 *
	 * @var string
	 */
	public $handle_name;


	/**
	 * Asset dependencies.
	 *
	 * @var array
	 */
	public $asset_deps;

	/**
	 * Asset type.
	 *
	 * @var string
	 */
	public $asset_type;

	/**
	 * Asset version.
	 *
	 * @var string
	 */
	public $version;

	/**
	 * AssetBase constructor.
	 *
	 * @param string      $asset_path Asset path relative to plugin root.
	 * @param string      $asset_url Asset url address.
	 * @param string|null $handle_name Asset handle name, null to use file name.
	 * @param array       $asset_deps Asset dependencies.
	 * @param string|null $version Asset version, null to use file modified time.
	 */
	public function __construct( $asset_path, $asset_url, $handle_name, $asset_deps = array(), $version = null ) {
		$this->asset_path  = $asset_path;
		$this->asset_url   = $asset_url;
		$this->asset_deps  = $asset_deps;
		$this->handle_name = $handle_name;
		$this->version     = $version ?? filemtime( $asset_path );
		$this->asset_type  = $this->find_asset_type( $this->asset_path );
	}


	/**
	 * Find asset type of given asset path.
	 *
	 * @param string $asset_path Asset path.
	 *
	 * @return string Asset type. Return value is one of the defined type constants in this class.
	 */
	private function find_asset_type( $asset_path ) {
		$parsed_path_info = pathinfo( $asset_path );

		switch ( $parsed_path_info['extension'] ) {
			case 'css':
				return self::TYPE_CSS;
			default:
				return self::TYPE_JS;
		}
	}
}
