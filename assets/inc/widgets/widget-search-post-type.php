<?php
/*
Widget Name: Post Type Search Widget
*/

register_widget('null_post_type_search_widget');

class null_post_type_search_widget extends WP_Widget {

	function null_post_type_search_widget() {
		$widget_ops = array('classname' => 'null-post-type-search', 'description' => __('Search a particular WordPress custom post type.', 'null'));
		$this->WP_Widget('null-post-type-search-widget', __('Search (Post Type)', 'null'), $widget_ops);
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? __('Search', 'null') : apply_filters('widget_title', $instance['title']);
		$post_type = empty($instance['post_type']) ? null : $instance['post_type'];

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		?>
		<form role="search" method="get" id="post_type_search_form" action="<?php echo home_url( '/' ); ?>">
			<input type="text" value="<?php the_search_query() ?>" name="s" id="s" />
			<input type="submit" id="post_type_search_submit" value="Search" class="button" />
			<input type="hidden" value="<?php print $post_type; ?>" name="post_type" id="post_type_custom_type" />
		</form>		
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = esc_html($new_instance['title']);
		$instance['post_type'] = esc_html($new_instance['post_type']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'post_type' => '') );
		$title = strip_tags($instance['title']);
		$post_type = strip_tags($instance['post_type']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','null'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p>
				<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post type to search:','null'); ?> 
					
					<?php 
					$args = array('public' => true, 'show_ui' => true); 
					$output = 'objects';
					$operator = 'and';
					$post_types = get_post_types( $args, $output, $operator );
					?>
					
					<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="widefat">					
					<?php foreach ($post_types as $pt): ?>
						<?php if ($post_type == $pt->name) { ?>
							<option value="<?php echo $pt->name; ?>" selected="selected"><?php echo $pt->labels->name; ?> (<?php echo $pt->name; ?>)</option>
						<?php } else { ?>
							<option value="<?php echo $pt->name; ?>"><?php echo $pt->labels->name; ?> (<?php echo $pt->name; ?>)</option>
						<?php } ?>
                	<?php endforeach; ?>
                	</select>
				</label>
			</p>
		<?php
	}
}
?>