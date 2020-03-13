<?php
    /**
     * The header for our theme.
     *
     * This is the template that displays all of the <head> section and everything up until <div id="content">
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package Refru
     */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <!-- WP_Head -->
    <?php wp_head(); ?>
    <!-- End WP_Head -->

</head>

<body <?php body_class(); ?>>
    <?php
        if ( function_exists( 'wp_body_open' ) ) {
            wp_body_open();
        } else {
            do_action( 'wp_body_open' );
        }
    ?>
    <div class="refru-preloader">
        <div class="refru-spinner">
            <div class="refru-double-bounce1"></div>
            <div class="refru-double-bounce2"></div>
        </div>
    </div>
    <?php
        echo '<a class="skip-link screen-reader-text" href="#content">' . esc_html__( 'Skip to content', 'refru' ) . '</a>';
    ?>
    <div class="refru-site-wrap">

        <?php
            get_template_part( 'template-parts/header-component', 'header' );
        ?>

        <?php
            /*
            Welcome Box and Banners are displayed only on the Shop page
             */
            if (  ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) ) && is_shop() ) {

            ?>
        <div class="refru-welcome-box">
            <?php
                $refru_home_welcome_desc = get_theme_mod( 'refru_home_welcome_desc', esc_html__( 'We find the best deals to save you time', 'refru' ) );
                ?>
            <h2 class="refru-welcome-box-title"><?php echo wp_kses_post( get_bloginfo( 'description' ) ); ?></h2>
            <p class="refru-welcome-box-desc"><?php echo wp_kses_post( $refru_home_welcome_desc ); ?></p>
            <svg class="refru-welcome-box-bottom" width="1440" height="50" viewBox="0 0 1440 50" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0H1440V10C1440 10 1001.61 50 720 50C438.389 50 0 10 0 10V0Z" fill="#151515"></path>
            </svg>
        </div>
        <?php

            }

            if ( ! is_singular( array( 'product' ) ) ) {
            ?>
        <main id="main" class="site-main">

            <div id="container" class="<?php echo esc_attr( refru_container_css_class() ); ?>">

                <div class="<?php echo esc_attr( refru_main_css_class() ); ?>">
                    <?php
                    }