<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require get_template_directory() . '/inc/theme-functions/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'refru_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function refru_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // This is an example of how to include a plugin pre-packaged with a theme
        array(
            'name'               => 'WooCommerce',
            'slug'               => 'woocommerce',
            'version'            => '2.5.1',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => 'Kirki Toolkit',
            'slug'               => 'kirki',
            'version'            => '2.0.7',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'refru',
        'default_path' => '', // Default absolute path to pre-packaged plugins.
         'menu'         => 'tgmpa-install-plugins', // Menu slug.
         'has_notices'  => true, // Show admin notices or not.
         'dismissable'  => true, // If false, a user cannot dismiss the nag message.
         'dismiss_msg'  => '', // If 'dismissable' is false, this message will be output at top of nag.
         'is_automatic' => false, // Automatically activate plugins after installation or not.
         'message'      => '',
    );

    tgmpa( $plugins, $config );

}