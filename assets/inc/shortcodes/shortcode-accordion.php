<?php
/*
Shortcode Name: jQuery UI Accordion 
Shortcode Template: [accordion][atab title="title"][/atab][/accordion]
*/

/***************************************************************
* Functions null_accordion, null_accordion_tabs
* Shortcode powered accordion interface. Requires jQuery ui accordion [accordion][atab title="title"]content[/atab][/accordion]
***************************************************************/

add_shortcode('accordion','null_accordion' );
add_shortcode('atab','null_accordion_tabs');

function null_accordion($atts, $content = null) {
	
	global $post;
	
	$GLOBALS['atab_count'] = 0;

	do_shortcode($content);

	if(is_array( $GLOBALS['atabs'])) {

		foreach( $GLOBALS['atabs'] as $tab ){
			$ac[] = '<a class="aheader" href="#a-'.null_slugify($tab['title']).'">'.$tab['title'].'</a><div class="apane" id="a-'.null_slugify($tab['title']).'">'.$tab['content'].'</div>';
		}
		
		$return = "\n<div class=\"accordion-shortcode accordion-shortcode".$post->ID."\">".implode( "\n", $ac )."\n".'</div>'."\n";
	}
	
	return $return;
}

function null_accordion_tabs($atts, $content = null) {

	extract(shortcode_atts(array('title' => 'Tab %d'), $atts));
	$x = $GLOBALS['atab_count'];
	$GLOBALS['atabs'][$x] = array( 'title' => sprintf($title, $GLOBALS['atab_count'] ), 'content' => do_shortcode($content));
	$GLOBALS['atab_count']++;
	
}
?>