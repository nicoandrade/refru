<?php if ( has_nav_menu( 'social' ) ) {

    wp_nav_menu(
        array(
            'theme_location'  => 'social',
            'container'       => 'div',
            'container_class' => 'menu-social',
            'menu_class'      => 'menu-items nav nav_social menu-social-items',
            'depth'           => 1,
            'link_before'     => '<span class="screen-reader-text">',
            'link_after'      => '</span>',
            'fallback_cb'     => '',
        )
    );

} ?>