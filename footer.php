<?php
    /**
     * The template for displaying the footer.
     *
     * Contains the closing of the #content div and all content after.
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package Refru
     */

?>


</div><!-- /#row -->

</div><!-- /#container -->

</main><!-- #main -->

<div class="footer-wrap">

    <div class="sub-footer">

        <div class="sub-footer-copy">

            <p><?php esc_html_e( '&copy; Copyright', 'refru' ); ?><?php echo ' ' . esc_html( date_i18n( __( 'Y', 'refru' ) ) ); ?>
                <a rel="nofollow"
                    href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( bloginfo( 'name' ) ); ?></a>
            </p>
        </div>
        <div class="sub-footer-social-menu">
            <?php get_template_part( '/template-parts/social-menu', 'footer' ); ?>
        </div>
    </div><!-- .sub-footer -->

</div><!-- .footer-wrap -->

</div><!-- /refru-site-wrap -->

<?php wp_footer(); ?>

</body>

</html>