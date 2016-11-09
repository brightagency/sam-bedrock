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
    wp_enqueue_script( 'fontawesome', 'https://use.fontawesome.com/92d1da124e.js', null, null, false );
    wp_enqueue_script( 'components', get_template_directory_uri() . '/js/min/components-min.js', null, null, true );
    wp_enqueue_script( 'app', get_template_directory_uri() . '/js/min/app-min.js', null, null, true );

	// Pass WordPress data into our JS
    $js_data = array(
        'install_url' => get_site_url(),
        'theme_url' => get_stylesheet_directory_uri()
    );
    wp_localize_script( 'app', 'wp_vars',  $js_data);

	// STYLES
	wp_enqueue_style('main', get_template_directory_uri() . '/style.css?v=' . md5_file(get_template_directory_uri() . '/style.css'));

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
| Functions
|--------------------------------------------------------------------------
*/

// Grab highest ancestor page ID
function frg_ancestor_id()
{
    global $post;

    if ( $post->post_parent ) {
        $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
        return $ancestors[0];
    }

    return $post->ID;
}

// Custom list pages with root page included
function frg_list_pages_with_intro( $args ) {

    global $post;

    if ( $post->post_parent ) {
        $grandfather = array_reverse( get_post_ancestors( $post->ID ) )[0];
        $is_current_page_item = false;
    } else {
        $grandfather = $post->ID;
        $is_current_page_item = true;
    }

    ?><li class="page_item page-item-<?php echo $grandfather; ?><?php if ($is_current_page_item) echo " current_page_item"; ?>">
        <a href="<?php echo the_permalink($grandfather); ?>"><?php echo get_the_title($grandfather) ?> Intro</a>
    </li><?php

    wp_list_pages( $args );
}