<?php
/**
This is a custom view for the tag archives e.g. /tag/null/
If deleted WordPress will call archive.php instead which supports tag as well
**/
?>
<?php get_header(); ?>

		<div id="content" role="main">
	
			<h2 class="page-title"><?php _e('Tag Archive for', 'null'); ?> <span>&ldquo;<?php single_tag_title() ?>&rdquo;</span></h2>
			
			<?php get_template_part('loop', 'tags'); ?>

		</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>