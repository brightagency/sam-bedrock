<?php

/*
|--------------------------------------------------------------------------
| Enqueue scripts
|--------------------------------------------------------------------------
*/

function bedrock_scripts_styles() {

	// SCRIPTS

    // User scripts
    wp_enqueue_script( 'vendor', get_template_directory_uri() . '/dist/js/vendor-min.js?v=' . md5_file(get_template_directory() . '/dist/js/vendor-min.js'), ['jquery'], null, true );
    wp_enqueue_script( 'app', get_template_directory_uri() . '/dist/js/app-min.js?v=' . md5_file(get_template_directory() . '/dist/js/app-min.js'), ['jquery'], null, true );

	// Pass WordPress data into our JS
	$js_data = array(
		'siteURL' => get_site_url(),
		'themeURL' => get_stylesheet_directory_uri(),
		'ajaxURL' => admin_url('admin-ajax.php'),
		'pageID' => get_the_id()
    );
	wp_localize_script( 'app', 'siteData',  $js_data);

    // STYLES
    wp_enqueue_style('main', get_template_directory_uri() . '/dist/css/main.css?v=' . md5_file(get_template_directory() . '/dist/css/main.css'));

}
add_action( 'wp_enqueue_scripts', 'bedrock_scripts_styles' );

/**
* Registers an editor stylesheet for the theme.
*/
function wpdocs_theme_add_editor_styles() {
    add_editor_style( get_template_directory_uri() . '/dist/css/editor.css?v=' . md5_file(get_template_directory() . '/dist/css/editor.css'));
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );

/*
|--------------------------------------------------------------------------
| Bright Color Theme
|--------------------------------------------------------------------------
*/

// Create our colour theme
add_action( 'init', function() {
    wp_admin_css_color( 
        'bright', // id
        'Bright', // name
        get_template_directory_uri() . '/dist/css/admin-colors.css', // stylesheet uri
        ['#222222', '#333333', '#c43333', '#f03f3c'] // display colours
    );
});

// Make sure it's always the default for new users
add_action('user_register', function ($user_id) {
    $args = array(
        'ID' => $user_id,
        'admin_color' => 'bright'
    );
    wp_update_user( $args );
});

// Disable color theme switching for non ID = 1 users
if ( get_current_user_id() != 1 ) {
    remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
}

/*
|--------------------------------------------------------------------------
| Basic setup
|--------------------------------------------------------------------------
*/

// Hide admin bar
show_admin_bar(false);

// Clean up header
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

// Theme support
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );


/*
|--------------------------------------------------------------------------
| Include extra files
|--------------------------------------------------------------------------
*/

include_once get_template_directory() . '/parts/client-backend-setup.php';
include_once get_template_directory() . '/class/class-forge.php';
include_once get_template_directory() . '/parts/cpt.php';