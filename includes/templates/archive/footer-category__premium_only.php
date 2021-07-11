<?php
/*
 * Footer for Templates
 */
if ( $parent == 'footer' || $parent == 'headerANDfooter' ):
?>
    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix"
         wpcd-data-action="wpcd_coupons_cat_vend_action">

        <?php
            if( ! WPCD_Amp::wpcd_amp_is() ) {
                if(infinity_scroll_in_archive()) {
                    echo '<div style="display: none;">';
                }
                if ( isset( $_POST['wpcd_page_num'] ) && ! empty( $_POST['wpcd_page_num'] ) && absint( $_POST['wpcd_page_num'] ) == $_POST['wpcd_page_num'] ) {
                    $current = absint( $_POST['wpcd_page_num'] );
                } elseif ( isset( $_GET['wpcd_page_num'] ) && ! empty( $_GET['wpcd_page_num'] ) && absint( $_GET['wpcd_page_num'] ) == $_GET['wpcd_page_num'] ) {
                    $current = absint( $_GET['wpcd_page_num'] );
                } else {
                    $current = 1;
                }

                echo paginate_links(
                    array(
                        'base'      => '?wpcd_page_num=%#%',
                        'format'    => '?page=%#%',
                        'current'   => $current,
                        'total'     => $max_num_page,
                        'prev_next' => true,
                        'prev_text' => __( '« Prev', 'wpcd-coupon' ),
                        'next_text' => __( 'Next »', 'wpcd-coupon' ),
                    )
                );
                if(infinity_scroll_in_archive()) {
                    echo '</div>';
                }

                ?>
                </div><!-- wpcd_coupon_pagination_wr -->
                <?php

                if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_cat_vend_action' ) {
                    echo '</div> <!-- wpcd_coupon_archive_container -->';
                    echo '<div class="wpcd_coupon_loader wpcd_coupon_hidden_loader">';
                    echo '<img src="' . WPCD_Plugin::instance()->plugin_assets . 'img/loading.gif">';
                    echo '</div>';
                    echo '</div> <!-- wpcd_coupon_archive_container_main -->';
                }
            } else {
                echo wpcd_generatePagination( $max_num_page );
                echo "</div>";
            }
        ?>
</section>
<?php endif; ?>
