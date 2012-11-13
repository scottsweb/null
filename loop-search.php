<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>

<article <?php post_class('loop-search loop loop-'.$loopcounter.' '.$class) ?> role="article">
	<header>
		<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
		<div class="entry-date"><time class="published" datetime="<?php the_time('Y-m-d\TH:i:s') ?>" pubdate><?php null_time(); ?></time></div>
	</header>
	<div class="entry-content">
		<?php the_excerpt() ?>
		<?php //get_template_part( 'content', get_post_format() ); // support for various post formats coming soon ?>
	</div>
	<footer>
		<ul class="entry-meta">
			<li class="author vcard entry-author"><?php _e('By:', 'null'); ?> <a class="url fn n" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php the_author_meta('display_name'); ?>"><?php the_author_meta('display_name'); ?></a></li>
			<li class="entry-reading-time"><?php _e('Reading time:', 'null'); ?> <?php echo null_estimated_reading_time(get_the_content()); ?></li>
			<li class="entry-categories"><?php _e('Posted in:', 'null'); ?> <?php the_category(', ') ?></li>
			<?php the_tags('<li class="entry-tags">'.__('Tagged:', 'null').' ', ', ', '</li>'); ?>
			<?php if ( comments_open() && ! post_password_required() ) : ?><li class="entry-comments"><?php comments_popup_link(__('No Comments', 'null'), __('1 Comment', 'null'), __('% Comments', 'null')); ?></li><?php endif; ?>
		</ul>
	</footer>
</article>

<?php endwhile; ?>

<?php if ($wp_query->max_num_pages > 1) : // only paginate when necessary ?>

<nav class="pagination" role="navigation">
	<?php null_paginate(); ?>
</nav>

<?php endif; ?>

<?php else : // no search results ?>

<article id="post-0" class="post no-results not-found">
	<header>
		<h3 class="entry-title"><?php _e('Nothing Found', 'null'); ?></h3>
	</header>
	<div class="entry-content">
		<p class="notice"><?php _e('Sorry but nothing matched your search. Please try searching again using the form below.', 'null'); ?></p>
		<?php get_search_form(); ?>
	</div>
</article>

<?php endif; ?>