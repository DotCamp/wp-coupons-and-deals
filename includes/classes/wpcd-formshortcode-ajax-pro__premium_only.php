<?php

class WPCD_Formshortcode_Ajax_Pro extends WPCD_Ajax_Base {


	/**
	 * @inheritDoc
	 */
	public function logic() {

		if ( filter_var( $this->_c()->check_ajax_referer( 'wpcd_shortcode_form', 'nonce', false ),
			FILTER_VALIDATE_BOOLEAN ) ) {
			if ( ! $this->checkAllowedTemplates( $_POST['coupon-template'] ) ) {
				$this->setError(
					__( 'You are not authorized to use this template',
						WPCD_Plugin::TEXT_DOMAIN ) );

			} else {
				if ( isset( $_POST['new_term'] ) ) {
					$this->create_term();
				} elseif ( isset( $_POST['ID'] ) ) {
					$this->update_coupon();
				} else {
					$this->insert_coupon();
				}
			}
		} else {
			// nonce error response
			$this->setError(
				__( 'You are not authorized to submit forms, refresh page and try again',
					WPCD_Plugin::TEXT_DOMAIN ) );
		}

		$this->getResponseJSON( true );

		die();
	}

	/**
	 * batch add/update post taxonomies
	 *
	 * @param int $post_id post id
	 * @param string $post_field $_POST field name to check for terms
	 */
	private function insertTerms( $post_id, $post_field ) {
		$tax_input = isset( $_POST[ $post_field ] ) ? $_POST[ $post_field ] : [];
		foreach ( $tax_input as $tax_name => $term ) {
			$term = array_map( 'intval', $term );

			wp_set_object_terms( $post_id, $term, $tax_name );
		}
	}

	/**
	 * check setting gated default template against sent post field
	 *
	 * @param string $postedTemplate template name to be checked agains
	 *
	 * @return bool true for allowed
	 */
	private function checkAllowedTemplates( $postedTemplate ) {
		$allowed_template = get_option( 'wpcd_form-shortcode-default-template', 'all' );
		if ( $allowed_template === 'all' ) {
			return true;
		} else {
			return $postedTemplate === $allowed_template;
		}
	}

	/**
	 * update a coupon
	 */
	private function update_coupon() {
		$ID = filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);

		$coupon_author  = $this->_c()->get_post( $ID )->post_author;
		$current_author = $this->_c()->wp_get_current_user()->ID;

		if ( $coupon_author != $current_author ) {
			$this->setError(
				__( 'You are not authorized to submit forms, refresh page and try again',
					WPCD_Plugin::TEXT_DOMAIN ) );
		} else {
			$data = $_POST;

			$original_fields = WPCD_Meta_Boxes_Fields_Pro__Premium_Only::getFields();

			// adding 'coupon-title' since it is not included in original fields
			$original_fields[] = [ 'id' => 'coupon-title' ];

			$rules = [];
			foreach ( $original_fields as $field ) {
				$key  = $field['id'];
				$rule = 'sanitize_text_field';
				if ( strpos( $key, 'link' ) !== false ) {
					$rule = 'esc_url_raw';
				}
				if ( $key === 'wpcd_description' ) {
					$rule = 'wp_kses_post';
				}
				$rules[ $key ] = $rule;
			}
			$sanitized_fields = WPCD_Sanitizer::sanitize( $data, $rules );

			$meta_input = $this->batchMetaInput( 'coupon_details_', $sanitized_fields );

			// updating post based on submitted form fields
			$operation_result = $this->_c()->wp_update_post( [
				'ID'         => $ID,
				'post_title' => $sanitized_fields['coupon-title'],
				'meta_input' => $meta_input,
			] );


			if ( $this->_c()->is_wp_error( $operation_result ) ) {
				$this->setError( $operation_result->get_error_message() );
			} else {
				$this->setData( 'id', $operation_result );
				$this->setData( 'message', __( 'coupon updated', WPCD_Plugin::TEXT_DOMAIN ) );

				// taxonomy input
				$this->insertTerms( $operation_result, 'terms' );
				$this->setData( 'terms', WPCD_Form_Shortcode_Pro::getCouponTerms() );

				// image attachment process
				$this->image_attachment_process( $operation_result );

				// featured image process
				$this->featured_image_process( $operation_result );
			}
		}
	}

	/**
	 * create and insert a new coupon
	 */
	private function insert_coupon() {
		$data = $_POST;

		$original_fields = WPCD_Meta_Boxes_Fields_Pro__Premium_Only::getFields();

		// adding 'coupon-title' since it is not included in original fields
		$original_fields[] = [ 'id' => 'coupon-title' ];

		$rules = [];
		foreach ( $original_fields as $field ) {
			$key  = $field['id'];
			$rule = 'sanitize_text_field';
			if ( strpos( $key, 'link' ) !== false ) {
				$rule = 'esc_url_raw';
			}
			if ( $key === 'wpcd_description' ) {
				$rule = 'wp_kses_post';
			}
			$rules[ $key ] = $rule;
		}
		$sanitized_fields = WPCD_Sanitizer::sanitize( $data, $rules );

		$meta_input = $this->batchMetaInput( 'coupon_details_', $sanitized_fields );

		$post_status = get_option( 'wpcd_form-shortcode-coupon-status', 'publish' );

		// inserting new post based on submitted form fields
		$operation_result = $this->_c()->wp_insert_post( [
			'post_title'  => $sanitized_fields['coupon-title'],
			'post_type'   => WPCD_Plugin::CUSTOM_POST_TYPE,
			'post_status' => $post_status,
			'meta_input'  => $meta_input,
		] );

		if ( $this->_c()->is_wp_error( $operation_result ) ) {
			$this->setError( $operation_result->get_error_message() );
		} else {

			//taxonomy input
			$this->insertTerms( $operation_result, 'terms' );
			$this->setData( 'terms', WPCD_Form_Shortcode_Pro::getCouponTerms() );

			$this->setData( 'id', $operation_result );
			$this->setData( 'message', __( 'coupon created', WPCD_Plugin::TEXT_DOMAIN ) );


			// image attachment process
			$this->image_attachment_process( $operation_result );

			// featured image process
			$this->featured_image_process( $operation_result );
		}
	}

	/**
	 * transform input array to be compatible for meta values of post
	 *
	 * @param string $suffix suffix
	 * @param array $meta_array array of meta values
	 *
	 * @return array handled array
	 */
	private function batchMetaInput( $suffix, $meta_array ) {
		$temp_array = [];

		foreach ( $meta_array as $key => $value ) {
			$final_key = "$suffix$key";
			if ( $key === 'wpcd_description' ) {
				$final_key = $suffix . "description";
			}
			$temp_array[ $final_key ] = $value;
		}

		return $temp_array;
	}

	/**
	 * create new terms
	 */
	private function create_term() {
		if ( isset( $_POST['new_term'] ) && get_option( 'wpcd_form-shortcode-enable-new-terms', '' ) === 'on' ) {
			$new_term = json_decode( stripslashes( $_POST['new_term'] ), true );

			foreach ( $new_term as $tax_name => $tax ) {
				wp_insert_term( $tax['name'], $tax_name, [ 'parent' => $tax['parent'] ] );
			}

			$this->setData( 'terms', WPCD_Form_Shortcode_Pro::getCouponTerms() );
		}
	}

	/**
	 * featured image process
	 *
	 * @param int $id post id
	 */
	private function featured_image_process( $id ) {
		if ( isset( $_POST['featured_id'] ) ) {
			$featured_id = sanitize_text_field( $_POST['featured_id'] );
			if ( $featured_id === 'remove' ) {
				delete_post_thumbnail( $id );
			} else {
				$this->_c()->set_post_thumbnail( $id, $featured_id );
			}
		}
	}

	/**
	 * image attachment process
	 *
	 * @param int $id post id
	 */
	private function image_attachment_process( $id ) {
		if ( isset( $_POST['coupon-attachment-id'] ) ) {
			$this->_c()->update_post_meta( $id, 'coupon_details_coupon-image-input',
				sanitize_text_field( $_POST['coupon-attachment-id'] ) );
		}

	}
}
