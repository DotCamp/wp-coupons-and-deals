<?php
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
?>

<form id="wpcd_import_form" class="wpcd_clearfix" enctype='multipart/form-data' method='post'>
	<p style="font-size: 16px"><?php echo __( 'Here you can import coupons from a CSV or XML file. Select the file you want to import, then click on Next.', 'wp-coupons-and-deals' ); ?></p>
	<p style="font-size: 16px"><?php echo __( 'Coupons will be imported as \'Coupon\' type.', 'wp-coupons-and-deals' ); ?>
	
	<div class="wpcd_import_field">
		<div>
			<label>
				<?php echo __( 'Choose Default template which will be assigned to imported coupons.', 'wp-coupons-and-deals' ); ?>
			</label>
			<select name="wpcd_default_template">
				<?php foreach ( $wpcd_coupon_templates as $template ): ?>
					<option value="<?php echo esc_attr( $template ); ?>"><?php echo esc_html( $template ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div id="wpcd_import_color_parent" style="display:none;">
			<label>
			   <?php echo __( 'Color Theme:', 'wp-coupons-and-deals' ); ?>
			</label>
			<div id="wpcd_import_color" class="wpcd_colorSelectors">
				<div data-color="#18e06e" style="background-color:#18e06e;"></div>
				<input id="wpcd_import_color" name="theme_color" type="text" value="#18e06e"/>
			</div>
		</div>
		<div>
			<input type="file" name='wpcd_import_file' id="wpcd_import_file" required/>
			
		</div>
		<div>
			<input type="submit" name='wpcd_import_submit' class="button button-primary button-large" id="wpcd_import_next_submit" value="Next" />
			<hr />
		</div>
	</div>
	<?php if ( isset( $_POST['wpcd_import_submit'] ) ) : ?>
		<p style="font-size: 16px; color: red"><?php echo __( 'File type not allowed.', 'wp-coupons-and-deals' ); ?></p>
	<?php endif; ?>
	<p style="font-size: 16px;"><?php echo __( 'Only CSV or XML files are allowed.', 'wp-coupons-and-deals' ); ?></p>
	<div class="wpcd_import_form_loader wpcd_loader" style="display:none"></div>

	<!-- Remove after finish below -->
	
</form>
