<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/18/17
 * Time: 11:30 PM
 */
global $coupon_id;
$title                     = get_the_title();
$description               = get_post_meta( $coupon_id, 'coupon_details_description', true );
$coupon_thumbnail          = get_the_post_thumbnail_url( $coupon_id );
$discount_text             = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type               = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$link                      = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code               = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$deal_text                 = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text         = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text           = get_option( 'wpcd_deal-hover-text' );
$button_class              = 'wpcd-btn-' . $coupon_id;
$no_expiry                 = get_option( 'wpcd_no-expiry-message' );
$expire_text               = get_option( 'wpcd_expire-text' );
$expired_text              = get_option( 'wpcd_expired-text' );
$hide_coupon_text          = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text  = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text          = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag          = get_option( 'wpcd_coupon-title-tag', 'h1' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$show_expiration           = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                     = date( 'd-m-Y' );
$expire_date               = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$expireDateFormat          = get_option( 'wpcd_expiry-date-format' );
$expire_time               = get_post_meta( $coupon_id, 'coupon_details_expire-time', true );
$never_expire              = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$hide_coupon               = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_text_to_show         = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text          = get_option( 'wpcd_custom-text' );

$linkTarget = get_option("wpcd_coupon-link-target");
$target = ($linkTarget == "on") ? "_self" : "_blank" ;

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else if ( empty( $wpcd_custom_text ) ) {
	$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wp-coupons-and-deals' );
}

$expireDateFormatFun = wpcd_getExpireDateFormatFun( $expireDateFormat );
if ( ! empty( $expire_date ) && (string)(int)$expire_date == $expire_date ) {
    $expire_date = date( $expireDateFormatFun, $expire_date );
} elseif ( ! empty( $expire_date ) ) {
    $expire_date = date( $expireDateFormatFun, strtotime( $expire_date ) );
}
$expire_date_format = date( "m/d/Y", strtotime( $expire_date ) );

?>

<div class="wpcd-coupon wpcd-coupon-two wpcd-widget wpcd-coupon-id-<?php echo absint( $coupon_id ); ?>">
    <div class="wpcd-coupon-content wpcd-col-1-1">
        <div class="wpcd-coupon-header">
            <div class="wpcd-col-1-1">
                <figure>
				    <?php if ( has_post_thumbnail() ) { ?>
                        <img class="wpcd-coupon-one-img" src="<?php echo esc_url( $coupon_thumbnail ); ?>">
				    <?php } else { ?>
                        <img class="wpcd-coupon-one-img"
                             src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/icon-128x128.png' ); ?>">
				    <?php } ?>
                </figure>
            </div>
            <div class="wpcd-col-1-1">
            <?php
				if ( 'on' === $disable_coupon_title_link ) { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<?php echo esc_html( $title ); ?>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
			 	<?php } else { ?>
					<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
						<a href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" rel="nofollow"><?php echo esc_attr( $title ); ?></a>
                	</<?php echo esc_html( $coupon_title_tag ); ?>>
				<?php } 
			?>
            </div>

            <div class="wpcd-col-1-1">
                <?php if( ! empty( $expire_date ) && $never_expire != 'on' ): ?>
                    <span class="wpcd-coupon-two-countdown-text">
                        <?php
                            echo $expire_text ? esc_html( $expire_text ) : __( 'Expires on: ', 'wp-coupons-and-deals' );
                        ?>
                    </span>
                    <span class="wpcd-coupon-two-countdown test"
                        data-countdown_coupon="<?php echo strtotime( $expire_date_format . ' ' . $expire_time ) ? ( $expire_date_format . ' ' . $expire_time ) : ''; ?>"
                        id="clock_<?php echo absint( $coupon_id ); ?>"></span>
                <?php else : ?>
                    <span style="color: green;">
                        <?php
                            echo $no_expiry ? esc_html( $no_expiry ) : __( "Doesn't expire", 'wp-coupons-and-deals' );
                        ?>
                    </span>   
                <?php endif; ?>
            </div>

        </div>

        <div class="wpcd-extra-content">
            <div class="wpcd-col-1-1">
                <div class="wpcd-coupon-description">
                    <span class="wpcd-full-description"><?php echo wp_kses_post( $description ); ?></span>
                    <span class="wpcd-short-description"></span>
                    <a href="#" class="wpcd-more-description"><?php echo __( 'More', 'wp-coupons-and-deals' ); ?></a>
                    <a href="#" class="wpcd-less-description"><?php echo __( 'Less', 'wp-coupons-and-deals' ); ?></a>
                </div>
            </div>

            <div class="wpcd-col-1-1">
				<?php
				if ( $coupon_type == 'Coupon' ) {
				    if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) {
				        if ( $hide_coupon == 'Yes' ) {
					        $template = new WPCD_Template_Loader();
        					$template->get_template_part( 'hide-coupon__premium_only' );
        				} else { ?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow"
                           class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           title="<?php
						   if ( ! empty( $coupon_hover_text ) ) {
							   echo esc_attr( $coupon_hover_text );
						   } else {
							   echo __( "Click To Copy Coupon", 'wp-coupons-and-deals' );
						   }
						   ?>" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
                           data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>">
                            <span class="wpcd_coupon_icon"></span> <?php echo esc_html( $coupon_code ); ?>
                            <span id="coupon_code_<?php echo absint( $coupon_id ); ?>"
                                  style="display:none;"><?php echo esc_html( $coupon_code ); ?></span>
                        </a>
                    </div>
				<?php }
				} else {
					?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow"
                           class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id ); ?> masterTooltip wpcd-btn wpcd-coupon-button"
                           title="<?php
						   if ( ! empty( $coupon_hover_text ) ) {
							   echo esc_attr( $coupon_hover_text );
						   } else {
							   echo __( "Click To Copy Coupon", 'wp-coupons-and-deals' );
						   }
						   ?>" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
                           data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>">
                            <span class="wpcd_coupon_icon"></span> <?php echo esc_html( $coupon_code ); ?>
                            <span id="coupon_code_<?php echo absint( $coupon_id ); ?>"
                                  style="display:none;"><?php echo esc_html( $coupon_code ); ?></span>
                        </a>
                    </div>
				<?php } ?>
                    <script type="text/javascript">
                        window.addEventListener('DOMContentLoaded', function() {
                            var clip = new ClipboardJS('.wpcd-btn-<?php echo absint( $coupon_id ); ?>');
                        });
                    </script>
				<?php } elseif ( $coupon_type == 'Deal' ) {
				?>
                    <div class="wpcd-coupon-code">
                        <a rel="nofollow"
                           class="<?php echo esc_attr( 'wpcd-btn-' . $coupon_id ); ?> wpcd-btn masterTooltip wpcd-deal-button"
                           title="<?php
						   if ( ! empty( $deal_hover_text ) ) {
							   echo esc_attr( $deal_hover_text );
						   } else {
							   echo __( "Click Here To Get This Deal", 'wp-coupons-and-deals' );
						   }
						   ?>" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
                            <span class="wpcd_deal_icon"></span><?php echo esc_html( $deal_text ); ?>
                        </a>
                    </div>
				<?php } ?>
            </div>
        </div>
    </div>
        <div class="clearfix"></div>
    <?php
    $template = new WPCD_Template_Loader();
    $template->get_template_part('vote-system');
    ?>
</div>