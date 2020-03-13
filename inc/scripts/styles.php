<?php

/**
 * CSS Classes
 * Featured Color
 * Color
 *
 */
function refru_featured_color() {
    return ".refru-cart-btn:hover,
	.refru-cart-btn:focus,
	.woocommerce_checkout_btn:hover,
	.widget .amount,
	.welcome-section .welcome-title,
	.question,
	.refru-contact-form .refru-contact-form-text,
	.refru-contact-form input[type='text'],
	.refru-contact-form input[type='email'],
	.refru-contact-form textarea,
	.refru-cart-btn .count,
	.refru-login-btn:hover,
	.refru-login-btn:focus,
	.woocommerce-cart .actions input[type='submit'],
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce a.added_to_cart,
	.post-password-form input[type='submit'],
	.woocommerce a.added_to_cart";
}

/**
 * CSS Classes
 * Featured Color
 * Background Color
 *
 */
function refru_featured_background_color() {
    return ".pagination .current,
	.pagination li.active a,
	.section-title::before,
	.pace .pace-progress,
	.woocommerce_checkout_btn,
	.woocommerce #main .single_add_to_cart_button,
	.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
	.contact-form input[type='submit'],
	.refru-preloader .refru-folding-cube .refru-cube::before,
	.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
	.woocommerce #main .single_add_to_cart_button,
	.no-touchevents .woocommerce-cart .actions input[type='submit']:hover,
	.no-touchevents .woocommerce .widget_price_filter .price_slider_amount .button:hover,
	.woocommerce input.button,
	.no-touchevents .post-password-form input[type='submit']:hover,
	.refru-double-bounce1,
	.refru-double-bounce2,
	.refru-preloader .refru-double-bounce1, .refru-preloader .refru-double-bounce2,
	.woocommerce #main ul.products li.product .product_text .price,
	.woocommerce-page ul.products li.product .product_text .price,
	.woocommerce ul.products li.product .product_text .price,
	.main-navigation ul ul a::before";
}

/**
 * CSS Classes
 * Featured Color
 * Border Color
 *
 */
function refru_featured_border_color() {
    return ".pagination li.active a,
	.pagination li.active a:hover,
	.section-title::after,
	.pace .pace-activity,
	.woocommerce_checkout_btn,
	#woocommerce-product-search-field,
	.refru-contact-form input[type='text']:focus,
	.refru-contact-form input[type='email']:focus,
	.refru-contact-form textarea:focus,
	.woocommerce-cart .actions input[type='submit'],
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.no-touchevents .blog #content .post .entry-footer .metadata ul li a:hover, .no-touchevents .archive #content .post .entry-footer .metadata ul li a:hover, .no-touchevents .search #content .post .entry-footer .metadata ul li a:hover,
	.main-navigation ul ul";
}

/**
 * CSS Classes
 * Headings Font
 * Font Family
 *
 */
function refru_headings_font_classes() {
    return "h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
	.pagination a, .pagination span,
	.post-navigation .nav-next a, .post-navigation .nav-previous a,
	.main-navigation ul";
}

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @see wp_add_inline_style()
 */
function refru_custom_css() {
    /*
    Colors
     */
    $heroColor = esc_html( get_theme_mod( 'refru_featured_color', '#fff200' ) );
    $headings_color = esc_html( get_theme_mod( 'refru_headings_color', '#222222' ) );
    $text_color = esc_html( get_theme_mod( 'refru_text_color', '#777777' ) );
    $link_color = esc_html( get_theme_mod( 'refru_link_color', '#4662ef' ) );
    $content_background_color = esc_html( get_theme_mod( 'refru_content_background_color', '#FFFFFF' ) );
    $footer_background = esc_html( get_theme_mod( 'refru_footer_background', '#FFFFFF' ) );
    $site_gradient = esc_html( get_theme_mod( 'refru_site_gradient', '1' ) );
    $site_background_color = esc_html( get_theme_mod( 'refru_site_background_color', '#e08461' ) );
    $logo_color = esc_html( get_theme_mod( 'refru_logo_color', '#222222' ) );
    $header_bck_color = esc_html( get_theme_mod( 'refru_header_bck_color', '#FFFFFF' ) );
    $header_lines_color = esc_html( get_theme_mod( 'refru_header_lines_color', '#EEEEEE' ) );

    $colors = array(
        'heroColor'                => $heroColor,
        'headings_color'           => $headings_color,
        'text_color'               => $text_color,
        'link_color'               => $link_color,
        'content_background_color' => $content_background_color,
        'footer_background'        => $footer_background,
        'site_gradient'            => $site_gradient,
        'site_background_color'    => $site_background_color,
        'logo_color'               => $logo_color,
        'header_bck_color'         => $header_bck_color,
        'header_lines_color'       => $header_lines_color,

    );

    $custom_css = refru_get_custom_css( $colors );

    wp_add_inline_style( 'refru_style', $custom_css );

    // Load Google Fonts
    $refru_google_font = refru_get_google_font();
    wp_enqueue_style( 'refru_google-font', $refru_google_font, array(), '1.0', 'all' );
    $refru_google_font_headings = refru_get_google_font_headings();
    wp_enqueue_style( 'refru_google-font-headings', $refru_google_font_headings, array(), '1.0', 'all' );

}
add_action( 'wp_enqueue_scripts', 'refru_custom_css' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors colors.
 * @return string CSS.
 */
function refru_get_custom_css( $colors ) {

    //Default colors
    $colors = wp_parse_args( $colors, array(
        'heroColor'                => '#fff50a',
        'headings_color'           => '#222222',
        'text_color'               => '#777777',
        'link_color'               => '#fd6848',
        'content_background_color' => '#FFFFFF',
        'footer_background'        => '#FFFFFF',
        'site_gradient'            => '1',
        'site_background_color'    => '#e08461',
        'logo_color'               => '#222222',
        'header_bck_color'         => '#FFFFFF',
        'header_lines_color'       => '#EEEEEE',

    ) );

    // Site Background Color
    $background_color = get_background_color();

    $heroColor_darker = refru_darken_color( $colors['heroColor'], 1.1 );
    $link_color_darker = refru_darken_color( $colors['link_color'], 1.2 );
    $heroColor_rgb = refru_hex2rgb( $colors['heroColor'] );

    // Custom CSS for the current page only
    $refru_header_bck_color = esc_attr( rwmb_meta( 'refru_header_bck_color' ) );
    $refru_header_logo_color = esc_attr( rwmb_meta( 'refru_header_logo_color' ) );
    $refru_header_text_color = esc_attr( rwmb_meta( 'refru_header_text_color' ) );
    $refru_header_hover_color = esc_attr( rwmb_meta( 'refru_header_hover_color' ) );
    $refru_header_mobile_menu_bck_color = esc_attr( rwmb_meta( 'refru_header_mobile_menu_bck_color' ) );
    // If is Shop page we need to pass the page ID
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        $shop_id = get_option( 'woocommerce_shop_page_id' );
        $refru_header_bck_color = esc_attr( rwmb_meta( 'refru_header_bck_color', '', $shop_id ) );
        $refru_header_logo_color = esc_attr( rwmb_meta( 'refru_header_logo_color', '', $shop_id ) );
        $refru_header_text_color = esc_attr( rwmb_meta( 'refru_header_text_color', '', $shop_id ) );
        $refru_header_hover_color = esc_attr( rwmb_meta( 'refru_header_hover_color', '', $shop_id ) );
        $refru_header_mobile_menu_bck_color = esc_attr( rwmb_meta( 'refru_header_mobile_menu_bck_color', '', $shop_id ) );
    }

    $css = <<<CSS


	.contact-form input[type='submit']{
		color: #{$background_color};
	}

	/* Link Color */
	a:hover{
		color: {$link_color_darker};
	}



	/*============================================
	// Featured Color
	============================================*/

	/* Darker Background Color */
	.no-touchevents .woocommerce #main .single_add_to_cart_button:hover,
	.no-touchevents .refru-contact-form input[type='submit']:hover,
	.no-touchevents .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
	.contact-form input[type="submit"]:hover,
	.no-touchevents .woocommerce #main .single_add_to_cart_button:hover,
	.woocommerce-mini-cart__buttons .button.checkout:focus
	{
		background-color: {$heroColor_darker};
	}

	/* Darker Color */
	.no-touchevents .refru-service.refru-service-style-7 .refru-service-action a:hover{
		color: {$heroColor_darker};
	}

	/* Faded Background Color */
	.refru_team_member .refru_team_hover,
	{
		background-color: rgba( {$heroColor_rgb['red']}, {$heroColor_rgb['green']}, {$heroColor_rgb['blue']}, 0.88 );
	}

	/* Footer Background Color */
	.footer-wrap
	{
		background-color: {$colors['footer_background']};
	}

	/* Logo Color */
	.logo_container .ql_logo
	{
		color: {$colors['logo_color']};
	}

	/* Header Lines Border Color */
	.refru-cart-btn,
	#header,
	.single-product #header,
	.logo_container::before,
	.refru-header-2 #header .logo_container::before,
	.refru-header-2 #header .refru-cart-btn
	{
		border-color: {$colors['header_lines_color']};
	}



	/* Current Page Header Styles */
	body #header,
	body .single-product #header{
		background-color: {$refru_header_bck_color} !important;
	}

	body #header .refru-logo-wrap .site-title .ql_logo{
		color: {$refru_header_logo_color} !important;
	}

	body .main-navigation a,
	body #header,
	body #header .refru-icons-nav-wrap ul li a,
	body #header .nav_social li a{
		color: {$refru_header_text_color};
	}

	.no-touchevents body #header .refru-icons-nav-wrap ul li a:hover,
	.no-touchevents .main-navigation .menu > li > a:hover,
	.main-navigation li:hover > a,
	.no-touchevents #header .refru-icons-nav-wrap ul li a:hover,
	.no-touchevents #header .main-navigation ul.menu > li > a:hover,
	.no-touchevents .main-navigation ul > li > a:hover{
		color: {$refru_header_hover_color};
	}

	@media (max-width: 767px) {
		.main-navigation{
			background-color: {$refru_header_mobile_menu_bck_color};
		}
	}


CSS;

    return $css;
}