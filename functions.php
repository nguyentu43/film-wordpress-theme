<?php

if(!defined('T_FILM_PLUGIN'))
{
	add_action( 'admin_notices', function(){

       ?>
	    <div class="notice notice-error is-dismissible">
	        <p><?php _e( 'Theme T-Film cần kích hoạt T-Film (Plugin)', 't-film' ); ?></p>
	    </div>
    <?php

	} );
}

if(!function_exists('setup_theme')){

	function setup_theme(){

		load_theme_textdomain( 't-film', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-background', apply_filters( 't_film_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		register_nav_menus( array(
			'menu-top' => esc_html__( 'Menu chính', 't_film' ),
		) );

		add_image_size( 'film-poster', 450, 600, $crop = false );
	}

}
add_action('after_setup_theme', 'setup_theme');

function add_scripts(){

	wp_enqueue_style( 'bootstrap-4-style', get_template_directory_uri().'/css/bootstrap.min.css' );
	wp_enqueue_style( 'open-iconic-bootstrap-style', get_template_directory_uri().'/css/open-iconic-bootstrap.min.css' );
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri().'/css/jquery-ui.min.css' );
	wp_enqueue_style( 'slick-stype', get_template_directory_uri().'/css/slick.css');
	wp_enqueue_style( 'slick-theme-stype', get_template_directory_uri().'/css/slick-theme.css');
	wp_enqueue_style( 'perfect-scrollbar-stype', get_template_directory_uri().'/css/perfect-scrollbar.css');
	wp_enqueue_style( 't-film-style', get_stylesheet_uri());

	wp_enqueue_script( 'wp-api');
	wp_enqueue_script( 'popper-js', get_template_directory_uri().'/js/popper.min.js' );
	wp_enqueue_script( 'bootstrap-4-js', get_template_directory_uri().'/js/bootstrap.min.js' );
	wp_enqueue_script( 'perfect-scrollbar-js', get_template_directory_uri().'/js/perfect-scrollbar.js' );
	wp_enqueue_script( 'jquery-ui-js', get_template_directory_uri().'/js/jquery-ui.min.js' );
	wp_enqueue_script( 'slick-js', get_template_directory_uri().'/js/slick.min.js' );

	wp_enqueue_script( 't-film-page-js', get_template_directory_uri().'/js/page.js' );

	if(is_front_page() && !is_home()){
		wp_enqueue_script( 't-film-front-page-js', get_template_directory_uri().'/js/front-page.js' );

	};

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_enqueue_scripts', 'add_scripts');

function change_title($title){
	if(is_front_page()){
		$title['title'] = __('Trang chủ', 't-film');
	}
	else if(is_home()){
		$title['title'] = __('Tin tức', 't-film');
	}
	else if(is_archive() && !is_search())
	{
		$title['title'] = get_the_archive_title();
	}
	else if(is_search())
	{
		$s = get_query_var( 's', $default = '' );
		if($s)
			$s = ': '.$s;
		$title['title'] = __('Tìm kiếm', 't-film') . $s;
	}
	else if(is_single())
	{
		the_post();
		$title['title'] = get_the_title();
		rewind_posts();
	}
	else if(is_page())
	{
		the_post();
		$_title = get_the_title();

		if($_title == 'Phát video')
		{
			$film = new WP_Query([
				'p' => $_GET['film_id'],
				'post_type' => 'film'
			]);

			if($film->have_posts())
			{
				$film->the_post();
				$_title = 'Xem phim '.get_the_title();
			}

			wp_reset_postdata();
		}

		$title['title'] = $_title;
		rewind_posts();
	}

	return $title;
}

add_filter('document_title_parts', 'change_title');

function custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function register_widget_sidebar()
{
	register_sidebar( [
		'name' => __( 'Widget Sidebar 1', 't-film'),
		'id' => 'widget-right-1',
		'before_widget' => '<div class="col-12 px-0 px-md-3 widget %2$s" id="%1$s"><div class="p-3 bg-film mb-4">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h5 class="title">',
		'after_title'   => '</h5>'
	] );

	register_sidebar( [
		'name' => __( 'Widget Footer 1', 't-film'),
		'id' => 'widget-footer-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s col-sm-4 col-12">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>'
	] );
}

add_action( 'widgets_init', 'register_widget_sidebar');

function template_chooser($template)   
{    
  global $wp_query;   
  $post_type = get_query_var('post_type');   
  if( $wp_query->is_search && $post_type == 'film' )   
  {
    return locate_template('film-search.php');
  }   
  return $template;   
}

add_filter('template_include', 'template_chooser');

function cookie_auth_rest_api(){

	if(is_user_logged_in())
	{
		wp_localize_script( 'wp-api', 'wpApiSettings', array(
		    'root' => esc_url_raw( rest_url() ),
		    'nonce' => wp_create_nonce( 'wp_rest' )
		) );
	}
}

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 't_film_register_required_plugins' );

function t_film_register_required_plugins() {
	$plugins = array(

		array(
			'name'               => 'T-Film (Plugin)', 
			'slug'               => 't-film-plugin', 
			'source'             => get_template_directory() . '/lib/plugins/t-film-plugin.zip', 
			'required'           => true, 
			'force_activation'   => true,
			'force_deactivation' => false,
		),
		array(
			'name'      => 'Category and Taxonomy Image',
			'slug'      => 'wp-custom-taxonomy-image',
			'source'             => get_template_directory() . '/lib/plugins/wp-custom-taxonomy-image.zip', 
			'required'           => true, 
			'force_activation'   => true,
			'force_deactivation' => false,
		),
		array(
			'name'      => 'Facebook Comments by Vivacity',
			'slug'      => 'facebook-comment-by-vivacity',
			'source'             => get_template_directory() . '/lib/plugins/facebook-comment-by-vivacity.zip', 
			'required'           => true, 
			'force_activation'   => true,
			'force_deactivation' => false,
		)

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 't-film',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 't-film' ),
			'menu_title'                      => __( 'Install Plugins', 't-film' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 't-film' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 't-film' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 't-film' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				't-film'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				't-film'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				't-film'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				't-film'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				't-film'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				't-film'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				't-film'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				't-film'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				't-film'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 't-film' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 't-film' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 't-film' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 't-film' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 't-film' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 't-film' ),
			'dismiss'                         => __( 'Dismiss this notice', 't-film' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 't-film' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 't-film' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}

require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/customizer.php';

if ( defined( 'JETPACK__VERSION' ) ){
	require_once get_template_directory() . '/inc/jetpack.php';	
}
require_once get_template_directory() . '/inc/class.JavaScriptPacker.php';