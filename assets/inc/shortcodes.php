<?php

/***************************************************************
* Function null_extension_shortcodes
* Include additional shortcodes
***************************************************************/

add_action('widgets_init', 'null_extension_shortcodes');

function null_extension_shortcodes() {

	$shortcodes = null_get_extensions("shortcodes");
	$shortcode_settings = of_get_option('additional_shortcodes');
	
	foreach($shortcodes as $shortcode) {
		if (isset($shortcode_settings[$shortcode['nicename']]))	{	
			if (file_exists($shortcode['path']) && ($shortcode_settings[$shortcode['nicename']])) {
				load_template($shortcode['path']);
			}
		}
	}
}
?>