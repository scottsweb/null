<?php get_header() ?>

		<div id="content" role="main">

			<article id="post-0" class="post error404 not-found">
				
				<header>
					<h2 class="entry-title"><?php _e('Page Not Found', 'null'); ?></h2>
				</header>
				
				<div class="entry-content">
					
					<p class="error"><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'null'); ?></p>
					<?php get_search_form(); ?>
					
				</div>
								
			</article>

		</div><!-- #content -->

<?php get_sidebar() ?>
<?php get_footer() ?>