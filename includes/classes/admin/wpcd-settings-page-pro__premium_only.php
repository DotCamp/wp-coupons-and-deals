<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class builds the settings page.
 *
 * @since 1.0
 */
class WPCD_Settings_Page_Pro {

	/**
	 * Settings base to be added before field ids.
	 *
	 * @var string
	 * @since 1.0
	 */
	private $settings_base;

	/**
	 * Adding the settings, settings fields here.
	 *
	 * @var array
	 * @since 1.0
	 */
	private $settings;

	/**
	 * Constructor method.
	 *
	 * Adding necessary actions to add settings page,
	 * register settings, adding links to plugin list.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$this->settings_base = 'wpcd_';

		/**
		 * Initializes the settings.
		 *
		 * @since 1.0
		 */
		add_action( 'admin_init', array( $this, 'init' ) );

		/**
		 * Registering the plugin settings.
		 *
		 * @since 1.0
		 */
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		/**
		 * Adding the settings page to the menu.
		 *
		 * @since 1.0
		 */
		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );

		/**
		 * Adding the links to plugins list page.
		 *
		 * @since 1.0
		 */
		add_filter( 'plugin_action_links', array( __CLASS__, 'add_settings_link' ), 10, 2 );


		/**
		 * Load stylesheets and scripts.
		 *
		 * @since 2.2.2
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_stylesheet_script' ) );
	}

	/**
	 * Add settings link to plugin list table.
	 *
	 * @param array $links Existing links
	 *
	 * @return array        Modified links
	 * @since 1.0
	 */
	public static function add_settings_link( $links, $file ) {
		static $plugin;
		if ( ! $plugin ) {
			$plugin = 'wp-coupons-deals/wp-coupons-deals.php';
		}
		if ( $file == $plugin ) {
			$settings_link = '<a href="edit.php?post_type=wpcd_coupons&page=wpcd_coupon_settings">' . __( 'Settings',
					'wp-coupons-and-deals' ) . '</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}

	/**
	 * Initialise settings by adding the fields.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function init() {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Build settings fields.
	 *
	 * @return array Fields to be displayed on settings page
	 * @since 1.0
	 */
	private function settings_fields() {
		global $wp_post_statuses;
		$post_statuses = [];
		foreach ( $wp_post_statuses as $key => $val ) {
			$post_statuses[ $key ] = $key;
		}

		// currently available template names
		$template_names       = WPCD_Form_Shortcode_Pro::getAvailableTemplateNames( WPCD_Meta_Boxes_Fields_Pro__Premium_Only::getFields() );
		$template_names_keyed = [];
		$template_names_keyed['all'] = 'all';
		foreach ( $template_names as $name ) {
			$template_names_keyed[ $name ] = $name;
		}

		/**
		 * Tabs setting.
		 *
		 * @since 2.2.2
		 */
		$settings['tabs'] = array(
			array(
				'id'          => 'general',
				'title'       => __( 'Coupon Settings', 'wp-coupons-and-deals' ),
				'description' => __( 'These are some general coupon settings. You can use the default settings or set your own ones.',
					'wp-coupons-and-deals' )
			),
			array(
				'id'          => 'design',
				'title'       => __( 'Design Settings', 'wp-coupons-and-deals' ),
				'description' => __( 'Design Settings for coupon templates and other elements.', 'wp-coupons-and-deals' )
			),
			array(
				'id'          => 'voting',
				'title'       => __( 'Voting Settings', 'wp-coupons-and-deals' ),
				'description' => __( 'Configure Voting Settings for Your Coupons.', 'wp-coupons-and-deals' )
			),
			array(
				'id'          => 'hide-coupon',
				'title'       => __( 'Hide Coupon Settings', 'wp-coupons-and-deals' ),
				'description' => __( 'Settings when coupon is hidden.', 'wp-coupons-and-deals' )
			),
			array(
				'id'          => 'pop-up',
				'title'       => __( 'Pop-up Settings', 'wp-coupons-and-deals' ),
				'description' => __( 'Settings for pop up which opens when user clicks to show code.' ),
			),
			array(
				'id'          => 'settings-extra',
				'title'       => __( 'Extras', 'wp-coupons-and-deals' ),
				'description' => __( 'These are some extra settings. You can use the default settings or set your own ones.',
					'wp-coupons-and-deals' )
			),

			array(
				'id'          => 'form-shortcode-settings',
				'title'       => __( 'Form Shortcode', 'wp-coupons-and-deals' ),
				'description' => __( 'Form shortcode settings', 'wp-coupons-and-deals' )
			)
		);

		/**
		 *  Tabs content.
		 *
		 * @since 2.2.2
		 */
		//each array is a content to a tab
		$settings['tabs_content'] = array(
			array(
				array(
					'id'          => 'featured-image',
					'label'       => __( 'Featured Image', 'wp-coupons-and-deals' ),
					'description' => __( 'If there\'s no featured image selected, choose whether to use Category Image or Vendor Image as the featured image.',
						'wp-coupons-and-deals' ),
					'type'        => 'select',
					'options'     => array(
						'category' => __( 'Category Image', 'wp-coupons-and-deals' ),
						'vendor'   => __( 'Vendor Image', 'wp-coupons-and-deals' )
					),
					'default'     => 'category'
				),
				array(
					'id'          => 'archive-munu-categories',
					'label'       => __( 'Archive Menu Categories', 'wp-coupons-and-deals' ),
					'description' => __( 'Choose the Type of  Navigation on Category or Vendor for Archive.',
						'wp-coupons-and-deals' ),
					'type'        => 'select',
					'options'     => array(
						'category' => __( 'Category Navigation', 'wp-coupons-and-deals' ),
						'vendor'   => __( 'Vendor Navigation', 'wp-coupons-and-deals' )
					),
					'default'     => 'category'
				),
                array(
                    'id'          => 'infinite-scroll-in-archive',
                    'label'       => __( 'Infinite Scroll in Archive.', 'wp-coupons-and-deals' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Set infinite scroll instead of pagination', 'wp-coupons-and-deals' ),
                    'default'     => ''
                ),
				array(
					'id'          => 'words-count',
					'label'       => __( 'Words Count to Add More/Less Link', 'wp-coupons-and-deals' ),
					'description' => __( 'If coupon description is more than this count, More/Less link will be added. Default is 30 words.',
						'wp-coupons-and-deals' ),
					'type'        => 'number',
					'default'     => 30,
					'placeholder' => 30,
				),
				array(
					'id'          => 'coupon-hover-text',
					'label'       => __( 'Coupon Button Hover Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show when user hovers on the coupon button. Default is Click To Copy Coupon' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Click To Copy Coupon', 'wp-coupons-and-deals' ),
				),
				array(
					'id'          => 'deal-hover-text',
					'label'       => __( 'Deal Button Hover Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show when user hovers on the deal button. Default is Click Here To Get This Deal' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Click Here To Get This Deal', 'wp-coupons-and-deals' ),
				),
				array(
					'id'          => 'expire-text',
					'label'       => __( 'Expire Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show before expire date. Default is \'Expires on:\' ',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Expires on:', 'wp-coupons-and-deals' )
				),
				array(
					'id'          => 'expired-text',
					'label'       => __( 'Expired Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show before expired date. Default is \'Expired on:\' ',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Expired on:', 'wp-coupons-and-deals' )
				),
				array(
					'id'          => 'no-expiry-message',
					'label'       => __( 'No Expiration Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show if coupon or deal never expires. Default is \'Doesn\'t expire\'.',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Doesn\'t Expire', 'wp-coupons-and-deals' )
				),
				array(
					'id'          => 'expiry-date-format',
					'label'       => __( 'Expiration Date Format', 'wp-coupons-and-deals' ),
					'description' => __( 'Choose the date format for expiration date.', 'wp-coupons-and-deals' ),
					'type'        => 'select',
					'options'     => array(
						'dd-mm-yy' => 'dd-mm-yy',
						'mm/dd/yy' => 'mm/dd/yy',
						'yy/mm/dd' => 'yy/mm/dd'
					),
					'default'     => 'mm/dd/yy'
				),
				array(
					'id'          => 'hide-expired-coupon',
					'label'       => __( 'Hide expired Coupon', 'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'description' => __( 'Hide Coupon when it\'s expired. Default - Not to hide', 'wp-coupons-and-deals' ),
					'default'     => ''
				),
				array(
					'id'          => 'coupon-title-tag',
					'label'       => __( 'Coupon Title Tag', 'wp-coupons-and-deals' ),
					'description' => __( 'Choose the heading tag to be used for Coupon Title', 'wp-coupons-and-deals' ),
					'type'        => 'select',
					'options'     => array(
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					),
					'default'     => 'h1',
				),
				array(
					'id'          => 'coupon-social-share',
					'label'       => __( 'Social Share Buttons', 'wp-coupons-and-deals' ),
					'description' => __( 'Enable Social Share Buttons in Coupons', 'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => ''
				),
                array(
                    'id'          => 'coupon-print-link',
                    'label'       => __( 'Show Print Links', 'wp-coupons-and-deals' ),
                    'description' => __( 'Enable Print Links for Coupons, Deals and Images', 'wp-coupons-and-deals' ),
                    'type'        => 'checkbox',
                    'default'     => ''
                ),
				array(
					'id'          => 'create-edit-import-allowed-roles',
					'label'       => __( 'Allowed User Roles', 'wp-coupons-and-deals' ),
					'description' => __( 'Allowed user roles to create, edit and import coupons.', 'wp-coupons-and-deals' ),
					'type'        => 'checkbox_multi',
					'options'     => wp_roles()->role_names,
					'default'     => [ 'administrator' ],
				)
			),
			array(
				array(
					'id'          => 'coupon-type-bg-color',
					'label'       => __( 'Coupon Type Color', 'wp-coupons-and-deals' ),
					'description' => __( 'Coupon Type Background Color in Default Template.', 'wp-coupons-and-deals' ),
					'type'        => 'colorpicker',
					'default'     => '#56b151'
				),
				array(
					'id'          => 'dt-border-color',
					'label'       => __( 'Border Color', 'wp-coupons-and-deals' ),
					'description' => __( 'Border Color in Default Template.', 'wp-coupons-and-deals' ),
					'type'        => 'colorpicker',
					'default'     => '#000000'
				),
				array(
					'id'          => 'pagination-color',
					'label'       => __( 'Pagination Color', 'wp-coupons-and-deals' ),
					'description' => __( 'Color for Pagination Numbers.', 'wp-coupons-and-deals' ),
					'type'        => 'colorpicker',
					'default'     => '#56b151'
				),
				array(
					'id'          => 'hidden-coupon-button-color',
					'label'       => __( 'Hidden Coupon Button Color', 'wp-coupons-and-deals' ),
					'description' => __( 'The color of the button when coupon is hidden.', 'wp-coupons-and-deals' ),
					'type'        => 'colorpicker',
					'default'     => '#347BAF',
				),
				array(
					'id'          => 'copy-button-bg-color',
					'label'       => __( 'Copy Button Color', 'wp-coupons-and-deals' ),
					'description' => __( 'Background color for the copy button in Pop Up.', 'wp-coupons-and-deals' ),
					'type'        => 'colorpicker',
					'default'     => '#56b151'
				),
				array(
					'id'          => 'coupon-popup-bg-color',
					'label'       => __( 'Coupon Code Color', 'wp-coupons-and-deals' ),
					'description' => __( 'Background color of the coupon code in the Pop up. Pop up is shown when users click to show code.',
						'wp-coupons-and-deals' ),
					'type'        => 'colorpicker',
					'default'     => '#BEFFB9'
				),
				array(
					'id'          => 'custom-css',
					'label'       => __( 'Custom CSS', 'wp-coupons-and-deals' ),
					'description' => __( 'Add any custom CSS you want here.', 'wp-coupons-and-deals' ),
					'type'        => 'textarea',
					'default'     => '',
					'placeholder' => ''
				)
			),
			array(
				array(
					'id'          => 'coupon-vote-system',
					'label'       => __( 'Vote Buttons', 'wp-coupons-and-deals' ),
					'description' => __( 'Enable Voting Buttons in Coupons', 'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => ''
				),
				array(
					'id'          => 'coupon-vote-success',
					'label'       => __( 'Voting Success Message', 'wp-coupons-and-deals' ),
					'description' => __( 'Message to Show After User has Voted Successfully', 'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'You have voted successfully!', 'wp-coupons-and-deals' )
				),
				array(
					'id'          => 'coupon-vote-fail',
					'label'       => __( 'Voting Failed Message', 'wp-coupons-and-deals' ),
					'description' => __( 'Message to Show If Voting Fails', 'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Voting Failed!', 'wp-coupons-and-deals' )
				),
				array(
					'id'          => 'coupon-vote-already',
					'label'       => __( 'Already Voted Message', 'wp-coupons-and-deals' ),
					'description' => __( 'Message to Show If User has Voted Already', 'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'You have voted already!', 'wp-coupons-and-deals' )
				)
			),
			array(
				array(
					'id'          => 'hidden-coupon-text',
					'label'       => __( 'Hidden Coupon Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show when coupon is hidden. Default is \'Show Code\' ',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Show Code', 'wp-coupons-and-deals' ),
				),
				array(
					'id'          => 'hidden-coupon-hover-text',
					'label'       => __( 'Hidden Coupon Hover Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show when user hovers on the hidden coupon. Default is \'Click Here to Show Code\'',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Click Here to Show Code', 'wp-coupons-and-deals' ),
				),
			),
			array(
				array(
					'id'          => 'copy-button-text',
					'label'       => __( 'Copy Button Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show in Copy button when pop up is shown. Default is \'Copy\'.',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Copy', 'wp-coupons-and-deals' ),
				),
				array(
					'id'          => 'after-copy-text',
					'label'       => __( 'After Copy Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to show after coupon is copied. Default is \'Copied\'.', 'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Copied', 'wp-coupons-and-deals' ),
				),
				array(
					'id'          => 'text-to-show',
					'label'       => __( 'Text to Show Below Coupon Code', 'wp-coupons-and-deals' ),
					'description' => __( 'Select what to show below the coupon code in Pop-up. Default is Description.',
						'wp-coupons-and-deals' ),
					'type'        => 'select',
					'options'     => array(
						'description' => 'Description',
						'custom-text' => 'Custom Text'
					),
					'default'     => 'description'
				),
				array(
					'id'          => 'custom-text',
					'label'       => __( 'Custom Text', 'wp-coupons-and-deals' ),
					'description' => __( 'Custom text to show below the coupon code. Default is \'Click on Copy to Copy the Coupon Code.\' ',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Click on Copy to Copy the Coupon Code.', 'wp-coupons-and-deals' ),
				),
				array(
					'id'          => 'popup-goto-link',
					'label'       => __( 'Enable \'Go To Offer\' button', 'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'description' => __( 'Show a button with a link to offer or affiliate link site. Default is \'Go To Offer\'.' ),
					'default'     => 'on'
				),
				array(
					'id'          => 'popup-goto-custom-text',
					'label'       => __( 'Custom Text for Button', 'wp-coupons-and-deals' ),
					'type'        => 'text',
					'description' => __( 'Custom text to show instead of \'Go to Offer\'.', 'wp-coupons-and-deals' ),
					'placeholder' => __( 'Go To Offer', 'wp-coupons-and-deals' ),
					'default'     => ''
				),
			),
			array(
				array(
					'id'          => 'coupon-link-target',
					'label'       => __( 'Affiliate Link in Current Tab', 'wp-coupons-and-deals' ),
					'description' => __( 'Enabling it will open the affiliate link in current tab. By default it opens in a new tab.',
						'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => ''
				),
				array(
					'id'          => 'coupon-link-featured-img',
					'label'       => __( 'Link the Featured Image', 'wp-coupons-and-deals' ),
					'description' => __( 'Enabling it will link the featured image to affiliate link. By default only the image is shown, it is not linked.',
						'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => ''
				),
				array(
					'id'          => 'disable-coupon-title-link',
					'label'       => __( 'Disable Link in Coupon Title', 'wp-coupons-and-deals' ),
					'description' => __( 'Disable the coupon title link. By default it\'s linked to the link/affiliate link you put when you create a coupon.',
						'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => '',
				),
				array(
					'id'          => 'disable-menu-archive-code',
					'label'       => __( 'Disable Navigation', 'wp-coupons-and-deals' ),
					'description' => __( 'Disable the categories navigation in archive shortcode.', 'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => '',
				),
				array(
					'id'          => 'hide-archive-thumbnail',
					'label'       => __( 'Hide Featured Image', 'wp-coupons-and-deals' ),
					'description' => __( 'Hide the featured image in Default Grid Style of Category and Archive Shortcode.',
						'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => '',
				),
				array(
					'id'          => 'dt-coupon-type-text',
					'label'       => __( 'Coupon Type Name', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to Show for Coupon Type Name in Default Template. Default is - Coupon.',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => __( 'Coupon', 'wp-coupons-and-deals' ),
					'placeholder' => __( 'Coupon', 'wp-coupons-and-deals' )
				),
				array(
					'id'          => 'dt-deal-type-text',
					'label'       => __( 'Deal Type Name', 'wp-coupons-and-deals' ),
					'description' => __( 'Text to Show for Deal Type Name in Default Template. Default is - Deal.',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'default'     => __( 'Deal', 'wp-coupons-and-deals' ),
					'placeholder' => __( 'Deal', 'wp-coupons-and-deals' )
				),
				array(
					'id'          => 'all-coupon-text',
					'label'       => __( 'All Coupons Text', 'wp-coupons-and-deals' ),
					'description' => __( '"All Coupons" text in Archive Shortcode Navigation menu. Deafult is - All Coupons',
						'wp-coupons-and-deals' ),
					'type'        => 'text',
					'placeholder' => __( 'All Coupons', 'wp-coupons-and-deals' ),
					'default'     => ''
				),
				array(
					'id'          => 'enable-stats-count',
					'label'       => __( 'Enable Statistics', 'wp-coupons-and-deals' ),
					'description' => __( 'Enable stats count of clicking and viewing the coupon',
						'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => ''
				),
			),
			array(
				array(
					'id'          => 'form-shortcode-allowed-roles',
					'label'       => __( 'Allowed User Roles', 'wp-coupons-and-deals' ),
					'description' => __( 'Allowed user roles to submit coupons using the form.', 'wp-coupons-and-deals' ),
					'type'        => 'checkbox_multi',
					'options'     => wp_roles()->role_names,
					'default'     => [ 'administrator' ],
				),
				array(
					'id'          => 'form-shortcode-coupon-status',
					'label'       => __( 'Coupon Status', 'wp-coupons-and-deals' ),
					'description' => __( 'Status of user submitted coupons, default is "publish".',
						'wp-coupons-and-deals' ),
					'type'        => 'select',
					'options'     => $post_statuses,
					'default'     => 'publish'
				),
				array(
					'id'          => 'form-shortcode-split-form',
					'label'       => __( 'Split Form', 'wp-coupons-and-deals' ),
					'description' => __( 'Split the form into smaller segments or show all fields.',
						'wp-coupons-and-deals' ),
					'type'        => 'select',
					'options'     => array( 'full' => 'full', 'split' => 'split' ),
					'default'     => 'split'
				),
				array(
					'id'          => 'form-shortcode-enable-thrash',
					'label'       => __( 'Enable Coupon Delete', 'wp-coupons-and-deals' ),
					'description' => __( 'Give the users the ability to delete their own coupons.',
						'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => '',
				),
				array(
					'id'          => 'form-shortcode-enable-new-terms',
					'label'       => __( 'Enable New Term Creation', 'wp-coupons-and-deals' ),
					'description' => __( 'Give the users the ability to create new terms (Categories & Vendors).',
						'wp-coupons-and-deals' ),
					'type'        => 'checkbox',
					'default'     => '',
				),
				array(
					'id'          => 'form-shortcode-default-template',
					'label'       => __( 'Default Template', 'wp-coupons-and-deals' ),
					'description' => __( 'Default template for users to use. Select "all" to enable selection from available templates.',
						'wp-coupons-and-deals' ),
					'type'        => 'select',
					'options'     => $template_names_keyed,
					'default'     => 'all'
				),
			)
		);

		$settings = apply_filters( 'wpcd_coupon_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item() {

		global $settings_page;
		/**
		 * Adding the settings page under our main menu item.
		 *
		 * @since 1.0
		 */
		$settings_page = add_submenu_page(
			'edit.php?post_type=wpcd_coupons',
			__( 'WP Coupons and Deals Settings', 'wp-coupons-and-deals' ),
			__( 'Settings', 'wp-coupons-and-deals' ),
			'manage_options',
			'wpcd_coupon_settings',
			array( $this, 'settings_page' )
		);
	}

	/**
	 * Loads the stylesheets on the settings page.
	 *
	 * @param $hook
	 *
	 * @since 2.1.2
	 */
	public function load_stylesheet_script( $hook ) {

		global $settings_page;

		if ( $hook != $settings_page ) {
			return;
		}

		// color Picker
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );

	}

	/**
	 * Register plugin settings.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function register_settings() {

		/**
		 * Registering settings, adding section.
		 *
		 * @since 1.0
		 */
		if ( is_array( $this->settings ) ) {

			/**
			 * display tabs
			 * @since 2.2.2
			 */
			//to cover tabs with div
			global $last;
			$last = count( $this->settings['tabs'] );
			$i    = 0;
			// display tabs
			foreach ( $this->settings['tabs'] as $data ) {
				add_settings_section( $i, '', array( $this, 'settings_section' ), 'wpcd_settings' );
				$i ++;
			}

			/**
			 * display tabs content
			 * @since 2.2.2
			 */
			$i = 0;
			foreach ( $this->settings['tabs_content'] as $tab_content ) {

				foreach ( $tab_content as $field ) {
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}
					$option_name = $this->settings_base . $field['id'];
					register_setting( 'wpcd_settings', $option_name, $validation );
					add_settings_field( $field['id'], $field['label'], array(
						$this,
						'display_field'
					), 'wpcd_settings', $i, array( 'field' => $field ) );
				}
				$i ++;
			}
		}
	}

	/**
	 * Settings section description.
	 *
	 * @param $section
	 *
	 * @since 1.0
	 */
	public function settings_section( $section ) {
		global $last;
		$active = "";
		//before first tab
		if ( $section['id'] == 0 ) {
			$active = 'active';
			echo "<h2 class='nav-tab-wrapper'>";
		}

		//If it's not link
		if ( ! array_key_exists( 'href', $this->settings['tabs'][ $section['id'] ] ) ) {
			echo "<button type='button' class='nav-tab $active'>" . esc_html( $this->settings['tabs'][ $section['id'] ]['title'] ) . "</button>";
		} else {
			echo "<a target='_blank' href='" . esc_url( $this->settings['tabs'][ $section['id'] ]['href'] ) . "'  class='nav-tab'>" . esc_html( $this->settings['tabs'][ $section['id'] ]['title'] ) . "</a>";
		}

		//after last tab
		if ( $section['id'] == $last - 1 ) {
			echo "</h2>";
		}
	}

	/**
	 * Generate HTML for displaying fields.
	 *
	 * @param array $args Field data
	 *
	 * @return void
	 * @since 1.0
	 */
	public function display_field( $args ) {
		$field       = $args['field'];
		$output      = '';
		$option_name = $this->settings_base . $field['id'];
		$option      = get_option( $option_name );
		$data        = '';

		if ( isset( $field['default'] ) ) {
			$data = $field['default'];
			if ( $option ) {
				$data = $option;
			}
		}

		switch ( $field['type'] ) {

			case 'text':
			case 'password':
			case 'number':
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . esc_attr( $data ) . '"/>' . "\n";
				break;

			case 'hidden':
				$output .= '<input class="color-picker" id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $data ) . '"/>' . "\n";
				break;

			case 'colorpicker':
				$output .= '<div id="' . esc_attr( $field['id'] ) . '" class="wpcd_colorSelectors">
                    <div data-color="' . sanitize_hex_color( $data ) . '" style="background-color:' . sanitize_hex_color( $data ) . ';"></div>
                    <input id="wpcd_color" name="' . esc_attr( $option_name ) . '" type="text" value="' . esc_attr( $data ) . '"/>
                    </div>';
				break;

			case 'text_secret':
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value=""/>' . "\n";
				break;

			case 'textarea':
				$output .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '">' . esc_html( $data ) . '</textarea><br/>' . "\n";
				break;

			case 'checkbox':
				$checked = '';
				if ( $data && 'on' == $data ) {
					$checked = 'checked="checked"';
				}

				$output .= '<input name="' . esc_attr( $option_name ) . '" ' . esc_attr( $checked ) . ' id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '"/>' . "\n";
				break;

			case 'checkbox_multi':
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
					if ( in_array( $k, $data ) ) {
						$checked = true;
					}
					$output .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="checkbox" ' . checked( $checked, true, false )
							. ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . esc_html( $v ) . '</label> ';
				}
				break;

			case 'radio':
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
					if ( $k == $data ) {
						$checked = true;
					}
					$output .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false )
							. ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . esc_html( $v ) . '</label> ';
				}
				break;

			case 'select':
				$output .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( $k == $data ) {
						$selected = true;
					}
					$output .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . esc_html( $v ) . '</option>';
				}
				$output .= '</select> ';
				break;

			case 'select_multi':
				$output .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $field['id'] ) . '" multiple="multiple">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( in_array( $k, $data ) ) {
						$selected = true;
					}
					$output .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '" />' . esc_html( $v ) . '</label> ';
				}
				$output .= '</select> ';
				break;
		}

		switch ( $field['type'] ) {

			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$output .= '<br/><span class="description">' . esc_html( $field['description'] ) . '</span>';
				break;

			default:
				$output .= '<label for="' . esc_attr( $field['id'] ) . '"><span class="description">' . esc_html( $field['description'] ) . '</span></label>' . "\n";
				break;
		}

		echo wp_kses( $output, array(
			'input' => array(
				'id' => array(),
				'class' => array(),
				'name' => array(),
				'type' => array(),
				'placeholder' => array(),
				'value' => array(),
				'checked' => array()
			),
			'div' => array(
				'id' => array(),
				'class' => array(),
				'data-color' => array(),
				'style' => array(),

			),
			'textarea' => array(
				'id' => array(),
				'rows' => array(),
				'cols' => array(),
				'name' => array(),
				'placeholder' => array()
			),
			'label' => array(
				'for' => array()
			),
			'select' => array(
				'name' => array(),
				'id' => array(),
				'multiple' => array()
			),
			'option' => array(
				'value' => array(),
				'selected' => array()
			),
			'br' => array(),
			'span' => array(
				'class' => array()
			)
		));
	}

	/**
	 * Validate individual settings field.
	 *
	 * @param string $data Inputted value
	 *
	 * @return string       Validated value
	 * @since 1.0
	 */
	public function validate_field( $data ) {
		if ( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = urlencode( strtolower( str_replace( ' ', '-', $data ) ) );
		}

		return $data;
	}

	/**
	 * Load settings page content.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function settings_page() {

		/**
		 * Building the page HTML.
		 *
		 * @since 1.0
		 */
		$output = '<div class="wrap" id="wpcd_coupon_settings">' . "\n";
		$output .= '<h3 class="setting-title">' . __( 'WP Coupons and Deals Settings', 'wp-coupons-and-deals' ) . '</h3>' . "\n";
		$output .= '<div class="wpcd_settings_section">';
		$output .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";
		// Get settings fields
		ob_start();
		settings_fields( 'wpcd_settings' );
		do_settings_sections( 'wpcd_settings' );
		$output .= ob_get_clean();
		$output .= '<p class="submit">' . "\n";
		$output .= '<input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Settings', 'wp-coupons-and-deals' ) . '" />' . "\n";
		$output .= '</p>' . "\n";
		$output .= '</form>' . "\n";
		$output .= '</div>';
		$output .= '</div>' . "\n";

		ob_start();

		$output .= ob_get_clean();

		echo wp_kses($output, array(
			'div' => array(
				'class' => array(),
				'id' => array(),
				'data-color' => array(),
				'style' => array()
			),
			'h2' => array(
				'class' => array()
			),
			'h3' => array(
				'class' => array()
			),
			'form' => array(
				'method' => array(),
				'action' => array(),
				'enctype' => array()
			),
			'button' => array(
				'type' => array(),
				'class' => array(),
				'style' => array(),
				'aria-expanded' => array()
			),
			'p' => array(
				'class' => array()
			),
			'a' => array(
				'tabindex' => array(),
				'target' => array(),
				'href' => array(),
				'class' => array(),
				'style' => array()
			),
			'input' => array(
				'id' => array(),
				'name' => array(),
				'class' => array(),
				'type' => array(),
				'value' => array(),
				'placeholder' => array(),
				'aria-label' => array(),
				'checked' => array()
			),
			'table' => array(
				'class' => array(),
				'role' => array(),
				'style' => array()
			),
			'tbody' => array(),
			'tr' => array(),
			'th' => array(
				'scope' => array()
			),
			'td' => array(),
			'label' => array(
				'for' => array()
			),
			'span' => array(
				'tabindex' => array(),
				'class' => array(),
				'style' => array()
			),
			'select' => array(
				'name' => array(),
				'id' => array()
			),
			'option' => array(
				'value' => array(),
				'selected' => array()
			),
			'textarea' => array(
				'id' => array(),
				'rows' => array(),
				'cols' => array(),
				'name' => array(),
				'placeholder' => array()
			),
			'br' => array()
		));
	}

}
