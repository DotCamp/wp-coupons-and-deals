<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shows the coupons templates and css for Amp pages
 *
 * @since 2.7.3
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
	 * @since 2.7.3
	 */
	private $css_list = array(
		'archive_not_temp'		=> 'amp_archive_not-temp',
		'archive_one'			=> 'amp_archive_one', 
		'archive_two'			=> 'amp_archive_two',
		'archive_three' 		=> 'amp_archive_three',
		'archive_seven' 		=> 'amp_archive_seven',
		'archive_eight'			=> 'amp_archive_eight',
		'archive_common'		=> 'amp_archive_common',
		'shortcode_default' 	=> 'amp_shortcode_default',
		'shortcode_one'			=> 'amp_archive_one',
		'shortcode_two'			=> 'amp_archive_two',
		'shortcode_three'		=> 'amp_archive_three',
		'shortcode_four'		=> 'amp_shortcode_four',
		'shortcode_five'		=> 'amp_shortcode_five',
		'shortcode_six'			=> 'amp_shortcode_six',
		'shortcode_seven'		=> 'amp_archive_seven',
		'shortcode_eight'		=> 'amp_archive_eight',
		'shortcode_image'		=> 'amp_shortcode_image',
		'shortcode_common'		=> 'amp_shortcode_common',
	);

	/**
	 * This is css file pointer
	 *
	 * @var string
	 * @since 2.7.3
	 */
	private $css_file = 'not_temp';

	/**
	 * This is css code for print
	 *
	 * @var string
	 * @since 2.7.3
	 */
	private $styles = array();

	/**
	 * This is array have names of css files which was be used
	 *
	 * @var string
	 * @since 2.7.3
	 */
	private $used_css_files = array();
	
	/**
	 * Singleton pattern, making only one instance of the class.
	 *
	 * @since 2.7.3
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
	 * @since 2.7.3
	 */
	private function __construct() {
		add_action( 'amp_post_template_css', array( $this,'wpcd_print_amp_styles' ) ); // AMP, Accelerated Mobile Pages
		add_action( 'amphtml_template_css', array( $this,'wpcd_print_amp_styles' ) ); // WP AMP
	}

	/**
	 * Setting parameters for choice of css file
	 *
	 * @since 2.7.3
	 */
	public function setCss( $css_file, $is_file = true ) {
		if ( $is_file ) {
			if( ! empty($css_file)) {
				$this->css_file = $css_file;
			}
			if( array_key_exists( $this->css_list[$this->css_file], $this->styles ) ) {
				return;
			}
			$wpcd_asset_embed = $this->wpcd_asset_embed( WPCD_Plugin::instance()->plugin_assets . 'css/' . WPCD_Assets::wpcd_version_correct( 'dir' ) . $this->css_list[$this->css_file] . WPCD_Assets::wpcd_version_correct( 'suffix' ) . '.css' );
			$this->styles[$this->css_list[$this->css_file]] = $wpcd_asset_embed;
		} else {
			if( array_key_exists( 'user_stylesheets', $this->styles ) ) {
				unset($this->styles['user_stylesheets']);
				$this->styles['user_stylesheets'] = $css_file;
			}
			$this->styles['user_stylesheets'] = $css_file;
		}
		
		
	}

	/**
	 * Getting CSS for amp pages
	 *
	 * @since 2.7.3
	 */
	public function wpcd_print_amp_styles() {
		foreach ( $this->styles as  $style ) {
			echo $style;
		}
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
