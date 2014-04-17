<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>

<?php tha_entry_before(); ?>

<article <?php post_class() ?> role="article">

	<?php tha_entry_top(); ?>

	<header>		
		<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( is_sticky() ) : ?>
		<div class="entry-sticky"><?php _e( 'Featured', 'null' ); ?></div>
		<?php else : ?>
		<div class="entry-date"><time class="published" datetime="<?php the_time('Y-m-d\TH:i:s') ?>"><?php null_time(); ?></time></div>
		<?php endif; ?>
		<?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail', array('class' => 'alignright')); } ?>
	</header>
	<div class="entry-content">
		<?php the_excerpt() ?>
		<?php //get_template_part( 'content', get_post_format() ); // support for various post formats, switch to this based on settings? ?>
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

	<?php tha_entry_bottom(); ?>

</article>

<?php tha_entry_after(); ?>

<?php endwhile; ?>

<?php if ($wp_query->max_num_pages > 1) : // only paginate when necessary ?>

<nav class="pagination" role="navigation">
	<?php null_paginate(); ?>
</nav>

<?php endif; ?>

<?php else : // no posts found ?>

<?php tha_entry_before(); ?>

<article role="article">

	<?php tha_entry_top(); ?>

	<h3><?php _e('No Posts Found', 'null'); ?></h3>
	<p class="notice"><?php _e("Sorry, but you are looking for something that isn't here.", 'null'); ?></p>

	<?php tha_entry_bottom(); ?>

</article>

<?php tha_entry_after(); ?>

<?php endif; ?>