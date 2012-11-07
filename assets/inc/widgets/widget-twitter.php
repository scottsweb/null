<?php
/*
Widget Name: Twitter Widget
*/

register_widget('null_twitter_widget');

class null_twitter_widget extends WP_Widget {
	
	function null_twitter_widget() {
		$widget_ops = array('classname' => 'null-twitter-feed', 'description' => __('Displays your tweets', "null") );
		$this->WP_Widget('null-twitter-feed', __('Twitter Feed', "null"), $widget_ops);	
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);	
		$username = $instance['username'];
		$limit = $instance['number'];
		$link = $instance['link'];
		
		echo $before_widget;
	    if(!empty($title)) { echo $before_title . $title . $after_title; };
		
		if (!class_exists('SimplePie')) {
			load_template(ABSPATH.WPINC.'/class-simplepie.php');
		}
		
		$tfeed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=" . $limit;
		
		$feed = new SimplePie();
		$feed->set_feed_url($tfeed);
		$feed->set_cache_location(null_cache_path());
		$feed->init();
		$feed->handle_content_type();
			
		$output = '<ul class="tweets">';
		
		foreach($feed->get_items(0, $limit) as $item){
			$output .= '<li>'.$item->get_description().'</li>'. "\n";
		}
		
		$output .= '</ul>';
		
		echo $output;

		?>
	    <p class="clear"><a href="http://twitter.com/<?php echo $username; ?>"><?php echo $link; ?></a></p>
	  	<?php  
		
		echo $after_widget; 
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Latest Tweets','null'), 'username' => (of_get_option('twitterusername') ? str_replace('@', '', of_get_option('twitterusername')) : 'scottsweb'), 'link' => 'Follow Us', 'number' => '3' ) );
		$title = strip_tags($instance['title']);
		$username = strip_tags($instance['username']);
		$number = strip_tags($instance['number']);
		$link = strip_tags($instance['link']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Tweets', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Text Link', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></label></p>
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;
	}
}
?>