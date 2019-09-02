<?php
    //Add WooCommerce Support
    add_action( 'after_setup_theme', 'refru_woocommerce_support' );

    function refru_woocommerce_support() {
        add_theme_support(
            'woocommerce', apply_filters(
                'refru_woocommerce_args', array(
                    'single_image_width'            => 400, // Single product main image
                     'thumbnail_image_width'         => 210, // catalog image
                     'gallery_thumbnail_image_width' => 100, // Single product thumbnails
                     'product_grid'                  => array(
                        'default_columns' => 3,
                        'default_rows'    => 4,
                        'min_columns'     => 1,
                        'max_columns'     => 6,
                        'min_rows'        => 1,
                    ),
                )
            )
        );

        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }

    /**
     * Change number or products per row only for demo
     */
    if ( isset( $_GET['shop_columns'] ) ) {
        add_filter( 'loop_shop_columns', 'refru_loop_columns', 999 );
        if ( ! function_exists( 'refru_loop_columns' ) ) {
            function refru_loop_columns() {
                $refru_shop_columns = intval( wp_unslash( $_GET['shop_columns'] ) );
                return $refru_shop_columns;
            }
        }
    }

    /**
     * WooCommerce Templates
     *
     */
    require get_template_directory() . '/inc/woocommerce/woocommerce-templates.php';

    /**
     * Remove Shop Title
     */
    add_filter( 'woocommerce_show_page_title', 'refru_remove_shop_title' );
    function refru_remove_shop_title() {
        if ( is_search() ) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Updates the total with AJAX
     */
    if ( ! function_exists( 'refru_header_add_to_cart_fragment' ) ) {
        function refru_header_add_to_cart_fragment( $fragments ) {
            ob_start();
            $cart_empty = ( WC()->cart->cart_contents_count > 0 ) ? '' : 'cart-empty';
        ?>
<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
    class="refru-cart-btn<?php echo esc_attr( ' ' . $cart_empty ); ?>">
    <span class="count"><?php echo esc_html( WC()->cart->cart_contents_count ); ?></span>
    <span
        class="refru-cart-word"><?php echo sprintf( esc_html__( 'Cart (%s)', 'refru' ), esc_html( WC()->cart->cart_contents_count ) ); ?></span>
    <i class="ql-icon-cart-empty"></i>
    <i class="ql-icon-cart-full"></i>
</a>
<?php
    $fragments['.refru-cart-btn'] = ob_get_clean();

            return $fragments;
        }
    }
    add_filter( 'woocommerce_add_to_cart_fragments', 'refru_header_add_to_cart_fragment' );

    /**
     * Register Widget Area for Shop Sidebar
     */
    function refru_register_shop_sidebar() {
        /*
        Shop Sidebar
        ===================================
         */
        $shop_sidebar_args = array(
            'name'          => 'Shop Sidebar',
            'id'            => 'shop-sidebar',
            'description'   => 'These are widgets for the Shop sidebar.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        );

        register_sidebar( $shop_sidebar_args );

        /*
        Shop Sidebar 2
        ===================================
         */
        register_sidebar( array(
            'name'          => esc_html__( 'Shop Sidebar 2', 'refru' ),
            'id'            => 'shop-sidebar-2',
            'description'   => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
    add_action( 'widgets_init', 'refru_register_shop_sidebar' );

    // Add the slug type for each cart item.
    function refru_woocommerce_cart_item_class( $item_class, $cart_item, $cart_item_key ) {
        if ( ! empty( $cart_item ) && ! empty( $cart_item['data'] ) ) {
            $item_class .= ' post-' . esc_attr( $cart_item['data']->get_id() );
        }
        return $item_class;
}
add_filter( 'woocommerce_cart_item_class', 'refru_woocommerce_cart_item_class', 10, 3 );