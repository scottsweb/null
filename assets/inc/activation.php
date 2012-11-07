<?php

global $pagenow;

/***************************************************************
* Function null_theme_activated
* Custom activation message for the framework 
***************************************************************/

if ( is_admin() && isset($_GET['activated']) && $pagenow == "themes.php" ) {
	add_action('admin_notices', 'null_theme_activated');
}

function null_theme_activated() {
	
	$output = '';
	$optionsframework = get_option('optionsframework');
	
	// if theme options already exist then simply reactivate
	if(get_option($optionsframework['id'])) {
		$output .= '<div id="null-activated" class="updated">';
		$output .= '<p>'.__('null successfully re-activated.', 'null').'</p>';
		$output .= '</div>';
	// else show hints
	} else {
		$output .= '<div id="null-activated" class="updated">';
		$output .= '<p>'.__('null successfully activated. Before you get started setting up your new website would you like us to configure WordPress for you?', 'null').'</p>';
		$output .= '<p><a class="button-primary" href="' . admin_url('themes.php?setup=true') . '">'.__('Yes! Setup WordPress', 'null').'</a>';
		$output .= '<a class="button-secondary" href="' . admin_url('themes.php?page=options-framework') . '">'.__('No Thanks','null').'</a></p>';
		$output .= '</div>';
	}
	echo $output;
}

/***************************************************************
* Function null_activate & null_theme_setup_complete
* Setup WordPress defaults on theme activation - feel like this needs some security?
***************************************************************/

if (is_admin() && 'themes.php' === $pagenow && isset($_GET['setup'])) {
	null_activate();
}

function null_activate() {
	
	global $wp_rewrite;
	
	// only run this for administrators
	if (!current_user_can('manage_options')) return;
	
	// on theme activation make sure there's a Home page
	// create it if there isn't and set the Home page menu order to -1
	// set WordPress to have the front page display the Home page as a static page
	$default_pages = array('Home', 'Blog');
	$existing_pages = get_pages();

	foreach ($existing_pages as $page) {
		$temp[] = $page->post_title;
	}

  	$pages_to_create = array_diff($default_pages, $temp);

	foreach ($pages_to_create as $new_page_title) {
	
		// create post object
		$add_default_pages = array();
		$add_default_pages['post_title'] = $new_page_title;
		$add_default_pages['post_content'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consequat, orci ac laoreet cursus, dolor sem luctus lorem, eget consequat magna felis a magna. Aliquam scelerisque condimentum ante, eget facilisis tortor lobortis in. In interdum venenatis justo eget consequat. Morbi commodo rhoncus mi nec pharetra. Aliquam erat volutpat. Mauris non lorem eu dolor hendrerit dapibus. Mauris mollis nisl quis sapien posuere consectetur. Nullam in sapien at nisi ornare bibendum at ut lectus. Pellentesque ut magna mauris. Nam viverra suscipit ligula, sed accumsan enim placerat nec. Cras vitae metus vel dolor ultrices sagittis. Duis venenatis augue sed risus laoreet congue ac ac leo. Donec fermentum accumsan libero sit amet iaculis. Duis tristique dictum enim, ac fringilla risus bibendum in. Nunc ornare, quam sit amet ultricies gravida, tortor mi malesuada urna, quis commodo dui nibh in lacus. Nunc vel tortor mi. Pellentesque vel urna a arcu adipiscing imperdiet vitae sit amet neque. Integer eu lectus et nunc dictum sagittis. Curabitur commodo vulputate fringilla. Sed eleifend, arcu convallis adipiscing congue, dui turpis commodo magna, et vehicula sapien turpis sit amet nisi.';
		$add_default_pages['post_status'] = 'publish';
		$add_default_pages['post_type'] = 'page';
		
		// insert the post into the database
		$result = wp_insert_post($add_default_pages);	
	}
	
	$home = get_page_by_title('Home');
	update_option('show_on_front', 'page');
	update_option('page_on_front', $home->ID);
	
	$home_menu_order = array();
	$home_menu_order['ID'] = $home->ID;
	$home_menu_order['menu_order'] = -1;
	wp_update_post($home_menu_order);
	
	$blog = get_page_by_title('Blog');
	update_option('page_for_posts', $blog->ID);	
	
	// set the permalink structure
	if (get_option('permalink_structure') != '/%postname%/') { 
		update_option('permalink_structure', '/%postname%/');
	}

	$wp_rewrite->init();
	$wp_rewrite->flush_rules();	
	
	// don't organize uploads by year and month
	update_option('uploads_use_yearmonth_folders', 0);
	//update_option('upload_path', 'assets');
	update_option('upload_url_path', site_url('/uploads'));
	
	// automatically create menus and set their locations
	// add all pages to the Primary Navigation
	if (!has_nav_menu('navigation')) {
		$nav_id = wp_create_nav_menu('Navigation', array('slug' => 'navigation'));
	}
	
	if (!has_nav_menu('footer_navigation')) {
		$footer_nav_id = wp_create_nav_menu('Footer', array('slug' => 'footer_navigation'));
	}
	
	set_theme_mod('nav_menu_locations', array(
		'navigation' => $nav_id, 
		'footer' => $footer_nav_id
	));	

	$nav = wp_get_nav_menu_object('Navigation');
	$nav_term_id = (int) $nav->term_id;	
	$pages = get_pages();
	foreach($pages as $page) {
		$item = array(
			'menu-item-object-id' => $page->ID,
			'menu-item-object' => 'page',
			'menu-item-type' => 'post_type',
			'menu-item-status' => 'publish'
		);
		wp_update_nav_menu_item($nav_term_id, 0, $item);
	}
	
	// create a cache folder if it does not exist
	$cache = null_cache_path();
	unset($cache);
	
	// action for activation
	do_action('null_theme_activation');
			
	// show feedback
	add_action('admin_notices', 'null_theme_setup_complete');

}

/***************************************************************
* Function null_footer_menu & null_footer_menu_fallback
* Build the footer menu and a suitable fallback
***************************************************************/

function null_theme_setup_complete() {
	
	$output  = '';
	$output .= '<div id="null-activated" class="updated">';
	$output .= '<p>'.__('WordPress setup complete.', 'null').'</p>';
	$output .= '<p><a class="button-primary" href="' . admin_url('themes.php?page=options-framework') . '">'.__('Theme Options','null').'</a></p>';
	$output .= '</div>';
	echo $output;
	
}
?>