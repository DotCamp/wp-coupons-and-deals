<?php
/**
 * Adds the import page.
 *
 * @since 2.3.2
 */

// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpcd_coupon_templates = array('Template One', 'Template Two', 'Template Three', 'Template Four', 'Template Five', 'Template Six', 'Template Seven', 'Template Eight');

?>

<div class="wrap">
    <h2><?php echo __( 'Import Coupons from CSV File', 'wpcd-coupon' ); ?></h2>
    <section id="wpcd_import_form_wr">
		<?php
		if ( isset( $_POST['wpcd_import_submit_final'] ) ) {

			$counter            = $_POST['wpcd_import_counter_field'] - 1;
			$import_fields_data = array();

			for ( $count = 0; $count <= $counter; $count ++ ) {
				$import_fields_data[ $_POST[ 'wpcd_import_select_' . $count ] ] = $count;
			}

			$handle3      = fopen( dirname( __FILE__ ) . '/wpcd_file.csv', "r" );
			$coupon_count = 0;

			while ( ( $data = fgetcsv( $handle3, 1000000 ) ) !== false ) {

				if ( $coupon_count != 0 ) {

					if ( isset( $import_fields_data['coupon_category'] ) ) {
						$website = $data[ $import_fields_data['coupon_category'] ];
					} else {
						$website = '';
					}
                                        
                    if ( isset( $import_fields_data['coupon_vendor'] ) ) {
						$vendor = $data[ $import_fields_data['coupon_vendor'] ];
					} else {
						$vendor = '';
					}

					if ( isset( $import_fields_data['coupon_title'] ) ) {
						$title = $data[ $import_fields_data['coupon_title'] ];
					} else {
						$title = '';
					}

					if ( isset( $import_fields_data['coupon_details_coupon-code-text'] ) ) {
						$coupon_code = $data[ $import_fields_data['coupon_details_coupon-code-text'] ];
					} else {
						$coupon_code = '';
					}

					if ( isset( $import_fields_data['coupon_details_link'] ) ) {
						$link = $data[ $import_fields_data['coupon_details_link'] ];
					} else {
						$link = '';
					}

					if ( isset( $import_fields_data['coupon_details_discount-text'] ) ) {
						$discount_text = $data[ $import_fields_data['coupon_details_discount-text'] ];
					} else {
						$discount_text = '';
					}

					if ( isset( $import_fields_data['coupon_details_description'] ) ) {
						$description = $data[ $import_fields_data['coupon_details_description'] ];
					} else {
						$description = '';
					}

					if ( isset( $import_fields_data['coupon_details_expire-date'] ) ) {
						$expiry_date = $data[ $import_fields_data['coupon_details_expire-date'] ];
					} else {
						$expiry_date = '';
					}

					if ( isset( $import_fields_data['coupon_details_hide-coupon'] ) ) {
						$hide_coupon = $data[ $import_fields_data['coupon_details_hide-coupon'] ];
						if ( $hide_coupon !== 'Yes' && $hide_coupon !== 'No' ) {
							$hide_coupon = '';
						}
					} else {
						$hide_coupon = '';
					}

					if ( isset( $import_fields_data['coupon_details_coupon-template'] ) ) {
						$default_coupon_template = trim( $data[ $import_fields_data['coupon_details_coupon-template'] ] );
						if ( ! in_array( trim( $default_coupon_template ), $wpcd_coupon_templates ) ) {
							$default_coupon_template = $_POST['wpcd_default_template'];
						}
					} else {
						$default_coupon_template = $_POST['wpcd_default_template'];
					}

					if ( $title != '' ) {
						$args = array(
							'post_type'    => 'wpcd_coupons',
							'post_title'   => $title,
							'post_content' => '',
							'post_status'  => 'publish',
						);

						$post_id = wp_insert_post( $args );

						if ( ! is_wp_error( $post_id ) ) {

							add_post_meta( $post_id, 'coupon_details_coupon-type', 'Coupon', true );
							add_post_meta( $post_id, 'coupon_details_coupon-code-text', $coupon_code, true );
							add_post_meta( $post_id, 'coupon_details_link', $link, true );
							add_post_meta( $post_id, 'coupon_details_description', $description, true );
							add_post_meta( $post_id, 'coupon_details_discount-text', $discount_text, true );
							add_post_meta( $post_id, 'coupon_details_show-expiration', 'Show', true );
							add_post_meta( $post_id, 'coupon_details_expire-date', $expiry_date, true );
							add_post_meta( $post_id, 'coupon_details_hide-coupon', $hide_coupon, true );
							add_post_meta( $post_id, 'coupon_details_coupon-template', $default_coupon_template, true );     

                            // Theme Color for only template Five and Six
                            $theme_color = $_POST['theme_color'];
                            if ( $default_coupon_template == 'Template Five' ):
                                add_post_meta( $post_id, 'coupon_details_template-five-theme', $theme_color );
                        	elseif( $default_coupon_template == 'Template Six'):
                                add_post_meta( $post_id, 'coupon_details_template-six-theme', $theme_color );
                            endif;

							if ( $website != '' && $website != ' ' ) {
								wp_set_object_terms( $post_id, $website, 'wpcd_coupon_category' );
							}
                                                        
                            if ( $vendor != '' && $vendor != ' ' ) {
								wp_set_object_terms( $post_id, $vendor, 'wpcd_coupon_vendor' );
							}

							$coupon_count++;

						} else {
							echo $post_id->get_error_message() . __( ' | On Line Number ', 'wpcd-coupon' ) . $coupon_count . '<br />';
						}

					} else {
						echo __( 'Error | On Line Number ', 'wpcd-coupon' ) . $coupon_count . '<br />';
					}

				} else {
					$coupon_count++;
				}

			}

			$total_coupon_import = $coupon_count - 1;
			echo '<div class="wpcd_green">' . $total_coupon_import . __( ' Coupons added.', 'wpcd-coupon' ) . '<a href="' . admin_url( 'edit.php?post_type=wpcd_coupons' ) . '" class="page-title-action">' . __( 'View', 'wpcd-coupon' ) . '</a></div>';
			fclose( $handle3 );

		} else {

			// Upload File.
			$count_row = 0;
			if ( isset( $_POST['wpcd_import_submit'] ) ) {
				$mimes = array(
					'application/vnd.ms-excel',
					'text/plain',
					'text/csv',
					'text/tsv',
					'application/octet-stream',
				);
				$file_extension = pathinfo( $_FILES['wpcd_import_file']['name'], PATHINFO_EXTENSION );
				if ( in_array( $_FILES['wpcd_import_file']['type'], $mimes ) && $file_extension === 'csv' ) {

					$handle = fopen( $_FILES['wpcd_import_file']['tmp_name'], "r" );
					$i      = 1;
					echo '<p style="font-size: 16px">' . __( 'This is just a preview of the CSV file you uploaded. All data are not showing here.', 'wpcd-coupon' ) . '</p>';
					echo '<div class="wpcd_preview_table_support">';
					echo '<table class="widefat wpcd_import_preview" cellspacing="0">';
					while ( ( $data = fgetcsv( $handle, 1000000 ) ) !== false ) {
						if ( $i == 1 ) {
							echo '<thead>';
							echo '<tr>';
							foreach ( $data as $value ) {
								echo '<th>';
								echo $value;
								echo '</th>';
							}
							echo '</tr>';
							echo '</thead>';
						} else {
							echo '<tr>';
							foreach ( $data as $value ) {
								echo '<td>';
								echo $value;
								echo '</td>';
							}
							echo '</tr>';
						}
						if ( $i > 5 ) {
							break;
						}
						$i ++;
						$count_row += 1;
					}
					fclose( $handle );
					echo '</table>';
					echo '</div>';
					echo '<div class="wpcd_choose_fields_wr wpcd_import_white_box wpcd_clearfix">';
					echo '<h5>' . __( 'Select Import Fields', 'wpcd-coupon' ) . '</h5>';
					echo '<form id="wpcd_import_form_final" class="wpcd_clearfix" enctype="multipart/form-data" method="post">';
					$handle2 = fopen( $_FILES['wpcd_import_file']['tmp_name'], "r" );
					while ( ( $data = fgetcsv( $handle2, 1000000 ) ) !== false ) {
						$name_var = 0;
						echo '<div class="wpcd_import_field_inner_wr wpcd_clearfix">';
						echo '<div class="wpcd_import_notes" style="display:none;">' . __( '* Coupon title is required', 'wpcd-coupon' ) . '</div>';
						foreach ( $data as $value ) {
							echo '<div class="wpcd_import_field">';
							echo '<label>';
							echo $value;
							echo '</label>';
							echo '<select class="wpcd_import_field_select" name="wpcd_import_select_' . $name_var . '" id="wpcd_import_select_' . $name_var . '" onChange="return wpcd_checkDuplicateField(' . $name_var . ')">';
							echo '<option value="">Select</option>';
							echo '<option value="coupon_title">Coupon Title</option>';
							echo '<option value="coupon_details_description">Coupon Description</option>';
							echo '<option value="coupon_category">Coupon Category</option>';
							echo '<option value="coupon_vendor">Coupon Vendor</option>';
							echo '<option value="coupon_details_coupon-code-text">Coupon Code</option>';
							echo '<option value="coupon_details_link">Coupon Link</option>';
							echo '<option value="coupon_details_discount-text">Discount Amount/Text</option>';
							echo '<option value="coupon_details_expire-date">Expiration Date</option>';
							echo '<option value="coupon_details_hide-coupon">Hide Coupon</option>';
							echo '<option value="coupon_details_coupon-template">Coupon Template</option>';
							echo '</select>';
							echo '</div>';
							$name_var ++;
						}
						echo '</div>';
						echo '<div class="wpcd_import_field wpcd_import_field_submit wpcd_clearfix">';
						echo '<input type="hidden" name="wpcd_import_counter_field" value="' . $name_var . '" />';
						echo '<input type="file" style="display:none;" name="wpcd_import_file_final" value="' . $_FILES['wpcd_import_file']['tmp_name'] . '" />';
						echo '<input type="hidden" name="wpcd_default_template" value="' . $_POST['wpcd_default_template'] . '">';
                        echo '<input type="hidden" name="theme_color" value="'.$_POST['theme_color'].'">';
						echo '<input name="wpcd_import_submit_final" value="" class="button button-primary button-large wpcp-import-btn" type="submit">';
                        echo '<span><strong>' . ($count_row - 1) . '</strong> Rows will be added! </span>'; 
						echo '</div>';
						break;
					}

					$wpcd_csv = dirname( __FILE__ ) . '/wpcd_file.csv';
					move_uploaded_file( $_FILES['wpcd_import_file']['tmp_name'], $wpcd_csv );
					fclose( $handle2 );

					echo '</form>';
					echo '<div class="wpcd_import_form_final_loader wpcd_loader" style="display:none;"></div>';
					
				} else { 
                    include('import-form__premium_only.php');
				}
			} else {
                include('import-form__premium_only.php');
			}
		}?>
    </section>
</div>