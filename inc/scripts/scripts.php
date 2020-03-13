<?php

//Imageloaded  ===================================================
wp_enqueue_script( 'imagesloaded', true );

/* Vendor
============================================== */
wp_enqueue_script( 'refru-vendor', get_template_directory_uri() . '/js/vendor.min.js', array(), '1.0.0', true );
//wp_enqueue_script( 'refru-vendor', get_template_directory_uri() . '/js/vendor.js', array(), '1.0.0', true );

//Comment Reply ===================================================
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
}
//=================================================================

//Customs Scripts =================================================
wp_enqueue_script( 'refru-custom', get_template_directory_uri() . '/js/custom.min.js', array( 'jquery', 'refru-vendor' ), '1.0.1', true );
//wp_enqueue_script( 'refru-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery', 'refru-vendor' ), '1.0.1', true );
$refru_custom_js = array(
    'admin_ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
    'token'      => wp_create_nonce( 'quemalabs-secret' ),
    'quote'      => refru_get_svg( array( 'icon' => 'quote-right' ) ),
    'expand'     => __( 'Expand child menu', 'refru' ),
    'collapse'   => __( 'Collapse child menu', 'refru' ),
    'icon'       => refru_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),
);
wp_localize_script( 'refru-custom', 'refru', $refru_custom_js );
//=================================================================

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) ) {
    if ( is_shop() ) {
        wp_enqueue_script( 'wc-single-product' );
        wp_enqueue_script( 'wc-add-to-cart-variation' );
        wp_enqueue_script( 'wc-add-to-cart' );
    }
}