<?php

/**
 *
 * This exits from the script if it's accessed
 * directly from somewhere else.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Assets class.
 * This loads the necessary styles and scripts.
 *
 * @since 1.0
 */
class WPCD_Assets {

	/**
	 * Adding the assets with WordPress
	 *
	 * @since 1.0
	 */
	public static function wpcd_assets_init() {

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wpcd_stylesheets' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wpcd_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wpcd_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wpcd_admin_stylesheets' ) );

	}

	/**
	 * Stylesheets for the coupon shortcode ,widgets and custom css.
	 *
	 * @since 2.2.2
	 */
	public static function wpcd_stylesheets() {

		wp_enqueue_style( 'wpcd-style', WPCD_Plugin::instance()->plugin_assets . 'css/style.css', false, WPCD_Plugin::PLUGIN_VERSION );

		$coupon_type_color = get_option( 'wpcd_coupon-type-bg-color' );

		$inline_style = "
                    
			.coupon-type {
				background-color: {$coupon_type_color};
			}
				 
		";

		$inline_style = preg_replace('/\s+/', ' ', $inline_style );

		wp_add_inline_style( 'wpcd-style', $inline_style  );

		if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->is_trial() ) {

			$hide_coupon_button_color = get_option( 'wpcd_hidden-coupon-button-color' );
			$copy_button_bg_color     = get_option( 'wpcd_copy-button-bg-color' );
			$coupon_popup_bg_color    = get_option( 'wpcd_coupon-popup-bg-color' );
			$pagination_color         = get_option( 'wpcd_pagination-color' );

			$wpcd_inline_style = "
                    
				.wpcd-coupon-button-type .coupon-code-wpcd .get-code-wpcd{
					background-color:{$hide_coupon_button_color};
				}
			
				.wpcd-coupon-button-type .coupon-code-wpcd .get-code-wpcd:after{
					border-left-color:{$hide_coupon_button_color};
				}
			
				span.wpcd_coupon_top_copy_span{
					background-color: {$copy_button_bg_color} !important;
				}
			
				.wpcd_coupon_popup_copy_code_wr {
					background-color: {$coupon_popup_bg_color};
					border-color: {$copy_button_bg_color};
				}
			
				.wpcd_popup-go-link {
					background-color: {$copy_button_bg_color};
				}
			
				.wpcd_popup-go-link:hover {
					background-color: {$copy_button_bg_color};
				}
			
				#wpcd_coupon_pagination_wr a, #wpcd_coupon_pagination_wr span {
					background-color: {$pagination_color};
				}
			 
			";

			$wpcd_inline_style = preg_replace('/\s+/', ' ', $wpcd_inline_style );

			//add changes to stylesheet
			wp_add_inline_style( 'wpcd-style', $wpcd_inline_style );

		}

	}

	/**
	 * Scripts for the coupon shortcode.
	 *
	 * @since 1.0
	 */
	public static function wpcd_scripts() {

		wp_register_script( 'wpcd-main-js', WPCD_Plugin::instance()->plugin_assets . 'js/main.js', array( 'jquery' ), WPCD_Plugin::PLUGIN_VERSION, true );
		wp_register_script( 'wpcd-clipboardjs', WPCD_Plugin::instance()->plugin_assets . 'js/clipboard.min.js', null, WPCD_Plugin::PLUGIN_VERSION, false );

		wp_enqueue_script( 'wpcd-main-js' );
		wp_enqueue_script( 'wpcd-clipboardjs' );
                
        //To make sure that "ajax_url" is defined in main.js
        wp_localize_script( 'wpcd-main-js', 'wpcd_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		
        $word_count = get_option( 'wpcd_words-count' );
		if ( empty( $word_count ) ) {
			$word_count = 30;
		}

		$copy_button_text = get_option( 'wpcd_copy-button-text' );
		$after_copy_text  = get_option( 'wpcd_after-copy-text' );
		$vote_success = get_option( 'wpcd_coupon-vote-success' );
		$vote_failed = get_option( 'wpcd_coupon-vote-fail' );
		$vote_already = get_option( 'wpcd_coupon-vote-already' );

		if ( ! empty( $vote_success ) ) {
			$vote_success_message = $vote_success;
		} else {
			$vote_success_message = __( 'You have voted successfully!', 'wpcd-coupon' );
		}

		if ( ! empty( $vote_failed ) ) {
			$vote_failed_message = $vote_failed;
		} else {
			$vote_failed_message = __( 'Voting failed!', 'wpcd-coupon' );
		}

		if ( ! empty( $vote_already ) ) {
			$vote_already_message = $vote_already;
		} else {
			$vote_already_message = __( 'You have voted already!', 'wpcd-coupon' );
		}

		if ( ! empty( $copy_button_text ) ) {
			$button_text = $copy_button_text;
		} else {
			$button_text = __( 'Copy', 'wpcd-coupon' );
		}

		if ( ! empty( $after_copy_text ) ) {
			$after_copy = $after_copy_text;
		} else {
			$after_copy = __( 'Copied', 'wpcd-coupon' );
		}

		wp_localize_script( 'wpcd-main-js', 'wpcd_main_js', array(
			'minutes'      => __( 'minutes', 'wpcd-coupon' ),
			'seconds'      => __( 'seconds', 'wpcd-coupon' ),
			'hours'        => __( 'hours', 'wpcd-coupon' ),
			'day'          => __( 'day', 'wpcd-coupon' ),
			'week'         => __( 'week', 'wpcd-coupon' ),
			'expired_text' => __( 'This offer has expired!', 'wpcd-coupon' ),
			'word_count'   => $word_count,
			'button_text'  => $button_text,
			'after_copy'   => $after_copy,
			'vote_success' => $vote_success_message,
			'vote_fail' => $vote_failed_message,
			'vote_already' => $vote_already_message
		) );

		if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->is_trial() ) {
			wp_enqueue_script( 'wpcd-countdown-js', WPCD_Plugin::instance()->plugin_assets . 'js/jquery.countdown.min.js', false, WPCD_Plugin::PLUGIN_VERSION, false );
		}

	}

	/**
	 * Stylesheets for admin area.
	 *
	 * @since 1.0
	 */
	public static function wpcd_admin_stylesheets( $hook_suffix ) {

		/**
		 * Loading script only where necessary.
		 *
		 * @since 1.2
		 */
		$custom_post_type = 'wpcd_coupons';

		if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {

			$screen = get_current_screen();

			if ( is_object( $screen ) && $custom_post_type == $screen->post_type ) {

				wp_enqueue_style( 'wpcd-jquery-ui-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/jquery-ui.css', false, WPCD_Plugin::PLUGIN_VERSION );

			}
		}

		if ( in_array( $hook_suffix, array( 'edit.php', 'post.php', 'post-new.php' ) ) ) {

			$screen = get_current_screen();

			if ( is_object( $screen ) && $custom_post_type == $screen->post_type ) {

				wp_enqueue_style( 'wpcd-admin-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/admin.css', false, WPCD_Plugin::PLUGIN_VERSION );
				wp_enqueue_style( 'wpcd-admin-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/select2.min.css', false, WPCD_Plugin::PLUGIN_VERSION );
				wp_enqueue_style( 'wpcd-color-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/colorpicker.css', false );
			}
		}

		if ( in_array( $hook_suffix, array( 'edit.php', 'post.php', 'post-new.php' ) ) ) {

			wp_enqueue_style( 'wpcd-admin-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/admin.css', false, WPCD_Plugin::PLUGIN_VERSION );

		}

	}

	/**
	 * Scripts for admin area.
	 *
	 * @since 1.0
	 */
	public static function wpcd_admin_scripts( $hook_suffix ) {

		/**
		 * Loading script only where necessary.
		 *
		 * @since 1.2
		 */
		$custom_post_type = 'wpcd_coupons';

		if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {

			$screen = get_current_screen();

			if ( is_object( $screen ) && $custom_post_type == $screen->post_type ) {

				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'wpcd-jquery-ui-timepicker', WPCD_Plugin::instance()->plugin_assets . 'admin/js/jquery-ui-timepicker.js', array( 'jquery' ), WPCD_Plugin::PLUGIN_VERSION, false );
				wp_enqueue_script( 'wpcd-countdown-js', WPCD_Plugin::instance()->plugin_assets . 'js/jquery.countdown.min.js', false, WPCD_Plugin::PLUGIN_VERSION, false );
				wp_enqueue_script( 'wpcd-color-script', WPCD_Plugin::instance()->plugin_assets . 'admin/js/colorpicker.js', array( 'jquery' ), WPCD_Plugin::PLUGIN_VERSION, true );

			}

		}

		wp_enqueue_script( 'wpcd-admin-js', WPCD_Plugin::instance()->plugin_assets . 'admin/js/admin.js', array(
			'jquery',
			'jquery-ui-datepicker',
			'wp-color-picker'
		), WPCD_Plugin::PLUGIN_VERSION, false );


	}

}
