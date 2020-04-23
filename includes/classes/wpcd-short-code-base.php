<?php

/**
 * main class for short code operations
 * Class WPCD_Short_Code_Base
 */
abstract class WPCD_Short_Code_Base {
	use WPCD_Global_Caller_Trait;

	/**
	 * short-code name
	 * @var string
	 */
	protected $name;

	/**
	 * WPCD_Short_Code_Base constructor.
	 *
	 * [source-code note] short-codes are called in
	 * a function as a callback to WP init hook
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * function to bind short-code to WordPress
	 */
	public function add() {
		// add shortcode to WordPress hook
		$this->_c()->add_shortcode( $this->name, array( $this, 'logic' ) );

	}

	/**
	 * function to check if post has this shortcode or not
	 * @return mixed result of operation
	 */
	public function haveShortcode() {
		global $post;
		$content = $post->post_content;

		return ( filter_var( preg_match( '/.*(\[' . $this->name . '\]).*/', $content ), FILTER_VALIDATE_BOOLEAN ) );
	}

	/**
	 * main logic for short code
	 *
	 * @param $attrs shortcode attributes
	 *
	 * @return mixed short-code render string
	 */
	abstract public function logic( $attrs );
}