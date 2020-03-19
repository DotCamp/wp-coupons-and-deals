<?php

use PHPUnit\Framework\TestCase;

class WPCD_Form_ShortcodeTest extends TestCase {

	function testShouldExtendShortCodeBase() {
		$temp_shortcode = new WPCD_Form_Shortcode_Pro( 'wpcd_form' );
		$this->assertInstanceOf( 'WPCD_Short_Code_Base', $temp_shortcode );
	}

	function testShouldGetAvailableTemplateNames() {
		$test_meta_array = array(
			[ 'id' => 'coupon-template', 'options' => [ 0, 1, 2 ] ],
			[
				'id'      => 'not-coupon-template',
				'options' => [ 0 ]
			]
		);

		$reflection_class = new ReflectionClass( WPCD_Form_Shortcode_Pro::class );
		$pri_method       = $reflection_class->getMethod( 'getAvailableTemplateNames' );
		$pri_method->setAccessible( true );

		$output = $pri_method->invoke( null, $test_meta_array);

		$this->assertEquals(count($output), count($test_meta_array[0]['options']));
	}
}

