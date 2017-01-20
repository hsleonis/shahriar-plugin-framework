<?php

return [

    /**
     * Plugin version
     */
    'version' => '1.0.1',

    /**
     * Minimum Wordpress version required
     */
    'minimum_wp' => '3.1',

    /**
     * Plugin directory path
     */
    'plugin_path' => __DIR__,

    /**
     * Plugin directory url
     */
    'plugin_url' => plugin_dir_url( __FILE__ ),

    /**
     * The tables to manage.
     */
    'tables' => [
    ],

    /**
     * The asset path.
     */
    'assets' => plugin_dir_url( __FILE__ ).'resources/assets/',

    /**
     * The view path.
     */
    'views' => plugin_dir_url( __FILE__ ).'resources/views/'

    /**
     * Declare custom globals here
     */
];
