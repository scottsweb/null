<?php
/*
Post Type Name: Portfolio
*/

/***************************************************************
* Function register_portfolio
* Register portfolio post type
***************************************************************/

add_action('init', 'null_register_portfolio');

function null_register_portfolio() {

	$labels = array(
		'name'                          => __('Categories', 'null'),
		'singular_name'                 => __('Portfolio Category', 'null'),
		'search_items'                  => __('Search Portfolio Categories', 'null'),
		'popular_items'                 => __('Popular Categories', 'null'),
		'all_items'                     => __('All Portfolio Categories', 'null'),
		'parent_item'                   => __('Parent Category', 'null'),
		'edit_item'                     => __('Edit Portfolio Category', 'null'),
		'update_item'                   => __('Update Portfolio Category', 'null'),
		'add_new_item'                  => __('Add New Portfolio Category', 'null'),
		'new_item_name'                 => __('New Portfolio Category', 'null'),
		'separate_items_with_commas'    => __('Separate categories with commas', 'null'),
		'add_or_remove_items'           => __('Add or remove Portfolio Categories', 'null'),
		'choose_from_most_used'         => __('Choose from most used Portfolio Categories', 'null')
	);
	
	$args = array(
		'label'							=> __('Categories', 'null'),
		'labels'                        => $labels,
		'public'                        => true,
		'hierarchical'                  => true,
		'show_ui'                       => true,
		'show_in_nav_menus'             => true,
		'args'                          => array('orderby' => 'term_order'),
		'rewrite'                       => array('slug' => 'portfolio/category', 'with_front' => false),
		'query_var'                     => true
	);
	
	register_taxonomy('portfolio_category', 'portfolio', $args);
	
	$labels = array(
	    'name' 							=> __('Projects', 'null'),
	    'singular_name' 				=> __('Portfolio Project', 'null'),
	    'add_new' 						=> __('Add Project', 'null'),
	    'add_new_item' 					=> __('Add Project', 'null'),
	    'edit_item' 					=> __('Edit Project', 'null'),
	    'new_item' 						=> __('New Project', 'null'),
	    'view_item' 					=> __('View', 'null'),
	    'search_items' 					=> __('Search Projects', 'null'),
	    'not_found' 					=> __('No projects found','null'),
	    'not_found_in_trash' 			=> __('No projects found in Trash','null'),
	    'parent_item_colon' 			=> '',
	    'menu_name' 					=> __('Portfolio','null')
	);
	
	$args = array(
		//'menu_position' 				=> 8,
	    'label' 						=> __('Portfolio','null'),
	    'labels' 						=> $labels,
	    'public' 						=> true,
	    'can_export'					=> true,
	    'show_ui' 						=> true,
	    '_builtin' 						=> false,
	    '_edit_link' 					=> 'post.php?post=%d',
	    'menu_icon' 					=> get_template_directory_uri() .'/assets/images/icon-post-type-portfolio.png',
	    'hierarchical'					=> true,
	    'rewrite' 						=> array( "slug" => "portfolio", "with_front" => false ),
	    'supports'						=> array('title', 'editor', 'thumbnail', 'revisions'),
	    'taxonomies' 					=> array('portfolio_category'),
	    'show_in_nav_menus' 			=> true,
	    'has_archive' 					=> true
	);
	
	register_post_type('portfolio', $args);
}

?>