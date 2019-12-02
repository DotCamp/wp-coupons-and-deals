<?php

class WPCD_Formshortcode_Ajax extends WPCD_Ajax_Base {


	/**
	 * @inheritDoc
	 */
	public function logic() {
		// TODO [task-001][erdembircan] implement sanitizer
		// TODO [task-001][erdembircan] implement full post fields

		$response = [];
		$data     = $_POST['data'];

		$operation_result = wp_insert_post( [
			'post_title' => $data['coupon-title'],
			'post_type'  => WPCD_Plugin::CUSTOM_POST_TYPE

		] );

		if ( is_wp_error( $operation_result ) ) {
			$response['error'] = $operation_result->get_error_message();
		} else {
			$response['data'] = [ 'id' => $operation_result ];
		}

		echo json_encode( $response );

		die();
	}
}
