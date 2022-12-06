<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * frontend-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    PHP_Package_Name
 */

namespace Plugin_Package_Name;

use Plugin_Package_Name\Admin;
use Plugin_Package_Name\Frontend;
use Plugin_Package_Name\I18n;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * frontend-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class PluginCamel {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->set_locale();
		$this->include_helpers();
		$this->init_classes();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale(): void {

		$plugin_i18n = new I18n();
		add_action( 'init',  [ $plugin_i18n, 'load_plugin_textdomain' ] );

	}

	private function init_classes(): void {
		if ( $this->is_request( 'frontend' ) ) {
			$this->init_frontend_classes();
		}
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function init_admin_classes(): void {
		$admin_assets = ( new Admin\Assets() )->init_hooks();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function init_frontend_classes(): void {
		$frontend_assets = ( new Frontend\Assets() )->init_hooks();
	}

	
	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Checks the environment for compatibility problems.  Returns a string with the first incompatibility
	 * found or false if the environment has no problems.
	 *
	 * @noinspection PhpUndefinedConstantInspection
	 */
	private function get_environment_warning() {
		$output = '';

		if ( version_compare( phpversion(), PLUGIN_NAME_MIN_PHP_VER, '<' ) ) {
			/* translators: %1$s: the minimum PHP version, %2$s: the current PHP version. */
			$message = __( 'WC Vendors - The minimum PHP version required for this plugin is %1$s. You are running %2$s.', 'wc-vendors' );
			$output  = sprintf( $message, PLUGIN_NAME_MIN_PHP_VER, phpversion() );
		}
		
		return $output;
	}

}
