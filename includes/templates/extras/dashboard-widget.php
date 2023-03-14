<?php

$post_type      = 'wpcd_coupons';
$num_posts      = wp_count_posts( 'wpcd_coupons' );
$published      = number_format_i18n( $num_posts->publish );
$draft          = number_format_i18n( $num_posts->draft );
$pending        = number_format_i18n( $num_posts->pending );
$trash          = number_format_i18n( $num_posts->trash );
$category_count = wp_count_terms( 'wpcd_coupon_category' );
$vendor_count   = wp_count_terms( 'wpcd_coupon_vendor' );

$install_ub_url = \wp_nonce_url(
	\self_admin_url( 'update.php?action=install-plugin&plugin=ultimate-blocks' ),
	'install-plugin_ultimate-blocks'
);

$install_wptb_url = \wp_nonce_url(
	\self_admin_url( 'update.php?action=install-plugin&plugin=wp-table-builder' ),
	'install-plugin_wp-table-builder'
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
            	<td style="border-top: 0;"><?php echo __( 'Published', 'wp-coupons-and-deals' ); ?></td>
            	<td style="border-top: 0;">
                	<?php echo absint( $published ); ?>
            	</td>
        	</tr>
        	<tr>
            	<td><?php echo __( 'Drafts', 'wp-coupons-and-deals' ); ?></td>
            	<td>
                	<?php echo absint( $draft ); ?>
            	</td>
        	</tr>
        	<tr>
            	<td><?php echo __( 'Trash', 'wp-coupons-and-deals' ); ?></td>
            	<td>
                	<?php echo absint( $trash ); ?>
            	</td>
        	</tr>
			<tr>
				<td><?php echo __( 'Categories', 'wp-coupons-and-deals' ); ?></td>
				<td><?php echo absint( $category_count ); ?></td>
			</tr>
			<tr>
				<td><?php echo __( 'Vendors', 'wp-coupons-and-deals' ); ?></td>
				<td><?php echo absint( $vendor_count ); ?></td>
			</tr>
    	</tbody>
	</table>
</div>

<div style="margin: 0px -12px 0; padding: 12px 12px 0; border-top: 1px solid #eee;">
	<p style="margin: 0">
		<?php echo __( 'Using WP Coupons and Deals version ', 'wp-coupons-and-deals' ) . '<strong>' .WPCD_Plugin::PLUGIN_VERSION . '</strong>'; ?>
		(<a href="https://wordpress.org/plugins/wp-coupons-and-deals/#developers" target="_blank">
			<?php echo __( 'Changelog', 'wp-coupons-and-deals'); ?>
		</a>)
	</p>
</div>

<?php

if ( current_user_can( "manage_options" ) ) {
	if ( !in_array( 'ultimate-blocks/ultimate-blocks.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
	<div style="margin: 12px -12px 0; padding: 12px 12px 0; border-top: 1px solid #eee;">
			<p style="margin: 0"><?php echo __( 'Recommended Plugin: ', 'wp-coupons-and-deals' );?><b><?php echo __( 'Ultimate Blocks', 'wp-coupons-and-deals' ); ?></b> -
				<a href="<?php echo esc_url( $install_ub_url ); ?>"><?php echo __( 'Install', 'wp-coupons-and-deals' ); ?></a> |
				<a href="https://ultimateblocks.com/?utm_source=wpdashboard&utm_medium=widget" target="_blank"><?php echo __( 'Learn More', 'wp-coupons-and-deals' ); ?></a></p>
	</div>
	<?php
	}
}

if ( current_user_can( "manage_options" ) ) {
	if ( !in_array( 'wp-table-builder/wp-table-builder.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
	<div style="margin: 12px -12px 0; padding: 12px 12px 0; border-top: 1px solid #eee;">
			<p style="margin: 0"><?php echo __( 'Recommended Plugin: ', 'wp-coupons-and-deals' );?><b><?php echo __( 'WP Table Builder', 'wp-coupons-and-deals' ); ?></b> -
				<a href="<?php echo esc_url( $install_ub_url ); ?>"><?php echo __( 'Install', 'wp-coupons-and-deals' ); ?></a> |
				<a href="https://wptablebuilder.com/?utm_source=wpdashboard&utm_medium=widget" target="_blank"><?php echo __( 'Learn More', 'wp-coupons-and-deals' ); ?></a></p>
	</div>
	<?php
	}
}