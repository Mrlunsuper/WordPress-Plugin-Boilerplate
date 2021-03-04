<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Package_Name
 * @subpackage Plugin_Package_Name/frontend
 */

namespace Plugin_Package_Name\Frontend;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the frontend-facing stylesheet and JavaScript.
 *
 * @package    Plugin_Package_Name
 * @subpackage Plugin_Package_Name/frontend
 * @author     Your Name <email@example.com>
 */
class Frontend {

	/**
	 * Register the stylesheets for the frontend-facing side of the site.
	 *
	 * @hooked wp_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {

		wp_enqueue_style( 'plugin-slug', plugin_dir_url( __FILE__ ) . 'css/plugin-slug-frontend.css', array(), PLUGIN_NAME_VERSION, 'all' );

	}

	/**
	 * Register the JavaScript for the frontend-facing side of the site.
	 *
	 * @hooked wp_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {

		wp_enqueue_script( 'plugin-slug', plugin_dir_url( __FILE__ ) . 'js/plugin-slug-frontend.js', array( 'jquery' ), PLUGIN_NAME_VERSION, false );

	}

}
