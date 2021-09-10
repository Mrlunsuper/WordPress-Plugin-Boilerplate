<?php
/**
 *
 *
 * @package Plugin_Package_Name
 * @author  Your Name <email@example.com>
 */

namespace Plugin_Package_Name\Includes;

/**
 * Class Plugin_WP_Mock_Test
 *
 * @coversDefaultClass \Plugin_Package_Name\Includes\I18n
 */
class I18n_Unit_Test extends \Codeception\Test\Unit {

	protected function setup(): void {
	    parent::setup();
		\WP_Mock::setUp();
	}

	// This is required for `'times' => 1` to be verified.
	protected function tearDown() {
		parent::tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * Verify load_plugin_textdomain is correctly called.
	 *
	 * @covers ::load_plugin_textdomain
	 */
	public function test_load_plugin_textdomain() {

		global $plugin_root_dir;

        \WP_Mock::userFunction(
            'plugin_basename',
            array(
                'args'   => array(
                    \WP_Mock\Functions::type( 'string' )
                ),
                'return' => 'plugin-slug',
                'times' => 1
            )
        );

        \WP_Mock::userFunction(
			'load_plugin_textdomain',
			array(
                'times' => 1,
				'args'   => array(
					'plugin-slug',
					false,
					'plugin-slug/languages/',
				)
			)
		);

        $i18n = new I18n();
        $i18n->load_plugin_textdomain();
	}
}
