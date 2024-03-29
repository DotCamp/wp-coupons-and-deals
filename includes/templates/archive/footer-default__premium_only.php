<?php
/*
 * Footer for Templates
 */
if ($parent == 'footer' || $parent == 'headerANDfooter'):
    ?>

    <div id="wpcd_coupon_pagination_wr" class="wpcd_coupon_pagination wpcd_clearfix"
         wpcd-data-action="wpcd_coupons_category_action">

        <?php
        if (!WPCD_Amp::wpcd_amp_is()) {
            if(infinity_scroll_in_archive()) {
                echo '<div style="display: none;">';
            }
            $add_args = array();

            $archive_category_setting = get_option( 'wpcd_archive-munu-categories' );
            if( $archive_category_setting == 'vendor' ) {
                $wpcd_coupon_taxonomy = WPCD_Plugin::VENDOR_TAXONOMY;
                $wpcd_term_field_name = 'wpcd_vendor';
            } else {
                $wpcd_coupon_taxonomy = WPCD_Plugin::CUSTOM_TAXONOMY;
                $wpcd_term_field_name = 'wpcd_category';
            }

            if ( isset( $_POST[$wpcd_term_field_name] ) && ! empty( $_POST[$wpcd_term_field_name] ) &&
                sanitize_text_field( $_POST[$wpcd_term_field_name] ) === $_POST[$wpcd_term_field_name] ) {
                if ( get_term_by('slug', sanitize_text_field( $_POST[$wpcd_term_field_name] ), $wpcd_coupon_taxonomy ) ) {
                    $add_args[$wpcd_term_field_name] = sanitize_text_field( $_POST[$wpcd_term_field_name] );
                }
            } elseif ( isset($_GET[$wpcd_term_field_name] ) && ! empty( $_GET[$wpcd_term_field_name] ) &&
                sanitize_text_field( $_GET[$wpcd_term_field_name] ) === $_GET[$wpcd_term_field_name] ) {
                if ( get_term_by( 'slug', sanitize_text_field( $_GET[$wpcd_term_field_name] ), $wpcd_coupon_taxonomy ) ) {
                    $add_args[$wpcd_term_field_name] = sanitize_text_field( $_GET[$wpcd_term_field_name] );
                }
            }

            if ( isset($_POST['wpcd_page_num'] ) && ! empty( $_POST['wpcd_page_num'] ) &&
                absint( $_POST['wpcd_page_num'] ) == $_POST['wpcd_page_num'] ) {
                $current = $_POST['wpcd_page_num'];
            } elseif ( isset( $_GET['wpcd_page_num'] ) && ! empty( $_GET['wpcd_page_num'] ) &&
                absint( $_GET['wpcd_page_num'] ) == $_GET['wpcd_page_num'] ) {
                $current = $_GET['wpcd_page_num'];
            } else {
                $current = 1;
            }

            if ( isset( $_POST['search_text'] ) && ! empty( $_POST['search_text'] ) &&
                sanitize_text_field( $_POST['search_text'] ) === trim( $_POST['search_text'] ) ) {
                $add_args['search_text'] = sanitize_text_field( $_POST['search_text'] );
            }

            echo paginate_links(
                array(
                    'base' => '?wpcd_page_num=%#%',
                    'format' => '?page=%#%',
                    'add_args' => $add_args,
                    'current' => absint( $current ),
                    'total' => absint( $max_num_page ),
                    'prev_next' => true,
                    'prev_text' => __('« Prev', 'wp-coupons-and-deals'),
                    'next_text' => __('Next »', 'wp-coupons-and-deals'),
                )
            );
            if(infinity_scroll_in_archive()) {
                echo '</div>';
            }
            ?>
            </div><!-- wpcd_coupon_pagination_wr -->
            <?php
            if ( ! isset( $_POST['action'] ) || $_POST['action'] != 'wpcd_coupons_category_action' ) {
                echo '</div> <!-- wpcd_coupon_archive_container -->';
                echo '<div class="wpcd_coupon_loader wpcd_coupon_hidden_loader">';
                echo '<img src="' . esc_url( WPCD_Plugin::instance()->plugin_assets . 'img/loading.gif') . '">';
                echo '</div>';
                echo '</div> <!-- wpcd_coupon_archive_container_main -->';
            }
        } else {
            echo wpcd_generatePagination( absint( $max_num_page ) );
            echo "</div>";
        }
        ?>

    </section>
<?php endif; ?>
