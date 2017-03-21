<?php

/*
|--------------------------------------------------------------------------
| Enqueue scripts
|--------------------------------------------------------------------------
*/

function bedrock_scripts_styles() {

	// SCRIPTS
    wp_deregister_script( 'jquery' );

    // User scripts
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/bower_components/jquery/dist/jquery.min.js', null, null, false );
    wp_enqueue_script( 'components', get_template_directory_uri() . '/dist/js/components-min.js?v=' . md5_file(get_template_directory_uri() . '/dist/js/components-min.js'), null, null, true );
    wp_enqueue_script( 'app', get_template_directory_uri() . '/dist/js/app-min.js?v=' . md5_file(get_template_directory_uri() . '/dist/js/app-min.js'), null, null, true );

	// Pass WordPress data into our JS
    $js_data = array(
        'siteURL' => get_site_url(),
        'themeURL' => get_stylesheet_directory_uri()
    );
    wp_localize_script( 'app', 'siteData',  $js_data);

	// STYLES
	wp_enqueue_style('main', get_template_directory_uri() . '/dist/css/main.css?v=' . md5_file(get_template_directory_uri() . '/dist/css/main.css'));

}
add_action( 'wp_enqueue_scripts', 'bedrock_scripts_styles' );


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
| Post thumbnails
|--------------------------------------------------------------------------
*/

// New image sizes
add_image_size( 'bedrock-200', 200, 200, true );

// Remove default thumbnail sizes
function bedrock_drop_default_image_sizes( $sizes ) {
	unset( $sizes['medium'] );
	unset( $sizes['large'] );
	return $sizes;
}

add_filter( 'intermediate_image_sizes_advanced', 'bedrock_drop_default_image_sizes' );


/*
|--------------------------------------------------------------------------
| Include the Forge class
|--------------------------------------------------------------------------
*/

include_once get_template_directory() . '/class/class-forge.php';