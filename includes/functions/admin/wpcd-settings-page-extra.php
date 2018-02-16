<?php
/**
 * Created by PhpStorm.
 * User: imtiazrayhan
 * Date: 5/27/17
 * Time: 1:43 AM
 */

?>


<div class="about-wrap">
    <div class="feature-section two-col">
        <div class="col">
            <div class="wpcd_settings_extra">
                <h3><?php _e( 'Help Us Spread the Word!', 'wpcd-coupon' ); ?></h3>
                <p><?php _e( 'Hey, if you like using this plugin, could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word. <br>~ Imtiaz Rayhan', 'wpcd-coupon' ); ?></p>
                <div class="wpcd_rate">
                    <a class="button-primary"
                       href="https://wordpress.org/support/plugin/wp-coupons-and-deals/reviews/#new-post"
                       target="_blank">Ok, you deserve it!</a>
                </div>
                <div id="clear"></div>
            </div>
        </div>

        <div class="col">
            <div class="wpcd_settings_extra">
                <h3><?php _e( 'Keep in touch!', 'wpcd-coupon' ); ?></h3>
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