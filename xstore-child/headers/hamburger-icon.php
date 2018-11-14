<?php 
    $ht = etheme_get_header_type();
    $color = etheme_get_header_color();

?>

<div class="fullscreen-menu">
    <p class="hamburger-icon open">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </p>
    <div class="container fullscreen-menu-container">
        <div class="fullscreen-menu-collapse navbar-collapse">
            <?php etheme_get_main_menu(); ?>
        </div><!-- /.fullscreen-menu-collapse -->
    </div> 
</div>

<div class="header-wrapper header-<?php echo esc_attr( $ht ); ?> header-color-<?php echo esc_attr( $color ); ?>">
    <header class="header main-header header-bg-block">
        <div class="container">
            <div class="container-wrapper">
                <div class="header-logo"><?php etheme_logo(); ?></div>


                <div class="navbar-header">
                    <div class="header-widget-area">
                        <div class="languages-area">
                            <?php if( ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'languages-sidebar' ) ) ): ?>
                            <?php endif; ?>
                        </div>

                        <div class="top-links">
                            <?php if( ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'top-bar-right' ) ) ): ?>
                            <?php endif; ?> 
                        </div>
                    </div>
                    <?php etheme_top_links(); ?>
                    <?php if( etheme_get_option( 'search_form' ) == 'header'): ?>
                        <?php etheme_search_form(); ?>
                    <?php endif; ?>

                    <?php if( etheme_woocommerce_installed() && etheme_get_option( 'top_wishlist_widget' ) == 'header' ) etheme_wishlist_widget(); ?>

                    <?php if( etheme_woocommerce_installed() && current_theme_supports( 'woocommerce' ) && ! etheme_get_option( 'just_catalog' ) && etheme_get_option( 'cart_widget' ) == 'header' ): ?>
                        <?php etheme_top_cart(); ?>
                    <?php endif ;?>

                    
                    <div class="hamburger-icon">
                      <span></span>
                      <span></span>
                      <span></span>
                      <span></span>
                    </div>
            </div>
            <div class="navbar-toggle"> <span class="sr-only">Menu</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></div>
        </div>
    </header>
</div>