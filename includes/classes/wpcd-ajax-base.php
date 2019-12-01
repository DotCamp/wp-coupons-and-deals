<?php
/**
 * base class for hooking into WordPress ajax hooks
 * Class WPCD_Ajax_Base
 */
abstract class WPCD_Ajax_Base  {
	use WPCD_Global_Caller_Trait;

	/**
	 * ajax hook name
	 * @var string
	 */
	public $ajax_call_name;

	/**
	 * WPCD_Ajax_Base constructor.
	 *
	 * @param string $ajax_call_name name of ajax hook
	 * @param bool $private nopriv
	 */
	public function __construct( $ajax_call_name , $private = false ) {
		$privPart = $private === true? '_' : '_nopriv_';
		$this->ajax_call_name = 'wp_ajax' . $privPart . $ajax_call_name;
	}

	/**
	 * add ajax to WordPress hook
	 * call this method inside WordPress init hook
	 */
	public function add(){
		$this->_c()->add_action($this->ajax_call_name, array($this, 'logic'));
	}

	/**
	 * main logic for processing incoming ajax request
	 * @return mixed
	 */
	abstract public function logic();
}