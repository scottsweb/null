<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<fieldset>
		<div class="form-row">
			<label for="s"><?php _e('Search', 'null'); ?></label>
			<input id="s" name="s" class="text" type="text" accesskey="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e('Search', 'null'); ?>" size="40" required/>
			<input type="submit" value="<?php esc_attr_e( 'Search', 'null' ); ?>" />
		</div>
	</fieldset>
</form>