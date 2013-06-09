<?php get_header() ?>

		<?php tha_content_before(); ?>

		<div id="content" role="main">

			<?php tha_content_top(); ?>

			<h2 class="page-title"><?php printf(__( 'Search Results for: %s', 'null' ), '<span>' . get_search_query() . '</span>'); ?></h2>

			<?php get_template_part('loop', 'search'); ?>

			<?php tha_content_bottom(); ?>

		</div><!-- #content -->
		
		<?php tha_content_after(); ?>

<?php get_sidebar() ?>
<?php get_footer() ?>