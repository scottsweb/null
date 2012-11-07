<?php
/*
Widget Name: Category Search Widget
*/

register_widget('null_category_search_widget');

class null_category_search_widget extends WP_Widget {

	function null_category_search_widget() {
		$widget_ops = array('classname' => 'null-category-search', 'description' => __('Search a particular WordPress category', 'null'));
		$this->WP_Widget('null-category-search-widget', __('Search (Category)', 'null'), $widget_ops);
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? __('Search', 'null') : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? null : $instance['category'];

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		?>
		<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
			<input type="text" value="<?php the_search_query() ?>" name="s" id="s" />
			<input type="submit" id="searchsubmit" value="<?php _e('Search', 'null'); ?>" />
			<?php if ($category != "-1") { ?> 
			<input type="hidden" value="<?php print $category; ?>" name="cat" id="cat" />
			<?php } ?>
		</form>		
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '') );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','null'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p>
				<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category to search:','null'); ?> 
					<?php wp_dropdown_categories(array('hide_empty' => 0, 'name' => $this->get_field_name('category'), 'orderby' => 'name', 'selected' => $category, 'hierarchical' => true, 'class' => 'widefat', 'show_option_none' => __('None', 'null'))); ?>
				</label>
			</p>
		<?php
	}
}
?>