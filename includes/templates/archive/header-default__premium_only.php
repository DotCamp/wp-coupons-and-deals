<?php
/*
 * Header for Templates
 */
if ( $parent == 'header' || $parent == 'headerANDfooter' ):
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ):
        ?>
        <section class="wpcd_archive_section wpcd_clearfix">
        <?php

            $archive_category_setting = get_option( 'wpcd_archive-munu-categories' );
            if( !($all_coupon_text = get_option( 'wpcd_all-coupon-text')) ){
                $all_coupon_text = __( 'All Coupons', 'wp-coupons-and-deals' );
            }

            if( $archive_category_setting == 'vendor' ) {
                $terms = get_terms( 'wpcd_coupon_vendor' );
                $wpcd_term_field_name = 'wpcd_vendor';
                $wpcd_category_menu_title = 'Vendors';
                $wpcd_js_data_tax_name = 'data-vendor';
            } else {
                $terms = get_terms( 'wpcd_coupon_category' );
                $wpcd_term_field_name = 'wpcd_category';
                $wpcd_category_menu_title = 'Categories';
                $wpcd_js_data_tax_name = 'data-category';
            }

            if ( !empty( $terms ) && !is_wp_error( $terms ) && !$disable_menu ):
                $current_url_final = wpcd_preparationMenuLinks( $wpcd_term_field_name );
                $current_url_final_all = $current_url_final['all'];
                $current_url_final_sin = $current_url_final['sin'];
        ?>
                <div class="wpcd_div_nav_block">
                    <div class="wpcd_cats">
                        <ul id="wpcd_cat_ul" class="wpcd_dropdown wpcd_categories_in_dropdown">
                            <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                                <a href="javascript:void(0)" class="wpcd_dropbtn">
                                    <?php echo esc_html__( $wpcd_category_menu_title, 'wp-coupons-and-deals' ); ?>
                                </a>
                            <?php else: ?>
                                <div class="wpcd_dropbtn">
                                    <?php echo esc_html__( $wpcd_category_menu_title, 'wp-coupons-and-deals' ); ?>
                                </div>
                            <?php endif; ?>
                            <div class="wpcd_dropdown-content">
                                <li>
                                    <?php
                                        if( ! isset( $_GET[$wpcd_term_field_name] ) || $_GET[$wpcd_term_field_name] == 'all' || $_GET[$wpcd_term_field_name] == '' ) {
                                            $wpcd_dropdown_content = ' active';
                                        } else {
                                            $wpcd_dropdown_content = '';
                                        }
                                    ?>
                                    <a class="wpcd_category<?php echo esc_attr( $wpcd_dropdown_content ); ?>" <?php echo esc_attr( $wpcd_js_data_tax_name ); ?>="all" href="<?php echo esc_url( $current_url_final_all ); ?>">
                                        <?php echo esc_html( $all_coupon_text ); ?>
                                    </a>
                                </li>
                                <?php foreach ( $terms as $term ):
                                    if( isset( $_GET[$wpcd_term_field_name] ) && $_GET[$wpcd_term_field_name] == $term->slug ) {
                                        $wpcd_dropdown_content = ' active';
                                    } else {
                                        $wpcd_dropdown_content = '';
                                    }


                                ?>
                                    <li>
                                        <a class="wpcd_category<?php echo esc_attr( $wpcd_dropdown_content ); ?>" <?php echo esc_attr( $wpcd_js_data_tax_name ); ?>="<?php echo esc_attr( $term->slug ); ?>"
                                           href="<?php echo esc_url( $current_url_final_sin . $wpcd_term_field_name . '=' . $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </div>
                        </ul>
                    </div>
                    <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                        <div id="wpcd_searchbar">
                            <div id="wpcd_cat_ul_search">
                                <div class="wpcd_searchbar_search">
                                    <input type="text" placeholder="Search">
                                </div>
                            </div>
                            <!--
                            <ul id="wpcd_cat_ul" class="wpcd_search2">
                                <li class="wpcd_searchbar_search">
                                    <input type="text" placeholder="Search">
                                </li>
                                <span id="wpcd_searchbar_search_close" class="dashicons dashicons-dismiss"></span>
                            </ul>
                            -->
                        </div>
                    <?php endif; ?>
                </div>
                <div class="wpcd_cat_ul_border"></div>
            <?php endif; ?>
            <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
            <div class="wpcd_coupon_archive_container_main">
                <div class="wpcd_coupon_archive_container">
            <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
