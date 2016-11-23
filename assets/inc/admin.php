<?php

/***************************************************************
* Function null_optionsframework_after_validate
* After options framework update flush the rewrite rules to handle new post types
***************************************************************/

add_action('optionsframework_after_validate', 'null_optionsframework_after_validate');

function null_optionsframework_after_validate($data) {

	// flush rewrite rules to register altered post type settings (checks if new data is different to old data)
	if (isset($data['additional_post_types'])) {
		if (of_get_option('additional_post_types', array()) != $data['additional_post_types']) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}
	}
}

/***************************************************************
* Function null_required_plugins
* Does this theme require any plugins to work? can also make plugin recommendations - http://tgmpluginactivation.com/
***************************************************************/

if (!function_exists('tgmpa')) {
	load_template(get_template_directory() . '/assets/lib/class-tgm-plugin-activation.php');
}

add_action('tgmpa_register', 'null_required_plugins' );

function null_required_plugins() {

	// array of plugin arrays. required keys are name, slug and required. if the source is NOT from the .org repo, then source is also required.
	$plugins = array();

	// this is an example of how to include a plugin pre-packaged with a theme
	/*array(
		'name'                  => 'TGM Example Plugin', // The plugin name
		'slug'                  => 'tgm-example-plugin', // The plugin slug (typically the folder name)
		'source'                => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source
		'required'              => true, // If false, the plugin is only 'recommended' instead of required
		'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		'external_url'          => '', // If set, overrides default API URL and points to an external URL
	),
	*/

	// required plugins
	// less
	$plugins['less'] = array(
		'name'      		=> 'WP LESS',
		'slug'      		=> 'wp-less',
		'source'    		=> 'https://github.com/roborourke/wp-less/archive/master.zip',
		'required'			=> true,
		'force_activation' 	=> true,
	);

	// optional plugins - from my favourites http://profiles.wordpress.org/scottsweb
	// advanced custom fields
	$plugins['acf'] = array(
		'name'      		=> 'Advanced Custom Fields',
		'slug'      		=> 'advanced-custom-fields',
		'required'  		=> false,
	);

	// custom 404 page
	$plugins['custom-404-error-page'] = array(
		'name'      		=> 'Custom 404 Error Page',
		'slug'      		=> 'custom-404-error-page',
		'required'  		=> false,
	);

	// regenerate thumbnails
	$plugins['regenerate-thumbnails'] = array(
		'name'      => 'Regenerate Thumbnails',
		'slug'      => 'regenerate-thumbnails',
		'required'  => false,
	);

	// wordpress seo
	$plugins['wordpress-seo'] = array(
		'name'      => 'WordPress SEO',
		'slug'      => 'wordpress-seo',
		'required'  => false,
	);

	// google analyticator
	$plugins['google-analyticator'] = array(
		'name'      => 'Google Analyticator',
		'slug'      => 'google-analyticator',
		'required'  => false,
	);

	// duplicate widget
	$plugins['duplicate-widget'] = array(
		'name'      => 'Duplicate Widget',
		'slug'      => 'duplicate-widget',
		'required'  => false,
	);

	// wp no category base
	$plugins['wp-no-category-base'] = array(
		'name'      => 'WP No Category Base',
		'slug'      => 'wp-no-category-base',
		'required'  => false,
	);

	// jetpack
	$plugins['jetpack'] = array(
		'name'      => 'Jetpack',
		'slug'      => 'jetpack',
		'required'  => false,
	);

	// social - to test
	/*$plugins['social'] = array(
		'name'      => 'Social',
		'slug'      => 'social',
		'required'  => false,
	);*/

	// twitter-mentions-as-comments - to test
	/*$plugins['twitter-mentions-as-comments'] = array(
		'name'      => 'Twitter Mentions as Comments',
		'slug'      => 'twitter-mentions-as-comments',
		'required'  => false,
	);*/

	// wp-smushit
	$plugins['wp-smushit'] = array(
		'name'      => 'WP Smush.it',
		'slug'      => 'wp-smushit',
		'required'  => false,
	);

	// redirection
	$plugins['redirection'] = array(
		'name'      => 'Redirection',
		'slug'      => 'redirection',
		'required'  => false,
	);

	// shortcode developer - to test
	/*$plugins['shortcode-developer'] = array(
		'name'      => 'Shortcode Developer',
		'slug'      => 'shortcode-developer',
		'required'  => false,
	);*/

	// members
	$plugins['members'] = array(
		'name'      => 'Members',
		'slug'      => 'members',
		'required'  => false,
	);

	// performance
	// wp html compression
	$plugins['wp-html-compression'] = array(
		'name'      => 'WP-HTML-Compression',
		'slug'      => 'wp-html-compression',
		'required'  => false,
	);

	// usability
	// simple page ordering
	$plugins['spo'] = array(
		'name'      => 'Simple Page Ordering',
		'slug'      => 'simple-page-ordering',
		'required'  => false,
	);

	// wp help
	$plugins['wphelp'] = array(
		'name'      => 'WP Help',
		'slug'      => 'wp-help',
		'required'  => false,
	);

	// backup & security
	// if multisite recommend a different backup plugin
	if ( is_multisite() ) {
		$plugins['backwpup'] = array(
			'name'      => 'BackWPup',
			'slug'      => 'backwpup',
			'required'  => false,
		);
	} else {
		$plugins['backupwp'] = array(
			'name'      => 'BackUpWordPress',
			'slug'      => 'backupwordpress',
			'required'  => false,
		);
	}

	// wordpress file monitor plus
	$plugins['wordpress-file-monitor-plus'] = array(
		'name'      => 'WordPress File Monitor Plus',
		'slug'      => 'wordpress-file-monitor-plus',
		'required'  => false,
	);

	// bad behavior
	$plugins['bad-behavior'] = array(
		'name'      => 'Bad Behavior',
		'slug'      => 'bad-behavior',
		'required'  => false,
	);

	// if development mode is on then recommend some developer plugins
	if (of_get_option('development_mode', '0')) {

		// developer
		$plugins['developer'] = array(
			'name'      => 'Developer',
			'slug'      => 'developer',
			'required'  => false,
		);

		// debug bar transients
		$plugins['debug-bar-transients'] = array(
			'name'      => 'Debug Bar Transients',
			'slug'      => 'debug-bar-transients',
			'required'  => false,
		);
	}

	// array of configuration settings
	$settings = array(
		'domain'            => 'null',
		'default_path'      => '',                           	// default absolute path to pre-packaged plugins
		'parent_slug'  		=> 'plugins.php',         			// default parent menu slug
		'menu'              => 'install-compatible-plugins',   	// menu slug
		'has_notices'       => true,                         	// show admin notices or not
		'is_automatic'      => false,            				// automatically activate plugins after installation or not
		'message'           => '',               				// message to output right before the plugins table
		'strings'           => array(
			'page_title'                                => __('Compatible &amp; Recommended Plugins', 'null'),
			'menu_title'                                => __('Compatible Plugins', 'null'),
			'installing'                                => __('Installing Plugin: %s', 'null'), // %1$s = plugin name
			'oops'                                      => __('Something went wrong with the plugin API.', 'null'),
			'notice_can_install_required'               => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'null'), // %1$s = plugin name(s)
			'notice_can_install_recommended'            => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'null'), // %1$s = plugin name(s)
			'notice_cannot_install'                     => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'null' ), // %1$s = plugin name(s)
			'notice_can_activate_required'              => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'null' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'           => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'null' ), // %1$s = plugin name(s)
			'notice_cannot_activate'                    => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'null' ), // %1$s = plugin name(s)
			'notice_ask_to_update'                      => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'null' ), // %1$s = plugin name(s)
			'notice_cannot_update'                      => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'null' ), // %1$s = plugin name(s)
			'install_link'                              => _n_noop('Begin installing plugin', 'Begin installing plugins', 'null' ),
			'activate_link'                             => _n_noop('Activate installed plugin', 'Activate installed plugins', 'null' ),
			'return'                                    => __('Return to Theme Plugins Installer', 'null' ),
			'plugin_activated'                          => __('Plugin activated successfully.', 'null' ),
			'complete'                                  => __('All plugins installed and activated successfully. %s', 'null' ) // %1$s = dashboard link
		)
	);

	// return the settings and filter them in case a child theme needs to modify the defaults
	tgmpa(apply_filters('null_recommended_plugins', $plugins), apply_filters('null_recommended_plugins_settings', $settings));

}

/***************************************************************
* Function null_admin_body_class
* Improve the body class options in the admin
***************************************************************/

add_filter('admin_body_class', 'null_admin_body_class');

function null_admin_body_class( $classes ) {

	global $wp_roles;

	// current action
	if (isset($_GET['action'])) {
		$classes .= 'action-'.$_GET['action'];
	}

	// current post ID
	if (isset($_GET['post'])) {
		$classes .= ' ';
		$classes .= 'post-'.$_GET['post'];
	}

	// taxonomy
	if (isset($_GET['taxonomy'])) {
		$classes .= ' ';
		$classes .= 'tax-'.$_GET['taxonomy'];
	}

	// new post type & listing page
	if (isset($_GET['post_type'])) $post_type = $_GET['post_type'];
	if (isset($post_type)) {
		$classes .= ' ';
		$classes .= 'post-type-'.$post_type;
	}

	// editing a post type
	if (isset($_GET['post'])) {
		$post_query = $_GET['post'];
		$current_post_edit = get_post($post_query);
		$current_post_type = $current_post_edit->post_type;
		if (!empty($current_post_type)) {
			$classes .= ' ';
			$classes .= 'post-type-'.$current_post_type;
		}
	}

	// user role
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);

	if (isset($wp_roles->role_names[$role])) {
		$classes .= ' ';
		$classes .= 'role-'.strtolower(translate_user_role($wp_roles->role_names[$role]));
	}

	// absolute admin bar
	if (of_get_option('admin_bar_attachment', 'fixed') == 'absolute') {
		$classes .= ' ';
		$classes .= 'admin-bar-absolute';
	}

	// dragging of meta boxes disabled
	if (of_get_option('disable_drag_meta', '1')) {
		$classes .= ' ';
		$classes .= 'drag-meta-box-disabled';
	}

	return $classes;

}

/***************************************************************
* Disable WordPress upgrade and plugin upgrade notices for admins (dead after 3.2?)
***************************************************************/

if ((!current_user_can('update_plugins')) && (of_get_option('disable_updates','1'))) {

	// wordpress version # 3.0:
	add_filter('pre_site_transient_update_core', '__return_null');

	// plugins # 3.0:
	remove_action('load-update-core.php', 'wp_update_plugins');
	add_filter('pre_site_transient_update_plugins', '__return_null');

}

/***************************************************************
* Function null_admin_menu
* Customise the admin menu and load the helper class
***************************************************************/

add_action('admin_menu', 'null_admin_menu', 20);

function null_admin_menu() {

	global $menu, $submenu;

	if (!function_exists('add_admin_menu_section')) {
		load_template(get_template_directory() . '/assets/lib/class-admin-menu.php');
	}

	// when comments are disabled remove the discussion options and comments menu
	if (of_get_option('disable_comments', 0)) {
		remove_menu_page('edit-comments.php');
		remove_submenu_page('options-general.php','options-discussion.php');
	}

	do_action('null_admin_menu');

}

/***************************************************************
* Function null_disable_draggable_meta_boxes
* Disabled dragging and dropping on meta boxes - also modifies body class
***************************************************************/

if (of_get_option('disable_drag_meta', '1')) {
	add_action( 'admin_init', 'null_disable_draggable_meta_boxes' );
}

function null_disable_draggable_meta_boxes() {
	wp_deregister_script('postbox');
}

/***************************************************************
* Function null_hide_welcome_panel
* Remove the welcome message from the dashboard (3.3+)
***************************************************************/

if (of_get_option('disable_welcome', '1')) {
	add_action( 'load-index.php', 'null_hide_welcome_panel' );
}

function null_hide_welcome_panel() {

	$user_id = get_current_user_id();

	// multi-site site owner
	if ( 2 == get_user_meta( $user_id, 'show_welcome_panel', true ) )
		update_user_meta( $user_id, 'show_welcome_panel', 0 );

	// toggled to show or single site creator
	if ( 1 == get_user_meta( $user_id, 'show_welcome_panel', true ) )
		update_user_meta( $user_id, 'show_welcome_panel', 0 );
}

/***************************************************************
* Function null_remove_pointer_script & null_remove_pointer_style
* Remove the tooltip bubbles from the dashboard (3.3+) - should not interfere with other plugins
***************************************************************/

if (of_get_option('disable_pointers', '1')) {
	add_action('admin_init', 'null_remove_pointer_script');
}

function null_remove_pointer_script() {
	remove_action( 'admin_enqueue_scripts', array( 'WP_Internal_Pointers', 'enqueue_scripts' ) );
}

/***************************************************************
* Function null_remove_dashboard_widgets
* Remove unrequired dashboard widgets
***************************************************************/

add_action('wp_dashboard_setup', 'null_remove_dashboard_widgets');

function null_remove_dashboard_widgets() {

	// dashboard widget settings
	$widgets = of_get_option('dashboard_widgets');

	// browser update nag
	if ($widgets['dashboard_browser_nag'] == "0") { remove_meta_box('dashboard_browser_nag', 'dashboard', 'normal'); }

	// plugins widget
	if ($widgets['dashboard_plugins'] == "0") { remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); }

	// right now widget
	if ($widgets['dashboard_right_now'] == "0") { remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); }

	// recent comments widget
	if ($widgets['dashboard_recent_comments'] == "0") { remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); }

	// incoming links widget
	if ($widgets['dashboard_incoming_links'] == "0") { remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); }

	// primary rss widget
	if ($widgets['dashboard_primary'] == "0") { remove_meta_box('dashboard_primary', 'dashboard', 'side'); }

	// secondary rss widget
	if ($widgets['dashboard_secondary'] == "0") { remove_meta_box('dashboard_secondary', 'dashboard', 'side'); }

	// quickpress widget
	if ($widgets['dashboard_quick_press'] == "0") { remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); }

	// recent drafts widget
	if ($widgets['dashboard_recent_drafts'] == "0") { remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); }
}

/***************************************************************
* Function null_posts_columns
* Remove "comments" from pages overview if comments disabled
***************************************************************/

add_filter('manage_posts_columns', 'null_posts_columns');

function null_posts_columns($defaults) {

	if (of_get_option('disable_comments', 0)) {
		unset($defaults['comments']);
	}

	return $defaults;
}


/***************************************************************
* Function null_pages_columns
* Remove "comments" from pages overview if comments disabled
***************************************************************/

add_filter('manage_pages_columns', 'null_pages_columns');

function null_pages_columns($defaults) {

	if (of_get_option('disable_comments', 0)) {
		unset($defaults['comments']);
	}

	return $defaults;
}

/***************************************************************
* Functions null_remove_author_metabox & null_move_author_to_publish_metabox
* Move the author metabox into the publish meta box to save space
***************************************************************/

//add_action( 'admin_menu', 'null_remove_author_metabox' );
//add_action( 'post_submitbox_misc_actions', 'null_move_author_to_publish_metabox' );

function null_remove_author_metabox() {
	remove_meta_box( 'authordiv', 'post', 'normal' );
}

function null_move_author_to_publish_metabox() {
	global $post_ID;
	$post = get_post( $post_ID );
	echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
	post_author_meta_box( $post );
	echo '</div>';
}

/***************************************************************
* Function null_add_excerpts_to_pages
* All excerpt box to pages
***************************************************************/

//add_action( 'init', 'null_add_excerpts_to_pages' );

function null_add_excerpts_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

/***************************************************************
* Function null_ico_mime
* Support .ico file uploads
***************************************************************/

add_filter('upload_mimes','null_ico_mime');

function null_ico_mime($mimes) {

	$mimes['ico'] = "icon/x-icon";
	return $mimes;
}

/***************************************************************
* Function null_mce_editor_buttons & null_mce_editor_styles
* Add a custom classes drop down to the kitchen sink
***************************************************************/

add_filter('mce_buttons_2', 'null_mce_editor_buttons' );

function null_mce_editor_buttons( $buttons ) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}

add_filter('tiny_mce_before_init', 'null_mce_editor_styles');

function null_mce_editor_styles( $settings ) {

	$style_formats = array(
		array(
			'title' => __('Error', 'null'),
			'block' => 'div',
			'classes' => 'error',
			'wrapper' => true
		),
		array(
			'title' => __('Notice', 'null'),
			'block' => 'div',
			'classes' => 'notice',
			'wrapper' => true
		),
		array(
			'title' => __('Success', 'null'),
			'block' => 'div',
			'classes' => 'success',
			'wrapper' => true
		),
		array(
			'title' => __('Text Button', 'null'),
			'selector' => 'a',
			'classes' => 'a-button'
		),
		array(
			'title' => __('Loud', 'null'),
			'inline' => 'span',
			'classes' => 'loud',
		),
		array(
			'title' => __('Quiet', 'null'),
			'inline' => 'span',
			'classes' => 'quiet',
		),
		array(
			'title' => __('Highlight', 'null'),
			'inline' => 'span',
			'classes' => 'highlight'
		)
	);

	$settings['style_formats'] = json_encode($style_formats);

	return $settings;

}

/***************************************************************
* Use a custom stylesheet in the WordPress editor? + cache busting
* Not added when run as a child theme - add this to child theme instead
***************************************************************/

if (!is_child_theme()) {

	// is less compiling enabled or disabled?
	$type = (!class_exists('wp_less') ? 'css' : 'less');
	add_editor_style('assets/'.$type.'/wp-editor.'.$type);

}

/***************************************************************
* Function null_editor_style
* Cache bust TinyMCE editor styles - http://bit.ly/12Yz03u
***************************************************************/

add_filter('mce_css', 'null_editor_style');

function null_editor_style($css) {

	global $editor_styles;

	if (empty($css) or empty($editor_styles)) {
		return $css;
	}

	$mce_css   = explode( ',', $css );
	$style_uri = get_stylesheet_directory_uri();
	$style_dir = get_stylesheet_directory();

	// cache bust
	foreach ( $mce_css as & $css ) {
		if ( false === strpos( $css, 'ver=' ) ) {
			$css = add_query_arg( 'ver', NULL_CACHE_BUST, $css );
		}
	}

	return implode( ',', $mce_css );

}

/***************************************************************
* Function null_page_break_button
* Add the page break button to TinyMCE after more break button
***************************************************************/

add_filter('mce_buttons','null_page_break_button');

function null_page_break_button($mce_buttons) {

	if (of_get_option('page_break', '0')) {
		$pos = array_search('wp_more',$mce_buttons,true);
		if ($pos !== false) {
			$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
			$tmp_buttons[] = 'wp_page';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
		}
	}
	return $mce_buttons;
}

/***************************************************************
* Function null_remove_meta_boxes
* Remove commenting meta boxes if disabled
***************************************************************/

add_action('admin_init','null_remove_meta_boxes');

function null_remove_meta_boxes() {

	if (of_get_option('disable_comments', 0)) {

		// post trackbacks
		remove_meta_box('trackbacksdiv','post','normal');

		// post discussion
		remove_meta_box('commentstatusdiv','post','normal');

		// post comments
		remove_meta_box('commentsdiv','post','normal');

		// page tracbacks
		remove_meta_box('trackbacksdiv','page','normal');

		// page discussion
		remove_meta_box('commentstatusdiv','page','normal');

		// page comments
		remove_meta_box('commentsdiv','page','normal');

	}
}

/***************************************************************
* Function null_filter_options_framework
* Filter options framework settings
***************************************************************/

add_filter( 'optionsframework_menu', 'null_filter_options_framework' );

function null_filter_options_framework( $menu ) {
	$menu['menu_slug'] = 'null-options';
	return $menu;
};

/***************************************************************
* Function null_options_santiziation & null_sanitize_text_field & null_sanitize_textarea_field & null_sanitize_upload
* Modify the options framework to validate differently
***************************************************************/

add_action('admin_init','null_options_santiziation', 100);

function null_options_santiziation() {

	// small amounts of html on text inputs
	remove_filter('of_sanitize_text', 'sanitize_text_field');
	add_filter('of_sanitize_text', 'null_sanitize_text_field', 20, 2);

	// allow JS in textarea inputs
	remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	add_filter( 'of_sanitize_textarea', 'null_sanitize_textarea_field' );

	// validate URLs in file upload fields
	add_filter( 'of_sanitize_upload', 'null_sanitize_upload', 20, 2);

}

function null_sanitize_text_field($input, $option) {

	$output = wp_kses_data($input);

	if ($option['id'] == 'delicious') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'dribbble') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'facebook') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'flickr') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'github') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'googleplus') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'instagram') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'linkedin') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'pinterest') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'soundcloud') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'twitter') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'vimeo') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'youtube') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'login_redirect_url') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'logout_redirect_url') $output = esc_url_raw($input, array('http', 'https'));

	return $output;
}

function null_sanitize_textarea_field($input) {
	global $allowedposttags;
	$custom_allowedtags["script"] = array(
		"src" => array(),
		"type" => array(),
		"charset" => array()
	);
	$custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
	$output = wp_kses( $input, $custom_allowedtags);
	return $output;
}

function null_sanitize_upload($input, $option) {

	$output = $input;

	if ($option['id'] == 'logo') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'favicon') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'touchicon') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'gravatar') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'iphone_splash') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'ipad_splash') $output = esc_url_raw($input, array('http', 'https'));
	if ($option['id'] == 'ipad_splash_landscape') $output = esc_url_raw($input, array('http', 'https'));

	return $output;
}

/***************************************************************
* Function null_optionsframework_custom_scripts
* Custom js for the admin panel options
***************************************************************/

add_action('optionsframework_custom_scripts', 'null_optionsframework_custom_scripts');

function null_optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	// post formats
	jQuery('#post_formats').click(function() {
		jQuery('#section-post_format_types').fadeToggle(400);
	});

	if (jQuery('#post_formats:checked').val() !== undefined) {
		jQuery('#section-post_format_types').show();
	} else {
		jQuery('#section-post_format_types').hide();
	}

	// development mode / holmes
	jQuery('#development_mode').click(function() {
		jQuery('#section-development_mode_holmes').fadeToggle(400);
	});

	if (jQuery('#development_mode:checked').val() !== undefined) {
		jQuery('#section-development_mode_holmes').show();
	} else {
		jQuery('#section-development_mode_holmes').hide();
	}

});
</script>
<?php
}

/***************************************************************
* Class null_user_caps
* Protect agains user level promotion by shop managers
***************************************************************/

$null_user_caps = new null_user_caps();

class null_user_caps {

	// Add our filters
	function __construct() {
		add_filter( 'editable_roles', array(&$this, 'editable_roles'));
		add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
	}

	// Remove 'Administrator' from the list of roles if the current user is not an admin
	function editable_roles( $roles ){
		if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
			unset( $roles['administrator']);
		}
		return $roles;
	}

	// If someone is trying to edit or delete and admin and that user isn't an admin, don't allow it
	function map_meta_cap( $caps, $cap, $user_id, $args ){

		switch( $cap ){
			case 'edit_user':
			case 'remove_user':
			case 'promote_user':

				if( isset($args[0]) && $args[0] == $user_id )
					break;
				elseif( !isset($args[0]) )
					$caps[] = 'do_not_allow';
					$other = new WP_User( absint($args[0]) );

				if( $other->has_cap( 'administrator' ) ){
					if(!current_user_can('administrator')){
						$caps[] = 'do_not_allow';
					}
				}

			break;

			case 'delete_user':
			case 'delete_users':

				if( !isset($args[0]) )
					break;
					$other = new WP_User( absint($args[0]) );
					if( $other->has_cap( 'administrator' ) ){
						if(!current_user_can('administrator')){
							$caps[] = 'do_not_allow';
						}
					}
			break;
			default:
			break;
		}
		return $caps;
	}
}

/***************************************************************
* Function null_hide_profile_fields
* Hide unwanted profile information
***************************************************************/

add_filter('user_contactmethods', 'null_hide_profile_fields', 10, 1);

function null_hide_profile_fields($contactmethods) {

	// remove unwanted
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	return $contactmethods;

}

/***************************************************************
* Function null_gravatar
* Add a custom avatar option
***************************************************************/

add_filter( 'avatar_defaults', 'null_gravatar' );

function null_gravatar($avatar_defaults) {

	if ($gravatar = of_get_option('gravatar')) {
		$avatar = $gravatar;
	} else {
		$avatar = get_template_directory_uri() . '/assets/images/apple-touch-icon-precomposed.png';
	}

	$avatar_defaults[$avatar] = __('Custom Avatar', 'null');

	return $avatar_defaults;
}

/***************************************************************
* Function all_settings_link
* Enable a hidden menu for Admins called "All Settings"
***************************************************************/

add_action('admin_menu', 'null_all_settings_link');

function null_all_settings_link() {
	if (of_get_option('all_settings', '0') && current_user_can('administrator')) {
		add_options_page(__('All Settings', 'null'), __('All Settings', 'null'), 'manage_options', 'options.php');
	}
}
