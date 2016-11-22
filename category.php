<?php
/**
This is a custom view for the category archives e.g. /category/news/
If deleted WordPress will call archive.php instead which supports category as well
**/
?>
<?php get_header() ?>

		<?php tha_content_before(); ?>

		<main id="content" role="main">

			<?php tha_content_top(); ?>

			<h2 class="page-title"><?php _e('Blog:', 'null'); ?> <?php echo single_cat_title(); ?></h2>

			<?php // does this category have a description?
			$category_description = category_description();
			if (!empty( $category_description)):
				echo '<section id="category-information" class="archive-meta">' . $category_description . '</section>';
			endif;
			?>

			<?php get_template_part('loop', 'category'); ?>

			<?php tha_content_bottom(); ?>

		</main><!-- #content -->

		<?php tha_content_after(); ?>

<?php get_sidebar() ?>
<?php get_footer() ?>