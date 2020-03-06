<?php

require __DIR__ . '/../../includes/classes/admin/wpcd-meta-boxes-fields-pro__premium_only.php';

use PHPUnit\Framework\TestCase;

class WPCD_Meta_Boxes_Fields_ProTest extends TestCase {

	public function setUp(): void {
		if ( ! function_exists( '__' ) ) {
			function __( $arg1, $arg2 ) {
				return null;
			}
		}
	}

	public function testShouldBeStatic() {
		$this->assertIsArray( WPCD_Meta_Boxes_Fields_Pro__Premium_Only::getFields() );
	}
}



