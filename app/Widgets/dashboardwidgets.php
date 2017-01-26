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
            'side'   => true,
            'top' => true,
            'options' => array(
                'example_number' => 15,
            )
        ));

        parent::construct();
    }

    public function remove_dashboard_meta()
    {
        // remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    }
    
    public function dashboard_form_function()
    {
        if(isset( $_POST['dashboard-widget-nonce'] )) {
            $number = stripslashes($_POST['number']);
            self::update_dashboard_widget_options(
                array(
                    'example_number' => $number,
                )
            );
        }
        ?>
        <div>
            <input type="text" autocomplete="off" name="number" value="<?php echo self::get_dashboard_widget_option('example_number', 15); ?>" />
        </div>
        <?php
    }
    
    public function dashboard_widget_function()
    {
        ?>
        <p>
            Count: <b><?php echo self::get_dashboard_widget_option('example_number'); ?></b>
        </p>
        <?php
    }
}