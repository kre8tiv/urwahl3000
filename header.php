<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); ?></title>


		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- mobile  -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		
		<!-- open graph -->
		<meta itemprop="og:site_name" content="<?php bloginfo('name'); ?>">
		<meta itemprop="og:title" content="<?php the_title(); ?>">
		<meta itemprop="og:type" content="article">
		<meta itemprop="og:url" content="<?php the_permalink() ?>">
		<meta property="og:description" content="<?php if ( is_single() ) { wp_title('-', true, 'right'); echo  strip_tags( get_the_excerpt() ); } elseif ( is_page() ) { wp_title('-', true, 'right'); echo strip_tags( get_the_excerpt() ); } else { bloginfo('description'); } ?>"/>
		<?php if ( has_post_thumbnail() ){ $og_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); echo '<meta property="og:image" content="'. $og_image[0].'">';} ?>
		
		<!-- basic meta-tags & seo-->

		<meta name="publisher" content="<?php bloginfo('name'); ?>" />
		<meta name="author" content="<?php bloginfo('name'); ?>" />
		<meta name="description" content="<?php if ( is_single() ) { wp_title('-', true, 'right'); echo  strip_tags( get_the_excerpt() ); } elseif ( is_page() ) { wp_title('-', true, 'right'); echo strip_tags( get_the_excerpt() ); } else { bloginfo('description'); } ?>" />
		<?php if ( is_singular() ) echo '<link rel="canonical" href="' . get_permalink() . '" />'; ?>
		

		<!-- icons & favicons -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/lib/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/lib/images/win8-tile-icon.png">


		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>
		
		<!--[if lt IE 9]>
			<script src="<?php echo get_template_directory_uri(); ?>/lib/js/responsive.js"></script>
		<![endif]-->
		
		<?php if (get_header_image() != '') {	?><style>#header.widthimg {margin: 0;background: url(<?php header_image(); ?>) top center no-repeat;background-size: cover;}</style><?php } ?>

		
	</head>

	<body <?php body_class(); ?>>
	
		<nav class="unsichtbar"><h6>Sprungmarken dieser Website</h6><ul>
			<li><a href="#content">Direkt zum Inhalt</a></li>
			<li><a href="#nav-main">Zur Navigation</a></li>
			<li><a href="#sidebar1">Seitenleiste mit weiterführenden Informationen</a></li>
			<li><a href="#footer">Zum Fußbereich</a></li>
		</ul></nav>
		
		<?php do_action('kr8_vor_portal'); ?>
		
		<section id="portal">
			<div class="inner">
				<nav role="navigation" id="nav-portal"><h6 class="unsichtbar">Links zu ähnlichen Websites:</h6>
					<?php kr8_nav_portal(); ?>
				</nav>

				<?php get_search_form(); ?>

				<?php do_action('kr8_in_portal'); ?>
			</div>
		</section>
			
		<?php do_action('kr8_nach_portal'); ?>

		<div id="wrap">
			
			<?php if (get_header_image() != '') {	?>
				<?php do_action('kr8_vor_header'); ?>
				<?php do_action('kr8_vor_header_mitbild'); ?>
				<header id="header" class="pos widthimg" role="banner">
			<?php } else {?>
				<?php do_action('kr8_vor_header'); ?>
				<?php do_action('kr8_vor_header_ohnebild'); ?>
				<header id="header" class="pos noimg" role="banner">
			<?php } ?>

				<?php if ( display_header_text() ) : ?>
					<p id="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Zur Startseite"><img src="<?php echo get_template_directory_uri(); ?>/lib/images/logo.png" width="185" height="100" alt="<?php bloginfo('name'); ?>"></a></p>
					
					<div class="hgroup">
						<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
						<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
					</div>
				<?php endif; ?>
												
				<?php get_search_form(); ?>

				<?php do_action('kr8_im_header'); ?>
			</header>

			<?php do_action('kr8_nach_header'); ?>
				
			<nav class="mobile-switch"><ul><li class="first"><a id="switch-menu" href="#menu"><span class="fa fa-bars"></span><span class="hidden">Menü</span></a></li><li class="last"><a id="switch-search" href="#search"><span class="fa fa-search"></span><span class="hidden">Suche</span></a></li></ul></nav>

			<?php do_action('kr8_vor_navwrap'); ?>

			<section class="navwrap">
				<nav role="navigation" class="pos" id="nav-main"><h6 class="unsichtbar">Hauptmenü:</h6>
					<?php kr8_nav_main(); ?>
				</nav>
				<?php if (function_exists('nav_breadcrumb') ) nav_breadcrumb(); ?>

				<?php do_action('kr8_im_navwrap'); ?>
			</section>

			<?php do_action('kr8_nach_navwrap'); ?>

			<section id="content">
				<div class="inner wrap clearfix">