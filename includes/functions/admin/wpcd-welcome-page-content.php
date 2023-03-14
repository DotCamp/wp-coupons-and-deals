<?php

/**
 * Welcome Page View
 *
 * @since 2.0
 * @package WPCD
 */

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="wpcd-welcome" class="lite">

    <div class="wpcd-welcome-container">

        <div class="wpcd-intro">

            <div class="wpcd-icon">
                <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/icon-128x128.png' );?>" alt="<?php esc_attr_e( 'WP Coupons and Deals', 'wp-coupons-and-deals' ); ?>">
            </div>

            <div class="wpcd-block">
                <h1><?php esc_html_e( 'Welcome to WP Coupons and Deals', 'wp-coupons-and-deals' ); ?></h1>
                <h6><?php esc_html_e( 'Thank you for choosing WP Coupons and Deals - the best Coupon Plugin for WordPress Websites.', 'wp-coupons-and-deals' ); ?></h6>
                <br/>
                <h6><?php esc_html_e( 'Check out the video below that shows how you can create your first coupon and insert the coupon in a post or page.', 'wp-coupons-and-deals' ); ?></h6>
            </div>

            <div class="wpcd-feature-video">
                <div>
                    <iframe width="716" height="415" src="https://www.youtube-nocookie.com/embed/ZeeMcHQMdx8?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>

            <div class="wpcd-block">

                <h6><?php esc_html_e( 'WP Coupons and Deals makes it insanely easy to create coupons and present them the right way in your posts/pages.', 'wp-coupons-and-deals' ); ?></h6>

                <div class="wpcd-button-wrap wpcd-clear">
                    <div class="wpcd-left">
                        <a href="<?php echo admin_url( 'post-new.php?post_type=wpcd_coupons' ); ?>" class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-green">
                            <?php esc_html_e( 'Create Your First Coupon', 'wp-coupons-and-deals' ); ?>
                        </a>
                    </div>
                    <div class="wpcd-right">
                        <a href="https://wpcouponsdeals.com/knowledgebase//?utm_source=WordPress&amp;utm_medium=link&amp;utm_campaign=dashboard"
                            class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-grey" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e( 'Read the Documentation', 'wp-coupons-and-deals' ); ?>
                        </a>
                    </div>
                </div>

            </div>

        </div><!-- /.wpcd-intro -->

        <div class="wpcd-features">

            <div class="wpcd-block">

                <h1><?php esc_html_e( 'WP Coupons and Deals Features', 'wp-coupons-and-deals' ); ?></h1>
                <h6><?php esc_html_e( 'WP Coupons and Deals comes with features that are designed to protect your affiliate sales and boost your revenue.', 'wp-coupons-and-deals' ); ?></h6>

                <div class="wpcd-feature-list wpcd-clear">

                    <div class="wpcd-feature-block wpcd-first">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/lightweight.png'); ?>">
                        <h5><?php esc_html_e( 'Click to Copy', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Users can copy the coupon code with just one click. How cool is that?', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                    <div class="wpcd-feature-block wpcd-last">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/responsive.png' ); ?>">
                        <h5><?php esc_html_e( 'Responsive', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Coupon templates are designed to work on all screen sizes.', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                    <div class="wpcd-feature-block wpcd-first">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/image.png' ); ?>">
                        <h5><?php esc_html_e( 'Image Coupons', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Add printable image coupons that can be printed and used offline.', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                    <div class="wpcd-feature-block wpcd-last">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/preview.png' ); ?>">
                        <h5><?php esc_html_e( 'Live Preview', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Watch the coupon as you create it, so you know what you are doing.', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                    <div class="wpcd-feature-block wpcd-first">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/expire.png' ); ?>">
                        <h5><?php esc_html_e( 'Expiration Dates', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Let your users know which coupons are expired and which are available.', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                    <div class="wpcd-feature-block wpcd-last">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/hide.png' ); ?>">
                        <h5><?php esc_html_e( 'Hide Expired Coupon', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Don\'t want to update expired coupons? No problem, just hide \'em.', 'wp-coupons-and-deals' ); ?></p>
                    </div>
                    
                    <div class="wpcd-feature-block wpcd-first">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/social.png' ); ?>">
                        <h5><?php esc_html_e( 'Social Share', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Add social share buttons in your coupons, let users spread the love.', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                    <div class="wpcd-feature-block wpcd-last">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/settings.png' ); ?>">
                        <h5><?php esc_html_e( 'Voting System', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Let your users vote whether a coupon worked for them or not.', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                    <div class="wpcd-feature-block wpcd-first">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/widget.png' ); ?>">
                        <h5><?php esc_html_e( 'Widgets', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'So you can add your coupons in any widget areas on your site.', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                    <div class="wpcd-feature-block wpcd-last">
                        <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/inserter.png'); ?>">
                        <h5><?php esc_html_e( 'Shortcode Inserter', 'wp-coupons-and-deals' ); ?></h5>
                        <p><?php esc_html_e( 'Instead of copy-paste, insert coupons straight from your editor.', 'wp-coupons-and-deals' ); ?></p>
                    </div>

                </div>

                <div class="wpcd-button-wrap">
                    <a href="https://wpcouponsdeals.com/?utm_source=WordPress&amp;utm_medium=link&amp;utm_campaign=profeatures"
                        class="wpcd-btn wpcd-btn-lg wpcd-btn-grey" rel="noopener noreferrer" target="_blank">
                        <?php esc_html_e( 'Check Out More', 'wp-coupons-and-deals' ); ?>
                    </a>
                </div>

            </div>

        </div><!-- /.features -->

        <div class="wpcd-upgrade-cta upgrade">

            <div class="wpcd-block wpcd-clear">

                <div class="wpcd-upgrade-cta-left">
                    <h2><?php esc_html_e( 'Upgrade to PRO', 'wp-coupons-and-deals' ); ?></h2>
                    <ul>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( '7 Coupon Templates', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Hide Coupon Code', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Expiration Counter', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Import from CSV', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Category Shortcode', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Archive Shortcode', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Extensive Settings', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Lifetime Usage', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( '1 Year Update', 'wp-coupons-and-deals' ); ?></li>
                        <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( '1 Year Priority Support', 'wp-coupons-and-deals' ); ?></li>
                    </ul>
                </div>

                <div class="wpcd-upgrade-cta-right">
                    <h2><span><?php esc_html_e( 'PRO', 'wp-coupons-and-deals' ); ?></span></h2>
                    <div class="wpcd-price">
                        <span class="wpcd-amount">39</span><br>
                        <span class="wpcd-term"><?php esc_html_e( 'per year', 'wp-coupons-and-deals' ); ?></span>
                    </div>
                    <a href="<?php echo admin_url( 'edit.php?post_type=wpcd_coupons&page=wp-coupons-and-deals-pricing' ); ?>"
                        class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-green wpcd-upgrade-modal">
                        <?php esc_html_e( 'Upgrade Now!', 'wp-coupons-and-deals' ); ?>
                    </a>
                </div>

            </div>

        </div>

        <div class="wpcd-testimonials upgrade">

            <div class="wpcd-block">

                <h1><?php esc_html_e( 'Testimonials', 'wp-coupons-and-deals' ); ?></h1>

                <div class="wpcd-testimonial-block wpcd-clear">
                    <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/testimonial1.png'); ?>">
                </div>

                <div class="wpcd-testimonial-block wpcd-clear">
                    <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/testimonial3.png' ); ?>">
                </div>

                <div class="wpcd-testimonial-block wpcd-clear">
                    <img src="<?php echo esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/testimonial2.png' ); ?>">
                </div>

                <div class="wpcd-button-wrap">
                    <a href="https://wordpress.org/support/plugin/wp-coupons-and-deals/reviews/"
                        class="wpcd-btn wpcd-btn-lg wpcd-btn-grey" rel="noopener noreferrer" target="_blank">
                        <?php esc_html_e( 'Read More Reviews on WP.org', 'wp-coupons-and-deals' ); ?>
                    </a>
                </div>

            </div>

        </div><!-- /.testimonials -->

        <div class="wpcd-footer">

            <div class="wpcd-block wpcd-clear">

                <div class="wpcd-button-wrap wpcd-clear">
                    <div class="wpcd-left">
                        <a href="<?php echo admin_url( 'post-new.php?post_type=wpcd_coupons' ); ?>"
                            class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-green">
                            <?php esc_html_e( 'Create Your First Coupon', 'wp-coupons-and-deals' ); ?>
                        </a>
                    </div>
                    <div class="wpcd-right">
                        <a href="<?php echo admin_url( 'edit.php?post_type=wpcd_coupons&page=wp-coupons-and-deals-pricing' ); ?>"
                            class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-trans-green wpcd-upgrade-modal">
                            <span class="underline">
                                <?php esc_html_e( 'WP Coupons and Deals Pro', 'wp-coupons-and-deals' ); ?> <span class="dashicons dashicons-arrow-right"></span>
                            </span>
                        </a>
                    </div>
                </div>            
            </div>

            <div class="wpcd-block wpcd-clear">
                <h1><?php esc_html_e( 'Other Free Tools By Me', 'wp-coupons-and-deals'); ?></h1>
                <div style="text-align:center">
                    <ol style="display: inline-block;text-align: left;font-size: 18px;line-height: 1.8">
                        <li><a target="_blank" href="https://wordpress.org/plugins/wp-table-builder/">WP Table Builder</a> - <?php esc_html_e( 'Drag and Drop Table Builder.', 'wp-coupons-and-deals' ); ?></li>
                        <li><a target="_blank" href="https://wordpress.org/plugins/ultimate-blocks/">Ultimate Blocks</a> - <?php esc_html_e( 'Custom Gutenberg Blocks.', 'wp-coupons-and-deals' ); ?></li>
                        <li><a target="_blank" href="https://wordpress.org/themes/groundwp/">GroundWP</a> - <?php esc_html_e( 'Block Theme For Site Building.', 'wp-coupons-and-deals' ); ?></li>
                    </ol>
                </div>
            </div>
            
        </div><!-- /.footer -->

    </div><!-- /.container -->

</div><!-- /#wpcd-welcome -->
