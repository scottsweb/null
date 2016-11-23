<?php

/***************************************************************
* Function optionsframework_options
* Defines an array of options that will be used to generate the settings page
***************************************************************/

function optionsframework_options() {

	// For settings examples see: https://github.com/devinsays/options-framework-theme/blob/master/options.php
	// General settings - GA, tracking code custom

	$general_options = array();

	$general_options['general_heading'] = array(
		"name" => __('General', 'null'),
		"type" => "heading"
	);

	$general_options['maintenance_mode'] = array(
		"name" => __('Enable Maintenance Mode?', 'null'),
		"desc" => __('Will bring down your site for the public (users that are not logged in and cannot edit_theme_options. /wp-admin is still accessible).', 'null'),
		"id" => "maintenance_mode",
		"std" => "0",
		"type" => "checkbox"
	);

	$general_options['gat'] = array(
		"name" => __('Google Analytics', 'null'),
		"desc" => __('Enter your Google Analytics tracking ID: <strong>UA-XXXXX-X</strong>', 'null'),
		"id" => "gat",
		"std" => "",
		"class" => "mini",
		"type" => "text"
	);

	$general_options['gat_external_download'] = array(
		"name" => __('Track External Links &amp; Downloads?', 'null'),
		"desc" => __('Track downloaded files and external links as events in Google Analytics?', 'null'),
		"id" => "gat_external_download",
		"std" => "0",
		"type" => "checkbox"
	);

	$general_options['custom_header_meta'] = array(
		"name" => __('Header Meta', 'null'),
		"desc" => __('Add custom meta data to the theme header. e.g. Feedburner or Google Webmaster Tools.', 'null'),
		"id" => "custom_header_meta",
		"std" => "",
		"type" => "textarea"
	);

	$general_options['show_tagline'] = array(
		"name" => __('Header Tagline', 'null'),
		"desc" => __('Display the site description in the header alongside the logo?', 'null'),
		"id" => "show_tagline",
		"std" => "1",
		"type" => "checkbox"
	);

	$general_options['breadcrumbs'] = array(
		"name" => __('Breadcrumbs', 'null'),
		"desc" => __('Toggle to enable breadcrumbs.', 'null'),
		"id" => "breadcrumbs",
		"std" => "0",
		"type" => "checkbox"
	);

	$general_options['footer_sidebar'] = array(
		"name" => __('Footer Sidebar', 'null'),
		"desc" => sprintf( __('Toggle to output the <a href="$s">footer sidebar</a> in your site footer.', 'null'), admin_url('widgets.php') ),
		"id" => "footer_sidebar",
		"std" => "1",
		"type" => "checkbox"
	);

	$general_options['custom_footer_meta'] = array(
		"name" => __('Footer Meta', 'null'),
		"desc" => __('Add custom meta data to the theme footer. e.g. Tracking codes.', 'null'),
		"id" => "custom_footer_meta",
		"std" => "",
		"type" => "textarea"
	);

	$general_options['wordpress_credit'] = array(
		"name" => __('WordPress Credit', 'null'),
		"desc" => __('Available tags: {{year}} {{sitename}} {{copyright}}', 'null'),
		"id" => "wordpress_credit",
		"std" => 'Powered by <a href="http://wordpress.org/" title="WordPress" rel="generator">WordPress</a> &amp; the <a href="http://null.scott.ee/" title="null framework">null framework</a>.',
		"class" => "large",
		"type" => "text"
	);

	$general_options['theme_credit'] = array(
		"name" => __('Designer Credit', 'null'),
		"desc" => __('Available tags: {{year}} {{sitename}} {{copyright}}', 'null'),
		"id" => "theme_credit",
		"std" => 'Designed by <a href="http://scott.ee" title="WordPress website design by Scott Evans." rel="designer">Scott Evans</a>.',
		"class" => "large",
		"type" => "text"
	);

	$general_options = apply_filters('null_general_options', $general_options);

	// Design related settings

	$design_options = array();

	$design_options['design_heading'] = array(
		"name" => __('Design', 'null'),
		"type" => "heading"
	);

	$background_images = get_template_directory_uri() . '/assets/images/';

	$design_options['background_image'] = array(
		"name" => __('Background Texture', 'null'),
		"desc" => __('Choose a background style, courtesy of <a href="http://subtlepatterns.com/">subtlepatterns.com</a>.', 'null'),
		"id" => "background_image",
		"std" => "bg-struckaxiom",
		"type" => "images",
		"options" => array(
			'bg-struckaxiom' => $background_images . 'bg-struckaxiom-square.png',
			'bg-wood' => $background_images . 'bg-wood-square.png',
			'bg-carbon-fibre' => $background_images . 'bg-carbon-fibre-square.png',
			'bg-tactile-noise' => $background_images . 'bg-tactile-noise-square.png',
			'bg-washi' => $background_images . 'bg-washi-square.png',
			'bg-pixels' => $background_images . 'bg-pixels-square.png'
		)
	);

	$design_options['primary_colour'] = array(
		"name" => __('Primary Colour', 'null'),
		"desc" => __('Primary colour for your website. Available as <strong>@primarycol</strong> in your LESS/CSS.', 'null'),
		"id" => "primary_colour",
		"std" => "#141414",
		"type" => "color"
	);

	$design_options['body_colour'] = array(
		"name" => __('Body Colour', 'null'),
		"desc" => __('Colour used for typographic elements. Available as <strong>@bodycol</strong> in your LESS/CSS.', 'null'),
		"id" => "body_colour",
		"std" => "#141414",
		"type" => "color"
	);

	$design_options['link_colour'] = array(
		"name" => __('Link Colour', 'null'),
		"desc" => __('Link colour. Available as <strong>@linkcol</strong> in your LESS/CSS.', 'null'),
		"id" => "link_colour",
		"std" => "#0000EE",
		"type" => "color"
	);

	$design_options['link_hover_colour'] = array(
		"name" => __('Link Hover Colour', 'null'),
		"desc" => __('Link Hover colour. Available as <strong>@linkhovercol</strong> in your LESS/CSS.', 'null'),
		"id" => "link_hover_colour",
		"std" => "#551A8B",
		"type" => "color"
	);

	$design_options['heading_font'] = array(
		"name" => __('Heading Font', 'null'),
		"desc" => __('Choose your heading font from the <a href="http://www.google.com/webfonts">Google Web Font</a> directory or default system fonts.', 'null'),
		"id" => "heading_font",
		"std" => "Cabin",
		"type" => "select",
		"class" => "mini",
		"options" => null_get_fonts()
	);

	$design_options['body_font'] = array(
		"name" => __('Body Font', 'null'),
		"desc" => __('Choose your body font from the <a href="http://www.google.com/webfonts">Google Web Font</a> directory or default system fonts.', 'null'),
		"id" => "body_font",
		"std" => "a1",
		"type" => "select",
		"class" => "mini",
		"options" => null_get_fonts()
	);

	// logo font ?
	// strapline font ?

	$design_options['gravatar'] = array(
		"name" => __('Gravatar', 'null'),
		"desc" => __('Square <a href="http://en.gravatar.com/">gravatar fallback</a>. Max of 512px by 512px.', 'null'),
		"id" => "gravatar",
		"type" => "upload"
	);

	// only add these settings if ios meta has been enabled

	$advanced_header_meta = of_get_option('advanced_header_meta', array(
		'ios_app'			=> "0",
		'ie9_app'			=> "1"
	));

	if ($advanced_header_meta['ios_app'] == "1") {

		$design_options['iphone_splash'] = array(
			"name" => __('iPhone App Splash Screen', 'null'),
			"desc" => __('A 320px by 460px .png file for iOS.', 'null'),
			"id" => "iphone_splash",
			"type" => "upload"
		);

		$design_options['ipad_splash'] = array(
			"name" => __('iPad App Splash Screen (Portrait)', 'null'),
			"desc" => __('Portrait image has to be 748px by 1024px.', 'null'),
			"id" => "ipad_splash_portrait",
			"type" => "upload"
		);

		$design_options['ipad_splash_landscape'] = array(
			"name" => __('iPad App Splash Screen (Landscape)', 'null'),
			"desc" => __('Landscape image has to be 1024px by 748px.', 'null'),
			"id" => "ipad_splash_landscape",
			"type" => "upload"
		);

	}

	if ($advanced_header_meta['ie9_app'] == "1") {

		$design_options['ie9_colour'] = array(
			"name" => __('IE9+/Win8/Chrome Android Pinned Application Colour', 'null'),
			"desc" => __('Used for browser buttons and for the Windows 8 touch tile.', 'null'),
			"id" => "ie9_colour",
			"std" => "#141414",
			"type" => "color"
		);

	}

	$design_options = apply_filters('null_design_options', $design_options);

	// Social settings (Twitter, YouTube etc)

	$social_options = array();

	$social_options['social_heading'] = array(
		"name" => __('Social', 'null'),
		"type" => "heading"
	);

	$social_options['delicious'] = array(
		"name" => __('Delicious', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "delicious",
		"class" => "large",
		"type" => "text"
	);

	$social_options['dribbble'] = array(
		"name" => __('Dribbble', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "dribbble",
		"class" => "large",
		"type" => "text"
	);

	$social_options['facebook'] = array(
		"name" => __('Facebook', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "facebook",
		"class" => "large",
		"type" => "text"
	);

	$social_options['flickr'] = array(
		"name" => __('Flickr', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "flickr",
		"class" => "large",
		"type" => "text"
	);

	$social_options['github'] = array(
		"name" => __('GitHub', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "github",
		"class" => "large",
		"type" => "text"
	);

	$social_options['googleplus'] = array(
		"name" => __('Google+', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "googleplus",
		"class" => "large",
		"type" => "text"
	);

	$social_options['instagram'] = array(
		"name" => __('Instagram', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "instagram",
		"class" => "large",
		"type" => "text"
	);

	$social_options['linkedin'] = array(
		"name" => __('LinkedIn', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "linkedin",
		"class" => "large",
		"type" => "text"
	);

	$social_options['pinterest'] = array(
		"name" => __('Pinterest', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "pinterest",
		"class" => "large",
		"type" => "text"
	);

	$social_options['soundcloud'] = array(
		"name" => __('SoundCloud', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "soundcloud",
		"class" => "large",
		"type" => "text"
	);

	$social_options['twitter'] = array(
		"name" => __('Twitter', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "twitter",
		"class" => "large",
		"type" => "text"
	);

	$social_options['twitterusername'] = array(
		"name" => __('Twitter @Username', 'null'),
		"desc" => __('Username beginning with @.', 'null'),
		"id" => "twitterusername",
		"class" => "large",
		"type" => "text"
	);

	$social_options['vimeo'] = array(
		"name" => __('Vimeo', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "vimeo",
		"class" => "large",
		"type" => "text"
	);

	$social_options['youtube'] = array(
		"name" => __('YouTube', 'null'),
		"desc" => __('URL to your profile.', 'null'),
		"id" => "youtube",
		"class" => "large",
		"type" => "text"
	);

	$social_options = apply_filters('null_social_options', $social_options);

	// WordPress settings (inc post types, shortcodes and widgets) - disable browser update nag and upgrade bubbles and whats new, disable update notices for non-admins

	$wordpress_options = array();

	$wordpress_options['wordpress_heading'] = array(
		"name" => __('WordPress', 'null'),
		"type" => "heading"
	);

	global $wp_roles;
	$role_list = array();

	foreach ($wp_roles->role_names as $role_nice => $role_name) {
		if ($role_name != "Pending") {
			$role_list[$role_nice] = str_replace('|User role', '', $role_name);
		}
	}

	ksort($role_list);

	$wordpress_options['admin_bar_disable'] = array(
		"name" => __('Disable Admin Bar', 'null'),
		"desc" => __('Disable the admin bar on the front end for the toggled user roles.', 'null'),
		"id" => "admin_bar_disable",
		"type" => "multicheck",
		"options" => $role_list
	);

	$wordpress_options['admin_bar_attachment'] = array(
		"name" => __('Admin Bar Attachment', 'null'),
		"desc" => __('Change how the admin bar attaches to the browser.', 'null'),
		"id" => "admin_bar_attachment",
		"std" => "fixed",
		"type" => "select",
		"class" => "mini", //mini, tiny, small
		"options" => array(
			'fixed' => __('Fixed (default)', 'null'),
			'absolute' => __('Absolute', 'null')
		)
	);

	$wordpress_options['howdy'] = array(
		"name" => __('Howdy?', 'null'),
		"desc" => __('Change the admin bar welcome message.', 'null'),
		"id" => "howdy",
		"std" => "",
		"class" => "mini",
		"type" => "text"
	);

	$wordpress_options['dashboard_widgets'] = array(
		"name" => __('Dashboard Widgets', 'null'),
		"desc" => __('Toggle WordPress dashboard widgets.', 'null'),
		"id" => "dashboard_widgets",
		"std" => array(
			'dashboard_browser_nag'		=> "1",
			'dashboard_incoming_links'	=> "1",
			'dashboard_plugins' 		=> "0",
			'dashboard_primary' 		=> "1",
			'dashboard_quick_press'		=> "1",
			'dashboard_recent_comments' => "1",
			'dashboard_recent_drafts'	=> "1",
			'dashboard_right_now'		=> "0",
			'dashboard_secondary' 		=> "0"
		),
		"type" => "multicheck",
		"options" => array(
			'dashboard_browser_nag'		=> __('Browser Upgrade Notification (Browse Happy)','null'),
			'dashboard_incoming_links' 	=> __('Incoming Links Widget', 'null'),
			'dashboard_plugins' 		=> __('Plugins Widget', 'null'),
			'dashboard_primary' 		=> __('Primary RSS Widget', 'null'),
			'dashboard_quick_press' 	=> __('Quick Press Widget', 'null'),
			'dashboard_recent_comments' => __('Recent Comments Widget', 'null'),
			'dashboard_recent_drafts' 	=> __('Recent Drafts Widget', 'null'),
			'dashboard_right_now' 		=> __('Right Now Widget', 'null'),
			'dashboard_secondary' 		=> __('Secondary RSS Widget', 'null')
		)
	);

	$wordpress_options['post_formats'] = array(
		"name" => __('Post Formats', 'null'),
		"desc" => __('Enable support for <a href="http://codex.wordpress.org/Post_Formats">WordPress post formats</a>.', 'null'),
		"id" => "post_formats",
		"std" => "0",
		"type" => "checkbox"
	);

	$wordpress_options['post_format_types'] = array(
		"name" => __('Post Format Types', 'null'),
		"desc" => __('Which <a href="http://codex.wordpress.org/Post_Formats#Supported_Formats">post format types</a> would you like to support?', 'null'),
		"id" => "post_format_types",
		"std" => array(
			'aside' 	=> "1",
			'audio'		=> "1",
			'chat'		=> "1",
			'gallery' 	=> "1",
			'image'		=> "1",
			'link' 		=> "1",
			'quote' 	=> "1",
			'status' 	=> "1",
			'video' 	=> "1"
		),
		"type" => "multicheck",
		"options" => array(
			'aside' 	=> __('Aside', 'null'),
			'audio'		=> __('Audio', 'null'),
			'chat'		=> __('Chat', 'null'),
			'gallery' 	=> __('Gallery', 'null'),
			'image'		=> __('Image', 'null'),
			'link' 		=> __('Link', 'null'),
			'quote' 	=> __('Quote', 'null'),
			'status' 	=> __('Status', 'null'),
			'video' 	=> __('Video', 'null')
		)
	);

	$extension_post_types = null_get_extensions('post-types', true);
	if (!empty($extension_post_types)) {
		$wordpress_options['additional_post_types'] = array(
			"name" => __('Additional Post Types', 'null'),
			"desc" => __('Toggle additional post types. Additional post types are found in the <strong>/null/assets/inc/post-types/</strong> folder or the same folder in your child theme.', 'null'),
			"id" => "additional_post_types",
			"std" => array(),
			"type" => "multicheck",
			"options" => $extension_post_types
		);
	}

	$extension_shortcodes = null_get_extensions('shortcodes', true);
	if (!empty($extension_shortcodes)) {
		$wordpress_options['additional_shortcodes'] = array(
			"name" => __('Shortcodes', 'null'),
			"desc" => __('Toggle shortcode support. Additional shortcodes are found in the <strong>/null/assets/inc/shortcodes/</strong> folder or the same folder in your child theme.', 'null'),
			"id" => "additional_shortcodes",
			"std" => array(),
			"type" => "multicheck",
			"options" => $extension_shortcodes
		);
	}

	$wordpress_options['wordpress_widgets'] = array(
		"name" => __('WordPress Widgets', 'null'),
		"desc" => __('Toggle default WordPress widgets.', 'null'),
		"id" => "wordpress_widgets",
		"std" => array(
			'archives_widget' 			=> "1",
			'calendar_widget'			=> "1",
			'categories_widget'			=> "1",
			'custom_menu_widget'		=> "1",
			'links_widget'				=> "1",
			'meta_widget'				=> "1",
			'pages_widget'		 		=> "1",
			'recent_comments_widget'	=> "1",
			'recent_posts_widget' 		=> "1",
			'rss_widget'				=> "1",
			'search_widget' 			=> "1",
			'tag_cloud_widget'			=> "1",
			'text_widget'				=> "1"
		),
		"type" => "multicheck",
		"options" => array(
			'archives_widget' 			=> __('Archives Widget', 'null'),
			'calendar_widget'			=> __('Calendar Widget', 'null'),
			'categories_widget'			=> __('Categories Widget', 'null'),
			'custom_menu_widget'		=> __('Custom Menu Widget', 'null'),
			'links_widget'				=> __('Links Widget', 'null'),
			'meta_widget'				=> __('Meta Widget', 'null'),
			'pages_widget'		 		=> __('Pages Widget', 'null'),
			'recent_comments_widget'	=> __('Recent Comments Widget', 'null'),
			'recent_posts_widget' 		=> __('Recent Posts Widget', 'null'),
			'rss_widget'				=> __('RSS Widget', 'null'),
			'search_widget' 			=> __('Search Widget', 'null'),
			'tag_cloud_widget'			=> __('Tag Cloud Widget', 'null'),
			'text_widget'				=> __('Text Widget', 'null')
		)
	);

	$extension_widgets = null_get_extensions('widgets', true);
	if (!empty($extension_widgets)) {
		$wordpress_options['additional_widgets'] = array(
			"name" => __('Additional Widgets', 'null'),
			"desc" => __('Toggle additional widgets. Additional widgets are found in the <strong>/null/assets/inc/widgets/</strong> folder or the same folder in your child theme.', 'null'),
			"id" => "additional_widgets",
			"std" => array(),
			"type" => "multicheck",
			"options" => $extension_widgets
		);
	}

	$wordpress_options = apply_filters('null_wordpress_options', $wordpress_options);

	// Email Settings

	$email_options = array();

	$email_options['email_heading'] = array(
		"name" => __('E-Mail', 'null'),
		"type" => "heading"
	);

	$email_options['email_from_name'] = array(
		"name" => __('Email From', 'null'),
		"desc" => __('Personalise outgoing e-mail with a from name.', 'null'),
		"id" => "email_from_name",
		"std" => get_bloginfo('name'),
		"class" => "large",
		"type" => "text"
	);

	$email_options['email_from'] = array(
		"name" => __('Email From Address', 'null'),
		"desc" => __('WordPress should send email from this address.', 'null'),
		"id" => "email_from",
		"std" => get_bloginfo('admin_email'),
		"class" => "large",
		"type" => "text"
	);

	$email_options['email_encode'] = array(
		"name" => __('Email Encoding / Anti Spam', 'null'),
		"desc" => __('Encode email addresses added to the content editor (TinyMCE) ?', 'null'),
		"id" => "email_encode",
		"std" => "1",
		"type" => "checkbox"
	);

	$email_options = apply_filters('null_email_options', $email_options);

	// Performance settings (html, css, js compress, combine etc)
	// Move these to advanced as these will most likely be the only options going forward?
	$performance_options = array();

	/*$performance_options['performance_heading'] = array(
		"name" => __('Performance', 'null'),
		"type" => "heading"
	);

	$performance_options['performance_intro'] = array(
		"name" => __("Performance?", 'null'),
		"desc" => __('Please refer to the <a href="'.admin_url('/plugins.php?page=install-compatible-plugins').'">recommended plugins section</a> for a number of the best performance/caching plugins. I still have plans to optimise the framework (reducing memory &amp; database queries) for v1.0. If you have any tips, please <a href="https://github.com/scottsweb/null">get in touch</a>.', 'null'),
		"type" => "info"
	);

	$performance_options['html_compression'] = array(
		"name" => __('HTML Compression', 'null'),
		"desc" => __('Compress HTML output (more options when toggled on).', 'null'),
		"id" => "html_compression",
		"std" => "1",
		"type" => "checkbox"
	);

	$performance_options['html_compression_options'] = array(
		"name" => __('HTML Compression Options', 'null'),
		"desc" => __('Which HTML features would you like to compress?', 'null'),
		"id" => "html_compression_options",
		"std" => array(
			'html_css'				=> '1',
			'html_js'				=> '0',
			'html_comments'			=> '1'
		),
		"type" => "multicheck",
		"options" => array(
			'html_css'				=> __('Inline CSS','null'),
			'html_js'				=> __('Inline JS','null'),
			'html_comments'			=> __('HTML Comments','null')
		)
	);*/

	$performance_options = apply_filters('null_performance_options', $performance_options);

	// Advanced Settings polyfills etc

	$advanced_options = array();

	$advanced_options['advanced_heading'] = array(
		"name" => __('Advanced', 'null'),
		"type" => "heading"
	);

	$advanced_options['login_redirect_url'] = array(
		"name" => __('Login Redirect URL', 'null'),
		"desc" => __('Change the default <a href="http://codex.wordpress.org/Function_Reference/wp_login_url">login URL</a> redirect for WordPress. Can be left blank for default functionality.', 'null'),
		"id" => "login_redirect_url",
		"std" => "",
		"class" => "large",
		"type" => "text"
	);

	$advanced_options['logout_redirect_url'] = array(
		"name" => __('Logout Redirect URL', 'null'),
		"desc" => __('Change the default <a href="http://codex.wordpress.org/Function_Reference/wp_logout">logout URL</a> redirect for WordPress. Can be left blank for default functionality.', 'null'),
		"id" => "logout_redirect_url",
		"std" => "",
		"class" => "large",
		"type" => "text"
	);

	$advanced_options['header_meta'] = array(
		"name" => __('WordPress Header Meta', 'null'),
		"desc" => __('Toggle certain WordPress meta data found in the theme header.', 'null'),
		"id" => "header_meta",
		"std" => array(
			'canonical' 		=> "1",
			'extra_feed_links'	=> "0",
			'generator'			=> "0",
			'rsd'				=> "1",
			'relational'		=> "0",
			'feed_links' 		=> "1",
			'shortlink' 		=> "0",
			'windows' 			=> "0"
		),
		"type" => "multicheck",
		"options" => array(
			'canonical'	 		=> __('Canonical', 'null'),
			'extra_feed_links'	=> __('Extra Feed Links (Categories etc)', 'null'),
			'generator'			=> __('Generator Tag', 'null'),
			'rsd'				=> __('Really Simple Discovery / XML-RPC','null'),
			'relational'		=> __('Related Posts', 'null'),
			'feed_links' 		=> __('RSS Feed Links', 'null'),
			'shortlink' 		=> __('Shortlink', 'null'),
			'windows' 			=> __('Windows Live Tag', 'null')
		)
	);

	// some additional future options for mobile: http://learnthemobileweb.com/2009/07/mobile-meta-tags/
	// addition ie9 settings: http://html5boilerplate.com/docs/html-head/#ie-pinned-sites-ie9
	// add social media to ie9 output: http://www.jonhartmann.com/index.cfm/2010/9/15/Getting-Started-with-IE9-Pinned-Applications-and-Jumplists
	$advanced_options['advanced_header_meta'] = array(
		"name" => __('Advanced Header Meta', 'null'),
		"desc" => __('Toggle advanced meta data in the theme header.', 'null'),
		"id" => "advanced_header_meta",
		"std" => array(
			'ie9_app'			=> "1",
			'ios_app'			=> "0"
		),
		"type" => "multicheck",
		"options" => array(
			'ie9_app'			=> __('IE9+ Pinned Application (if enabled set colour in Design tab)','null'),
			'ios_app'			=> __('iOS Web App (if enabled set custom splash images in Design tab)','null')
		)
	);

	$advanced_options['polyfills'] = array(
		"name" => __('Polyfills ', 'null'),
		"desc" => __('Patch up certain browsers with <a href="https://github.com/Modernizr/Modernizr/wiki/HTML5-Cross-Browser-Polyfills">JavaScript polyfills</a>?', 'null'),
		"id" => "polyfills",
		"std" => array(
			'imgsizer'		=> "0",
			'html5_forms'	=> "1",
			'ios' 			=> "1",
			'selectivizr'	=> "0",
		),
		"type" => "multicheck",
		"options" => array(
			'imgsizer'	 	=> __('Fluid Images (IE7,IE8)', 'null'),
			'html5_forms' 	=> __('HTML5 Forms (standardise form behaviour across all browsers)', 'null'),
			'ios' 			=> __('Screen Rotation Scale Bug (iOS)', 'null'),
			'selectivizr'	=> __('Selectivizr CSS3 Selectors (IE7,IE8)', 'null')
		)
	);

	// only show this when commenting and trackbacks are toggled off
	if (get_option('default_comment_status') == 'closed' && get_option('default_ping_status') == 'closed') {
		$advanced_options['disable_comments'] = array(
			"name" => __('Disable Comments', 'null'),
			"desc" => sprintf( __('This will remove meta boxes, comment related table columns, the comments admin menu and the <a href="$s">discussion settings menu</a>.', 'null'), admin_url('options-discussion.php') ),
			"id" => "disable_comments",
			"std" => "0",
			"type" => "checkbox"
		);
	}

	$advanced_options['disable_rss'] = array(
		"name" => __('Disable RSS', 'null'),
		"desc" => __('Disable access to all RSS feeds.', 'null'),
		"id" => "disable_rss",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['disable_search'] = array(
		"name" => __('Disable Search', 'null'),
		"desc" => __('Disable WordPress search functionality.', 'null'),
		"id" => "disable_search",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['disable_welcome'] = array(
		"name" => __('Disable Welcome Message', 'null'),
		"desc" => __('Disable the friendly welcome message for first-time users in WordPress 3.3+.', 'null'),
		"id" => "disable_welcome",
		"std" => "1",
		"type" => "checkbox"
	);

	$advanced_options['disable_pointers'] = array(
		"name" => __('Disable Pointer Tips', 'null'),
		"desc" => __('Disable the pointer / new feature tooltips in WordPress 3.3+.', 'null'),
		"id" => "disable_pointers",
		"std" => "1",
		"type" => "checkbox"
	);

	$advanced_options['disable_acf'] = array(
		"name" => __('Enable ACF Lite Mode', 'null'),
		"desc" => __('Load Advanced Custom Fields in lite mode. Hides menu entry and disables the ability to manage fields.', 'null'),
		"id" => "disable_acf",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['disable_drag_meta'] = array(
		"name" => __('Disable Dragging Meta Boxes', 'null'),
		"desc" => __('Disable the ability to re-order and drag meta boxes.', 'null'),
		"id" => "disable_drag_meta",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['page_break'] = array(
		"name" => __('Page Break', 'null'),
		"desc" => __('Enable support for page breaks. Adds a new button to the editor.', 'null'),
		"id" => "page_break",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['custom_header'] = array(
		"name" => __('Custom Header', 'null'),
		"desc" => __('Enable support for setting a custom <a href="http://codex.wordpress.org/Custom_Headers">theme header</a> within WordPress.', 'null'),
		"id" => "custom_header",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['custom_background'] = array(
		"name" => __('Custom Background', 'null'),
		"desc" => __('Enable support for setting a custom <a href="http://codex.wordpress.org/Custom_Backgrounds">theme background</a> within WordPress.', 'null'),
		"id" => "custom_background",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['all_settings'] = array(
		"name" => __('All Settings', 'null'),
		"desc" => __('Enable the hidden <strong>All Settings</strong> WordPress menu for administrators.', 'null'),
		"id" => "all_settings",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['disable_updates'] = array(
		"name" => __('Disable Update Notifications', 'null'),
		"desc" => __('Disable update notifications for any user that is not an administrator (ties into the update_plugins capability).', 'null'),
		"id" => "disable_updates",
		"std" => "1",
		"type" => "checkbox"
	);

	// only provide cleanup option if not child theme or multisite
	if (!is_multisite() && !is_child_theme()) {
		$advanced_options['cleanup'] = array(
			"name" => __('Cleanup URLs', 'null'),
			"desc" => __('Rewrite WordPress URLs for cleaner HTML (e.g. /assets/, /uploads/ etc).', 'null'),
			"id" => "cleanup",
			"std" => "0",
			"type" => "checkbox"
		);
	}

	$advanced_options['force_rewrite'] = array(
		"name" => __('Force Rewrite', 'null'),
		"desc" => __('On some servers WordPress incorrectly detects rewrite functionality (e.g. Nginx). Checking this will force rewrite features.', 'null'),
		"id" => "force_rewrite",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['development_mode'] = array(
		"name" => __('Development Mode', 'null'),
		"desc" => __('Development mode outputs memory and performance data in the footer of your HTML. For a comprehensive development tool try <a href="http://wordpress.org/extend/plugins/debug-bar/">debug bar</a> and add define(\'WP_DEBUG\', true); to your wp-config.php file.', 'null'),
		"id" => "development_mode",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options['development_mode_holmes'] = array(
		"name" => __('Holmes', 'null'),
		"desc" => __('Highlight HTML problems  with <a href="http://www.red-root.com/sandbox/holmes/">holmes</a>, the CSS markup detective.', 'null'),
		"id" => "development_mode_holmes",
		"std" => "0",
		"type" => "checkbox"
	);

	$advanced_options = apply_filters('null_advanced_options', $advanced_options);

	// return all options as single array
	$options = array_merge($general_options, $design_options, $social_options, $wordpress_options, $email_options, $performance_options, $advanced_options);
	$options = apply_filters('null_options', $options);
	return $options;
}

/***************************************************************
* Function null_options_theme_customiser
* Take some of the settings from above and make them available in the 3.4+ theme customiser
***************************************************************/

add_action('customize_register', 'null_options_theme_customiser');

function null_options_theme_customiser($wp_customize) {

	// grab our options from above
	$options = optionsframework_options();

	// layout section
	$wp_customize->add_section( 'null_options_theme_customiser_layout', array(
			'title' => __( 'Layout', 'null' ),
			'priority' => 190
	));

	// tagline
	if (isset($options['show_tagline'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[show_tagline]', array(
			'default' => $options['show_tagline']['std'],
			'type' => 'option'
		) );

		$wp_customize->add_control( NULL_OPTION_NAME.'_show_tagline', array(
			'label' => $options['show_tagline']['name'],
			'section' => 'null_options_theme_customiser_layout',
			'settings' => NULL_OPTION_NAME.'[show_tagline]',
			'type' => $options['show_tagline']['type'],
		) );
	}

	// breadcrumbs
	if (isset($options['breadcrumbs'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[breadcrumbs]', array(
			'default' => $options['breadcrumbs']['std'],
			'type' => 'option'
		) );

		$wp_customize->add_control( NULL_OPTION_NAME.'_breadcrumbs', array(
			'label' => $options['breadcrumbs']['name'],
			'section' => 'null_options_theme_customiser_layout',
			'settings' => NULL_OPTION_NAME.'[breadcrumbs]',
			'type' => $options['breadcrumbs']['type'],
		) );
	}

	// footer_sidebar
	if (isset($options['footer_sidebar'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[footer_sidebar]', array(
			'default' => $options['footer_sidebar']['std'],
			'type' => 'option'
		) );

		$wp_customize->add_control( NULL_OPTION_NAME.'_footer_sidebar', array(
			'label' => $options['footer_sidebar']['name'],
			'section' => 'null_options_theme_customiser_layout',
			'settings' => NULL_OPTION_NAME.'[footer_sidebar]',
			'type' => $options['footer_sidebar']['type'],
		) );
	}

	// design section
	$wp_customize->add_section( 'null_options_theme_customiser_design', array(
		'title' => __( 'Design', 'null' ),
		'priority' => 200
	) );

	// logo
	if (isset($options['logo'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[logo]', array(
			//'default' => $options['logo']['std'],
			'type' => 'option'
		) );

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, NULL_OPTION_NAME.'_logo', array(
			'label' => $options['logo']['name'],
			'section' => 'null_options_theme_customiser_design',
			'settings' => NULL_OPTION_NAME.'[logo]',
			'priority' => 1
		)));
	}

	// primary colour
	if (isset($options['primary_colour'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[primary_colour]', array(
			'default' => $options['primary_colour']['std'],
			'type' => 'option',
			'transport' => 'refresh'
		) );

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, NULL_OPTION_NAME.'_primary_colour', array(
			'label' => $options['primary_colour']['name'],
			'section' => 'null_options_theme_customiser_design',
			'settings' => NULL_OPTION_NAME.'[primary_colour]',
			'priority' => 2
		)));
	}

	// body colour
	if (isset($options['body_colour'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[body_colour]', array(
			'default' => $options['body_colour']['std'],
			'type' => 'option',
			//'transport' => 'refresh'
		) );

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, NULL_OPTION_NAME.'_body_colour', array(
			'label' => $options['body_colour']['name'],
			'section' => 'null_options_theme_customiser_design',
			'settings' => NULL_OPTION_NAME.'[body_colour]',
			'priority' => 3
		)));
	}

	// link colour
	if (isset($options['link_colour'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[link_colour]', array(
			'default' => $options['link_colour']['std'],
			'type' => 'option'
		) );

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, NULL_OPTION_NAME.'_link_colour', array(
			'label' => $options['link_colour']['name'],
			'section' => 'null_options_theme_customiser_design',
			'settings' => NULL_OPTION_NAME.'[link_colour]',
			'priority' => 4
		)));
	}

	// link hover colour
	if (isset($options['link_hover_colour'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[link_hover_colour]', array(
			'default' => $options['link_hover_colour']['std'],
			'type' => 'option'
		) );

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, NULL_OPTION_NAME.'_link_hover_colour', array(
			'label' => $options['link_hover_colour']['name'],
			'section' => 'null_options_theme_customiser_design',
			'settings' => NULL_OPTION_NAME.'[link_hover_colour]',
			'priority' => 5
		)));
	}

	// heading font
	if (isset($options['heading_font'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[heading_font]', array(
			'default' => $options['heading_font']['std'],
			'type' => 'option',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(NULL_OPTION_NAME.'_heading_font', array(
			'label' => $options['heading_font']['name'],
			'section' => 'null_options_theme_customiser_design',
			'settings' => NULL_OPTION_NAME.'[heading_font]',
			'type' => $options['heading_font']['type'],
			'choices' => $options['heading_font']['options'],
			'priority' => 6
		));
	}

	// body font
	if (isset($options['body_font'])) {
		$wp_customize->add_setting(NULL_OPTION_NAME.'[body_font]', array(
			'default' => $options['body_font']['std'],
			'type' => 'option',
			'transport' => 'refresh'
		) );

		$wp_customize->add_control(NULL_OPTION_NAME.'_body_font', array(
			'label' => $options['body_font']['name'],
			'section' => 'null_options_theme_customiser_design',
			'settings' => NULL_OPTION_NAME.'[body_font]',
			'type' => $options['body_font']['type'],
			'choices' => $options['body_font']['options'],
			'priority' => 7
		));
	}
}