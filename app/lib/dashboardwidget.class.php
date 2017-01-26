<?php

/**
 * Class TmxDashboardWidget
 * Adds Widgets to WordPress Dashboard.
 * @author: Md. Hasan Shahriar
 * @date: 23rd Jan, 2017
 * @version: 1.0.1
 * @email: hsleonis2@gmail.com
 */
class TmxDashboardWidget{

    /**
     * Dashboard widget options:
     * 
     * slug = Widget slug (string).
     * title = Title (string).
     * func = Display function.
     * form = Control callback function or false.
     * network = Show widget in Network Admin dashboard (true) or not (false).
     * top = Move widget to the top (boolean).
     * side = Move widget to the right side (boolean).
     * 
     * Note: top & side only works until the user sorts manually.
     * @var $opts array
     */
    public static $opts;

    /**
     * The one instance of this singleton class
     * @var $instance TmxDashboardWidget
     */
    private static $instance;

    /**
     * TmxDashboardWidget constructor.
     */
    public static function construct()
    {
        self::hooks();
    }

    /**
     * Get the static object.
     * @return TmxDashboardWidget
     */
    public static function get_instance() {
        if ( !self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Attach functions to hooks.
     */
    private function hooks()
    {
        if(self::$opts['slug']){
            if(self::$opts['network'])
                add_action( 'wp_network_dashboard_setup', array(get_called_class(), 'add_dashboard_widgets') );

            add_action( 'wp_dashboard_setup', array(get_called_class(), 'add_dashboard_widget') );
        }

        add_action( 'admin_init', array(get_called_class(), 'remove_dashboard_meta') );
    }

    /**
     * Create a Dashboard Widget.
     * @param array $opts
     */
    public function create_dashboard_widget($opts=array())
    {
        self::$opts['slug'] = isset($opts['slug'])?$opts['slug']:false;
        self::$opts['title'] = isset($opts['title'])?$opts['title']:'ThemeAxe Dashboard Widget';
        self::$opts['func'] = isset($opts['func'])?$opts['func']:array(get_called_class(), 'dashboard_widget_function');
        self::$opts['form'] = isset($opts['form'])?$opts['form']:array(get_called_class(), 'dashboard_form_function');;
        self::$opts['network'] = isset($opts['network'])?boolval($opts['network']):false;
        self::$opts['top'] = isset($opts['top'])?$opts['top']:false;
        self::$opts['side'] = isset($opts['side'])?$opts['side']:false;
        self::$opts['options'] = (isset($opts['options']) && is_array($opts['options']))?$opts['options']:array();
    }

    /**
     * Add a widget to the dashboard.
     */
    public function add_dashboard_widget()
    {
        wp_add_dashboard_widget(
            self::$opts['slug'],
            self::$opts['title'],
            self::$opts['func'],
            self::$opts['form']
        );
        
        if(self::$opts['top'] or self::$opts['side']){
            self::move_dashboard_widget();
        }

        self::register_dashboard_widget_options(self::$opts['options']);
    }

    /**
     * Move widget to the top or side.
     * Note: Only works for people who have never re-ordered their widgets.
     */
    private function move_dashboard_widget()
    {
        global $wp_meta_boxes;

        // Get the regular dashboard widgets array
        // (which has our new widget already but at the end)
        $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
        $side_dashboard = $wp_meta_boxes['dashboard']['side']['core'];

        // Backup and delete our new dashboard widget from the end of the array
        $widget_backup = array( self::$opts['slug'] => $normal_dashboard[self::$opts['slug']] );
        unset( $normal_dashboard[self::$opts['slug']] );

        if (self::$opts['top'] && !self::$opts['side']){
            $sorted_dashboard = array_merge($widget_backup, $normal_dashboard);
            $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
        }
        elseif (self::$opts['side']){
            $wp_meta_boxes['dashboard']['normal']['core'] = $normal_dashboard;

            if (self::$opts['top'])
                $sorted_dashboard = array_merge($widget_backup,$side_dashboard);
            else
                $sorted_dashboard = array_merge($side_dashboard,$widget_backup);

            $wp_meta_boxes['dashboard']['side']['core'] = $sorted_dashboard;
        }
    }

    /**
     * Create the function to output the contents of our Dashboard Widget.
     */
    public function dashboard_widget_function(){}

    /**
     * Dashboard Widget form elements show and update.
     */
    public function dashboard_form_function(){}

    /**
     * Removes metaboxes from dashboard.
     */
    public function remove_dashboard_meta(){}

    /**
     * Register dashboard widget options,
     * otherwise an error will be shown first time the form is shown.
     * @param array $args
     */
    public static function register_dashboard_widget_options($args=array())
    {
        //Register widget settings by updating only when the option isn't existing
        self::update_dashboard_widget_options($args, true);
    }

    /**
     * Gets the options for a widget of the specified name.
     * @return array An associative array containing the widget's options and values. False if no opts.
     */
    public static function get_dashboard_widget_options()
    {
        //Fetch ALL dashboard widget options from the db
        $opts = get_option( 'dashboard_widget_options' );

        //If no widget is specified, return everything
        if ( empty( self::$opts['slug'] ) )
            return $opts;

        //If we request a widget and it exists, return it
        if ( isset( $opts[self::$opts['slug']] ) )
            return $opts[self::$opts['slug']];

        //Something went wrong
        return false;
    }

    /**
     * Gets one specific option for the specified widget.
     * @param $option
     * @param null $default
     * @return string
     */
    public static function get_dashboard_widget_option( $option, $default=NULL )
    {

        $opts = self::get_dashboard_widget_options();

        //If widget opts dont exist, return false
        if ( ! $opts )
            return false;

        //Otherwise fetch the option or use default
        if ( isset( $opts[$option] ) && ! empty($opts[$option]) )
            return $opts[$option];
        else
            return ( isset($default) ) ? $default : false;
    }

    /**
     * Saves an array of options for a single dashboard widget to the database.
     * Can also be used to define default values for a widget.
     * @param $args array An associative array of options being saved.
     * @param $add_only bool If true, options will not be added if widget options already exists
     * @return mixed option
     */
    public static function update_dashboard_widget_options( $args=array(), $add_only=false )
    {
        //Fetch ALL dashboard widget options from the db
        $settings = get_option( 'dashboard_widget_options' );

        //Get just our widget's options, or set empty array
        $w_opts = ( isset( $settings[self::$opts['slug']] ) ) ? $settings[self::$opts['slug']] : array();

        if ( $add_only ) {
            //Flesh out any missing options (existing ones overwrite new ones)
            $settings[self::$opts['slug']] = array_merge($args,$w_opts);
        }
        else {
            //Merge new options with existing ones, and add it back to the widgets array
            $settings[self::$opts['slug']] = array_merge($w_opts,$args);
        }

        //Save the entire widgets array back to the db
        return update_option('dashboard_widget_options', $settings);
    }
}