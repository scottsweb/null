<?php

/***************************************************************
* Function null_extension_post_types
* Include additional post types
***************************************************************/

add_action('widgets_init', 'null_extension_post_types');

function null_extension_post_types() {
	
	$post_types = null_get_extensions();
	$post_types_settings = of_get_option('additional_post_types', array());
	
	foreach($post_types as $post) {
		if (isset($post_types_settings[$post['nicename']])) {
			if (file_exists($post['path']) && ($post_types_settings[$post['nicename']])) {
				load_template($post['path']);
			}
		}
	}
}

?>