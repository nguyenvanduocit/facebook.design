<?php
/**
 * fbd functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package fbd
 */

if ( ! function_exists( 'fbd_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fbd_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on fbd, use a find and replace
	 * to change 'fbd' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'fbd', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'fbd' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	] );

	add_image_size('thumbnail', 630, 280, true);
	add_image_size('resource-thumbnail', 710, 592, true);
	add_image_size('video-thumbnail', 710, 870, true);
	add_theme_support( 'custom-logo', [
		'height'      => 150,
		'width'       => 150,
		'flex-height' => false,
		'flex-width'  => false,
		'header-text' => [ 'site-title' ],
	] );
}
endif;
add_action( 'after_setup_theme', 'fbd_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fbd_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fbd_content_width', 640 );
}
add_action( 'after_setup_theme', 'fbd_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function fbd_scripts() {
	wp_enqueue_script('fbd-vendor', get_template_directory_uri() . '/js/vendor.js', ['jquery'], false, false);
	wp_enqueue_script('fbd-script', get_template_directory_uri() . '/js/script.js', ['fbd-vendor'], false, false);
	if(is_home() || is_front_page() || is_archive()){
		wp_enqueue_style( 'fbd-homepage', get_template_directory_uri().'/css/homepage.css' );
		wp_enqueue_script('fbd-homepage', get_template_directory_uri() . '/js/homepage.js', ['fbd-vendor'], false, false);
	}
	elseif(is_page() || is_singular()){
		if(get_post_type() == 'video'){
			wp_enqueue_style( 'fbd-singular-video', get_template_directory_uri().'/css/video.css' );
		}else{
			wp_enqueue_style( 'fbd-singular', get_template_directory_uri().'/css/singular.css' );
		}
	}else{
		wp_enqueue_style( 'fbd-global', get_template_directory_uri().'/css/global.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'fbd_scripts' );

/**
 * Change excerpt lenght to 20
 *
 * @param $length
 *
 * @return int
 */
function fbd_custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'fbd_custom_excerpt_length', 999 );

/**
 * Change excerpt to ...
 *
 * @param $more
 *
 * @return string
 */
function fbd_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'fbd_excerpt_more' );

/**
 * Register posttype
 */
function fbd_register_posttype() {
	$posttypes =[
		'resource' => "Resources",
		'video' => "Videos"];

	foreach ($posttypes as $posttype => $label){
		register_post_type( $posttype, [
			'public' => true,
			'label'  => $label,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'comments',
				'revisions',
			]
		] );
		register_taxonomy_for_object_type( 'category', $posttype );
	}
}
add_action( 'init', 'fbd_register_posttype' );

/**
 * Add custom posttype to home query
 * @param WP_Query $query
 *
 * @return WP_Query
 */
function fbd_get_posts( WP_Query $query ) {

	if ( ( is_home() || is_archive()) && $query->is_main_query() )
		$query->set( 'post_type', ['post','resource', 'video'] );

	return $query;
}
add_filter( 'pre_get_posts', 'fbd_get_posts' );

/**
 * Register video metabox
 */
function fbd_video_meta_box()
{
	add_meta_box( 'video-attributes', __('Video Attributes', 'fbd'), 'fbd_video_meta_box_callback', 'video' );
}
add_action( 'add_meta_boxes', 'fbd_video_meta_box' );


/**
 * Outpput metabox content
 *
 * @param $post
 */
function fbd_video_meta_box_callback($post){
	$youtube_id = get_post_meta( $post->ID, '_youtube_id', true );
	echo '<label for="link_download">'.__("Youtube ID: ", "fbd").'</label>' ;
	echo '<input type="text" id="_youtube_id" name="_youtube_id" value="'.$youtube_id.'" />';
}

/**
 * Save metabox
 * @param $post_id
 */
function fbd_video_meta_box_save( $post_id )
{
	$link_download = sanitize_text_field( $_POST['_youtube_id'] );
	update_post_meta( $post_id, '_youtube_id', $link_download );
}
add_action( 'save_post', 'fbd_video_meta_box_save' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';

