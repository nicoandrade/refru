<?php
    if ( is_active_sidebar( 'shop-sidebar' ) && ! is_single() && ! isset( $_GET['shop_no_sidebar'] ) ) {
    ?>
<aside id="sidebar" class="woocommerce-sidebar">

    <?php
            if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 'shop-sidebar' ) ): else:

                endif;
            ?>

    <div class="clearfix"></div>
</aside>
<?php } //if is_active_sidebar ?>