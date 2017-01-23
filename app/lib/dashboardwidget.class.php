<?php

/**
 * Class TmxDashboardWidget
 */
class TmxDashboardWidget{

    /**
     * Dashboard widget options:
     * slug = Widget slug (string).
     * title = Title (string).
     * func = Display function.
     * form = Control callback function.
     * network = Show widget in Network Admin dashboard (true) or not (false).
     * @var $opts array
     */
    private static $opts;

    /**
     * The one instance of this singleton class
     * @var $instance TmxDashboardWidget
     */
    private static $instance;

    /**
     * TmxDashboardWidget constructor.
     */
    public static function construct($opts=array())
    {
        self::$opts['slug'] = isset($opts['slug'])?$opts['slug']:false;
        self::$opts['title'] = isset($opts['title'])?$opts['title']:'ThemeAxe Dashboard Widget';
        self::$opts['func'] = isset($opts['func'])?$opts['func']:array(get_called_class(), 'dashboard_widget_function');
        self::$opts['form'] = isset($opts['form'])?$opts['form']:array(get_called_class(), 'dashboard_form_function');;
        self::$opts['network'] = isset($opts['network'])?boolval($opts['network']):false;

        self::hooks();
    }

    /**
     *
     * @return TmxDashboardWidget
     */
    public static function get_instance() {
        if ( !self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Attach functions to hooks
     */
    private function hooks()
    {
        if(self::$opts['slug']){
            if(self::$opts['network'])
                add_action( 'wp_network_dashboard_setup', array(get_called_class(), 'add_dashboard_widgets') );

            add_action( 'wp_dashboard_setup', array(get_called_class(), 'add_dashboard_widgets') );
        }

        add_action( 'admin_init', array(get_called_class(), 'remove_dashboard_meta') );
    }

    /**
     * Add a widget to the dashboard.
     */
    public function add_dashboard_widgets()
    {
        wp_add_dashboard_widget(
            self::$opts['slug'],
            self::$opts['title'],
            self::$opts['func'],
            self::$opts['form']
        );
    }

    /**
     * Create the function to output the contents of our Dashboard Widget.
     */
    public function dashboard_widget_function()
    {
        // Display whatever it is you want to show.
        echo "Hello World, I'm a great Dashboard Widget";
    }

    public function dashboard_form_function()
    {

    }

    /**
     * Removes metaboxes from dashboard
     */
    public function remove_dashboard_meta(){}
}