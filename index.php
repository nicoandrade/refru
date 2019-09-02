<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Refru
 */

get_header(); ?>

	<div id="content" class="<?php echo esc_attr( refru_content_css_class() ); ?>">

		<?php if ( have_posts() ) : ?>

			<div class="refru-post-wrapper">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						$post_format = get_post_format();
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', $post_format );
					?>

				<?php endwhile; ?>
				
			</div><!-- /refru-post-wrapper -->

			<?php get_template_part( 'template-parts/pagination', 'index' ); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</div><!-- /content -->


<?php get_sidebar(); ?>


<?php get_footer(); ?>
