<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<title><?php wp_title(''); ?> - <?php bloginfo('name'); ?></title>

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
		
		
		<?php if(is_single()): ?>
			<script>
			jQuery(document).ready(function($){
			      if($('#socialshareprivacy').length > 0){
			        $('#socialshareprivacy').socialSharePrivacy({
						 services : {
						        facebook : {
						            'dummy_img'  : '<?php echo get_template_directory_uri(); ?>/lib/js/libs/socialshareprivacy/images/dummy_facebook.png'
						        }, 
						        twitter : {
						            'dummy_img'  : '<?php echo get_template_directory_uri(); ?>/lib/js/libs/socialshareprivacy/images/dummy_twitter.png'
						        },
						        gplus : {
						            'dummy_img'  : '<?php echo get_template_directory_uri(); ?>/lib/js/libs/socialshareprivacy/images/dummy_gplus.png'
						        }
						    },
						  'css_path' : '<?php echo get_template_directory_uri(); ?>/lib/js/libs/socialshareprivacy/socialshareprivacy.css'
						});
			        
			      }
			      
			    });
			</script>
		<?php endif;?>
	</head>

	<body <?php body_class(); ?>>
	
		<nav class="unsichtbar"><h6>Sprungmarken dieser Website</h6><ul>
			<li><a href="#content">Direkt zum Inhalt</a></li>
			<li><a href="#nav-main">Zur Navigation</a></li>
			<li><a href="#sidebar1">Seitenleiste mit weiterführenden Informationen</a></li>
			<li><a href="#footer">Zum Fußbereich</a></li>
		</ul></nav>
		
		<section id="portal">
			<div class="inner">
					<nav role="navigation" id="nav-portal"><h6 class="unsichtbar">Links ähnlichen Websites:</h6>
						<?php kr8_nav_portal(); ?>
					</nav>
			<?php get_search_form( $echo ); ?>
			</div>
		</section>
			

		<div id="wrap">
			
				<nav class="mobile-switch"><ul><li class="first"><a id="switch-menu" href="#menu">Menü</a></li><li class="middle"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></li><li class="last"><a id="switch-search" href="#search">Suche</a></li></ul></nav>
				
						
						<?php if (get_header_image() != '') {	?>
							<header id="header" class="pos widthimg" role="banner">
							<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" class="headerimg"/><? 
						
						} else {?>
							<header id="header" class="pos" role="banner">
						
						<?php } ?>

						<p id="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Zur Startseite"><img src="<?php echo get_template_directory_uri(); ?>/lib/images/logo.png" width="185" height="100" alt="<?php bloginfo('name'); ?>"></a></p>
						<div class="hgroup">
							<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
							<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
						</div>						
						<?php get_search_form( $echo ); ?>
				</header>


				<section class="navwrap">
					<nav role="navigation" class="pos" id="nav-main"><h6 class="unsichtbar">Hauptmenü:</h6>
						<?php kr8_nav_main(); ?>
					</nav>
					<?php if (function_exists('nav_breadcrumb') && !is_home()) nav_breadcrumb(); ?>
				</section>

			

			
			<section id="content">
				<div class="inner wrap clearfix">