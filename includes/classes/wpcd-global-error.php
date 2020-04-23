<?php

/**
 * Exception class for global caller
 * Class WPCD_Global_Error
 */
class WPCD_Global_Error extends BadMethodCallException {
	/**
	 * original error object
	 * @var Error
	 */
	private $error;

	/**
	 * WPCD_Global_Error constructor.
	 *
	 * @param $error
	 */
	public function __construct( $message ) {
		$this->error = $this->getErrorObject();
		$short_file  = basename( $this->getFile() );
		$message     = "[$short_file, line {$this->getLine()}] $message";
		parent::__construct( $message );
	}

	/**
	 * return base error object
	 * @return Error
	 */
	public function getErrorObject() {
		return $this->error;
	}
}