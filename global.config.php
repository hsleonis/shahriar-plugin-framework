<?php

$prefix = 'SH_';

return [

    /**
     * Plugin version
     */
    $prefix.'version' => '1.0.1',

    /**
     * Minimum Wordpress version required
     */
    $prefix.'minimum_wp' => '3.1',

    /**
     * Plugin directory path
     */
    $prefix.'plugin_path' => __DIR__,

    /**
     * Plugin directory url
     */
    $prefix.'plugin_url' => plugin_dir_url( __FILE__ ),

    /**
     * The tables to manage.
     */
    $prefix.'tables' => [
    ],

    /**
     * The asset path.
     */
    $prefix.'assets' => plugin_dir_url( __FILE__ ).'resources/assets/',

    /**
     * The view path.
     */
    $prefix.'views' => plugin_dir_url( __FILE__ ).'resources/views/'

    /**
     * Declare custom globals here
     */
    //
];
