<?php
/**
 * @package PHP_Package_Name_Unit_Name
 * @author  Your Name <email@example.com>
 */

namespace Plugin_Package_Name\WP_Includes;

use Plugin_Package_Name\Admin\Admin;
use Plugin_Package_Name\Frontend\Frontend;
use WP_Mock\Matcher\AnyInstance;

/**
 * Class Plugin_Package_Name_Unit_Test
 * @coversDefaultClass \Plugin_Package_Name\WP_Includes\Plugin_Package_Name
 */
class Plugin_Package_Name_Unit_Test extends \Codeception\Test\Unit {

	protected function setUp(): void {
	    parent::setUp();
		\WP_Mock::setUp();
	}

	protected function tearDown(): void {
		parent::tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::set_locale
	 */
	public function test_set_locale_hooked(): void {

		\WP_Mock::expectActionAdded(
			'init',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		new Plugin_Package_Name();
	}

	/**
	 * @covers ::define_admin_hooks
	 */
	public function test_admin_hooks(): void {

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin::class ), 'enqueue_styles' )
		);

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin::class ), 'enqueue_scripts' )
		);

		new Plugin_Package_Name();
	}

	/**
	 * @covers ::define_frontend_hooks
	 */
	public function test_frontend_hooks(): void {

		\WP_Mock::expectActionAdded(
			'wp_enqueue_scripts',
			array( new AnyInstance( Frontend::class ), 'enqueue_styles' )
		);

		\WP_Mock::expectActionAdded(
			'wp_enqueue_scripts',
			array( new AnyInstance( Frontend::class ), 'enqueue_scripts' )
		);

		new Plugin_Package_Name();
	}

}
