<?php
/**
 * @package Shahriar
 */

namespace SHAHRIAR;

// Make sure we don't expose any info if called directly
/*if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

register_activation_hook( __FILE__, array( 'Watchman', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Watchman', 'plugin_deactivation' ) );

add_action( 'init', array( 'Watchman', 'init' ) );
*/

class Shahriar{
    /**
     * Instance initialized
     * @var bool
     */
    private static $initiated = false;

    public function __construct(){
        if ( ! self::$initiated ) {
            self::init();
        }
    }

    private static function globals($defined){
        foreach ($defined as $d => $val){
            if(!defined(__NAMESPACE__.$d)){
                define(__NAMESPACE__.$d, $val);
            }
        }
    }

    public static function autoload($class){
        echo 'lib/'.$class . '.class.php';
    }

    private static function init(){
        self::$initiated = true;

        if(is_readable(dirname(__FILE__) . '/../global.config.php')) {
            $var = require_once(dirname(__FILE__) . '/../global.config.php');
            self::globals($var);

            spl_autoload_register(array(self, 'autoload'));
        }
        else{

        }
    }
}

new Shahriar();