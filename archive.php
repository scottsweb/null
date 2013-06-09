<?php get_header() ?>

		<?php tha_content_before(); ?>

		<div id="content" role="main">

			<?php tha_content_top(); ?>

			<?php /** if this is a category archive **/ if (is_category()) { ?>				
			<h2 class="page-title"><?php _e('Blog:', 'null'); ?> <?php echo single_cat_title(); ?></h2>
			<?php /** if this is a tag archive **/ } else if (is_tag()) { ?>
			<h2 class="page-title"><?php _e('Tag Archive for', 'null'); ?> <span>&ldquo;<?php single_tag_title() ?>&rdquo;</span></h2>
			<?php /** if this is a daily archive **/ } else if (is_day()) { ?>
			<h2 class="page-title"><?php the_time('F jS, Y'); ?> <?php _e('Archive', 'null'); ?></h2>
			<?php /** if this is a monthly archive **/ } else if (is_month()) { ?>
			<h2 class="page-title"><?php the_time('F, Y'); ?> <?php _e('Archive', 'null'); ?></h2>
			<?php /** if this is a yearly archive **/ } else if (is_year()) { ?>
			<h2 class="page-title"><?php the_time('Y'); ?> <?php _e('Archive', 'null'); ?></h2>
			<?php /** if this is a search **/ } elseif (is_search()) { ?>
			<h2 class="page-title"><?php _e('Search Results', 'null'); ?></h2>
			<?php /** if this is an author archive **/ } else if (is_author()) { ?>
			<h2 class="page-title"><?php _e('Author Archive', 'null'); ?></h2>
			<?php /** if this is a paged archive **/ } else if (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h2 class="page-title"><?php _e('Blog Archive', 'null'); ?></h2>
			<?php } ?>
			
			<?php get_template_part('loop', 'archive'); ?>

			<?php tha_content_bottom(); ?>

		</div><!-- #content -->

		<?php tha_content_after(); ?>

<?php get_sidebar() ?>
<?php get_footer() ?>