<?php if (have_posts()) while (have_posts()) : the_post(); ?>

<?php tha_entry_before(); ?>

<article <?php post_class() ?>>

	<?php tha_entry_top(); ?>

	<header>
		<h2 class="entry-title"><?php the_title() ?></h2>
	</header>

	<div class="entry-content">
		<?php wp_link_pages('before=<div class="page-link">'  . __('Page:', 'null') . '&after=</div>&link_before=<span>&link_after=</span>') ?>
		<?php the_content() ?>
	</div>

	<?php
	// if comments are open or we have at least one comment, load up the comment template
	if (comments_open() || '0' != get_comments_number()) {
		comments_template();
	}
	?>

	<?php tha_entry_bottom(); ?>

</article>

<?php tha_entry_after(); ?>

<?php endwhile; ?>