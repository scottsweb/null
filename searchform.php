<form method="get" class="search-form" action="<?php echo trailingslashit(site_url()); ?>" role="search">
	<fieldset>
		<div class="form-row">
			<label for="s"><?php _e('Search', 'null'); ?></label>
			<input id="s" name="s" class="text" type="text" accesskey="s" value="<?php the_search_query() ?>" placeholder="<?php _e('Search', 'null'); ?>" title="<?php _e('Search', 'null'); ?>" size="40" required/>
			<input type="submit" value="<?php _e('Search', 'null'); ?>" />
		</div>
	</fieldset>
</form>