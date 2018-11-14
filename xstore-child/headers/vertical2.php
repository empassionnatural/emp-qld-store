<?php 
    $ht = etheme_get_header_type();
    $color = etheme_get_header_color();
?>

<div class="header-wrapper header-<?php echo esc_attr( $ht ); ?> header-color-<?php echo esc_attr( $color ); ?>">
    <header class="header main-header header-bg-block">
        <div class="container-wrapper">
            <div class="menu-wrapper"> 
			    <p class="hamburger-icon">
			        <span></span>
			    </p>
			    <?php etheme_get_main_menu(); ?>
			</div>
        </div>
    </header>
</div>
<div class="header-wrapper header-bg-block header-center3 vertical-mod header-color-<?php echo esc_attr( $color ); ?>">
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
            <?php if ( is_active_sidebar( 'top-bar-right' ) ): ?>
                <div class="top-links">
                    <?php dynamic_sidebar( 'top-bar-right') ?>
                </div>
            <?php endif;?>
            <?php etheme_shop_navbar( 'header' ); ?>
        </div>
        <div class="navbar-toggle">
            <span class="sr-only"><?php esc_html_e( 'Menu', 'xstore' ); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>
    </div>
    </div>
</header>
</div>