<?php
    /**
     * The template for displaying archive pages.
     *
     * @link https://codex.wordpress.org/Template_Hierarchy
     *
     * @package Refru
     */

get_header(); ?>

<div id="content" class="<?php echo esc_attr( refru_content_css_class() ); ?>">

    <?php if ( have_posts() ): ?>

    <header class="page-header">
        <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="taxonomy-description">', '</div>' );
        ?>
    </header><!-- .page-header -->

    <div class="refru-post-wrapper">
        <?php
            /* Start the Loop */
            while ( have_posts() ): the_post();

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part( 'template-parts/content', get_post_format() );

        endwhile; ?>

    </div><!-- /refru-post-wrapper -->

    <?php get_template_part( 'template-parts/pagination', 'archive' ); ?>

    <?php else: ?>

    <?php get_template_part( 'template-parts/content', 'none' ); ?>

    <?php endif; ?>

</div><!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>