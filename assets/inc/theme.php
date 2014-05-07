<?php

/***************************************************************
* Function null_clean_assets & null_clean_plugins
* Tidy up our URLs for assets and plugins
***************************************************************/

if (!is_multisite() && !is_child_theme() && of_get_option('cleanup', '0')) {
	add_filter('plugins_url', 'null_clean_plugins');
	add_filter('bloginfo', 'null_clean_assets');
	add_filter('stylesheet_directory_uri', 'null_clean_assets');
	add_filter('template_directory_uri', 'null_clean_assets'); 
	add_filter('script_loader_src', 'null_clean_plugins');
	add_filter('style_loader_src', 'null_clean_plugins');
}

function null_clean_assets($content) {
	// determine current theme folder name
	preg_match("/wp-content\/themes\/(.+)/", get_stylesheet_directory(), $bits);
	$current_path = '/wp-content/themes/'.untrailingslashit($bits[1]);
	$new_path = '';
	$content = str_replace($current_path, $new_path, $content);
	return $content;
}

function null_clean_plugins($content) {
	$current_path = '/wp-content/plugins';
	$new_path = '/plugins';
	$content = str_replace($current_path, $new_path, $content);
	return $content;
}

/***************************************************************
* Function null_robots
* Filter robots.txt file with WordPress specific rules, can be overwritten by child
***************************************************************/

if (get_option('blog_public')) {
	remove_action('do_robots', 'do_robots');
	add_action('do_robots','null_robots');
}

if (!function_exists('null_robots')) {
	function null_robots() {
	
		if (is_robots()) {
	
			$output = "User-agent: *\n";
			$output .= "Disallow: /cgi-bin/\n";
			$output .= "Disallow: /wp-admin/\n";
			$output .= "Disallow: /wp-includes/\n";
			$output .= "Disallow: /wp-content/uploads/gravity_forms/\n";
			$output .= "Disallow: /wp-content/plugins/\n";
			$output .= "Disallow: /wp-content/themes/\n";
			$output .= "Disallow: /wp-login.php\n";
			$output .= "Disallow: /wp-register.php\n";
		
			if ( file_exists($_SERVER['DOCUMENT_ROOT'].'/sitemap.xml.gz') )
				$output .= 'Sitemap: http://'.$_SERVER['HTTP_HOST'].'/sitemap.xml.gz';
			else if ( file_exists($_SERVER['DOCUMENT_ROOT'].'/sitemap.xml') )
				$output .= 'Sitemap: http://'.$_SERVER['HTTP_HOST'].'/sitemap.xml';
			elseif ( class_exists('WPSEO_Sitemaps'))
				$output .= 'Sitemap: http://'.$_SERVER['HTTP_HOST'].'/sitemap_index.xml';
		
			header('Status: 200 OK', true, 200);
			header('Content-type: text/plain; charset='.get_bloginfo('charset'));
			echo $output;
			exit;
		}
	}
}

/***************************************************************
* Function null_language_attributes
* Set lang="en" as default (rather than en-US)
***************************************************************/

add_filter('language_attributes', 'null_language_attributes');

function null_language_attributes() {
	$attributes = array();
	$output = '';
	
	if (function_exists('is_rtl')) {
		if (is_rtl() == 'rtl') {
			$attributes[] = 'dir="rtl"';
		}
	}
	
	$lang = get_bloginfo('language');
	if ($lang && $lang !== 'en-US') {
		$attributes[] = "lang=\"$lang\"";
	} else {
		$attributes[] = 'lang="en"';
	}
	
	$output = implode(' ', $attributes);
	$output = apply_filters('null_language_attributes', $output);
	return $output;
}

/***************************************************************
* Function null_title 
* Calculate title of the current page, can be overwritten by child
***************************************************************/

if (!function_exists('null_title')) {

	function null_title() {

		global $page, $paged;
		
		wp_title('|', true, 'right');
		bloginfo('name');
		
		$site_description = get_bloginfo('description', 'display');
		if ($site_description && (is_home() || is_front_page()))
			echo " | $site_description";
		
		if ($paged >= 2 || $page >= 2)
			echo ' | ' . sprintf(__( 'Page %s', 'null' ), max($paged, $page));
	}
}

/***************************************************************
* Function null_clean_head 
* Remove unwanted links and tags in <head>
***************************************************************/

add_action('init', 'null_clean_head');

function null_clean_head() {

	$options = of_get_option('header_meta', array( 
		'rsd'				=> "1",
		'windows' 			=> "0", 
		'generator'			=> "0", 
		'feed_links' 		=> "1", 
		'extra_feed_links'	=> "0", 
		'shortlink' 		=> "0", 
		'canonical' 		=> "1",
		'relational'		=> "0"
	));
	
	// RSD link 
	if ($options['rsd'] != "1") remove_action('wp_head', 'rsd_link');
	// remove windows live generator tag
	if ($options['windows'] != "1") remove_action('wp_head', 'wlwmanifest_link');	
	// remove generator tag			
	if ($options['generator'] != "1") remove_action('wp_head', 'wp_generator');
	// remove links to the extra feeds (e.g. category feeds)
	if ($options['feed_links'] != "1") remove_action('wp_head', 'feed_links', 2);
	// remove links to the general feeds (e.g. posts and comments)
	if ($options['extra_feed_links'] != "1") remove_action('wp_head', 'feed_links_extra', 3);
	// remove rel shortlink
	if ($options['shortlink'] != "1") remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	// canoncical
	if ($options['canonical'] != "1") remove_action('wp_head', 'rel_canonical');
	// relational posts
	if ($options['relational'] != "1") {
		// remove index link
		remove_action('wp_head', 'index_rel_link' );
		// remove prev link
		remove_action('wp_head', 'parent_post_rel_link', 10, 0 );
		// remove start link
		remove_action('wp_head', 'start_post_rel_link', 10, 0 );
		// display relational links for adjacent posts
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	}
}

/***************************************************************
* Function null_remove_recent_comments_style
* Remove inline styles caused by using the recent comments widget
***************************************************************/

add_action('widgets_init', 'null_remove_recent_comments_style', 99);

function null_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}

/***************************************************************
* Function null_wp_head 
* Output null ployfills, custom code etc to wp_head
***************************************************************/

add_action('wp_head', 'null_wp_head');

function null_wp_head() {
	
	// pingback
	if (get_option('default_ping_status') == "open") {
	?>
	
	<!-- pingback -->
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php
	}
	
	// icons
	?>
	
	<!-- icons -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php if ($favicon = of_get_option('favicon')) { echo $favicon; } else { echo get_template_directory_uri() . '/assets/images/favicon.ico'; } ?>" />
	<link rel="apple-touch-icon-precomposed" href="<?php if ($touchicon = of_get_option('touchicon')) { echo $touchicon; } else { echo get_template_directory_uri() . '/assets/images/apple-touch-icon-precomposed.png'; } ?>" />
	<?php
	
	// pollyfills
	$polyfills = of_get_option('polyfills', array(
		'ios' 			=> "1",
		'selectivizr'	=> "0", 
		'html5_forms'	=> "1",
		'imgsizer'		=> "0",
	));

	//  ios fix
	if ($polyfills['ios'] == "1") { 
	?>
	
	<!-- ios rotation fix -->
	<script type="text/javascript">
		(function(a){var b='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in a?a[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];a.removeEventListener(type,fix,true)}if((meta=meta[meta.length-1])&&b in a){fix();scales=[.25,1.6];a[b](type,fix,true)}}(document));
	</script>
	<?php
	}
	
	//  selectivizr
	if ($polyfills['selectivizr'] == "1") { 
	?>
	
	<!-- selectivizr -->
	<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/assets/js/selectivizr.js"></script><![endif]-->
	<?php
	}
	
	//  fluid images
	if ($polyfills['imgsizer'] == "1") { 
	?>
	
	<!-- fluid images -->
	<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/assets/js/imgsizer.js"></script><![endif]-->
	<?php
	}

	$advanced_header_meta = of_get_option('advanced_header_meta', array(
		'ios_app'			=> "0",
		'ie9_app'			=> "1"
	));
	
	// ie9+ pinned app
	if ($advanced_header_meta['ie9_app'] == "1") {
	?>

	<!-- allow pinned app in ie9+ / windows 8 -->
	<meta name="application-name" content="<?php bloginfo('name'); ?>" />
	<meta name="msapplication-tooltip" content="<?php bloginfo('description'); ?>"/>
	<meta name="msapplication-starturl" content="<?php echo home_url(); ?>"/>
	<?php if ($touchicon = of_get_option('touchicon')) { ?><meta name="msapplication-TileImage" content="<?php echo $touchicon; ?>"><?php echo "\n"; } ?>
	<?php if ($ie9colour = of_get_option('ie9_colour')) { ?><meta name="msapplication-TileColor" content="<?php echo $ie9colour; ?>"><?php echo "\n"; } ?>
	<?php if ($ie9colour = of_get_option('ie9_colour')) { ?><meta name="msapplication-navbutton-color" content="<?php echo $ie9colour; ?>"><?php echo "\n"; }  ?>
	<?php
	}
	
	// ios app
	if ($advanced_header_meta['ios_app'] == "1") { 
	?>
	
	<!-- ios app -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<?php if ($ipl = of_get_option('ipad_splash_landscape')) { ?><link rel="apple-touch-startup-image" href="<?php echo $ipl; ?>" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)" /> <?php echo "\n"; } ?>
	<?php if ($ipp = of_get_option('ipad_splash_portrait')) { ?><link rel="apple-touch-startup-image" href="<?php echo $ipp; ?>" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)" /> <?php echo "\n"; } ?>
	<?php if ($ips = of_get_option('iphone_splash')) { ?><link rel="apple-touch-startup-image" href="<?php echo $ips; ?>" media="screen and (max-device-width: 320px)" /><?php echo "\n"; } ?>
	<?php
	}

	// custom header meta (from general settings)
	if ($meta = of_get_option('custom_header_meta')) {
	?>
	
	<!-- custom header meta -->
	<?php echo $meta . "\n"; ?>
	<?php
	}
	
	// google analytics  (from general settings)
	if ($tracking = of_get_option('gat')) {
	?>
	
	<!-- google analytics -->
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo $tracking; ?>']);
	_gaq.push(['_trackPageview']);
	
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
	<?php 
	}
	
	echo "\n";
}
	 	
/***************************************************************
* Function null_disable_rss_feed
* Disable RSS in WordPress
***************************************************************/

if (of_get_option('disable_rss', '0')) {
	add_action('do_feed', 'null_disable_rss_feed', 1);
	add_action('do_feed_rdf', 'null_disable_rss_feed', 1);
	add_action('do_feed_rss', 'null_disable_rss_feed', 1);
	add_action('do_feed_rss2', 'null_disable_rss_feed', 1);
	add_action('do_feed_atom', 'null_disable_rss_feed', 1);
}

function null_disable_rss_feed() {
	wp_die( __('RSS is currently disabled. Please visit our <a href="'. home_url() .'">homepage</a>!', 'null'));
}

/***************************************************************
* Function null_disable_search
* Disable Search in WordPress
***************************************************************/

if (of_get_option('disable_search', '0')) {
	add_action('parse_query', 'null_disable_search');
	//add_filter('get_search_form', '__return_null', 100);
}

function null_disable_search( $query, $error = true ) {
    if (is_search()) {
        $query->is_search = false;
        $query->query_vars['s'] = false;
        $query->query['s'] = false;
 
        // 404 error
        if ( $error == true )
            $query->is_404 = true;
    }
}

/***************************************************************
* Function null_body_class
* Improves the body_class function with some extras
***************************************************************/

add_filter('body_class','null_body_class');

function null_body_class($classes) {
	
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $wpdb, $post, $blog_id;
	
	// multisite site id and child-site	
	if (isset($blog_id)) {
		$classes[] = 'site-'.$blog_id;
		
		if($blog_id != 1) {
			$classes[] = 'child-site';
		}
	}

	// browsers (only of mobble not enable)
	if (!function_exists('mobble_settings')) {
	    if ($is_lynx) $classes[] = 'lynx';
	    else if ($is_gecko) $classes[] = 'gecko';
	    else if ($is_IE) $classes[] = 'ie';
	    else if ($is_opera) $classes[] = 'opera';
	    else if ($is_NS4) $classes[] = 'netscape';
	    else if ($is_safari) $classes[] = 'safari';
	    else if ($is_chrome) $classes[] = 'chrome';
	    else if ($is_iphone) $classes[] = 'iphone';
	    else $classes[] = 'other';
	}

	// date & time
	$t = time() + ( get_option('gmt_offset') * 3600 );
	$classes[] = 'y' . gmdate( 'Y', $t ); // Year
	$classes[] = 'm' . gmdate( 'm', $t ); // Month
	$classes[] = 'd' . gmdate( 'd', $t ); // Day
	$classes[] = 'h' . gmdate( 'H', $t ); // Hour
	
	// parent section
    if (is_page()) {
        if ($post->post_parent) {
            $parent  = end(get_post_ancestors($post->ID));
        } else {
            $parent = $post->ID;
        }
        $post_data = get_post($parent, ARRAY_A);
        $classes[] = 'section-' . $post_data['post_name'];
    }
	
	// post/page name/slug
	if (is_page() || is_single()) { 
		$classes[] = $post->post_name;
	}

	// footer sidebar activated 
	if (of_get_option('footer_sidebar', '1') && is_active_sidebar('sidebar-footer')) {
		$classes[] = "sidebar-footer";
	}

	// holmes in debug mode
	if (of_get_option('development_mode_holmes', '0')) {
		$classes[] = "holmes-debug";
	}

	// absolute admin bar
	if (of_get_option('admin_bar_attachment', 'fixed') == 'absolute') {
		$classes[] = 'admin-bar-absolute';
	}
	
	// multi author site
	if (is_multi_author()) {
		$classes[] = 'group-site';
	}
	
	return $classes;
}

/***************************************************************
* Function null_disable_admin_bar
* Disable the admin bar on the front end of the site for various user roles
***************************************************************/

add_filter('show_admin_bar', 'null_disable_admin_bar');

function null_disable_admin_bar() {
	
	global $wp_roles;
	
	if (isset($wp_roles)) {
		$disabled = of_get_option('admin_bar_disable');
				
		foreach ($wp_roles->role_names as $role_nice => $role_name) {
			if ($role_name != "Pending") {
				if (current_user_can($role_nice) && $disabled[$role_nice] == "1") {
					return false;
				}
			}
		}
	}
	
	if (is_user_logged_in()) {
		return true;
	} else {
		return false;
	}
}

/***************************************************************
* Function null_logo
* Output the logo if uploded, else return the blog title, can be declared in child theme
***************************************************************/

if (!function_exists('null_logo')) {
	function null_logo() {
		
		if ($logo_image = of_get_option('logo', '0')) {
			$logo = '<a href="'. home_url() .'" title="' . esc_html( get_bloginfo('name'), 1 ) .'" rel="home" class="replace png-bg logo"><img src="'. $logo_image .'" alt="'. get_bloginfo('name') .'" /></a>';
		} else {
			$logo = '<a href="'. home_url() .'" title="' . esc_html( get_bloginfo('name'), 1 ) .'" rel="home" class="replace png-bg no-logo">'. get_bloginfo('name') .'</a>';
		}
	
		$output = apply_filters('null_custom_logo', $logo);
		echo $output;
	
	}
}

/***************************************************************
* Function null_navigation_menu & null_navigation_menu_fallback
* Build the main menu and a suitable fallback
***************************************************************/

function null_navigation_menu() {

	wp_nav_menu( 
		array( 
			'menu' => 'navigation',
			'theme_location' => 'navigation',
			'container' => 'false',
			'fallback_cb' => 'null_navigation_menu_fallback',
			'depth' => 2
		)
	);
}

function null_navigation_menu_fallback() { 
	wp_page_menu('show_home='.__('Home','null')); 
}

/***************************************************************
* Function null_filter_menu_class
* Add first and last classes to menus
***************************************************************/

//add_filter('wp_nav_menu_objects', 'null_filter_menu_class');

function null_filter_menu_class( $objects ) {

 	// Add first/last classes to nested menu items
    $ids        = array();
    $parent_ids = array();
    $top_ids    = array();
    foreach ( $objects as $i => $object ) {
        // If there is no menu item parent, store the ID and skip over the object
        if ( 0 == $object->menu_item_parent ) {
            $top_ids[$i] = $object;
            continue;
        }

        // Add first item class to nested menus
        if ( ! in_array( $object->menu_item_parent, $ids ) ) {
            $objects[$i]->classes[] = 'first-menu-item';
            $ids[]          = $object->menu_item_parent;
        }

        // If we have just added the first menu item class, skip over adding the ID
        if ( in_array( 'first-menu-item', $object->classes ) )
            continue;

        // Store the menu parent IDs in an array
        $parent_ids[$i] = $object->menu_item_parent;
    }

    // Remove any duplicate values and pull out the last menu item
    $sanitized_parent_ids = array_unique( array_reverse( $parent_ids, true ) );

    // Loop through the IDs and add the last menu item class to the appropriate objects
    foreach ( $sanitized_parent_ids as $i => $id )
        $objects[$i]->classes[] = 'last-menu-item';

    // Finish it off by adding classes to the top level menu items
    $objects[1]->classes[] = 'first-menu-item'; // We can be assured 1 will be the first item in the menu :-)
    $objects[]->classes[end(array_keys($top_ids))] = 'last-menu-item';

    // Return the menu objects
    return $objects;

}

/***************************************************************
* Function null_breadcrumb_textdomain
* Use null textdomain for breadcrumbs as it is bundled with theme
***************************************************************/

add_filter('breadcrumb_trail_textdomain','null_breadcrumb_textdomain');

function null_breadcrumb_textdomain($domain) {
	
	$domain = 'null';
	return $domain;

}

/***************************************************************
* Function null_post_class
* Add some custom classes to each post
***************************************************************/

add_filter('post_class', 'null_post_class', 20);

function null_post_class($classes){
	
	global $wp_query, $post;
	
	// apply only to archives not single posts
	if (!is_single()) {
	
		// loop
		$classes[] = 'loop';
		
		// first and last
		if ($wp_query->current_post+1 == 1) $classes[] = 'loop-first'; 
		if (($wp_query->current_post+1) == $wp_query->post_count) $classes[] = 'loop-last';
	
		// odd and even
		if ($wp_query->current_post+1 & 1) { $classes[] = "loop-odd"; } else { $classes[] = "loop-even"; } 
	
		// counter
		$count = $wp_query->current_post+1;
		$classes[] = 'loop-'.$count;
	
		// per row? a filterable row count based on post type (think toggle shop). Perhaps wrap in a <div class="row"></div>
	
	}
	
	// featured image
	if (has_post_thumbnail($post->ID)) $classes[] = "featured-image";

	return $classes;
}

/***************************************************************
* Function null_time
* create a post time based on WordPress settings, can be declared in child theme
***************************************************************/

if (!function_exists('null_time')) {
	function null_time($format='') {
		
		global $post;
		
		// parse a custom stamp format e.g. F jS, Y &#8212; H:i
		if ($format) {
			the_time($format);
			return;
		}
		
		if ((get_option('date_format') != '') && (get_option('time_format') != '')) {
			the_time(get_option('date_format'));
			echo " - ";
			the_time();
			return;
		}
	
		if ((get_option('date_format') != '') && (get_option('time_format') == '')) {
			the_time(get_option('date_format'));
			return;
		}
	}
}

/***************************************************************
* Function null_get_time
* Return a post time based on WordPress settings, can be declared in child theme
***************************************************************/

if (!function_exists('null_get_time')) {
	function null_get_time($format='') {
		
		global $post;
		
		// parse a custom stamp format e.g. F jS, Y &#8212; H:i
		if ($format) {
			return get_the_time($format);
		}
		
		if ((get_option('date_format') != '') && (get_option('time_format') != '')) {
			return get_the_time(get_option('date_format')) . " - " . get_the_time();
		}
	
		if ((get_option('date_format') != '') && (get_option('time_format') == '')) {
			return get_the_time(get_option('date_format'));
		}
	}
}

/***************************************************************
* Function null_excerpt_length 
* Set a custom excerpt length for posts without an excerpt
***************************************************************/

add_filter('excerpt_length', 'null_excerpt_length');

if (!function_exists('null_excerpt_length')) {
	function null_excerpt_length($length) {
		return 42;
	}
}

/***************************************************************
* Function null_get_excerpt_more 
* Add the same to excerpt more link to custom excerpts, can be overwritten by child
***************************************************************/

add_filter('get_the_excerpt', 'null_get_excerpt_more');

if (!function_exists('null_get_excerpt_more')) {
	function null_get_excerpt_more( $output ) {

		global $post;

		if ( has_excerpt() && ! is_attachment() ) {
			$output .= 	apply_filters('null_except', '<a href="'. get_permalink($post->ID) . '">' . __(' &hellip;Continue reading &raquo;', 'null') . '</a>');
		}
		return $output;
	}
}

/***************************************************************
* Function null_excerpt_more 
* Set a custom excerpt more link, can be overwritten by child
***************************************************************/

add_filter('excerpt_more', 'null_excerpt_more');

if (!function_exists('null_excerpt_more')) {
	function null_excerpt_more($more) {
		global $post;
		return apply_filters('null_excerpt', '<a href="'. get_permalink($post->ID) . '">' . __(' &hellip;Continue reading &raquo;', 'null') . '</a>');
	}
}

/***************************************************************
* Function null_remove_more_skip_link 
* Removes url hash to avoid the jump link
***************************************************************/

add_filter('the_content_more_link', 'null_remove_more_skip_link');

function null_remove_more_skip_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
	  $end = strpos($link, '"',$offset);
	}
	if ($end) {
	  $link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}

/***************************************************************
* Function null_remove_more_skip_link 
* Removes empty span for skip link above
***************************************************************/

add_filter('the_content', 'null_remove_empty_read_more_span');

function null_remove_empty_read_more_span($content) {
	return preg_replace("(<span id=\"more-[0-9]{1,}\"></span>)", "", $content);
}

/***************************************************************
* Function null_oembed_wmode
* Fix oEmbed window mode for flash objects
***************************************************************/

add_filter('embed_oembed_html', 'null_oembed_wmode', 1);

function null_oembed_wmode( $embed ) {
    if ( strpos( $embed, '<param' ) !== false ) {
        $embed = str_replace( '<embed', '<embed wmode="transparent" ', $embed );
        $embed = preg_replace( '/param>/', 'param><param name="wmode" value="transparent" />', $embed, 1);
    }
    return $embed;
}

/***************************************************************
* Functions null_embed_html, null_embed_tweaks, null_oembed_result
* Wrap oembed in a container for responsive & use custom colours 
***************************************************************/

add_filter('embed_oembed_html', 'null_embed_html', 10, 4) ;
 
function null_embed_html($html, $url, $attr, $post_ID) {
	$url = str_replace(array('www.', '.com'), '', parse_url($url, PHP_URL_HOST));
    $return = '<figure class="o-container '.null_slugify($url).'">'.$html.'</figure>';
    return $return;
}

add_filter('oembed_fetch_url', 'null_embed_tweaks', 30, 3);

function null_embed_tweaks($provider, $args, $url) {

	// tweak vimeo colours to match theme settings
	if (null_string_search('vimeo', $provider)) {
		$provider = add_query_arg(apply_filters('null_viemo_features', array('color' => str_replace('#','', of_get_option('primary_colour', '#FFFFFF')))), $provider);
	}

	return $provider;
}

add_filter('oembed_result','null_oembed_result', 10, 3);

function null_oembed_result($html, $url, $args) {

	// light youtube player
 	if (preg_match("/youtube.com\/watch\?v=([^&]+)/i", $url, $match)){
        return str_replace('http://www.youtube.com/embed/' . $match[1] .'?feature=oembed', add_query_arg(apply_filters('null_youtube_features', array('feature' => 'oembed', 'fs' => 0, 'modestbranding' => 1, 'theme' => 'light', 'showinfo' => 1, 'autohide' => 0, 'rel' => 0)), 'http://www.youtube.com/embed/' . $match[1]), $html);
    }

    return $html;
}

/***************************************************************
* Function null_user_posts_count
* Count particular number of posts (pages, custom post types etc) by a user
***************************************************************/

function null_user_posts_count($userid, $post_type = 'post') {
	global $wpdb; 
	$where = get_posts_by_author_sql($post_type, TRUE, $userid);
  	$count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts $where");
  	return $count;
}

/***************************************************************
* Function null_estimated_reading_time
* Estimate the reading time of a chunk of content
***************************************************************/

if (!function_exists('null_estimated_reading_time')) {
	function null_estimated_reading_time($content) {
		$word = str_word_count(strip_tags($content));
		$m = floor($word / 200);
		$s = floor($word % 200 / (200 / 60));
		if ($m) {
			$est = sprintf(_n("%d minute", "%d minutes", $m), $m) . ', ' . sprintf(_n("%d second", "%d seconds", $s), $s);
		} else {
			$est = sprintf(_n("%d second", "%d seconds", $s), $s);
		}
		return $est;
	}
}

/***************************************************************
* Function null_comment
* Comment formatting & setup. Referenced in comments.php can be overwritten by child
***************************************************************/

if (!function_exists('null_comment')) {
	function null_comment( $comment, $args, $depth ) {
		
		global $post;
		
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
		case '' :
		?>
		<li>
		<article <?php comment_class(null_date_classes( mysql2date( 'U', $comment->comment_date ), 'c-' )); ?> id="comment-<?php comment_ID(); ?>" role="article">
			
			<header class="vcard">
				
				<?php echo get_avatar( $comment, 70 ); ?>
				
				<ul class="comment-meta">
					<li class="comment-author"><span class="fn n"><?php comment_author_link(); ?></span></li>
					<li class="comment-date"><time class="published" datetime="<?php comment_date('Y-m-d\TH:i:s') ?>"><?php comment_date('F jS, Y') ?> at <?php comment_time('H:i') ?></time></li>
			  	</ul>
			  	
			</header>
			
			<div class="comment-content">
				<?php if ($comment->comment_approved == '0') : ?><p class="notice"><?php _e('Your comment is awaiting moderation.', 'null'); ?></p><?php endif; ?>
				<?php comment_text() ?>
			</div>
	
			<footer>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				<?php edit_comment_link(__('Moderate', 'null'),'<span class="entry-edit comment-edit">','</span>'); ?>
			</footer>
					
		</article>
		<?php
		break;
		case 'pingback'  :
		case 'trackback' :
		// needs testing
		?>
		<li>
		<article <?php comment_class(null_date_classes( mysql2date( 'U', $comment->comment_date ), 'c-' ) . 'pingback'); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e('Pingback:','null'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('Moderate', 'null'),'<span class="entry-edit comment-edit">','</span>'); ?></p>
		</article>
		<?php
		break;
		endswitch;
		
	}
}

/***************************************************************
* Function null_date_class
* Generates time- and date-based classes for comments
***************************************************************/

function null_date_classes( $t, $p = '' ) {
	$t = $t + ( get_option('gmt_offset') * 3600 );
	$c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
	$c[] = $p . 'm' . gmdate( 'm', $t ); // Month
	$c[] = $p . 'd' . gmdate( 'd', $t ); // Day
	$c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
	
	return $c;
}

/***************************************************************
* Function null_paginate
* number based pagination, often a little flakey and can be overwritten by child
***************************************************************/

if (!function_exists('null_paginate')) {
	function null_paginate() {

		global $wp_query, $wp_rewrite;
		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
		
		$pagination = array(
			'base' => @add_query_arg('page','%#%'),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'end_size' => 3,
			'mid_size' => 3,
			'current' => $current,
			'show_all' => false,
			'type' => 'list',
			'next_text' => '&raquo;',
			'prev_text' => '&laquo;'
		);
		
		if ($wp_rewrite->using_permalinks()) {
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
		}
		
		if (!empty($wp_query->query_vars['s']))
			$pagination['add_args'] = array( 's' => get_query_var('s'));	
		
		echo paginate_links($pagination);
	}
}

/***************************************************************
* Function null_sidebar
* determine correct sidebar for current section can be overwritten by child
***************************************************************/

if (!function_exists('null_sidebar')) {
	function null_sidebar() {
		
		global $post;
		$post_type = get_post_type($post);

		if (is_front_page()) {
			dynamic_sidebar('homepage'); 
		} else if (is_page()) {
			dynamic_sidebar('page'); 
		} else if (is_search()) {
			dynamic_sidebar('search'); 
		} else if (((is_archive()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ($post_type == 'post')) { // essentially an is_blog() conditional
			dynamic_sidebar('posts'); 
		}
	}
}

/***************************************************************
* Function null_widget_classes
* Add first and last classes to widgets
***************************************************************/

add_filter('dynamic_sidebar_params','null_widget_classes');

function null_widget_classes($params) {

	global $my_widget_num;

	// get the id for the current sidebar we're processing
	$this_id = $params[0]['id']; 
	
	// get an array of ALL registered widgets
	$arr_registered_widgets = wp_get_sidebars_widgets(); 
		
	if (!$my_widget_num) { // If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	// check if the current sidebar has no widgets.. if not bail early
	if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { 
		return $params;
	}
	
	// see if the counter array has an entry for this sidebar
	if (isset($my_widget_num[$this_id])) { 
		$my_widget_num[$this_id] ++;
	} else {
		$my_widget_num[$this_id] = 1;
	}

	// add a widget number class for additional styling options
	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; 
	
	// first and last classes
	if ($my_widget_num[$this_id] == 1) {
		$class .= 'widget-first ';
	} else if($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'widget-last ';
	}

	// insert our new classes into "before widget"
	$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);
	return $params;
}

/***************************************************************
* Function null_footer_menu & null_footer_menu_fallback
* Build the footer menu and a suitable fallback
***************************************************************/

function null_footer_menu() {

	wp_nav_menu( 
		array( 
			'menu' => 'footer',
			'theme_location' => 'footer',
			'container' => 'false',
			'fallback_cb' => 'null_footer_menu_fallback',
			'depth' => 1
		)
	);
}

function null_footer_menu_fallback() {
	wp_page_menu('show_home='.__('Home','null')); 
}

/***************************************************************
* Function null_clean_page_menu
* Clean up the fallback page menus to be similar to wp_nav_menu
***************************************************************/

add_filter('wp_page_menu', 'null_clean_wp_page_menu');

function null_clean_wp_page_menu($page_markup) {
	$toreplace = array('<div class="menu">', '</div>');
	$new_markup = str_replace($toreplace, '', $page_markup);
	$new_markup = preg_replace('/^<ul>/i', '<ul class="menu">', $new_markup);
	return $new_markup; 
}


/***************************************************************
* Function null_mustache_tags
* Replace mustache style tags in some theme options
***************************************************************/

function null_mustache_tags($content) {
	$content = str_replace('{{year}}', date('Y'), $content);
	$content = str_replace('{{sitename}}', get_bloginfo('name'), $content);
	$content = str_replace('{{copyright}}', '&copy;', $content);
	return apply_filters('null_mustache_tags', $content);
}

/***************************************************************
* Function null_wp_footer
* Hook custom features into wp_footer
***************************************************************/

add_action('wp_footer', 'null_wp_footer');

function null_wp_footer() {
	
	// custom footer meta (from general settings)
	if ($meta = of_get_option('custom_footer_meta')) {
	?>
	
	<!-- custom footer meta -->
	<?php echo $meta . "\n"; ?>
	<?php
	}
}
?>