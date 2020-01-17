<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package Plugin_Name
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

namespace Plugin_Name;

use Plugin_Name\includes\Plugin_Name;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Develop_Test extends \WP_UnitTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'plugin_name', $GLOBALS );

		$this->assertInstanceOf( Plugin_Name::class, $GLOBALS['plugin_name'] );
	}

}
