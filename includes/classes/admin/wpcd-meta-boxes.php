<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class constructs the meta box for coupon add page.
 *
 * @since 1.0
 */
class WPCD_Meta_Boxes {

	/**
	 * Post types on which metabox will be added.
	 *
	 * @var array post types.
	 * @since 1.0
	 */
	private $post_types = array(
		'wpcd_coupons',
	);

	/**
	 * Setting up the fields for the metabox.
	 *
	 * @var array Fields.
	 * @since 1.0
	 */
	private $wpcd_fields = array();

	/**
	 * Class construct method.
	 * Adding actions to WordPress hooks.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );

		$this->wpcd_fields = array(
			array(
				'id'      => 'coupon-type',
				'label'   => __( 'Coupon Type', 'wpcd-coupon' ),
				'type'    => 'select',
				'help'    => __( 'Coupon Type. Coupon will display a coupon code which will be copied when user clicks on it. Deal will display a link to get the deal instead of coupon code.', 'wpcd-coupon' ),
				'options' => array(
					'Coupon',
					'Deal',
					'Image'
				),
			),
			array(
				'id'    => 'coupon-code-text',
				'label' => __( 'Coupon Code', 'wpcd-coupon' ),
				'type'  => 'buttontext',
				'help'  => __( 'Put your coupon code here. This will be copied when user clicks on it.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'second-coupon-code-text',
				'label' => __( 'Second Coupon Code', 'wpcd-coupon' ),
				'type'  => 'temp4-buttontext',
				'help'  => __( 'Put your coupon code here. This will be copied when user clicks on it.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'third-coupon-code-text',
				'label' => __( 'Third Coupon Code', 'wpcd-coupon' ),
				'type'  => 'temp4-buttontext',
				'help'  => __( 'Put your coupon code here. This will be copied when user clicks on it.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'deal-button-text',
				'label' => __( 'Deal Button Text', 'wpcd-coupon' ),
				'type'  => 'dealtext',
				'help'  => __( 'Deal button text. Put something like Get this Deal.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'second-deal-button-text',
				'label' => __( 'Second Deal Button Text', 'wpcd-coupon' ),
				'type'  => 'temp4-dealtext',
				'help'  => __( 'Deal button text. Put something like Get this Deal.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'third-deal-button-text',
				'label' => __( 'Third Deal Button Text', 'wpcd-coupon' ),
				'type'  => 'temp4-dealtext',
				'help'  => __( 'Deal button text. Put something like Get this Deal.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'link',
				'label' => __( 'Link', 'wpcd-coupon' ),
				'type'  => 'text',
				'help'  => __( 'Link to be opened when clicked on coupon code. You can use your affiliate links.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'second-link',
				'label' => __( 'Second Link', 'wpcd-coupon' ),
				'type'  => 'temp4-text',
				'help'  => __( 'Link to be opened when clicked on coupon code. You can use your affiliate links.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'third-link',
				'label' => __( 'Third Link', 'wpcd-coupon' ),
				'type'  => 'temp4-text',
				'help'  => __( 'Link to be opened when clicked on coupon code. You can use your affiliate links.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'discount-text',
				'label' => __( 'Discount Amount/Text', 'wpcd-coupon' ),
				'type'  => 'text',
				'help'  => __( 'Discount amount or text to be shown. Example: 60% Off.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'second-discount-text',
				'label' => __( 'Discount Amount/Text (Second Code)', 'wpcd-coupon' ),
				'type'  => 'temp4-text',
				'help'  => __( 'Discount amount or text to be shown. Example: 60% Off.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'third-discount-text',
				'label' => __( 'Discount Amount/Text (Third Code)', 'wpcd-coupon' ),
				'type'  => 'temp4-text',
				'help'  => __( 'Discount amount or text to be shown. Example: 60% Off.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'wpcd_description',
				'label' => __( 'Description', 'wpcd-coupon' ),
				'type'  => 'textarea',
				'help'  => __( 'A little description so users know what the coupon code or deal is about.', 'wpcd-coupon' )
			),
			array(
				'id'      => 'show-expiration',
				'label'   => __( 'Coupon/Deal Expiration', 'wpcd-coupon' ),
				'type'    => 'select',
				'help'    => __( 'Choose whether you want to show coupon/deal expiration.', 'wpcd-coupon' ),
				'options' => array(
					'Show',
					'Hide'
				)
			),
			array(
				'id'    => 'expire-date',
				'label' => __( 'Expiration Date', 'wpcd-coupon' ),
				'type'  => 'expiredate',
				'help'  => __( 'Choose a date this coupon will expire. If you leave this blank, shortcode will show the message Doesn\'t expire.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'second-expire-date',
				'label' => __( 'Expiration Date (Second Coupon)', 'wpcd-coupon' ),
				'type'  => 'temp4-expiredate',
				'help'  => __( 'Choose a date this coupon will expire. If you leave this blank, shortcode will show the message Doesn\'t expire.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'third-expire-date',
				'label' => __( 'Expiration Date (Third Coupon)', 'wpcd-coupon' ),
				'type'  => 'temp4-expiredate',
				'help'  => __( 'Choose a date this coupon will expire. If you leave this blank, shortcode will show the message Doesn\'t expire.', 'wpcd-coupon' )
			),
			array(
				'id'    => 'expire-time',
				'label' => __( 'Expiration Time', 'wpcd-coupon' ),
				'type'  => 'expiretime',
				'help'  => __( 'Choose expiration time of the coupon.', 'wpcd-coupon' )
			),
			array(
				'id'      => 'hide-coupon',
				'label'   => __( 'Hide Coupon (Pro)', 'wpcd-coupon' ),
				'type'    => 'select',
				'help'    => __( 'Choose whether you want to hide the coupun', 'wpcd-coupon' ),
				'options' => array(
					'No',
					'Yes'
				)
			),
			array(
				'id'       => 'template-five-theme',
				'label'    => __( 'Coupon Theme', 'wpcd-coupon' ),
				'type'     => 'colorpicker',
				'tr_class' => 'coupon-code-field coupon-deal-field template-five-theme-field',
				'help'     => '',
				'default'  => '#18e06e'
			),
			array(
				'id'       => 'template-six-theme',
				'label'    => __( 'Coupon Theme', 'wpcd-coupon' ),
				'type'     => 'colorpicker',
				'tr_class' => 'coupon-code-field coupon-deal-field template-six-theme-field',
				'help'     => '',
				'default'  => '#18e06e'
			),
			array(
				'id'       => 'template-seven-theme',
				'label'    => __( 'Coupon Theme', 'wpcd-coupon' ),
				'type'     => 'colorpicker',
				'tr_class' => 'coupon-code-field coupon-deal-field template-seven-theme-field',
				'help'     => '',
				'default'  => '#9b59b6'
			),
			array(
				'id'       => 'template-eight-theme',
				'label'    => __( 'Coupon Theme', 'wpcd-coupon' ),
				'type'     => 'colorpicker',
				'tr_class' => 'coupon-code-field coupon-deal-field template-eight-theme-field',
				'help'     => '',
				'default'  => '#329d40'
			),
			array(
				'id'      => 'coupon-template',
				'label'   => __( 'Template (Pro)', 'wpcd-coupon' ),
				'type'    => 'select',
				'help'    => __( 'Choose coupon shortcode template.', 'wpcd-coupon' ),
				'options' => array(
					'Default',
					'Template One',
					'Template Two',
					'Template Three',
					'Template Four',
					'Template Five',
					'Template Six', 
					 'Template Seven',
					 'Template Eight',
				)
			),
			array(
				'id'       => 'coupon-image-input',
				'label'    => __( 'Coupon Image', 'wpcd-coupon-image' ),
				'type'     => 'coupon-image-row',
				'help'     => __( 'Choose your coupon image', 'wpcd-coupon' ),
				'tr_class' => 'coupon-image-field',
				'help'     => ''
			),
			array(
				'id'       => 'coupon-image-print',
				'label'    => __( 'Show Coupon Print link', 'wpcd-coupon' ),
				'type'     => 'select',
				'tr_class' => 'coupon-image-field',
				'options'  => array(
					'Yes',
					'No'
				),
				'help'     => ''
			),
			array(
				'id'          => 'coupon-image-width',
				'label'       => __( 'Coupon Image width', 'wpcd-coupon' ),
				'type'        => 'text',
				'tr_class'    => 'coupon-image-field',
				'placeholder' => 'e.g 60% or 200px',
				'help'        => ''
			),
			array(
				'id'          => 'coupon-image-height',
				'label'       => __( 'Coupon Image height', 'wpcd-coupon' ),
				'type'        => 'text',
				'tr_class'    => 'coupon-image-field',
				'placeholder' => 'e.g 60% or 200px',
				'help'        => ''
			)
		);
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 *
	 * @since 1.0
	 */
	public function add_meta_boxes() {
		foreach ( $this->post_types as $post_type ) {
			add_meta_box(
				'coupon-details',
				__( 'Coupon Details', 'wpcd-coupon' ),
				array( $this, 'add_meta_box_callback' ),
				$post_type,
				'normal',
				'core'
			);
		}
	}

	/**
	 * Generating the HTML for the meta box.
	 *
	 * @param object $post WordPress post object.
	 *
	 * @since 1.0
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'coupon_details_data', 'coupon_details_nonce' );
		$this->generate_wpcd_fields( $post );
	}

	/**
	 * Generating the field's HTML for the meta box.
	 *
	 * @param array $post post data.
	 *
	 * @since 1.0
	 */
	public function generate_wpcd_fields( $post ) {
		$expire_date_format = get_option( 'wpcd_expiry-date-format' );
		if ( empty( $expire_date_format ) ) {
			$expire_date_format = 'dd-mm-yy';
		}
			
		$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expire_date_format );
		
		$output           = '';
		$help             = '';

		foreach ( $this->wpcd_fields as $wpcd_field ) {
			$tr_class = '';
			if ( ! empty( $wpcd_field['tr_class'] ) ) {
				$tr_class = $wpcd_field['tr_class'];
			}
			$type     = $wpcd_field['type'];
            $label    = '<label for="' . $wpcd_field['id'] . '">' . $wpcd_field['label'] . '</label>
            <span wpcd-data-tooltip="'.$wpcd_field['help'].'">
            <span  class="dashicons dashicons-editor-help" ></span></span>';
            $wpcd_coupon_meta_key = 'coupon_details_' . $wpcd_field['id'];
            if( $wpcd_field['id'] == 'wpcd_description' ) $wpcd_coupon_meta_key = 'coupon_details_description';
			$db_value = get_post_meta( $post->ID, $wpcd_coupon_meta_key, true );
			if ( $wpcd_field['type'] == 'expiredate' || $wpcd_field['type'] == 'temp4-expiredate' ) {
				if ( ! empty( $db_value ) && ( (string)(int)$db_value ) == $db_value ) {
					$db_value = date( $expireDateFormatFun, $db_value );
				} elseif ( ! empty( $db_value ) ) {
					$db_value = date( $expireDateFormatFun, strtotime( $db_value ) );
				}
			}
			switch ( $wpcd_field['type'] ) {

				case 'dealtext':
					$input = sprintf(
						'<input type="text" name="%s" id="%s" value="%s"/>',
						$wpcd_field['id'],
						$wpcd_field['id'],
						$db_value
					);
					break;
					
				case 'temp4-dealtext':
					$input = sprintf(
						'<input type="text" name="%s" id="%s" value="%s"/>',
						$wpcd_field['id'],
						$wpcd_field['id'],
						$db_value
					);
					break;

				case 'buttontext':
					$input = sprintf(
						'<input type="text" name="%s" id="%s" value="%s"/>',
						$wpcd_field['id'],
						$wpcd_field['id'],
						$db_value
					);
					break;
				case 'temp4-buttontext':
					$input = sprintf(
						'<input type="text" name="%s" id="%s" value="%s"/>',
						$wpcd_field['id'],
						$wpcd_field['id'],
						$db_value
					);
					break;

				case 'temp4-text':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$wpcd_field['type'] !== 'color' ? 'class="regular-text"' : '',
						$wpcd_field['id'],
						$wpcd_field['id'],
						'text',
						$db_value
					);
					break;
				case 'date':
					$input = sprintf(
						'<input type="%s" name="%s" id="%s" value="%s" />',
						$wpcd_field['type'],
						$wpcd_field['id'],
						$wpcd_field['id'],
						$db_value
					);
					break;

				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$wpcd_field['id'],
						$wpcd_field['id']
					);
					foreach ( $wpcd_field['options'] as $key => $value ) {
						$field_value = ! is_numeric( $key ) ? $key : $value;
						$input       .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							$field_value,
							$value
						);
					}
					$input .= '</select>';
					break;

				case 'textarea':
					if ( $wpcd_field['id'] == 'wpcd_description' ):
						ob_start();
						/**
						* Add Editor to description field
						* 
						* @since 2.5.0.2
						*/
						$settings = array(
					   		'wpautop' => false, 
					   		'media_buttons' => false,
							'tinymce' => true,
							'textarea_rows' => 5,
							'editor_height' => 150,
							'teeny' => false,
							'quicktags' => false,
							'textarea_name' => "wpcd_description"
						);
						wp_editor( $db_value, 'wpcd_description' ,$settings);
						$input = ob_get_clean();
					else:
						$input = sprintf(
							'<textarea class="large-text" id="%s" name="%s" rows="5">%s</textarea>',
							$wpcd_field['id'],
							$wpcd_field['id'],
							$db_value
						);
					endif;
					break;

				case 'expirationcheck':
					$input = sprintf(
						'<input type="checkbox" name="%s" id="%s" value="%s"/>',
						$wpcd_field['id'],
						$wpcd_field['id'],
						$db_value
					);
					break;

				case 'expiredate':
					$input = sprintf(
						'<input type="text" data-expiredate-format="%s" name="%s" id="%s" placeholder="%s" value="%s"/>',
						$expire_date_format,
						$wpcd_field['id'],
						$wpcd_field['id'],
						$expire_date_format,
						$db_value
					);
					break;

				case 'temp4-expiredate':
					$input = sprintf(
						'<input type="text" data-expiredate-format="%s" name="%s" id="%s" placeholder="%s" value="%s"/>',
						$expire_date_format,
						$wpcd_field['id'],
						$wpcd_field['id'],
						$expire_date_format,
						$db_value
					);
					break;

				case 'expiretime':
					$input = sprintf(
						'<input type="text" name="%s" id="%s" value="%s"/>',
						$wpcd_field['id'],
						$wpcd_field['id'],
						$db_value
					);
					break;

				case 'coupon-image-row' :
					$id    = $wpcd_field['id'];
					$input = '';
					//Get upload url
					$upload_link = esc_url( get_upload_iframe_src( 'image', $db_value ) );
					// Get the image src
					$img_src      = wp_get_attachment_image_src( $db_value, 'full' );
					$you_have_img = is_array( $img_src );
					//img container
					$input .= '<div class="coupon-img-container" style="width:70%;">';
					if ( $you_have_img ) {
						$input .= '<img src="' . $img_src[0] . '" alt="" style="max-width:100%;"/>';
					}
					$input .= '</div>';
					//add image or remove
					$input .= '<div class="hide-if-no-js">';
					$input .= '<a class="upload-coupon-img button media-button ' . ( $you_have_img ? 'hidden' : '' ) . '" >' . __( 'Upload Coupon Image', 'wpcd-coupon' ) . '</a>';
					$input .= '<a class="red-text delete-coupon-img button media-button ' . ( $you_have_img ? '' : 'hidden' ) . '">' . __( 'Remove Coupon Image', 'wpcd-coupon' ) . '</a>';
					$input .= '</div>';
					//hidden input
					$input .= '<input class="' . $id . '" id="' . $id . '" name="' . $id . '" type="hidden" value="' . $db_value . '"/>
					';
					break;
				case 'colorpicker':
					$value = empty( $db_value ) ? $wpcd_field['default'] : $db_value;
					$input = '<div id="' . esc_attr( $wpcd_field['id'] ) . '" class="wpcd_colorSelectors">
	                    <div data-color="' . $value . '" style="background-color:' . $value . ';"></div>
	                    <input id="' . $wpcd_field['id'] . '" name="' . $wpcd_field['id'] . '" type="text" value="' . $value . '"/>
	                    </div>';
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s" placeholder="%s">',
						$wpcd_field['type'] !== 'color' ? 'class="regular-text"' : '',
						$wpcd_field['id'],
						$wpcd_field['id'],
						$wpcd_field['type'],
						$db_value,
						( empty( $wpcd_field['placeholder'] ) ? '' : $wpcd_field['placeholder'] )
					);
			}
			$output .= $this->row_format( $type, $label, $input, $tr_class );
		}
		echo '<table class="form-table"><tbody>' . $output . $help . '</tbody></table>';
		echo "<script>
				jQuery('#expire-time').timepicker({
					controlType: 'select',
					oneLine: true,
					timeFormat: 'h:m tt',
					showButtonPanel: false
				});
			 </script>";

		if ( wcad_fs()->is_not_paying() ) {
			echo '<p style="font-size: 16px;">' . __( 'Hide coupon, change templates and get many more features', 'wpcd-coupon' ) . '- ';

			echo '<a href="' . wcad_fs()->get_upgrade_url() . '">' .
			     __( 'Upgrade to Pro!', 'wpcd-coupon' ) .
			     '</a>';
			echo ' or ';
			echo '<a href="' . wcad_fs()->get_trial_url() . '">' .
			     __( 'Start 14 day Free Trial!', 'wpcd-coupon' ) .
			     '</a>';
		}

	}

	/**
	 * Generates the HTML for table rows.
	 *
	 * @since 1.0
	 */
	public function row_format( $type, $label, $input, $tr_class = '' ) {
		return sprintf(
			'<tr id="%s" class="%s"><th scope="row">%s</th><td>%s</td></tr>',
			$type,
			$tr_class,
			$label,
			$input
		);
	}

	/**
	 * Hooks into WordPress' save_post function.
	 *
	 * @since 1.0
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['coupon_details_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['coupon_details_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'coupon_details_data' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		foreach ( $this->wpcd_fields as $wpcd_field ) {
			if ( isset( $_POST[ $wpcd_field['id'] ] ) ) {
				switch ( $wpcd_field['type'] ) {
					case 'email':
						$_POST[ $wpcd_field['id'] ] = sanitize_email( $_POST[ $wpcd_field['id'] ] );
						break;
					case 'text':
						if($wpcd_field['id'] == 'link')
                            $_POST[ $wpcd_field['id'] ] = esc_url( $_POST[ $wpcd_field['id'] ] );
                        else
                            $_POST[ $wpcd_field['id'] ] = sanitize_text_field( $_POST[ $wpcd_field['id'] ] );
                        break;
				}

				if ( $wpcd_field['id'] == 'expire-date' ) {
                	$_POST[ $wpcd_field['id'] ] = strtotime( sanitize_text_field( $_POST[ $wpcd_field['id'] ] ) );
                } 
				if ( $wpcd_field['id'] == 'second-expire-date' ) {
                	$_POST[ $wpcd_field['id'] ] = strtotime( sanitize_text_field( $_POST[ $wpcd_field['id'] ] ) );
                } 
				if ( $wpcd_field['id'] == 'third-expire-date' ) {
                	$_POST[ $wpcd_field['id'] ] = strtotime( sanitize_text_field( $_POST[ $wpcd_field['id'] ] ) );
                } 
                
				$field_checker = 'coupon_details_' . $wpcd_field['id'];

				if ( $field_checker == 'coupon_details_hide-coupon' ) {
					update_post_meta( $post_id, 'coupon_details_' . $wpcd_field['id'], 'No' );
				} elseif ( $field_checker == 'coupon_details_coupon-template' ) {
					update_post_meta( $post_id, 'coupon_details_' . $wpcd_field['id'], 'Default' );
				} else {
                    $wpcd_coupon_meta_key = 'coupon_details_' . $wpcd_field['id'];
                    if( $wpcd_field['id'] == 'wpcd_description' ) $wpcd_coupon_meta_key = 'coupon_details_description';
					update_post_meta( $post_id, $wpcd_coupon_meta_key, $_POST[ $wpcd_field['id'] ] );
				}

			} else if ( $wpcd_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'coupon_details_' . $wpcd_field['id'], '0' );
			}
		}
	}

}