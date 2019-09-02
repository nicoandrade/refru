<?php
    /**
     * Template part for displaying posts.
     *
     * @link https://codex.wordpress.org/Template_Hierarchy
     *
     * @package Refru
     */

?>
<article id="post-<?php the_ID(); ?>"<?php post_class(); ?>>
    <?php
        if ( has_post_thumbnail() ):
    ?>
    <div class="post-image">
        <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
            <?php
                $refru_thumbnail_size = 'refru_post';
                the_post_thumbnail( $refru_thumbnail_size );
            ?>
        </a>
    </div><!-- /post-image -->
    <?php endif; ?>

        <header class="post-header entry-header">
            <?php the_title( sprintf( '<h2 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
                the_content();
            ?>

            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'refru' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->

        <div class="clearfix"></div>

        <?php if ( 'post' === get_post_type() ): ?>
        <footer class="post-footer entry-footer">
            <div class="metadata">
                <?php refru_metadata(); ?>
                <div class="clearfix"></div>
            </div><!-- /metadata -->
        </footer><!-- .entry-footer -->
        <?php endif; ?>

        <div class="clearfix"></div>

</article><!-- #post-## -->
