<?php
    // First Sidebar when Both are present
    get_template_part( 'template-parts/sidebar-shop-2', 'shop' );
?>
<div id="content" class="<?php echo esc_attr( refru_shop_css_class() ); ?>">

    <?php
        if ( ! is_shop() ) {
            echo '<header class="page-header">';
            the_archive_title( '<h1 class="page-title">', '</h1>' );
        echo '</header><!-- .page-header -->';
    }