<?php
/**
 * @package Shahriar
 */

namespace SHAHRIAR;

/*
add_action( 'init', array( 'Watchman', 'init' ) );
*/

class Shahriar{
    /**
     * Instance initialized
     * @var bool
     */
    private static $initiated = false;

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
     * @param $defined array
     */
    private static function globals($defined){
        foreach ($defined as $d => $val){
            if(!defined(__NAMESPACE__.$d)){
                define(__NAMESPACE__.$d, $val);
            }
        }
    }

    /**
     * Autoload plugin library classes
     */
    private static function autoload(){
        $dir = new \DirectoryIterator(dirname(__FILE__) .'/lib');

        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {

                $name = $fileinfo->getFilename();
                if(is_readable(dirname(__FILE__) .'/lib/'.$name)){
                    require_once(dirname(__FILE__) .'/lib/'.$name);
                }
            }
        }
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
        }
        else{

        }
    }
}