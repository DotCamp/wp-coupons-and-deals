<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Constants Class
 * 
 * Defines all plugin constants in one place
 * Eliminates magic strings and numbers throughout the codebase
 *
 * @since 3.3.0
 */
class WPCD_Constants {

	/**
	 * Plugin Version
	 */
	const VERSION = '3.2.4';

	/**
	 * Post Type and Taxonomy Names
	 */
	const POST_TYPE = 'wpcd_coupons';
	const TAXONOMY_CATEGORY = 'wpcd_coupon_category';
	const TAXONOMY_VENDOR = 'wpcd_coupon_vendor';

	/**
	 * Text Domain
	 */
	const TEXT_DOMAIN = 'wp-coupons-and-deals';

	/**
	 * Meta Keys
	 */
	const META_PREFIX = 'coupon_details_';
	
	// Coupon Details Meta Keys
	const META_COUPON_TYPE = 'coupon_details_coupon-type';
	const META_COUPON_CODE = 'coupon_details_coupon-code-text';
	const META_DESCRIPTION = 'coupon_details_description';
	const META_DISCOUNT_TEXT = 'coupon_details_discount-text';
	const META_LINK = 'coupon_details_link';
	const META_COUPON_TEMPLATE = 'coupon_details_coupon-template';
	const META_EXPIRE_DATE = 'coupon_details_expire-date';
	const META_SECOND_EXPIRE_DATE = 'coupon_details_second-expire-date';
	const META_THIRD_EXPIRE_DATE = 'coupon_details_third-expire-date';
	const META_NEVER_EXPIRE = 'coupon_details_never-expire-check';
	const META_HIDE_COUPON = 'coupon_details_hide-coupon';
	const META_COUPON_HOVER_TEXT = 'coupon_details_coupon-hover-text';
	const META_BUTTON_TEXT = 'coupon_details_coupon-button-text';
	const META_DEAL_TEXT = 'coupon_details_deal-button-text';

	// Statistics Meta Keys
	const META_VIEW_COUNT = 'coupon_view_count';
	const META_CLICK_COUNT = 'coupon_click_count';

	/**
	 * Template Names
	 */
	const TEMPLATE_DEFAULT = 'Default';
	const TEMPLATE_ONE = 'Template One';
	const TEMPLATE_TWO = 'Template Two';
	const TEMPLATE_THREE = 'Template Three';
	const TEMPLATE_FOUR = 'Template Four';
	const TEMPLATE_FIVE = 'Template Five';
	const TEMPLATE_SIX = 'Template Six';
	const TEMPLATE_SEVEN = 'Template Seven';
	const TEMPLATE_EIGHT = 'Template Eight';
	const TEMPLATE_NINE = 'Template Nine';

	/**
	 * Coupon Types
	 */
	const COUPON_TYPE_CODE = 'Coupon';
	const COUPON_TYPE_DEAL = 'Deal';
	const COUPON_TYPE_IMAGE = 'Image';

	/**
	 * AJAX Actions
	 */
	const AJAX_CATEGORY_ACTION = 'wpcd_coupons_category_action';
	const AJAX_CAT_VEND_ACTION = 'wpcd_coupons_cat_vend_action';
	const AJAX_CLICKED_ACTION = 'wpcd_coupon_clicked_action';
	const AJAX_TRACK_CLICK = 'wpcd_track_click';

	/**
	 * Nonce Actions
	 */
	const NONCE_ACTION = 'wpcd-security-nonce';
	const NONCE_FIELD = 'security';

	/**
	 * Default Values
	 */
	const DEFAULT_COUPON_COUNT = 9;
	const DEFAULT_SORT_ORDER = 'newest';
	const DEFAULT_DATE_FORMAT = 'd-m-Y';

	/**
	 * Capability
	 */
	const ALLOWED_ROLE_META_CAP = 'wpcd_allowed_cap';

	/**
	 * Shortcode Names
	 */
	const SHORTCODE_COUPON = 'wpcd_coupon';
	const SHORTCODE_CODE = 'wpcd_code';
	const SHORTCODE_COUPONS = 'wpcd_coupons';
	const SHORTCODE_COUPONS_LOOP = 'wpcd_coupons_loop';
	const SHORTCODE_FORM = 'wpcd_form';

	/**
	 * CSS Classes
	 */
	const CSS_PREFIX = 'wpcd-';
	const CSS_COUPON_CODE = 'wpcd-coupon-code';
	const CSS_CODE_TEXT = 'wpcd-code-text';
	const CSS_BUTTON = 'wpcd-btn';
	const CSS_COUPON_CONTAINER = 'wpcd-coupon-container';

	/**
	 * Date Formats
	 */
	const DATE_FORMAT_DEFAULT = 'd-m-Y';
	const DATE_FORMAT_MYSQL = 'Y-m-d H:i:s';

	/**
	 * Pagination
	 */
	const POSTS_PER_PAGE = 9;

	/**
	 * Sort Options
	 */
	const SORT_NEWEST = 'newest';
	const SORT_OLDEST = 'oldest';
	const SORT_EXPIRE_FIRST = 'expired-first';
	const SORT_EXPIRE_LAST = 'expired-last';

	/**
	 * Template Types for Factory
	 */
	const TEMPLATE_TYPE_SHORTCODE = 'shortcode';
	const TEMPLATE_TYPE_ARCHIVE = 'archive';
	const TEMPLATE_TYPE_CATEGORY = 'category';

	/**
	 * Settings Keys (without prefix)
	 */
	const SETTING_HIDE_EXPIRED = 'wpcd_hide-expired-coupon';
	const SETTING_ENABLE_STATS = 'wpcd_enable-stats-count';
	const SETTING_POPUP_GOTO_LINK = 'wpcd_popup-goto-link';
	const SETTING_ARCHIVE_MENU_CATEGORIES = 'wpcd_archive-munu-categories';

	/**
	 * Get meta key with prefix
	 *
	 * @param string $key Key without prefix
	 * @return string Full meta key
	 */
	public static function get_meta_key( $key ) {
		return self::META_PREFIX . $key;
	}

	/**
	 * Get all template names as array
	 *
	 * @return array Template names
	 */
	public static function get_template_names() {
		return array(
			self::TEMPLATE_DEFAULT,
			self::TEMPLATE_ONE,
			self::TEMPLATE_TWO,
			self::TEMPLATE_THREE,
			self::TEMPLATE_FOUR,
			self::TEMPLATE_FIVE,
			self::TEMPLATE_SIX,
			self::TEMPLATE_SEVEN,
			self::TEMPLATE_EIGHT,
			self::TEMPLATE_NINE
		);
	}

	/**
	 * Get all coupon types
	 *
	 * @return array Coupon types
	 */
	public static function get_coupon_types() {
		return array(
			self::COUPON_TYPE_CODE,
			self::COUPON_TYPE_DEAL,
			self::COUPON_TYPE_IMAGE
		);
	}

	/**
	 * Get all sort options
	 *
	 * @return array Sort options
	 */
	public static function get_sort_options() {
		return array(
			self::SORT_NEWEST => __( 'Newest First', self::TEXT_DOMAIN ),
			self::SORT_OLDEST => __( 'Oldest First', self::TEXT_DOMAIN ),
			self::SORT_EXPIRE_FIRST => __( 'Expire First', self::TEXT_DOMAIN ),
			self::SORT_EXPIRE_LAST => __( 'Expire Last', self::TEXT_DOMAIN )
		);
	}
}