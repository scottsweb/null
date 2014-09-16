<?php
/**
This is a custom view for the author archives e.g. /author/admin/
If deleted WordPress will call archive.php instead which supports author (just not as well)
**/
?>
<?php get_header() ?>

	<?php tha_content_before(); ?>

	<div id="content" role="main">

		<?php tha_content_top(); ?>

		<?php $auth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); // grab author data ?>

		<h2 class="page-title author"><?php _e('Author Archive', 'null'); ?></h2>

		<?php if (get_the_author_meta('description',  $auth->ID)) : // if user has filled out their biography then show mini biography ?>
		<section id="author-information" class="archive-meta vcard">
			<header>
				<?php echo get_avatar(get_the_author_meta('user_email', $auth->ID), 70 ); ?>
				<h3><span class="fn n"><?php echo $auth->display_name; ?></span></h3>
			</header>
			<div id="author-content">
				<p><?php the_author_meta('description', $auth->ID); ?></p>
			</div>
			<footer>
				<ul id="author-meta">
					<li id="author-post-count"><?php _e('Posts:', 'null'); ?> <?php echo null_user_posts_count($auth->ID); ?></li>
					<?php if ($auth->user_url) : ?><li id="author-url"><?php _e('Website:', 'null'); ?> <a href="<?php echo $auth->user_url;?>" title="<?php echo $auth->display_name; ?>" class="url"><?php echo str_replace('http://', '', $auth->user_url);?></a></li><?php endif; ?>
				</ul>
			</footer>
		</section><!-- #author-information -->
		<?php endif; ?>

		<?php rewind_posts(); ?>

		<?php get_template_part('loop', 'author'); ?>

		<?php tha_content_bottom(); ?>

	</div><!-- #content -->

	<?php tha_content_after(); ?>

<?php get_sidebar() ?>
<?php get_footer() ?>