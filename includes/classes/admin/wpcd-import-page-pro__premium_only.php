<?php
// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPCD_Import_Page_Pro extends WPCD_Import_Page {

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item() {

		global $import_page;
		/**
		 * Adding the import page under our main menu item.
		 *
		 * @since 2.3.2
		 */
		$import_page = add_submenu_page(
			'edit.php?post_type=wpcd_coupons',
			__( 'WP Coupons and Deals: Import Coupons', 'wp-coupons-and-deals' ),
			__( 'Import Coupons', 'wp-coupons-and-deals' ),
            WPCD_Plugin::ALLOWED_ROLE_META_CAP,
			'wpcd_coupon_import',
			array( $this, 'import_page' )
		);
	}

	/**
	 * Content for Import Page.
	 *
	 * @since 2.3.2
	 */
	public function import_page() {
		$wpcd_coupon_templates = array(
			'Default',
			'Template One',
			'Template Two',
			'Template Three',
			'Template Four',
			'Template Five',
			'Template Six',
			'Template Seven',
			'Template Eight'
		);

		echo '<div class="wrap">
		<h2>' . __( 'Import Coupons from CSV or XML File', 'wp-coupons-and-deals' ) . '</h2>
		<section id="wpcd_import_form_wr">
		<form id="wpcd_import_form" class="wpcd_clearfix" enctype="multipart/form-data" method="post">
		<p style="font-size: 16px">' . __( 'Here you can import coupons from a CSV or XML file. Select the file you want to import, then click on Next.', 'wp-coupons-and-deals' ) . '</p>
		<p style="font-size: 16px">' . __( "Coupons will be imported as 'Coupon' type.", 'wp-coupons-and-deals' ) .
		
		'<div class="wpcd_import_field">
			<div>
				<label>' . __( 'Choose Default template which will be assigned to imported coupons.', 'wp-coupons-and-deals' ) . '</label>
				<select name="wpcd_default_template">';

		foreach ( $wpcd_coupon_templates as $template ){
			echo '<option value="' . esc_attr( $template ) . '">' . esc_html( $template ) . '</option>';
		}
		echo '</select>
			</div>
			<div id="wpcd_import_color_parent" style="display:none;">
				<label>' . __( 'Color Theme:', 'wp-coupons-and-deals' ) . '</label>
				<div id="wpcd_import_color" class="wpcd_colorSelectors">
					<div data-color="#18e06e" style="background-color:#18e06e;"></div>
					<input id="wpcd_import_color" name="theme_color" type="text" value="#18e06e"/>
				</div>
			</div>
			<div>
				<input type="file" name="wpcd_import_file" id="wpcd_import_file" required/>	
			</div>
			<div>
				<input type="submit" name="wpcd_import_submit" class="button button-primary button-large" id="wpcd_import_next_submit" value="Next" />
				<hr />
			</div>
		</div>';

		if( isset( $_POST['wpcd_import_submit'] ) ){
			echo '<p style="font-size: 16px; color: red">' .  __( 'File type not allowed.', 'wp-coupons-and-deals' ) . '</p>';
		}

		echo '<p style="font-size: 16px;">' . __( 'Only CSV or XML files are allowed.', 'wp-coupons-and-deals' ) . '</p>
		<div class="wpcd_import_form_loader wpcd_loader" style="display:none"></div>
	
		<!-- Remove after finish below -->
		
	</form>
	
			<!-- Wrapper set to display none -->
			<div class="wpcd-import-wrapper">
				<p>' . __( 'This is just a preview of the file you uploaded. All data are not showing here.', 'wp-coupons-and-deals') . '</p>
				<!-- Table -->
				<div class="wpcd_preview_table_support">
					<div id="wpcd-table-csv">
						<!-- Table data here from js -->
					</div>
				</div>
				<div class="wpcd_choose_fields_wr wpcd_import_white_box wpcd_clearfix">
					<h5>' . __( 'Select Import Fields', 'wp-coupons-and-deals' ) . '</h5>
					<form id="wpcd_import_form_final" class="wpcd_clearfix" enctype="multipart/form-data" method="post">
						<div class="wpcd_import_field_inner_wr wpcd_clearfix">
							<div class="wpcd_import_field">
								<div class="wpcd_import_field wpcd_import_field_submit wpcd_clearfix">
								<input type="hidden" name="wpcd_import_counter_field" value="$name_var" />
								<input type="file" style="display:none;" name="wpcd_import_file_final" value="' . filter_var($_FILES['wpcd_import_file']['tmp_name'], FILTER_SANITIZE_STRING) .'" />
								<input type="hidden" name="wpcd_default_template" value="' . filter_var($_POST['wpcd_default_template'], FILTER_SANITIZE_STRING) . '">
								<input type="hidden" name="theme_color" value="' . sanitize_hex_color($_POST['theme_color']) . '">'
								. wp_nonce_field( 'wpcd_nonce' ) .
								'<input name="wpcd_import_submit_final" value="Import Coupons" class="button button-primary button-large wpcd-import-btn" type="submit">
								<span><strong>0</strong>' . __( 'Coupons will be added!', 'wp-coupons-and-deals' ) . '</span>
								<p style="display:none; color: red; font-size: 16px; margin-top: 20px;" id="wpcd_import_field_error">' . __( 'Error: You must select a field for Coupon Title.', 'wp-coupons-and-deals' ) . '</p>
							</div>
							</div><!-- end of import notes -->
						</div><!-- end of clearfix -->
					</form>
					<div class="wpcd_import_form_final_loader wpcd-pbar-container" style="display:none;">
						<div class="wpcd-pbar-progress">
							<div id="wpcd-pbar-percent" class="wpcd-pbar-progress-bar wpcd-zero-percent">
								<span>0%</span>
							</div>
						</div>
					</div>
				</div>
			</div><!-- End of Wrapper import -->
			<div class="wpcd_green">
				<span>' . __( ' 0 Coupons added.', 'wp-coupons-and-deals' ) . '</span>
				<a href="' . admin_url( 'edit.php?post_type=wpcd_coupons' ) . '" class="page-title-action">' . __( 'View', 'wp-coupons-and-deals' ) . '</a>
			</div>
		</section>
	</div>';
	}

}
