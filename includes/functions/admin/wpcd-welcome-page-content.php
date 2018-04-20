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

<style>

#wpcd-welcome {
    color: #555;
    padding-top: 110px;
}

#wpcd-welcome .container {
    margin: 0 auto;
    max-width: 720px;
    padding: 0;
}

#wpcd-welcome *, #wpcd-welcome ::before, #wpcd-welcome ::after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.intro {
    background-color: #fff;
    border: 2px solid #e1e1e1;
    border-radius: 2px;
    margin-bottom: 30px;
    position: relative;
    padding-top: 40px;
}

.wpcd-icon {
    background-color: #fff;
    border: 2px solid #e1e1e1;
    border-radius: 50%;
    height: 110px;
    width: 110px;
    padding: 17px 18px 0px 13px;
    position: absolute;
    top: -58px;
    left: 50%;
    margin-left: -55px;
}

#wpcd-welcome img {
    max-width: 100%;
    height: auto;
}

.block {
    padding: 40px;
}

#wpcd-welcome h1 {
    color: #222;
    font-size: 24px;
    text-align: center;
    margin: 0 0 16px 0;
}

#wpcd-welcome h6 {
    font-size: 16px;
    font-weight: 400;
    line-height: 1.6;
    text-align: center;
    margin: 0;
}

.intro .video-thumbnail {
    display: block;
    margin: 0 auto;
}

.button-wrap {
    margin-top: 25px !important;
    text-align: center;
}

.button-wrap {
    max-width: 590px;
    margin: 0 auto 0 auto;
}

.wpcd-clear::before {
    content: " ";
    display: table;
}

.left {
    float: left;
    width: 50%;
    padding-right: 20px;
}

.wpcd-btn-green {
    background-color: #329d40;
    border-color: #329d40;
    color: #fff;
}

.wpcd-btn-lg {
    font-size: 16px;
    font-weight: 600;
    padding: 16px 28px;
}

.wpcd-btn-block {
    display: block;
    width: 100%;
}

.wpcd-btn {
    border: 0;
    border-radius: 3px;
    cursor: pointer;
    display: inline-block;
    margin: 0;
    text-decoration: none;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    box-shadow: none;
}

.right {
    float: right;
    width: 50%;
    padding-left: 20px;
}

.wpcd-btn-grey {
    background-color: #eee;
    border-color: #ccc;
    color: #666;
}

.wpcd-clear::after {
    clear: both;
    content: " ";
    display: table;
}

.features {
    background-color: #fff;
    border: 2px solid #e1e1e1;
    border-bottom: 0;
    border-radius: 2px 2px 0 0;
    position: relative;
    padding-top: 20px;
    padding-bottom: 20px;
}

.feature-list {
    margin-top: 60px;
}

.feature-block {
    float: left;
    width: 50%;
    padding-bottom: 35px;
    overflow: auto;
    padding-top: 20px;
}

.first {
    padding-right: 20px;
    clear: both;
}

.last {
    padding-left: 20px;
}

.feature-block img {
    float: left;
    margin-top: 5px;
    max-width: 50px !important;
}

.feature-block h5 {
    margin-left: 75px !important;
}
#wpcd-welcome h5 {
    color: #222;
    font-size: 18px;
    margin: 0 0 8px 0;
}

.feature-block p {
    margin: 0;
    margin-left: 75px !important;
}

.upgrade-cta {
    background-color: #000;
    border: 2px solid #e1e1e1;
    border-top: 0;
    border-bottom: 0;
    color: #fff;
}
 
.upgrade-cta-left {
    float: left;
    width: 66.666666%;
    padding-right: 20px;
}

.upgrade-cta h2 {
    color: #fff;
    font-size: 20px;
    margin: 0 0 30px 0;
}

.upgrade-cta ul {
    display: -ms-flex;
    display: -webkit-flex;
    display: flex;
    -webkit-flex-wrap: wrap;
    flex-wrap: wrap;
    font-size: 15px;
    margin: 0;
    padding: 0;
}

.upgrade-cta ul li {
    display: block;
    width: 50%;
    margin: 0 0 8px 0;
    padding: 0;
}

.upgrade-cta-right {
    float: right;
    width: 33.333333%;
    padding-left: 20px;
    text-align: center;
}

.upgrade-cta-right h2 {
    text-align: center;
    margin: 0;
}

.price {
    padding: 26px 0;
}

.amount {
    font-size: 48px;
    font-weight: 600;
    position: relative;
    display: inline-block;
}

.term {
    font-size: 12px;
    display: inline-block;
}

.testimonials {
    background-color: #fff;
    border-top: 0;
    padding: 20px 0;
}

.testimonial-block {
    margin: 50px 0 0 0;
}

.testimonial-block img {
    float: left;
    max-width: 100% !important;
}

.testimonial-block p {
    font-size: 14px;
    margin: 0 0 12px 140px;
}

.footer {
    background-color: #f1f1f1;
    border-top: 0;
    border-radius: 0 0 2px 2px;
}

.feature-video {
    text-align: center;
}

a.wpcd-btn-green {
    color: #fff;
}

</style>

<div id="wpcd-welcome" class="lite">

<div class="container">

    <div class="intro">

        <div class="wpcd-icon">
            <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/icon-128x128.png" alt="<?php esc_attr_e( 'WP Coupons and Deals', 'wpcd-coupon' ); ?>">
        </div>

        <div class="block">
            <h1><?php esc_html_e( 'Welcome to WP Coupons and Deals', 'wpcd-coupon' ); ?></h1>
            <h6><?php esc_html_e( 'Thank you for choosing WP Coupons and Deals - the best Coupon Plugin for WordPress Websites.', 'wpcd-coupon' ); ?></h6>
            <br/>
            <h6><?php esc_html_e( 'Check out the video below that shows how you can create your first coupon and insert the coupon in a post or page.', 'wpcd-coupon' ); ?></h6>
        </div>

        <div class="feature-video">
            <div>
                <iframe width="716" height="415" src="https://www.youtube-nocookie.com/embed/ZeeMcHQMdx8?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>

        <div class="block">

            <h6><?php esc_html_e( 'WP Coupons and Deals makes it insanely easy to create coupons and present them the right way in your posts/pages.', 'wpcd-coupon' ); ?></h6>

            <div class="button-wrap wpcd-clear">
                <div class="left">
                    <a href="<?php echo admin_url( 'post-new.php?post_type=wpcd_coupons' ); ?>" class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-green">
                        <?php esc_html_e( 'Create Your First Coupon', 'wpcd-coupon' ); ?>
                    </a>
                </div>
                <div class="right">
                    <a href="https://wpcouponsdeals.com/knowledgebase//?utm_source=WordPress&amp;utm_medium=link&amp;utm_campaign=dashboard"
                        class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-grey" target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e( 'Read the Documentation', 'wpcd-coupon' ); ?>
                    </a>
                </div>
            </div>

        </div>

    </div><!-- /.intro -->

    <div class="features">

        <div class="block">

            <h1><?php esc_html_e( 'WP Coupons and Deals Features', 'wpcd-coupon' ); ?></h1>
            <h6><?php esc_html_e( 'WP Coupons and Deals comes with features that are designed to protect your affiliate sales and boost your revenue.', 'wpcd-coupon' ); ?></h6>

            <div class="feature-list wpcd-clear">

                <div class="feature-block first">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/lightweight.png">
                    <h5><?php esc_html_e( 'Click to Copy', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Users can copy the coupon code with just one click. How cool is that?', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block last">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/responsive.png">
                    <h5><?php esc_html_e( 'Responsive', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Coupon templates are designed to work on all screen sizes.', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block first">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/image.png">
                    <h5><?php esc_html_e( 'Image Coupons', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Add printable image coupons that can be printed and used offline.', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block last">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/preview.png">
                    <h5><?php esc_html_e( 'Live Preview', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Watch the coupon as you create it, so you know what you are doing.', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block first">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/expire.png">
                    <h5><?php esc_html_e( 'Expiration Dates', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Let your users know which coupons are expired and which are available.', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block last">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/hide.png">
                    <h5><?php esc_html_e( 'Hide Expired Coupon', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Don\'t want to update expired coupons? No problem, just hide \'em.', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block first">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/widget.png">
                    <h5><?php esc_html_e( 'Widgets', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'So you can add your coupons in any widget areas on your site.', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block last">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/inserter.png">
                    <h5><?php esc_html_e( 'Shortcode Inserter', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Instead of copy-paste, insert coupons straight from your editor.', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block first">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/social.png">
                    <h5><?php esc_html_e( 'Social Share', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Add social share buttons in your coupons, let users spread the love.', 'wpcd-coupon' ); ?></p>
                </div>

                <div class="feature-block last">
                    <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/settings.png">
                    <h5><?php esc_html_e( 'Customization Options', 'wpcd-coupon' ); ?></h5>
                    <p><?php esc_html_e( 'Customize everything to your need, make the most out of your coupons.', 'wpcd-coupon' ); ?></p>
                </div>

            </div>

            <div class="button-wrap">
                <a href="https://wpcouponsdeals.com/?utm_source=WordPress&amp;utm_medium=link&amp;utm_campaign=profeatures"
                    class="wpcd-btn wpcd-btn-lg wpcd-btn-grey" rel="noopener noreferrer" target="_blank">
                    <?php esc_html_e( 'Check Out More', 'wpcd-coupon' ); ?>
                </a>
            </div>

        </div>

    </div><!-- /.features -->

    <div class="upgrade-cta upgrade">

        <div class="block wpcd-clear">

            <div class="upgrade-cta-left">
                <h2><?php esc_html_e( 'Upgrade to PRO', 'wpcd-coupon' ); ?></h2>
                <ul>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( '7 Coupon Templates', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Hide Coupon Code', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Expiration Counter', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Import from CSV', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Category Shortcode', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Archive Shortcode', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Extensive Settings', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Lifetime Usage', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( '1 Year Update', 'wpcd-coupon' ); ?></li>
                    <li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( '1 Year Priority Support', 'wpcd-coupon' ); ?></li>
                </ul>
            </div>

            <div class="upgrade-cta-right">
                <h2><span><?php esc_html_e( 'PRO', 'wpcd-coupon' ); ?></span></h2>
                <div class="price">
                    <span class="amount">29.99</span><br>
                    <span class="term"><?php esc_html_e( 'per year', 'wpcd-coupon' ); ?></span>
                </div>
                <a href="<?php echo admin_url( 'edit.php?post_type=wpcd_coupons&page=wp-coupons-and-deals-pricing' ); ?>"
                    class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-green wpcd-upgrade-modal">
                    <?php esc_html_e( 'Upgrade Now!', 'wpcd-coupon' ); ?>
                </a>
            </div>

        </div>

    </div>

    <div class="testimonials upgrade">

        <div class="block">

            <h1><?php esc_html_e( 'Testimonials', 'wpcd-coupon' ); ?></h1>

            <div class="testimonial-block wpcd-clear">
                <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/testimonial1.png">
            </div>

            <div class="testimonial-block wpcd-clear">
                <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/testimonial3.png">
            </div>

            <div class="testimonial-block wpcd-clear">
                <img src="<?php echo WPCD_Plugin::instance()->plugin_assets; ?>img/testimonial2.png">
            </div>

            <div class="button-wrap">
                <a href="https://wordpress.org/support/plugin/wp-coupons-and-deals/reviews/"
                    class="wpcd-btn wpcd-btn-lg wpcd-btn-grey" rel="noopener noreferrer" target="_blank">
                    <?php esc_html_e( 'Read More Reviews on WP.org', 'wpcd-coupon' ); ?>
                </a>
            </div>

        </div>

    </div><!-- /.testimonials -->

    <div class="footer">

        <div class="block wpcd-clear">

            <div class="button-wrap wpcd-clear">
                <div class="left">
                    <a href="<?php echo admin_url( 'post-new.php?post_type=wpcd_coupons' ); ?>"
                        class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-green">
                        <?php esc_html_e( 'Create Your First Coupon', 'wpcd-coupon' ); ?>
                    </a>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url( 'edit.php?post_type=wpcd_coupons&page=wp-coupons-and-deals-pricing' ); ?>"
                        class="wpcd-btn wpcd-btn-block wpcd-btn-lg wpcd-btn-trans-green wpcd-upgrade-modal">
                        <span class="underline">
                            <?php esc_html_e( 'WP Coupons and Deals Pro', 'wpcd-coupon' ); ?> <span class="dashicons dashicons-arrow-right"></span>
                        </span>
                    </a>
                </div>
            </div>

        </div>

    </div><!-- /.footer -->

</div><!-- /.container -->

</div><!-- /#wpcd-welcome -->