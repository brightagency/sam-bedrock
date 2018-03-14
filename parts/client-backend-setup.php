<?php

/*
|--------------------------------------------------------------------------
| Client Backend Setup
|--------------------------------------------------------------------------
*/

// Remove Menu Items
// -----------------

function remove_menus () {

    // Don't hide anything for User 1
    if ( get_current_user_id() == 1 ) { return; }

    
    // Top Level Pages
    // ---------------

    // ACF Menu
    remove_menu_page( 'edit.php?post_type=acf-field-group' );

    // Themes
    remove_menu_page( 'themes.php' );

    // Tools
    remove_menu_page( 'tools.php' );

    // Updates
    remove_menu_page( 'update-core' );

    // Activity Log
    remove_menu_page( 'activity_log_page' );

    
    // Submenu Pages
    // -------------

    // Gravity PDF
    remove_submenu_page( 'index.php', 'gfpdf-getting-started' );

    // Nested Pages
    remove_submenu_page( 'options-general.php', 'nested-pages-settings' );

    // Reveal Page IDs
    remove_submenu_page( 'options-general.php', 'reveal-ids-for-wp-admin-25/reveal-ids-for-wp-admin-25.php' );


}
add_action('admin_menu', 'remove_menus', 999);


// Disable Default Dashboard Widgets
// ---------------------------------

add_action('wp_dashboard_setup', function() {

    // Don't hide anything for User 1
    if ( get_current_user_id() == 1 ) { return; }
 
    global $wp_meta_boxes;
    
	// WordPress
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    
    // Yoast
	unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);

}, 999);