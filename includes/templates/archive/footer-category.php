<?php
/*
 * Footer for Templates
 */
if ( $parent == 'footer' || $parent == 'headerANDfooter' ): 
    if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ):
        echo "</ul>";
    endif;
?>                
    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix" wpcd-data-action="wpcd_coupons_cat_vend_action">
        
        <?php
            if( !WPCD_Amp::wpcd_amp_is() ) {
                $add_args = array();

                if ( isset($_POST['page_num'] ) && !empty( $_POST['page_num'] ) ) {
                    $current = (int)( $_POST['page_num'] );
                } else {
                    $current = 1;
                }
            
                echo paginate_links( 
                    array(
                        'base'      => '?page_num=%#%',
                        'format'    => '?page=%#%',
                        'add_args'  => $add_args,
                        'current'   => $current,
                        'total'     => $max_num_page,
                        'prev_next' => true,
                        'prev_text' => __( '« Prev', 'wpcd-coupon' ),
                        'next_text' => __( 'Next »', 'wpcd-coupon' ),
                    )
                );  

                if ( !isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ) {
                    echo '</div></div> <!-- wpcd_coupon_archive_container -->
            </div> <!-- wpcd_coupon_archive_container_main -->';
                }
                
            } else {
                $current_url = wpcd_curPageURL();
                echo wpcd_generatePagination($current_url, $max_num_page);
                echo "</div>";
            }
        ?>
</section>
<?php endif; ?>