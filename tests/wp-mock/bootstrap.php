<?php
/**
 * PHPUnit bootstrap file for WP_Mock.
 *
 * @package Plugin_Package_Name
 * @author  Your Name <email@example.com>
 */

$project_root_dir   = dirname( __FILE__, 3 );
$plugin_root_dir    = $project_root_dir . '/src';
$plugin_slug        = basename( $project_root_dir );
$plugin_slug_php    = $plugin_slug . '.php';
$plugin_path_php    = $plugin_root_dir . '/' . $plugin_slug_php;
$plugin_basename    = $plugin_slug . '/' . $plugin_slug_php;
$wordpress_root_dir = $project_root_dir . '/vendor/wordpress/wordpress/src';

// Composer require-dev autoloader.
require_once $project_root_dir . '/vendor/autoload.php';

// Plugin autoload. ... can't do this because things extend WordPress classes.
require_once $plugin_root_dir . '/autoload.php';

WP_Mock::bootstrap();

