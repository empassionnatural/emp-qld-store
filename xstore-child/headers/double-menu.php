<?php 
    $ht = etheme_get_header_type();
    $color = etheme_get_header_color();
    $menu_class = 'menu-align-' . etheme_get_option('menu_align');
    $custom_html = etheme_get_option( 'header_custom_block' );
?>

<div class="header-wrapper header-<?php echo esc_attr( $ht ); ?> header-color-<?php echo esc_attr( $color ); ?>">
    <?php get_template_part('headers/parts/top-bar'); ?>
    <header class="header main-header header-bg-block">
        <div class="container">
            <div class="container-wrapper">
                <?php if ( ! empty( $custom_html ) ): ?>
                    <div class="header-custom">
                    <div class="custom-content">
                        <?php do_shortcode( etheme_option( 'header_custom_block' ) ) ?>
                        </div>
                    </div>
                <?php endif ?>
                <div class="menu-wrapper <?php echo esc_attr($menu_class); ?>"><?php etheme_get_main_menu(); ?></div>
                <div class="header-logo"><?php etheme_logo(); ?></div>
                <div class="menu-wrapper menu-wrapper-right <?php echo esc_attr($menu_class); ?>"><?php etheme_get_main_menu_right(); ?></div>
                <?php etheme_shop_navbar( 'header' ); ?>
                <div class="navbar-toggle">
                    <span class="sr-only"><?php esc_html_e('Menu', 'xstore'); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>
            </div>
        </div>
    </header>
</div>