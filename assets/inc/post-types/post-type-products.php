<?php
/*
Post Type Name: Products
*/

/***************************************************************
* Function register_products
* Register product post type
***************************************************************/

add_action('init', 'null_register_products');

function null_register_products() {
	
	$labels = array(
		'name'                          => __('Categories', 'null'),
		'singular_name'                 => __('Product Category', 'null'),
		'search_items'                  => __('Search Product Categories', 'null'),
		'popular_items'                 => __('Popular Categories', 'null'),
		'all_items'                     => __('All Product Categories', 'null'),
		'parent_item'                   => __('Parent Category', 'null'),
		'edit_item'                     => __('Edit Product Category', 'null'),
		'update_item'                   => __('Update Product Category', 'null'),
		'add_new_item'                  => __('Add New Product Category', 'null'),
		'new_item_name'                 => __('New Product Category', 'null'),
		'separate_items_with_commas'    => __('Separate categories with commas', 'null'),
		'add_or_remove_items'           => __('Add or remove Product Categories', 'null'),
		'choose_from_most_used'         => __('Choose from most used Product Categories', 'null')
	);
	
	$args = array(
		'label'							=> __('Categories', 'null'),
		'labels'                        => $labels,
		'public'                        => true,
		'hierarchical'                  => true,
		'show_ui'                       => true,
		'show_in_nav_menus'             => true,
		'args'                          => array('orderby' => 'term_order'),
		'rewrite'                       => array('slug' => 'product/category', 'with_front' => false),
		'query_var'                     => true
	);
	
	register_taxonomy('product_category', 'products', $args);

	$labels = array(
		'name'                          => __('Features', 'null'),
		'singular_name'                 => __('Product Features', 'null'),
		'search_items'                  => __('Search Product Features', 'null'),
		'popular_items'                 => __('Popular Features', 'null'),
		'all_items'                     => __('All Product Features', 'null'),
		'parent_item'                   => __('Parent Product Feature', 'null'),
		'edit_item'                     => __('Edit Product Feature', 'null'),
		'update_item'                   => __('Update Product Feature', 'null'),
		'add_new_item'                  => __('Add New Product Feature', 'null'),
		'new_item_name'                 => __('New Product Feature', 'null'),
		'separate_items_with_commas'    => __('Separate features with commas', 'null'),
		'add_or_remove_items'           => __('Add or remove Product Features', 'null'),
		'choose_from_most_used'         => __('Choose from most used Product Features', 'null')
	);
	
	$args = array(
		'label'							=> __('Features', 'null'),
		'labels'                        => $labels,
		'public'                        => true,
		'hierarchical'                  => true,
		'show_ui'                       => true,
		'show_in_nav_menus'             => true,
		'args'                          => array('orderby' => 'term_order'),
		'rewrite'                       => array('slug' => 'product/product-feature', 'with_front' => false),
		'query_var'                     => true
	);
	
	register_taxonomy('product_feature', 'products', $args);
	
	$labels = array(
	    'name' 							=> __('Products', 'null'),
	    'singular_name' 				=> __('Product', 'null'),
	    'add_new' 						=> __('Add Product', 'null'),
	    'add_new_item' 					=> __('Add New Product', 'null'),
	    'edit_item' 					=> __('Edit Product', 'null'),
	    'new_item' 						=> __('New Product', 'null'),
	    'view_item' 					=> __('View Product', 'null'),
	    'search_items' 					=> __('Search Products', 'null'),
	    'not_found' 					=> __('No products found','null'),
	    'not_found_in_trash' 			=> __('No products found in Trash','null'),
	    'parent_item_colon' 			=> ''
	);
	
	$args = array(
		//'menu_position' 				=> 8,
	    'label' 						=> __('Products','null'),
	    'labels' 						=> $labels,
	    'public' 						=> true,
	    'can_export'					=> true,
	    'show_ui' 						=> true,
	    '_builtin' 						=> false,
	    '_edit_link' 					=> 'post.php?post=%d',
	    'menu_icon' 					=> get_template_directory_uri() .'/assets/images/icon-post-type-products.png',
	    'hierarchical'					=> true,
	    'rewrite' 						=> array( "slug" => "product", "with_front" => false ),
	    'supports'						=> array('title', 'editor', 'thumbnail', 'revisions'),
	    'taxonomies' 					=> array('product_category', 'product_feature'),
	    'show_in_nav_menus' 			=> true,
	    'has_archive' 					=> true
	);
	
	register_post_type('products', $args);
}

?>