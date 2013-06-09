<?php

/***************************************************************
* Constants 
***************************************************************/

define('UPDATE_URL', 'http://scott.ee'); // url to theme site or changelog
define('UPDATE_API_URL', 'https://api.github.com/repos/scottsweb/null');
define('UPDATE_RAW_URL', 'https://raw.github.com/scottsweb/null/master');
define('UPDATE_ZIP_URL', 'https://github.com/scottsweb/null/zipball/master');
			
/***************************************************************
* Function null_hide_theme
* Stop the theme/child theme from checking the WordPress.org API for updates
***************************************************************/

add_filter('http_request_args', 'null_hide_theme', 5, 2);

function null_hide_theme($r, $url) {
	if (!null_string_search('http://api.wordpress.org/themes/update-check', $url))
		return $r; // not a theme update request. bail.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[get_option('template')]);
	unset( $themes[get_option('stylesheet')]);
	$r['body']['themes'] = serialize($themes);
	return $r;
}

/***************************************************************
* Function null_http_request_sslverify
* Fix the SSL error caused when downloading ZIP from Github
***************************************************************/

add_filter('http_request_args', 'null_http_request_sslverify', 10, 2);

function null_http_request_sslverify($r, $url) {
	if (UPDATE_ZIP_URL != $url)
		return $r; // not a github zip request. bail.
	$r['sslverify'] = false; // do not SSL verify as it often fails	
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
		$update = version_compare($theme_info['version'], $theme_info['old_version']);
		
		if (1 === $update) {
			
			$response = array();
			$response['new_version'] = $theme_info['version'];
			$response['url'] = $theme_info['url'];
			$response['package'] = $theme_info['zip_url'];
			
			// if response is false, don't alter the transient
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
			'old_version' 	=> $current_theme->Version,
			'version'		=> $current_theme->Version,
			'updated'		=> date('Y-m-d'),
			'url'			=> UPDATE_URL,
			'api_url'		=> UPDATE_API_URL,
			'raw_url' 		=> UPDATE_RAW_URL,
			'zip_url' 		=> UPDATE_ZIP_URL,
			'sslverify' 	=> false, // should we veryify SSL? - will cause issues if enabled
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

/***************************************************************
* Function null_upgrader_source_selection_filter
* Github delivers zip files as <Username>-<Repo>-<Hash>.zip - must rename this zip file to match theme folder
***************************************************************/

add_filter('upgrader_source_selection', 'null_upgrader_source_selection_filter', 10, 3);

function null_upgrader_source_selection_filter($source, $remote_source, $upgrader) {

	$theme_info = null_theme_information();

	// only change the source for the github zip file - the source changed in WP3.5 - if this fails, auto updates fail
	// if your using this code elsewhere then change the string below
	if (strpos($source, 'scottsweb-null') === false) return $source;
	
	if (isset($source, $remote_source, $theme_info['slug'])) {
		$corrected_source = $theme_info['slug'];
		
		if(@rename($source, $corrected_source)) {
			
			delete_transient('null_theme_update_information'); // clear the null information transient to ensure it gets checked again
			return $corrected_source;
			
		} else {
			return new WP_Error();
		}
	}
		
	return $source;
}
?>