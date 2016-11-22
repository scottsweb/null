<?php get_header(); ?>

		<?php tha_content_before(); ?>

		<main id="content" role="main">

			<?php tha_content_top(); ?>

			<?php get_template_part('loop', 'index'); ?>

			<?php tha_content_bottom(); ?>

		</main><!-- #content -->

		<?php tha_content_after(); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>