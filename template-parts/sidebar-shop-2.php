<?php
if ( ! isset( $_GET['shop_no_sidebar'] ) ) {
    echo '<div class="refru-sidebar-wrapper col-md-2 order-2 order-sm-1">';
    echo '<aside id="woocommerce-sidebar-2" class="woocommerce-sidebar widget-area" role="complementary">';
    dynamic_sidebar( 'shop-sidebar-2' );
    echo '</aside><!-- #sidebar -->';
    echo '</div><!-- /refru-sidebar-wrapper -->';
}