<?php

/**
 * Usage of TmxDashboardWidget
 * Since 1.0.1
 * Class TestDashboardWidgets
 */
class TestDashboardWidgets extends TmxDashboardWidget{

    public static function construct()
    {
        self::create_dashboard_widget(array(
            'slug' => 'test-widget',
            'title' => 'Test Widget',
            'form' => false,
            'side'   => true,
            'top' => true
        ));

        parent::construct();
    }

    public function remove_dashboard_meta()
    {
        // remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    }
    
    public function dashboard_form_function()
    {
        echo 'This is the form';
    }
    
    public function dashboard_widget_function()
    {
        echo 'This is a custom Dashboard Widget';
    }
}