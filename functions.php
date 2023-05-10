<?php

/**
 * Enqueue child theme styles/scripts.
 */
add_action( 'wp_enqueue_scripts', 'exp_child_enqueue_styles' );
function exp_child_enqueue_styles() {
    
    wp_enqueue_style(
        'child-theme',
        get_stylesheet_directory_uri() . '/style.css',
        array(),
        filemtime( get_stylesheet_directory() . '/style.css')
    );
}

/**
 * Remove admin dashboard widgets.
 */
add_action( 'wp_dashboard_setup', 'exp_remove_dashboard_widgets' );
function exp_remove_dashboard_widgets() {
    
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress Events and News
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Activity
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft
    remove_meta_box('wpe_dify_news_feed', 'dashboard', 'normal'); // WP Engine
    
    // Remove for all roles except Administrator
    if ( !current_user_can('manage_options') ) {
        
        remove_action('welcome_panel', 'wp_welcome_panel'); // Welcome
        remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Site Health Status
    }
}

/**
 * Remove dashboard menu items.
 */
add_action( 'admin_init', 'exp_remove_admin_menu_items' );
function exp_remove_admin_menu_items() {
    
    if ( !current_user_can('manage_options') ) {
        remove_menu_page('tools.php');
        remove_menu_page('themes.php');
        remove_menu_page('kadence-blocks');
    }
}

/**
 * Remove application passwords.
 */
add_filter( 'wp_is_application_passwords_available', '__return_false' );

/**
 * Redirect author archive pages.
 */
add_action( 'template_redirect', 'exp_redirect_author_pages' );
function exp_redirect_author_pages() {
    
    if ( is_author() ) {
        wp_safe_redirect( home_url( '/' ), 301 );
        exit;
    }
}
