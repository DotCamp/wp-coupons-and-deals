<?php

/**
 * test autoloader class
 * Class TestAutoloader
 */
class TestAutoloader {

	/**
	 * class instance
	 * @var
	 */
	private static $instance;

	/**
	 * relative path operator to project class files
	 * @var
	 */
	public $relative;

	/**
	 * get singleton class instance
	 * @return mixed class instance
	 */
	public static function getInstance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new self;
		}

		return static::$instance;
	}

	/**
	 * register autoloader
	 *
	 * @param string $relative relative path operator
	 */
	public function register( string $relative ) {
		$this->relative = $relative;
		spl_autoload_register( [ $this, 'autoload' ], true );
	}


	/**
	 * autoload callback
	 *
	 * @param $class class name
	 *
	 * @return bool|void load operation result
	 */
	public function autoload( $class ) {
		if ( filter_var( preg_match( '/^WPCD_.+/', $class ), FILTER_VALIDATE_BOOLEAN ) === false ) {
			return;
		}

		$file_base = str_replace( '_', '-', strtolower( $class ) );

		if(filter_var(preg_match('/^.+(-pro)$/', $file_base),FILTER_VALIDATE_BOOLEAN)){
			$file_name = $file_base . '__premium_only.php';

		}else{
			$file_name = $file_base . '.php';
		}

		$normal_path = __DIR__ . $this->relative . 'includes/classes/' . $file_name;
		$admin_path  = __DIR__ . $this->relative . 'includes/classes/admin/' . $file_name;

		if ( is_file( $normal_path ) ) {
			require_once( $normal_path );

			return true;
		} elseif ( is_file( $admin_path ) ) {
			require_once( $admin_path );

			return true;
		}

		return false;
	}
}
