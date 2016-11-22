<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fbd
 */

?>
<?php if ( is_single() ) :
	get_template_part("template-parts/content-single", get_post_type());
else: ?>

	<li id="post-<?php the_ID(); ?>" <?php post_class("mix"); ?>>
		<a href="<?php the_permalink() ?>">
			<div class="card card--article not-visible"><!--Article-->
				<div class="card-body">
					<div class="card-circle card-circle--article" style="background-image: url('<?php echo get_avatar_url(get_the_author_meta('ID')) ?>')"></div>
					<?php the_title( '<div class="card-title">', '</div>' ); ?>
					<?php if(has_post_thumbnail()): ?>
						<div class="card-description card-description--clamp-0"><?php echo get_the_excerpt() ?></div>
					<?php else: ?>
						<p class="card-description card-description--clamp-14"><?php echo get_the_excerpt() ?></p>
						<p class="card-description card-article-preview"><?php echo wp_trim_words(get_the_content(), 50) ?></p>
					<?php endif; ?>
				</div>
				<?php if(has_post_thumbnail()): ?>
					<div class="card-hero">
						<div class="card-image card-image--size-185" style="background-image: url(<?php echo get_the_post_thumbnail_url(null, 'thumbnail') ?>);"></div>
					</div>
				<?php endif; ?>
				<div class="card-footer">
					<div class="card-footer-wrapper" layout="row bottom-left">
						<?php fbd_item_taxonomies(); ?>
						<?php fbd_posted_on(); ?>
						<div class="card-tag is-shownIfHover" self="left"><?php _e("View more","fbd") ?></div>
						<div class="card-readmore is-shownIfHover" self="right"></div>
					</div>
				</div>
			</div>
		</a>
	</li>
<?php endif; ?>
