<?php

/*
|--------------------------------------------------------------------------
| Enqueue scripts
|--------------------------------------------------------------------------
*/

function bedrock_scripts() {

    wp_deregister_script( 'jquery' );

    // Core scripts
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/bower_components/jquery/dist/jquery.min.js', null, '2.1.4', false );
    wp_enqueue_script( 'what-input', get_template_directory_uri() . '/bower_components/what-input/what-input.min.js', null, '1.1.3', true );
    wp_enqueue_script( 'foundation', get_template_directory_uri() . '/bower_components/foundation-sites/dist/foundation.min.js', null, '6.0.4', true );

    // Custom scripts
    wp_enqueue_script( 'fontawesome', 'https://use.fontawesome.com/92d1da124e.js', null, null, true );
    wp_enqueue_script( 'matchHeight', get_template_directory_uri() . '/bower_components/matchHeight/dist/jquery.matchHeight-min.js', null, null, true );

    // User scripts
    wp_enqueue_script( 'app', get_template_directory_uri() . '/js/min/app-min.js', null, null, true );

}

add_action( 'wp_enqueue_scripts', 'bedrock_scripts' );


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