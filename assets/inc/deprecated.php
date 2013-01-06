<?php

global $wp_version;

/***************************************************************
* Function null_sort_query_by_post_in
* Add an extra sort option to WP_Query: post__in order - http://bit.ly/aV1tNJ
* Deprecated in 3.5 as this is now part of core
***************************************************************/

if ($wp_version < 3.5) {

add_filter('posts_orderby', 'null_sort_query_by_post_in', 10, 2); 

function null_sort_query_by_post_in( $sortby, $thequery ) {
	if (!empty($thequery->query['post__in']) && isset($thequery->query['orderby']) && $thequery->query['orderby'] == 'post__in')
		$sortby = "find_in_set(ID, '" . implode( ',', $thequery->query['post__in'] ) . "')";
	return $sortby;
}}

?>