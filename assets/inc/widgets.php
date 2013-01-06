<?php

/***************************************************************
* Function null_register_sidebars
* Initialise theme sidebars ready for chosen widgets
***************************************************************/

add_action('init', 'null_register_sidebars');

function null_register_sidebars() {
	
	if (!function_exists('register_sidebars'))
		return;
	
	$sidebars = apply_filters('null_sidebars', array(__('Homepage', 'null'), __('Page', 'null'), __('Posts/Blog', 'null'), __('Search', 'null'), __('Footer', 'null')));
	
	foreach ($sidebars as $sidebar) {
		register_sidebar(
			array(
				'name' 			=> $sidebar,
				'id'			=> 'sidebar-'.null_slugify($sidebar),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section><!-- .widget -->',
				'before_title'  => '<h4 class="widgettitle">',
				'after_title'   => '</h4>'
			)
		);	
	}
}

/***************************************************************
* Function null_remove_wordpress_widgets
* Remove unrequired widgets as chosen in settings
***************************************************************/

add_action('widgets_init','null_wordpress_widgets', 1);

function null_wordpress_widgets() {

	$wordpress_widget_settings = of_get_option('wordpress_widgets');

	// calendar
	if ($wordpress_widget_settings['calendar_widget'] == "0") { unregister_widget('WP_Widget_Calendar'); }
	
	// search
	if ($wordpress_widget_settings['search_widget'] == "0") { unregister_widget('WP_Widget_Search'); }
	
	// recent comments
	if ($wordpress_widget_settings['recent_comments_widget'] == "0") { unregister_widget('WP_Widget_Recent_Comments'); }
	
	// archives
	if ($wordpress_widget_settings['archives_widget'] == "0") { unregister_widget('WP_Widget_Archives'); }
	
	// categories
	if ($wordpress_widget_settings['categories_widget'] == "0") { unregister_widget('WP_Widget_Categories'); }

	// pages
	if ($wordpress_widget_settings['pages_widget'] == "0") { unregister_widget('WP_Widget_Pages'); }

	// recent posts
	if ($wordpress_widget_settings['recent_posts_widget'] == "0") { unregister_widget('WP_Widget_Recent_Posts'); }

	// rss
	if ($wordpress_widget_settings['rss_widget'] == "0") { unregister_widget('WP_Widget_RSS'); }

	// tag cloud
	if ($wordpress_widget_settings['tag_cloud_widget'] == "0") { unregister_widget('WP_Widget_Tag_Cloud'); }

	// text
	if ($wordpress_widget_settings['text_widget'] == "0") { unregister_widget('WP_Widget_Text'); }

	// links
	if ($wordpress_widget_settings['links_widget'] == "0") { unregister_widget('WP_Widget_Links'); }

	// meta
	if ($wordpress_widget_settings['meta_widget'] == "0") { unregister_widget('WP_Widget_Meta'); }
	
	// custom menus
	if ($wordpress_widget_settings['custom_menu_widget'] == "0") { unregister_widget('WP_Nav_Menu_Widget'); }
}

/***************************************************************
* Function null_extension_widgets
* Include additional widgets
***************************************************************/

add_action('widgets_init', 'null_extension_widgets');

function null_extension_widgets() {

	$widgets = null_get_extensions("widgets");
	$widget_settings = of_get_option('additional_widgets');
	
	foreach($widgets as $widget) {
		if (isset($widget_settings[$widget['nicename']])) {		
			if (file_exists($widget['path']) && ($widget_settings[$widget['nicename']])) {
				load_template($widget['path']);
			}
		}
	}
}

/***************************************************************
* Enable oEmbed & shortcodes in text widgets 
***************************************************************/

global $wp_embed;
add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8);
add_filter('widget_text', array( $wp_embed, 'autoembed'), 8);
add_filter('widget_text', 'do_shortcode', 11);

?>