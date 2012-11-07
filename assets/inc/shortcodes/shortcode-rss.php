<?php
/*
Shortcode Name: RSS [rss src="http://url" limit="3"]
*/

/***************************************************************
* Function null_rss
* A shortcode for RSS feeds. Usage: [rss src="http://url" limit="3"]
***************************************************************/

add_shortcode('rss', 'null_rss');

function null_rss($atts) {
	
	global $post;

	if (!class_exists('SimplePie')) {
		load_template(ABSPATH.WPINC.'/class-simplepie.php');
	}
	
    extract(shortcode_atts(array("src" => 'http://', "limit" => '3'), $atts));
    
    $feed = new SimplePie();
	$feed->set_feed_url($src);
	$feed->set_cache_location(null_cache_path());
  	$feed->init();
 	$feed->handle_content_type();
  	
  	$output = '<div class="rss-shortcode rss-shortcode-'.$post->ID.'">';
	$output .= '<ul>';
	foreach($feed->get_items(0, $limit) as $item){
		$output .= '<li><a href="'.$item->get_permalink().'">'.$item->get_title().'</a>'. "\n";
		$output .= '<p>'.substr($item->get_description(),0,180).'&hellip;</p></li>'."\n";
	}
	$output .= '</ul>';
    $output .= '</div>';

    return $output;
    
}
?>