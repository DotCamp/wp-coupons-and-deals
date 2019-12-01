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
}