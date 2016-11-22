<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package fbd
 */

get_header(); ?>
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content-single', get_post_type() );
			get_template_part( 'template-parts/related', get_post_type() );

		endwhile; // End of the loop.
		?>
<?php
get_footer();
