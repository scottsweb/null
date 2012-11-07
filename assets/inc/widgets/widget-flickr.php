<?php
/*
Widget Name: Flickr Widget
*/

register_widget('null_flickr_widget');

class null_flickr_widget extends WP_Widget {
	
	function null_flickr_widget() {
		$widget_ops = array('classname' => 'null-flickr-feed', 'description' => __('Displays your flickr photos', "null") );
		$this->WP_Widget('pw_flickr_feed', __('Flickr Feed', "null"), $widget_ops);	
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);	
		$UserID = $instance['UserID'];
		$NumPics = $instance['NumPics'];
		$link = $instance['link'];
		
		echo $before_widget;
	    if(!empty($title)) { echo $before_title . $title . $after_title; };
		
		$feed = "http://www.flickr.com/badge_code_v2.gne?count=" . $NumPics . "&display=latest&size=s&layout=x&source=user&user=" .$UserID;
		
		echo '<div id="flickr_tab">';
		echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' . $NumPics . '&display=latest&size=s&layout=x&source=user&user=' .$UserID .'"></script>';
		echo '</div>';

		?>
	    <p class="clear flickr-link"><a href="http://flickr.com/photos/<?php echo $UserID; ?>"><?php echo $link; ?></a></p>
	  	<?php  
		
		echo $after_widget; 
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Flickr Photos', 'UserID' => '', 'link' => 'Find Me on Flickr', 'NumPics' => '9' ) );
		$title = strip_tags($instance['title']);
		$UserID = strip_tags($instance['UserID']);
		$NumPics = strip_tags($instance['NumPics']);
		$link = strip_tags($instance['link']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('UserID'); ?>"><?php _e('UserID', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('UserID'); ?>" name="<?php echo $this->get_field_name('UserID'); ?>" type="text" value="<?php echo esc_attr($UserID); ?>" /></label><br /><a href="http://idgettr.com/" target="_blank"><?php _e('Flickr idGettr', "null"); ?></a></p>
		<p><label for="<?php echo $this->get_field_id('NumPics'); ?>"><?php _e('Number of Photos', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('NumPics'); ?>" name="<?php echo $this->get_field_name('NumPics'); ?>" type="text" value="<?php echo esc_attr($NumPics); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link Text', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></label></p>
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['UserID'] = strip_tags($new_instance['UserID']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['NumPics'] = strip_tags($new_instance['NumPics']);
		return $instance;
	}
}
?>