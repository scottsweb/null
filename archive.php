<?php get_header() ?>

	<?php tha_content_before(); ?>

	<main id="content" role="main">

		<?php tha_content_top(); ?>

		<?php
			the_archive_title( '<h2 class="page-title">', '</h2>' );
			the_archive_description( '<section class="archive-meta">', '</section>' );
		?>

		<?php get_template_part('loop', 'archive'); ?>

		<?php tha_content_bottom(); ?>

	</main><!-- #content -->

	<?php tha_content_after(); ?>

<?php get_sidebar() ?>
<?php get_footer() ?>