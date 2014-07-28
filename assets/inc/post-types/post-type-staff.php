<?php
/*
Post Type Name: Staff
*/

/***************************************************************
* Function register_staff
* Register staff post type
***************************************************************/

add_action('init', 'null_register_staff');

function null_register_staff() {

	$labels = array(
		'name'                          => __('Departments', 'null'),
		'singular_name'                 => __('Department', 'null'),
		'search_items'                  => __('Search Departments', 'null'),
		'popular_items'                 => __('Popular Departments', 'null'),
		'all_items'                     => __('All Departments', 'null'),
		'parent_item'                   => __('Parent Department', 'null'),
		'edit_item'                     => __('Edit Department', 'null'),
		'update_item'                   => __('Update Department', 'null'),
		'add_new_item'                  => __('Add New Department', 'null'),
		'new_item_name'                 => __('New Department', 'null'),
		'separate_items_with_commas'    => __('Separate Departments with commas', 'null'),
		'add_or_remove_items'           => __('Add or remove Departments', 'null'),
		'choose_from_most_used'         => __('Choose from most used Departments', 'null')
	);

	$args = array(
		'label'							=> __('Departments', 'null'),
		'labels'                        => $labels,
		'public'                        => true,
		'hierarchical'                  => true,
		'show_ui'                       => true,
		'show_in_nav_menus'             => true,
		'args'                          => array('orderby' => 'term_order'),
		'rewrite'                       => array('slug' => 'staff/department', 'with_front' => false),
		'query_var'                     => true
	);

	register_taxonomy('departments', 'staff', $args);

	$labels = array(
		'name' 							=> __('Staff', 'null'),
		'singular_name' 				=> __('Staff', 'null'),
		'add_new' 						=> __('Add Staff', 'null'),
		'add_new_item' 					=> __('Add Staff', 'null'),
		'edit_item' 					=> __('Edit Staff', 'null'),
		'new_item' 						=> __('New Staff', 'null'),
		'view_item' 					=> __('View', 'null'),
		'search_items' 					=> __('Search Staff', 'null'),
		'not_found' 					=> __('No staff found','null'),
		'not_found_in_trash' 			=> __('No staff found in Trash','null'),
		'parent_item_colon' 			=> '',
		'menu_name' 					=> __('Staff','null'),
		'all_items'						=> __('Staff', 'null')
	);

	$args = array(
		//'menu_position' 				=> 8,
		'label' 						=> __('Staff','null'),
		'labels' 						=> $labels,
		'public' 						=> true,
		'can_export'					=> true,
		'show_ui' 						=> true,
		'_builtin' 						=> false,
		'_edit_link' 					=> 'post.php?post=%d',
		'menu_icon' 					=> 'dashicons-groups',
		'hierarchical'					=> true,
		'rewrite' 						=> array( "slug" => "staff", "with_front" => false ),
		'supports'						=> array('title', 'editor', 'thumbnail', 'revisions'),
		'taxonomies' 					=> array('departments'),
		'show_in_nav_menus' 			=> true,
		'has_archive' 					=> true
	);

	register_post_type('staff', $args);
}

?>