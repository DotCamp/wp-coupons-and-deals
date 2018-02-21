<?php 
$wpcd_coupon_templates = array('Default', 'Template One', 'Template Two', 'Template Three', 'Template Four', 'Template Five', 'Template Six');
?>
<form id="wpcd_import_form" class="wpcd_clearfix" enctype='multipart/form-data' method='post'>
	<p style="font-size: 16px"><?php echo __( 'Here you can import coupons from a CSV file. Select the CSV file you want to import, then click on Next.', 'wpcd-coupon' ); ?></p>
	<p style="font-size: 16px"><?php echo __( 'Alternatively, you can check out ', 'wpcd-coupon' ) . '<a href="http://wpcouponsdeals.com/knowledgebase/import-coupons-csv-file/">' . __( 'this guide', 'wpcd-coupon' ) . '</a>' . __( ' to learn how importing from CSV file works.', 'wpcd-coupon' ); ?>

	<p style="font-size: 16px; font-weight: bold;"><?php echo __( 'Few things to know before importing coupons:' ); ?></p>
	<ul>
	    <li style="font-size: 15px;">1. Default template will be assigned to imported coupons.</li>
	    <li style="font-size: 15px;">2. Coupons will be imported as coupons type.</li>
	</ul>
	<div class="wpcd_import_field">
			<div>
			<label>
				Choose Default template which will be assigned to imported coupons.
			</label>
	    	<select name="wpcd_default_template">
	    		<?php foreach( $wpcd_coupon_templates as $template ): ?>
	        	<option value="<?php echo $template; ?>"><?php echo $template; ?></option>
	        	<?php endforeach; ?>
	        </select>
		</div>
                <div id="wpcd_import_color_parent" style="display:none;">
                    <label>
                        Color Theme: 
                    </label>
                    <div id="wpcd_import_color" class="wpcd_colorSelectors">
                        <div data-color="#18e06e" style="background-color:#18e06e;"></div>
                        <input id="wpcd_import_color" name="theme_color" type="hidden" value="#18e06e"/>
                    </div>
                </div>

		<div>
	    	<input type="file" name='wpcd_import_file' required/>
		</div>
		<div>
	    	<input type='submit' name='wpcd_import_submit' value='Next'
	           class="button button-primary button-large"/>
	    </div>
	</div>
	<?php if( isset( $_POST['wpcd_import_submit'] ) ) : ?>
	<p style="font-size: 16px; color: red"><?php echo __( 'File type not allowed.', 'wpcd-coupon' ); ?></p>
	<?php endif; ?>
	<p style="font-size: 16px;"><?php echo __( 'Only CSV files are allowed.', 'wpcd-coupon' ); ?></p>
	<div class="wpcd_import_form_loader wpcd_loader" style="display:none"></div>
</form>