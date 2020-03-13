<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Refru
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function refru_body_classes( $classes ) {

    $refru_theme_data = wp_get_theme();

    $classes[] = sanitize_title( $refru_theme_data['Name'] );
    $classes[] = 'v' . $refru_theme_data['Version'];

    // Add Animations Class
    $refru_site_animations = get_theme_mod( 'refru_site_animations', 'true' );
    if ( 'true' == $refru_site_animations ) {
        $classes[] = 'refru-animations';
    }

    // Add class for background color
    $background_color = get_background_color();
    if ( ! empty( $background_color ) ) {
        $color = ariColor::newColor( $background_color );
        if ( 127 < $color->luminance ) {
            $classes[] = 'refru-light-background';
        } else {
            $classes[] = 'refru-dark-background';
        }
    }

    //Add class for Blog Layout
    $classes[] = 'refru-blog-layout-5';

    //Add class if there is Sidebar
    if ( is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'refru-with-sidebar';
    } else {
        $classes[] = 'refru-with-out-sidebar';
    }

    //Add class for Header Menu Type
    $refru_menu_type = get_theme_mod( 'refru_header_menu_type', 'regular-menu' );
    if ( isset( $_GET['menu_type'] ) ) {
        $refru_menu_type = sanitize_text_field( wp_unslash( $_GET['menu_type'] ) );
    }
    if ( 'mega-menu' == $refru_menu_type ) {
        $classes[] = 'refru-mega-menu';
    } else {
        $classes[] = 'refru-regular-menu';
    }

    //Add class for Header Absolute
    $refru_header_absolute = get_theme_mod( 'refru_header_absolute', false );
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        $shop_id = get_option( 'woocommerce_shop_page_id' );
    }
    if ( isset( $_GET['header_absolute'] ) ) {
        $refru_header_absolute = sanitize_text_field( wp_unslash( $_GET['header_absolute'] ) );
    }
    if ( $refru_header_absolute ) {
        $classes[] = 'refru-header-absolute';
    }

    //Add class for Shop Sidebar Position
    $classes[] = 'refru-shop-sidebar-both';

    //Add class for Single Product Layout
    $refru_shop_single_product_layout = get_theme_mod( 'refru_shop_single_product_layout', 'product-fullwidth' );
    if ( isset( $_GET['single_product_layout'] ) ) {
        $refru_shop_single_product_layout = sanitize_text_field( wp_unslash( $_GET['single_product_layout'] ) );
    }
    $classes[] = 'refru-' . esc_attr( $refru_shop_single_product_layout );

    return $classes;
}
add_filter( 'body_class', 'refru_body_classes' );

if ( ! function_exists( 'refru_new_content_more' ) ) {
    function refru_new_content_more( $more ) {
        global $post;
        return ' <br><a href="' . esc_url( get_permalink() ) . '" class="more-link read-more">' . esc_html__( 'Read more', 'refru' ) . ' <i class="ql-icon-arrow-right"></i></a>';
    }
} // end function_exists
add_filter( 'the_content_more_link', 'refru_new_content_more' );

/**
 * Convert HEX colors to RGB
 */
function refru_hex2rgb( $colour ) {
    $colour = str_replace( "#", "", $colour );
    if ( strlen( $colour ) == 6 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    } elseif ( strlen( $colour ) == 3 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    } else {
        return false;
    }
    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );
    return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Avoid undefined functions if Meta Box is not activated
 *
 * @return bool
 */
if ( ! function_exists( 'rwmb_meta' ) ) {
    function rwmb_meta( $key, $args = '', $post_id = null ) {
        return false;
    }
}

/**
 * Return a darker color in HEX
 *
 * @return string
 */
function refru_darken_color( $rgb, $darker = 2 ) {

    $hash = ( strpos( $rgb, '#' ) !== false ) ? '#' : '';
    $rgb = ( strlen( $rgb ) == 7 ) ? str_replace( '#', '', $rgb ) : (  ( strlen( $rgb ) == 6 ) ? $rgb : false );
    if ( strlen( $rgb ) != 6 ) {
        return $hash . '000000';
    }

    $darker = ( $darker > 1 ) ? $darker : 1;

    list( $R16, $G16, $B16 ) = str_split( $rgb, 2 );

    $R = sprintf( "%02X", floor( hexdec( $R16 ) / $darker ) );
    $G = sprintf( "%02X", floor( hexdec( $G16 ) / $darker ) );
    $B = sprintf( "%02X", floor( hexdec( $B16 ) / $darker ) );

    return $hash . $R . $G . $B;
}

/**
 * Return CSS class for #content
 *
 * @return bool
 */
if ( ! function_exists( 'refru_content_css_class' ) ) {
    function refru_content_css_class() {

        if ( is_page_template( 'template-full-width.php' ) ) {
            return 'col-md-12';
        }
        if ( is_page_template( 'template-2-shop-sidebars.php' ) ) {
            return 'col-md-8 order-2';
        }

        if ( is_home() ) { // blog page
            return '';
        }

        if ( is_active_sidebar( 'sidebar-1' ) && ! is_singular( array( 'product' ) ) ) {
            return 'col-md-8';
        } elseif ( is_singular( array( 'product' ) ) ) {
            return 'col-md-12';
        } else {
            return 'col-md-12';
        }
        return 'col-md-8 offset-md-2';

    }
}

/**
 * Return CSS class for Shop Page
 *
 * @return bool
 */
if ( ! function_exists( 'refru_shop_css_class' ) ) {
    function refru_shop_css_class() {

        if ( isset( $_GET['shop_no_sidebar'] ) ) {
            return 'col-md-12';
        }

        return 'col-md-8 order-1 order-sm-1';

    }
}

/**
 * Return CSS class for Container
 *
 * @return bool
 */
if ( ! function_exists( 'refru_container_css_class' ) ) {
    function refru_container_css_class() {

        //Default
        $container_css_class = 'container-fluid';

        if ( is_singular( 'post' ) ) {
            $container_css_class = '';
        } elseif ( is_home() ) { // Blog page
            $container_css_class = '';
        }

        return $container_css_class;

    }
}

/**
 * Return CSS class for Main
 *
 * @return bool
 */
if ( ! function_exists( 'refru_main_css_class' ) ) {
    function refru_main_css_class() {
        //Default
        $main_css_class = 'row';

        if ( is_singular( 'post' ) ) {
            $main_css_class = '';
        } elseif ( is_home() ) { // Blog page
            $main_css_class = '';
        }

        return $main_css_class;

    }
}

/**
 * Return SVG markup.
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function refru_get_svg( $args = array() ) {
    // Make sure $args are an array.
    if ( empty( $args ) ) {
        return __( 'Please define default parameters in the form of an array.', 'refru' );
    }

    // Define an icon.
    if ( false === array_key_exists( 'icon', $args ) ) {
        return __( 'Please define an SVG icon filename.', 'refru' );
    }

    // Set defaults.
    $defaults = array(
        'icon'     => '',
        'title'    => '',
        'desc'     => '',
        'fallback' => false,
    );

    // Parse args.
    $args = wp_parse_args( $args, $defaults );

    // Set aria hidden.
    $aria_hidden = ' aria-hidden="true"';

    // Set ARIA.
    $aria_labelledby = '';

    if ( $args['title'] ) {
        $aria_hidden = '';
        $unique_id = uniqid();
        $aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

        if ( $args['desc'] ) {
            $aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
        }
    }

    // Begin SVG markup.
    $svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

    // Display the title.
    if ( $args['title'] ) {
        $svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

        // Display the desc only if the title is already set.
        if ( $args['desc'] ) {
            $svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
        }
    }

    /*
     * Display the icon.
     *
     * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
     *
     * See https://core.trac.wordpress.org/ticket/38387.
     */
    $svg .= ' <use href="#icon-' . esc_attr( $args['icon'] ) . '"
            xlink:href="#icon-' . esc_attr( $args['icon'] ) . '"></use> ';

    // Add some markup to use as a fallback for browsers that do not support SVGs.
    if ( $args['fallback'] ) {
        $svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
    }

    $svg .= '</svg>';

    return $svg;
}

/**
 * Add dropdown icon if menu item has children.
 *
 * @param string $title The menu item's title.
 * @param object $item The current menu item.
 * @param array $args An array of wp_nav_menu() arguments.
 * @param int $depth Depth of menu item. Used for padding.
 * @return string $title The menu item's title with dropdown icon.
 */
function refru_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
    if ( 'primary' === $args->theme_location ) {
        foreach ( $item->classes as $value ) {
            if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
                $title = $title . '<i class="fa-angle-down fa icon"></i>';
            }
        }
    }

    return $title;
}
add_filter( 'nav_menu_item_title', 'refru_dropdown_icon_to_menu_link', 10, 4 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function refru_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '
<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'refru_pingback_header' );

/**
 * Return the complete URL to the selected Google Font
 *
 */
function refru_get_google_font() {

    $refru_typography_font_family = get_theme_mod( 'refru_typography_font_family', 'Lato' );
    $refru_typography_subsets = get_theme_mod( 'refru_typography_subsets', '' );

    // URL friendly
    $refru_typography_font_family = str_replace( ' ', '+', $refru_typography_font_family );

    //Add Google Fonts
    $refru_font_subset = '';
    if ( is_array( $refru_typography_subsets ) && ! empty( $refru_typography_subsets ) ) {
        $refru_font_subset = '&subset=';
        foreach ( $refru_typography_subsets as $subset ) {
            $refru_font_subset .= $subset . ',';
        }
        $refru_font_subset = rtrim( $refru_font_subset, ',' );
    }

    $refru_google_font = 'https://fonts.googleapis.com/css?family=' . $refru_typography_font_family . ':400,700' .
        $refru_font_subset;

    return esc_url( $refru_google_font );
}

/**
 * Return the complete URL to the selected Google Font for Headings
 *
 */
function refru_get_google_font_headings() {

    $refru_typography_font_family = get_theme_mod( 'refru_typography_font_family_headings', 'Lato' );
    $refru_typography_subsets = get_theme_mod( 'refru_typography_subsets', '' );

    // URL friendly
    $refru_typography_font_family = str_replace( ' ', '+', $refru_typography_font_family );

    //Add Google Fonts
    $refru_font_subset = '';
    if ( is_array( $refru_typography_subsets ) && ! empty( $refru_typography_subsets ) ) {
        $refru_font_subset = '&subset=';
        foreach ( $refru_typography_subsets as $subset ) {
            $refru_font_subset .= $subset . ',';
        }
        $refru_font_subset = rtrim( $refru_font_subset, ',' );
    }

    $refru_google_font = 'https://fonts.googleapis.com/css?family=' . $refru_typography_font_family . ':400,700' .
        $refru_font_subset;

    return esc_url( $refru_google_font );
}

/**
 * Adds a Meta Description tag in the header
 */
function refru_meta_description() {
    $refru_site_meta_description = get_theme_mod( 'refru_site_meta_description', true );
    if ( true == $refru_site_meta_description ) {
        echo '<meta name="description" content="' . esc_attr( get_bloginfo( 'description' ) ) . '">';
    }
}
add_action( 'wp_head', 'refru_meta_description' );

/**
 * Backwards Compatibility for wp_body_open
 *
 */
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}