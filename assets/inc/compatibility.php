<?php

// contains is_plugin_active() which is used below
if (!function_exists('is_plugin_active')) { load_template(ABSPATH . 'wp-admin/includes/plugin.php'); }

/***************************************************************
* Plugin - Advanced Custom Fields (http://www.advancedcustomfields.com/)
* Determine if to load the lite version of ACF (checks for active plugin and if lite is already bundled)
***************************************************************/

// when loaded uses an extra 1MB of memory - option to turn off for performance?

if (is_plugin_inactive('advanced-custom-fields/acf.php') && !function_exists('get_field')) {

	// make sure we are not currently trying to activate ACF
	if (is_admin()) {
		$action = (isset($_GET['action']) ? $_GET['action'] : '');
		$plugin = (isset($_GET['plugin']) ? $_GET['plugin'] : '');
		if ($action != 'activate' && $plugin != 'advanced-custom-fields') {
			load_template(get_template_directory() . '/assets/lib/acf/acf-lite.php');
		}
	} else {
		load_template(get_template_directory() . '/assets/lib/acf/acf-lite.php');
	}
}

/***************************************************************
* Plugin - MinQueue
* Tell MinQueue to use a different cache store and prefix
***************************************************************/

if (is_plugin_active('minqueue/plugin.php')) {

	add_filter('minqueue_prefix', 'null_minqueue_prefix');

	function null_minqueue_prefix($prefix) {
		return 'null';
	}
}

/***************************************************************
* Plugin - Google Analyticator 
* Remove framework options for Google Analytics tracking
***************************************************************/

if (is_plugin_active('google-analyticator/google-analyticator.php')) {

	add_filter('null_options', 'null_google_analyticator_remove_options');

	function null_google_analyticator_remove_options($options) {
		unset($options['gat']);
		unset($options['gat_external_download']);
		return $options;
	}
}

// wordpress seo 
// infinite scroll in jetpack - http://jetpack.me/support/infinite-scroll/ & https://github.com/Automattic/_s/blob/master/inc/jetpack.php


?>