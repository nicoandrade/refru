<?php
    /*
    Shop Page
    ============================================================*/

    //Change the default Before & After content
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

    add_action( 'woocommerce_before_main_content', 'refru_wrapper_start', 10 );
    add_action( 'woocommerce_after_main_content', 'refru_wrapper_end', 10 );

    if ( ! function_exists( 'refru_wrapper_start' ) ) {
        function refru_wrapper_start() {
            if ( is_single() ) {
                get_template_part( "/template-parts/beforeloop", "woocommerce-single" );
            } else {
                get_template_part( "/template-parts/beforeloop", "woocommerce" );
            }
        }
    }

    if ( ! function_exists( 'refru_wrapper_end' ) ) {
        function refru_wrapper_end() {
            if ( is_single() ) {
                get_template_part( "/template-parts/afterloop", "woocommerce-single" );
            } else {
                get_template_part( "/template-parts/afterloop", "woocommerce" );
            }
        }
    }

    /**
     * Remove Catalog Ordering on Shop Page
     */
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

    /**
     * Close product link after thumbnails
     */
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_close', 11 );

    /**
     * Remove Add to cart and add it inside product_text
     */
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15 );

    /**
     * Add wrapper for product text on content-product.php
     */
    add_action( 'woocommerce_shop_loop_item_title', 'refru_wrapper_product_text_start', 8 );
    add_action( 'woocommerce_after_shop_loop_item_title', 'refru_wrapper_product_text_end', 20 );
    if ( ! function_exists( 'refru_wrapper_product_text_start' ) ) {
        function refru_wrapper_product_text_start() {
            echo '<div class="product_text">';
        }
    }
    if ( ! function_exists( 'refru_wrapper_product_text_end' ) ) {
        function refru_wrapper_product_text_end() {
            global $product;
            if ( ! $product->is_in_stock() ) {
                echo '<p class="stock out-of-stock">';
                esc_html_e( 'Out of stock', 'refru' );
                echo '</p>';
            }
            echo "</div>";
        }
    }

    /**
     * Wrap the main Product Loop Start
     */
    if ( ! function_exists( 'refru_loop_wrap_start' ) ) {
        function refru_loop_wrap_start() {
            echo '<div class="refru-main-products-wrap">';
        }
    }
    add_action( 'woocommerce_before_shop_loop', 'refru_loop_wrap_start', 40 );

    /**
     * Wrap the main Product Loop End
     */
    if ( ! function_exists( 'refru_loop_wrap_end' ) ) {
        function refru_loop_wrap_end() {
            echo '</div><!-- /.refru-main-products-wrap -->';
        }
    }
    add_action( 'woocommerce_after_shop_loop', 'refru_loop_wrap_end', 5 );

    //Remove Rating from product loop
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

    /**
     * Wraps a product into a div to use with CSS animations
     */
    if ( ! function_exists( 'refru_woocommerce_template_loop_product_animation_wrap_start' ) ) {
        function refru_woocommerce_template_loop_product_animation_wrap_start() {
            echo '<div class="refru-product-loading-content"></div><div class="refru-product-animation-wrap">';
        }
    }
    //Wraps a product into a div to use with CSS animations
    add_action( 'woocommerce_before_shop_loop_item', 'refru_woocommerce_template_loop_product_animation_wrap_start', 5 );

    /**
     * Wraps a product into a div to use with CSS animations
     */
    if ( ! function_exists( 'refru_woocommerce_template_loop_product_animation_wrap_end' ) ) {
        function refru_woocommerce_template_loop_product_animation_wrap_end() {
            echo '</div>';
        }
    }
    //Wraps a product into a div to use with CSS animations
    add_action( 'woocommerce_after_shop_loop_item', 'refru_woocommerce_template_loop_product_animation_wrap_end', 25 );

    /**
     * Insert the opening anchor tag for products in the loop.
     */
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    add_action( 'woocommerce_before_shop_loop_item', 'refru_template_loop_product_link_open', 10 );
    if ( ! function_exists( 'refru_template_loop_product_link_open' ) ) {
        function refru_template_loop_product_link_open() {
            echo '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link refru-product-link" aria-label="' . esc_attr( get_the_title() ) . '">';
            echo '<i class="fa fa-refresh fa-spin fa-fw"></i>';
        }
    }

    // Removes the "Product Category:" from the Archive Title
    add_filter( 'get_the_archive_title', 'refru_archive_title' );
    function refru_archive_title( $title ) {
        if ( is_tax() ) {
            $title = single_cat_title( '', false );
        }
        return $title;
    }

    /*
    Single Product Page
    ============================================================*/

    //Remove Breadcrumbs
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

    // Move order for Sale Flash
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 2 );

    // Starts Wrap for images and content on single product
    add_action( 'woocommerce_before_single_product_summary', 'refru_wrapper_start_single_product', 5 );
    function refru_wrapper_start_single_product() {
        echo '<div class="refru-single-product-wrap">';
    }

    // Ends Wrap for images and content on single product
    add_action( 'woocommerce_after_single_product_summary', 'refru_wrapper_end_single_product', 5 );
    function refru_wrapper_end_single_product() {
        echo '</div>';
    }

    // Move order for Ratings
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 3 );

    // Move order for Price
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

    /**
     * Adds SKU, Categories and Tags below tabs in Single Product
     */
    if ( ! function_exists( 'refru_single_product_after_tabs' ) ) {
        function refru_single_product_after_tabs() {
            global $product;

            $refru_cats = get_the_terms( $product->get_id(), 'product_cat' );
            $refru_tag = get_the_terms( $product->get_id(), 'product_tag' );

            if ( $product->get_sku() || $refru_cats || $refru_tag ) {
            ?>
<div class="refru-product-metadata">
    <?php
        if ( $product->get_sku() ) {
                    ?>
    <div class="refru-product-metadata-item"><span
            class="refru-product-metadata-desc"><?php echo esc_html__( 'SKU:', 'refru' ); ?></span><?php echo esc_html( $product->get_sku() ); ?>
    </div>
    <?php
        }
                    if ( $refru_cats ) {
                    ?>
    <div class="refru-product-metadata-item"><span
            class="refru-product-metadata-desc"><?php echo esc_html( _n( 'Category:', 'Categories:', sizeof( $refru_cats ), 'refru' ) ); ?></span><?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?>
    </div>
    <?php
        }
                    if ( $refru_tag ) {
                    ?>
    <div class="refru-product-metadata-item"><span
            class="refru-product-metadata-desc"><?php echo esc_html( _n( 'Tag:', 'Tags:', sizeof( $refru_tag ), 'refru' ) ); ?></span><?php echo wc_get_product_tag_list( $product->get_id(), ', ' ); ?>
    </div>
    <?php
        }
                ?>
</div>
<?php
    }

        }
    }
    add_action( 'woocommerce_after_single_product_summary', 'refru_single_product_after_tabs', 13 );

    //Remove categories from Single Product page
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

    /*
    Sidebar Shop
    ============================================================*/

    /**
     * Adds Start wrapper for Shop Sidebar
     */
    if ( ! function_exists( 'refru_sidebar_wrapper_start' ) ) {
        function refru_sidebar_wrapper_start() {

            if ( is_single() ) {
                return false;
            }

            echo '<div class="refru-sidebar-wrapper  col-md-2 order-3 order-sm-3">';

        }
    }
    add_action( 'woocommerce_sidebar', 'refru_sidebar_wrapper_start', 5 );

    /**
     * Adds End wrapper for Shop Sidebar
     */
    if ( ! function_exists( 'refru_sidebar_wrapper_end' ) ) {
        function refru_sidebar_wrapper_end() {

            if ( is_single() ) {
                return false;
            }
            echo '</div><!-- /refru-sidebar-wrapper -->';
        }
}
add_action( 'woocommerce_sidebar', 'refru_sidebar_wrapper_end', 15 );