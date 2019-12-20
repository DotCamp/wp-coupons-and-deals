<?php

class WPCD_Formshortcode_Ajax extends WPCD_Ajax_Base {


	/**
	 * @inheritDoc
	 */
	public function logic() {

		if ( filter_var( $this->_c()->check_ajax_referer( 'wpcd_shortcode_form', 'nonce', false ),
			FILTER_VALIDATE_BOOLEAN ) ) {
			if ( isset( $_POST['ID'] ) ) {
				$this->update_coupon();
			} else {
				$this->insert_coupon();
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

	private function update_coupon() {
		$ID = $_POST['ID'];

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
					$rule = 'esc_url';
				}
				if ( $key === 'wpcd_description' ) {
					$rule = 'wp_kses_post';
				}
				$rules[ $key ] = $rule;
			}
			$sanitized_fields = WPCD_Sanitizer::sanitize( $data, $rules );

			$meta_input = $this->batchMetaInput( 'coupon_details_', $sanitized_fields );

			// inserting new post based on submitted form fields
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
				if ( isset( $_POST['new_terms'] ) ) {
					$new_terms = json_decode( stripslashes( $_POST['new_terms'] ), true );

					foreach ( $new_terms as $tax_name => $tax_array ) {
						foreach ( $tax_array as $term ) {
							$this->_c()->wp_insert_term( $term['name'], $tax_name, [ 'parent' => $term[ parent ] ] );
						}
					}
				}

//				// taxonomy input
				$tax_input = isset( $_POST['terms'] ) ? $_POST['terms'] : [];
				foreach ( $tax_input as $tax_name => $term ) {
					$this->_c()->wp_set_object_terms( $operation_result, $term, $tax_name );
				}

				$this->setData( 'terms', WPCD_Form_Shortcode::getCouponTerms() );


				// image attachment process
				if ( isset( $_POST['coupon-attachment-id'] ) ) {

					$this->_c()->update_post_meta( $operation_result, 'coupon_details_coupon-image-input',
						sanitize_text_field( $_POST['coupon-attachment-id'] ) );
				}

				// featured image process
				if ( isset( $_POST['featured_id'] ) ) {
					$featured_id = sanitize_text_field( $_POST['featured_id'] );
					if ( $featured_id === 'remove' ) {
						delete_post_thumbnail( $operation_result );
					} else {
						$this->_c()->set_post_thumbnail( $operation_result, $featured_id );
					}
				}
			}
		}
	}

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
				$rule = 'esc_url';
			}
			if ( $key === 'wpcd_description' ) {
				$rule = 'wp_kses_post';
			}
			$rules[ $key ] = $rule;
		}
		$sanitized_fields = WPCD_Sanitizer::sanitize( $data, $rules );

		$meta_input = $this->batchMetaInput( 'coupon_details_', $sanitized_fields );

//			$terms = get_terms( WPCD_Plugin::CUSTOM_TAXONOMY, [ 'hide_empty' => false ] );
//			$tax_input = isset( $_POST['terms'] ) ? $_POST['terms'] : [];

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
			if ( isset( $_POST['new_terms'] ) ) {
				$new_terms = json_decode( stripslashes( $_POST['new_terms'] ), true );

				foreach ( $new_terms as $tax_name => $tax_array ) {
					foreach ( $tax_array as $term ) {
						$this->_c()->wp_insert_term( $term['name'], $tax_name, [ 'parent' => $term[ parent ] ] );
					}
				}
			}

			// taxonomy input
			$tax_input = isset( $_POST['terms'] ) ? $_POST['terms'] : [];
			foreach ( $tax_input as $tax_name => $term ) {
				$this->_c()->wp_set_object_terms( $operation_result, $term, $tax_name );
			}

			$this->setData( 'terms', WPCD_Form_Shortcode::getCouponTerms() );

			$this->setData( 'id', $operation_result );
			$this->setData( 'message', __( 'coupon created', WPCD_Plugin::TEXT_DOMAIN ) );


			// image attachment process
			if ( isset( $_POST['coupon-attachment-id'] ) ) {

				$this->_c()->update_post_meta( $operation_result, 'coupon_details_coupon-image-input',
					sanitize_text_field( $_POST['coupon-attachment-id'] ) );
			}

			// featured image process
			if ( isset( $_POST['featured_id'] ) ) {
				$featured_id = sanitize_text_field( $_POST['featured_id'] );
				$this->_c()->set_post_thumbnail( $operation_result, $featured_id );
			}
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
}
