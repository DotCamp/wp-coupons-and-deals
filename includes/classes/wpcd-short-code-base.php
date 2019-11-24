<?php

/**
 * main class for short code operations
 * Class WPCD_Short_Code_Base
 */
class WPCD_Short_Code_Base {
	use WPCD_Global_Caller_Trait;

	/**
	 * WPCD_Short_Code_Base constructor.
	 *
	 * [source-code note] shortcodes are called in
	 * a function as a callback to WP init hook
	 */
	public function __construct( string $name, \Closure $callback ) {
		$this->_c()->add_shortcode( $name, $callback );
	}

}