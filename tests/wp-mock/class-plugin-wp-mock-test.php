<?php
/**
 * Tests for the root plugin file.
 *
 * @package Plugin_Name
 * @author  Your Name <email@example.com>
 */

namespace Plugin_Name;

use Plugin_Name\includes\Plugin_Name;

/**
 * Class Plugin_WP_Mock_Test
 */
class Plugin_WP_Mock_Test extends \WP_Mock\Tools\TestCase {

	/**
	 * Verifies the plugin initialization.
	 *
	 * @runInSeparateProcess
	 */
	public function test_plugin_include() {

		global $plugin_root_dir;

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		require_once $plugin_root_dir . '/plugin-name.php';

		$this->assertArrayHasKey( 'plugin_name', $GLOBALS );

		$this->assertInstanceOf( Plugin_Name::class, $GLOBALS['plugin_name'] );

	}


	/**
	 * Verifies the plugin does not output anything to screen.
	 *
	 * @runInSeparateProcess
	 */
	public function test_plugin_include_no_output() {

		global $plugin_root_dir;

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		ob_start();

		require_once $plugin_root_dir . '/plugin-name.php';

		$printed_output = ob_get_contents();

		ob_end_clean();

		$this->assertEmpty( $printed_output );

	}

}
