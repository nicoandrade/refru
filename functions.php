<?php
/**
 * Refru functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Refru
 */

if ( ! function_exists( 'refru_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
    function refru_setup() {

        /*
         * Defines Constant
         */
        $refru_theme_data = wp_get_theme();
        define( 'REFRU_THEME_NAME', $refru_theme_data->get( 'Name' ) );
        define( 'REFRU_THEME_VERSION', $refru_theme_data->get( 'Version' ) );
        define( 'REFRU_THEME_AUTHOR', $refru_theme_data->get( 'Author' ) );

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Refru, use a find and replace
         * to change 'refru' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'refru', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        //Blog
        add_image_size( 'refru_post', 888, 498, true );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Menu', 'refru' ),
            'social'  => esc_html__( 'Social Menu', 'refru' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'refru_custom_background_args', array(
            'default-color' => 'ebebeb',
            'default-image' => '',
        ) ) );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        // Add support for full and wide align images.
        add_theme_support( 'align-wide' );

        // Adding support for responsive embedded content.
        add_theme_support( 'responsive-embeds' );

        // Adds default block styles also for the front end
        add_theme_support( 'wp-block-styles' );

        // Editor Styles
        add_theme_support( 'editor-styles' );

        // Google Fonts on Editor Styles
        $refru_google_font = refru_get_google_font();
        $refru_google_font_headings = refru_get_google_font_headings();

        // Dynamic Styles for Editor
        $dynamic_editor_styles_url = add_query_arg(
            array(
                'action' => 'refru_dynamic_editor_styles',
                'token'  => wp_create_nonce( 'refru-dynamic-editor-style' ),
            ),
            esc_url( admin_url( 'admin-ajax.php' ) )
        );

        // Adds all the Custom Styles for the Editor at once
        add_editor_style( array( 'css/style-editor.css', $refru_google_font, $refru_google_font_headings, $dynamic_editor_styles_url ) );

        // Add Logo support
        add_theme_support( 'custom-logo', array(
            'height'      => 40,
            'width'       => 110,
            'flex-height' => true,
            'flex-width'  => true,
        ) );

    }
endif; // refru_setup
add_action( 'after_setup_theme', 'refru_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function refru_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'refru_content_width', 780 );
}
add_action( 'after_setup_theme', 'refru_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function refru_widgets_init() {

    require get_template_directory() . '/inc/widget-areas/widget-areas.php';

}
add_action( 'widgets_init', 'refru_widgets_init' );

/**
 * Register widgets.
 *
 * @link https://codex.wordpress.org/Widgets_API
 */
function refru_widgets_register() {
}
add_action( 'widgets_init', 'refru_widgets_register' );

/**
 * Enqueue scripts and styles.
 */
function refru_scripts() {

    /**
     * Enqueue Stylesheets
     */
    require get_template_directory() . '/inc/scripts/stylesheets.php';

    /**
     * Enqueue Scripts
     */
    require get_template_directory() . '/inc/scripts/scripts.php';

}
add_action( 'wp_enqueue_scripts', 'refru_scripts' );

/**
 * Custom CSS generated by the Theme.
 */
require get_template_directory() . '/inc/scripts/styles.php';

/**
 * Admin Styles
 *
 * Enqueue styles to the Admin Panel.
 */
function refru_wp_admin_style() {
    $current_screen = get_current_screen();

    if ( "appearance_page_refru_theme-info" == $current_screen->id || 'page' == $current_screen->id || 'post' == $current_screen->id || 'customize' == $current_screen->id ) {

        wp_register_style( 'refru_custom_wp_admin_css', get_template_directory_uri() . '/css/admin-styles.css', false, '1.0.0' );
        wp_enqueue_style( 'refru_custom_wp_admin_css' );

    }
}
add_action( 'admin_enqueue_scripts', 'refru_wp_admin_style' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Extras
 *
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer
 *
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * WooCommerce Support
 *
 * WooCommerce additions.
 */
require get_template_directory() . '/inc/woocommerce/woocommerce-support.php';

/**
 * Jetpack
 *
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Theme Functions
 *
 * Add Theme Functions
 */

// Custom Header
require get_template_directory() . '/inc/theme-functions/custom-header.php';

// TGM Plugin Activation
require get_template_directory() . '/inc/theme-functions/ql-tgm-plugin-activation.php';

// Theme Info Page
require get_template_directory() . '/inc/theme-functions/theme-info-page.php';

// AJAX Functions
require get_template_directory() . '/inc/theme-functions/ajax-functions.php';

// Retina Logo
require get_template_directory() . '/inc/theme-functions/retina-logo.php';

// Menu Walker
require get_template_directory() . '/inc/theme-functions/menu-walker.php';

// Aricolor
require get_template_directory() . '/inc/theme-functions/aricolor.php';