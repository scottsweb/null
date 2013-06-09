<?php

global $pagenow;

// only run this file on apache
if (stristr($_SERVER['SERVER_SOFTWARE'], 'apache') !== false) {

/***************************************************************
* Function null_htaccess_writable & null_htaccess_admin_notice
* Provide feedback that the .htaccess file is not writable
***************************************************************/

if ( is_admin() && isset($_GET['activated']) && $pagenow == "themes.php" ) {
	add_action('admin_init', 'null_htaccess_writable');
}

function null_htaccess_writable() {
	if (!is_writable(get_home_path() . '.htaccess')) {
		if (current_user_can('manage_options')) {
			add_action('admin_notices', 'null_htaccess_admin_notice');
		}
	}
}

function null_htaccess_admin_notice() {
	echo '<div class=\"error\"><p>' . sprintf(__('Please make sure your <a href="%s">.htaccess</a> file is writable ', 'null'), admin_url('options-permalink.php')) . '</p></div>';
}

/***************************************************************
* Function null_rewrites_www & null_mod_rewrites_www
* Handle redirects to www or non www version of website
***************************************************************/

add_action('generate_rewrite_rules', 'null_rewrites_www');
add_filter('mod_rewrite_rules', 'null_mod_rewrites_www');

function null_rewrites_www()
{
	global $wp_rewrite;
	
	// determine current theme folder name
	preg_match("/wp-content\/themes\/(.+)/", get_stylesheet_directory(), $bits);

	$non_wp_rules = array(
		//'c/(javascript|css)/(.*\.js|.*\.css)' => ltrim(get_template_directory(), '/') . '/assets/inc/combine.php?type=$1&files=$2', - compression
		'x1'			=> 'x1',
		'x2'			=> 'x2',
		'assets/(.*)'   => 'wp-content/themes/'.untrailingslashit($bits[1]).'/assets/$1',
		'plugins/(.*)'  => 'wp-content/plugins/$1',
		'admin/?$'		=> 'wp-login.php', // this could be improved - always forces a re-auth?
		'login/?$'		=> 'wp-login.php',
		'logout/?$'		=> 'wp-login.php'
	);

	// /uploads to /wp-content/uploads/folder if not year/month folder setup
	if (get_option('uploads_use_yearmonth_folders') != true) {
		$uploads = wp_upload_dir();
		$non_wp_rules['uploads/(.*)'] = ltrim($uploads['path'], '/') . '/$1';
	}

	$wp_rewrite->non_wp_rules = $non_wp_rules + $wp_rewrite->non_wp_rules;
}

function null_mod_rewrites_www($rules) {

	global $wp_filesystem;

	// redirect to www version of url at all times
	if (null_string_search('www',get_bloginfo('url'))) {
		$rules = str_replace('RewriteRule ^x1 /x1 [QSA,L]', "RewriteCond %{HTTPS} !=on\nRewriteCond %{HTTP_HOST} !^www\..+$ [NC]\nRewriteCond %{HTTP_HOST} (.+)$ [NC]", $rules);
		$rules = str_replace('RewriteRule ^x2 /x2 [QSA,L]', 'RewriteRule ^(.*)$ http://www.%1/$1 [R=301,L]', $rules);
	// else redirect to non www version
	} else {
		$rules = str_replace('RewriteRule ^x1 /x1 [QSA,L]', 'RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]', $rules);
		$rules = str_replace('RewriteRule ^x2 /x2 [QSA,L]', 'RewriteRule ^(.*)$ http://%1/$1 [R=301,L]', $rules);
	}

    if (!defined('FS_METHOD')) define('FS_METHOD', 'direct');
    if (is_null($wp_filesystem)) WP_Filesystem(array(), ABSPATH);

    $filename = dirname(__FILE__) . '/htaccess';
    
    return $rules . $wp_filesystem->get_contents($filename);
    	
}

/***************************************************************
* Function null_flush_htaccess_rules
* Flush rewrite rules on theme activation
***************************************************************/

add_action( 'load-themes.php', 'null_flush_htaccess_rules' );

function null_flush_htaccess_rules() {
	
	global $pagenow, $wp_rewrite;

	if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php") {
		
		// flush/add our rewrite rules to htaccess
		$wp_rewrite->flush_rules();
		
	}
}
}
?>