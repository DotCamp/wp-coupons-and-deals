<?php
/*
 * Header for Templates
 */
if ( $parent == 'header' || $parent == 'headerANDfooter' ):
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ):
        ?>
        <section class="wpcd_archive_section wpcd_clearfix">
            <?php
            
            $terms = get_terms( 'wpcd_coupon_category' );
            if ( !empty( $terms ) && !is_wp_error( $terms ) && !$disable_menu ):
                $pageNum=(get_query_var('paged')) ? get_query_var('paged') : 1;
                $current_url = get_pagenum_link($pageNum);
                $current_url_final = preparationMenuLinks( $current_url );
                $current_url_final_all = $current_url_final['all'];
                $current_url_final_sin = $current_url_final['sin'];
                ?>
                <div class="wpcd_div_nav_block">
                    <div class="wpcd_cats">
                        <ul id="wpcd_cat_ul" class="wpcd_dropdown wpcd_categories_in_dropdown">
                            <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>    
                                <a href="javascript:void(0)" class="wpcd_dropbtn">
                                    <?php echo __( 'Categories', 'wpcd-coupon' ); ?>
                                </a>
                            <?php endif; ?>
                            <div class="wpcd_dropdown-content">
                                <li>
                                    <a class="wpcd_category" data-category="all" href="<?php echo $current_url_final_all; ?>">
                                        <?php echo __( 'All Coupons', 'wpcd-coupon' ); ?>
                                    </a>
                                </li>
                                <?php foreach ( $terms as $term ): ?>
                                    <li>
                                        <a class="wpcd_category" data-category="<?php echo $term->slug; ?>"
                                           href="<?php echo $current_url_final_sin . 'wpcd_category=' . $term->slug; ?>"><?php echo $term->name; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </div>
                        </ul>
                    </div>
                    <?php if( !WPCD_Amp::wpcd_amp_is() ): ?>
                        <div id="wpcd_searchbar">
                            <ul id="wpcd_cat_ul_search">
                                <li class="wpcd_searchbar_search">
                                    <input type="text" placeholder="Search">
                                </li>
                            </ul>
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
            <div class="wpcd_coupon_loader wpcd_coupon_hidden_loader">
                <img src="<?php echo WPCD_Plugin::instance()->plugin_assets . 'img/loading.gif'; ?>">
            </div>
            <div id="wpcd_coupon_archive_container">
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>