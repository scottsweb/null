<?php

/***************************************************************
* Function null_hide_theme
* Stop the theme/child theme from checking the WordPress.org API for updates
***************************************************************/

add_filter('http_request_args', 'null_hide_theme', 5, 2 );

function null_hide_theme($r, $url) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // not a theme update request. bail.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[get_option('template')]);
	unset( $themes[get_option('stylesheet')]);
	$r['body']['themes'] = serialize($themes);
	return $r;
}

/***************************************************************
* Function null_check_for_update
* Check for a framework automatic update from Github
***************************************************************/

add_filter('pre_set_site_transient_update_themes', 'null_check_for_update');

function null_check_for_update($checked_data) {
	
	// check if the transient contains the 'checked' information. if not, just return its value without hacking it
	if (empty($checked_data->checked))
		return $checked_data;	
	
	// grab the theme info from github using the function below
	if ($theme_info = null_theme_information()) {
	
		// check the versions and push a new response to WordPress
		$update = version_compare($theme_info['version'], NULL_VERSION);
		if (1 === $update) {
		
			$response = array();
			$response['new_version'] = $theme_info['version'];
			$response['url'] = $theme_info['url'];
			$response['package'] = $theme_info['zip_url'];
			
			// If response is false, don't alter the transient
			if ( false !== $response )
				$checked_data->response[$theme_info['slug']] = $response;
		}		
	}
	
	return $checked_data;
}

/***************************************************************
* Function null_update_information
* Take over the Theme info screen on WP multisite
***************************************************************/

add_filter('themes_api', 'null_update_information', 10, 3);

function null_update_information($def, $action, $response) {

	// only modify the current template info
	if ($response->slug != get_option('template')) return false;
	
	// grab the theme information
	$theme_info = null_theme_information();

	$response = new stdClass;
	$response->slug 			= $theme_info['slug'];
	$response->name 			= $theme_info['name'];
	$response->version			= $theme_info['version'];
	$response->last_updated 	= $theme_info['updated'];
	$response->download_link	= $theme_info['zip_url'];
	$response->author 			= $theme_info['author'];
	$response->downloaded		= 0;
	$response->requires 		= $theme_info['requires'];
	$response->tested 			= $theme_info['tested'];
	$response->screenshot_url	= get_template_directory_uri().'/assets/images/apple-touch-icon-precomposed.png';
		
	return $response;

}

/***************************************************************
* Function null_theme_information
* Return theme information from current theme and github
***************************************************************/

function null_theme_information() {
	
	global $wp_version;
	
	// store the info in a transient for performance
	if (false === ($theme = get_transient('null_theme_update_information'))) { 
	
		// grab the current (parent) theme info
		$current_theme = wp_get_theme(get_option('template'));
			
		// config for github query
		$theme = array(
			'name'			=> $current_theme->Name,
			'slug'			=> $current_theme->Template,
			'author'		=> $current_theme->Author,
			'version'		=> $current_theme->Version,
			'updated'		=> date('Y-m-d'),
			'url'			=> 'http://scott.ee', // url to theme site or changelog
			'api_url'		=> 'https://api.github.com/repos/scottsweb/null',
			'raw_url' 		=> 'https://raw.github.com/scottsweb/null/master',
			'zip_url' 		=> 'https://github.com/scottsweb/null/zipball/master',
			'sslverify' 	=> false, // should we veryify SSL? - may cause issues if enabled
			'requires'		=> $wp_version,
			'tested'		=> $wp_version
		);
	
		// query github for latest stylesheet (get the latest version)
		$remote_stylesheet = trailingslashit( $theme['raw_url'] ) . 'style.css';
		$raw_response = wp_remote_get($remote_stylesheet, array('sslverify' => $theme['sslverify']));
		
		// did we recieve an error?
		if (!is_wp_error($raw_response)) { 
		
			// parse the remote stylesheet
			if (preg_match('|Version:(.*)$|mi', $raw_response['body'], $version)) {
		
				if (!empty($version)) {
				
					// clean up the version	
					$version = trim($version[1]);
					
					// add it to the info array
					$theme['version'] = $version;
				
				} 
			}
		}
		
		// query the github api for update time
		$remote_json = wp_remote_get($theme['api_url'], array('sslverify' => $theme['sslverify']));
		
		// did we recieve an error?
		if (!is_wp_error($remote_json)) {
			
			// decode the remote JSON
			$github_data = json_decode($remote_json['body']);
			
			if (!empty($github_data->updated_at)) { 
				
				// add update date to the theme array
				$theme['updated'] = date('Y-m-d', strtotime($github_data->updated_at ));
			}
		}

		// 1 day cache
		set_transient('null_theme_update_information', $theme, 60 * 60 * 24);
	}
	
	// filter the array just in case it needs changing by the child theme
	$theme = apply_filters('null_theme_information', $theme);
	return $theme;
}
?>