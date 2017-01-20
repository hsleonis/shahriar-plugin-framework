<?php
/**
 * @package Shahriar
 */

class Shahriar{
    /**
     * Instance initialized
     * @var bool
     */
    private static $initiated = false;

    /**
     * Plugin variables
     * @var $vars array
     */
    public static $vars;

    /**
     * Shahriar constructor.
     */
    public function __construct(){
        if ( ! self::$initiated ) {
            self::init();
        }
    }

    /**
     * Define plugin variables
     * @param $vars array
     */
    public function globals($vars=array()){
        self::$vars = $vars;
    }

    /**
     * Autoload plugin library classes
     */
    private static function autoload(){
        // All class in lib folder
        $dir = new \DirectoryIterator(dirname(__FILE__) .'/lib');

        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {

                $name = $fileinfo->getFilename();
                if(is_readable(dirname(__FILE__) .'/lib/'.$name)){
                    require_once(dirname(__FILE__) .'/lib/'.$name);
                }
            }
        }

        // WP Router
        require_once(dirname(__FILE__). '/wp-router/wp-router.php');
    }

    /**
     * Attach hooks
     */
    private static function hooks(){
        add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );
    }

    /**
     * Initialize plugin framework
     */
    private static function init(){
        self::$initiated = true;

        if(is_readable(dirname(__FILE__) . '/../global.config.php')) {
            $var = require_once(dirname(__FILE__) . '/../global.config.php');

            // Defined identifiers
            self::globals($var);

            // Autoload classes
            self::autoload();

            // Activate plugin
            register_activation_hook( __FILE__, array( 'Activator', 'run' ) );

            // Deactivate plugin
            register_deactivation_hook( __FILE__, array( 'Deactivator', 'run' ) );
            
            // Attach hooks
            self::hooks();

            // Test admin notice
            
        }
        else{

        }
    }
}