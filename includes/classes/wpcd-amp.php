<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shows the coupons templates and css for Amp pages
 *
 * @since 2.0
 */
class WPCD_Amp {

	/**
	 * Instance to instantiate object.
	 *
	 * @var $instance
	 */
	protected static $instance;

	/**
	 * This is css list for amp template.
	 *
	 * @var string
	 * @since 2.7.2
	 */
	private $css_list = array(
		'archive'	=> array(
			'not_temp'	=> 'amp_archive_not-temp.css',
			'one'		=> 'amp_archive_one.css', 
			'two'		=> '',
			'three' 	=> '',
			'seven' 	=> '',
			'eight'		=> '',
			'default'	=> '',
		),
		'category' 	=> array(

		),
	);

	/**
	 * This is css file pointer
	 *
	 * @var string
	 * @since 2.7.2
	 */
	private $css_file = array('archive', 'not_temp');
	
	/**
	 * Singleton pattern, making only one instance of the class.
	 *
	 * @since 2.7.2
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			$className      = __CLASS__;
			self::$instance = new $className;
		}

		return self::$instance;
	}

	/**
	 * Class construct method.
	 *
	 * @since 2.7.2
	 */
	private function __construct() {
		add_action( 'amp_post_template_css', array( $this,'wpcd_print_amp_styles' ) ); // AMP, Accelerated Mobile Pages
		add_action( 'amphtml_template_css', array( $this,'wpcd_print_amp_styles' ) ); // WP AMP
	}

	/**
	 * Setting parameters for choice of css file
	 *
	 * @since 2.7.2
	 */
	public function setCssFile(array $css_file) {
		$this->css_file = $css_file;
	}

	/**
	 * Getting CSS for amp pages
	 *
	 * @since 2.7.2
	 */
	public function wpcd_print_amp_styles() {
		$wpcd_asset_embed = $this->wpcd_asset_embed( WPCD_Plugin::instance()->plugin_assets . '/css/' . $this->css_list[$this->css_file[0]][$this->css_file[1]] );
		echo $wpcd_asset_embed;
	}



	/**
	 * Embed AMP styles
	 *
	 * @param $file
	 *
	 * @return mixed|string
	 */
	public function wpcd_asset_embed( $file ) {

		$response = wp_remote_get( $file );

		if ( ! is_array( $response ) || ! isset( $response['body'] ) ) {
			return '';
		}

		$content = $response['body'];

		return $content;
	}

	/**
	 * Check activiti AMP page
	 *
	 * @return bool
	 */
	public static function wpcd_amp_is() {
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			return true;
		}
		if ( function_exists( 'is_wp_amp' ) && is_wp_amp() ) {
			return true;
		}
		return false;
	}

}
