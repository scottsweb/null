<?php get_header() ?>

		<?php tha_content_before(); ?>

		<div id="content" role="main">
			
			<?php tha_content_top(); ?>

			<?php tha_entry_before(); ?>

			<article id="post-0" class="post error404 not-found">
				
				<?php tha_entry_top(); ?>
				
				<header>
					<h2 class="entry-title"><?php _e('Page Not Found', 'null'); ?></h2>
				</header>
				
				<div class="entry-content">
					
					<p class="error"><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'null'); ?></p>
					<?php get_search_form(); ?>
										
				</div>

				<?php tha_entry_bottom(); ?>

			</article>
			
			<?php tha_entry_after(); ?>

			<?php tha_content_bottom(); ?>

		</div><!-- #content -->

		<?php tha_content_after(); ?>

<?php get_sidebar() ?>
<?php get_footer() ?>