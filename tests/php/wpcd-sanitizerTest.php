<?php

use PHPUnit\Framework\TestCase;

class WPCD_SanitizerTest extends TestCase {

	public $mock_class;

	protected function setUp(): void {
		$this->mock_class = $this->getMockBuilder( stdClass::class )->addMethods( [ 'sanitize_test' ] )->getMock();
	}


	public function testShouldSanitizeGivenArray() {

		$source = [ 'fieldOne' => 'field 1 value' ];
		$rules  = [
			'fieldOne' => [ $this->mock_class, 'sanitize_test' ]
		];

		$this->mock_class->expects( $this->once() )->method( 'sanitize_test' )->with( $this->equalTo( $source['fieldOne'] ) );


		$result = WPCD_Sanitizer::sanitize( $source, $rules );
		print_r( $result );
	}

	public function testShouldOnlyReturnedGivenFields() {
		$source = [ 'fieldOne' => 'field 1 value', 'fieldTwo' => 'field 2 value' ];
		$rules  = [
			'fieldOne' => [ $this->mock_class, 'sanitize_test' ]
		];

		$result = WPCD_Sanitizer::sanitize( $source, $rules );

		$this->assertSame( sizeof( $result ), 1 );
		$this->assertArrayNotHasKey( 'fieldTwo', $result );
	}

}