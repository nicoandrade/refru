<?php
    /**
     * Template part for displaying single posts.
     *
     * @link https://codex.wordpress.org/Template_Hierarchy
     *
     * @package Refru
     */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="post-header entry-header">
        <?php the_title( '<h1 class="post-title entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->


    <?php if ( has_post_thumbnail() ): ?>
    <div class="post-image">
        <?php the_post_thumbnail( 'refru_post' ); ?>
    </div><!-- /post-image -->
    <?php endif; ?>


    <div class="post-content">

        <?php if ( 'post' === get_post_type() ): ?>
        <footer class="post-footer entry-footer">
            <div class="metadata">
                <?php refru_metadata(); ?>
                <div class="clearfix"></div>
            </div><!-- /metadata -->
        </footer><!-- .entry-footer -->
        <?php endif; ?>

        <div class="entry-content">
            <?php the_content(); ?>
            <?php
    wp_link_pages( array(
        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'refru' ),
        'after'  => '</div>',
    ) );
?>
        </div><!-- .entry-content -->

        <div class="clearfix"></div>

    </div><!-- /post_content -->

</article><!-- #post-## -->