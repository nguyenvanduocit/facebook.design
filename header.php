<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fbd
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="nav" layout="row top-left">
		<div self="left">
			<a href="/"><div class="logo logo-isNotVisIfMobile" style="background-image: url(<?php echo fbd_logo_src() ?>);"><?php bloginfo("site-title") ?></div></a>
			<a href="/"><div class="logo logo-isVisIfMobile"></div></a>
		</div>
		<?php wp_nav_menu( [ 'theme_location' => 'primary','container'=>'div', 'container_class'=>'nav-isNotVisIfMobile'] ); ?>
		<?php wp_nav_menu( [ 'theme_location' => 'primary','container'=>'div', 'container_class'=>'nav-isVisIfMobile'] ); ?>
	</div>

	<div id="content" class="site-content">
