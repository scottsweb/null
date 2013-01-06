<?php

/*
Shortcode Name: Embed Widget [widget type="WP_Widget_Search" title="" class=""]
*/

/***************************************************************
* Function null_embed_widget_shortcode
* A shortcode for dropping widgets into your content areas
***************************************************************/

add_shortcode('widget', 'null_embed_widget_shortcode');

function null_embed_widget_shortcode($atts) {

	extract(shortcode_atts( 
		array( 
			'type'   => '',
			'title'  => 'Widget',
			'class'  => ''
		), 
		$atts 
	));

	$args = array(
		'name' 			=> null_slugify($title),
		'id'			=> 'sidebar-'.null_slugify($title),
		'before_widget' => '<section id="sidebar-'.null_slugify($title).'" class="widget embedded-widget '.$class.'">',
		'after_widget'  => '</section><!-- .widget -->',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>'
	);

	ob_start();
	the_widget($type, $atts, $args); 
	$output = ob_get_clean();

	return $output;
}
?>