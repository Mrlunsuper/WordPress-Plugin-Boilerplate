<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package Plugin_Package_Name
 * @author     Your Name <email@example.com>
 */

namespace Plugin_Package_Name;

use Plugin_Package_Name\includes\Plugin_Package_Name;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Develop_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'plugin_snake', $GLOBALS );

		$this->assertInstanceOf( Plugin_Package_Name::class, $GLOBALS['plugin_snake'] );
	}

}
