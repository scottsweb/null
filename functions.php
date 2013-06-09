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
	----------------------------------------
	
	future
	to-do: http://gridster.net/ - build virtual templates via UI (fork coming soon)
			- http://jsfiddle.net/maxgalbu/UfyjW/
			- https://github.com/ducksboard/gridster.js/issues/69
			- http://headwaythemes.com/features/headway-grid/
			- http://www.webresourcesdepot.com/grid-builder-drag-n-drop-html-grid-generator/
			- http://app.responsify.it/
			- https://www.scrollkit.com/
			- http://mcpants.github.io/jquery.shapeshift/index.html
	to-do: bundle xml file import for WordPress (use wordpress import/export feature) - theme unit test installer?
	to-do: perhaps move to: http://wordpress.org/extend/plugins/option-tree/ for options?
			- 	to-do: pre-configured site settings (so buddypress, multi site, multi author, client etc)
	to-do: a second take on responsive tables -> http://filamentgroup.com/examples/rwd-table-patterns/ / http://consulenza-web.com/jquery/MediaTable/?
			-  http://css-tricks.com/responsive-data-table-roundup/ - more options for responsive tables
	to-do: font effects? https://developers.google.com/webfonts/docs/getting_started#Effects - shortcode?
	to-do: explore the gantry-framework http://www.gantry-framework.org/download
	to-do: ability to disable built in post types and taxonomies - http://core.trac.wordpress.org/ticket/14761
	to-do: move to an existing CSS/LESS framework?
			- clean up gravity forms less and test with some forms (not using GF much)
			- a beautiful, minimal, responsive design (old scott.ee site?)
			- http://typeplate.com/ 
			- https://github.com/clearleft/clearless
			- http://twitter.github.com/bootstrap/ also http://bootswatch.com/
			- http://responsablecss.com/ - baseline is not calculated
			- http://mateuszkocz.github.com/3l - seo helper is rather nifty
			- http://compass-style.org/reference/compass/css3/ - less mixin ideas from compass
			- https://github.com/dancrew32/lesslib/blob/master/mixins.less - less mixins
			- http://kushagragour.in/lab/hint/ - css tooltips 
			- http://necolas.github.com/normalize.css/ - use normalize instead of full reset
			- investigate this grid system: https://t.co/GaP9MWsZtS
			- http://coding.smashingmagazine.com/2013/03/08/tips-tricks-print-style-sheets/ - improve print styles
			- http://gumbyframework.com/
			- http://www.99lime.com/elements/
			- http://www.formee.org/
			- http://simplegrid.info/
			- http://www.responsivegridsystem.com/
	to-do: replace modernizr? http://conditionizr.com/
	to-do: live bind shortcode JS for instant search plugin compatibility - livequery? or .on
	to-do: compatibilty with live edit - http://wordpress.org/extend/plugins/live-edit/
			- if (function_exists("live_edit")) { live_edit(apply_filters('null_live_edit_loop', 'post_title, post_excerpt')); }
	to-do: HiDPI/vector icon post type icons - ready for 3.7 and MP6
	to-do: create an editable 404?
	to-do: feature tooltips restricted by user type (same code as with admin bar)
	to-do: improve gallery shortcode - css and filters tweaks - see chailey - make the built in gallery useful in more projects //http://wordpress.stackexchange.com/questions/4343/how-to-customise-the-output-of-the-wp-image-gallery-shortcode-from-a-plugin

	ongoing
	to-do: update language files
	to-do: update modernizr
	to-do: update ligature symbols
	to-do: update less compiler 0.3.9+ / less plugin and grid - hopefully will work again and provide css compression
	to-do: update acf
	to-do: test against the theme guide: http://developer.wordpress.com/themes/

	soon
	to-do: cache 
			- (transients) null_get_extensions?
			- (transients) menus? - http://www.codeforest.net/wordpress-transients-api-caching-benchmarks
			- cache any wp-query and custom query?
	to-do: integrate options-framework with google font code (filter of_recognized_font_faces)
	to-do: filter folder locations for extensions (a plugin could register extension folders?)
	to-do: Turn on certain extensions by default (child theme ships with X,Y,Z on)
	to-do: improve nav walker to provide better classes and support for other attributes
	to-do: issue - all templates that exist in the parent theme are a pain - if i just want index.php in child theme I have to overwrite category, tag etc etc - move all these to null child?
		- 	to-do: style and code for various post format types (chat, video, quote etc)
		- 	to-do: home.php
	to-do: Performance for htaccess? http://wp.tutsplus.com/tutorials/hosting/optimizing-wordpress-loading-speed-with-header-php-htaccess/
	to-do: please make sure your htaccess is writable notice on activation?	
	to-do: navigation fix for cpt - see MHP
	to-do: remove more polyfills - chrome frame notice? (see h5bp index.html)
			- webp images? - http://webpjs.appspot.com/ - https://developers.google.com/speed/webp/
			- One tool based on jQuery and modernizr - http://afarkas.github.io/webshim/demos/index.html
			- http://elclanrs.github.io/jq-idealforms/
			- https://github.com/louisremi/jquery-smartresize
	to-do: filter null_mustache_tags - register your own replacements

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
	
	// parse template info from style.css - version number
	$theme_data = wp_get_theme();
	define('NULL_VERSION', $theme_data['Version']);

	// get the theme name from the stylesheet (lowercase and without spaces)
	$themename = $theme_data['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename));
	define('NULL_OPTION_NAME', $themename);

	// cache bust based on options settings and file gen time of main css - filterable for child themes to add different css filemtime
	$type = (of_get_option('disable_less', '1') ? 'css' : 'less');	
	$cachefiles = intval(filemtime(get_template_directory() . '/assets/'.$type.'/screen.'.$type));
	$cacheoptions = md5(serialize(get_option(NULL_OPTION_NAME, array('0' => '1'))));
	$cacheoptions = intval($cacheoptions);
	$cachebust = apply_filters('null_cache_bust', abs(intval($cacheoptions+$cachefiles)));
	define('NULL_CACHE_BUST', $cachebust);

	// load activation code
	locate_template('/assets/inc/activation.php', true, true);

	// deprecated code - do not rely on code in this file
	load_template(get_template_directory() . '/assets/inc/deprecated.php');

	// compatibility - work nicely with other popular plugins
	load_template(get_template_directory() . '/assets/inc/compatibility.php');

	// email
	load_template(get_template_directory() . '/assets/inc/email.php');
	
	// custom post types
	load_template(get_template_directory() . '/assets/inc/post-types.php');

	// widgets and sidebars
	load_template(get_template_directory() . '/assets/inc/widgets.php');

	// cron
	load_template(get_template_directory() . '/assets/inc/cron.php');
	
	// shortcodes
	load_template(get_template_directory() . '/assets/inc/shortcodes.php');
	
	// breadcrumbs - http://wordpress.org/extend/plugins/breadcrumb-trail/
	if (!is_admin()) { locate_template('/assets/inc/breadcrumbs.php', true, true); }

	// load htaccess code, rewrites etc
	if (is_admin()) { locate_template('/assets/inc/htaccess.php', true, true); }
	
	// only load in admin functions in admin interface
	if (is_admin()) { locate_template('/assets/inc/admin.php', true, true); }

	// load update code
	if (is_admin()) { load_template(get_template_directory() . '/assets/inc/update.php'); }
	
	// wp app store
	if (is_admin() && !class_exists('WP_App_Store_Installer') && !of_get_option('disable_wpas', '0') && !is_multisite()) { load_template(get_template_directory() . '/assets/inc/wp-app-store.php'); }
	
	// only load front end functions for site
	if (!is_admin()) { locate_template('/assets/inc/theme.php', true, true); }

	// load theme hook alliance - https://github.com/zamoose/themehookalliance
	load_template(get_template_directory() . '/assets/inc/thahooks.php');

	// set content width - see: http://toggl.es/wEBCFs - largely irrelevant with responsive sites?
	if (!isset($content_width)) $content_width = 656;

	/***************************************************************
	* Maintenance Mode
	* Take the front end of the site down for users that are not logged in and cannot manage optionsframework
	***************************************************************/

	global $pagenow;
	if (!is_user_logged_in() && !current_user_can('edit_theme_options') && $pagenow != 'wp-login.php' && of_get_option('maintenance_mode', '0')) { 
		header('Retry-After: 600'); // 600 seconds/10 minutes
		wp_die(__('Website is down for maintenance.', 'null'), get_bloginfo('name').' | '.__('Maintenance (503)', 'null'), array('response' => 503)); 
	}

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
		if (of_get_option('custom_header', '0')) {
			if (is_wp_version( '3.4' )) {
				add_theme_support('custom-header'); 
			} else { 
				add_custom_image_header();
			}
		}
			
		// add support for custom backgrounds if setup
		if (of_get_option('custom_background', '0')) {
			if (is_wp_version( '3.4' )) {
				add_theme_support('custom-background'); 
			} else { 
				add_custom_background();
			}
		}
			
		// post-formats
		if (of_get_option('post_formats', '0')) {
			
			$formats = of_get_option('post_format_types', array());
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
		
		// add theme hook alliance support (https://github.com/zamoose/themehookalliance) - filterable by child theme 
		add_theme_support('tha_hooks', apply_filters('null_tha_hooks', array('body','head','header','content','entry','comments','sidebar','footer')));

		// set defualt thumbnail size: the_post_thumbnail();
		set_post_thumbnail_size( 150, 150, true );
		
		// custom hook to easily register more image sizes
		do_action('null_register_image_size');
	
		// custom menu support
	    add_theme_support('menus');
	    
		// register navigation menus for this theme
		register_nav_menus(apply_filters('null_register_menu', array(
	  		  'navigation' => __('Navigation', 'null'),
	  		  'footer' => __('Footer', 'null')
	  		)
	  	));
		
	}

	// load php less parser if enabled
	if (!of_get_option('disable_less', '1')) { locate_template('/assets/inc/less.php', true, true); }

	/***************************************************************
	* Function null_less_vars
	* Parse theme options into less for use in stylesheets
	***************************************************************/

	if (!of_get_option('disable_less', '0')) {
		add_filter('less_vars', 'null_less_vars', 10, 2 );
	}

	function null_less_vars($vars, $handle) {
	   	
	   	global $pagenow;

	    // $handle is a reference to the handle used with wp_enqueue_style()
	    $vars['primarycol'] = of_get_option('primary_colour', '#141414');
		$vars['bodycol'] = of_get_option('body_colour', '#141414');
		$vars['linkcol'] = of_get_option('link_colour', '#0000EE');
		$vars['linkhovercol'] = of_get_option('link_hover_colour', '#551A8B');
		$vars['backgroundimage'] = of_get_option('background_image', get_template_directory_uri().'/assets/images/placeholder.png');
		$vars['headingfont']  = of_get_option('heading_font', 'Cabin');
	   	$vars['bodyfont'] = of_get_option('body_font', 'a1');
	   	$vars['cachebust'] = NULL_CACHE_BUST;
	    return $vars;
	    
	}

	/***************************************************************
	* Function null_admin_css_setup
	* Register and enqueue all css/less files backend - http://toggl.es/tSgnfR
	***************************************************************/
	
	add_action('admin_enqueue_scripts', 'null_admin_css_setup');
	
	function null_admin_css_setup() {
		
		// is less compiling enabled or disabled?
		$type = (of_get_option('disable_less', '1') ? 'css' : 'less');	
		
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
		
		// is less compiling enabled or disabled?
		$type = (of_get_option('disable_less', '1') ? 'css' : 'less');

		// register all css/less
		// grab the google font based on font settings
		$heading_font = of_get_option('heading_font', 'Cabin');
		$body_font = of_get_option('body_font', 'a1'); // arial
		$allfonts = null_get_fonts();
		$gfonts = array();
		
		if ($heading_font != '') {
			if (!null_string_search('(system)', $allfonts[$heading_font])) {
				$gfonts[] = $heading_font;
			}
		}
		
		if (!null_string_search('(system)', $allfonts[$body_font])) {
			$gfonts[] = $body_font;
		}
		
		if (!empty($gfonts)) { 
			$getfonts = implode('|', $gfonts);
			wp_register_style('google-font', 'http://fonts.googleapis.com/css?family='.$getfonts, '', null_slugify(NULL_VERSION), 'all'); 
			wp_enqueue_style('google-font');
		}		

		// the rest of the styles
		wp_register_style('null-screen', get_template_directory_uri() . '/assets/'.$type.'/screen.'.$type, array(), NULL_CACHE_BUST, 'screen');
		wp_register_style('holmes', get_template_directory_uri() . '/assets/css/holmes.css', array('null-screen'), NULL_CACHE_BUST, 'screen');
		wp_register_style('null-print', get_template_directory_uri() . '/assets/'.$type.'/print.'.$type, array(), NULL_CACHE_BUST, 'print');
		
		// register ie styles
		wp_register_style('null-screen-ie', get_template_directory_uri() . '/assets/'.$type.'/screen-ie.'.$type, array(), NULL_CACHE_BUST, 'screen');
		
		// all styles for this theme
		wp_enqueue_style('null-screen');

		// holmes if in development mode and holmes is set
		if (of_get_option('development_mode_holmes', '0'))	wp_enqueue_style('holmes');

		// remove admin bar css for print media - added already
		remove_action('wp_head', 'wp_admin_bar_header');
		
		// print style sheet (including admin bar hide removed above)
		wp_enqueue_style('null-print');
		
		// ie styles
		wp_enqueue_style('null-screen-ie');
		
		// action for adding or removing theme css
		do_action('null_theme_css');
		
	}

	/***************************************************************
	* Function null_login_css_setup
	* Add a custom stylesheet to the login (same CSS is also added to the admin)
	***************************************************************/
	
	add_action('login_enqueue_scripts', 'null_login_css_setup');
	
	function null_login_css_setup() {

		// is less compiling enabled or disabled?
		$type = (of_get_option('disable_less', '1') ? 'css' : 'less');
		
		// custom admin css
		wp_register_style('null-admin', get_template_directory_uri() . '/assets/'.$type.'/wp-admin.'.$type, array(), filemtime(get_template_directory() . '/assets/'.$type.'/wp-admin.'.$type));
		wp_enqueue_style('null-admin');
	   
	}

	/***************************************************************
	* Function null_admin_js_setup
	* Register and enqueue all admin javascript files
	***************************************************************/
	
	add_action('admin_enqueue_scripts', 'null_admin_js_setup');
	
	function null_admin_js_setup() {
		
		// action for adding or removing more js in the admin
		do_action('null_admin_js');
			
	}
		
	/***************************************************************
	* Function null_theme_js_setup
	* Register and enqueue all frontend javascript files
	***************************************************************/

	add_action('wp_enqueue_scripts', 'null_theme_js_setup');
	
	function null_theme_js_setup() {
		
		//  grab settings
		$polyfills = of_get_option('polyfills', array(
			'ios' 			=> "1",
			'selectivizr'	=> "0", 
			'html5_forms'	=> "1",
			'imgsizer'		=> "0"
		));
			
		// register all scripts			
		wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.js', '', filemtime(get_template_directory() . '/assets/js/modernizr.js'));
		wp_register_script('html5-forms', get_template_directory_uri() . '/assets/js/forms.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/forms.js'));
		wp_register_script('null-gat', get_template_directory_uri() . '/assets/js/analytics.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/analytics.js'));
		wp_register_script('null', get_template_directory_uri() . '/assets/js/onload.js', array('jquery', 'jquery-ui-tabs', 'jquery-ui-accordion'), filemtime(get_template_directory() . '/assets/js/onload.js'));

		// comment threading
		if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply');
		
		// standard shipped jquery
		wp_enqueue_script('jquery');
				
		// always load modernizr as it contains HTML5 shiv
		wp_enqueue_script('modernizr');
		
		// html5 forms if option is set
		if ($polyfills['html5_forms'] == "1") wp_enqueue_script('html5-forms');
		
		// analytics event tracking
		if ((of_get_option('gat')) && (of_get_option('gat_external_download', '0'))) wp_enqueue_script('null-gat');

		// the onload/custom js file
		wp_enqueue_script('null');
		
		// action for adding or removing more js on the theme
		do_action('null_theme_js');
		
	}

	/***************************************************************
	* Function null_conditional_ie_styles
	* Add conditional comments around IE specific stylesheets
	***************************************************************/
	
	add_filter('style_loader_tag', 'null_conditional_ie_styles', 10, 2);
	
	function null_conditional_ie_styles( $tag, $handle ) {
	
		if ('null-screen-ie' == $handle || 'screen-ie' == $handle)
			$tag = '<!-- IE css -->' . "\n" .'<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
	
		return $tag;
	
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

				// for shortcodes we want to check a second header (shortcode template)
				$pregtemplate = '|Shortcode Template:(.*)$|mi';

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
				
				// additional check for shortcodes - rip the template header out too
				if (isset($pregtemplate)) {

					if (preg_match($pregtemplate, $data, $template)) {
						$template = _cleanup_header_comment($template[1]);
					}

					if (!empty($name) && !empty($template)) {
						$extensions[] = array("name" => trim($name), "nicename" => null_slugify(trim($name)), "path" => $file, "template" => $template);
					}

				} else {

					if (!empty($name)) {
						$extensions[] = array("name" => trim($name), "nicename" => null_slugify(trim($name)), "path" => $file);
					}	
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
				
				// additional check for shortcodes - rip the template header out too
				if (isset($pregtemplate)) {

					if (preg_match($pregtemplate, $data, $template)) {
						$template = _cleanup_header_comment($template[1]);
					}

					if (!empty($name) && !empty($name)) {
						$extensions[] = array("name" => trim($name), "nicename" => null_slugify(trim($name)), "path" => $file, "template" => $template);
					}

				} else {

					if (!empty($name)) {
						$extensions[] = array("name" => trim($name), "nicename" => null_slugify(trim($name)), "path" => $file);
					}	
				}	
			}
		}
		
		// return an array of settings if set
		if ($settings) {
			
			$settings = array();
			
			foreach($extensions as $extension) {
				$settings[$extension['nicename']] = $extension['name'];
			}
			
			// sort
			ksort($settings);

			return $settings;
		}
		
		// sort
		$sorted = array();
		foreach ($extensions as $extension) {
			$sorted[] = $extension['name'];
		}
		array_multisort($sorted, SORT_ASC, $extensions);

		// return an array of extensions
		return $extensions;
	}

	/***************************************************************
	* Function null_extensions_enabled
	* Simple check to see if any extension is set to on within an extensions array
	***************************************************************/

	function null_extensions_enabled($extensions) {
		$tmp = array_filter($extensions);
		if (empty($tmp)) return false;
		return true;
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
			
			// system fonts - the stacks are available in mixins.less and simple array references are used for compatibility with LESS guards
			$font_list['a1'] = 'Arial (system)';
			$font_list['a2'] = 'Arial Rounded (system)'; 
			$font_list['b1'] = 'Baskerville (system)';
			$font_list['c1'] = 'Cambria (system)';
			$font_list['c2'] = 'Centry Gothic (system)';
			$font_list['c3'] = 'Courier New (system)';
			$font_list['g1'] = 'Georgia (system)';
			$font_list['h1'] = 'Helvetica (system)';
			$font_list['l1'] = 'Lucida Bright (system)';
			$font_list['l2'] = 'Lucida Sans (system)';
			$font_list['t1'] = 'Tahoma (system)';
			$font_list['t2'] = 'Trebuchet MS (system)';
			$font_list['v1'] = 'Verdana (system)';
						
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
		$optionsframework_settings = get_option('optionsframework');
		$optionsframework_settings['id'] = NULL_OPTION_NAME;
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
	* Function current_url
	* Determine the URL of the currently viewed page - will return array if $parse set to true
	***************************************************************/

	if (!function_exists('current_url')) {
		function current_url($parse = false) {
			$s = empty($_SERVER['HTTPS']) ? '' : ($_SERVER['HTTPS'] == 'on') ? 's' : '';
			$protocol = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0, strpos(strtolower($_SERVER['SERVER_PROTOCOL']), '/')) . $s;
			$port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (":".$_SERVER['SERVER_PORT']);
			if ($parse) {
				return parse_url($protocol . "://" . $_SERVER['HTTP_HOST'] . $port . $_SERVER['REQUEST_URI']);
			} else { 
				return $protocol . "://" . $_SERVER['HTTP_HOST'] . $port . $_SERVER['REQUEST_URI'];
			}
		}
	}

	/***************************************************************
	* Function null_obscure_login
	* Make the login error message a touch more generic - add to options?
	***************************************************************/

	add_filter( 'login_errors', 'null_obscure_login' );

	function null_obscure_login($error) { 
		$new_message = __('The credentials you provided are incorrect.', 'null');
		$error = str_replace( 'Invalid username.', $new_message, $error );
		$error = preg_replace( '{The password you entered for the username <strong>.*</strong> is incorrect.}', $new_message, $error );
		return $error;
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
		
		// $str2 = sanitize_title_with_dashes($str); - replace with?
	    $str = preg_replace('/[^a-zA-Z0-9 -]/', '', $str);
	    $str = strtolower(str_replace(' ', '-', trim($str)));
	    $str = preg_replace('/-+/', '-', $str);

	    //if ($str != $str2) echo ('slugs differ ('.$str.' - '.$str2.')<br/>');
	   	return $str;

	}	

?>