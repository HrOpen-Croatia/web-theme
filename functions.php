<?php

function terminal_theme_enqueue_styles() {
    wp_enqueue_style('terminal-css', get_stylesheet_directory_uri() . '/css/terminal.min.css', array(), '0.7.4');
    wp_enqueue_style('console-css', get_stylesheet_directory_uri() . '/css/console.css', array('terminal-css'), '1.0.0');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css', array('terminal-css'), '1.0.0');
}

add_action('wp_enqueue_scripts', 'terminal_theme_enqueue_styles');

register_nav_menus([
    'primary' => __('Primary Menu')
]);
?>