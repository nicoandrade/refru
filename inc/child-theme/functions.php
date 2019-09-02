<?php
function child_refru_theme_enqueue_styles() {
    // Parent styles
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array() );

    // Child styles
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );

}
add_action( 'wp_enqueue_scripts', 'child_refru_theme_enqueue_styles' );
