<?php
/**
 * LibraryPaths class.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core;

use function plugin_dir_path;
use function plugin_dir_url;

/**
 * LibraryPaths class.
 *
 * Class for managing library paths.
 */
class LibraryPaths {
	/**
	 * Path to library root as relative to the plugin file.
	 *
	 * @var string
	 */
	private $library_root_relative_path;

	/**
	 * Plugin directory path.
	 *
	 * @var string
	 */
	private $plugin_dir_path_cached;

	/**
	 * Plugin URL path.
	 *
	 * @var string
	 */
	private $plugin_url_path_cached;

	/**
	 * Class constructor.
	 *
	 * @param string $plugin_file Path to the main plugin file.
	 * @param string $library_root_path Path to the library root directory.
	 */
	public function __construct( $plugin_file, $library_root_path ) {
		$this->plugin_dir_path_cached     = plugin_dir_path( $plugin_file );
		$this->plugin_url_path_cached     = plugin_dir_url( $plugin_file );
		$this->library_root_relative_path = $this->find_library_root_relative_path( $this->plugin_dir_path_cached, $library_root_path );
	}

	/**
	 * Find the library root relative path.
	 *
	 * This function will find relative path of the library root to the plugin file.
	 *
	 * @param string $plugin_dir_path Plugin directory path.
	 *
	 * @param string $library_root_path Library root path.
	 *
	 * @return string Library root relative path.
	 */
	public function find_library_root_relative_path( $plugin_dir_path, $library_root_path ) {
		return str_replace( $plugin_dir_path, '', $library_root_path );
	}

	/**
	 * Library directory path.
	 *
	 * @param string $target_library_path Target library path relative to library root.
	 *
	 * @return string Absolute directory path.
	 */
	public function dir_path( $target_library_path ) {
		return trailingslashit( $this->plugin_dir_path_cached ) . trailingslashit( ltrim( $this->library_root_relative_path, '/' ) ) . ltrim( $target_library_path, '/' );
	}

	/**
	 * Library URL path.
	 *
	 * @param string $target_library_path Target library path relative to library root.
	 *
	 * @return string Absolute URL path.
	 */
	public function url_path( $target_library_path ) {
		return trailingslashit( $this->plugin_url_path_cached ) . trailingslashit( ltrim( $this->library_root_relative_path, '/' ) ) . ltrim( $target_library_path, '/' );
	}
}
