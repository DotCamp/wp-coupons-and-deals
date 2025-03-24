<?php
/**
 * Promoter main class.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter;

use DotCamp\Promoter\Core\EditorAssetHandler;
use DotCamp\Promoter\Core\LibraryPaths;
use DotCamp\Promoter\Core\PromoterCore;
use DotCamp\Promoter\Core\PromotionBlacklistManager;
use DotCamp\Promoter\Core\PromotionManager;
use DotCamp\Promoter\Core\Registry;
use DotCamp\Promoter\Utils\ArrayConfiguration;
use DotCamp\Promoter\Utils\PromoterAsset;
use DotCamp\Promoter\Core\PromotionBlacklistAjaxEndpoint;
use DotCamp\Promoter\Utils\AjaxEndpoint;
use DotCamp\Promoter\Core\PromotionInstallAjaxEndpoint;

/**
 * Promoter bootstrap class.
 *
 * This class will be responsible for initializing the library.
 */
class Promoter {
	/**
	 * Library paths.
	 *
	 * @var LibraryPaths
	 * @private
	 */
	private $library_paths;

	/**
	 * Registry.
	 *
	 * @var Registry
	 * @private
	 */
	private $registry;

	/**
	 * Asset handler.
	 *
	 * @var EditorAssetHandler
	 * @private
	 */
	private $asset_handler;

	/**
	 * Promoter core instance.
	 *
	 * @var PromoterCore
	 * @private
	 */
	private $promoter_core_instance;

	/**
	 * Promoter instance.
	 *
	 * @var Promoter
	 * @private
	 */
	public static $promoter_instance;

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
	 * @param string                       $plugin_file Path to the main plugin file.
	 * @param Array<Promotion> | Promotion $promotions Promotions.
	 */
	private function __construct( $plugin_file, $promotions ) {
		// Initialize core components of library.
		$this->initialize_library( $plugin_file );

		// Generate ajax endpoints.
		$ajax_endpoints = $this->generate_ajax_endpoints();

		// Promotion manager initialization.
		$promotion_manager = new PromotionManager( $promotions );

		// Promoter core initialization.
		$this->promoter_core_instance = new PromoterCore( $promotion_manager, $this->registry->get_config( 'frontend.editor_script.handle' ), $this->asset_handler, $this->registry->get_config( 'frontend.editor_styles.handle' ), $ajax_endpoints['blacklist'], $ajax_endpoints['install'], $this->promotion_blacklist_manager );

		// Add promoter core instance to the installation endpoint.
		$ajax_endpoints['install']->add_promoter_core_instance( $this->promoter_core_instance );
	}

	/**
	 * Generate default promotions.
	 *
	 * @param string $plugin_file Path to the main plugin file.
	 * @param string $promoter_plugin_name Promoter plugin name.
	 * @param string $promoter_plugin_id Promoter plugin id.
	 *
	 * @return Array<Promotion> Default promotions.
	 */
	public static function generate_default_promotions( $plugin_file, $promoter_plugin_name, $promoter_plugin_id ) {
		$promoter_instance       = self::get_instance( $plugin_file );
		$default_promotions_data = require $promoter_instance->library_paths->dir_path( 'inc/Config/config_default_promotions.php' );

		return array_reduce(
			$default_promotions_data,
			function ( $carry, $current ) use ( $promoter_plugin_name, $promoter_plugin_id ) {
				$carry[] = new Promotion( $promoter_plugin_name, $promoter_plugin_id, $current['plugin_name'], $current['plugin_id'], $current['description'], $current['blocks_to_use'], $current['link_href'], $current['link_label'] );
				return $carry;
			},
			array()
		);
	}

	/**
	 * Get instance.
	 *
	 * @param string $plugin_file Path to the main plugin file.
	 *
	 * @return Promoter Promoter instance.
	 */
	public static function get_instance( $plugin_file ) {
		if ( ! isset( self::$promoter_instance ) ) {
			self::$promoter_instance = new Promoter( $plugin_file, array() );
		}
		return self::$promoter_instance;
	}

	/**
	 * Add promotions.
	 *
	 * @param Array<Promotion> | Promotion $promotions Promotions to add.
	 * @param string                       $plugin_file Path to the main plugin file.
	 */
	public static function add_promotions( $promotions, $plugin_file ) {
		$instance = self::get_instance( $plugin_file );
		$instance->add_new_promotions( is_array( $promotions ) ? $promotions : array( $promotions ) );
	}

	/**
	 * Add new promotions.
	 *
	 * @param Array<Promotion> $new_promotions New promotions.
	 */
	private function add_new_promotions( $new_promotions ) {
		if ( isset( $this->promoter_core_instance ) ) {
			$this->promoter_core_instance->add_promotions( $new_promotions );
		}
	}

	/**
	 * Generate ajax endpoints.
	 *
	 * @return Array<AjaxEndpoint> Generated ajax endpoints.
	 */
	private function generate_ajax_endpoints() {
		$blacklist_endpoint = new PromotionBlacklistAjaxEndpoint( $this->registry->get_config( 'ajax.promotion_black_list.action' ), $this->promotion_blacklist_manager );

		$install_endpoint = new PromotionInstallAjaxEndpoint( $this->registry->get_config( 'ajax.promotion_install.action' ) );

		return array(
			'blacklist' => $blacklist_endpoint,
			'install'   => $install_endpoint,
		);
	}

	/**
	 * Initialize the library.
	 *
	 * @param string $plugin_file Path to the main plugin file.
	 */
	private function initialize_library( $plugin_file ) {
		$this->library_paths               = $this->initialize_library_paths( $plugin_file );
		$this->registry                    = $this->initialize_registry();
		$this->asset_handler               = $this->initialize_asset_handler();
		$this->promotion_blacklist_manager = new PromotionBlacklistManager( $this->registry->get_config( 'ajax.promotion_black_list.option_id' ) );
	}

	/**
	 * Initialize the asset handler.
	 *
	 * This function will initialize the asset handler which will handle all js and css
	 * files for frontend.
	 */
	private function initialize_asset_handler() {
		$editor_core_script_config        = $this->registry->get_config( 'frontend.editor_script' );
		$editor_core_script_relative_path = $editor_core_script_config['path'];
		$editor_core_script_deps          = require $this->library_paths->dir_path( $editor_core_script_config['deps'] );

		// Main editor script asset.
		$editor_core_script_asset = new PromoterAsset(
			$this->library_paths->dir_path( $editor_core_script_relative_path ),
			$this->library_paths->url_path( $editor_core_script_relative_path ),
			$editor_core_script_config['handle'],
			$editor_core_script_deps['dependencies'],
			$editor_core_script_deps['version']
		);

		$editor_core_style_config = $this->registry->get_config( 'frontend.editor_styles' );
		$editor_core_style_asset  = new PromoterAsset(
			$this->library_paths->dir_path( $editor_core_style_config['path'] ),
			$this->library_paths->url_path( $editor_core_style_config['path'] ),
			$editor_core_style_config['handle'],
			array()
		);

		return new EditorAssetHandler( array( $editor_core_script_asset, $editor_core_style_asset ) );
	}

	/**
	 * Initialize the library paths.
	 *
	 * @param string $plugin_file Path to the main plugin file.
	 *
	 * @return LibraryPaths Initialized library paths.
	 */
	private function initialize_library_paths( $plugin_file ) {
		// Since our entry point is not in the root of the library, we need to calculate it.
		$library_abs_root_path = dirname( __DIR__ );

		return new LibraryPaths( $plugin_file, $library_abs_root_path );
	}

	/**
	 * Initialize registry.
	 *
	 * @return Registry Initialized registry.
	 */
	private function initialize_registry() {
		$core_configs = require $this->library_paths->dir_path( 'inc/Config/config_core.php' );

		return new Registry( new ArrayConfiguration( $core_configs ) );
	}
}
