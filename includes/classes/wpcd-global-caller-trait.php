<?php
/**
 * trait object for easy implementing global caller to classes
 * Trait GlobalCaller
 */
trait WPCD_Global_Caller_Trait {

	/**
	 * stored global caller object
	 * @var object
	 */
	private $caller;

	/**
	 * get stored global caller
	 *
	 * set it up automatically if not defined
	 * shortened the function name for quick access
	 *
	 * @return object
	 */
	public function _c() {
		if ( ! isset( $this->caller ) ) {
			$this->setCaller( new WPCD_Global_Caller() );
		}
		return $this->caller;
	}

	/**
	 * set stored global caller object
	 * perfect function to test stubs and mocks
	 *
	 * @param WPCD_Global_Caller $wpc
	 */
	public function setCaller( $wpc ) {
		$this->caller = $wpc;
	}
}