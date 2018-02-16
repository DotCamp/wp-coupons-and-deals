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

<div class="wrap about-wrap">

    <h1><?php printf( __( 'WP Coupons and Deals %s', 'wpcd-coupon' ), WPCD_Plugin::PLUGIN_VERSION ); ?></h1>

    <div class="about-text">
		<?php printf( __( "Thank you for using WP Coupons and Deals plugin. 
		WP Coupons and Deals is ready to create beautiful coupons and deals shortcode for you. ", 'wpcd-coupon' ), WPCD_Plugin::PLUGIN_VERSION ); ?>
		<?php echo __( 'Check out the changes in this version ', 'wpcd-coupon' ) . '<a href="https://wpcouponsdeals.com/blog/">' . __( 'in our blog.', 'wpcd-coupon' ) . '</a>'; ?>
    </div>

    <div class="wp-badge welcome__logo"></div>

    <div class="feature-section two-col">
        <div class="col">
            <h3><?php _e( "Let's Get Started", 'wpcd-coupon' ); ?></h3>
            <ul>
                <li>
                    <strong><?php _e( 'Step 1:', 'wpcd-coupon' ); ?></strong> <?php _e( 'First things first,', 'wpcd-coupon' ); ?>
                    <a href="<?php echo get_admin_url() . 'post-new.php?post_type=wpcd_coupons'; ?>"
                       target="_blank"><?php _e( 'Add a new Coupon.', 'wpcd-coupon' ); ?></a></li>
                <li>
                    <strong><?php _e( 'Step 2:', 'wpcd-coupon' ); ?></strong> <?php _e( 'Copy and paste the shortcode in your post.', 'wpcd-coupon' ); ?>
                </li>
                <li>
                    <strong><?php _e( 'Step 3:', 'wpcd-coupon' ); ?></strong> <?php _e( 'Publish your post and you are done!!', 'wpcd-coupon' ); ?>
                </li>
            </ul>
        </div>

        <div class="col">
            <h3><?php _e( "Adding coupons in widget areas", 'wpcd-coupon' ); ?></h3>
            <ul>
                <li>
                    <strong><?php _e( 'Step 1:', 'wpcd-coupon' ); ?></strong> <?php _e( "Drag the 'Coupons and Deals Widget' to widget area.", 'wpcd-coupon' ); ?>
                </li>
                <li>
                    <strong><?php _e( 'Step 2:', 'wpcd-coupon' ); ?></strong> <?php _e( 'Select the coupon you want to show.', 'wpcd-coupon' ); ?>
                </li>
                <li>
                    <strong><?php _e( 'Step 3:', 'wpcd-coupon' ); ?></strong> <?php _e( "Hit the save button. You're done.", 'wpcd-coupon' ); ?>
                </li>
            </ul>

        </div>
    </div>

    <h3 align="center"><?php _e( "Here's a liitle video to help you get started.", 'wpcd-coupon' ); ?></h3>

    <div class="feature-section one-col">
        <div class="feature-video">
            <div>
                <iframe width="640" height="360" src="https://www.youtube.com/embed/w_2_ONfWGvM?rel=0&amp;showinfo=0"
                        frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <p align="center">
            <i><?php _e( 'Watch the video on HD and fullscreen for a clear experience.', 'wpcd-coupon' ) ?></i></p>

    </div>

    <div class="feature-section two-col">
        <div class="col">
            <div class="wpcd_settings_extra">
                <h3><?php _e( 'Contact', 'wpcd-coupon' ); ?></h3>
                <p><?php _e( 'If you have any questions or suggestions about the plugin, feel free to <a href="https://wpcouponsdeals.com/contact-us/" target="_blank">get in touch</a>.', 'wpcd-coupon' ); ?></p>
                <p><?php _e( 'I would love to hear from you. You can also conncect with me on', 'wpcd-coupon' ); ?> <a
                            href="http://facebook.com/imtiaz.rayhan.bleh" rel="nofollow">Facebook</a>, <a
                            href="https://plus.google.com/u/0/+ImtiazRayhanAsif/" rel="nofollow">Google+</a> and <a
                            href="https://twitter.com/asif_irayhan" rel="nofollow">Twitter</a>.</p>
            </div>
        </div>

        <div class="col">
            <div class="wpcd_settings_extra">
                <h3><?php _e( 'More stuff!', 'wpcd-coupon' ); ?></h3>
                <p><?php _e( 'Sign up to get plugin updates news, WordPress tips and more! We hate spam  just as much as you do. We promise we wil NEVER EVER spam.', 'wpcd-coupon' ); ?></p>
                <!-- Begin MailChimp Signup Form -->
                <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet"
                      type="text/css">
                <style type="text/css">
                    #mc_embed_signup {
                        background: #fff;
                        clear: left;
                        font: 14px Helvetica, Arial, sans-serif;
                        width: 100%;
                    }

                    /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
				    We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
                </style>
                <div id="mc_embed_signup">
                    <form action="//imtiazrayhan.us15.list-manage.com/subscribe/post?u=0a9383740015cd2c6a8912d36&amp;id=07de159dd4"
                          method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form"
                          class="validate" target="_blank" novalidate>
                        <div id="mc_embed_signup_scroll">

                            <input style="height: 30px;" type="email"
                                   value="<?php echo get_option( 'admin_email', 'email@address.com' ) ?>" name="EMAIL"
                                   class="email" id="mce-EMAIL" placeholder="Email Address" required>
                            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text"
                                                                                                      name="b_0a9383740015cd2c6a8912d36_07de159dd4"
                                                                                                      tabindex="-1"
                                                                                                      value=""></div>
                            <div class="clear"><input type="submit" value="Sign Me Up!" name="subscribe"
                                                      id="mc-embedded-subscribe" class="button-primary"></div>
                        </div>
                    </form>
                </div>
                <!--End mc_embed_signup-->
            </div>
        </div>
    </div>

</div>
