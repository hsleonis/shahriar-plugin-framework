<?php

/**
 * Load all the plugin files and initialize appropriately
 *
 * @return void
 */
if ( !function_exists('WP_Router_load') ) {
	function WP_Router_load() {
		// load the base class
		require_once 'WP_Router_Utility.class.php';

		if ( WP_Router_Utility::prerequisites_met(phpversion(), get_bloginfo('version')) ) {
			// we can continue. Load all supporting files and hook into wordpress
			require_once 'WP_Router.class.php';
			require_once 'WP_Route.class.php';
			require_once 'WP_Router_Page.class.php';
			
			add_action('init', array('WP_Router_Utility', 'init'), -100, 0);
			add_action(WP_Router_Utility::PLUGIN_INIT_HOOK, array('WP_Router_Page', 'init'), 0, 0);
			add_action(WP_Router_Utility::PLUGIN_INIT_HOOK, array('WP_Router', 'init'), 1, 0);

			// Sample page
			require_once 'WP_Router_call.class.php';
			add_action(WP_Router_Utility::PLUGIN_INIT_HOOK, array('WP_Router_Call', 'init'), 1, 0);
		}
	}
	// Fire it up!
	WP_Router_load();
}
