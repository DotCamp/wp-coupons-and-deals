<?php

use PHPUnit\Framework\TestCase;

class WPCD_Form_ShortcodeTest extends TestCase {

	function testShouldExtendShortCodeBase() {
		$temp_shortcode = new WPCD_Form_Shortcode( 'wpcd_form' );
		$this->assertInstanceOf( 'WPCD_Short_Code_Base', $temp_shortcode );
	}
}

