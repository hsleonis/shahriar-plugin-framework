<?php
 
class WP_Router_call {
	public static function init() {
		add_action('wp_router_generate_routes', array(get_class(), 'generate_routes'), 10, 1);
	}

	public static function generate_routes( WP_Router $router ) {
		$router->add_route('wp-router-sample', array(
			'path' => '^wp_router/(.*?)$',
			'query_vars' => array(
				'sample_argument' => 1,
			),
			'page_callback' => array(get_class(), 'sample_callback'),
			'page_arguments' => array('sample_argument'),
			'access_callback' => TRUE,
			'title' => 'WP Router Sample Page',
		));
		$router->add_route('product', array(
			'path' => '^product$',
			'page_callback' => array(get_class(), 'sample_callback'),
			'page_arguments' => array('new_title'),
			'access_callback' => TRUE,
			'title' => 'ABOUT FROM ROUTER',
		));
	}

	public static function sample_callback( $argument ) {
		echo '<p>Welcome to the WP Router sample page. You can find the code that generates this page in '.__FILE__.'</p>';
		echo '<p>This page helpfully tells you the value of the <code>sample_argument</code> query variable: '.esc_html($argument).'</p>';
	}
}
