<?php

/**
 * base class for hooking into WordPress ajax hooks
 * Class WPCD_Ajax_Base
 */
abstract class WPCD_Ajax_Base {
	use WPCD_Global_Caller_Trait;

	/**
	 * ajax hook name
	 * @var string
	 */
	public $ajax_call_name;
	public $response;

	/**
	 * WPCD_Ajax_Base constructor.
	 *
	 * @param string $ajax_call_name name of ajax hook
	 * @param bool $private nopriv
	 */
	public function __construct( $ajax_call_name, $private = false ) {
		$privPart             = $private === true ? '_' : '_nopriv_';
		$this->ajax_call_name = 'wp_ajax' . $privPart . $ajax_call_name;
		$this->response       = [];
	}

	/**
	 * add ajax to WordPress hook
	 * call this method inside WordPress init hook
	 */
	public function add() {
		$this->_c()->add_action( $this->ajax_call_name, array( $this, 'logic' ) );
	}

	/**
	 * set error to response object
	 *
	 * @param string $message error message
	 */
	public function setError( $message ) {
		$this->response['error'] = $message;
	}

	/**
	 * set key/value pairs to response object
	 *
	 * @param string $key key
	 * @param string $value value
	 */
	public function setData( $key, $value ) {

		$this->response[ $key ] = $value;
	}

	/**
	 * get response array
	 * @return array response array
	 */
	public function getResponse() {
		return $this->response;
	}


	/**
	 * get response as json encoded string
	 *
	 * @param bool $echo echo response
	 *
	 * @return false|string|void
	 */
	public function getResponseJSON( $echo = false ) {
		if ( $echo ) {
			echo json_encode( $this->getResponse() );

			return;
		} else {
			return json_encode( $this->getResponse() );
		}
	}


	/**
	 * main logic for processing incoming ajax request
	 * @return mixed
	 */
	abstract public function logic();
}