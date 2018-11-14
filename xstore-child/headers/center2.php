<?php
    $ht = etheme_get_header_type();
    $color = etheme_get_header_color();
    $menu_class = 'menu-align-' . etheme_get_option('menu_align');
?>
<div class="header-wrapper header-<?php echo esc_attr( $ht ); ?> header-color-<?php echo esc_attr( $color ); ?>">
    <?php if (etheme_get_option('top_bar')): ?>
        <div class="top-bar topbar-color-<?php echo etheme_get_tb_color(); ?>">
            <div class="container">
                <div class="et_centered-type">
                    <div class="languages-area">
                        <?php if((!function_exists('dynamic_sidebar') || !dynamic_sidebar('languages-sidebar'))): ?>
                        <?php endif; ?>
                    </div>

                    <div class="header-logo"><?php etheme_logo(); ?></div>

                    <div class="top-links">
                        <?php if((!function_exists('dynamic_sidebar') || !dynamic_sidebar('top-bar-right'))): ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <header class="header main-header header-bg-block">
        <div class="container">
            <div class="container-wrapper">
                <div class="header-logo"><?php etheme_logo(); ?></div>
                <div class="menu-wrapper <?php echo esc_attr($menu_class); ?>">
                    <?php if ( has_nav_menu( 'secondary' ) && etheme_get_option( 'secondary_menu' ) ): ?>
                        <div class="secondary-menu-wrapper">
                            <div class="secondary-title">
                                <div class="secondary-menu-toggle">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </div>
                                <?php etheme_option('all_departments_text'); ?>
                            </div>
                            <?php etheme_get_main_menu('secondary'); ?>
                        </div>
                    <?php endif ?>
                    <?php etheme_get_main_menu(); ?>
                    
                    </div>
                <div class="navbar-toggle">
                    <span class="sr-only"><?php esc_html_e('Menu', 'xstore'); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>
                <?php etheme_shop_navbar( 'header' ); ?>
            </div>
        </div>
    </header>
</div>