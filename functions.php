<?php

	/*
	
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	888888888$1||120888888110811081108888888
	88888880;  ;;' '288880  20  20  28888888
	88888881 '08881  08880  20  20  28888888
	8888888; :88882  08880  20  20  28888888
	8888888| :88882  08880  20  20  28888888
	8888888; :88880' ;2$2;  00  20  28888888
	88888881 ;8888801'   '|080: $0' $8888888
	8888888800888888880008888800880088888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
	8888888888888888888888888888888888888888
                                      
	Notes:
	-----------------------------------------
	
	future
	to-do: look through https://github.com/Automattic/_s
	to-do: http://gridster.net/ - build virtual templates via UI
	to-do: customise the admin bar? options for this (plugin?)
	to-do: option to toggle forced cropping on standard image sizes - better via plugin http://wordpress.org/extend/plugins/scissors/ OR better cropping?
	to-do: perhaps move to: http://wordpress.org/extend/plugins/option-tree/ for options? - not quite as good yet
	to-do: potential performance and debug script http://pbl.elgatonaranja.com/home
	to-do: a second take on responsive tables -> http://filamentgroup.com/examples/rwd-table-patterns/ / http://consulenza-web.com/jquery/MediaTable/?

	ongoing
	to-do: update language files
	to-do: update modernizr
	to-do: update less compiler 0.3.5+ - hopfully will work again and provide css compression
		   - add back font choice options when this gets fixed

	for 1.0
	to-do: https://github.com/clearleft/clearless - investigate clear less - might make a good less replacement OR bootstrap for css/less? http://twitter.github.com/bootstrap/ also http://bootswatch.com/
	to-do: less mixin ideas from compass http://compass-style.org/reference/compass/css3/ & https://github.com/dancrew32/lesslib/blob/master/mixins.less
	to-do: live bind shortcode JS for instant search compatibility
	to-do: a beautiful, minimal, responsive design - ideas: http://safe.tumblr.com/theme/preview/3292, 
	to-do: drop ie6 support, chrome frame etc when IE6 hits 5%
	to-do: bundle psds with zip for icon/image templates
	to-do: ability to disable built in post types and taxonomies and links (customise the WP menu - already a hook for this and always different?) - http://core.trac.wordpress.org/ticket/14761
	to-do: pre-configured site settings (so buddypress, multi site, multi author, client etc)
	to-do: bundle xml file import for WordPress (use wordpress import/export feature) - theme unit test?
	to-do: new feature tooltips restricted by user type (same code as with admin bar)
	to-do: table of contents generator improvements - choose to include and post type support
	to-do: http://vimeo.com/50590785 - compatibilty with live edit once released
	to-do: cron schedules to have there own options (enabled / disable)
	to-do: clean up gravity forms less and test with some forms
	to-do: pimp user profiles with tabs (from client work)?
	to-do: font effects? https://developers.google.com/webfonts/docs/getting_started#Effects
	to-do: a few new widgets (featured posts? - post type and taxonomy choice)
	to-do: better shortcodes & shortcode builder (see md theme)
	to-do: style and code for various post format types (chat, video, quote etc)
	to-do: meta boxes - use php exports from ACF and add them to post types (start with portfolio)
	to-do: custom fields in list view for custom post types (e.g. portfolio thumbnail, categories etc)
	to-do: improve gallery shortcode - css and filters tweaks - see chailey - make the built in gallery useful in more projects //http://wordpress.stackexchange.com/questions/4343/how-to-customise-the-output-of-the-wp-image-gallery-shortcode-from-a-plugin
	to-do: auto updater api (see admin.php)
	to-do: improve nav walker to provide better classes and support for other attributes
	to-do: standard placeholder image for admin - for list views etc
	to-do: if some settings are filtered away (eg custom header and background) the options appear. of_get_option always need a default value!!!
			- unset($options['login_redirect_url']);
			- unset($options['logout_redirect_url']);
			- unset($options['disable_less']);
			- unset($options['force_rewrite']); - check these first
	to-do: Implement a maintenance mode (as part of development mode?)
	to-do: move ie.css to less - lots of advantages including references to pie CSS will always work, colours etc
	to-do: can the automatic linking of emebedded images be disabled - attachment view is a waste of time
	to-do: test if inline js compression kills analyitcs (it appears to)
	to-do: look over https://github.com/wpmark/pxjn-framework / https://github.com/wpmark/pxlcore - especially the loop classes (move out of templates)
	to-do: auto updates from GitHub - https://github.com/UCF/Theme-Updater
	

	*/

	// load the options framework
	if (!function_exists( 'optionsframework_init' )) {
		define('OPTIONS_FRAMEWORK', get_template_directory() . '/assets/inc/options-framework/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/assets/inc/options-framework/');		
		load_template(OPTIONS_FRAMEWORK . 'options-framework.php');
		load_template(get_template_directory() . '/options.php'); // temporary fix for options framework & theme customiser http://wptheming.com/2012/07/options-framework-theme-customizer/
	}
	
	// set PHP timezone from WordPress settings
	if ($timezone = get_option('timezone_string')) date_default_timezone_set($timezone);
		
	// force WordPress rewrite - we have mod_rewrite installed on the server
	if (of_get_option('force_rewrite', '0')) add_filter('got_rewrite', '__return_true');
	
	// parse template info from css - version number
	$theme_data = wp_get_theme();
	define('NULL_VERSION', $theme_data['Version']);
		
	// load activation code
	locate_template('/assets/inc/activation.php', true, true);
	
	// set content width - see: http://toggl.es/wEBCFs - largely irrelevant with responsive sites?
	if (!isset($content_width)) $content_width = 656;

	/***************************************************************
	* Functions null_admin_bar_updates
	* Remove the updates notification from the admin bar for non admins
	***************************************************************/
	
	add_action('wp_before_admin_bar_render', 'null_admin_bar_updates', 25);
	
	function null_admin_bar_updates() {
		
		global $wp_admin_bar;

		if ((!current_user_can('update_plugins')) && (of_get_option('disable_updates', '1'))) {
			$wp_admin_bar->remove_menu('updates');
		}
		
	}

	/***************************************************************
	* Function null_howdy
	* Change Howdy? in the admin bar
	***************************************************************/
	
	add_filter('gettext', 'null_howdy', 10, 2 );
	
	function null_howdy($translation, $original) {
		
		if ($howdy = of_get_option('howdy')) {
			if ('Howdy, %1$s' == $original) {
				return $howdy.' %1$s';
			}
		}
		return $translation;
			
	}

	/***************************************************************
	* Function null_setup
	* Setup theme, languages, enable post thumbnail support & custom menus etc
	***************************************************************/
	
	add_action('after_setup_theme','null_setup');
	
	function null_setup() {
	
		// load language files for null framework
		load_theme_textdomain('null', get_template_directory() . '/assets/languages'); 		
 
 		// add support for custom header if setup
		if (of_get_option('custom_header', '1')) {
			if (is_wp_version( '3.4' )) {
				add_theme_support('custom-header'); 
			} else { 
				add_custom_image_header();
			}
		}
			
		// add support for custom backgrounds if setup
		if (of_get_option('custom_background', '1')) {
			if (is_wp_version( '3.4' )) {
				add_theme_support('custom-background'); 
			} else { 
				add_custom_background();
			}
		}
			
		// post-formats
		if (of_get_option('post_formats', '0')) {
			add_theme_support('post-formats');
			
			$formats = of_get_option('post_format_types');
			$supported = array();
			
			foreach ($formats as $key => $value) {
				if ($value == 1) $supported[] = $key;
			}

			add_theme_support('post-formats', $supported);
		}

		// add feed links for comments and posts to <head>	
		add_theme_support('automatic-feed-links');
	
		// setup thumbnail support
		add_theme_support( 'post-thumbnails' ); 
		
		// set defualt thumbnail size: the_post_thumbnail();
		set_post_thumbnail_size( 150, 150, true );
		
		// custom hook to easily register more image sizes
		do_action('null_register_image_size');
	
		// custom menu support
	    add_theme_support('menus');
	    
		// register navigation menus for this theme
		register_nav_menus(apply_filters('null_register_menu', array(
	  		  'navigation' => 'Navigation',
	  		  'footer' => 'Footer'
	  		)
	  	));
		
	}

	// load php less parser if enabled
	if (!of_get_option('disable_less', '0')) { locate_template('/assets/inc/less.php', true, true); }
		
	/***************************************************************
	* Function null_admin_css_setup
	* Register and enqueue all css/less files backend - http://toggl.es/tSgnfR
	***************************************************************/
	
	add_action('admin_enqueue_scripts', 'null_admin_css_setup');
	
	function null_admin_css_setup() {
		
		// use the blog_id for prefixing child-site specific css - not needed due to movement of cache?
		global $blog_id;
		
		// is less compiling enabled or disabled?
		$type = (of_get_option('disable_less', '0') ? 'css' : 'less');	
		
		// custom admin css
		wp_register_style('null-admin', get_template_directory_uri() . '/assets/'.$type.'/wp-admin.'.$type, '', filemtime(get_template_directory() . '/assets/'.$type.'/wp-admin.'.$type));
		wp_enqueue_style('null-admin');

		// action for adding or removing admin css
		do_action('null_admin_css');
	
	}
	
	/***************************************************************
	* Function null_theme_css_setup
	* Register and enqueue all css/less files frontend - http://toggl.es/tSgnfR
	***************************************************************/

	add_action('wp_enqueue_scripts', 'null_theme_css_setup');
	
	function null_theme_css_setup() {

		// use the blog_id for prefixing child-site specific tweaks - not needed due to movement of cache?
		global $blog_id;
		
		// is less compiling enabled or disabled?
		$type = (of_get_option('disable_less', '0') ? 'css' : 'less');

		// hack to cache bust theme customiser - seems to make it work in chrome
		if (isset($_POST['customize_messenger_channel'])) {
			$cachestamp = time();
		} else {
			$cachestamp = filemtime(get_template_directory() . '/assets/'.$type.'/screen.'.$type);
		}
		
		// register all css/less
		// grab the google font based on font settings
		$heading_font = of_get_option('heading_font', '');
		$body_font = of_get_option('body_font', '');
		$allfonts = null_get_fonts();
		$gfonts = array();
		
		if ($heading_font != '') {
			if (!null_string_search('(system)', $allfonts[$heading_font])) {
				$gfonts[] = $heading_font;
			}
		}
		
		//if (!null_string_search('(system)', $allfonts[$body_font])) {
		//	$gfonts[] = $body_font;
		//}
		
		if (!empty($gfonts)) { 
			$getfonts = implode('|', $gfonts);
			wp_register_style('google-font', 'http://fonts.googleapis.com/css?family='.$getfonts, '', null_slugify(NULL_VERSION), 'all'); 
			wp_enqueue_style('google-font');
		}		
		
		// the rest of the styles
		wp_register_style('null-screen', get_template_directory_uri() . '/assets/'.$type.'/screen.'.$type, array(), $cachestamp, 'screen');
		wp_register_style('holmes', get_template_directory_uri() . '/assets/css/holmes.css', array('null-screen'), filemtime(get_template_directory() . '/assets/css/holmes.css'), 'screen');
		wp_register_style('null-print', get_template_directory_uri() . '/assets/'.$type.'/print.'.$type, array(), filemtime(get_template_directory() . '/assets/'.$type.'/print.'.$type), 'print');
		
		// all styles for this theme
		wp_enqueue_style('null-screen');

		// holmes if in development mode and holmes is set
		if (of_get_option('development_mode_holmes', '0'))	wp_enqueue_style('holmes');

		// remove admin bar css for print media - added already
		remove_action('wp_head', 'wp_admin_bar_header');
		
		// print style sheet (including admin bar hide removed above)
		wp_enqueue_style('null-print');

		// action for adding or removing theme css
		do_action('null_theme_css');
		
	}

	/***************************************************************
	* Function null_login_css_setup
	* Add a custom stylesheet to the login (same CSS is also added to the admin)
	***************************************************************/
	
	add_action('login_enqueue_scripts', 'null_login_css_setup');
	
	function null_login_css_setup() {

		// use the blog_id for prefixing child-site specific tweaks - not needed due to movement of cache?
		global $blog_id;

		// is less compiling enabled or disabled?
		$type = (of_get_option('disable_less', '0') ? 'css' : 'less');
		
		// custom admin css
		wp_register_style('null-admin', get_template_directory_uri() . '/assets/'.$type.'/wp-admin.'.$type, '', filemtime(get_template_directory() . '/assets/'.$type.'/wp-admin.'.$type));
		wp_enqueue_style('null-admin');
	   
	}

	/***************************************************************
	* Function null_admin_js_setup
	* Register and enqueue all admin javascript files
	***************************************************************/
	
	add_action('admin_enqueue_scripts', 'null_admin_js_setup');
	
	function null_admin_js_setup() {

		// use the blog_id for prefixing child-site specific js
		global $blog_id;
		
		// action for adding or removing more js in the admin
		do_action('null_admin_js');
			
	}
		
	/***************************************************************
	* Function null_theme_js_setup
	* Register and enqueue all frontend javascript files
	***************************************************************/

	add_action('wp_enqueue_scripts', 'null_theme_js_setup');
	
	function null_theme_js_setup() {

		// use the blog_id for prefixing child-site specific js - not needed due to movement of cache?
		global $blog_id;
		
		//  grab settings
		$polyfills = of_get_option('polyfills');
			
		// register all scripts			
		wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.js', '', filemtime(get_template_directory() . '/assets/js/modernizr.js'));
		wp_register_script('superfish-menu', get_template_directory_uri() . '/assets/js/superfish.js', '', filemtime(get_template_directory() . '/assets/js/superfish.js'));
		wp_register_script('jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/jquery-ui.js'));
		wp_register_script('html5-forms', get_template_directory_uri() . '/assets/js/forms.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/forms.js'));
		wp_register_script('null', get_template_directory_uri() . '/assets/js/onload.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/onload.js'));
		
		// comment threading
		if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply');
		
		// standard shipped jquery
		wp_enqueue_script('jquery');
		
		// jquery ui (custom build to support tab shortcodes, accordions and a few extras)
		wp_enqueue_script('jquery-ui');
		
		// superfish if option set
		if ($polyfills['superfish'] == "1") wp_enqueue_script('superfish-menu');
		
		// always load modernizr as it contains HTML5 shiv
		wp_enqueue_script('modernizr');
		
		// html5 forms if option is set
		if ($polyfills['html5_forms'] == "1") wp_enqueue_script('html5-forms');
		
		// the onload/custom js file
		wp_enqueue_script('null');
		
		// action for adding or removing more js on the theme
		do_action('null_theme_js');
		
	}

	/***************************************************************
	* Function null_clean_login_logout
	* Tidy up our URLs for WordPress login and WordPress logout & alter redirects
	***************************************************************/
	
	add_filter('login_url', 'null_clean_login_logout');
	add_filter('logout_url', 'null_clean_login_logout');
		
	function null_clean_login_logout($url, $redirect='') {
		
		// logout		
		if (null_string_search('logout', $url)) {
			
			if (empty($redirect) && of_get_option('logout_redirect_url')) {
				$redirect = of_get_option('logout_redirect_url');
			}
			
			if (!is_multisite() && !is_child_theme() && of_get_option('cleanup', '0')) {
				$url = str_replace('wp-login.php', 'logout/', $url);
				if (empty($redirect)) {
					$redirect = get_option('siteurl') . '/wp-login.php?loggedout=true';
				}
			}
		
		// login	
		} else {
		
			if (!is_multisite() && !is_child_theme() && of_get_option('cleanup', '0')) {
				$url = str_replace('wp-login.php', 'login/', $url);
			}
			
			if (empty($redirect) && of_get_option('login_redirect_url')) {
				$redirect = of_get_option('login_redirect_url');
			}
		}
		
		if (!empty($redirect)) {
			$url = add_query_arg('redirect_to', urlencode($redirect), $url);
		}
		
		return $url;
	}

	/***************************************************************
	* Function null_get_extensions
	* Helper function for retrieving widgets, shortcodes and post-type extensions
	***************************************************************/
	
	function null_get_extensions($type = 'post-types', $settings = false) {
	
		switch($type) {
		
			// shortcodes
			case "shortcodes":
				
				$folder_base = trailingslashit(get_template_directory() . '/assets/inc/shortcodes');
				$folder_child = trailingslashit(get_stylesheet_directory() . '/assets/inc/shortcodes');
				$preg = '|Shortcode Name:(.*)$|mi';
				
			break;
			
			// widgets
			case "widgets":
	
				$folder_base = trailingslashit(get_template_directory() . '/assets/inc/widgets');
				$folder_child = trailingslashit(get_stylesheet_directory() . '/assets/inc/widgets');
				$preg = '|Widget Name:(.*)$|mi';
			
			break;
			
			// post types
			case "post-types":
			default:
	
				$folder_base = trailingslashit(get_template_directory() . '/assets/inc/post-types');
				$folder_child = trailingslashit(get_stylesheet_directory() . '/assets/inc/post-types');
				$preg = '|Post Type Name:(.*)$|mi';
				
			break;
			
		}
		
		// array to store extensions
		$extensions = array();
		
		// loop the directory and grab the extension information
		if (file_exists($folder_base)) {
			foreach(glob($folder_base . '*.php') as $file)  {  
				$data = implode('', file($file));
		
				if (preg_match($preg, $data, $name)) {
					$name = _cleanup_header_comment($name[1]);
				}
				
				if (!empty($name)) {
					$extensions[] = array("name" => trim($name), "nicename" => null_slugify(trim($name)), "path" => $file);
				}	
			}
		}
		
		// if a child theme then do it again
		if (file_exists($folder_child) && ($folder_base != $folder_child)) {
			foreach(glob($folder_child . '*.php') as $file)  {  
				$data = implode('', file($file));
		
				if (preg_match($preg, $data, $name)) {
					$name = _cleanup_header_comment($name[1]);
				}
				
				if (!empty($name)) {
					$extensions[] = array("name" => trim($name), "nicename" => null_slugify(trim($name)), "path" => $file);
				}	
			}
		}
		
		// return an array of settings if set
		if ($settings) {
			
			$settings = array();
			
			foreach($extensions as $extension) {
				$settings[$extension['nicename']] = $extension['name'];
			}
			
			return $settings;
		}
		
		// return an array of extensions
		return $extensions;
	}

	/***************************************************************
	* Function null_get_fonts
	* Get System & Google Web Fonts json object and save as transient 
	***************************************************************/
	
	function null_get_fonts($sort = 'alpha')	{
		
		// sort options
		// alpha: Sort the list alphabetically
		// date: Sort the list by date added (most recent font added or updated first)
		// popularity: Sort the list by popularity (most popular family first)
		// style: Sort the list by number of styles available (family with most styles first)
		// trending: Sort the list by families seeing growth in usage (family seeing the most growth first)
		
		if (false === ($font_list = get_transient('null_google_fonts_'.$sort))) { 
			
			// system fonts - the stacks are available in mixins.less
			$font_list['Arial'] = 'Arial (system)';
			$font_list['Arial Rounded'] = 'Arial Rounded (system)'; 
			$font_list['Baskerville'] = 'Baskerville (system)';
			$font_list['Cambria'] = 'Cambria (system)';
			$font_list['Century Gothic'] = 'Centry Gothic (system)';
			$font_list['Courier New'] = 'Courier New (system)';
			$font_list['Georgia'] = 'Georgia (system)';
			$font_list['Helvetica'] = 'Helvetica (system)';
			$font_list['Lucida Bright'] = 'Lucida Bright (system)';
			$font_list['Lucida Sans'] = 'Lucida Sans (system)';
			$font_list['Tahoma'] = 'Tahoma (system)';
			$font_list['Trebuchet MS'] = 'Trebuchet MS (system)';
			$font_list['Verdana'] = 'Verdana (system)';
						
			// google fonts
			$api_key = 'AIzaSyCTTbK5s0or8LmQfUCNhndMfSvyz-f6jqk';
			$gwf_uri = "https://www.googleapis.com/webfonts/v1/webfonts?key=" . $api_key . "&sort=" . $sort;
			$raw = file_get_contents($gwf_uri, 0, null, null );
			$fonts = json_decode($raw);
						
			foreach ($fonts->items as $font) {
				$font_list[$font->family] = $font->family;
			}
			
			// cache for 3 days
			set_transient('null_google_fonts_' . $sort, $font_list, 60 * 60 * 24 * 3);
		
		}
		
		// return the saved list of Google Web Fonts
		return $font_list;
	
	}	

	/***************************************************************
	* Function null_cache_path
	* Return the path to the null-cache directory in /uploads/
	***************************************************************/
	
	function null_cache_path() {
			
		$upload_dir = wp_upload_dir();
		$dir = apply_filters('null_cache_path', trailingslashit( $upload_dir[ 'basedir' ] ) . 'null-cache');
						
		// create folder if it doesn't exist yet
		if (!file_exists($dir))
			wp_mkdir_p($dir);
			
		return rtrim($dir, '/');
	}

	/***************************************************************
	* Function optionsframework_option_name
	* Determine a unique name for the theme options settings in database
	***************************************************************/
	
	function optionsframework_option_name() {
	
		// This gets the theme name from the stylesheet (lowercase and without spaces)
		$themename = wp_get_theme();
		$themename = $themename['Name'];
		$themename = preg_replace("/\W/", "", strtolower($themename) );
		
		$optionsframework_settings = get_option('optionsframework');
		$optionsframework_settings['id'] = $themename;
		update_option('optionsframework', $optionsframework_settings);
	
	}

	/***************************************************************
	* Function is_wp_version
	* What version of WordPress are we running?
	***************************************************************/
	
	if (!function_exists('is_wp_version')) {
		function is_wp_version( $is_ver ) {
		    $wp_ver = explode( '.', get_bloginfo( 'version' ) );
		    $is_ver = explode( '.', $is_ver );
		    for( $i=0; $i<=count( $is_ver ); $i++ )
		        if( !isset( $wp_ver[$i] ) ) array_push( $wp_ver, 0 );
		    foreach( $is_ver as $i => $is_val )
		        if( $wp_ver[$i] < $is_val ) return false;
		    return true;
		}
	}
	
	/***************************************************************
	* Function null_sort_query_by_post_in
	* Add an extra sort option to WP_Query: post__in order - http://bit.ly/aV1tNJ
	***************************************************************/
	
	add_filter('posts_orderby', 'null_sort_query_by_post_in', 10, 2);
	
	function null_sort_query_by_post_in( $sortby, $thequery ) {
		if (!empty($thequery->query['post__in']) && isset($thequery->query['orderby']) && $thequery->query['orderby'] == 'post__in')
			$sortby = "find_in_set(ID, '" . implode( ',', $thequery->query['post__in'] ) . "')";
		return $sortby;
	}

	/***************************************************************
	* Function null_obscure_login
	* Make the login error message a touch more generic - add to option
	***************************************************************/

	add_filter( 'login_errors', 'null_obscure_login' );

	function null_obscure_login($error) { 
		$new_message = __('The credentials you provided are incorrect.', 'null');
		$error = str_replace( 'Invalid username.', $new_message, $error );
		$error = preg_replace( '{The password you entered for the username <strong>.*</strong> is incorrect.}', $new_message, $error );

		return $error;
		//return __('<strong>ERROR</strong>: You supplied incorrect login information.', 'null');
	}

	/***************************************************************
	* Function null_string_search
	* Search a $string for $needle
	***************************************************************/
	
	function null_string_search($needle,$string) {
	
		return (strpos($string, $needle) !== false);
	
	}
	
	/***************************************************************
	* Function null_slugify
	* Create a friendly URL slug from a string
	***************************************************************/
	
	function null_slugify($str) {
	
	    $str = preg_replace('/[^a-zA-Z0-9 -]/', '', $str);
	    $str = strtolower(str_replace(' ', '-', trim($str)));
	    $str = preg_replace('/-+/', '-', $str);
	    return $str;
	    
	}
	// email
	load_template(get_template_directory() . '/assets/inc/email.php');
	
	// custom post types
	load_template(get_template_directory() . '/assets/inc/post-types.php');

	// widgets
	load_template(get_template_directory() . '/assets/inc/widgets.php');

	// cron
	load_template(get_template_directory() . '/assets/inc/cron.php');
	
	// shortcodes
	if (!is_admin()) { load_template(get_template_directory() . '/assets/inc/shortcodes.php'); }
	
	// breadcrumbs - http://wordpress.org/extend/plugins/breadcrumb-trail/
	if (!is_admin()) { locate_template('/assets/inc/breadcrumbs.php', true, true); }

	// performance
	if (!is_admin()) { locate_template('/assets/inc/performance.php', true, true); }
	
	// table of contents - add settings to attach this to certain post types only
	//if (!is_admin()) { load_template(get_template_directory() . '/assets/lib/class-toc.php'); }

	// load htaccess code, rewrites etc
	if (is_admin()) { locate_template('/assets/inc/htaccess.php', true, true); }
	
	// only load in admin functions in admin interface
	if (is_admin()) { locate_template('/assets/inc/admin.php', true, true); }

	// load update code
	if (is_admin()) { load_template(get_template_directory() . '/assets/inc/update.php'); }
	
	// only load front end functions for site
	if (!is_admin()) { locate_template('/assets/inc/theme.php', true, true); }
			
?>