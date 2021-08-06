<?php
// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode inserter class.
 * Adding the functionality to insert shortcode
 * from WordPress post or page editor.
 *
 * @since 1.0
 */
class WPCD_Shortcode_Inserter {

	/**
	 * Adding the button to the editor and
	 * the popup content.
	 *
	 * @since 1.0
	 */
	public static function wpcd_shortcode_insert() {

		/**
		 * This adds the coupon inserter button.
		 *
		 * @since 1.0
		 */
		add_action( 'media_buttons', array( __CLASS__, 'add_coupon_button' ) );

		/**
		 * Adding the coupon inserter popup when button is clicked.
		 *
		 * @since 1.0
		 */
		add_action( 'admin_footer', array( __CLASS__, 'add_coupon_inline_popup' ), 20 );
	}

	/*
	 * Add Coupon Inserter Button Above WordPress Editor
	 *
	 * @since 1.0
	 */

	public static function add_coupon_button() {

		do_action( 'wpcd_add_button' );

	}

	/*
	 * Coupon Inserter Popup Coding and Script.
	 *
	 * @version 1.00
	 */

	public static function add_coupon_inline_popup() {
		?>

        <div id="wpcd_coupon_container" style="display:none;">

			<?php
			/**
			 * Arguments for the loop to get the coupon list.
			 *
			 * @since 1.0
			 */
			$coupon_args = array(
				'post_type'      => 'wpcd_coupons',
				'posts_per_page' => '-1',
				'post_status'    => 'publish'
			);

			/**
			 * Coupon loop.
			 *
			 * @since 1.0
			 */
			$wpcd_coupon_query = new WP_Query( $coupon_args );

			if ( $wpcd_coupon_query->have_posts() ) {
			?>
            <div class="wpcd_shortcode_insert">
                <div class="wpcd_shortcode_insert-row">

					<?php if ( wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code() ) { //premium version ?>
                        <div class="shortcode_inserter_select wpcd_types_select">
                            <label for="coupons_shortcode_type">
								<?php echo __( 'Select Shortcode Type', 'wp-coupons-and-deals' ); ?>
                            </label>
                            <select name="shortcode_type_box" id="coupons_shortcode_type">
                                <option value="single" selected="selected"><?php echo __( 'Single Coupon', 'wp-coupons-and-deals' ); ?></option>
                                <option value="archive"><?php echo __( 'Archive', 'wp-coupons-and-deals' ); ?></option>
                                <option value="category"><?php echo __( 'Category', 'wp-coupons-and-deals' ); ?></option>
                                <option value="vendor"><?php echo __( 'Vendor', 'wp-coupons-and-deals' ); ?></option>
                            </select>
                        </div>
                        <!-- Start Archive -->
                        <div class="shortcode_inserter_select wpcd_coupon_count">
                            <label for="coupons_coupon_count">
								<?php echo __( 'Number of Coupon Display', 'wp-coupons-and-deals' ); ?>
                            </label>
                            <input id="wpcd_coupon_count" type="number" min="1" value="9"/>
                        </div>
                        <div class="shortcode_inserter_select wpcd_style_select">
                            <label for="coupons_style_select">
								<?php echo __( 'Select Style Type', 'wp-coupons-and-deals' ); ?>
                            </label>
                            <select name="shortcode_style_box" id="coupons_style_select">
                                <option value="vertical"><?php echo __( 'Vertical', 'wp-coupons-and-deals' ); ?></option>
                                <option value="horizontal"
                                        selected="selected"><?php echo __( 'Horizontal', 'wp-coupons-and-deals' ); ?></option>
                            </select>
                        </div>
                        <div class="shortcode_inserter_select wpcd_template_select">
                            <label for="coupons_template_select">
								<?php echo __( 'Select Template', 'wp-coupons-and-deals' ); ?>
                            </label>
                            <select name="shortcode_template_box" id="coupons_template_select">
                                <option value="default"
                                        selected="selected"><?php echo __( 'Default', 'wp-coupons-and-deals' ); ?></option>
                                <option value="one"><?php echo __( 'Template one', 'wp-coupons-and-deals' ); ?></option>
                                <option value="two"><?php echo __( 'Template two', 'wp-coupons-and-deals' ); ?></option>
                                <option value="three"><?php echo __( 'Template three', 'wp-coupons-and-deals' ); ?></option>
                            </select>
                        </div>
                        <!-- End Archive -->

					<?php } else { ?>
                        <!-- choose the type (free version) -->
                        <div class="shortcode_inserter_select wpcd_types_select">
                            <label for="coupons_shortcode_type">
								<?php echo __( 'Select Shortcode Type', 'wp-coupons-and-deals' ); ?>
                            </label>
                            <select name="shortcode_type_box" id="coupons_shortcode_type" disabled="disabled">
                                <option value="single"
                                        selected="selected"><?php echo __( 'Single Coupon', 'wp-coupons-and-deals' ); ?></option>
                            </select>
                        </div>

					<?php } ?>
                    <!-- Start Category -->
                    <div class="shortcode_inserter_select wpcd_categories_select">
                        <label for="coupon_type">
							<?php echo __( 'Select The Category', 'wp-coupons-and-deals' ); ?>
                        </label>
                        <input autocomplete="off" type="text" id="coupon_type" list="coupon_typelist"
                               placeholder="<?php echo __( 'Search the category', 'wp-coupons-and-deals' ); ?>">
                        <datalist name="coupon_select_type" id="coupon_typelist">
							<?php
							$terms = get_terms( 'wpcd_coupon_category' );
							foreach ( $terms as $term ) {
								$term = (array) $term;
								echo '<option category_id="' . esc_attr( $term['term_id'] ) . '" value="' . esc_attr( $term['name'] ) . '"></option>';
							}
							?>
                        </datalist>
                    </div>
                    <div class="shortcode_inserter_select wpcd_style_category_select">
                        <label for="coupons_style_category_select">
							<?php echo __( 'Select Style Type', 'wp-coupons-and-deals' ); ?>
                        </label>
                        <select name="shortcode_style_box" id="coupons_style_category_select">
                            <option value="vertical"><?php echo __( 'Vertical', 'wp-coupons-and-deals' ); ?></option>
                            <option value="horizontal"
                                    selected="selected"><?php echo __( 'Horizontal', 'wp-coupons-and-deals' ); ?></option>
                        </select>
                    </div>

                    <div class="shortcode_inserter_select wpcd_template_category_select">
                        <label for="coupons_template_category_select">
							<?php echo __( 'Select Template', 'wp-coupons-and-deals' ); ?>
                        </label>
                        <select name="shortcode_template_box" id="coupons_template_category_select">
                            <option value="default"
                                    selected="selected"><?php echo __( 'Default', 'wp-coupons-and-deals' ); ?></option>
                            <option value="one"><?php echo __( 'Template one', 'wp-coupons-and-deals' ); ?></option>
                            <option value="two"><?php echo __( 'Template two', 'wp-coupons-and-deals' ); ?></option>
                            <option value="three"><?php echo __( 'Template three', 'wp-coupons-and-deals' ); ?></option>
                        </select>
                    </div>
                    <!-- End Category -->

                    <!-- Start Vendor -->
                    <div class="shortcode_inserter_select wpcd_vendors_select">
                        <label for="coupon_type">
							<?php echo __( 'Select The Vendor', 'wp-coupons-and-deals' ); ?>
                        </label>
                        <input autocomplete="off" type="text" id="coupon_type_vendor" list="coupon_typelist_vendor"
                               placeholder="<?php echo __( 'Search the vendor', 'wp-coupons-and-deals' ); ?>">
                        <datalist name="coupon_select_type" id="coupon_typelist_vendor">
							<?php
							$terms = get_terms( 'wpcd_coupon_vendor' );
							foreach ( $terms as $term ) {
								$term = (array) $term;
								echo '<option vendor_id="' . esc_attr( $term['term_id'] ) . '" value="' . esc_attr( $term['name'] ) . '"></option>';
							}
							?>
                        </datalist>
                    </div>
                    <div class="shortcode_inserter_select wpcd_style_vendor_select">
                        <label for="coupons_style_vendor_select">
							<?php echo __( 'Select Style Type', 'wp-coupons-and-deals' ); ?>
                        </label>
                        <select name="shortcode_style_box" id="coupons_style_vendor_select">
                            <option value="vertical"><?php echo __( 'Vertical', 'wp-coupons-and-deals' ); ?></option>
                            <option value="horizontal" selected="selected"><?php echo __( 'Horizontal', 'wp-coupons-and-deals' ); ?></option>
                        </select>
                    </div>

                    <div class="shortcode_inserter_select wpcd_template_vendor_select">
                        <label for="coupons_template_vendor_select">
							<?php echo __( 'Select Template', 'wp-coupons-and-deals' ); ?>
                        </label>
                        <select name="shortcode_template_box" id="coupons_template_vendor_select">
                            <option value="default"
                                    selected="selected"><?php echo __( 'Default', 'wp-coupons-and-deals' ); ?></option>
                            <option value="one"><?php echo __( 'Template one', 'wp-coupons-and-deals' ); ?></option>
                            <option value="two"><?php echo __( 'Template two', 'wp-coupons-and-deals' ); ?></option>
                            <option value="three"><?php echo __( 'Template three', 'wp-coupons-and-deals' ); ?></option>
                        </select>
                    </div>
                    <!-- End Vendor -->

                    <!-- Start Single -->
                    <div class="shortcode_inserter_select wpcd_category_filter_select">
                        <label for="coupon_shortcode_type">
							<?php echo __( 'Select the category', 'wp-coupons-and-deals' ); ?>
                        </label>
                        <input id="select_category_filter" list="list_category_filter"
                               placeholder="<?php echo __( 'Search the Category', 'wp-coupons-and-deals' ); ?>">
                        <datalist name="coupon_select_type" id="list_category_filter">
							<?php
							$terms = get_terms( 'wpcd_coupon_category' );
							foreach ( $terms as $term ) {
								$term = (array) $term;
								echo '<option value="' . esc_attr( $term['name'] ) . '">' . esc_html( $term['name'] ) . '</option>';
							}
							?>
                            <option value="all-categories"><?php echo __( 'All Categories', 'wp-coupons-and-deals' ); ?></option>
                        </datalist>
                    </div>
                    <div class="shortcode_inserter_select wpcd_coupons_select">

                        <label for="coupon_select">
							<?php echo __( 'Select the Coupon you want to insert', 'wp-coupons-and-deals' ); ?>
                        </label>
						<?php
						$terms_name = array();
							?>

                            <input autocomplete="off" id="coupon_select" list="coupon_list"
                                   placeholder="<?php echo __( 'Search the Coupon', 'wp-coupons-and-deals' ); ?>"
                                   name="coupon_select_box">
                            <datalist id="coupon_list" name="coupon_select_box">
								<?php
								foreach ( $terms as $term ) {
									wp_reset_query();

									array_push( $terms_name, $term->name );
									$args = array(
										'post_type' => 'wpcd_coupons',
										'tax_query' => array(
											array(
												'taxonomy' => 'wpcd_coupon_category',
												'field'    => 'slug',
												'terms'    => $term->slug,
											),
										),
									);

									$loop = new WP_Query( $args );
									if ( $loop->have_posts() ) {
										while ( $loop->have_posts() ) : $loop->the_post();
											?>
                                            <option category-title="<?php echo esc_attr( $term->name ); ?>"
                                                    coupon-id="<?php the_ID(); ?>"
                                                    value="<?php the_title(); ?>"><?php the_title(); ?></option>
											<?php
										endwhile;
									}
								}
								//the coupons with no category
								wp_reset_query();
								$args = array(
									'post_type'   => 'wpcd_coupons',
									'post_status' => 'publish'
								);
								$loop = new WP_Query( $args );
								if ( $loop->have_posts() ) {
									while ( $loop->have_posts() ) :
										$loop->the_post();
										?>
                                        <option category-title="all-categories"
                                                coupon-id="<?php the_ID(); ?>"
                                                value="<?php the_title(); ?>"><?php the_title(); ?></option>
										<?php
									endwhile;
								}
								?>
                            </datalist>

                    </div>

                    <div class="shortcode_inserter_select wpcd_type_select">
                        <label for="coupon_shortcode_type">
							<?php echo __( 'Select the Coupon Shortcode Type', 'wp-coupons-and-deals' ); ?>
                        </label>
                        <select name="shortcode_type_box" id="coupon_shortcode_type">
                            <option value="coupon"><?php echo __( 'Full Coupon with Details', 'wp-coupons-and-deals' ); ?></option>
                            <option value="code"><?php echo __( 'Only Coupon Code', 'wp-coupons-and-deals' ); ?></option>
                        </select>
                    </div>
                    <!-- End Single -->

                    <div id="clear"></div>
                </div>

				<?php do_action( 'wpcd_help_info_div' ); ?>
				<?php do_action( 'wpcd_shortcode_insert_button_div' ); ?>

				<?php } else { ?>
                    <h4><?php echo __( 'No Coupons are Published', 'wp-coupons-and-deals' ); ?></h4>
				<?php } ?>
            </div>
        </div>
		<?php
	}

}
