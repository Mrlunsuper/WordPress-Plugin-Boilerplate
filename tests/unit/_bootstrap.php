<?php
/**
 * PHPUnit bootstrap file for WP_Mock.
 *
 * @package           Plugin_Package_Name
 */

global $plugin_root_dir;
require_once $plugin_root_dir . '/autoload.php';

WP_Mock::bootstrap();
