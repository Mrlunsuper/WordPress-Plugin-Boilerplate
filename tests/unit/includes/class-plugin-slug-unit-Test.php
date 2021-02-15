<?php
/**
 * @package Plugin_Package_Name_Unit_Name
 * @author  Your Name <email@example.com>
 */

namespace Plugin_Package_Name\includes;

use Plugin_Package_Name\admin\Admin;
use Plugin_Package_Name\frontend\Frontend;
use WP_Mock\Matcher\AnyInstance;

/**
 * Class Plugin_Package_Name_Unit_Test
 */
class Plugin_Package_Name_Unit_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::setUp();
	}

	// This is required for `'times' => 1` to be verified.
	protected function _tearDown() {
		parent::_tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers Plugin_Package_Name::set_locale
	 */
	public function test_set_locale_hooked() {

		\WP_Mock::expectActionAdded(
			'plugins_loaded',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		new Plugin_Package_Name();
	}

	/**
	 * @covers Plugin_Package_Name::define_admin_hooks
	 */
	public function test_admin_hooks() {

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
	 * @covers Plugin_Package_Name::define_frontend_hooks
	 */
	public function test_frontend_hooks() {

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
