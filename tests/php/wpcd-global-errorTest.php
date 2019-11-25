<?php

use PHPUnit\Framework\TestCase;

class WPCD_Global_ErrorTest extends TestCase {

	function testShouldExtendBadMethodCallException() {
		$temp_error = new WPCD_Global_Error( 'test' );
		$this->assertInstanceOf( 'BadMethodCallException', $temp_error );
	}
}