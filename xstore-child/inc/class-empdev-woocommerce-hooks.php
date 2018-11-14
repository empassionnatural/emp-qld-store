<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Created by DynamicAction.
 * User: web@empassion.com.au
 * Date: 4/30/2018
 * Time: 10:53 AM
 */
class EMPDEV_WooCommerce_Hooks {

	public function __construct() {
		// check for empty-cart get param to clear the cart
		add_action( 'woocommerce_init', array( $this, 'empdev_woocommerce_clear_cart_url' ) );

		// hook button at cart page next to update button
		add_action( 'woocommerce_cart_actions', array( $this, 'empdev_add_clear_cart_button' ), 20 );
	}

	function empdev_woocommerce_clear_cart_url() {
		global $woocommerce;
		if ( isset( $_GET['empty-cart'] ) ) {
			$woocommerce->cart->empty_cart();
		}
	}

	function empdev_add_clear_cart_button() {
		$blog_url = get_bloginfo('wpurl');
		echo '<button class="btn gray" onclick="if(confirm(\'Are you sure to remove all items?\'))window.location=\''.$blog_url.'/cart/?empty-cart=true\';else event.stopPropagation();event.preventDefault();">' . __( "Empty Cart", "woocommerce" ) . '</button>';

	}
}

new EMPDEV_WooCommerce_Hooks();