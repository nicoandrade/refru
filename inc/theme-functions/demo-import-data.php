<?php
/**
 * Set import files
 */
function refru_import_files() {
    return array(
        array(
            'import_file_name'           => esc_attr__( 'Demo 1 - Default', 'refru' ),
            'categories'                 => array(),
            'import_file_url'            => 'https://www.quemalabs.com/files/import-files/refru/demo-1/content.xml',
            'import_widget_file_url'     => 'https://www.quemalabs.com/files/import-files/refru/demo-1/widgets.wie',
            'import_customizer_file_url' => 'https://www.quemalabs.com/files/import-files/refru/demo-1/customizer.dat',
            'import_preview_image_url'   => 'https://www.quemalabs.com/files/import-files/refru/demo-1/screenshot.png',
            'import_notice'              => esc_html__( 'Click on "Import Demo Data" to start importing. Images were replaced by a placeholder to avoid long waits.', 'refru' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'refru_import_files' );

// Disable Proteus branding
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * Assign Menus, Front adn Blog page
 */
function refru_after_import_setup( $import_files ) {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main', 'nav_menu' );
    $footer_menu = get_term_by( 'name', 'Footer', 'nav_menu' );
    $social_menu = get_term_by( 'name', 'Social', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
        'primary'     => $main_menu->term_id,
        'footer-menu' => $footer_menu->term_id,
        'social'      => $social_menu->term_id,
    )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $shop_page_id = get_page_by_title( 'Shop' );
    $blog_page_id = get_page_by_title( 'Blog' );
    $woocommerce_cart_page_id = get_page_by_title( 'Cart' );
    $woocommerce_checkout_page_id = get_page_by_title( 'Checkout' );
    $woocommerce_myaccount_page_id = get_page_by_title( 'My Account' );

    switch ( $import_files['import_file_name'] ) {

    case 'Demo 1 - Default':

        break;

    }

    update_option( 'show_on_front', 'page' );

    //Front Page and Blog Page
    update_option( 'page_on_front', $shop_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

    //WooCommerce
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
    update_option( 'woocommerce_cart_page_id', $woocommerce_cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $woocommerce_checkout_page_id->ID );
    update_option( 'woocommerce_myaccount_page_id', $woocommerce_myaccount_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'refru_after_import_setup' );

/**
 * Export Custom Options
 */
function refru_export_option_keys( $keys ) {
    $keys[] = 'refru_hero_color';
    $keys[] = 'refru_logo_color';
    $keys[] = 'refru_headings_color';
    $keys[] = 'refru_text_color';
    $keys[] = 'refru_link_color';
    $keys[] = 'refru_footer_background';
    $keys[] = 'refru_header_bck_color';
    $keys[] = 'refru_header_lines_color';
    $keys[] = 'refru_shop_options';
    $keys[] = 'refru_shop_categories';
    $keys[] = 'refru_shop_categories';
    $keys[] = 'refru_shop_products_amount';
    $keys[] = 'refru_shop_columns';
    $keys[] = 'refru_shop_pre_page';
    $keys[] = 'refru_shop_post_page';
    $keys[] = 'refru_shop_page_layout';
    $keys[] = 'refru_shop_product_layout';
    $keys[] = 'refru_shop_second_image';
    $keys[] = 'refru_shop_login_icon';
    $keys[] = 'refru_blog_layout';
    $keys[] = 'refru_site_animations';
    $keys[] = 'refru_site_not_kirki';
    $keys[] = 'refru_typography_font_family';
    $keys[] = 'refru_typography_font_family_headings';
    $keys[] = 'refru_typography_subsets';
    $keys[] = 'refru_typography_font_size';
    $keys[] = 'refru_topbar_enable';
    $keys[] = 'refru_topbar_text';
    $keys[] = 'refru_topbar_color';
    $keys[] = 'refru_topbar_menu';
    $keys[] = 'woocommerce_shop_page_id';
    $keys[] = 'woocommerce_cart_page_id';
    $keys[] = 'woocommerce_checkout_page_id';
    $keys[] = 'woocommerce_myaccount_page_id';
    $keys[] = 'custom_logo_is_retina';

    return $keys;
}

add_filter( 'cei_export_option_keys', 'refru_export_option_keys' );