<?php 
    $ht = etheme_get_header_type();
    $color = etheme_get_header_color();

?>

<div class="header-wrapper header-<?php echo esc_attr( $ht ); ?> header-color-<?php echo esc_attr( $color ); ?>">
    <header class="header main-header header-bg-block">
        <div class="container-wrapper">

            <div class="header-logo"><?php etheme_logo(); ?></div>

            <div class="menu-wrapper"> 
			    <p class="hamburger-icon">
			        <span></span>
			    </p>
			    <?php etheme_get_main_menu(); ?>
			</div>

			 <div class="navbar-toggle">
                    <span class="sr-only"><?php esc_html_e( 'Menu', 'xstore' ); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>
            <?php etheme_shop_navbar( 'header', array( 'search' ) ); ?>
        </div>
    </header>
</div>