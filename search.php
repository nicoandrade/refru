<?php
    /**
     * The template for displaying search results pages.
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
     *
     * @package Refru
     */

get_header(); ?>

<div id="content" class="<?php echo esc_attr( refru_content_css_class() ); ?>">

    <?php if ( have_posts() ): ?>

    <header class="page-header">
        <h1 class="page-title">
            <?php printf( esc_html__( 'Search Results for: %s', 'refru' ), '<span>' . get_search_query() . '</span>' ); ?>
        </h1>
    </header><!-- .page-header -->

    <?php /* Start the Loop */ ?>
    <?php while ( have_posts() ): the_post(); ?>

    <?php
                /**
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part( 'template-parts/content', 'search' );
            ?>

    <?php endwhile; ?>

    <?php get_template_part( 'template-parts/pagination', 'search' ); ?>

    <?php else: ?>

    <?php get_template_part( 'template-parts/content', 'none' ); ?>

    <?php endif; ?>

</div><!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>