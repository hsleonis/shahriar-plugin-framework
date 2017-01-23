<?php
/**
 * @package Shahriar
 */
/*
Plugin Name: Shahriar
Plugin URI: https://themeaxe.com/
Description: WP PLUGIN FRAMEWORK BY SHAHRIAR :)
Version: 1.0.1
Author: MD. Hasan Shahriar
Author URI: https://github.com/hsleonis
License: GPLv2 or later
Text Domain: themeaxe

Copyright 2016 ThemeAxe.
*/

/**
 * Initialize plugin and library
 */
require_once( dirname(__FILE__) . '/app/autoload.php' );
new Shahriar();

/**
 * Dashboard widgets
 */
require_once ( dirname(__FILE__) . '/app/Widgets/dashboardwidgets.php' );
TestDashboardWidgets::construct(array(
    'slug' => 'test-widget'
));

