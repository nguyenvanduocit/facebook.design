<?php
function fbd_item_taxonomies($post = null, $taxonomy="category"){
	$categories = get_the_terms($post,$taxonomy);
	$category = current($categories);
	echo '<div class="card-type is-notShownIfHover">' . $category->name . '</div>';
}

/**
 * Posted on
 */
function fbd_posted_on() {
	echo '<div class="card-tag is-notShownIfHover" self="left">'.get_the_modified_date().'</div>';
}

/**
 * Output featured image singulare
 */
function fbd_singular_featured_image(){
	if(has_post_thumbnail()){
		$image_src = get_the_post_thumbnail_url();
	}else{
		$image_src = "https://source.unsplash.com/random";
	}
	?>
	<div class="container--image">
		<div class="careers-hero visible" style="background-image: url(<?php echo esc_attr($image_src) ?>);"></div>
	</div>
<?php
}

/**
 * Get logo src
 * @return string
 */
function fbd_logo_src(){
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	if($image){
		return $image[0];
	}else{
		return get_template_directory_uri().'/img/logo-fb.svg';
	}
}

/**
 * Get social links
 * @return array
 */
function fbd_social_links(){
	return [
		'facebook' => get_theme_mod( 'fbd_facebook_url'),
		'twitter' => get_theme_mod( 'fbd_twitter_url'),
		'dribbble' => get_theme_mod( 'fbd_dribbble_url'),
		'medium' => get_theme_mod( 'fbd_medium_url')
	];
}
