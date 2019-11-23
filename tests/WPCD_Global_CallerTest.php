<?php


use PHPUnit\Framework\TestCase;

require __DIR__ . '/../includes/classes/wpcd-global-caller.php';

function globalTestFunctionSingleArgument( string $message ) {
	return "$message";
}

function globalTestFunctionMultipleArgument( string $message, string $other_message ) {
	return "$message $other_message";
}

class WPCD_Global_CallerTest extends TestCase {

	public $expected_val = 'test';

	public function testShouldCallGlobal() {
		$temp_caller = new WPCD_Global_Caller();

		$this->assertIsObject( $temp_caller );
		$returned = $temp_caller->globalTestFunctionSingleArgument( $this->expected_val );

		$this->assertSame( $this->expected_val, $returned );
	}

	public function testShouldCallMultipleArguments() {
		$temp_caller = new WPCD_Global_Caller();

		$this->assertIsObject( $temp_caller );
		$expected = 'rock on';
		$returned = $temp_caller->globalTestFunctionMultipleArgument( 'rock', 'on' );
		$this->assertSame( $expected, $returned );
	}


	// TODO [task-001][erdembircan] implement correct test for global error object after its initial tests
	public function testShouldThrowGlobalError() {
		$temp_caller = new WPCD_Global_Caller();

		$this->markTestIncomplete( 'not implemented yet' );
	}

	public function testShouldGetGlobalVariable() {
		global $test_variable;

		$test_variable = $this->expected_val;

		$temp_caller = new WPCD_Global_Caller();
		$returned    = $temp_caller->test_variable;

		$this->assertSame($this->expected_val, $returned );
	}
}
