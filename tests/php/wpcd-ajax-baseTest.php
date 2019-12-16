<?php

use PHPUnit\Framework\TestCase;

class WPCD_Ajax_BaseTest extends TestCase {

	public function setUp(): void {
		$this->ajax_base = $this->getMockBuilder( WPCD_Ajax_Base::class )->setConstructorArgs( [ 'ajax_base' ] )->getMockForAbstractClass();
	}

	protected function tearDown(): void {
		$this->ajax_base = null;
	}


	public function testShouldSetupCorrectAjaxname() {
		$call_name        = 'call_test';
		$expected         = 'wp_ajax_' . $call_name;
		$no_priv_expected = 'wp_ajax_nopriv_' . $call_name;

		$base_abstract = $this->getMockBuilder( WPCD_Ajax_Base::class )->setConstructorArgs( [
			$call_name,
			false
		] )->getMockForAbstractClass();
		$this->assertSame( $base_abstract->ajax_call_name, $no_priv_expected );

		$base_abstract = $this->getMockBuilder( WPCD_Ajax_Base::class )->setConstructorArgs( [
			$call_name,
			true
		] )->getMockForAbstractClass();
		$this->assertSame( $base_abstract->ajax_call_name, $expected );
	}

	public function testShouldCallAjaxHookWithCorrectName() {
		$ajax_name     = 'call_test';
		$expected      = 'wp_ajax_' . $ajax_name;
		$base_abstract = $this->getMockBuilder( WPCD_Ajax_Base::class )->setConstructorArgs( [
			$ajax_name,
			true
		] )->getMockForAbstractClass();

		$global_caller_mock = $this->createMock( WPCD_Global_Caller::class );
		$base_abstract->setCaller( $global_caller_mock );

		$global_caller_mock->expects( $this->once() )->method( '__call' )->with( $this->equalTo( 'add_action' ),
			$this->equalTo( [ $expected, [ $base_abstract, 'logic' ] ] ) );

		try {
			$base_abstract->add();
		} catch ( Exception $e ) {
		}

	}

	public function testShouldUseResponseObject() {
		$error_message = 'an error message';
		$this->ajax_base->setError( $error_message );

		$this->assertSame( $error_message, ( $this->ajax_base->getResponse() )['error'] );

		$data_key   = 'test';
		$data_value = 'test value';

		$this->ajax_base->setData( $data_key, $data_value );

		$this->assertSame( $data_value, $this->ajax_base->getResponse()[ $data_key ] );
	}

	public function testShouldReturnJSONString() {
		$test_array = ['test'=>'test_value'];
		$this->ajax_base->setData('test', 'test_value');

		$json_string = json_encode($test_array);

		$this->assertSame($json_string , $this->ajax_base->getResponseJson());
	}
}