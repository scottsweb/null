<?php
/*
Shortcode Name: Blog Info
Shortcode Template: [bloginfo key="template_url"]
*/

/***************************************************************
* Function null_bloginfo
* A shortcode for grabbing bloginfo settings. Usage: [bloginfo key='template_url'], good for blogs that move
***************************************************************/

add_shortcode('bloginfo', 'null_bloginfo');

function null_bloginfo($atts, $content = null) {

	do_shortcode( $content );
	extract(shortcode_atts(array('key' => ''), $atts));
	return get_bloginfo($key);

}