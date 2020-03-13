<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Refru
 */

/**
 * Add theme support for Jetpack
 * See: https://jetpack.me/support/infinite-scroll/
 */
function refru_jetpack_setup() {

    add_theme_support( 'infinite-scroll', array(
        'container' => 'sub-content',
        'render'    => 'refru_infinite_scroll_render',
        'footer'    => false,
    ) );

    if ( class_exists( 'Jetpack' ) ) {
        //Enable Custom CSS
        Jetpack::activate_module( 'custom-css', false, false );
        //Enable Tiled Galleries
        Jetpack::activate_module( 'tiled-gallery', false, false );
    }

} // end function refru_jetpack_setup
add_action( 'after_setup_theme', 'refru_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function refru_infinite_scroll_render() {
    while ( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/content', get_post_format() );
    }
} // end function refru_infinite_scroll_render
