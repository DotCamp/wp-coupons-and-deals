<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * This is contains the main plugin class
 * which contains everything.
 *
 * @since 1.0
 * @author Imtiaz Rayhan
 */
// Checking is the class already exists.
if ( ! class_exists( 'WPCD_Plugin' ) ) {

	/**
	 * Class WPCD_Plugin
	 * This is the main plugin class.
	 *
	 * @since 1.0
	 */
	class WPCD_Plugin {

		/**
		 * Setting up constant that we will use later
		 * throughout our class.
		 *
		 * @since 1.0
		 */
		const PLUGIN_VERSION = '2.8.6';
		const CUSTOM_POST_TYPE = 'wpcd_coupons';
		const CUSTOM_TAXONOMY = 'wpcd_coupon_category';
        const VENDOR_TAXONOMY = 'wpcd_coupon_vendor';
		const TEXT_DOMAIN = 'wpcd-coupon';
		const NAME_SINGULAR = 'Coupon';
		const NAME_PLURAL = 'Coupons';
		const TAXONOMY_SINGULAR = 'Coupon Category';
		const TAXONOMY_PLURAL = 'Coupon Categories';
        const VENDOR_SINGULAR = 'Coupon Vendor';
        const VENDOR_PLURAL = 'Coupon Vendors';
		/**
		 * Instance to instantiate object.
		 *
		 * @var $instance
		 */
		protected static $instance;

		/**
		 * Plugin directory.
		 *
		 * @var string $plugin_dir_path holds the plugin directory path.
		 * @since 1.0
		 */
		public $plugin_dir_path;

		/**
		 * Plugin directory URI.
		 *
		 * @var string $plugin_dir_uri holds the plugin directory URI.
		 * @since 1.0
		 */
		public $plugin_dir_uri;

		/**
		 * Plugin assets URI.
		 *
		 * @var string $plugin_assets holds the path to plugin assets.
		 * @since 1.0
		 */
		public $plugin_assets;

		/**
		 * Plugin includes path.
		 *
		 * @var string $plugin_includes holds the path to plugin includes.
		 * @since 1.0
		 */
		public $plugin_includes;

		/**
		 * Plugin classes path.
		 *
		 * @var string $plugin_classes holds the path to plugin classes.
		 * @since 1.0
		 */
		public $plugin_classes;

		/**
		 * Singleton pattern, making only one instance of the class.
		 *
		 * @since 1.00
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) ) {
				$className      = __CLASS__;
				self::$instance = new $className;
			}

			return self::$instance;
		}

		/**
		 * WPCD_Plugin constructor.
		 * Adds necessary stuff when plugin
		 * is activated.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			/**
			 * These are the necessary directory, we'll need
			 * throughout plugin.
			 *
			 * @since 1.0
			 */
			$this->plugin_dir_path = trailingslashit( dirname( plugin_dir_path( __FILE__ ) ) );
			$this->plugin_dir_uri  = trailingslashit( dirname( plugin_dir_url( __FILE__ ) ) );
			$this->plugin_assets   = $this->plugin_dir_uri . trailingslashit( 'assets' );
			$this->plugin_includes = $this->plugin_dir_path . trailingslashit( 'includes' );
			$this->plugin_classes  = $this->plugin_includes . trailingslashit( 'classes' );
		}

		/**
		 * Activation function. Runs this when plugin is activated.
		 *
		 * @since 1.0
		 */
		public static function wpcd_activate() {

			/**
			 * Checking if the user has the permissions.
			 */
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			// Adds the option to check if user is notified for review.
			add_option( 'wpcd_review_notify', 'no' );
			add_option( 'wpcd_popup-goto-link', 'on' );

			/**
			 * Loading the class here to avoid errors.
			 *
			 * @since 1.0
			 */
			WPCD_Plugin::instance()->loadClasses();

			/**
			 * Registering the custom post type when plugin is activated.
			 *
			 * @since 1.0
			 */
			WPCD_Plugin::instance()->custom_post_type_register();

			/**
			 * Clear the permalinks after the post type has been registered.
			 *
			 * @since 1.0
			 */
			flush_rewrite_rules();

			/**
			 * Adds the welcome page.
			 *
			 * @since 2.0
			 */
			//WPCD_Welcome_Page::wpcd_welcome_activate();
		}

		/**
		 * Deactivation. Runs when the plugin is deactivated.
		 *
		 * @since 1.0
		 */
		public static function wpcd_deactivate() {

			/**
			 * Checking if the user has the permissions.
			 */
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			// Delets the option to check if user is notified for review.
			delete_option( 'wpcd_review_notify' );

			/**
			 * Clear the permalinks to remove our post type's rules.
			 *
			 * @since 1.0
			 */
			flush_rewrite_rules();

			add_action( 'after_uninstall', 'wcad_fs_uninstall_cleanup' );

			/**
			 * Welcome page transient remove.
			 *
			 * @since 2.0
			 */
			//WPCD_Welcome_Page::wpcd_welcome_deactivate();
		}

		/**
		 * This function initializes necessary files, classes
		 * and functions.
		 *
		 * @since 1.0
		 */
		public static function init() {

			/**
			 * Adding actions using proper functions.
			 *
			 * @since 1.0
			 */
			add_action( 'init', array( __CLASS__, 'loadClasses' ), 10 );
			add_action( 'init', array( __CLASS__, 'custom_taxonomy_register' ) );
			add_action( 'init', array( __CLASS__, 'custom_post_type_register' ) );
			add_action( 'widgets_init', array( __CLASS__, 'wpcd_widget_register' ), 20 );
			add_filter( 'wp_enqueue_scripts', array( __CLASS__, 'load_jquery' ), 1 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_jquery' ) );
			add_filter( 'wp_head', array( __CLASS__, 'load_jquery' ) );
			add_action( 'wp_dashboard_setup', array( __CLASS__, 'wpcd_dashboard_add_widgets' ) );

			if ( wcad_fs()->is_not_paying() && !( wcad_fs()->is_trial() ) ) {
				add_action( 'admin_menu', array( __CLASS__, 'free_pro_trial'), 99 );
			}

		}
		/**
		 * this function checks if jQuery exits to added it
		 *
		 * @since 2.2.2
		 */
		public static function load_jquery() {

			if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {

				//Enqueue
				wp_enqueue_script( 'jquery', false, array(), false, false );
			}

		}

		/**
		 * This function loads the auto-loader which
		 * loads all the classes.
		 *
		 * @since 1.0
		 */
		public static function loadClasses() {

			/**
			 * Including the auto loader file.
			 * This loads all the classes so we can use them
			 * whenever we want.
			 *
			 * @since 1.0
			 */
			include WPCD_Plugin::instance()->plugin_includes . 'autoloader.php';

			/**
			 * Registering the autoloader to autoload classes.
			 *
			 * @since 1.0
			 */
			WPCD_Autoloader::register();

			/**
			 * Adding the admin classes to initialize.
			 *
			 * @since 1.0
			 */
			self::wpcd_admin_classes();

			/**
			 * Adding the shortcode class to initialize.
			 *
			 * @since 1.0
			 */
			self::shortcode_class();

             /**
             * Adding the ajax class to initialize.
             * 
             * @since 2.5.0.1
             */
            self::ajax_class();
                        
			/**
			 * Welcome page.
			 *
			 * @since 2.0
			 */
			WPCD_Welcome_Page::init();

			/**
			 * Adds the links to toolbar.
			 *
			 * @since 2.0
			 */
			new WPCD_Toolbar_Links();

			/**
			 * Include pagination functions
			 *
			 * @since 2.7.3
			 */
			self::wpcd_pagination();

			/**
			 * Include addition functions
			 *
			 * @since 2.7.3
			 */
			self::wpcd_additional_functions();

		}

		/**
		 * This function registers the custom coupon
		 * code post type.
		 *
		 * @since 1.0
		 */
		public static function custom_post_type_register() {

			/**
			 * This generates the lables for the custom post type.
			 * Passing the arguments for the static method of the
			 * post type class.
			 *
			 * @since 1.0
			 */
			$labels = WPCD_Custom_Post_Type::post_type_labels(
				self::NAME_SINGULAR, self::NAME_PLURAL, self::TEXT_DOMAIN
			);

			/**
			 * This method registers the custom post type
			 * with WordPress.
			 *
			 * @since 1.0
			 */
			WPCD_Custom_Post_Type::post_type_register(
				self::CUSTOM_POST_TYPE, self::NAME_SINGULAR, $labels, self::TEXT_DOMAIN
			);

			/**
			 * Instantiating the custom post type class.
			 * Custom Post type name is passed.
			 *
			 * @since 1.0
			 */
			new WPCD_Custom_Post_Type( self::CUSTOM_POST_TYPE );
		}

		/**
		 * This function generates the labels for the
		 * custom taxonomy and registers it with WordPress.
		 *
		 * @since 1.0
		 */
		public static function custom_taxonomy_register() {
			
			/**
            * Category
            */
			/**
			 * Generating the labels for the custom taxonomy.
			 */
			$labels = WPCD_Custom_Taxonomy::taxonomy_labels(
				self::TAXONOMY_SINGULAR, self::TAXONOMY_PLURAL, self::TEXT_DOMAIN
			);

			/**
			 * Registering the custom taxonomy with WordPress.
			 */
			WPCD_Custom_Taxonomy::register_taxonomy(
				self::CUSTOM_TAXONOMY, self::CUSTOM_POST_TYPE, $labels, 'wpcd_coupon_category'
			);

			WPCD_Custom_Taxonomy_Image::register( self::CUSTOM_TAXONOMY );
                        
            /**
             * Vendor
             */
            /**
			 * Generating the labels for the custom taxonomy.
			 */
			$labels = WPCD_Custom_Taxonomy::taxonomy_labels(
				self::VENDOR_SINGULAR, self::VENDOR_PLURAL, self::TEXT_DOMAIN
			);

			/**
			 * Registering the vendor taxonomy with WordPress.
			 */
			WPCD_Custom_Taxonomy::register_taxonomy(
				self::VENDOR_TAXONOMY, self::CUSTOM_POST_TYPE, $labels, 'wpcd_coupon_vendor'
			);

			WPCD_Custom_Taxonomy_Image::register( self::VENDOR_TAXONOMY );
		}

		/**
		 * Registering the Widget.
		 *
		 * @since 1.2
		 */
		public static function wpcd_widget_register() {

			/**
			 * Including the Widget class.
			 *
			 * @since 1.2
			 */
			include WPCD_Plugin::instance()->plugin_classes . 'wpcd-coupon-widget.php';

			/**
			 * Register widget with WordPress.
			 *
			 * @since 1.2
			 */
			register_widget( 'WPCD_Coupon_Widget' );
		}

		/**
		 * This function loads the necessary admin classes by
		 * instantiating the classes.
		 *
		 * @since 1.0
		 */
		public static function wpcd_admin_classes() {

			/**
			 * Including the necessary actions.
			 *
			 * @since 1.0
			 */
			include WPCD_Plugin::instance()->plugin_includes . '/functions/admin/actions/' . 'wpcd-admin-actions.php';

			/**
			 * Instantiation of settings page class.
			 * Adds the settings page.
			 *
			 * @since 1.0
			 */
			if ( file_exists( WPCD_Plugin::instance()->plugin_includes . '/classes/admin/wpcd-settings-page-pro__premium_only.php' ) ) {

				require_once WPCD_Plugin::instance()->plugin_includes . '/classes/admin/wpcd-settings-page-pro__premium_only.php';

				if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
					new WPCD_Settings_Page_Pro();
				} else {
					new WPCD_Settings_Page();
				}

			} else {

				new WPCD_Settings_Page();

			}

			/**
			 * Loading the import page.
			 *
			 * @since 2.3.2
			 */
			if ( file_exists( WPCD_Plugin::instance()->plugin_includes . '/classes/admin/wpcd-import-page-pro__premium_only.php' ) ) {

				require_once WPCD_Plugin::instance()->plugin_includes . '/classes/admin/wpcd-import-page-pro__premium_only.php';

				if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
					new WPCD_Import_Page_Pro();
				} else {
					new WPCD_Import_Page();
				}

			} else {

				new WPCD_Import_Page();

			}

			/**
			 * This instantiation adds the custom meta boxes
			 * to the custom post type we registered.
			 *
			 * @since 1.0
			 */
			if ( file_exists( WPCD_Plugin::instance()->plugin_includes . '/classes/admin/wpcd-meta-boxes-pro__premium_only.php' ) ) {

				require_once WPCD_Plugin::instance()->plugin_includes . '/classes/admin/wpcd-meta-boxes-pro__premium_only.php';

				if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
					new WPCD_Meta_Boxes_Pro();
				} else {
					new WPCD_Meta_Boxes();
				}

			} else {

				new WPCD_Meta_Boxes();

			}      

			/**
			 * Shows the shortcodes after coupon is published.
			 *
			 * @since 2.0
			 */
			new WPCD_Shortcode_Metabox();

			/**
			 * Adds the help shortocode in new coupon screen.
			 *
			 * @since 2.3.2
			 */
			new WPCD_Help_Metabox();

			/**
			 * Adds the preview metabox.
			 *
			 * @since 2.0
			 */
			new WPCD_Preview_Metabox();

			/**
			 * This adds the add coupon button to the post and
			 * page editors.
			 *
			 * Inserts the shortcode.
			 *
			 * @since 1.0
			 */
			WPCD_Shortcode_Inserter::wpcd_shortcode_insert();

			/**
			 * This adds the custom columns in
			 * custom post type admin scree.
			 *
			 * @since 1.0
			 */
			WPCD_Admin_Columns::wpcd_columns_init();

			/**
			 * This loads the necessary stylesheets and
			 * scripts.
			 *
			 * @since 1.0
			 */
			WPCD_Assets::wpcd_assets_init();

			/**
			 * Shows the shortcodes in admin notices when post Published.
			 *
			 * @since 2.0
			 */
			WPCD_Admin_Notices::init();
		}

		/**
		 * This function loads the shortcode class and
		 * related files with the class.
		 *
		 * @since 1.0
		 */
		public static function shortcode_class() {

			/**
			 * Including the necessary actions.
			 *
			 * @since 1.0
			 */
			include WPCD_Plugin::instance()->plugin_includes . '/functions/shortcode/code/actions/' . 'wpcd-shortcode-code-actions.php';
			/**
			 * Instantiation of shortcode class.
			 * This registers the shortcode with WordPress.
			 *
			 * @since 1.0
			 */
			WPCD_Short_Code::init();
		}
                
        /**
		 * This function loads the ajax class
		 *
		 * @since 2.5.0.1
		 */
        public static function ajax_class() {
			
			/**
            * Load the ajax events
            * 
            * @since 2.5.0.1
            */
            WPCD_AJAX::LoadEvents();
		
		}

		/**
		 * Free Pro Trial Page for Free Users.
		 * @since 2.6.2
		 */
		public static function free_pro_trial() {
			
			global $menu, $submenu;
			
			$parent_menu = 'edit.php?post_type=wpcd_coupons';
			$menu_name = 'Free Pro Trial';
			$capability = 'manage_options';
			$url = wcad_fs()->get_trial_url();
			
			$submenu[$parent_menu][] = array( $menu_name, $capability, $url );
		
		}	

		/**
		 * This function loads the file with pagination functions
		 *
		 * @since 2.7.3
		 */
        public static function wpcd_pagination() {
			
			if ( file_exists( WPCD_Plugin::instance()->plugin_includes . '/functions/wpcd-coupon-pagination__premium_only.php' ) ) {

				include WPCD_Plugin::instance()->plugin_includes . '/functions/wpcd-coupon-pagination__premium_only.php';
			
			}
		
		}		

		/**
		 * This function loads the file with different help functions
		 *
		 * @since 2.7.3
		 */
        public static function wpcd_additional_functions() {
			
			include WPCD_Plugin::instance()->plugin_includes . '/functions/wpcd-addition-functions.php';
		
		}

		/**
		 * Setting up dashboard widget.
		 */
		public static function wpcd_dashboard_add_widgets() {
			wp_add_dashboard_widget( 'wpcd_dashboard_widget_news', __( 'Coupons Overview', 'wpcd-coupon' ), array ( __CLASS__, 'wpcd_dashboard_widget_news_handler' ) );
		}

		/**
		 * Dashboard Widget.
		 */
		public static function wpcd_dashboard_widget_news_handler() {
			include WPCD_Plugin::instance()->plugin_includes . '/templates/extras/dashboard-widget.php';
		}

	}

}
