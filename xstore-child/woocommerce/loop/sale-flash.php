<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$sale_text = trim( get_post_meta( $product->get_id(), '_empdev_custom_sale_text', true ) );
$pre_sale_text = trim( get_post_meta( $product->get_id(), '_empdev_custom_pre_sale_text', true ) );

$sale_text = ($sale_text) ? $sale_text : esc_html__( 'Sale', 'woocommerce' );
$pre_sale_text = ($pre_sale_text) ? $pre_sale_text : esc_html__( '', 'woocommerce' );

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span>'.$pre_sale_text.'</span>' . $sale_text . '</span>', $post, $product ); ?>

<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
