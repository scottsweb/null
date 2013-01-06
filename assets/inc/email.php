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

?>