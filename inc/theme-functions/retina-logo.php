<?php
/**
 * Plugin Name:         Retina Logo
 * Plugin URI:          http://164a.com
 * Description:         Extends WordPress' inbuilt custom logo feature to add support for uploading retina logos.
 * Version:             0.1.0
 * Author:              Studio 164a
 * Author URI:          https://164a.com
 *
 * @package             Retina Logo
 * @author              Eric Daams
 * @copyright           Copyright (c) 2015, Studio 164a
 * @license             http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Filter the attributes of the custom logo image, including
 * srcset & sizes attributes for the retina version, if
 * available.
 *
 * @param   array $attr
 * @param   WP_Post $attachment
 * @param   string|array $size
 * @return  array $attr
 * @since   0.1.0
 */
function refru_custom_logo_image_attributes( $attr, $attachment, $size ) {
    if ( ! isset( $attr[ 'class' ] ) || 'custom-logo' != $attr[ 'class' ] ) {
        return $attr;
    }

    $logo_meta = wp_get_attachment_metadata( $attachment->ID );

    if ( ! isset( $logo_meta[ 'sizes' ][ 'logo-standard' ] ) ) {
        return $attr;
    }

    $standard_size = $logo_meta[ 'sizes' ][ 'logo-standard' ];

    $dir = trailingslashit( _wp_get_attachment_relative_path( $attr[ 'src' ] ) );

    $upload_dir = wp_get_upload_dir();

    if ( 0 !== strpos( $dir, $upload_dir[ 'baseurl' ] ) ) {
        $dir = trailingslashit( $upload_dir[ 'baseurl' ] ) . $dir;
    }

    $attr[ 'src' ] = $dir . $standard_size[ 'file' ];
    $attr[ 'sizes' ] = sprintf( '(max-width: %1$dpx) 100vw, %1$dpx', $standard_size[ 'width' ] );

    return $attr;
}

add_filter( 'wp_get_attachment_image_attributes', 'refru_custom_logo_image_attributes', 10, 3 );

/**
 * Filter the custom logo output.
 *
 * @param   string $html
 * @return  array
 * @since   0.1.0
 */
function refru_custom_logo_html( $html ) {
    $logo_meta = wp_get_attachment_metadata( get_theme_mod( 'custom_logo' ) );

    if ( ! isset( $logo_meta[ 'sizes' ][ 'logo-standard' ] ) ) {
        return $html;
    }

    $html = preg_replace( '/width="\d+"/i', 'width="' . $logo_meta[ 'sizes' ][ 'logo-standard' ][ 'width' ] . '"', $html );
    $html = preg_replace( '/height="\d+"/i', 'height="' . $logo_meta[ 'sizes' ][ 'logo-standard' ][ 'height' ] . '"', $html );

    return $html;
}

add_filter( 'get_custom_logo', 'refru_custom_logo_html' );

/**
 * Customize the Custom Logo control to include a prompt about whether
 * the logo is a retina version.
 *
 * @param   WP_Customize_Manager $wp_customize
 * @return  void
 * @since   0.1.0
 */
function refru_custom_logo_customizer_control( WP_Customize_Manager $wp_customize ) {
    $control = $wp_customize->get_control( 'custom_logo' );

    if ( ! is_a( $control, 'WP_Customize_Control' ) ) {
        return;
    }

    $wp_customize->add_setting( 'custom_logo_is_retina', array(
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint'
    ) );

    $wp_customize->add_control( 'custom_logo_is_retina', array(
        'settings' => 'custom_logo_is_retina',
        'label' => __( 'Is this image retina-ready?', 'refru' ),
        'section' => $control->section,
        'priority' => $control->priority + 0.1,
        'type' => 'checkbox'
    ) );
}

add_action( 'customize_register', 'refru_custom_logo_customizer_control', 20 );

/**
 * Dynamically create and save the non-retina size of a logo.
 *
 * This will first check whether the logo has changed. It will also
 * check if the logo
 *
 * @param   WP_Customize_Setting $setting
 * @return  void
 * @since   0.1.0
 */
function refru_save_logo_sizes( WP_Customize_Setting $setting ) {
    $logo = $setting->manager->get_setting( 'custom_logo' )->post_value( '-1' );
    $is_retina = $setting->manager->get_setting( 'custom_logo_is_retina' )->post_value( '-1' );

    if ( '-1' == $logo ) {
        $logo = get_theme_mod( 'custom_logo', false );
    }

    if ( '-1' == $is_retina ) {
        $is_retina = get_theme_mod( 'custom_logo_is_retina', 0 );
    }

    // If this is not a retina logo or no logo was set, go no further.
    if ( ! $is_retina || empty( $logo ) ) {
        return;
    }

    // A logo was set and it is a retina version.
    $logo_meta = wp_get_attachment_metadata( $logo );

    if ( ! isset( $logo_meta[ 'sizes' ] ) ) {
        $logo_meta[ 'sizes' ] = array();
    }

    // @todo check if a logo-standard size already exists for this logo
    if ( isset( $logo_meta[ 'sizes' ][ 'logo-standard' ] ) ) {
        return;
    }

    // Get the logo file
    $file = get_attached_file( $logo );

    // Calculate the dimensions of the non-retina version.
    $width = floor( $logo_meta['width'] / 2 );
    $height = floor( $logo_meta['height'] / 2 );

    // Create the standard size.
    $resized_file = image_make_intermediate_size( $file, $width, $height );

    if ( ! $resized_file ) {
        return;
    }

    // Add new size to logo meta and save.
    $logo_meta[ 'sizes' ][ 'logo-standard' ] = $resized_file;

    wp_update_attachment_metadata( $logo, $logo_meta );
}

add_action( 'customize_save_custom_logo', 'refru_save_logo_sizes' );
add_action( 'customize_save_custom_logo_is_retina', 'refru_save_logo_sizes' );
