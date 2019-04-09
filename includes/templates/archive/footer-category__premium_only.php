<?php
/*
 * Footer for Templates
 */
if ( $parent == 'footer' || $parent == 'headerANDfooter' ): 
?>                
    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix" wpcd-data-action="wpcd_coupons_cat_vend_action">
        
        <?php
            if( ! WPCD_Amp::wpcd_amp_is() ) {
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

                if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ) {
                    echo '</div></div> <!-- wpcd_coupon_archive_container -->';
                    echo '</div> <!-- wpcd_coupon_archive_container_main -->';
                }
                
            } else {
                echo wpcd_generatePagination( $max_num_page );
                echo "</div>";
            }
        ?>
</section>
<?php endif; ?>