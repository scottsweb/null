<?php get_header() ?>

		<?php tha_content_before(); ?>

		<div id="content" role="main">

			<?php tha_content_top(); ?>
			
			<?php get_template_part('loop', 'single'); ?>

			<?php tha_content_bottom(); ?>

		</div><!-- #content -->

		<?php tha_content_after(); ?>

<?php get_sidebar() ?>
<?php get_footer() ?>