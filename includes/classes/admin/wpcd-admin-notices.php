<?php

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPCD_Admin_Notices
 *
 * Custom Admin notices for post publish, update or draft.
 *
 * @since 2.0
 */
class WPCD_Admin_Notices {

	/**
	 * Adding the filter.
	 *
	 * @since 2.0
	 */
	public static function init() {

		add_filter( 'post_updated_messages', array( __CLASS__, 'coupon_publish_notice' ) );
		add_action( 'admin_notices', array( __CLASS__, 'review_notice' ), 20 );
		add_action( 'wp_ajax_wpcdReviewNoticeHide', array( __CLASS__, 'wpcd_hide_review_notify' ) );

	}


	/**
	 * Generating the review notice.
	 *
	 * @since 2.0
	 */
	public static function review_notice() {

		$coupon_count  = wp_count_posts( 'wpcd_coupons' );
		$coupon_number = $coupon_count->publish;

		if ( $coupon_number >= 5 && get_option( 'wpcd_review_notify' ) == "no" ) {
			?>
            <div class="wpcd-review-notice notice notice-info">
                <p style="font-size: 14px;">
					<?php _e( 'Hey,<br> I noticed you have already created ' . $coupon_number . ' coupons with WP Coupons and Deals plugin - that’s awesome! Could you please do me a BIG favor and <b>give it a 5-star rating on WordPress</b>? Just to help us spread the word and boost our motivation. <br>~ Imtiaz Rayhan', 'wpcd-coupon' ); ?>
                </p>
                <ul>
                    <li><a style="margin-right: 5px; margin-bottom: 5px;" class="button-primary"
                           href="https://wordpress.org/support/plugin/wp-coupons-and-deals/reviews/#new-post"
                           target="_blank">Sure,
                            you deserve it.</a>
                        <a style="margin-right: 5px;" class="wpcd_HideReview_Notice button" href="javascript:void(0);">
                            I already did.</a>
                        <a class="wpcd_HideReview_Notice button" href="javascript:void(0);">No, not good enough.</a>
                    </li>
                </ul>
            </div>
            <script>
                jQuery(document).ready(function ($) {
                    jQuery('.wpcd_HideReview_Notice').click(function () {
                        var data = {'action': 'wpcdReviewNoticeHide'};
                        jQuery.ajax({
                            url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                            type: "post",
                            data: data,
                            dataType: "json",
                            async: !0,
                            success: function (notice_hide) {
                                if (notice_hide == "success") {
                                    jQuery('.wpcd-review-notice').slideUp('fast');
                                }
                            }
                        });
                    });
                });
            </script>
			<?php

		}

	}

	/**
	 * Hides the review notice.
	 *
	 * @since 2.0
	 */
	static function wpcd_hide_review_notify() {

		update_option( 'wpcd_review_notify', 'yes' );
		echo json_encode( array( "success" ) );
		exit;

	}

	/**
	 * Adding the custom notices.
	 *
	 * @param $messages
	 *
	 * @return mixed
	 *
	 * @since 2.0
	 */
	public static function coupon_publish_notice( $messages ) {

		$post = get_post();

		$full_coupon = '<b>' . __( 'Full Coupon:', 'wpcd-coupon' ) . '</b> [wpcd_coupon id=' . $post->ID . ']';
		$only_code   = '<b>' . __( 'Only Coupon Code:', 'wpcd-coupon' ) . '</b> [wpcd_code id=' . $post->ID . ']';

		$messages['wpcd_coupons'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Coupon updated.', 'wpcd-coupon' ),
			2  => '',
			3  => '',
			4  => __( 'Coupon updated.', 'wpcd-coupon' ),
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Coupon restored to revision from %s', 'wpcd-coupon' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => sprintf(
				__( 'Coupon published. <br><br> Here are the shortcodes for this coupon: %s and %s ', 'wpcd-coupon' ),
				$full_coupon, $only_code
			),
			7  => __( 'Coupon saved.', 'wpcd-coupon' ),
			8  => __( 'Coupon submitted.', 'wpcd-coupon' ),
			9  => sprintf(
				__( 'Coupon scheduled for: <strong>%1$s</strong>.', 'wpcd-coupon' ),
				date_i18n( __( 'M j, Y @ G:i', 'wpcd-coupon' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Coupon draft updated.', 'wpcd-coupon' )
		);

		return $messages;

	}
}
