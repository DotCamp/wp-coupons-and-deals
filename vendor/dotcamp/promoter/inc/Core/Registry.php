<?php
/**
 * Registry class.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core;

use DotCamp\Promoter\Core\Interfaces\IConfig;

/**
 * Registry class.
 *
 * This class is used to read configuration values.
 */
class Registry {
	/**
	 * Configuration arrays.
	 *
	 * @var Array<IConfig>
	 * @private
	 */
	private $array_configurations;

	/**
	 * Class constructor.
	 *
	 * @param Array<IConfig>|IConfig $array_configurations Configuration arrays.
	 */
	public function __construct( $array_configurations ) {
		$this->array_configurations = $this->check_array_configurations( $array_configurations );
	}

	/**
	 * Check compatibility of configuration arrays.
	 *
	 * @param Array<IConfig>|IConfig $array_configurations Configuration array(s).
	 *
	 * @return Array<IConfig>|array() Passed configurations.
	 */
	public function check_array_configurations( $array_configurations ) {
		$unregistered_configurations = $array_configurations;
		if ( ! is_array( $array_configurations ) ) {
			$unregistered_configurations = array( $unregistered_configurations );
		}

		$unregistered_configurations = array_filter(
			$unregistered_configurations,
			function ( $configuration ) {
				return $configuration instanceof IConfig;
			}
		);

		return $unregistered_configurations;
	}

	/**
	 * Get configuration value.
	 *
	 * @param string $config_key Configuration key.
	 *
	 * @return mixed Configuration value.
	 */
	public function get_config( $config_key ) {
		$return_value = null;

		foreach ( $this->array_configurations as $configuration ) {
			$return_value = $configuration->get_config( $config_key );
			if ( isset( $return_value ) ) {
				break;
			}
		}

		return $return_value;
	}
}
