<?php

/**
 * proxy class for WordPress global function caller
 * Class WPCD_Global_Caller
 */
class WPCD_Global_Caller {

	/**
	 * magic method for undefined variables
	 *
	 * with this method, we can call the global namespaces
	 * variables in a secure way
	 * also from now on can test functionality with global
	 * variables used in (especially with WordPress and its
	 * hell of globals)
	 *
	 * @param $name variable name
	 *
	 * @return mixed|null
	 */
	public function __get( $name ) {
		if(isset($GLOBALS[$name])){
			return $GLOBALS[$name];
		}
		return null;
	}

	/**
	 * magic method for  undefined functions
	 *
	 * this method will enable us to call global WordPress methods
	 * and will open possibilities for our WP code to be tested
	 *
	 * @param $name function name
	 * @param $arguments an argument array
	 *
	 * @return mixed
	 * @throws WPCD_Global_Error
	 */
	public function __call( $name, $arguments ) {
		try {
			return \call_user_func_array( $name, $arguments );
		} catch ( Exception $e ) {
			throw new WPCD_Global_Error( "function '$name' does not exist in global scope" );
		}
	}
}