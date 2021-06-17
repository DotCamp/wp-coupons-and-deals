<?php


/**
 * field values for meta boxes fields
 * Class WPCD_Meta_Boxes_Fields
 */
class WPCD_Meta_Boxes_Fields {

	/**
	 * get fields of meta box
	 * @return array meta box fields
	 */
	public static function getFields() {
		return
			array(
				array(
					'id'      => 'coupon-type',
					'label'   => __( 'Coupon Type', 'wpcd-coupon' ),
					'type'    => 'select',
					'help'    => __( 'Coupon Type. Coupon will display a coupon code which will be copied when user clicks on it. Deal will display a link to get the deal instead of coupon code.',
						'wpcd-coupon' ),
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
					'help'  => __( 'Put your coupon code here. This will be copied when user clicks on it.',
						'wpcd-coupon' )
				),
				array(
					'id'    => 'second-coupon-code-text',
					'label' => __( 'Second Coupon Code', 'wpcd-coupon' ),
					'type'  => 'temp4-buttontext',
					'help'  => __( 'Put your coupon code here. This will be copied when user clicks on it.',
						'wpcd-coupon' )
				),
				array(
					'id'    => 'third-coupon-code-text',
					'label' => __( 'Third Coupon Code', 'wpcd-coupon' ),
					'type'  => 'temp4-buttontext',
					'help'  => __( 'Put your coupon code here. This will be copied when user clicks on it.',
						'wpcd-coupon' )
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
					'help'  => __( 'Link to be opened when clicked on coupon code. You can use your affiliate links.',
						'wpcd-coupon' )
				),
				array(
					'id'    => 'second-link',
					'label' => __( 'Second Link', 'wpcd-coupon' ),
					'type'  => 'temp4-text',
					'help'  => __( 'Link to be opened when clicked on coupon code. You can use your affiliate links.',
						'wpcd-coupon' )
				),
				array(
					'id'    => 'third-link',
					'label' => __( 'Third Link', 'wpcd-coupon' ),
					'type'  => 'temp4-text',
					'help'  => __( 'Link to be opened when clicked on coupon code. You can use your affiliate links.',
						'wpcd-coupon' )
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
					'help'  => __( 'A little description so users know what the coupon code or deal is about.',
						'wpcd-coupon' )
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
					'help'  => __( 'Choose a date this coupon will expire. If you leave this blank, shortcode will show the message Doesn\'t expire.',
						'wpcd-coupon' )
				),
				array(
					'id'    => 'second-expire-date',
					'label' => __( 'Expiration Date (Second Coupon)', 'wpcd-coupon' ),
					'type'  => 'temp4-expiredate',
					'help'  => __( 'Choose a date this coupon will expire. If you leave this blank, shortcode will show the message Doesn\'t expire.',
						'wpcd-coupon' )
				),
				array(
					'id'    => 'third-expire-date',
					'label' => __( 'Expiration Date (Third Coupon)', 'wpcd-coupon' ),
					'type'  => 'temp4-expiredate',
					'help'  => __( 'Choose a date this coupon will expire. If you leave this blank, shortcode will show the message Doesn\'t expire.',
						'wpcd-coupon' )
				),
				array(
					'id'    => 'expire-time',
					'label' => __( 'Expiration Time', 'wpcd-coupon' ),
					'type'  => 'expiretime',
					'help'  => __( 'Choose expiration time of the coupon.', 'wpcd-coupon' )
				),
				array(
					'id'    => 'never-expire-check',
					'label' => __( 'Never expire', 'wpcd-coupon' ),
					'type'  => 'neverexpire-checkbox',
					'help'  => __( 'Check this if the coupon never expires.', 'wpcd-coupon' )
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
					'label'    => __( 'Coupon Image', 'wpcd-coupon' ),
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
}
