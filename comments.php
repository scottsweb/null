<?php
	
	// security 
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		wp_die(__('Please do not load this page directly. Thanks!', 'null'));

	if (!empty($post->post_password))
	{ 
		// if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) 
		{ ?>
			<p class="nocomments error"><?php _e('This post is password protected. Enter the password to view comments.', 'null'); ?></p>
			<?php
			return;
    	}
 	}
 	
?>

<aside id="comment-wrapper">

<?php if ($comments) : ?>

	<section id="comments">
		
		<header>
			<h3><?php comments_number(__('No Comments', 'null'), __('One Comment', 'null'), __('% Comments', 'null'));?></h3>
		</header>
		
		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // do we need comment pagination? ?>
		<nav class="comment-pagination">
			<div class="previous"><?php previous_comments_link(__('&laquo; Previous Comments', 'null')) ?></div>
			<div class="next"><?php next_comments_link(__('Next Comments &raquo;', 'null')) ?></div>
		</nav>
		<?php endif; ?>

		<ol id="comment-list">
			<?php
				// loop through and list the comments. See null_comment() in /assets/inc/theme.php for formatting
				wp_list_comments( array( 'callback' => 'null_comment' ) );
			?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // do we need comment pagination? ?>
		<nav class="comment-pagination">
			<div class="previous"><?php previous_comments_link(__('&laquo; Previous Comments', 'null')) ?></div>
			<div class="next"><?php next_comments_link(__('Next Comments &raquo;', 'null')) ?></div>
		</nav>
		<?php endif; ?>
		
	</section><!-- #comments -->
	
<?php else : // this is displayed if there are no comments so far ?>

	<section id="no-comments">
		<?php if ('open' == $post->comment_status) : ?> 
			<!-- If comments are open, but there are no comments. -->
		<?php else : // comments are closed ?>
			<!-- If comments are closed. -->
			<h3><?php _e('Comments are closed', 'null'); ?></h3>	
		<?php endif; ?>
	</section><!-- #no-comments -->
	
<?php endif; ?>
<?php if (function_exists('comment_form')) { comment_form(); } else { // now uses bundled comment form function http://codex.wordpress.org/Function_Reference/comment_form - however not HTML5 compliant ?>
	<section id="respond">

		<?php if ('open' == $post->comment_status) : ?>
		<?php $req = get_option('require_name_email'); ?>
			
			<header>
				<h3><?php comment_form_title( __('Post a Comment', 'null'), __('Reply to %s', 'null')); ?></h3>
				<div id="reply-cancel" class=""><?php cancel_comment_reply_link(__('Cancel Reply', 'null')); ?></div>
				<div id="form-feedback"><p id="comment-notes"><?php _e('Your email is <em>never</em> shared.', 'null'); ?> <?php if ($req) { _e('Required fields are marked <span class="required">*</span>', 'null'); } ?></p></div>
			</header>
			
			<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
				<p>
				<?php 
				printf(
					__('You must be <a href="%1$s">logged in</a> to post a comment.', 'null'),
					get_option('siteurl') . '/wp-login.php?redirect_to='. get_permalink()
				);
				?>
				</p>
			<?php else : ?>
				<form action="<?php echo site_url('wp-comments-post.php') ?>" method="post" id="comment-form">
					<?php if ( $user_ID ) : ?>
						<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(); ?>" title="<?php _e('Log out of this account', 'null'); ?>"><?php _e('Logout &raquo;', 'null'); ?></a></p>
					<?php else : ?>
						<fieldset>
							<div class="form-row">
								<label for="author"><?php _e('Name', 'null'); ?> <?php if ($req) echo '<span class="required">*</span>'; ?></label>
								<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" placeholder="<?php _e('Name', 'null'); ?>" title="<?php _e('Name', 'null'); ?>" <?php if ($req) echo 'required'; ?>/>
							</div>
							<div class="form-row">
								<label for="email"><?php _e('Email', 'null'); ?> <?php if ($req) echo '<span class="required">*</span>'; ?></label>
								<input type="email" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" placeholder="<?php _e('Email', 'null'); ?>" title="<?php _e('Email', 'null'); ?>" <?php if ($req) echo 'required'; ?>/>
							</div>
							<div class="form-row">
								<label for="url"><?php _e('Website', 'null'); ?></label>
								<input type="url" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" placeholder="http://" title="<?php _e('Website', 'null'); ?>"/>
							</div>
						<?php endif; ?>
							<div class="form-row">
								<label for="comment"><?php _e('Comment', 'null'); ?> <span class="required">*</span></label>
								<textarea name="comment" id="comment" rows="10" tabindex="4" placeholder="<?php _e("What's on your mind?", 'null'); ?>" title="<?php _e('Comment', 'null'); ?>" required></textarea>
							</div>
							<div class="form-row form-button">
								<input name="submit" type="submit" tabindex="5" value="<?php _e('Comment', 'null'); ?>" /> 
								<?php comment_id_fields(); ?>
								<?php do_action('comment_form', $post->ID); ?>
							</div>
						</fieldset>
						<div class="help">
							<p id="allowed_tags" class="small"><?php _e('You can use the following tags:', 'null'); ?> <code><?php echo allowed_tags(); ?></code></p>
						</div>
				</form>
			<?php endif;?>
		<?php endif; ?>
	</section><!-- #respond -->
	<?php } ?>
</aside><!-- #comment-wrapper-->