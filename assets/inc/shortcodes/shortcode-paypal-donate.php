<?php
/*
Shortcode Name: PayPal Donate [donate text="" email="email" for=""]
*/

/***************************************************************
* Function null_donate
* A shortcode for paypal donations. Usage: [donate text="" email="email" for=""]
***************************************************************/

add_shortcode('donate', 'null_donate');

function null_donate($atts, $content = null) {
    
    global $post;
    extract(shortcode_atts(array('text' => __('Make a donation', 'null'), 'email' => '', 'for' => ''), $atts));
    if (!$for) $for = str_replace(" ","+",$post->post_title);
    if (!$email) $email = get_bloginfo('admin_email');

    return '<a class="donate-shortcode-button" href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business='.$email.'&item_name='.$for.'">'.$text.'</a>';

}
?>