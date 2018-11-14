<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="user-scalable=0, width=device-width, initial-scale=1, maximum-scale=2.0"/>
	<?php wp_head(); ?>
	<style>
        /*Fixed bugs woocommerce*/
        .shopping-container .cart-bag .badge-number{
            background-color: #000 !important;
            opacity: 1;
        }
        .shipping-error{
            position: relative;
            top: 10px;
            color: red;
        }
        .shipping-error .woocommerce-error{
            padding: 1em 4em !important;
        }
        .woocommerce-info{
            border-top-color: #428ebf;
            color: #313131;
            background-color: #f8f8f8;
            line-height: 1.6em;
        }
        .woocommerce-info b, .cart-popup .woocommerce-Price-amount{
            color: #333;
        }
        .woocommerce-checkout.wholesale_customer .quantity.buttons_added{
            opacity: 1;
        }
        .quantity{
            opacity: 1;
        }
        #wc-stripe-payment-request-wrapper, #wc-stripe-payment-request-button-separator, .wholesale_customer .cart-subtotal{
            display: none !important;
        }
        .quantity.buttons_added span:hover, table.cart .remove-item:hover,
        input[type=submit]:hover, .btn:hover, .back-top:hover, .button:hover,
        .swiper-entry .swiper-custom-left:hover, .swiper-entry .swiper-custom-right:hover {
            background-color: #dadada;
        }
        .header-search.act-default [role=searchform] .btn:hover{
            background-color: #4a4a4a !important;
        }
        table.cart .product-details a:hover, .cart-widget-products .remove:hover, .cart-widget-products a:hover, .shipping-calculator-button, .tabs .tab-title:hover, .next-post .post-info .post-title, .prev-post .post-info .post-title, .form-submit input[type=submit]{
            color: #000 !important;
        }
        .form-submit input[type=submit]:hover{
            color: white !important;
        }
        .shipping-calculator-button:hover{
            text-decoration: underline;
        }
        .active.et-opened .tab-title.opened{
            border: 1px solid #e6e6e6;
        }
        .posts-nav-btn:hover .button:before{
            color: #cbcbcb;
        }
        .error-tr{
            outline: 1px solid #b63231;
        }
        #place_order.button.alt:disabled, #place_order.button.alt.disabled{
            background-color: #c1c1c1 !important;
            border: 1px solid #ababab;
        }
        #place_order.button.alt:hover{
            background-color: #92c707;
            cursor: pointer;
        }
        .states-info{
            margin-top: 20px;
        }
        .states-info .woocommerce-info:before {
            display: none;
        }
        .states-info .woocommerce-info{
            border-top-color: #c15757;
        }

        .states-info a{
            color: #ff0000 !important;
            font-size: 18px;
        }
        ::-moz-selection { background: #d2c5ff !important; }
        ::selection { background: #d2c5ff !important; }
	</style>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'et_after_body' ); ?>

<?php
$header_type = etheme_get_header_type();
?>

<div class="template-container">
	<?php if ( is_active_sidebar('top-panel') && etheme_get_option('top_panel') && etheme_get_option('top_bar')): ?>
		<div class="top-panel-container">
			<div class="top-panel-inner">
				<div class="container">
					<?php dynamic_sidebar( 'top-panel' ); ?>
					<div class="close-panel"></div>
				</div>
			</div>
		</div>
	<?php endif ?>
	<div class="mobile-menu-wrapper">
		<div class="container">
			<div class="navbar-collapse">
				<?php if(etheme_get_option('search_form')): ?>
					<?php etheme_search_form( array(
						'action' => 'default'
					)); ?>
				<?php endif; ?>
				<?php etheme_get_mobile_menu(); ?>
				<?php etheme_top_links( array( 'short' => true ) ); ?>
				<?php dynamic_sidebar('mobile-sidebar'); ?>
			</div><!-- /.navbar-collapse -->
		</div>
	</div>
	<div class="template-content">
		<div class="page-wrapper" data-fixed-color="<?php etheme_option( 'fixed_header_color' ); ?>">

<?php get_template_part( 'headers/' . $header_type ); ?>