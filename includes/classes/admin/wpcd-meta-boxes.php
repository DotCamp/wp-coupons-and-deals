<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/wpcd-meta-boxes-fields.php';

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

		$this->wpcd_fields= WPCD_Meta_Boxes_Fields::getFields();
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
				__( 'Coupon Details', 'wp-coupons-and-deals' ),
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

		$kses_array = array('table' => array(
								'class' => array()
							),
							'tbody' => array(),
							'tr' => array(
								'id' => array(),
								'class' => array()
							),
							'th' => array(
								'scope' => array()
							),
							'td' => array(),
							'label' => array(
								'for' => array()
							),
							'span' => array(
								'wpcd-data-tooltip' => array(),
								'class' => array()
							),
							'div' => array(
								'class' => array(),
								'id' => array(),
								'data-color' => array(),
								'style' => array()
							),
							'img' => array(
								'src' => array(),
								'alt' => array(),
								'style' => array()
							),
							'a' => array(
								'class' => array()
							),
							'input' => array(
								'type' => array(),
								'name' => array(),
								'class' => array(),
								'id' => array(),
								'value' => array(),
								'placeholder' => array(),
								'data-expiredate-format' => array()
							),
							'textarea' => array(
								'class' => array(),
								'id' => array(),
								'name' => array(),
								'rows' => array()
							),
							'select' => array(
								'id' => array(),
								'name' => array()
							),
							'option' => array(
								'selected' => array(),
								'value' => array()
							)
						);

		foreach ( $this->wpcd_fields as $wpcd_field ) {
			$tr_class = '';
			if ( ! empty( $wpcd_field['tr_class'] ) ) {
				$tr_class = $wpcd_field['tr_class'];
			}
			$type     = $wpcd_field['type'];
			$label    = '<label for="' . esc_attr( $wpcd_field['id'] ) . '">' . esc_html( $wpcd_field['label'] ) . '</label>
						<span wpcd-data-tooltip="' . esc_attr( $wpcd_field['help'] ) . '">
						<span  class="dashicons dashicons-editor-help" ></span></span>';
            $wpcd_coupon_meta_key = 'coupon_details_' . $wpcd_field['id'];
            if( $wpcd_field['id'] == 'wpcd_description' ) $wpcd_coupon_meta_key = 'coupon_details_description';
			$db_value = get_post_meta( absint($post->ID), $wpcd_coupon_meta_key, true );
			if ( $wpcd_field['type'] == 'expiredate' || $wpcd_field['type'] == 'temp4-expiredate' ) {
				if ( ! empty( $db_value ) && ( (string)(int)$db_value ) == $db_value ) {
					$db_value = date( $expireDateFormatFun, $db_value );
				} elseif ( ! empty( $db_value ) ) {
					$db_value = date( $expireDateFormatFun, strtotime( $db_value ) );
				}
			}
			switch ( $wpcd_field['type'] ) {

				case 'dealtext':
				case 'temp4-dealtext':
				case 'buttontext':
				case 'temp4-buttontext':
					$input = sprintf(
						'<input type="text" name="%s" id="%s" value="%s"/>',
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $db_value )
					);
					break;

				case 'temp4-text':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="text" value="%s">',
						$wpcd_field['type'] !== 'color' ? 'class="regular-text"' : '',
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $db_value )
					);
					break;
				case 'date':
					$input = sprintf(
						'<input type="%s" name="%s" id="%s" value="%s" />',
						esc_attr( $wpcd_field['type'] ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $db_value )
					);
					break;

				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['id'] )
					);
					foreach ( $wpcd_field['options'] as $key => $value ) {
						$field_value = ! is_numeric( $key ) ? $key : $value;
						$input       .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							esc_attr( $field_value ),
							esc_attr( $value )
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
							esc_attr( $wpcd_field['id'] ),
							esc_attr( $wpcd_field['id'] ),
							esc_textarea( $db_value )
						);
					endif;
					break;

				case 'expirationcheck':
					$input = sprintf(
						'<input type="checkbox" name="%s" id="%s" value="%s"/>',
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $db_value )
					);
					break;

				case 'expiredate':
				case 'temp4-expiredate':
					$input = sprintf(
						'<input type="text" data-expiredate-format="%s" name="%s" id="%s" placeholder="%s" value="%s"/>',
						esc_attr( $expire_date_format ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $expire_date_format ),
						esc_attr( $db_value )
					);
					break;

				case 'expiretime':
					$input = sprintf(
						'<input type="text" name="%s" id="%s" value="%s"/>',
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $db_value )
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
						$input .= '<img src="' . esc_url( $img_src[0] ) . '" alt="" style="max-width:100%;"/>';
					}
					$input .= '</div>';
					//add image or remove
					$input .= '<div class="hide-if-no-js">';
					$input .= '<a class="upload-coupon-img button media-button ' . ( $you_have_img ? 'hidden' : '' ) . '" >' . __( 'Upload Coupon Image', 'wp-coupons-and-deals' ) . '</a>';
					$input .= '<a class="red-text delete-coupon-img button media-button ' . ( $you_have_img ? '' : 'hidden' ) . '">' . __( 'Remove Coupon Image', 'wp-coupons-and-deals' ) . '</a>';
					$input .= '</div>';
					//hidden input
					$input .= '<input class="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" type="hidden" value="' . esc_attr( $db_value ) . '"/>
					';
					break;
				case 'colorpicker':
					$value = empty( $db_value ) ? $wpcd_field['default'] : $db_value;
					$input = '<div id="' . esc_attr( $wpcd_field['id'] ) . '" class="wpcd_colorSelectors">
	                    <div data-color="' . sanitize_hex_color( $value ) . '" style="background-color:' . sanitize_hex_color( $value ) . ';"></div>
	                    <input id="' . esc_attr( $wpcd_field['id'] ) . '" name="' . esc_attr( $wpcd_field['id'] ) . '" type="text" value="' . sanitize_hex_color( $value ) . '"/>
	                    </div>';
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s" placeholder="%s">',
						$wpcd_field['type'] !== 'color' ? 'class="regular-text"' : '',
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['id'] ),
						esc_attr( $wpcd_field['type'] ),
						$wpcd_field['type'] === 'color' ? sanitize_hex_color( $db_value ) : esc_attr( $db_value ),
						( empty( $wpcd_field['placeholder'] ) ? '' : esc_attr( $wpcd_field['placeholder'] ) )
					);
			}
			$output .= $this->row_format( esc_attr( $type ), $label, $input, esc_attr( $tr_class ) );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
		echo "<script>
				jQuery('#expire-time').timepicker({
					controlType: 'select',
					oneLine: true,
					timeFormat: 'h:m tt',
					showButtonPanel: false
				});
			 </script>";

		if ( wcad_fs()->is_not_paying() ) {
			echo '<p style="font-size: 16px;">' . __( 'Hide coupon, change templates and get many more features', 'wp-coupons-and-deals' ) . '- ';

			echo '<a href="' . esc_url( wcad_fs()->get_upgrade_url() ). '">' .
			     __( 'Upgrade to Pro!', 'wp-coupons-and-deals' ) .
			     '</a>';
			echo ' or ';
			echo '<a href="' . esc_url( wcad_fs()->get_trial_url() ) . '">' .
			     __( 'Start 14 day Free Trial!', 'wp-coupons-and-deals' ) .
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
                            $_POST[ $wpcd_field['id'] ] = esc_url_raw( $_POST[ $wpcd_field['id'] ] );
                        else
                            $_POST[ $wpcd_field['id'] ] = sanitize_text_field( $_POST[ $wpcd_field['id'] ] );
                        break;
				}

				if ( in_array( $wpcd_field['id'], array('expire-date', 'second-expire-date', 'third-expire-date') ) ) {
                	$_POST[ $wpcd_field['id'] ] = strtotime( sanitize_text_field( $_POST[ $wpcd_field['id'] ] ) );
                }

				$field_checker = 'coupon_details_' . $wpcd_field['id'];

				if ( $field_checker == 'coupon_details_hide-coupon' ) {
					update_post_meta( $post_id, 'coupon_details_' . sanitize_text_field($wpcd_field['id']), 'No' );
				} elseif ( $field_checker == 'coupon_details_coupon-template' ) {
					update_post_meta( $post_id, 'coupon_details_' . sanitize_text_field($wpcd_field['id']), 'Default' );
				} else {
                    $wpcd_coupon_meta_key = 'coupon_details_' . $wpcd_field['id'];
                    if( $wpcd_field['id'] == 'wpcd_description' ) $wpcd_coupon_meta_key = 'coupon_details_description';
					update_post_meta( $post_id, $wpcd_coupon_meta_key, wp_kses_post( $_POST[ $wpcd_field['id'] ] ) );
				}

			} else if ( $wpcd_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'coupon_details_' . $wpcd_field['id'], '0' );
			}
		}
	}

}
