<?php

$post_type      = 'wpcd_coupons';
$num_posts      = wp_count_posts( 'wpcd_coupons' );
$published      = number_format_i18n( $num_posts->publish );
$draft          = number_format_i18n( $num_posts->draft );
$pending        = number_format_i18n( $num_posts->pending );
$trash          = number_format_i18n( $num_posts->trash );
$category_count = wp_count_terms( 'wpcd_coupon_category' );
$vendor_count   = wp_count_terms( 'wpcd_coupon_vendor' );

if ( current_user_can( 'edit_posts' ) ) {
    $published      = "<a href=" . esc_url( admin_url( 'edit.php?post_status=publish&post_type=wpcd_coupons' ) ) . ">$published</a>";
    $draft          = "<a href=" . esc_url( admin_url( 'edit.php?post_status=draft&post_type=wpcd_coupons' ) ) . ">$draft</a>";
    $trash          = "<a href=" . esc_url( admin_url( 'edit.php?post_status=trash&post_type=wpcd_coupons' ) ) . ">$trash</a>";
    $category_count = "<a href=" . esc_url( admin_url( 'edit-tags.php?taxonomy=wpcd_coupon_category&post_type=wpcd_coupons' ) ) . ">$category_count</a>";
    $vendor_count   = "<a href=" . esc_url( admin_url( 'edit-tags.php?taxonomy=wpcd_coupon_vendor&post_type=wpcd_coupons' ) ) . ">$vendor_count</a>";
}

$install_ub_url = \wp_nonce_url(
	\self_admin_url( 'update.php?action=install-plugin&plugin=ultimate-blocks' ),
	'install-plugin_ultimate-blocks'
);

?>
<style>

.wpcd-dashboard-widget table {
	width: calc(100% + 24px);
    margin: 0 -12px;
}

.wpcd-dashboard-widget table td {
    padding: 10px 12px;
    background-color: #fafafa;
    border-top: 1px solid #eee;
}

.wpcd-dashboard-widget table td:not(:first-child) {
    text-align: right;
}

</style>

<div style="margin-top: -12px;" class="wpcd-dashboard-widget">
	<table cellspacing="0">
    	<tbody>
        	<tr>
            	<td style="border-top: 0;"><?php echo __( 'Published', 'wpcd-coupon' ); ?></td>
            	<td style="border-top: 0;">
                	<?php echo $published; ?>
            	</td>
        	</tr>
        	<tr>
            	<td><?php echo __( 'Drafts', 'wpcd-coupon' ); ?></td>
            	<td>
                	<?php echo $draft; ?>
            	</td>
        	</tr>
        	<tr>
            	<td><?php echo __( 'Trash', 'wpcd-coupon' ); ?></td>
            	<td>
                	<?php echo $trash; ?>
            	</td>
        	</tr>
			<tr>
				<td><?php echo __( 'Categories', 'wpcd-coupon' ); ?></td>
				<td><?php echo $category_count; ?></td>
			</tr>
			<tr>
				<td><?php echo __( 'Vendors', 'wpcd-coupon' ); ?></td>
				<td><?php echo $vendor_count; ?></td>
			</tr>
    	</tbody>
	</table>
</div>

<div style="margin: 0px -12px 0; padding: 12px 12px 0; border-top: 1px solid #eee;">
	<p style="margin: 0">
		<?php echo __( 'Using WP Coupons and Deals version ', 'wpcd-coupon' ) . '<strong>' .WPCD_Plugin::PLUGIN_VERSION . '</strong>'; ?>
		(<a href="https://wpcouponsdeals.com/changelog/" target="_blank">
			<?php echo __( 'Changelog', 'wpcd-coupon'); ?>
		</a>)
	</p>
</div>

<?php

if ( current_user_can( "manage_options" ) ) {
	if ( !in_array( 'ultimate-blocks/ultimate-blocks.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
	<div style="margin: 12px -12px 0; padding: 12px 12px 0; border-top: 1px solid #eee;">
			<p style="margin: 0"><?php echo __( 'Recommended Plugin: ', 'wpcd-coupon' );?><b><?php echo __( 'Ultimate Blocks', 'wpcd-coupon' ); ?></b> -
				<a href="<?php echo \esc_url( $install_ub_url ); ?>"><?php echo __( 'Install', 'wpcd-coupon' ); ?></a> |
				<a href="https://ultimateblocks.com/?utm_source=wpdashboard&utm_medium=widget" target="_blank"><?php echo __( 'Learn More', 'wpcd-coupon' ); ?></a></p>
	</div>
	<?php
	}
}
