<?php
/*
Widget Name: vCard Widget
*/

register_widget('null_vcard');

class null_vcard extends WP_Widget {

	function null_vcard() {
		$widget_ops = array('description' => 'Display a vCard');
		parent::WP_Widget(false, __('vCard', 'null'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		extract($instance);
		echo $before_widget;
		if ($title) {
			echo $before_title, $title, $after_title;
		}
		?>
		<div class="vcard">
			<a class="fn org url" href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a><br/>
			<span class="adr">
			<span class="street-address"><?php echo $street_address; ?></span><br/>
			<span class="locality"><?php echo $locality; ?></span>,
			<span class="region"><?php echo $region; ?></span>,<br/>
			<span class="postal-code"><?php echo $postal_code; ?></span><br/>
			</span>
			<span class="tel"><span class="value"><?php echo $tel; ?></span></span><br/>
			<a class="email" href="mailto:<?php echo antispambot($email); ?>"><?php echo antispambot($email); ?></a>
		</div>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'null'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset($instance['title'])) { echo esc_attr($instance['title']); } ?>" class="widefat" id="<?php if (isset($instance['title'])) { echo $this->get_field_id('title'); } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('street_address'); ?>"><?php _e('Street Address:', 'null'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('street_address'); ?>" value="<?php if (isset($instance['street_address'])) { echo esc_attr($instance['street_address']); } ?>" class="widefat" id="<?php if (isset($instance['street_address'])) { echo $this->get_field_id('street_address'); } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('locality'); ?>"><?php _e('City/Locality:', 'null'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('locality'); ?>" value="<?php if (isset($instance['locality'])) { echo esc_attr($instance['locality']); } ?>" class="widefat" id="<?php if (isset($instance['locality'])) { echo $this->get_field_id('locality'); } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('region'); ?>"><?php _e('State/Region:', 'null'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('region'); ?>" value="<?php if (isset($instance['region'])) { echo esc_attr($instance['region']); } ?>" class="widefat" id="<?php if (isset($instance['region'])) { echo $this->get_field_id('region'); } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('postal_code'); ?>"><?php _e('Zipcode/Postal Code:', 'null'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('postal_code'); ?>" value="<?php if (isset($instance['postal_code'])) { echo esc_attr($instance['postal_code']); } ?>" class="widefat" id="<?php if (isset($instance['postal_code'])) { echo $this->get_field_id('postal_code'); } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tel'); ?>"><?php _e('Telephone:', 'null'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('tel'); ?>" value="<?php if (isset($instance['tel'])) { echo esc_attr($instance['tel']); } ?>" class="widefat" id="<?php if (isset($instance['tel'])) { echo $this->get_field_id('tel'); } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'null'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('email'); ?>" value="<?php if (isset($instance['email'])) { echo esc_attr($instance['email']); } ?>" class="widefat" id="<?php if (isset($instance['email'])) { echo $this->get_field_id('email'); } ?>" />
		</p>
	<?php
	}
}
