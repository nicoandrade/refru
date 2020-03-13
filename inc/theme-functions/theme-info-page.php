<?php
    add_action( 'admin_menu', 'refru_getting_started_menu' );
    function refru_getting_started_menu() {
        add_theme_page( esc_attr__( 'Theme Info', 'refru' ), esc_attr__( 'Theme Info', 'refru' ), 'manage_options', 'refru_theme-info', 'refru_getting_started_page' );
    }

    /**
     * Theme Info Page
     */
    function refru_getting_started_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'refru' ) );
        }
        echo '<div class="getting-started">';
    ?>
<div class="getting-started-header">
    <div class="header-wrap">
        <div class="theme-image">
            <span class="top-browser"><i></i><i></i><i></i></span>
            <img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" alt="">
        </div>
        <div class="theme-content">
            <div class="theme-content-wrap">
                <h4><?php esc_html_e( 'Getting Started', 'refru' ); ?></h4>
                <h2 class="theme-name"><?php echo esc_html( REFRU_THEME_NAME ); ?> <span
                        class="ver"><?php esc_html_e( 'v', 'refru' ) . esc_html( REFRU_THEME_VERSION ); ?></span></h2>
                <p><?php echo sprintf( esc_html__( 'Thanks for using %s, we appriciate that you create with our products.', 'refru' ), esc_html( REFRU_THEME_NAME ) ); ?>
                </p>
                <p><?php esc_html_e( 'Check the content below to get started with our theme.', 'refru' ); ?></p>
            </div>

            <ul class="getting-started-menu">
                <?php
                    if ( isset( $_GET['tab'] ) ) {
                            $tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
                        } else {
                            $tab = 'docs';
                        }
                    ?>
                <li><a href="?page=refru_theme-info&amp;tab=docs"
                        class="<?php echo ( $tab == 'docs' ) ? ' active' : ''; ?>"><i
                            class="far fa-file-alt"></i><?php esc_html_e( 'Documentation', 'refru' ); ?></a></li>
                <?php if ( class_exists( 'OCDI_Plugin' ) ) { ?>
                <li><a href="<?php echo get_admin_url( null, 'themes.php?page=pt-one-click-demo-import' ); ?>"><i
                            class="fa fa-download"></i><?php esc_html_e( 'Import Demo', 'refru' ); ?></a></li>
                <?php } ?>
            </ul>

        </div><!-- .theme-content -->
    </div>
    <a href="https://www.quemalabs.com/" class="ql_logo" target="_blank"><img
            src="<?php echo esc_url( get_template_directory_uri() ) . '/images/quemalabs.png'; ?>"
            alt="Quema Labs" /></a>
</div><!-- .getting-started-header -->

<div class="getting-started-content">

    <?php
        global $pagenow;
            global $updater;

            if ( $pagenow == 'themes.php' && isset( $_GET['page'] ) && 'refru_theme-info' == $_GET['page'] ) {
                if ( isset( $_GET['tab'] ) ) {
                    $tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
                } else {
                    $tab = 'docs';
                }

                switch ( $tab ) {
                case 'docs':
                ?>

    <div class="theme-docuementation">
        <div class="help-msg-wrap">
            <div class="help-msg">
                <?php echo sprintf( esc_html__( 'You can find this documentation and more at our %1$sHelp Center%2$s.', 'refru' ), '<a href="https://quemalabs.ticksy.com/articles/100015740" target="_blank">', '</a>' ); ?>
            </div>
        </div>
    </div><!-- .theme-docuementation -->
    <?php
        break;

            } //switch ?>


    <?php } //if theme.php ?>

</div><!-- .getting-started-content -->
<?php
    echo '</div><!-- .getting-started -->';
}
