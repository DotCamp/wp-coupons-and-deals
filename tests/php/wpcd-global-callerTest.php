<?php

use PHPUnit\Framework\TestCase;

function globalTestFunctionSingleArgument( string $message ) {
	return "$message";
}

function globalTestFunctionMultipleArgument( string $message, string $other_message ) {
	return "$message $other_message";
}

class WPCD_Global_CallerTest extends TestCase {

	public $expected_val = 'test';
	public $temp_caller;

	public function setUp(): void {
		$this->temp_caller = new WPCD_Global_Caller();
	}

	public function testShouldCallGlobal() {

		$this->assertIsObject( $this->temp_caller );
		$returned = $this->temp_caller->globalTestFunctionSingleArgument( $this->expected_val );
		$this->assertSame( $this->expected_val, $returned );
	}

	public function testShouldCallMultipleArguments() {

		$this->assertIsObject( $this->temp_caller );
		$expected = 'rock on';
		$returned = $this->temp_caller->globalTestFunctionMultipleArgument( 'rock', 'on' );
		$this->assertSame( $expected, $returned );
	}

	public function testShouldThrowGlobalError() {
		$this->expectException( WPCD_Global_Error::class );
		$this->temp_caller->not_implemented_global_function();
	}

	public function testShouldGetGlobalVariable() {
		global $test_variable;

		$test_variable = $this->expected_val;
		$returned      = $this->temp_caller->test_variable;
		$this->assertSame( $this->expected_val, $returned );
	}
}
