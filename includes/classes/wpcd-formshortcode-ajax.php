<?php
class WPCD_Formshortcode_Ajax extends WPCD_Ajax_Base {


	/**
	 * @inheritDoc
	 */
	public function logic() {
		$response_json = ['message'=>'request received'];

		echo json_encode($response_json);

		die();
	}
}
