<?php
    /**
     * Template part for displaying page content in page.php.
     *
     * @link https://codex.wordpress.org/Template_Hierarchy
     *
     * @package Refru
     */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
        $refru_show_title = rwmb_meta( 'refru_show_title' );
        if ( 'no' != $refru_show_title ) {
        ?>
    <header class="page-header entry-header">
        <?php the_title( '<h1 class="page-title entry-title">', '</h1>' ); ?>
    </header><!-- .page-header -->
    <?php } ?>

    <div class="page-content">

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'refru' ),
                'after'  => '</div>',
            ) );
        ?>
    </div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->