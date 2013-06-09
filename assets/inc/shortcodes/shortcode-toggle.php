<?php
/*
Shortcode Name: jQuery toggle 
Shortcode Template: [toggle title="Button text"]content[/toggle]
*/

/***************************************************************
* Functions null_toggle
* Create accordion-like toggle panels within your content (requires jQuery) [toggle title="Button text"]Content[/toggle]
***************************************************************/

add_shortcode('toggle', 'null_toggle');

function null_toggle($atts, $content = null) {
	
	global $post;
	
	extract(shortcode_atts(array('title' => '', 'style' => 'list'), $atts));
	
	$output  = '';
	$output .= '<div class="toggle-shortcode toggle-shortcode-'.$post->ID.' '.$style.'"><p class="trigger"><a href="#">' .$title. '</a></p>';
	$output .= '<div class="toggle-container"><div class="block">';
	$output .= do_shortcode($content);
	$output .= '</div></div></div>';

	return $output;
}
?>