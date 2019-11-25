<?php

require __DIR__ . '/../../includes/classes/wpcd-short-code-base.php';

use PHPUnit\Framework\TestCase;

class WPCD_Short_Code_BaseTest extends TestCase {

	public function testShouldDetectShortcode() {
		global $post;

		$expected           = '[wpcd_form]';
		$post               = new stdClass();
		$post->post_content = $expected;

		$mock_shortcode = $this->getMockBuilder( 'WPCD_Short_Code_Base' )->setConstructorArgs( [
			str_replace( array(
				'[',
				']'
			), array( '', '' ), $expected )
		] )->getMockForAbstractClass();

		$this->assertTrue( $mock_shortcode->haveShortcode() );

		$post->post_content = 'not a single short-code in this content';
		$this->assertFalse( $mock_shortcode->haveShortcode() );
	}
}