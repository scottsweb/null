<?php
/*
Shortcode Name: Google Map 
Shortcode Template: [map address="loc" width="px/%" height="px"]
*/

/***************************************************************
* Function null_map_shortcode
* Shortcode to display a Google map from http://pippinsplugins.com/simple-google-maps-short-code
***************************************************************/

add_shortcode('map', 'null_map_shortcode' );

function null_map_shortcode( $atts ) {

	$atts = shortcode_atts(
		array(
			'address' 	=> false,
			'width' 	=> '100%',
			'height' 	=> '400px'
		),
		$atts
	);

	$address = $atts['address'];

	if ($address) :

		wp_print_scripts( 'google-maps-api' );

		$coordinates = null_map_get_coordinates($address);

		if( !is_array( $coordinates ) )
			return;

		$map_id = uniqid( 'null_map_' ); // generate a unique ID for this map

		ob_start(); ?>

		<div class="map-shortcode-canvas" id="<?php echo esc_attr( $map_id ); ?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>; width: <?php echo esc_attr( $atts['width'] ); ?>"></div>
	    <script type="text/javascript">
			var map_<?php echo $map_id; ?>;
			function null_run_map_<?php echo $map_id ; ?>(){
				var location = new google.maps.LatLng("<?php echo $coordinates['lat']; ?>", "<?php echo $coordinates['lng']; ?>");
				var map_options = {
					zoom: 15,
					center: location,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				map_<?php echo $map_id ; ?> = new google.maps.Map(document.getElementById("<?php echo $map_id ; ?>"), map_options);
				var marker = new google.maps.Marker({
				position: location,
				map: map_<?php echo $map_id ; ?>
				});
			}
			null_run_map_<?php echo $map_id ; ?>();
		</script>
		<?php
	endif;
	return ob_get_clean();
}

/***************************************************************
* Function null_map_get_coordinates
* Retrieve coordinates for an address. Coordinates are cached using transients and a hash of the address.
***************************************************************/

function null_map_get_coordinates( $address, $force_refresh = false ) {
	
    $address_hash = md5( $address );

    $coordinates = get_transient( $address_hash );

    if ($force_refresh || $coordinates === false) {
    	
    	$url 		= 'http://maps.google.com/maps/api/geocode/xml?address=' . urlencode($address) . '&sensor=false';
     	$response 	= wp_remote_get( $url );

     	if( is_wp_error( $response ) )
     		return;

     	$xml = wp_remote_retrieve_body( $response );

     	if( is_wp_error( $xml ) )
     		return;

		if ( $response['response']['code'] == 200 ) {

			$data = new SimpleXMLElement( $xml );

			if ( $data->status == 'OK' ) {

			  	$cache_value['lat'] 	= (float) $data->result->geometry->location->lat;
			  	$cache_value['lng'] 	= (float) $data->result->geometry->location->lng;
			  	$cache_value['address'] = (string) $data->result->formatted_address;

			  	// cache coordinates for 3 months
			  	set_transient($address_hash, $cache_value, 3600*24*30*3);
			  	$data = $cache_value;

			} elseif ($data->status == 602) {
			  	return sprintf( __( 'Unable to parse entered address. API response code: %s', 'null' ), @$data->Response->Status->code );
			} else {
			   	return sprintf( __( 'XML parsing error. Please try again later. API response code: %s', 'null' ), @$data->Response->Status->code );
			}

		} else {
		 	return __( 'Unable to contact Google API service.', 'null' );
		}

    } else {
       // return cached results
       $data = $coordinates;
    }

    return $data;
}

/***************************************************************
* Function null_map_load_scripts
* Register the google maps API js for use in shortcode
***************************************************************/

add_action( 'wp_enqueue_scripts', 'null_map_load_scripts' );

function null_map_load_scripts() {
	wp_register_script( 'google-maps-api', 'http://maps.google.com/maps/api/js?sensor=false' );
}
?>