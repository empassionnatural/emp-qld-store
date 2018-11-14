<?php

//enqueue parent theme
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array( 'bootstrap' ) );


	if ( is_rtl() ) {
		wp_enqueue_style( 'rtl-style', get_template_directory_uri() . '/rtl.css' );
	}

	$timestamp = strtotime( "now" );
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'parent-style', 'bootstrap' ), '0.1.' . $timestamp
	);

	//wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array(), '', true );

}

//enqueue custom scripts
add_action( 'wp_enqueue_scripts', 'empdev_custom_scripts_frontend', 99 );

function empdev_custom_scripts_frontend(){
	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery'), '1.2.1', false );
	wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/css/custom-style.css', array(), '1.1.3' );
}

add_action( 'wp_enqueue_scripts', 'plugin_scripts', 99 );
function plugin_scripts() {

	wp_enqueue_style( 'bootstrap-select', get_stylesheet_directory_uri() . '/plugins/bootstrap-select/css/bootstrap-select.css' );
	wp_enqueue_script( 'bootstrap-core', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', false, false );
	wp_enqueue_script( 'bootstrap-select', get_stylesheet_directory_uri() . '/plugins/bootstrap-select/js/bootstrap-select.js', array( 'jquery' ), false, false );

}


add_action( 'pmpro_after_checkout', 'sync_woo_billing_func' );

if ( ! function_exists( 'sync_woo_billing_func' ) ) {
	function sync_woo_billing_func() {
		global $current_user;
		$user_id = get_current_user_id();

		update_user_meta( $user_id, 'billing_first_name', $_REQUEST['bfirstname'] );
		update_user_meta( $user_id, 'billing_last_name', $_REQUEST['blastname'] );
		update_user_meta( $user_id, 'billing_address_1', $_REQUEST['baddress1'] );
		update_user_meta( $user_id, 'billing_address_2', $_REQUEST['baddress2'] );
		update_user_meta( $user_id, 'billing_city', $_REQUEST['bcity'] );
		update_user_meta( $user_id, 'billing_state', $_REQUEST['bstate'] );
		update_user_meta( $user_id, 'billing_postcode', $_REQUEST['bzipcode'] );
		update_user_meta( $user_id, 'billing_country', $_REQUEST['bcountry'] );
		update_user_meta( $user_id, 'billing_email', $_REQUEST['bconfirmemail'] );
		update_user_meta( $user_id, 'billing_phone', $_REQUEST['bphone'] );

		update_user_meta( $user_id, 'shipping_first_name', $_REQUEST['bfirstname'] );
		update_user_meta( $user_id, 'shipping_last_name', $_REQUEST['blastname'] );
		update_user_meta( $user_id, 'shipping_address_1', $_REQUEST['baddress1'] );
		update_user_meta( $user_id, 'shipping_address_2', $_REQUEST['baddress2'] );
		update_user_meta( $user_id, 'shipping_city', $_REQUEST['bcity'] );
		update_user_meta( $user_id, 'shipping_state', $_REQUEST['bstate'] );
		update_user_meta( $user_id, 'shipping_postcode', $_REQUEST['bzipcode'] );
		update_user_meta( $user_id, 'shipping_country', $_REQUEST['bcountry'] );

	}
}

function wc_ninja_remove_password_strength() {
	if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}
}

add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );

add_filter( "pmpro_registration_checks", "check_username" );

function check_username( $pmpro_continue_registration ) {
	$isValid                     = preg_match( '/^[-a-zA-Z0-9 .]+$/', $_REQUEST['username'] );
	$pmpro_error_fields[]        = "";
	$pmpro_continue_registration = true;
	if ( ! $isValid ) {
		pmpro_setMessage( __( "Invalid username. White space and Special character is not allowed.", 'paid-memberships-pro' ), "pmpro_error" );
		$pmpro_error_fields[]        = "username";
		$pmpro_continue_registration = false;
	}

	return $pmpro_continue_registration;
}

//conversio recommendation widget
//if ( function_exists( 'Receiptful' ) && method_exists( Receiptful()->recommendations, 'get_recommendations' ) ) {
//	add_action( 'woocommerce_after_single_product_summary', array(
//		Receiptful()->recommendations,
//		'display_recommendations'
//	), 12 );
//}


//woocommerce custom hooks
require_once( get_stylesheet_directory() . '/inc/class-empdev-woocommerce-hooks.php' );

//wholesale notice filter
if( class_exists( 'WWP_Wholesale_Prices' ) ) {
	require_once( get_stylesheet_directory() . '/woocommerce-wholesale-prices-premium/class-wwpp-wholesale-price-requirement.php' );
}

// **********************************************************************//
// ! Show shop navbar
// **********************************************************************//
function etheme_shop_navbar( $location = 'header', $exclude = array(), $force = false ) {

	$args['wishlist'] = ( ! in_array( 'wishlist', $exclude ) && etheme_woocommerce_installed() && etheme_get_option( 'top_wishlist_widget' ) == $location ) ? true : false ;
	$args['search'] = ( ! in_array( 'search', $exclude ) && etheme_get_option( 'search_form' ) == $location ) ? true : false;
	$args['cart'] = ( ! in_array( 'cart', $exclude ) && etheme_woocommerce_installed() && ! etheme_get_option( 'just_catalog' ) && etheme_get_option( 'cart_widget' ) == $location ) ? true : false ;

	if ( ! $args['wishlist'] && ! $args['search'] && ! $args['cart'] && ! $force ) return;

	//do_action( 'etheme_before_shop_navbar' );

	echo '<div class="navbar-header show-in-' . $location . '">';
	//if( $args['search'] ) etheme_search_form();
	if( $args['wishlist'] ) etheme_wishlist_widget();
	if( $args['cart'] ) etheme_top_cart();
	echo '</div>';

	//do_action( 'etheme_after_shop_navbar' );

}

//EMP Dev Woocommerce
require_once( get_stylesheet_directory() . '/emp-dev-wc/emp-dev-theme-functions.php' );
require_once( get_stylesheet_directory() . '/emp-dev-wc/class-emp-dev-wc-meta-option.php' );
