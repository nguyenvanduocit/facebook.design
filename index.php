<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fbd
 */

get_header(); ?>
<?php  if ( have_posts() ) : ?>
	<div class="container container--header">
		<h1 class="h1--home-title"><?php echo get_theme_mod('fbd_home_title') ?></h1>
		<p><?php echo get_theme_mod('fbd_home_subtitle') ?></p>
	</div>
	<div class="container--grid home-container">
		<ul layout="rows top-left">
		<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/list-item-content', get_post_type() );
			endwhile;
		?>
		</ul>
		<?php the_posts_navigation(); ?>
	</div>
<?php else: ?>
	<div class="container container--header">
		<h1 class="h1--home-title"><?php _e("There are no thing to show you?", "fbd") ?></h1>
		<p><?php _e("Sorry about that, but currently, there are no thing to show you.","fbd") ?></p>
	</div>
<?php endif; ?>
<?php
get_footer();
