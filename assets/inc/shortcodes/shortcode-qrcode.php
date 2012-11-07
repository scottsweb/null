<?php
/*
Shortcode Name: QR Code [qrcode url="" size=""]
*/

/***************************************************************
* Function null_qrcode
* A shortcode for qrcodes. Usage: [qrcode url="" size=""]
***************************************************************/

add_shortcode('qrcode', 'null_qrcode');

function null_qrcode($atts, $content = null) {
    
    global $post;
    
    extract(shortcode_atts(array('url' => '','size' => '200'), $atts));
    
    if (!$size) $size = 200;
    if ($size <= 50) $size = 50;
    if (!$url) $url = get_permalink();

	return '<img src="https://chart.googleapis.com/chart?chs='.$size.'x'.$size.'&cht=qr&chl='.urlencode($url).'&chld=L|1&choe=UTF-8" width="'.$size.'" height="'.$size.'" title="'.$url.'" alt="'.__('QR Code for: ','null').$url.'" class="qrcode-shortcode qrcode-shortcode-'.$post->ID.'" />';

}
?>