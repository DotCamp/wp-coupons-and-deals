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

// $wpcd_coupon_templates = array('Template One', 'Template Two', 'Template Three', 'Template Four', 'Template Five', 'Template Six', 'Template Seven', 'Template Eight');

?>

<div class="wrap">
    <h2><?php echo __( 'Import Coupons from CSV or XML File', 'wpcd-coupon' ); ?></h2>
    <section id="wpcd_import_form_wr">
		<?php
			include('import-form__premium_only.php');
		?>
		<!-- Wrapper set to display none -->
		<div class="wpcd-import-wrapper">
			<p><?php echo __( 'This is just a preview of the file you uploaded. All data are not showing here.', 'wpcd-coupon'); ?></p>
			<!-- Table -->
			<div class="wpcd_preview_table_support">
				<div id="wpcd-table-csv">
					<!-- Table data here from js -->
				</div>
			</div>
			<div class="wpcd_choose_fields_wr wpcd_import_white_box wpcd_clearfix">
				<h5><?php echo __( 'Select Import Fields', 'wpcd-coupon' ); ?></h5>
				<form id="wpcd_import_form_final" class="wpcd_clearfix" enctype="multipart/form-data" method="post">
					<div class="wpcd_import_field_inner_wr wpcd_clearfix">
						
						<div class="wpcd_import_field">
							<div class="wpcd_import_field wpcd_import_field_submit wpcd_clearfix">
							<input type="hidden" name="wpcd_import_counter_field" value="' . $name_var . '" />
							<input type="file" style="display:none;" name="wpcd_import_file_final" value="<?=filter_var($_FILES['wpcd_import_file']['tmp_name'], FILTER_SANITIZE_STRING)?>" />
							<input type="hidden" name="wpcd_default_template" value="<?=filter_var($_POST['wpcd_default_template'], FILTER_SANITIZE_STRING)?>">
							<input type="hidden" name="theme_color" value="<?=sanitize_hex_color($_POST['theme_color'])?>">
							<?php wp_nonce_field( 'wpcd_nonce' ); ?>
							<input name="wpcd_import_submit_final" value="Import Coupons" class="button button-primary button-large wpcd-import-btn" type="submit">
							<span><strong>0</strong> <?php echo __( 'Coupons will be added!', 'wpcd-coupon' ); ?></span>
							<p style="display:none; color: red; font-size: 16px; margin-top: 20px;" id="wpcd_import_field_error"><?php echo __( 'Error: You must select a field for Coupon Title.', 'wpcd-coupon' ); ?></p>
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
			<span>
				<?php echo __( ' 0 Coupons added.', 'wpcd-coupon' ); ?>
			</span>
			<?php echo '<a href="' . admin_url( 'edit.php?post_type=wpcd_coupons' ) . '" class="page-title-action">' . __( 'View', 'wpcd-coupon' ); ?></a>
		</div>
	</section>
</div>