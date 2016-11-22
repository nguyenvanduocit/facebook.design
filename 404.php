<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package fbd
 */

get_header(); ?>
	<div class="container container--header">
		<h1 class="h1--home-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'fbd' ); ?></h1>
		<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'fbd' ); ?></p>
	</div>
<?php
get_footer();
