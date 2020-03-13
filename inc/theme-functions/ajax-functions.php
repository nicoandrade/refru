<?php
/*
 * Dynamic Editor Styles
 */
function refru_dynamic_editor_styles() {

    // Check if it is GET method and has nonce and action
    if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'GET' != $_SERVER['REQUEST_METHOD'] || empty( $_GET['action'] ) ) {
        wp_send_json_error( 'error' );
        return;
    }

    /*
    No need for a nonce, since this functions doesn't do any modification and it is not involved any authentication or authorization
    Also nonces will not work since the nonce is created as guest user on the Editor Style.
     */

    $refru_typography_font_family = esc_attr( get_theme_mod( 'refru_typography_font_family', 'Lato' ) );
    $refru_typography_font_family_headings = esc_attr( get_theme_mod( 'refru_typography_font_family_headings', 'Lato' ) );
    $refru_typography_font_size = esc_attr( get_theme_mod( 'refru_typography_font_size', 16 ) );
    $refru_text_color = esc_attr( get_theme_mod( 'refru_text_color', '#484848' ) );

    $headings_classes = refru_headings_font_classes();

    $css = <<<CSS

	body{
		font-family: {$refru_typography_font_family};
		color: {$refru_text_color};
		font-size: {$refru_typography_font_size}px;
	}

	{$headings_classes},
	.editor-post-title__block .editor-post-title__input {
		font-family: {$refru_typography_font_family_headings};
	}

CSS;

    header( 'Content-type: text/css' );
    echo $css;
    die(); // end ajax process.

} // refru_dynamic_editor_styles()

add_action( 'wp_ajax_nopriv_refru_dynamic_editor_styles', 'refru_dynamic_editor_styles' );
add_action( 'wp_ajax_refru_dynamic_editor_styles', 'refru_dynamic_editor_styles' );