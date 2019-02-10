<?php
/*
 * Footer for Templates
 */
if ( $parent == 'footer' || $parent == 'headerANDfooter' ): ?>
    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix">
        <?php
        $big = 999999999; // need an unlikely integer
        echo paginate_links( array(
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format'    => '?paged=%#%',
            'current'   => max( 1, get_query_var( 'paged' ) ),
            'total'     => $max_num_page,
            'prev_next' => true,
            'prev_text' => __( '« Prev', 'wpcd-coupon' ),
            'next_text' => __( 'Next »', 'wpcd-coupon' ),
        ) );
        ?>
    </div>
    
</section>
<?php endif; ?>