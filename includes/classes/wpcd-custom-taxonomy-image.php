<?php
// If accessed directly, exit
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPCD Custom Taxonomy
 * This class is used to register a new taxonomy.
 *
 * @since 2.3
 * @author Aqib Rashid
 */
class WPCD_Custom_Taxonomy_Image {

	/**
	 * this function registers hooks for upload image field
	 *
	 * @since 2.3
	 */
	public static function register( $taxonomy ) {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'load_wp_media_library' ) );
		//register field
		add_action( $taxonomy . '_edit_form_fields', array( __CLASS__, 'show_image_field' ), 10, 2 );
		//save field
		add_action( 'edited_' . $taxonomy, array( __CLASS__, 'save_image_field' ), 10, 2 );
	}

	/**
	 * this function creates upload field for image
	 *
	 * @since 2.3
	 */
	public static function load_wp_media_library() {
		wp_enqueue_media();
	}

	/**
	 * this function checks if jQuery exits to added it
	 *
	 * @since 2.3
	 */
	public static function show_image_field( $tag ) {
		$t_id      = $tag->term_id; // Get the ID of the term you're editing  
		$term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check

		// Get the image src
		$your_img_src = wp_get_attachment_image_src( $term_meta['image_id'], 'full' );

		// For convenience, see if the array is valid
		$you_have_img = is_array( $your_img_src );
		?>

        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="image_id"><?php _e( 'Image', 'wpcd-coupon' ); ?></label>
            </th>
            <td>
                <input type="hidden" class="custom-img-id" name="term_meta[image_id]" id="term_meta[image_id]" size="25"
                       style="width:60%;"
                       value="<?php echo $term_meta['image_id'] ? $term_meta['image_id'] : ''; ?>"><br/>
                <!-- Your image container -->
                <div class="custom-img-container" style="width:250px;">
					<?php if ( $you_have_img ) : ?>
                        <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:100%;"/>
					<?php endif; ?>
                </div>
                <!-- Your add & remove image links -->
                <p class="hide-if-no-js">
                    <a class="upload-custom-img button <?php if ( $you_have_img ) {
						echo 'hidden';
					} ?>">
						<?php _e( 'Upload image' ) ?>
                    </a>
                    <a style="color:red" class="delete-custom-img button <?php if ( ! $you_have_img ) {
						echo 'hidden';
					} ?>"
                       href="#">
						<?php _e( 'Remove this image' ) ?>
                    </a>
                </p>
                <span class="description"><?php _e( 'The uploaded image will show up in all the coupons archive/category shortcodes with empty featured images.' ); ?></span>
            </td>
        </tr>

        <script>
            jQuery(function ($) {
                // Set all variables to be used in scope
                var frame,
                    metaBox = $('#edittag'), // Your meta box id here
                    addImgLink = metaBox.find('.upload-custom-img'),
                    delImgLink = metaBox.find('.delete-custom-img'),
                    imgContainer = metaBox.find('.custom-img-container'),
                    imgIdInput = metaBox.find('.custom-img-id');

                // ADD IMAGE LINK
                addImgLink.on('click', function (event) {

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if (frame) {
                        frame.open();
                        return;
                    }

                    // Create a new media frame
                    frame = wp.media({
                        title: 'Select or Upload Media for Your Coupon Category',
                        button: {
                            text: 'Use this media'
                        },
                        multiple: false  // Set to true to allow multiple files to be selected
                    });


                    // When an image is selected in the media frame...
                    frame.on('select', function () {

                        // Get media attachment details from the frame state
                        var attachment = frame.state().get('selection').first().toJSON();

                        // Send the attachment URL to our custom image input field.
                        imgContainer.append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');

                        // Send the attachment id to our hidden input
                        imgIdInput.val(attachment.id);

                        // Hide the add image link
                        addImgLink.addClass('hidden');

                        // Unhide the remove image link
                        delImgLink.removeClass('hidden');
                    });

                    // Finally, open the modal on click
                    frame.open();
                });


                // DELETE IMAGE LINK
                delImgLink.on('click', function (event) {

                    event.preventDefault();

                    // Clear out the preview image
                    imgContainer.html('');

                    // Un-hide the add image link
                    addImgLink.removeClass('hidden');

                    // Hide the delete image link
                    delImgLink.addClass('hidden');

                    // Delete the image id from the hidden input
                    imgIdInput.val('');

                });

            });
        </script>

		<?php
	}

	/**
	 * this function saves term image id
	 *
	 * @since 2.3
	 */
	public static function save_image_field( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id      = $term_id;
			$term_meta = get_option( "taxonomy_term_$t_id" );
			$cat_keys  = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset( $_POST['term_meta'][ $key ] ) ) {
					$term_meta[ $key ] = $_POST['term_meta'][ $key ];
				}
			}
			//save the option array  
			update_option( "taxonomy_term_$t_id", $term_meta );
		}
	}
}