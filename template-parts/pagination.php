<div class="clearfix"></div>
<?php
    if ( ! class_exists( 'Jetpack' ) || ! Jetpack::is_module_active( 'infinite-scroll' ) ):
        $pagination = get_the_posts_pagination( array(
            'prev_text' => esc_html__( 'Previous page', 'refru' ),
            'next_text' => esc_html__( 'Next page', 'refru' ),
        ) );

        if ( $pagination ) {
            echo '<div class="pagination_wrap">';
            echo wp_kses_post( $pagination );
            echo '</div><!-- /pagination_wrap -->';
        }
endif;
?>