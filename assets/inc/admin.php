<?php

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
    // advanced custom fields
    $plugins[] = array(
        'name'      		=> 'Advanced Custom Fields',
        'slug'      		=> 'advanced-custom-fields',
        'required'  		=> true,
        'force_activation' 	=> true
    );       
    
    // optional plugins
    // wordpress seo
    $plugins[] = array(
        'name'      => 'WordPress SEO',
        'slug'      => 'wordpress-seo',
        'required'  => false,
    );
    
    // mobble
    $plugins[] = array(
        'name'      => 'mobble',
        'slug'      => 'mobble',
        'required'  => false,
    );

    // simple page ordering
    $plugins[] = array(
        'name'      => 'Simple Page Ordering',
        'slug'      => 'simple-page-ordering',
        'required'  => false,
    );
    
    // duplicate widget
    $plugins[] = array(
        'name'      => 'Duplicate Widget',
        'slug'      => 'duplicate-widget',
        'required'  => false,
    );

    // wordpress file monitor plus
    $plugins[] = array(
        'name'      => 'WordPress File Monitor Plus',
        'slug'      => 'wordpress-file-monitor-plus',
        'required'  => false,
    );
    
    // wordfence
    $plugins[] = array(
        'name'      => 'Wordfence Security',
        'slug'      => 'wordfence',
        'required'  => false,
    );
    
    // drag and drop featured image
    $plugins[] = array(
        'name'      => 'Drag & Drop Featured Image',
        'slug'      => 'drag-drop-featured-image',
        'required'  => false,
    );

    // jetpack
    $plugins[] = array(
        'name'      => 'Jetpack',
        'slug'      => 'jetpack',
        'required'  => false,
    );
    
    // relevanssi
    /*$plugins[] = array(
        'name'      => 'Relevanssi',
        'slug'      => 'relevanssi',
        'required'  => false,
    );*/
    
    // search everything
    $plugins[] = array(
        'name'      => 'Search Everything',
        'slug'      => 'search-everything',
        'required'  => false,
    );    
    
    // w3 total cache
    $plugins[] = array(
        'name'      => 'W3 Total Cache',
        'slug'      => 'w3-total-cache',
        'required'  => false,
    ); 
  
    // wp super cache
    /*$plugins[] = array(
        'name'      => 'WP Super Cache',
        'slug'      => 'wp-super-cache',
        'required'  => false,
    );*/ 
    
    // wp help
    $plugins[] = array(
        'name'      => 'WP Help',
        'slug'      => 'wp-help',
        'required'  => false,
    ); 
    
    // backup tool
    // if multisite recommend a different backup plugin
    if ( is_multisite() ) {
	    $plugins[] = array(
	        'name'      => 'BackWPup',
	        'slug'      => 'backwpup',
	        'required'  => false,
	    ); 
	} else {
	    $plugins[] = array(
	        'name'      => 'BackUpWordPress',
	        'slug'      => 'backupwordpress',
	        'required'  => false,
	    ); 
    }
    
    // if development mode is on then recommend some developer plugins
    if (of_get_option('development_mode', '0')) { 
    	
    	// developer
	    $plugins[] = array(
	        'name'      => 'Developer',
	        'slug'      => 'developer',
	        'required'  => false,
	    ); 
    
	    // theme check
	    $plugins[] = array(
	        'name'      => 'Theme-Check',
	        'slug'      => 'theme-check',
	        'required'  => false,
	    );
	}  
 
    $theme_text_domain = 'null';
 
    // array of configuration settings
    $settings = array(
        'domain'            => $theme_text_domain,           
        'default_path'      => '',                           	// default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'plugins.php',         			// default parent menu slug
        'parent_url_slug'   => 'plugins.php',         			// default parent URL slug
        'menu'              => 'install-required-plugins',   	// menu slug
        'has_notices'       => true,                         	// show admin notices or not
        'is_automatic'      => false,            				// automatically activate plugins after installation or not
        'message'           => '',               				// message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => __('Required/Recommended Plugins', $theme_text_domain),
            'menu_title'                                => __('Theme Plugins', $theme_text_domain),
            'installing'                                => __('Installing Plugin: %s', $theme_text_domain), // %1$s = plugin name
            'oops'                                      => __('Something went wrong with the plugin API.', $theme_text_domain),
            'notice_can_install_required'               => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.'), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.'), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop('Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                             => _n_noop('Activate installed plugin', 'Activate installed plugins' ),
            'return'                                    => __('Return to Theme Plugins Installer', $theme_text_domain ),
            'plugin_activated'                          => __('Plugin activated successfully.', $theme_text_domain ),
            'complete'                                  => __('All plugins installed and activated successfully. %s', $theme_text_domain ) // %1$s = dashboard link
        )
    );
    
    // return the settings and filter them in case a child theme needs to modify the defaults
    tgmpa(apply_filters('null_required_plugins', $plugins), apply_filters('null_required_plugins_settings', $settings));
 
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

if ((!current_user_can('update_plugins')) && (of_get_option('disable_updates'))) {  
	
	// wordpress version # 3.0:
	add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ));
	
	// plugins # 3.0:
	remove_action('load-update-core.php', 'wp_update_plugins' );
	add_filter('pre_site_transient_update_plugins', create_function( '$a', "return null;" ));	
	
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
	
	if (of_get_option('disable_comments', 0)) {
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
* Use a custom stylesheet in the WordPress editor? + cache busting
* Not added when run as a child theme - add this to child theme instead
***************************************************************/

if (get_stylesheet_directory() == get_template_directory()) {

	// is less compiling enabled or disabled?
	$type = (of_get_option('disable_less', '0') ? 'css' : 'less');
		
	add_editor_style('assets/'.$type.'/wp-editor.'.$type);
	//add_editor_style('assets/css/wp-editor.less?' . time());
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
* Function null_framework_check_for_update
* Check for a framework automatic update - API needs to be finished for v1
***************************************************************/

add_filter('pre_set_site_transient_update_themes', 'null_framework_check_for_update');

function null_framework_check_for_update($checked_data) {
	
	global $wp_version;

	$request = array(
		'slug' => get_option('template'),
		'version' => NULL_VERSION
	);
	// Start checking for an update
	$send_for_check = array(
		'body' => array(
			'action' => 'theme_update', 
			'request' => serialize($request),
			'api-key' => md5(site_url())
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . site_url()
	);
		
	$raw_response = wp_remote_post('http://scott.ee/api/', $send_for_check);
		
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);
	
	// Feed the update data into WP updater
	if (!empty($response)) 
		$checked_data->response[get_option('template')] = $response;
	
	return $checked_data;
}

/***************************************************************
* Function null_options_santiziation & null_sanitize_text_field & null_sanitize_textarea_field
* Modify the options framework to validate differently
***************************************************************/

add_action('admin_init','null_options_santiziation', 100);
 
function null_options_santiziation() {

  	// small amounts of html on text inputs
    remove_filter('of_sanitize_text', 'sanitize_text_field');
	add_filter('of_sanitize_text', 'null_sanitize_text_field');
	
	// allow JS in textarea inputs
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'null_sanitize_textarea_field' );
	
}
 
function null_sanitize_text_field($input) {
    $output = wp_kses_data($input);
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

	// html compression
	jQuery('#html_compression').click(function() {
  		jQuery('#section-html_compression_options').fadeToggle(400);
	});
	
	if (jQuery('#html_compression:checked').val() !== undefined) {
		jQuery('#section-html_compression_options').show();
	} else {
		jQuery('#section-html_compression_options').hide();
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
	function null_user_caps(){
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
?>