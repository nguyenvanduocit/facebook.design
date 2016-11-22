<?php
$randomQuery = new WP_Query([
	"orderby" => "rand",
	"posts_per_page" => 3
])
?>
<div class="related_posts-container">
	<p class="related_posts-header"><?php _e("Random Articles", "fbd") ?></p>
	<div layout="rows center-spread">
		<?php while ($randomQuery->have_posts()):$randomQuery->the_post(); ?>
			<a href="<?php the_permalink() ?>">
				<div class="card card--article not-visible"><!--Article-->
					<div class="card-body">
						<div class="card-circle card-circle--article" style="background-image: url('<?php echo get_avatar_url(get_the_author_meta('ID')) ?>')"></div>
						<?php the_title( '<div class="card-title">', '</div>' ); ?>
						<?php if(has_post_thumbnail()): ?>
							<p class="card-description card-description--clamp-0"><?php echo get_the_excerpt() ?></p>
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
		<?php endwhile;
		wp_reset_query()
		?>
	</div>
</div>
