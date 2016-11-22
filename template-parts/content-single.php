<div class="page-wrapper">
	<div class="container--text">
		<?php the_title( '<h1>', '</h1>' ); ?>
		<h4><?php echo get_the_excerpt() ?></h4>
	</div>
</div>
<?php fbd_singular_featured_image(); ?>
<div class="page-wrapper">
	<div class="container--text">
		<?php the_content() ?>
	</div>
</div>
