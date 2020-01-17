<?php
/**
 * Tests for I18n. Tests load_plugin_textdomain.
 *
 * @package Plugin_Name
 * @author  Your Name <email@example.com>
 */

namespace Plugin_Name\includes;

/**
 * Class Plugin_Name_Test
 *
 * @see I18n
 */
class Plugin_Name_I18n_Test extends \WP_UnitTestCase {

	/**
	 * AFAICT, this will fail until a translation has been added.
	 *
	 * @see load_plugin_textdomain()
	 * @see https://gist.github.com/GaryJones/c8259da3a4501fd0648f19beddce0249
	 */
	public function test_load_plugin_textdomain() {

		$this->markTestSkipped( 'Needs one translation before test might pass.' );

		global $plugin_root_dir;

		$this->assertTrue( file_exists( $plugin_root_dir . '/languages/' ), '/languages/ folder does not exist.' );

		// Seems to fail because there are no translations to load.
		$this->assertTrue( is_textdomain_loaded( 'plugin-name' ), 'i18n text domain not loaded.' );

	}


	/**
	 * Checks if the filter run by WordPress in the load_plugin_textdomain() function is called.
	 *
	 * @see load_plugin_textdomain()
	 */
	public function test_load_plugin_textdomain_function() {

		$called        = false;
		$actual_domain = null;

		$filter = function( $locale, $domain ) use ( &$called, &$actual_domain ) {

			$called        = true;
			$actual_domain = $domain;

			return $locale;
		};

		add_filter( 'plugin_locale', $filter, 10, 2 );

		/**
		 * Get the main plugin class.
		 *
		 * @var Plugin_Name $plugin_name
		 */
		$plugin_name = $GLOBALS['plugin_name'];
		$i18n        = $plugin_name->i18n;

		$i18n->load_plugin_textdomain();

		$this->assertTrue( $called, 'plugin_locale filter not called within load_plugin_textdomain() suggesting it has not been set by the plugin.' );
		$this->assertEquals( 'plugin-name', $actual_domain );

	}
}
