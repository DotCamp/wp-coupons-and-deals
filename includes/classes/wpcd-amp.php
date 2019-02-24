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
		'archive_not_temp'		=> 'amp_archive_not-temp.css',
		'archive_one'			=> 'amp_archive_one.css', 
		'archive_two'			=> 'amp_archive_two.css',
		'archive_three' 		=> 'amp_archive_three.css',
		'archive_seven' 		=> 'amp_archive_seven.css',
		'archive_eight'			=> 'amp_archive_eight.css',
		'archive_default'		=> 'amp_archive_default.css',
		'archive_common'		=> 'amp_archive_common.css',
		'shortcode_default' 	=> 'amp_shortcode_default.css',
		'shortcode_one'			=> 'amp_archive_one.css',
		'shortcode_two'			=> 'amp_archive_two.css',
		'shortcode_three'		=> 'amp_archive_three.css',
		'shortcode_four'		=> 'amp_shortcode_four.css',
		'shortcode_five'		=> 'amp_shortcode_five.css',
		'shortcode_six'			=> 'amp_shortcode_six.css',
		'shortcode_seven'		=> 'amp_archive_seven.css',
		'shortcode_eight'		=> 'amp_archive_eight.css',
		'shortcode_image'		=> 'amp_shortcode_image.css',
		'shortcode_common'		=> 'amp_shortcode_common.css',
	);

	/**
	 * This is css file pointer
	 *
	 * @var string
	 * @since 2.7.2
	 */
	private $css_file = 'not_temp';

	/**
	 * This is css code for print
	 *
	 * @var string
	 * @since 2.7.2
	 */
	private $styles = '';

	/**
	 * This is array have names of css files which was be used
	 *
	 * @var string
	 * @since 2.7.2
	 */
	private $used_css_files = array();
	
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
	public function setCss( $css_file, $is_file = true ) {
		if ( $is_file ) {
			if( ! empty($css_file)) {
				$this->css_file = $css_file;
			}
			if( in_array( $this->css_list[$this->css_file], $this->used_css_files ) ) {
				return;
			}
			$wpcd_asset_embed = $this->wpcd_asset_embed( WPCD_Plugin::instance()->plugin_assets . '/css/' . $this->css_list[$this->css_file] );
			$this->used_css_files[] = $this->css_list[$this->css_file];
		} else {
			if( in_array( 'user_stylesheets', $this->used_css_files ) ) {
				return;
			}
			$wpcd_asset_embed = $css_file;
			$this->used_css_files[] = 'user_stylesheets';
		}
		
		$this->styles .= $wpcd_asset_embed;
	}

	/**
	 * Getting CSS for amp pages
	 *
	 * @since 2.7.2
	 */
	public function wpcd_print_amp_styles() {
		echo $this->styles;
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
