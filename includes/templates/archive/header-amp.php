<?php
/*
 * Header Grid for Templates
 */
if ( $parent == 'header' || $parent == 'headerANDfooter' ):
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ): ?>
        <section class="wpcd_archive_section wpcd_clearfix">
        <?php
        global $current_url;
        $terms = get_terms( 'wpcd_coupon_category' );
        if ( !empty( $terms ) && !is_wp_error( $terms ) && !$disable_menu ):

            ?>
            <div class="wpcd_div_nav_block">
                <div class="wpcd_cats">
                    <ul id="wpcd_cat_ul">
                        <li>
                            <a class="wpcd_category" data-category="all" href="<?php echo $current_url; ?>amp">
                                <?php echo __( 'All Coupons', 'wpcd-coupon' ); ?>
                            </a>
                        </li>
                        <?php foreach ( $terms as $term ): ?>
                            <li>
                                <a class="wpcd_category" data-category="<?php echo $term->slug; ?>"
                                   href="<?php echo $current_url . '/amp?wpcd_category=' . $term->slug; ?>"><?php echo $term->name; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="wpcd_searchbar">
                    <ul id="wpcd_cat_ul">
                        <li class="wpcd_searchbar_search">
                            <input type="text" placeholder="Search">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="wpcd_cat_ul_border"></div>
        <?php endif; ?>

        <ul id="wpcd_coupon_ul" class="wpcd_clearfix">
    <?php endif; ?>
<?php endif; ?>