<!doctype html>
<!--[if lt IE 7 ]> <html <?php language_attributes() ?> class="no-js ie6 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes() ?> class="no-js ie7 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes() ?> class="no-js ie8 lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes() ?> class="no-js"> <!--<![endif]-->
<head>

<?php tha_head_top(); ?>

<!-- utf-8 -->
<meta charset="<?php bloginfo('charset') ?>" />

<!-- title -->
<title><?php if (function_exists('wpseo_frontend_init') || class_exists('All_in_One_SEO_Pack')) { wp_title('|'); } else { null_title(); } ?></title>

<!-- set mobile viewport // maximum-scale=1.0 for mobile apps -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php tha_head_bottom(); ?>

<!-- wp_head -->
<?php wp_head(); ?>

</head>

<body <?php body_class()?>>

	<?php tha_body_top(); ?>

	<div id="accessibility" class="visuallyhidden">
		<a href="#content" class="skip-link" title="Skip to content"><?php _e('Skip to content &raquo;', 'null'); ?></a>
	</div><!-- #accessibility -->
	
	<div id="wrapper" class="hfeed">

		<?php tha_header_before(); ?>

		<header id="header" role="banner">

			<?php tha_header_top(); ?>
			
			<h1 id="site-title"><?php null_logo(); ?></h1>
			<?php if (of_get_option('show_tagline', '1')) { ?><h2 id="site-description"><?php bloginfo('description') ?></h2><?php } ?>

			<nav id="navigation" role="navigation">
				<?php null_navigation_menu(); ?>
			</nav><!--  #navigation -->

			<?php tha_header_bottom(); ?>

		</header><!-- #header -->
		
		<?php tha_header_after(); ?>
			
		<?php if (of_get_option('breadcrumbs', '0')) { ?>
		<nav id="breadcrumbs">
			<?php 
			breadcrumb_trail(array(
				'separator' => '&rsaquo;', 
				'before' => false, 
				'after' => false, 
				'front_page' => true, 
				'show_home' => __('Home', 'null'), 
				'echo' => true
				)
			); 
			?>		
		</nav><!-- #breadcrumbs -->
		<?php } ?>