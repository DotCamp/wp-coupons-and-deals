<?php
/**
 * Array configuration reader class.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Utils;

use DotCamp\Promoter\Core\Interfaces\IConfig;

/**
 * Configuration reader class.
 *
 * This class is used to read configuration values from supplied configuration arrays.
 */
class ArrayConfiguration implements IConfig {
	/**
	 * Configuration array.
	 *
	 * @var array
	 * @private
	 */
	private $config_array;

	/**
	 * Class constructor.
	 *
	 * @param array $config_array Configuration array.
	 */
	public function __construct( $config_array ) {
		$this->config_array = $config_array;
	}

	/**
	 * Parse configuration address.
	 *
	 * Configuration address is a string that represents a path to a configuration value
	 * with each part separated by a dot.
	 *
	 * @param string $config_addr Configuration address.
	 *
	 * @return array Configuration address parts.
	 */
	public function parse_config_address( $config_addr ) {
		return explode( '.', $config_addr );
	}

	/**
	 * Get configuration value.
	 *
	 * @param string $config_name Configuration name.
	 *
	 * @return mixed Configuration value.
	 */
	public function get_config( $config_name ) {
		$return_value = $this->config_array;
		if ( isset( $this->config_array ) ) {
			$address_parts = $this->parse_config_address( $config_name );
			foreach ( $address_parts as $part ) {
				if ( isset( $return_value[ $part ] ) ) {
					$return_value = $return_value[ $part ];
				} else {
					$return_value = null;
					break;
				}
			}
		}

		return $return_value;
	}

	/**
	 * Set configuration value.
	 *
	 * This method is not supported for array configuration update operations.
	 *
	 * @param string $config_name Configuration name.
	 * @param mixed  $config_value Configuration value.
	 *
	 * @return boolean True if the configuration value was set, false otherwise.
	 */
	public function set_config( $config_name, $config_value ) {
		return false;
	}
}
