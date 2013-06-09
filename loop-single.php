<?php if (have_posts()) : the_post(); ?>

<?php tha_entry_before(); ?>

<article <?php post_class() ?> role="article">

	<?php tha_entry_top(); ?>

	<header>
		<h2 class="entry-title"><?php the_title() ?></h2>
	</header>
	
	<div class="entry-content">
		<?php wp_link_pages('before=<div class="page-link">'  . __('Page:', 'null') . '&after=</div>&link_before=<span>&link_after=</span>') ?>
		<?php the_content() ?>
	</div>
	
	<footer>
		<p class="entry-meta entry-description">
		<?php 
		printf(__('This entry was posted by %1$s on %2$s and is filed under %3$s. ', 'null'), 
			get_the_author(),
			'<time datetime="'.get_the_time('Y-m-d').'" pubdate>'.null_get_time('l, F jS, Y @ g:ia').'</time>',
			get_the_category_list(', ')
		);
		
		printf(__('You can follow any responses to this entry through the %1$sRSS 2.0%2$s feed. ', 'null'),
			'<a href="'.get_post_comments_feed_link().'">',
			'</a>'
		);
		
		if ( comments_open() && pings_open() ) {
		
			// Both Comments and Pings are open
			printf(
				__('You can <a href="#respond">leave a response</a>, or <a href="%1$s" rel="trackback">trackback</a> from your own site.', 'null'),
				get_trackback_url()
			);
		
		} else if ( !comments_open() && pings_open() ) {
			
			// Only Pings are Open 
			printf(
				__('Responses are currently closed, but you can leave a <a href="%1$s" rel="trackback">trackback</a> from your own site.', 'null'),
				get_trackback_url()
			); 
		
		} else if ( comments_open() && !pings_open() ) {
		
			// Comments are open, Pings are not
			_e('You can skip to the end and leave a response. Pinging is currently not allowed.', 'null');
		
		} else if ( !comments_open() && !pings_open() ) {
		
			// Neither Comments, nor Pings are open 
			_e('Both comments and pings are currently closed.', 'null');
		
		}
		?>				
		</p>
	</footer>
	
	<nav class="pagination" role="navigation">
		<div class="previous"><?php previous_post_link('%link', '&laquo; %title') ?></div>
		<div class="next"><?php next_post_link('%link', '%title &raquo;') ?></div>
	</nav>
	
	<?php 
	// if comments are open or we have at least one comment, load up the comment template
	if (comments_open() || '0' != get_comments_number()) {
		comments_template();
	}
	?>

	<?php tha_entry_bottom(); ?>

</article>

<?php tha_entry_after(); ?>

<?php else : // hopfully WordPress will 404 this ?>

<?php tha_entry_before(); ?>

<article role="article">

	<?php tha_entry_top(); ?>

	<h3><?php _e('Post Not Found', 'null'); ?></h3>
	<p class="notice"><?php _e("Sorry, but you are looking for something that isn't here.", 'null'); ?></p>

	<?php tha_entry_bottom(); ?>

</article>

<?php tha_entry_after(); ?>

<?php endif; ?>