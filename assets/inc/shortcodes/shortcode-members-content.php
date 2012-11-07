<?php
/*
Shortcode Name: Restrict Content [member]secret content[/member]
*/

/***************************************************************
* Function null_members
* A shortcode that shows content to members only. Usage: [member]Secret content[/member]
***************************************************************/

add_shortcode( 'member', 'null_members' );

function null_members($atts, $content = null) {
	 if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
		return $content;
	return '';
}
?>