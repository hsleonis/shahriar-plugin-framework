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
            if (is_file(dirname(__FILE__) .'/lib/'.$fileinfo->getFilename())) {

                $name = $fileinfo->getFilename();
                if(is_readable(dirname(__FILE__) .'/lib/'.$name)){
                    require_once(dirname(__FILE__) .'/lib/'.$name);
                }
            }
        }
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
            new \SHAHRIAR\Activator();

            // Deactivate plugin
            new \SHAHRIAR\Deactivator();
            
            // Attach hooks
            self::hooks();

            // Test admin notice
            new TmxAdminNotice(array(
                'msg' => 'Hello Plugin User!'
            ));

            // Test Help tab
            $helptabs = new TmxHelpTab();
            $helptabs->create(array('options-general', 'options-writing', 'seagul-options'), array(
                'first-tab' => array(
                    'title'   => 'ThemeAxe',
                    'content' => 'It is the best software firm ever!'
                ),
                'second-tab' => array(
                    'title'   => 'Contact',
                    'content' => '<p>+88 01234 567890</p><p><a href="mailto:info@themeaxe.com">info@themeaxe.com</a></p>'
                )
            ));
            $helptabs->remove('overview');
            $helptabs->sidebar('options-general',"Hello WOrld!");
        }
        else{

        }
    }
}