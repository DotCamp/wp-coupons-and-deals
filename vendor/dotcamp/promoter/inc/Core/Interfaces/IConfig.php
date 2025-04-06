<?php
/**
 * Configuration interface.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core\Interfaces;

/**
 * Configuration interface.
 *
 * This interface is used to define various configuration data.
 */
interface IConfig {
	/**
	 * Get configuration value.
	 *
	 * @param string $config_name Configuration name.
	 *
	 * @return mixed Configuration value.
	 */
	public function get_config( $config_name );

	/**
	 * Set configuration value.
	 *
	 * @param string $config_name  Configuration name.
	 * @param mixed  $config_value Configuration value.
	 *
	 * @return boolean True if the configuration value was set, false otherwise.
	 */
	public function set_config( $config_name, $config_value );
}
