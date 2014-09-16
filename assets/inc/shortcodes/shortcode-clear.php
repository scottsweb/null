<?php
/*
Shortcode Name: Clear & Line Break
Shortcode Template: [clear] or [clearline]
*/

/***************************************************************
* Functions null_break & null_linebreak
* Clear floated editor content in two ways: [clear] [clearline]
***************************************************************/

add_shortcode('clear', 'null_break');
add_shortcode('clearline', 'null_linebreak');

function null_break( $atts, $content = null ) {

	return '<div class="clear"></div>';

}

function null_linebreak( $atts, $content = null ) {

	return '<hr /><div class="clear"></div>';

}