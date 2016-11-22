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
	get_template_part("template-parts/content-single");
else: ?>
	<li id="post-<?php the_ID(); ?>" <?php post_class("mix"); ?>>
		<a href="<?php the_permalink() ?>">

			<div class="card card--video not-visible">
				<div class="card-body card-body--video" style="background:linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.6) 100%),url(<?php echo get_the_post_thumbnail_url(null, 'video-thumbnail') ?>);background-size: cover; background-position: center;">
					<div class="card-play"></div>
					<div class="card-meta-container">
						<?php the_title( '<div class="card-title card-title--video">', '</div>' ); ?>
						<div class="card-description card-description--video"><?php echo get_the_excerpt() ?></div>
					</div>
				</div>
				<div class="card-footer">
					<div class="card-footer-wrapper" layout="row bottom-left">
						<?php fbd_item_taxonomies(); ?>
						<?php fbd_posted_on(); ?>
						<div class="card-tag is-shownIfHover" self="left"><?php _e("Play this video","fbd") ?></div>
					</div>
				</div>
			</div>
		</a>
	</li>
<?php endif; ?>
