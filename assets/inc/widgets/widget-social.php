<?php
/*
Widget Name: Social Profiles Widget
*/

register_widget('null_social_widget');

class null_social_widget extends WP_Widget {
	
	function null_social_widget() {
		$widget_ops = array('classname' => 'null-social-widget', 'description' => __('Displays your social media profiles as icons', "null") );
		$this->WP_Widget('null_social_feed', __('Social Profiles', "null"), $widget_ops);	
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);	

		echo $before_widget;
		if(!empty($title)) { echo $before_title . $title . $after_title; };
		?>
		<ul class="social-links">
			<?php if ($delicious = of_get_option('delicious')) { ?><li id="social-delicious"><a href="<?php echo $delicious; ?>" class="iconfont-replace">delicious</a></li><?php } ?>
			<?php if ($dribbble = of_get_option('dribbble')) { ?><li id="social-dribbble"><a href="<?php echo $dribbble; ?>" class="iconfont-replace">dribbble</a></li><?php } ?>
			<?php if ($facebook = of_get_option('facebook')) { ?><li id="social-facebook"><a href="<?php echo $facebook; ?>" class="iconfont-replace">facebook</a></li><?php } ?>
			<?php if ($flickr = of_get_option('flickr')) { ?><li id="social-flickr"><a href="<?php echo $flickr; ?>" class="iconfont-replace">flickr</a></li><?php } ?>
			<?php if ($github = of_get_option('github')) { ?><li id="social-github"><a href="<?php echo $github; ?>" class="iconfont-replace">github</a></li><?php } ?>
			<?php if ($google = of_get_option('googleplus')) { ?><li id="social-google"><a href="<?php echo $google; ?>" class="iconfont-replace">google</a></li><?php } ?>
			<?php if ($instagram = of_get_option('instagram')) { ?><li id="social-instagram"><a href="<?php echo $instagram; ?>" class="iconfont-replace">instagram</a></li><?php } ?>							
			<?php if ($linkedin = of_get_option('linkedin')) { ?><li id="social-linkedin"><a href="<?php echo $linkedin; ?>" class="iconfont-replace">linkedin</a></li><?php } ?>				
			<?php if ($pinterest = of_get_option('pinterest')) { ?><li id="social-pinterest"><a href="<?php echo $pinterest; ?>" class="iconfont-replace">pinterest</a></li><?php } ?>				
			<?php if ($soundcloud = of_get_option('soundcloud')) { ?><li id="social-soundcloud"><a href="<?php echo $soundcloud; ?>" class="iconfont-replace">soundcloud</a></li><?php } ?>				
			<?php if ($twitter = of_get_option('twitter')) { ?><li id="social-twitter"><a href="<?php echo $twitter; ?>" class="iconfont-replace">twitter</a></li><?php } ?>
			<?php if ($vimeo = of_get_option('vimeo')) { ?><li id="social-vimeo"><a href="<?php echo $vimeo; ?>" class="iconfont-replace">vimeo</a></li><?php } ?>				
			<?php if ($youtube = of_get_option('youtube')) { ?><li id="social-youtube"><a href="<?php echo $youtube; ?>" class="iconfont-replace">youtube</a></li><?php } ?>				
		</ul>
		<?php  

		echo $after_widget; 
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', "null"); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php if (current_user_can('edit_theme_options')) { ?>
		<p><?php printf(__('Social profiles are managed from your %1$stheme options%2$s.', 'null'), '<a href="'.admin_url('/themes.php?page=options-framework').'">','</a>'); ?></p>
		<?php } ?>
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}
?>