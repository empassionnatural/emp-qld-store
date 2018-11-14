<?php 
    $ht = etheme_get_header_type();
    $color = etheme_get_header_color();
    $menu_class = 'menu-align-' . etheme_get_option('menu_align');
?>

<div class="header-wrapper header-bg-block header-<?php echo esc_attr( $ht ); ?> header-color-<?php echo esc_attr( $color ); ?>">
    <header class="header main-header">
        <div class="container">
            <div class="container-wrapper">
                <div class="header-left-wrap">
                    <div class="languages-area">
                        <?php if((!function_exists('dynamic_sidebar') || !dynamic_sidebar('languages-sidebar'))): ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="header-logo"><?php etheme_logo(); ?></div>

                <div class="header-right-wrap">
                    <?php etheme_shop_navbar( 'header', array( 'search' ) ); ?>
                    <div class="top-links">
                        <?php etheme_top_links(); ?>
                        <?php if((!function_exists('dynamic_sidebar') || !dynamic_sidebar('top-bar-right'))): ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="navbar-toggle">
                    <span class="sr-only"><?php esc_html_e('Menu', 'xstore'); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>
            </div>
        </div>
    </header>
    <div class="navigation-wrapper">
        <div class="container">
            <div class="menu-inner">
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
                <?php if( etheme_get_option( 'search_form' ) == 'header' ): ?>
                    <?php etheme_search_form( array(
                        'action' => 'default'
                    )); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>