<?php

/**
 * Container class to frequently used functions and helpers
 */
class Forge {

    /**
     * Returns the ID of the highest page ancestor
     *
     * @return int
     */
    public static function ancestor_id() {

        // Get the current post from the loop
        global $post;

        // Find the highest ancestor
        if ( $post->post_parent ) {
            $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
            return $ancestors[0];
        }

        // Return the highest ancestor
        return $post->ID;
    }

    /**
     * Mimicks wp_list_pages but includes and Intro page
     * @return void
     */
    public static function list_pages_with_intro( $args ) {

        // Get the current post from the loop
        global $post;

        // Find the highest page ancestor
        if ( $post->post_parent ) {
            $grandfather = array_reverse( get_post_ancestors( $post->ID ) )[0];
            $is_current_page_item = false;
        } else {
            $grandfather = $post->ID;
            $is_current_page_item = true;
        }

        // Create an 'intro' link using the highest page ancestor
        ?><li class="page_item page-item-<?php echo $grandfather; ?><?php if ($is_current_page_item) echo " current_page_item"; ?>">
            <a href="<?php echo the_permalink($grandfather); ?>"><?php echo get_the_title($grandfather) ?> Intro</a>
        </li><?php

        // List pages with the passed in $args
        wp_list_pages( $args );
    }

}