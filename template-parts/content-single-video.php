<div class="page-wrapper">
	<div class="container--video">
		<iframe class="fb-video" width="560" height="315" src="https://www.youtube.com/embed/<?php echo get_post_meta( get_the_ID(), '_youtube_id', true ); ?>" frameborder="0" allowfullscreen></iframe>
	</div>
</div>
<div class="page-wrapper">
	<div class="container--text">
		<?php the_title( '<h1>', '</h1>' ); ?>
		<p class="meta-robo"><?php echo get_the_modified_date() ?></p>
		<?php the_content() ?>
	</div>
</div>
