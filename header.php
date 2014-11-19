<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package community
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic|Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic|PT+Sans:400,700,400italic,700italic|Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400|Open+Sans+Condensed:300,700,300italic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		
			<div class="site-branding">
				<div class="title-image">
				</div>
			</div>
		
		<div id="nav-wrapper">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle"><?php _e( 'Menu', 'community' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				<?php community_social_menu(); ?>
			</nav>
		</div><!-- #site-navigation -->


	</header><!-- #masthead -->
		<div id="wrapper">
	 		<div id="content" class="site-content">
