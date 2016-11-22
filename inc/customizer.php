<?php
function fbd_customize_register( $wp_customize ) {
	//Footer
	$wp_customize->add_section( 'fbd_footer' , array(
		'title'      => __( 'Footer', 'fbd' ),
		'priority'   => 60,
	) );

	$socialOptions = [
		'fbd_facebook_url' => __("Facebook URL", "fbd"),
		'fbd_twitter_url'=> __("Twitter URL", "fbd"),
		'fbd_dribbble_url'=> __("Dribbble URL", "fbd"),
		'fbd_medium_url'=> __("Medium URL", "fbd"),
	];
	foreach ($socialOptions as $social => $title){
		$wp_customize->add_setting( $social, [
			'type' => 'theme_mod', // or 'option'
			'capability' => 'edit_theme_options',
			'theme_supports' => '', // Rarely needed.
			'default' => 'http://laptrinh.senviet.org',
			'transport' => 'refresh', // or postMessage
		] );
		$wp_customize->add_control($social,[
			'label' => $title,
			'type' => 'url',
			'section' => 'fbd_footer',
		]);
	}
	//END Footer

	//Home page
	$wp_customize->add_section( 'fbd_home' , array(
		'title'      => __( 'Home page', 'fbd' ),
		'priority'   => 60,
	) );

	$wp_customize->add_setting( 'fbd_home_title', [
		'type' => 'theme_mod', // or 'option'
		'capability' => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
		'default' => 'What’s on our mind?',
		'transport' => 'refresh', // or postMessage
	] );
	$wp_customize->add_control('fbd_home_title',[
		'label' => __("Home title", "fbd"),
		'type' => 'text',
		'section' => 'fbd_home',
	]);

	$wp_customize->add_setting( 'fbd_home_subtitle', [
		'type' => 'theme_mod', // or 'option'
		'capability' => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
		'default' => 'Collection of articles, videos, and resources made by designers at Facebook.',
		'transport' => 'refresh', // or postMessage
	] );
	$wp_customize->add_control('fbd_home_subtitle',[
		'label' => __("Home subtitle", "fbd"),
		'type' => 'textarea',
		'section' => 'fbd_home',
	]);
}
add_action( 'customize_register', 'fbd_customize_register' );
