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
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wpcd_load_dashicons_front_end' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wpcd_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wpcd_admin_stylesheets' ) );

	}

	/**
	 * Stylesheets for the coupon shortcode ,widgets and custom css.
	 *
	 * @since 2.2.2
	 */
	public static function wpcd_stylesheets( $amp = false, $coupon_id = false, $coupon_template = false ) {
		if ( ! $amp ) {
			wp_enqueue_style( 'wpcd-style', WPCD_Plugin::instance()->plugin_assets . 'css/' . self::wpcd_version_correct( 'dir' ) . 'style' . self::wpcd_version_correct( 'suffix' ) . '.css', false, WPCD_Plugin::PLUGIN_VERSION );
		}

		$custom_css = get_option( 'wpcd_custom-css' );

		$coupon_type_color = get_option( 'wpcd_coupon-type-bg-color' );
		$coupon_border_color = get_option( 'wpcd_dt-border-color' );

		$hide_featured_image = get_option( 'wpcd_hide-archive-thumbnail' );
		if ( $amp ) {
			$output_for_amp = '';
		}

		if ( $hide_featured_image === 'on' ) {

			$custom_style = "

				#wpcd_coupon_ul li.wpcd_coupon_li {
					min-height: initial;
				}
				
				.wpcd_coupon_li_inner {
					height: auto;
				}

				.wpcd_coupon_li_content {
					height: auto;
					padding: 10px;
				}

			";

			$custom_style = preg_replace( '/\s+/', ' ', $custom_style );

			if ( ! $amp ) {
				wp_add_inline_style( 'wpcd-style', $custom_style  );
			} else {
				$output_for_amp .= $custom_style;
			}

		}

		$inline_style = "
                    
			.coupon-type {
				background-color: {$coupon_type_color};
			}

			.deal-type {
				background-color: {$coupon_type_color};
			}

			.wpcd-coupon {
				border-color: {$coupon_border_color};
			}

		";

		$inline_style = preg_replace( '/\s+/', ' ', $inline_style );

		if ( ! $amp ) {
			wp_add_inline_style( 'wpcd-style', $inline_style  );
		} else {
			$output_for_amp .= $inline_style;
		}

		$custom_css = preg_replace( '/\s+/', ' ', $custom_css );

		if ( ! $amp ) {
			wp_add_inline_style( 'wpcd-style', $custom_css  );
		} else {
			$output_for_amp .= $custom_css;
		}

		if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {

			$hide_coupon_button_color = get_option( 'wpcd_hidden-coupon-button-color' );
			$copy_button_bg_color     = get_option( 'wpcd_copy-button-bg-color' );
            if ( ! $amp ) $copy_button_bg_color = $copy_button_bg_color . ' !important';
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
					background-color: {$copy_button_bg_color};
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

			$wpcd_inline_style = preg_replace( '/\s+/', ' ', $wpcd_inline_style );

			//add changes to stylesheet
			if ( ! $amp ) {
				wp_add_inline_style( 'wpcd-style', $wpcd_inline_style );
			} else {
				$output_for_amp .= $wpcd_inline_style;
			}

			if ( $amp ) {
				$coupon_theme_color = "";
				if ( $coupon_template === 'Template Five' ) {

				} elseif ( $coupon_template === 'Template Six' ) {

				} elseif ( $coupon_template === 'Template Eight' ) {
					$wpcd_template_eight_theme  = get_post_meta( $coupon_id, 'coupon_details_template-eight-theme', true );
					$coupon_theme_color = "
	                    
						a.wpcd-new-coupon-code:hover {
							border-color: {$wpcd_template_eight_theme};
						}

					";
				}
				if ( $coupon_theme_color ) {
					$coupon_theme_color = preg_replace( '/\s+/', ' ', $coupon_theme_color );
					$output_for_amp .= $coupon_theme_color;
				}
			}


		}

		if ( $amp ) {
			return $output_for_amp;
		}

	}

    /**
     * Get URL of a frontend CSS file
     *
     * @since 3.0.3
     */
    public static function wpcd_frontend_css_url_get() {
        return WPCD_Plugin::instance()->plugin_assets . 'css/' . self::wpcd_version_correct( 'dir' ) . 'style' . self::wpcd_version_correct( 'suffix' ) . '.css';
    }

	/**
	 * Scripts for the coupon shortcode.
	 *
	 * @since 1.0
	 */
	public static function wpcd_scripts() {

		wp_register_script( 'wpcd-main-js', WPCD_Plugin::instance()->plugin_assets . 'js/main.js', array( 'jquery' ), WPCD_Plugin::PLUGIN_VERSION, false );
		wp_register_script( 'wpcd-clipboardjs', WPCD_Plugin::instance()->plugin_assets . 'js/clipboard.min.js', null, WPCD_Plugin::PLUGIN_VERSION, false );

		wp_enqueue_script( 'wpcd-main-js' );
		wp_enqueue_script( 'wpcd-clipboardjs' );

        //To make sure that "ajax_url" is defined in main.js
        wp_localize_script(
        	'wpcd-main-js',
        	'wpcd_object',
        	[
			  	'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			  	'security'  => wp_create_nonce( 'wpcd-security-nonce' ),
			]
		);

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
			'vote_fail'    => $vote_failed_message,
			'vote_already' => $vote_already_message
		) );

		if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
			wp_enqueue_script( 'wpcd-countdown-js', WPCD_Plugin::instance()->plugin_assets . 'js/jquery.countdown.min.js', false, WPCD_Plugin::PLUGIN_VERSION, false );
		}

	}

    /*
     * Dashicons Connection
     *
     * @since 2.7.3
     */
    public static function wpcd_load_dashicons_front_end() {
        wp_enqueue_style( 'dashicons' );
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
		$screen = get_current_screen();
		if ( is_object( $screen ) && $custom_post_type == $screen->post_type ) {

			if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {

				wp_enqueue_style( 'wpcd-jquery-ui-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/' . self::wpcd_version_correct( 'dir' ) . 'jquery-ui' . self::wpcd_version_correct( 'suffix' ) . '.css', false, WPCD_Plugin::PLUGIN_VERSION );

			}

			wp_enqueue_style( 'wpcd-admin-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/' . self::wpcd_version_correct( 'dir' ) . 'admin' . self::wpcd_version_correct( 'suffix' ) . '.css', false, WPCD_Plugin::PLUGIN_VERSION );

			if ( in_array( $hook_suffix, array( 'edit.php', 'post.php', 'post-new.php' ) ) ) {

				wp_enqueue_style( 'wpcd-admin-style', WPCD_Plugin::instance()->plugin_assets . 'admin/css/select2.min.css', false, WPCD_Plugin::PLUGIN_VERSION );

			}


			$coupon_type_color = get_option( 'wpcd_coupon-type-bg-color' );
			$coupon_border_color = get_option( 'wpcd_dt-border-color' );

			$inline_style = "
                    
					.coupon-type {
						background-color: {$coupon_type_color};
					}
		
					.deal-type {
						background-color: {$coupon_type_color};
					}
		
					.wpcd-coupon {
						border-color: {$coupon_border_color};
					}
		
				";

			$inline_style = preg_replace( '/\s+/', '', $inline_style );

			wp_add_inline_style( 'wpcd-admin-style', $inline_style  );

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
		$screen = get_current_screen();
		if ( is_object( $screen ) && $custom_post_type == $screen->post_type ) {
			if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {

				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'wpcd-jquery-ui-timepicker', WPCD_Plugin::instance()->plugin_assets . 'admin/js/jquery-ui-timepicker.js', array( 'jquery' ), WPCD_Plugin::PLUGIN_VERSION, false );
				wp_enqueue_script( 'wpcd-countdown-js', WPCD_Plugin::instance()->plugin_assets . 'js/jquery.countdown.min.js', false, WPCD_Plugin::PLUGIN_VERSION, false );
				//To add custom javascript code to tinymce editor at initiation
				add_filter( 'tiny_mce_before_init', array( __CLASS__, 'wpcd_tiny_mce' ) );
				// color Picker
				wp_enqueue_script( 'wp-color-picker' );
                wp_enqueue_style( 'wp-color-picker' );

			}

			wp_enqueue_script( 'wpcd-admin-js', WPCD_Plugin::instance()->plugin_assets . 'admin/js/admin.js', array(
				'jquery',
				'jquery-ui-datepicker',
				'wp-color-picker'
			), WPCD_Plugin::PLUGIN_VERSION, false );

			$ajax_data = array(
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'wpcd-script-nonce' ),
			);

			wp_localize_script( 'wpcd-admin-js', 'wpcd_ajax_script_import', $ajax_data );
		}
	}
    /**
     * to add custom javascript code tinymce Editor at initiation
     *
     * @since 2.6.2
     * @param array $initArray
     * @return array
     */
    public static function wpcd_tiny_mce( $initArray ) {

        /*
         * change description dynamically in live preview
         *
         * VERY IMPORTANT: don't change the spaces in this code !!!!
         * @since 2.6.2
         */
        $initArray['toolbar1'] = "bold,italic,underline,bullist,numlist,alignleft,aligncenter,alignright,link,unlink";
        $initArray['toolbar2'] = '';
        $initArray['setup'] = <<<JS
[function(ed) {
        ed.on('KeyUp', function (e) {
            var description = tinyMCE.activeEditor.getContent();
            jQuery('.wpcd-coupon-description').html(description);
        });
        ed.on('Change', function (e) {
            var description = tinyMCE.activeEditor.getContent();
            jQuery('.wpcd-coupon-description').html(description);
        });            
    
}][0]
JS;
        return $initArray;
    }

    /**
	 * This function checks debug is switch on or switch off
	 * and then return the necessary directory or suffix if it needs ( for minimized version )
	 *
	 * @since 2.7.3
	 * @param string $way_correct
	 * @return string
	 */
    public static function wpcd_version_correct( $way_correct ) {
        $correct = array(
        	'dir'   => 'dist/',
        	'suffix' => '.min',
        );
        if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
        	$correct['dir']   = '';
        	$correct['suffix'] = '';
        }

        return array_key_exists( $way_correct, $correct ) ? $correct[$way_correct] : '';

    }
}
