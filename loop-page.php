<?php if (have_posts()) while (have_posts()) : the_post(); ?>

<article <?php post_class() ?>>
	
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
	
</article>

<?php endwhile; ?>