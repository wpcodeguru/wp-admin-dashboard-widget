<?php
/*
Plugin Name: wpcode.guru Latest Articles Dashboard Widget
Plugin URI: https://wpcode.guru/development/how-to-create-a-wordpress-admin-dashboard-widget/
Description: Display the latest WP Code Guru articles in a WordPress admin dashboard widget
Version: 1.0
Author: WP Code Guru
Author URI: https://wpcode.guru/
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Register the dashboard widget
function wpcg_register_dashboard_widget() {
    wp_add_dashboard_widget(
        'wpcg_dashboard_widget',
        'WordPress News, Tips and Tricks from <a href="https://wpcode.guru" target="_blank">WP Code Guru</a>',
        'wpcg_posts_dashboard_widget_contents'
    );
}
add_action( 'wp_dashboard_setup', 'wpcg_register_dashboard_widget' );

// Dashboard widget content
function wpcg_posts_dashboard_widget_contents() {
    $api_url = 'https://wpcode.guru/wp-json/wp/v2/posts?per_page=10&_embed';
    $json_data = file_get_contents($api_url);
    $posts = json_decode($json_data);
    echo '<ul>';
    foreach ($posts as $post) {
        echo '<li><a href="' . $post->link . '" target="_blank">' . $post->title->rendered . '</a></li>';
    }
    echo '</ul>';
}

// Dashboard widget CSS
function wpcg_dashboard_widget_styles() {
    $screen = get_current_screen();
    if ( $screen->base == 'dashboard' ) {
        wp_enqueue_style( 'wpcg-dashboard-widget-styles', plugin_dir_url( __FILE__ ) . 'dashboard-widget.css' );
    }
}
add_action( 'admin_enqueue_scripts', 'wpcg_dashboard_widget_styles' );