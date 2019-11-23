<?php

/**
 * Exception class for global caller
 * Class WPCD_Global_Error
 */
class WPCD_Global_Error extends Exception {
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
	public function __construct(Error $error) {
		$short_file =basename($error->file);

		$message = "[$short_file, line {$error->line}, col {$error->column}] {$error->getMessage()}";

		$this->error = $error;

		parent::__construct($message);
	}

	/**
	 * return base error object
	 * @return Error
	 */
	public function getErrorObject(  ) {
		return $this->error;
	}
}