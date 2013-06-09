<?php

/***************************************************************
* Function null_cron_schedules
* Add a few more schedules to WordPress cron (add options to enable at some point?)
***************************************************************/

add_filter('cron_schedules', 'null_cron_schedules');

function null_cron_schedules( $param ) {
	return array(
		'halfhourly' 	=> array('interval' => 1800, 'display' => __('Once Every Half an Hour', 'null')),
		'weekly' 		=> array('interval' => 604800, 'display' => __('Once Weekly', 'null')),
		'monthly' 		=> array('interval' => 2419200, 'display' => __('Once Monthly', 'null')),
	);
}

/***************************************************************
* Function null_cron_events
* Register custom cron events 
***************************************************************/

add_action('init', 'null_cron_events');

function null_cron_events() {
	
	// schedule a weekly transient clean up once a week
	if (!wp_next_scheduled('null_cron_transient_cleanup')) {
		wp_schedule_event( time(), 'weekly', 'null_cron_transient_cleanup' );
	}
	
	// use to debug the scheduled events above
	//wp_clear_scheduled_hook('null_cron_transient_cleanup');
	//do_action('null_cron_transient_cleanup');
}

/***************************************************************
* Function null_transient_cleanup
* Clean up expired transients in WordPress http://bit.ly/ea4jek
***************************************************************/

add_action('null_cron_transient_cleanup', 'null_transient_cleanup');

function null_transient_cleanup() {

    global $wpdb, $_wp_using_ext_object_cache;

    if ($_wp_using_ext_object_cache)
        return;

    $time = isset ( $_SERVER['REQUEST_TIME'] ) ? (int)$_SERVER['REQUEST_TIME'] : time() ;
    $expired = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout%' AND option_value < {$time};" );

    foreach( $expired as $transient ) {
        $key = str_replace('_transient_timeout_', '', $transient);
        delete_transient($key);
    }
}
?>