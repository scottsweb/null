<?php
/**
This is the default view for an attached library item.
This template will be irrelevant if you never use the "Link to Page" option when inserting a library item. 
Other views include: image.php, video.php, audio.php, application.php - all are optional.
By default we will redirect this page to the file.
**/

/** by default simply redirect to the file - the library item view is oftern overkill **/
the_post();
wp_redirect(wp_get_attachment_url($post->ID));
exit;

?>
<?php get_header() ?>

		<?php tha_content_before(); ?>

		<div id="content" role="main">

			<?php tha_content_top(); ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php if (!empty($post->post_parent)) : // page title ?>
				<h2 class="page-title"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr(printf(__('Return to %s', 'null'), get_the_title($post->post_parent))); ?>" rev="attachment" rel="gallery">&laquo; <?php echo get_the_title($post->post_parent); ?></a></h2>
			<?php endif; ?>

			<?php tha_entry_before(); ?>

		    <article <?php post_class() ?> role="article">
				
				<?php tha_entry_top(); ?>

				<header>
					<h3 class="entry-title"><?php the_title(); ?></h3>
				</header>
				
				<div class="entry-content">
					<div class="entry-attachment">

					<?php if ( wp_attachment_is_image() ) :
						
						$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
						
						foreach ( $attachments as $k => $attachment ) {
							if ( $attachment->ID == $post->ID )
							break;
						}
						$k++;
						
						// If there is more than 1 image attachment in a gallery
						if ( count( $attachments ) > 1 ) {
							if ( isset( $attachments[ $k ] ) )
								// get the URL of the next image attachment
								$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
							else
								// or get the URL of the first image attachment
								$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
						} else {
							// or, if there's only 1 image attachment, get the URL of the image
							$next_attachment_url = wp_get_attachment_url();
						}
						?>
						
						<p class="attachment">
							<a href="<?php echo $next_attachment_url; ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
							<?php echo wp_get_attachment_image( $post->ID, 'large' ); ?>
							</a>
						</p>
						
						<?php if ($wp_query->max_num_pages > 1) : // only paginate when necessary ?>
						<nav class="attachment-pagination">
							<div class="previous"><?php previous_image_link(false, __('&laquo; Previous Image', 'null')) ?></div>
							<div class="next"><?php next_image_link(false, __('Next Image &raquo;', 'null')) ?></div>
						</nav>
						<?php endif; ?>
					
					<?php else : ?>
						
						<p class="attachment">
							<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
						</p>
						
					<?php endif; ?>			
					
					</div><!-- .entry-attachment -->
					
					<div class="entry-caption"><?php if (!empty($post->post_excerpt)) the_excerpt(); // caption from gallery settings ?></div>
														
				</div><!-- .entry-content -->
				
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

	  			<?php comments_template(); ?>

	  			<?php tha_entry_bottom(); ?>

		    </article>

			<?php tha_entry_after(); ?>

 			<?php endwhile; else: ?>
 
 			<?php tha_entry_before(); ?>

			<article role="article">

				<?php tha_entry_top(); ?>

				<h3><?php _e('No Posts Found', 'null'); ?></h3>
				<p class="notice"><?php _e('Sorry, no attachments were found that matched your criteria.', 'null'); ?></p>
			
				<?php tha_entry_bottom(); ?>

			</article>    

			<?php tha_entry_after(); ?>		
		
			<?php endif; ?>

			<?php tha_content_bottom(); ?>

		</div><!-- #content -->

		<?php tha_content_after(); ?>
		
<?php get_sidebar() ?>
<?php get_footer() ?>