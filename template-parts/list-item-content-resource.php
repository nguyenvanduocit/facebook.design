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
			<div class="card card--resource not-visible" > <!--Resource-->
				<div class="card-hero" style="background-image: url(<?php echo get_the_post_thumbnail_url(null, 'resource-thumbnail') ?>)">
				</div>
				<div class="card-body">
					<?php the_title( '<div class="card-title">', '</div>' ); ?>
					<p class="card-description"><?php echo get_the_excerpt() ?></p>
				</div>
				<div class="card-footer">
					<div class="card-footer-wrapper" layout="row bottom-left">
						<?php fbd_item_taxonomies(); ?>
						<?php fbd_posted_on(); ?>
						<div class="card-tag is-shownIfHover" self="left"><?php _e("View more","fbd") ?></div>
						<div class="card-link is-shownIfHover" self="right"></div>
					</div>
				</div>
			</div>
		</a>
	</li>
<?php endif; ?>
