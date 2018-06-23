<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 8/25/17
 * Time: 11:31 PM
 */
global $coupon_id, $parent;
$title                    = get_the_title();
$link                     = get_post_meta( $coupon_id, 'coupon_details_link', true );
$coupon_code              = get_post_meta( $coupon_id, 'coupon_details_coupon-code-text', true );
$featured_img_url         = get_the_post_thumbnail_url( get_the_ID(), 'large' );
$discount_text            = get_post_meta( $coupon_id, 'coupon_details_discount-text', true );
$coupon_type              = get_post_meta( $coupon_id, 'coupon_details_coupon-type', true );
$description              = get_post_meta( $coupon_id, 'coupon_details_description', true );
$deal_text                = get_post_meta( $coupon_id, 'coupon_details_deal-button-text', true );
$coupon_hover_text        = get_option( 'wpcd_coupon-hover-text' );
$deal_hover_text          = get_option( 'wpcd_deal-hover-text' );
$button_class             = '.wpcd-btn-' . $coupon_id;
$no_expiry                = get_option( 'wpcd_no-expiry-message' );
$never_expire             = get_post_meta( $coupon_id, 'coupon_details_never-expire-check', true );
$expire_text              = get_option( 'wpcd_expire-text' );
$expired_text             = get_option( 'wpcd_expired-text' );
$hide_coupon_text         = get_option( 'wpcd_hidden-coupon-text' );
$hidden_coupon_hover_text = get_option( 'wpcd_hidden-coupon-hover-text' );
$copy_button_text         = get_option( 'wpcd_copy-button-text' );
$coupon_title_tag         = get_option( 'wpcd_coupon-title-tag', 'h1' );
$disable_coupon_title_link = get_option( 'wpcd_disable-coupon-title-link' );
$hide_featured_image       = get_option( 'wpcd_hide-archive-thumbnail' );
$coupon_share = get_option( 'wpcd_coupon-social-share' );
$show_expiration          = get_post_meta( $coupon_id, 'coupon_details_show-expiration', true );
$today                    = date( 'd-m-Y' );
$expire_date              = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );
$hide_coupon              = get_post_meta( $coupon_id, 'coupon_details_hide-coupon', true );
$wpcd_coupon_image_id     = get_post_meta( $coupon_id, 'coupon_details_coupon-image-input', true );
$wpcd_coupon_image_src    = wp_get_attachment_image_src( $wpcd_coupon_image_id, 'full' );
$wpcd_show_print          = get_post_meta( $coupon_id, 'coupon_details_coupon-image-print', true );
$template = new WPCD_Template_Loader();

if ( is_array( $wpcd_coupon_image_src ) ) {
	$wpcd_coupon_image_src = $wpcd_coupon_image_src[0];
} else {
	$wpcd_coupon_image_src = '';
}

$wpcd_text_to_show = get_option( 'wpcd_text-to-show' );
$wpcd_custom_text  = get_option( 'wpcd_custom-text' );

if ( $wpcd_text_to_show == 'description' ) {
	$wpcd_custom_text = $description;
} else {
	if ( empty( $wpcd_custom_text ) ) {
		$wpcd_custom_text = __( "Click on 'Copy' to Copy the Coupon Code.", 'wpcd-coupon' );
	}
}
$wpcd_coupon_template     = get_post_meta( $coupon_id, 'coupon_details_coupon-template', true );

/*
 * use category image as featured image
 */
if ( ! has_post_thumbnail() ) {
	$terms     = get_the_terms( $coupon_id, 'wpcd_coupon_category' );
	$max_count = - 1;
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( $max_count < $term->count ) {
				$max_count = $term->count;
				$term_meta = get_option( 'taxonomy_term_' . $term->term_id );
				if ( empty( $term_meta ) || empty( $term_meta['image_id'] ) ) {
					continue;
				} else {
					$attachment = wp_get_attachment_image_src( $term_meta['image_id'], 'full' );
					if ( is_array( $attachment ) ) {
						$featured_img_url = $attachment[0];
					}
				}
			}
		}
	}
}


if ( $parent == 'header' || $parent == 'headerANDfooter' ): ?>
<section class="wpcd_archive_section wpcd_clearfix">
    <ul id="wpcd_coupon_ul" class="wpcd_clearfix">
		<?php endif; ?>


        <li class="wpcd_coupon_li  wpcd-coupon-id-<?php echo $coupon_id; ?>">
            <?php
            if ( $hide_featured_image != 'on' ) {
                if ( ! empty( $featured_img_url ) ) { ?>
                    <div class="wpcd_coupon_li_top_wr"
                    style="background-image:url('<?php echo esc_url( $featured_img_url ); ?>')">
				<?php } else { ?>
                    <div class="wpcd_coupon_li_top_wr">
				<?php } ?>
                    </div>
                <?php } ?>
                <div class="wpcd_coupon_li_content">
                <?php
					if ( 'on' === $disable_coupon_title_link ) { ?>
						<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
							<?php echo $title; ?>
                		</<?php echo esc_html( $coupon_title_tag ); ?>>
			 		<?php } else { ?>
						<<?php echo esc_html( $coupon_title_tag ); ?> class="wpcd-coupon-title">
							<a href="<?php echo $link; ?>" target="_blank" rel="nofollow"><?php echo $title; ?></a>
                		</<?php echo esc_html( $coupon_title_tag ); ?>>
					<?php } 
				?>
                    <div class="wpcd_coupon_li_top_btn_wr wpcd_clearfix <?php echo( $coupon_type === 'Image' ? 'hidden' : '' ); ?>">
						<?php if ( $discount_text ) { ?>
                            <div class="wpcd_coupon_li_top_discount_left"><?php echo $discount_text; ?></div>
							<?php
						}
						if ( $coupon_type == 'Coupon' ) {
						if ( $hide_coupon == 'Yes' ) { ?>

							<div class="wpcd-coupon-code wpcd_btn_wr"><?php $template->get_template_part( 'hide-coupon__premium_only' ); ?></div>

						<?php } else { ?>
                            <div class="wpcd-coupon-code wpcd_btn_wr">
								<?php if ( ! empty( $coupon_hover_text ) ) { ?>
                                    <a rel="nofollow"
                                       class="wpcd-btn-<?php echo $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                                       href="<?php echo $link; ?>" title="<?php echo $coupon_hover_text; ?>"
                                       target="_blank"
                                       data-clipboard-text="<?php echo $coupon_code; ?>">
                                        <span class="wpcd_coupon_icon"></span> <?php echo $coupon_code; ?>
                                        <span id="coupon_code_<?php echo $coupon_id; ?>"
                                              style="display:none;"><?php echo $coupon_code; ?></span>
                                    </a>
								<?php } else { ?>
                                    <a rel="nofollow"
                                       class="wpcd-btn-<?php echo $coupon_id; ?> masterTooltip wpcd-btn wpcd-coupon-button"
                                       href="<?php echo $link; ?>"
                                       title="<?php echo __( 'Click To Copy Coupon', 'wpcd-coupon' ); ?>"
                                       target="_blank"
                                       data-clipboard-text="<?php echo $coupon_code; ?>">
                                        <span class="wpcd_coupon_icon"></span> <?php echo $coupon_code; ?>
                                        <span id="coupon_code_<?php echo $coupon_id; ?>"
                                              style="display:none;"><?php echo $coupon_code; ?></span>
                                    </a>
								<?php } ?>
                            </div>
                            <script type="text/javascript">
                                var clip = new Clipboard('.wpcd-btn-<?php echo $coupon_id; ?>');
                            </script>
						<?php }
						} elseif ( $coupon_type == 'Deal' ) { ?>
                            <div class="wpcd-coupon-code wpcd_btn_wr">
								<?php if ( ! empty( $deal_hover_text ) ) { ?>
                                    <a rel="nofollow"
                                       class="wpcd-btn-<?php echo $coupon_id; ?> wpcd-btn masterTooltip wpcd-deal-button"
                                       title="<?php echo $deal_hover_text; ?>" href="<?php echo $link; ?>"
                                       target="_blank">
                                        <span class="wpcd_deal_icon"></span><?php echo $deal_text; ?>
                                    </a>
								<?php } else { ?>
                                    <a rel="nofollow"
                                       class="wpcd-btn-<?php echo $coupon_id; ?> wpcd-btn masterTooltip wpcd-deal-button"
                                       title="<?php echo __( 'Click Here To Get This Deal', 'wpcd-coupon' ); ?>"
                                       href="<?php echo $link; ?>" target="_blank">
                                        <span class="wpcd_deal_icon"></span><?php echo $deal_text; ?>
                                    </a>
								<?php } ?>
                            </div>
						<?php } ?>

                    </div>
                    <div class="wpcd_coupon_li_inner <?php echo( $coupon_type === 'Image' ? 'hidden' : '' ); ?>">
						<?php if ( $description ) { ?>
                            <div class="wpcd_coupon_li_description">
                                <div class="wpcd-coupon-description">
                                    <span class="wpcd-full-description"><?php echo $description; ?></span>
                                    <span class="wpcd-short-description"></span>
                                    <a href="#"
                                       class="wpcd-more-description"><?php echo __( 'More', 'wpcd-coupon' ); ?></a>
                                    <a href="#"
                                       class="wpcd-less-description"><?php echo __( 'Less', 'wpcd-coupon' ); ?></a>
                                </div>
                            </div>
						<?php } ?>
						<?php if ( $show_expiration == 'Show' ) { 
                                                            $never_expire = ($wpcd_coupon_template == 'Template Two' ||
                                                                             $wpcd_coupon_template == 'Template Six') 
                                                                            ? $never_expire: '';
                                                    if ( ! empty( $expire_date ) && $never_expire != 'on' ) { ?>
                                <div class="wpcd_coupon_li_bottom wpcd_clearfix">

									<?php if ( strtotime( $expire_date ) >= strtotime( $today ) ) { ?>

										<?php if ( ! empty( $expire_text ) ) { ?>
                                            <p class="wpcd-coupon-loop-expire"><?php echo $expire_text . $expire_date; ?></p>
										<?php } else { ?>
                                            <p class="wpcd-coupon-loop-expire"><?php echo __( 'Expires on: ', 'wpcd-coupon' ) . $expire_date ?></p>
										<?php } ?>

									<?php } elseif ( strtotime( $expire_date ) < strtotime( $today ) ) { ?>

										<?php if ( ! empty( $expired_text ) ) { ?>
                                            <p class="wpcd-coupon-loop-expired"><?php echo $expired_text . $expire_date; ?></p>
										<?php } else { ?>
                                            <p class="wpcd-coupon-loop-expired"><?php echo __( 'Expired on: ', 'wpcd-coupon' ) . $expire_date; ?></p>
										<?php } ?>

									<?php } ?>
                                </div>
							<?php } else { ?>
                                <div class="wpcd_coupon_li_bottom wpcd_clearfix">

									<?php if ( ! empty( $no_expiry ) ) { ?>
										<?php echo $no_expiry; ?>
									<?php } else { ?>
                                        <p class='wpcd-coupon-loop-expire'><?php echo __( "Doesn't expire", 'wpcd-coupon' ); ?></p>
									<?php } ?>

                                </div>
							<?php } ?>
						<?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="wpcd-li-footer">
                        <?php
                        if ( $coupon_share === 'on' ) {
                                $template->get_template_part('social-share');
                        }
                        $template->get_template_part('vote-system');
                        ?>
                    </div>
                </div>
        </li>
		<?php if ( $parent == 'footer' || $parent == 'headerANDfooter' ): ?>
    </ul>
    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix">
		<?php
		global $max_num_page;
		$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $max_num_page,
			'prev_next' => true,
			'prev_text' => __( '« Prev', 'wpcd-coupon' ),
			'next_text' => __( 'Next »', 'wpcd-coupon' ),
		) );
		?>
    </div>
</section>

<?php endif; ?>            