<?php
/*
Shortcode Name: Related Posts [related_posts limit="5"]
*/

/***************************************************************
* Function null_related_posts
* A shortcode that related posts based on tag. Usage: [related_posts limit="5"]
***************************************************************/

add_shortcode('related_posts', 'null_related_posts');

function null_related_posts( $atts ) {
	
	extract(shortcode_atts(array('limit' => '5'), $atts));

	global $wpdb, $post, $table_prefix;
		
	if ($post->post_type != "post") { return false; }

	if ($post->ID) {
		$retval = '<div class="related-posts-shortcode related-posts-shortcode-'.$post->ID.'">';
		$retval .= '<h4>'.__('Related Posts', 'null').'</h4>';
		$retval .= '<ul>';
		
 		// get tags
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);

		// do the query
		$q = "SELECT p.*, count(tr.object_id) as count
			 FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
 			 GROUP BY tr.object_id
			 ORDER BY count DESC, p.post_date_gmt DESC
			 LIMIT $limit;";

		$related = $wpdb->get_results($q);
 		if ( $related ) {
			foreach($related as $r) {
				$retval .= '<li><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></li>';
			}
		} else {
			$retval .= '<li>'.__('No related posts found.', 'null').'</li>';
		}
		$retval .= '</ul>';
		$retval .= '</div>';
		return $retval;
	}
	return;
}
?>