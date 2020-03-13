<?php
    /**
     * Cart Page
     *
     * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
     *
     * HOWEVER, on occasion WooCommerce will need to update template files and you
     * (the theme developer) will need to copy the new files to your theme to
     * maintain compatibility. We try to do this as little as possible, but it does
     * happen. When this occurs the version of the template file will be bumped and
     * the readme will list any important changes.
     *
     * @see     https://docs.woocommerce.com/document/template-structure/
     * @package WooCommerce/Templates
     * @version 3.8.0
     */

    defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <ul class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

        <?php
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>

        <li
            class="woocommerce-cart-form__cart-item                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
            <?php
                // @codingStandardsIgnoreLine
                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                            __( 'Remove this item', 'refru' ),
                            esc_attr( $product_id ),
                            esc_attr( $_product->get_sku() )
                        ), $cart_item_key );
                    ?>
            <?php
    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'shop_catalog' ), $cart_item, $cart_item_key );
            if ( ! $product_permalink ) {
                echo $thumbnail; // PHPCS: XSS ok.
            } else {
                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
            }
        ?>
            <div class="product_text">
                <div class="product_text_left">
                    <h3><?php
                            if ( ! $product_permalink ) {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                    } else {
                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                }
                                ?></h3>
                </div>

                <div class="product_text_right">
                    <?php
                        // Meta data.
                                echo wc_get_formatted_cart_item_data( $cart_item );
                            ?>

                    <?php
                        // Backorder notification
                                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'refru' ) . '</p>', $product_id ) );
                                }
                            ?>

                    <?php
                        if ( $_product->is_sold_individually() ) {
                                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                } else {
                                    $product_quantity = woocommerce_quantity_input( array(
                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                        'input_value'  => $cart_item['quantity'],
                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                        'min_value'    => '0',
                                        'product_name' => $_product->get_name(),
                                    ), $_product, false );
                                }

                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                            ?>
                    <div class="price">&times;
                        <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                    </div>
                </div>
            </div>

        </li>
        <?php
            }
            }

            do_action( 'woocommerce_cart_contents' );
        ?>
        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
    </ul>


    <div class="actions">

        <?php if ( wc_coupons_enabled() ) { ?>
        <div class="coupon">
            <input type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
                placeholder="<?php esc_attr_e( 'Coupon code', 'refru' ); ?>" /> <button type="submit" class="button"
                name="apply_coupon"
                value="<?php esc_attr_e( 'Apply coupon', 'refru' ); ?>"><?php esc_html_e( 'Apply coupon', 'refru' ); ?></button>
            <?php do_action( 'woocommerce_cart_coupon' ); ?>
        </div>
        <?php } ?>

        <button type="submit" class="button" name="update_cart"
            value="<?php esc_attr_e( 'Update cart', 'refru' ); ?>"><?php esc_html_e( 'Update cart', 'refru' ); ?></button>

        <?php do_action( 'woocommerce_cart_actions' ); ?>

        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">
    <?php
        /**
         * woocommerce_cart_collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action( 'woocommerce_cart_collaterals' );
    ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>