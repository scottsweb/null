<?php

/***************************************************************
* Function null_email_from_name
* Send emails from the correct name
***************************************************************/

add_filter('wp_mail_from_name', 'null_email_from_name');

function null_email_from_name($name) {
	if ($from = of_get_option('email_from_name')) {
		return esc_attr($from);
	}
	return $name;
}

/***************************************************************
* Function null_email_from
* Send emails from the correct email address
***************************************************************/

add_filter('wp_mail_from', 'null_email_from');

function null_email_from($email) {
	if ($from = of_get_option('email_from')) {
		$from = is_email($from);
		return $from;
	}
	return $email;
}

/***************************************************************
* Function null_email_encode & null_email_encode_callback
* Protect email addresses when added to the content editor as plain text
***************************************************************/

if (of_get_option('email_encode', '1')) {
	add_filter ('the_content', 'null_email_encode', 15);
}

function null_email_encode($text) {
	return preg_replace_callback ('/([> ])[A-Z0-9._-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z.]{2,6}/i', 'null_email_encode_callback', $text);
}

function null_email_encode_callback($matches) {
	$email = substr($matches[0], 1);
	return $matches[1].'<a href="mailto:'.antispambot($email, true).'">'.antispambot($email).'</a>';
}

?>