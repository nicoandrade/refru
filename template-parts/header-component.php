<?php
    $header_image = "";
    if ( get_header_image() ) {
        $header_image = get_header_image();
    }

    $refru_header_margin = rwmb_meta( 'refru_header_margin' );
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        $shop_id = get_option( 'woocommerce_shop_page_id' );
        $refru_header_margin = rwmb_meta( 'refru_header_margin', '', $shop_id );
    }
    if ( '' == $refru_header_margin ) {
        $refru_header_margin = 0;
    }

?>
<header id="header" class="site-header refru-header-style-1"
    <?php echo ( $header_image ) ? 'style="background-image: url(' . esc_url( $header_image ) . '); margin-bottom: ' . esc_attr( $refru_header_margin ) . 'px;"' : 'style=" margin-bottom: ' . esc_attr( $refru_header_margin ) . 'px;"'; ?>>

    <div class="refru-nav-btn-wrap">
        <button id="ql_nav_btn2" type="button" class="collapsed refru-nav-btn" data-toggle="collapse"
            data-target="#ql_nav_collapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'refru' ); ?>">
            <i class="fa fa-bars"></i>
        </button>
    </div>

    <div class="refru-logo-wrap">
        <?php
            $logo = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="ql_logo">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
            if ( has_custom_logo() ) {
                $logo = get_custom_logo();
            }
        ?>
        <?php if ( is_front_page() ): ?>
        <h1 class="site-title"><?php echo wp_kses_post( $logo ); ?>&nbsp;</h1>
        <?php else: ?>
        <p class="site-title"><?php echo wp_kses_post( $logo ); ?></p>
        <?php endif; ?>

        <button id="refru-nav-btn" type="button" class="menu-toggle" data-toggle="collapse" aria-controls="primary-menu"
            aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'refru' ); ?>">
            <i class="fa fa-bars"></i>
        </button>
    </div><!-- /refru-logo-wrap -->

    <div class="refru-main-nav-wrap">
        <nav id="site-navigation" class="main-navigation" role="navigation"
            aria-label="<?php esc_attr_e( 'Main Menu', 'refru' ); ?>">
            <?php

                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
            ) ); ?>
        </nav><!-- #site-navigation -->
    </div><!-- /refru-main-nav-wrap -->


    <div class="refru-icons-nav-wrap">

        <nav id="icons-navigation" class="icons-navigation" role="navigation" aria-label="Icons Menu">
            <ul id="icons-menu" class="menu">
                <?php
                    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) ) {
                        $cart_empty = ( WC()->cart->cart_contents_count > 0 ) ? '' : 'cart-empty';
                    ?>

                <li>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
                        class="refru-cart-btn<?php echo esc_attr( ' ' . $cart_empty ); ?>">

                        <span class="count"><?php echo esc_html( WC()->cart->cart_contents_count ); ?></span>
                        <span
                            class="refru-cart-word"><?php echo sprintf( esc_html__( 'Cart (%s)', 'refru' ), esc_html( WC()->cart->cart_contents_count ) ); ?></span>
                        <i class="ql-icon-cart-empty"></i>
                        <i class="ql-icon-cart-full"></i>
                    </a>
                </li>

                <?php } //if WooCommerce active ?>
            </ul>
        </nav>

    </div><!-- /refru-icons-nav-wrap -->

</header>