<?php

class WPCD_Formshortcode_Ajax extends WPCD_Ajax_Base {


	/**
	 * @inheritDoc
	 */
	public function logic() {
		// TODO [task-001][erdembircan] implement full post fields

		$response = [];
		if ( filter_var( $this->_c()->check_ajax_referer( 'wpcd_shortcode_form', 'nonce', false ),
			FILTER_VALIDATE_BOOLEAN ) ) {
			$data = $_POST['data'];

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
				$rules[ $key ] = $rule;
			}
			$sanitized_fields = WPCD_Sanitizer::sanitize( $data, $rules );

			$meta_input = $this->batchMetaInput( 'coupon_details_', $sanitized_fields );

			// inserting new post based on submitted form fields
			$operation_result = $this->_c()->wp_insert_post( [
				'post_title'  => $sanitized_fields['coupon-title'],
				'post_type'   => WPCD_Plugin::CUSTOM_POST_TYPE,
				'post_status' => 'publish',
				'meta_input'  => $meta_input
			] );

			if ( $this->_c()->is_wp_error( $operation_result ) ) {
				$response['error'] = $operation_result->get_error_message();
			} else {
				$test_meta = get_post_meta(1165);

				$response['data'] = [ 'id' => $operation_result];
			}

		} else {
			// nonce error response
			$response['error'] = __( 'You are not authorized to submit forms, refresh page and try again',
				WPCD_Plugin::TEXT_DOMAIN );
		}

		echo json_encode( $response );

		die();
	}

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
