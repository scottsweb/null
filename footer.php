
		<?php tha_footer_before(); ?>

		<footer id="footer" role="contentinfo">

			<?php tha_footer_top(); ?>

			<?php if (of_get_option('footer_sidebar', '1') && is_active_sidebar('footer')) { ?>
			<aside id="sidebar-footer" class="sidebar" role="complementary">
				<?php dynamic_sidebar('footer'); ?>
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
				<span id="generator-link"><?php echo null_mustache_tags($wordpress_credit); ?></span>
				<?php
				}

				// designer credit
				if ($theme_credit = of_get_option('theme_credit')) {
				?>

				<!-- designer credit -->
				<span id="theme-link"><?php echo null_mustache_tags($theme_credit); ?></span>
				<?php
				}
				?>
			</div>

			<?php tha_footer_bottom(); ?>

		</footer><!-- #footer -->

		<?php tha_footer_after(); ?>

	</div><!-- #wrapper .hfeed -->

	<div id="wp-footer">
		<?php wp_footer(); ?>
	</div><!-- #wp-footer -->

	<?php tha_body_bottom(); ?>

</body>
</html>
<?php if (of_get_option('development_mode', '0')) { ?><!-- page generated in <?php echo timer_stop(); ?> seconds (<?php echo get_num_queries () ?> SQL queries using <?php echo round(memory_get_peak_usage() / 1024 / 1024,2); ?>MB memory). --><?php } ?>