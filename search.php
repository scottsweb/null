<?php get_header() ?>

		<div id="content" role="main">

			<h2 class="page-title"><?php printf(__( 'Search Results for: %s', 'null' ), '<span>' . get_search_query() . '</span>'); ?></h2>

			<?php get_template_part('loop', 'search'); ?>

		</div><!-- #content -->

<?php get_sidebar() ?>
<?php get_footer() ?>