<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Package_Name
 *
 * @wordpress-plugin
 * Plugin Name:       plugin_title
 * Plugin URI:        http://github.com/username/plugin-slug/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-slug
 * Domain Path:       /languages
 */

namespace Plugin_Package_Name;

use Plugin_Package_Name\includes\Activator;
use Plugin_Package_Name\includes\Deactivator;
use Plugin_Package_Name\includes\Plugin_Package_Name;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function activate_plugin_snake() {

	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function deactivate_plugin_snake() {

	Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'Plugin_Package_Name\activate_plugin_snake' );
register_deactivation_hook( __FILE__, 'Plugin_Package_Name\deactivate_plugin_snake' );


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function instantiate_plugin_snake() {

	$plugin = new Plugin_Package_Name();

	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and frontend-facing site hooks.
 */
$GLOBALS['plugin_snake'] = $plugin_snake = instantiate_plugin_snake();
$plugin_snake->run();
