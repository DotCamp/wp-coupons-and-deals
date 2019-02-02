<?php
/*
 * Header for Templates
 */
if ($parent == 'header' || $parent == 'headerANDfooter'):
?>
<section class="wpcd_archive_section wpcd_clearfix">
    <?php
    global $current_url;
    $terms = get_terms('wpcd_coupon_category');
    if (!empty($terms) && !is_wp_error($terms) && !$disable_menu):
        ?>
        <div class="wpcd_div_nav_block">
            <ul id="wpcd_cat_ul">
                <li>
                    <a class="wpcd_category" data-category="all" href="<?php echo $current_url; ?>">
                        <?php echo __('All Coupons', 'wpcd-coupon'); ?>
                    </a>
                </li>
                <?php foreach ($terms as $term): ?>
                    <li>
                        <a class="wpcd_category" data-category="<?php echo $term->slug; ?>"
                           href="<?php echo $current_url . '?wpcd_category=' . $term->slug; ?>"><?php echo $term->name; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div id="wpcd_searchbar">
                <ul id="wpcd_cat_ul">
                    <li class="wpcd_searchbar_search">
                        <span id="wpcd_searchbar_search_icon" class="dashicons dashicons-search"></span>
                        <input type="text" placeholder="Search">
                    </li>
                    <span id="wpcd_searchbar_search_close" class="dashicons dashicons-dismiss"></span>
                </ul>
                <ul id="wpcd_cat_ul" class="wpcd_search2">
                    <li class="wpcd_searchbar_search">
                        <input type="text" placeholder="Search">
                    </li>
                    <span id="wpcd_searchbar_search_close" class="dashicons dashicons-dismiss"></span>
                </ul>
            </div>
        </div>
        <div class="wpcd_cat_ul_border"></div>
    <?php endif; ?>
    <?php endif; ?>
    <?php //categories with dropdown, if needed for later
    /*
    <div class="wpcd_cats">
                <ul id="wpcd_cat_ul" class="wpcd_dropdown">
                    <a href="javascript:void(0)" class="wpcd_dropbtn">Categories</a>
                    <div class="wpcd_dropdown-content">
                    <li>
                        <a class="wpcd_category" data-category="all" href="<?php echo $current_url; ?>">
                            <?php echo __('All Coupons', 'wpcd-coupon'); ?>
                        </a>
                    </li>
                    <?php foreach ($terms as $term): ?>
                        <li>
                            <a class="wpcd_category" data-category="<?php echo $term->slug; ?>"
                               href="<?php echo $current_url . '?wpcd_category=' . $term->slug; ?>"><?php echo $term->name; ?></a>
                        </li>
                    <?php endforeach; ?>
                    </div>
                </ul>
            </div>
     */
    ?>
