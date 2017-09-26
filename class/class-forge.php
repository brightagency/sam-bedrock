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
    
    public static function page_item_class($page_id, $additional_classes = false) {
        echo 'class="' . self::get_page_item_classes($page_id, $additional_classes) . '"';
    }

    public static function get_page_item_classes($page_id, $additional_classes = false) {
        // Setup empty array of classes
        $classes = [];

        // page_item class
        $classes[] = 'page_item';

        // page-item-[id] class
        $classes[] = 'page-item-' . $page_id;

        // current_page_item class if it's the current page
        if ($page_id == get_the_id()) {
            $classes[] = 'current_page_item';
        }

        // Page item has children
        if (count(get_children(['post_parent' => $page_id]))) {
            $classes[] = 'has_children';
        }

        // Additional classes
        if ($additional_classes) {
            if (gettype($additional_classes) == 'string') {
                $classes[] = $additional_classes;
            } elseif (gettype($additional_classes == 'array')) {
                foreach ($additional_classes as $class) {
                    $classes[] = $class;
                }
            }
        }

        // Space separated string of classes
        return implode(' ', $classes);
    }

}
