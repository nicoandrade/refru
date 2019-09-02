<?php
    /**
     * The template for displaying 404 pages (not found).
     *
     * @link https://codex.wordpress.org/Creating_an_Error_404_Page
     *
     * @package Refru
     */

get_header(); ?>

<div id="content" class="site-content col-md-12">

    <section class="error-404 not-found">
        <header class="page-header">
			<i class="fas fa-exclamation-circle"></i>
            <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'refru' ); ?></h1>
        </header><!-- .page-header -->

        <div class="page-content">
            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'refru' ); ?>
            </p>

            <?php get_search_form(); ?>

        </div><!-- .page-content -->
    </section><!-- .error-404 -->

</div><!-- #div -->

<?php get_footer(); ?>