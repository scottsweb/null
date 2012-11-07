<?php
/*
Shortcode Name: jQuery UI Tabs [tabgroup][tab title="title"]content[/tab][/tabgroup]
*/

/***************************************************************
* Functions null_tab_group, null_tabs
* Shortcode powered tab interface. Requires jQuery ui tabs [tabgroup][tab title="title"]content[/tab][/tabgroup]
***************************************************************/

add_shortcode('tabgroup','null_tab_group' );
add_shortcode('tab','null_tabs');

function null_tab_group($atts, $content = null) {
	
	global $post;

	$GLOBALS['tab_count'] = 0;

	do_shortcode($content);

	if(is_array( $GLOBALS['tabs'])) {

		foreach( $GLOBALS['tabs'] as $tab ){
			$tabs[] = '<li><a class="" href="#t-'.null_slugify($tab['title']).'">'.$tab['title'].'</a></li>';
			$panes[] = '<div class="tpane" id="t-'.null_slugify($tab['title']).'">'.$tab['content'].'</div>';
		}
		
		$return = "\n<div class=\"tabs-shortcode tabs-shortcode-".$post->ID."\">".'<ul class="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".implode( "\n", $panes ).'</div>'."\n";
	}
	
	return $return;
}

function null_tabs($atts, $content = null) {

	extract(shortcode_atts(array('title' => 'Tab %d'), $atts));
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array('title' => sprintf($title, $GLOBALS['tab_count']), 'content' =>  do_shortcode($content));
	$GLOBALS['tab_count']++;
	
}
?>