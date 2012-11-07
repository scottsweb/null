<?php
/*
Shortcode Name: Encode Email [mailto]email@email.com[/mailto]
*/

/***************************************************************
* Function null_email_shortcode
* A shortcode for encoding email addresses. Usage: [mailto]email@email.com[/mailto]
***************************************************************/

add_shortcode('mailto', 'null_email_shortcode');

function null_email_shortcode($atts , $content = null) {

	do_shortcode( $content );

	if (!$content) { return false; }
    return '<a href="mailto:'.antispambot($content).'">'.antispambot($content).'</a>';

}
?>