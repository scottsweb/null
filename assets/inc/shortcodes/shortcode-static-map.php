<?php
/*
Shortcode Name: Static Google Map
Shortcode Template: [smap center="loc" size="WxH" zoom="14"]
*/

/***************************************************************
* Function null_static_map_shortcode
* Shortcode to display a static Google map (https://developers.google.com/maps/documentation/staticmaps/)
***************************************************************/

add_shortcode('smap', 'null_static_map_shortcode' );

function null_static_map_shortcode( $atts ) {

	$args = shortcode_atts(array(
		'center' => 'London',
		'zoom' => '14',
		'size' => '400x400',
		'scale' => '1', // 1 = lower resolution, 2 = HiDPI
		'sensor' => 'false',
		'maptype' => 'roadmap',
		'format' => 'png',
		'markers' => 'London'
	), $atts );

	// construct map url with img title and alt attributes using supplied content
	$map_url = '<img title="' . $args['center'] . '" alt="' . $args['center'] . '" src="http://maps.googleapis.com/maps/api/staticmap?';

	foreach($args as $arg => $value){
		$map_url .= $arg . '=' . urlencode($value) . '&';
	}

	$map_url .= '"/>';

	return $map_url;
}
