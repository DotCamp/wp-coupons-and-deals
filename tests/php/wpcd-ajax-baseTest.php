<?php

use PHPUnit\Framework\TestCase;

class WPCD_Ajax_BaseTest extends TestCase{

	public function testShouldSetupCorrectAjaxname(  ) {
		$call_name = 'call_test';
		$expected = 'wp_ajax_' . $call_name;
		$no_priv_expected = 'wp_ajax_nopriv_' . $call_name;

		$base_abstract = 	$this->getMockBuilder(WPCD_Ajax_Base::class)->setConstructorArgs([$call_name, false])->getMockForAbstractClass();
		$this->assertSame($base_abstract->ajax_call_name, $no_priv_expected);

		$base_abstract = 	$this->getMockBuilder(WPCD_Ajax_Base::class)->setConstructorArgs([$call_name, true])->getMockForAbstractClass();
		$this->assertSame($base_abstract->ajax_call_name, $expected);
	}

	public function testShouldCallAjaxHookWithCorrectName(  ) {
		$ajax_name = 'call_test';
		$expected = 'wp_ajax_' . $ajax_name;
		$base_abstract = $this->getMockBuilder(WPCD_Ajax_Base::class)->setConstructorArgs([$ajax_name , true])->getMockForAbstractClass();

		$global_caller_mock =$this->createMock(WPCD_Global_Caller::class);
		$base_abstract->setCaller($global_caller_mock);

		$global_caller_mock->expects($this->once())->method('__call')->with($this->equalTo('add_action'),$this->equalTo([$expected, [$base_abstract , 'logic']]));

		try {
			$base_abstract->add();
		} catch ( Exception $e ) {
		}

	}
}