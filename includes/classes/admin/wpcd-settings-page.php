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
class WPCD_Settings_Page {

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
	 * @param  array $links Existing links
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
			$settings_link = '<a href="edit.php?post_type=wpcd_coupons&page=wpcd_coupon_settings">' . __( 'Settings', 'wpcd-coupon' ) . '</a>';
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

		/**
		 * Tabs setting.
		 *
		 * @since 2.2.2
		 */
		$settings['tabs'] = array(
			array(
				'id'          => 'general',
				'title'       => __( 'Coupon Settings', 'wpcd-coupon' ),
				'description' => __( 'These are some general coupon settings. You can use the default settings or set your own ones.', 'wpcd-coupon' )
			),
			array(
				'id'          => 'design',
				'title'       => __( 'Design Settings', 'wpcd-coupon' ),
				'description' => __( 'Design Settings for coupon templates and other elements.', 'wpcd-coupon' )
			),
			array(
				'id' => 'voting',
				'title' => __( 'Voting Settings', 'wpcd-coupon' ),
				'description' => __( 'Configure Voting Settings for Your Coupons.', 'wpcd-coupon' )
			),
			array(
				'id'          => 'settings-extra',
				'title'       => __( 'Extras', 'wpcd-coupon' ),
				'description' => __( 'These are some extra settings. You can use the default settings or set your own ones.', 'wpcd-coupon' )
			),
			array(
				'id'          => 'link',
				'title'       => __( 'Knowledge Base', 'wpcd-coupon' ),
				'description' => __( 'These are some general settings. You can use the default settings or set your own ones.', 'wpcd-coupon' ),
				'href'        => 'https://wpcouponsdeals.com/knowledgebase/'
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
					'id'          => 'words-count',
					'label'       => __( 'Words Count to Add More/Less Link', 'wpcd-coupon' ),
					'description' => __( 'If coupon description is more than this count, More/Less link will be added. Default is 30 words.', 'wpcd-coupon' ),
					'type'        => 'number',
					'default'     => 30,
					'placeholder' => 30,
				),
				array(
					'id'          => 'coupon-hover-text',
					'label'       => __( 'Coupon Button Hover Text', 'wpcd-coupon' ),
					'description' => __( 'Text to show when user hovers on the coupon button. Default is Click To Copy Coupon' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Click To Copy Coupon', 'wpcd-coupon' ),
				),
				array(
					'id'          => 'deal-hover-text',
					'label'       => __( 'Deal Button Hover Text', 'wpcd-coupon' ),
					'description' => __( 'Text to show when user hovers on the deal button. Default is Click Here To Get This Deal' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Click Here To Get This Deal', 'wpcd-coupon' ),
				),
				array(
					'id'          => 'expire-text',
					'label'       => __( 'Expire Text', 'wpcd-coupon' ),
					'description' => __( 'Text to show before expire date. Default is \'Expires on:\' ', 'wpcd-coupon' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Expires on:', 'wpcd-coupon' )
				),
				array(
					'id'          => 'expired-text',
					'label'       => __( 'Expired Text', 'wpcd-coupon' ),
					'description' => __( 'Text to show before expired date. Default is \'Expired on:\' ', 'wpcd-coupon' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Expired on:', 'wpcd-coupon' )
				),
				array(
					'id'          => 'no-expiry-message',
					'label'       => __( 'No Expiration Text', 'wpcd-coupon' ),
					'description' => __( 'Text to show if coupon or deal never expires. Default is \'Doesn\'t expire\'.', 'wpcd-coupon' ),
					'type'        => 'text',
					'default'     => '',
					'placeholder' => __( 'Doesn\'t Expire', 'wpcd-coupon' )
				),
				array(
					'id'          => 'expiry-date-format',
					'label'       => __( 'Expiration Date Format', 'wpcd-coupon' ),
					'description' => __( 'Choose the date format for expiration date.', 'wpcd-coupon' ),
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
					'label'       => __( 'Hide expired Coupon', 'wpcd-coupon' ),
					'type'        => 'checkbox',
					'description' => __( 'Hide Coupon when it\'s expired. Default - Not to hide', 'wpcd-coupon' ),
					'default'     => ''
				),
				array(
					'id'          => 'coupon-title-tag',
					'label'       => __( 'Coupon Title Tag', 'wpcd-coupon' ),
					'description' => __( 'Choose the heading tag to be used for Coupon Title', 'wpcd-coupon' ),
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
					'id' => 'coupon-social-share',
					'label' => __( 'Social Share Buttons', 'wpcd-coupon' ),
					'description' => __( 'Enable Social Share buttons in Coupons', 'wpcd-coupon' ),
					'type' => 'checkbox',
					'default' => ''
				),
			),
			array(
				array(
					'id'          => 'coupon-type-bg-color',
					'label'       => __( 'Coupon Type Color', 'wpcd-coupon' ),
					'description' => __( 'Coupon Type Background Color in Default Template.', 'wpcd-coupon' ),
					'type'        => 'colorpicker',
					'default'     => '#56b151'
				),
				array(
					'id'          => 'dt-border-color',
					'label'       => __( 'Border Color', 'wpcd-coupon' ),
					'description' => __( 'Border Color in Default Template.', 'wpcd-coupon' ),
					'type'        => 'colorpicker',
					'default'     => '#000000'
				),
				array(
					'id' 		  => 'custom-css',
					'label'	      => __( 'Custom CSS', 'wpcd-coupon' ),
					'description' => __( 'Add any custom CSS you want here.', 'wpcd-coupon' ),
					'type'		  => 'textarea',
					'default' 	  => '',
					'placeholder' => ''
				)
			),
			array(
				array(
					'id' => 'coupon-vote-system',
					'label' => __( 'Vote Buttons', 'wpcd-coupon' ),
					'description' => __( 'Enable Voting buttons in Coupons', 'wpcd-coupon' ),
					'type' => 'checkbox',
					'default' => ''
				),
				array(
					'id' => 'coupon-vote-success',
					'label' => __( 'Voting Success Message', 'wpcd-coupon' ),
					'description' => __( 'Message to Show After User has Voted Successfully', 'wpcd-coupon' ),
					'type' => 'text',
					'default' => '',
					'placeholder' => __( 'You have voted successfully!', 'wpcd-coupon' )
				),
				array(
					'id' => 'coupon-vote-fail',
					'label' => __( 'Voting Failed Message', 'wpcd-coupon' ),
					'description' => __( 'Message to Show If Voting Fails', 'wpcd-coupon' ),
					'type' => 'text',
					'default' => '',
					'placeholder' => __( 'Voting Failed!', 'wpcd-coupon' )
				),
				array(
					'id' => 'coupon-vote-already',
					'label' => __( 'Already Voted Message', 'wpcd-coupon' ),
					'description' => __( 'Message to Show If User has Voted Already', 'wpcd-coupon' ),
					'type' => 'text',
					'default' => '',
					'placeholder' => __( 'You have voted already!', 'wpcd-coupon' )
				)
			),
			array(
				array (
					'id' => 'coupon-link-target',
					'label' => __( 'Affiliate Link in Current Tab', 'wpcd-coupon' ),
					'description' => __( 'Enabling it will open the affiliate link in current tab. By default it opens in a new tab.', 'wpcd-coupon' ),
					'type' => 'checkbox',
					'default' => ''
				),
				array(
					'id'          => 'disable-coupon-title-link',
					'label'       => __( 'Disable Link in Coupon Title', 'wpcd-coupon' ),
					'description' => __( 'Disable the coupon title link. By default it\'s linked to the link/affiliate link you put when you create a coupon.', 'wpcd-coupon' ),
					'type'        => 'checkbox',
					'default'     => '',
				),
				array(
					'id' 		  => 'dt-coupon-type-text',
					'label'       => __( 'Coupon Type Name', 'wpcd-coupon' ),
					'description' => __( 'Text to Show for Coupon Type Name in Default Template. Default is - Coupon.', 'wpcd-coupon' ),
					'type'		  => 'text',
					'default'	  => __( 'Coupon', 'wpcd-coupon' ),
					'placeholder' => __( 'Coupon', 'wpcd-coupon' )
				),
				array(
					'id' 		  => 'dt-deal-type-text',
					'label'       => __( 'Deal Type Name', 'wpcd-coupon' ),
					'description' => __( 'Text to Show for Deal Type Name in Default Template. Default is - Deal.', 'wpcd-coupon' ),
					'type'		  => 'text',
					'default'	  => __( 'Deal', 'wpcd-coupon' ),
					'placeholder' => __( 'Deal', 'wpcd-coupon' )
				)
			),

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
			__( 'WP Coupons and Deals Settings', 'wpcd-coupon' ),
			__( 'Settings', 'wpcd-coupon' ),
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
			echo "<button type='button' class='nav-tab $active'>" . $this->settings['tabs'][ $section['id'] ]['title'] . "</button>";
		} else {
			echo "<a target='_blank' href='" . $this->settings['tabs'][ $section['id'] ]['href'] . "'  class='nav-tab'>" . $this->settings['tabs'][ $section['id'] ]['title'] . "</a>";
		}

		//after last tab
		if ( $section['id'] == $last - 1 ) {
			echo "</h2>";
		}
	}

	/**
	 * Generate HTML for displaying fields.
	 *
	 * @param  array $args Field data
	 *
	 * @return void
	 * @since 1.0
	 */
	public function display_field( $args ) {
		$field       = $args['field'];
		$output      = '';
		$option_name = $this->settings_base . $field['id'];
		$option      = get_option( $option_name );

		$data = '';
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
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . $data . '"/>' . "\n";
				break;

			case 'hidden':
				$output .= '<input class="color-picker" id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" value="' . $data . '"/>' . "\n";
				break;

			case 'colorpicker':
				$output .= '<div id="' . esc_attr( $field['id'] ) . '" class="wpcd_colorSelectors">
                    <div data-color="' . $data . '" style="background-color:' . $data . ';"></div>
                    <input id="wpcd_color" name="' . esc_attr( $option_name ) . '" type="text" value="' . $data . '"/>
                    </div>';
				break;

			case 'text_secret':
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value=""/>' . "\n";
				break;

			case 'textarea':
				$output .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '">' . $data . '</textarea><br/>' . "\n";
				break;

			case 'checkbox':
				$checked = '';
				if ( $option && 'on' == $option ) {
					$checked = 'checked="checked"';
				}
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
				break;

			case 'checkbox_multi':
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
					if ( in_array( $k, $data ) ) {
						$checked = true;
					}
					$output .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
				break;

			case 'radio':
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
					if ( $k == $data ) {
						$checked = true;
					}
					$output .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
				break;

			case 'select':
				$output .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( $k == $data ) {
						$selected = true;
					}
					$output .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
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
					$output .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '" />' . $v . '</label> ';
				}
				$output .= '</select> ';
				break;
		}

		switch ( $field['type'] ) {

			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$output .= '<br/><span class="description">' . $field['description'] . '</span>';
				break;

			default:
				$output .= '<label for="' . esc_attr( $field['id'] ) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
				break;
		}

		echo $output;
	}

	/**
	 * Validate individual settings field.
	 *
	 * @param  string $data Inputted value
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
		$output .= '<h3 class="setting-title">' . __( 'WP Coupons and Deals Settings', 'wpcd-coupon' ) . '</h3>' . "\n";
		$output .= '<div class="wpcd_settings_section">';
		$output .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";
		// Get settings fields
		ob_start();
		settings_fields( 'wpcd_settings' );
		do_settings_sections( 'wpcd_settings' );
		$output .= ob_get_clean();
		$output .= '<p class="submit">' . "\n";
		$output .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings', 'wpcd-coupon' ) ) . '" />' . "\n";
		$output .= '</p>' . "\n";
		$output .= '</form>' . "\n";
		$output .= '</div>';
		$output .= '</div>' . "\n";

		ob_start();

		$output .= ob_get_clean();

		echo $output;
	}

}
