<?php
/*
 * Footer Grid for Templates
 */
if ( $parent == 'footer' || $parent == 'headerANDfooter' ): ?>

    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix">
        
        <?php
            
            $add_args = array();

            if(!function_exists('generatePageUrl')) {
                function generatePageUrl($current_url, $page_num) {
                    $pos1 = strpos($current_url, '?');

                    if( $pos1 === false ) {
                        $current_url_new = $current_url . '?wpcd_amp_p_num=' . $page_num;
                    } else {
                        $pos2 = strpos($current_url, 'wpcd_amp_p_num');
                        if( $pos2 === false ) {
                            $current_url_new .= $current_url . '&wpcd_amp_p_num=' . $page_num;
                        } else {
                            $current_url_one_del = explode('?', $current_url);
                            if( is_array($current_url_one_del) ) {
                                $current_url_params = $current_url_one_del[1];
                                $current_url_params_del = explode('&', $current_url_params);
                                if( is_array($current_url_params_del) ) {
                                    $current_url_params_new_arr = array();
                                    foreach ($current_url_params_del as $single_par) {
                                        $pos3 = strpos($single_par, 'wpcd_amp_p_num=');
                                        if($pos3 !== false) {
                                            $current_url_params_new_arr[] = 'wpcd_amp_p_num=' . $page_num;
                                        } else {
                                            $current_url_params_new_arr[] .= $single_par;
                                        }
                                    }
                                    $current_url_params_new = implode('&', $current_url_params_new_arr);
                                    $current_url_new = $current_url_one_del[0] . '?' . $current_url_params_new;
                                }
                            }
                        }
                    }
                    return $current_url_new;
                }
            }


            if(!function_exists('curPageURL')) {
                function curPageURL() {
                    $pageURL = 'http';
                    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
                    $pageURL .= "://";
                    if ($_SERVER["SERVER_PORT"] != "80") {
                        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
                    } else {
                        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
                    }
                    return $pageURL;
                }
            }

           
            if(!function_exists('generatePagination')) {
                function generatePagination($current_url, $max_num_page, $end_size = 1, $mid_size = 2, $prev_next = true, $show_all = false) {
                    if($max_num_page < 2) {
                        return;
                    }
                    $current = 1;
                    if( $_GET['wpcd_amp_p_num'] && (int)$_GET['wpcd_amp_p_num'] ) $current = (int)$_GET['wpcd_amp_p_num'];
                    $page_links = array();
                    if ( $prev_next && $current && 1 < $current ) :
                        $current_minus_one = $current - 1;
                        $page_links[] = '<a class="prev page-numbers" href="' . esc_url( generatePageUrl($current_url, $current_minus_one) ) . '">« Prev</a>';
                    endif;
                    for ( $n = 1; $n <= $max_num_page; $n++ ) :
                        if ( $n == $current ) :
                            $page_links[] = "<span class='page-numbers current'>" . number_format_i18n( $n ) . "</span>";
                            $dots = true;
                        else :
                            if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $max_num_page - $end_size ) ) :

                                $page_links[] = "<a class='page-numbers' href='" . esc_url( generatePageUrl($current_url, $n) ) . "'>" . number_format_i18n( $n ) . "</a>";
                                $dots = true;
                            elseif ( $dots && ! $show_all ) :
                                $page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
                                $dots = false;
                            endif;
                        endif;
                    endfor;
                    if ( $prev_next && $current && $current < $max_num_page ) :
                        
                        $current_plus_one = $current + 1;
                        $page_links[] = '<a class="next page-numbers" href="' . esc_url( generatePageUrl($current_url, $current_plus_one) ) . '">Next »</a>';
                    endif;

                    if( is_array($page_links) && count($page_links) > 0 ) {
                        return implode(' ', $page_links);
                    } 
                }
            }
            
            $current_url = curPageURL();

            echo generatePagination($current_url, $max_num_page);

            

        ?>
    </div>


   

</section>
<?php endif;
