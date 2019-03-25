<?php

function t_film_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 't_film_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 't_film_customize_partial_blogdescription',
		) );
	}

	$wp_customize->add_setting('t_film_bg', [
		'default' => 'white',
		'transport' => 'refresh'
	]);

	$wp_customize->add_setting('t_film_navbar_top_bg', [
		'default' => '#343a40',
		'transport' => 'refresh'
	]);

	$wp_customize->add_setting('t_film_navbar_film_bg', [
		'default' => 'white',
		'transport' => 'refresh'
	]);

	$wp_customize->add_setting('t_film_footer_bg', [
		'default' => '#343a40',
		'transport' => 'refresh'
	]);

	$wp_customize->add_setting('t_film_film_item_bg', [
		'default' => 'white',
		'transport' => 'refresh'
	]);

	//color
	$wp_customize->add_setting('t_film_color', [
		'default' => 'black',
		'transport' => 'refresh'
	]);

	$wp_customize->add_setting('t_film_navbar_top_color', [
		'default' => 'white',
		'transport' => 'refresh'
	]);

	$wp_customize->add_setting('t_film_navbar_film_color', [
		'default' => 'black',
		'transport' => 'refresh'
	]);

	$wp_customize->add_setting('t_film_footer_color', [
		'default' => 'white',
		'transport' => 'refresh'
	]);

	$wp_customize->add_setting('t_film_film_item_color', [
		'default' => 'white',
		'transport' => 'refresh'
	]);

	$wp_customize->add_section('t_film_customize_css', [
		'title' => __('T-Film: Màu nền, chữ', 't-film'),
		'priority' => 30
	]);

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film__set_bgcolor', [
		'label' => __('Màu nền nội dung', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_bg'
	]));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film_navbar_top_bg_set_bgcolor', [
		'label' => __('Màu nền Menu Header', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_navbar_top_bg'
	]));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film_navbar_film_bg_set_bgcolor', [
		'label' => __('Màu nền Menu Film', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_navbar_film_bg'
	]));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film_footer_bg_set_bgcolor', [
		'label' => __('Màu nền Footer', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_footer_bg'
	]));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film_film_item_bg_set_bgcolor', [
		'label' => __('Màu nền Film Item', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_film_item_bg'
	]));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film_color_set_color', [
		'label' => __('Màu chữ', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_color'
	]));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film_navbar_top_set_color', [
		'label' => __('Màu chữ Menu Header', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_navbar_top_color'
	]));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film_navbar_film_set_color', [
		'label' => __('Màu chữ Menu Film', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_navbar_film_color'
	]));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 't_film_footer_set_color', [
		'label' => __('Màu chữ Footer', 't-film'),
		'section' => 't_film_customize_css',
		'settings' => 't_film_footer_color'
	]));

}
add_action( 'customize_register', 't_film_customize_register' );


function t_film_customize_partial_blogname() {
	bloginfo( 'name' );
}


function t_film_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function t_film_customize_preview_js() {
	wp_enqueue_script( 't-film-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 't_film_customize_preview_js' );

function t_film_customize_css()
{
    ?>
         <style type="text/css">

			.bg-film, .list-group-item{ background: <?= get_theme_mod('t_film_bg', 'white') ?>; }
			#navbar-film{ background: <?= get_theme_mod('t_film_navbar_film_bg', 'white') ?>; }
			#navbar-top, #navbar-top .dropdown-menu{ background: <?= get_theme_mod('t_film_navbar_top_bg', '#343a40') ?>; }
			footer{	background: <?= get_theme_mod('t_film_footer_bg', '#343a40') ?>; }
			.film-v-list .content, .film-item-default .film-title{ background: <?= get_theme_mod('t_film_film_item_bg', 'white') ?>; }

			#primary, .post-title a,.list-film .title a, .film-item, .film-item a{ color: <?= get_theme_mod('t_film_color', 'black') ?>; }
			#navbar-top a, .btn-toggler{color: <?= get_theme_mod('t_film_navbar_top_color', 'white') ?>;}
			#navbar-film a.nav-link:not(.active){color: <?= get_theme_mod('t_film_navbar_film_color', 'black') ?>;}
			footer{ color: <?= get_theme_mod('t_film_footer_color', 'white') ?>; }

         </style>
    <?php
}
add_action( 'wp_head', 't_film_customize_css');
