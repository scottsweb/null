
		<footer id="footer" role="contentinfo">
			
			<?php if (of_get_option('footer_sidebar', '1') && is_active_sidebar('sidebar-footer')) { ?>
			<aside id="sidebar-footer" class="sidebar" role="complementary">
				<?php dynamic_sidebar('sidebar-'.null_slugify('Footer')); ?>
			</aside>
			<?php } ?>
			
			<nav id="footer-navigation" role="navigation">
				<?php null_footer_menu(); ?>
			</nav>
			
			<div id="null-footer">
				<?php
				// wordpress credit
				if ($wordpress_credit = of_get_option('wordpress_credit')) {
				?>

				<!-- wordpress credit -->
				<span id="generator-link"><?php echo $wordpress_credit; ?></span>
				<?php
				}

				// designer credit
				if ($theme_credit = of_get_option('theme_credit')) {
				?>

				<!-- designer credit -->
				<span id="theme-link"><?php echo $theme_credit; ?></span>
				<?php
				}
				?>
			</div>
		
		</footer><!-- #footer -->
	
	</div><!-- #wrapper .hfeed -->

	<div id="wp-footer">
		<?php wp_footer(); ?>
	</div><!-- #wp-footer -->

</body>
</html>
<?php if (of_get_option('development_mode', '0')) { ?><!-- page generated in <?php echo timer_stop(); ?> seconds (<?php echo get_num_queries () ?> SQL queries using <?php echo round(memory_get_peak_usage() / 1024 / 1024,2); ?>MB memory). --><?php } ?>