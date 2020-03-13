<?php
/**
 * Refru Theme Customizer.
 *
 * @package Refru
 */

/**
 * Remove control "Display Site Title and Tagline"
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function refru_default_customizer_settings( $wp_customize ) {
    // remove control "Display Site Title and Tagline"
    $wp_customize->remove_control( 'display_header_text' );

    // if selective refresh is available.
    if ( isset( $wp_customize->selective_refresh ) ) {

        $wp_customize->selective_refresh->add_partial( 'title_tagline', array(
            'selector'        => '.refru-welcome-box-title',
            'settings'        => array( 'blogdescription' ),
            'render_callback' => function () {
                return get_bloginfo( 'description' );
            },
        ) );
    }

    /*
    PRO Version
    ------------------------------ */
    $wp_customize->add_section( 'refru_pro_section', array(
        'title'    => esc_attr__( 'Refru Pro', 'refru' ),
        'priority' => 5,
    ) );
    $wp_customize->add_setting( 'refru_probtn', array( 'default' => '', 'sanitize_callback' => 'refru_sanitize_text' ) );
    $wp_customize->add_control( new refru_Display_Text_Control( $wp_customize, 'refru_probtn', array(
        'section' => 'refru_pro_section', // Required, core or custom.
         /* translators: %1$s: open anchor %2$s: closing anchor */
        'label'   => sprintf( __( 'Check out the PRO version for more features. %1$s Go Pro %2$s', 'refru' ), '<a target="_blank" class="button" href="https://www.quemalabs.com/theme/refru-pro/" style="margin: 10px auto; display: block; text-align: center;">', '</a>' ),
    ) ) );
}
add_action( 'customize_register', 'refru_default_customizer_settings' );

/**
 * Configuration sample for the Kirki Customizer.
 * The function's argument is an array of existing config values
 * The function returns the array with the addition of our own arguments
 * and then that result is used in the kirki_config filter
 *
 * @param $config the configuration array
 *
 * @return array
 */
function refru_kirki_configuration_styling( $config ) {
    return wp_parse_args( array(
        'disable_loader' => true,
    ), $config );
}
add_filter( 'kirki_config', 'refru_kirki_configuration_styling' );

if ( class_exists( 'Kirki' ) ) {

    // Define Kirki Config
    Kirki::add_config( 'refru', array(
        'capability'  => 'edit_theme_options',
        'option_type' => 'theme_mod',
    ) );

    /*
    Colors
    ===================================================== */
    /*
    Featured
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_featured_color',
        'label'     => esc_html__( 'Featured Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#fff50a',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => refru_featured_color(),
                'property' => 'color',
            ),
            array(
                'element'  => refru_featured_background_color(),
                'property' => 'background-color',
            ),
            array(
                'element'  => refru_featured_border_color(),
                'property' => 'border-color',
            ),
        ),
    ) );

    /*
    Headings Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_headings_color',
        'label'     => esc_html__( 'Headings Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#222222',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => 'h1:not(.site-title), h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover',
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Text Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_text_color',
        'label'     => esc_html__( 'Text Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#484848',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => 'body',
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Link Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_link_color',
        'label'     => esc_html__( 'Link Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#4662ef',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => 'a',
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Title
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'     => 'custom',
        'settings' => 'refru_title_color_footer',
        'label'    => esc_html__( 'Footer Colors', 'refru' ),
        'section'  => 'colors',
    ) );

    /*
    Sub Footer Background Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_sub_footer_background',
        'label'     => esc_html__( 'Sub Footer Background Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#1b1b1b',
        'choices'   => array(
            'alpha' => true,
        ),
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => '.sub-footer',
                'property' => 'background-color',
            ),
        ),
    ) );

    /*
    Sub Footer Text Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_sub_footer_title_color',
        'label'     => esc_html__( 'Sub Footer Text Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#929292',
        'choices'   => array(
            'alpha' => true,
        ),
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => '.sub-footer',
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Sub Footer Social Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_sub_footer_social_color',
        'label'     => esc_html__( 'Sub Footer Social Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#FFFFFF',
        'choices'   => array(
            'alpha' => true,
        ),
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => '.sub-footer .nav_social li a, .sub-footer .widget #menu-social li a',
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Title
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'     => 'custom',
        'settings' => 'refru_title_color_header',
        'label'    => esc_html__( 'Header Colors', 'refru' ),
        'section'  => 'colors',
    ) );

    /*
    Header Background Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_header_bck_color',
        'label'     => esc_html__( 'Header Background Color', 'refru' ),
        'section'   => 'colors',
        'choices'   => array(
            'alpha' => true,
        ),
        'default'   => '#151515',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => '#header, .single-product #header, .refru-welcome-box',
                'property' => 'background-color',
            ),
            array(
                'element'  => '.refru-welcome-box .refru-welcome-box-bottom path',
                'property' => 'fill',
            ),
        ),
    ) );

    /*
    Logo Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_logo_color',
        'label'     => esc_html__( 'Logo Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#FFFFFF',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => '#header .refru-logo-wrap .site-title .ql_logo',
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Header Text Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_sub_header_text_color',
        'label'     => esc_html__( 'Header Text Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#FFFFFF',
        'choices'   => array(
            'alpha' => true,
        ),
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => array(
                    '.main-navigation a',
                    '#header',
                    '#header .refru-icons-nav-wrap ul li a',
                    '#header .nav_social li a',
                ),
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Header Hover Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_sub_header_hover_color',
        'label'     => esc_html__( 'Header Hover Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#b5b5b5',
        'choices'   => array(
            'alpha' => true,
        ),
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => array(
                    '.no-touchevents #header .refru-icons-nav-wrap ul li a:hover',
                    '.no-touchevents .main-navigation a:hover',
                ),
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Header Lines Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_header_lines_color',
        'label'     => esc_html__( 'Header Lines Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#333333',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => '
					.refru-cart-btn,
					#header,
					.single-product #header,
					.logo_container::before,
					.refru-header-2 #header .logo_container::before,
					.refru-header-2 #header .refru-cart-btn,
					#header.refru-header-style-8 .refru-main-nav-wrap',
                'property' => 'border-color',
            ),
            array(
                'element'  => '#header .refru-icons-nav-wrap::before',
                'property' => 'background-color',
            ),
        ),
    ) );

    /*
    Title
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'     => 'custom',
        'settings' => 'refru_title_color_submenu',
        'label'    => esc_html__( 'Sub Menu Colors', 'refru' ),
        'section'  => 'colors',
    ) );

    /*
    Sub Menu Background Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_header_submenu_bck_color',
        'label'     => esc_html__( 'Sub Menu Background Color', 'refru' ),
        'section'   => 'colors',
        'choices'   => array(
            'alpha' => true,
        ),
        'default'   => '#ffffff',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => array( '.main-navigation ul ul', '.refru-mega-menu .main-navigation ul ul' ),
                'property' => 'background-color',
            ),
        ),
    ) );

    /*
    Sub Menu Items Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_header_submenu_items_color',
        'label'     => esc_html__( 'Sub Menu Items Color', 'refru' ),
        'section'   => 'colors',
        'choices'   => array(
            'alpha' => true,
        ),
        'default'   => '#4d4d4d',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => array(
                    '.refru-mega-menu .main-navigation ul ul li a',
                    '.main-navigation ul ul a',
                ),
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Sub Menu Description Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_header_submenu_description_color',
        'label'     => esc_html__( 'Sub Menu Description Color', 'refru' ),
        'section'   => 'colors',
        'choices'   => array(
            'alpha' => true,
        ),
        'default'   => '#b9b9b9',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => array( '.main-navigation ul ul a .description', '.refru-mega-menu .main-navigation ul li a .description' ),
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Sub Menu Icons Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'        => 'color',
        'settings'    => 'refru_header_submenu_icons_color',
        'label'       => esc_html__( 'Sub Menu Icons Color', 'refru' ),
        'description' => esc_html__( 'If you add icons to menu items and use Icon Fonts.', 'refru' ),
        'section'     => 'colors',
        'default'     => '#6683e2',
        'transport'   => 'auto',
        'output'      => array(
            array(
                'element'  => array(
                    '.menu-item i._mi',
                ),
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Sub Menu Hover Background Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_header_submenu_hover_bck_color',
        'label'     => esc_html__( 'Sub Menu Hover Background Color', 'refru' ),
        'section'   => 'colors',
        'choices'   => array(
            'alpha' => true,
        ),
        'default'   => 'rgba(0,0,0,0.05)',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => array(
                    '.no-touchevents .refru-mega-menu .main-navigation ul ul li a:hover',
                    '.no-touchevents .main-navigation ul ul a:hover',
                ),
                'property' => 'background-color',
            ),
        ),
    ) );

    /*
    Sub Menu Hover Item Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_header_submenu_hover_item_color',
        'label'     => esc_html__( 'Sub Menu Hover Item Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#222222',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => array(
                    '.no-touchevents .refru-mega-menu .main-navigation ul ul li a:hover',
                    '.no-touchevents .main-navigation ul ul a:hover',
                ),
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Sub Menu Hover Description Color
    ------------------------------ */
    Kirki::add_field( 'refru', array(
        'type'      => 'color',
        'settings'  => 'refru_header_submenu_hover_description_color',
        'label'     => esc_html__( 'Sub Menu Hover Description Color', 'refru' ),
        'section'   => 'colors',
        'default'   => '#9e9e9e',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element'  => array(
                    '.no-touchevents .refru-mega-menu .main-navigation ul ul li a:hover .description',
                ),
                'property' => 'color',
            ),
        ),
    ) );

    /*
    Blog Options
    ===================================================== */
    Kirki::add_section( 'refru_blog_section', array(
        'title'    => esc_html__( 'Blog Options', 'refru' ),
        'priority' => 130,
    ) );

    /*
    Site Options
    ===================================================== */
    Kirki::add_section( 'refru_site_options_section', array(
        'title'    => esc_html__( 'Site Options', 'refru' ),
        'priority' => 140,
    ) );

    Kirki::add_field( 'refru', array(
        'type'     => 'switch',
        'settings' => 'refru_site_animations',
        'label'    => esc_html__( 'Site Animations', 'refru' ),
        'section'  => 'refru_site_options_section',
        'default'  => '1',
        'choices'  => array(
            'on'  => esc_html__( 'On', 'refru' ),
            'off' => esc_html__( 'Off', 'refru' ),
        ),
    ) );

    Kirki::add_field( 'refru', array(
        'type'     => 'switch',
        'settings' => 'refru_site_meta_description',
        'label'    => esc_html__( 'Meta Description in <head>', 'refru' ),
        'section'  => 'refru_site_options_section',
        'default'  => '1',
        'choices'  => array(
            'on'  => esc_html__( 'On', 'refru' ),
            'off' => esc_html__( 'Off', 'refru' ),
        ),
    ) );

    /*
    Home Options
    ===================================================== */
    Kirki::add_section( 'refru_home_options_section', array(
        'title'    => esc_html__( 'Home Options', 'refru' ),
        'priority' => 145,
    ) );

    Kirki::add_field( 'refru', [
        'type'            => 'text',
        'settings'        => 'refru_home_welcome_desc',
        'label'           => esc_html__( 'Welcome Description', 'refru' ),
        'section'         => 'refru_home_options_section',
        'default'         => esc_html__( 'We find the best deals to save you time', 'refru' ),
        'priority'        => 20,
        'partial_refresh' => [
            'welcome_box_desc' => [
                'selector'        => '.refru-welcome-box .refru-welcome-box-desc',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'refru_home_welcome_desc', esc_html__( 'We find the best deals to save you time', 'refru' ) ) );
                },
            ],
        ],
    ] );

    /*
    Typography
    ------------------------------ */
    Kirki::add_section( 'refru_typography_section', array(
        'title'    => esc_html__( 'Typography', 'refru' ),
        'priority' => 150,
    ) );

    Kirki::add_field( 'refru', array(
        'type'     => 'select',
        'settings' => 'refru_typography_font_family',
        'label'    => esc_html__( 'Font Family', 'refru' ),
        'section'  => 'refru_typography_section',
        'default'  => 'Lato',
        'priority' => 20,
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output'   => array(
            array(
                'element'  => 'body',
                'property' => 'font-family',
            ),
        ),
    ) );

    Kirki::add_field( 'refru', array(
        'type'     => 'select',
        'settings' => 'refru_typography_font_family_headings',
        'label'    => esc_html__( 'Headings Font Family', 'refru' ),
        'section'  => 'refru_typography_section',
        'default'  => 'Lato',
        'priority' => 22,
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output'   => array(
            array(
                'element'  => refru_headings_font_classes(),
                'property' => 'font-family',
            ),
        ),
    ) );

    Kirki::add_field( 'refru', array(
        'type'        => 'multicheck',
        'settings'    => 'refru_typography_subsets',
        'label'       => esc_html__( 'Google-Font subsets', 'refru' ),
        'description' => esc_html__( 'The subsets used from Google\'s API.', 'refru' ),
        'section'     => 'refru_typography_section',
        'default'     => array( 'latin' ),
        'priority'    => 23,
        'choices'     => Kirki_Fonts::get_google_font_subsets(),
    ) );

    Kirki::add_field( 'refru', array(
        'type'      => 'slider',
        'settings'  => 'refru_typography_font_size',
        'label'     => esc_html__( 'Font Size', 'refru' ),
        'section'   => 'refru_typography_section',
        'default'   => 16,
        'priority'  => 25,
        'choices'   => array(
            'min'  => 7,
            'max'  => 48,
            'step' => 1,
        ),
        'output'    => array(
            array(
                'element'  => 'html',
                'property' => 'font-size',
                'units'    => 'px',
            ),
        ),
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => 'html',
                'function' => 'css',
                'property' => 'font-size',
                'units'    => 'px',
            ),
        ),
    ) );

} else {

    add_action( 'customize_register', 'refru_no_kirki' );

} // If class_exists( 'Kirki' )

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function refru_no_kirki( $wp_customize ) {
    $wp_customize->add_section( 'refru_no_kirki_section', array(
        'title' => esc_html__( 'Install Kirki Plugin', 'refru' ),
    ) );

    $wp_customize->add_setting( 'refru_site_not_kirki', array( 'default' => '', 'sanitize_callback' => 'refru_sanitize_text' ) );
    $wp_customize->add_control( new refru_Display_Text_Control( $wp_customize, 'refru_site_not_kirki', array(
        'section' => 'refru_no_kirki_section', // Required, core or custom.
         /* translators: %1$s: open anchor %2$s: closing anchor */
        'label'   => sprintf( esc_html__( 'To access Site Options make sure you have installed the %1$s Kirki Toolkit %2$s plugin.', 'refru' ), '<a href="' . esc_url( get_admin_url( null, 'themes.php?page=tgmpa-install-plugins' ) ) . '">', '</a>' ),
    ) ) );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function refru_customize_register( $wp_customize ) {

    /**
     * Control for the PRO buttons
     */
    class refru_Pro_Version extends WP_Customize_Control {
        public function render_content() {
            $args = array(
                'a'      => array(
                    'href'  => array(),
                    'title' => array(),
                ),
                'br'     => array(),
                'em'     => array(),
                'strong' => array(),
            );
            echo wp_kses( $this->label, $args );
        }
    }

    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

    $wp_customize->remove_control( 'header_textcolor' );

}
add_action( 'customize_register', 'refru_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function refru_customize_preview_js() {

    wp_register_script( 'refru_customizer_preview', get_template_directory_uri() . '/js/customizer-preview.js', array( 'customize-preview' ), '20151024', true );
    wp_localize_script( 'refru_customizer_preview', 'refru_wp_customizer', array(
        'ajax_url'  => esc_url( admin_url( 'admin-ajax.php' ) ),
        'theme_url' => esc_url( get_template_directory_uri() ),
        'site_name' => get_bloginfo( 'name' ),
    ) );
    wp_enqueue_script( 'refru_customizer_preview' );

}
add_action( 'customize_preview_init', 'refru_customize_preview_js' );

/**
 * Load scripts on the Customizer not the Previewer (iframe)
 */
function refru_customize_js() {

    wp_enqueue_script( 'refru_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-controls' ), '20151024', true );

}
add_action( 'customize_controls_enqueue_scripts', 'refru_customize_js' );

/*
Sanitize Callbacks
 */

/**
 * Sanitize for post's categories
 */
function refru_sanitize_categories( $value ) {
    if ( ! array_key_exists( $value, refru_categories_ar() ) ) {
        $value = '';
    }

    return $value;
}

/**
 * Sanitize return an non-negative Integer
 */
function refru_sanitize_integer( $value ) {
    return absint( $value );
}

/**
 * Sanitize return pro version text
 */
function refru_pro_version( $input ) {
    return $input;
}

/**
 * Sanitize Text
 */
function refru_sanitize_text( $str ) {
    return sanitize_text_field( $str );
}

/**
 * Sanitize Boolean
 */
function refru_sanitize_bool( $string ) {
    return (bool)$string;
}

/**
 * Sanitize Text with html
 */
function refru_sanitize_text_html( $str ) {
    $args = array(
        'a'      => array(
            'href'  => array(),
            'title' => array(),
        ),
        'br'     => array(),
        'em'     => array(),
        'strong' => array(),
        'span'   => array(),
    );
    return wp_kses( $str, $args );
}

/**
 * Sanitize array for multicheck
 * http://stackoverflow.com/a/22007205
 */
function refru_sanitize_multicheck( $values ) {

    $multi_values = ( ! is_array( $values ) ) ? explode( ',', $values ) : $values;
    return ( ! empty( $multi_values ) ) ? array_map( 'sanitize_title', $multi_values ) : array();
}

/**
 * Sanitize GPS Latitude and Longitud
 * http://stackoverflow.com/a/22007205
 */
function refru_sanitize_lat_long( $coords ) {
    if ( preg_match( '/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $coords ) ) {
        return $coords;
    } else {
        return 'error';
    }
}

/**
 * Create the "PRO version" buttons
 */
if ( ! function_exists( 'refru_pro_btns' ) ) {
    function refru_pro_btns( $args ) {

        $wp_customize = $args['wp_customize'];
        $title = $args['title'];
        $label = $args['label'];
        if ( isset( $args['priority'] ) || array_key_exists( 'priority', $args ) ) {
            $priority = $args['priority'];
        } else {
            $priority = 120;
        }
        if ( isset( $args['panel'] ) || array_key_exists( 'panel', $args ) ) {
            $panel = $args['panel'];
        } else {
            $panel = '';
        }

        $section_id = sanitize_title( $title );

        $wp_customize->add_section( $section_id, array(
            'title'    => $title,
            'priority' => $priority,
            'panel'    => $panel,
        ) );
        $wp_customize->add_setting( $section_id, array(
            'sanitize_callback' => 'refru_pro_version',
        ) );
        $wp_customize->add_control( new refru_Pro_Version( $wp_customize, $section_id, array(
            'section' => $section_id,
            'label'   => $label,
        )
        ) );
    }
} //end if function_exists

/**
 * Display Text Control
 * Custom Control to display text
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
    class refru_Display_Text_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {

            $wp_kses_args = array(
                'a'      => array(
                    'href'         => array(),
                    'title'        => array(),
                    'data-section' => array(),
                    'class'        => array(),
                    'style'        => array(),
                ),
                'button' => array(
                    'href'         => array(),
                    'title'        => array(),
                    'data-section' => array(),
                    'class'        => array(),
                    'style'        => array(),
                ),
                'br'     => array(),
                'em'     => array(),
                'strong' => array(),
                'span'   => array(),
            );

            echo '<p>' . wp_kses( $this->label, $wp_kses_args ) . '</p>';

        }
    }
}