<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
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
 * @version     3.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user = wp_get_current_user();

$count_method = 0;
?>
<tr class="shipping">
	<th><?php echo wp_kses_post( $package_name ); ?></th>
	<td data-title="<?php echo esc_attr( $package_name ); ?>">
		<?php if ( 1 < count( $available_methods ) ) : ?>
			<ul id="shipping_method">
                <?php
                //array_shift($available_methods);
                if( in_array( 'wholesale_customer', $user->roles ) ) :
                $available_methods = array_reverse($available_methods); ?>
				<?php foreach ( $available_methods as $method ) : ?>
					<?php
					if( sanitize_title( $method->id ) == 'starshipit_exp' || wc_cart_totals_shipping_method_label( $method ) == 'Pick Up from Empassion' ) : ?>

					    <li>
						<?php

							printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />
								<label for="shipping_method_%1$d_%2$s">%5$s</label>',
								$index, sanitize_title( $method->id ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ), wc_cart_totals_shipping_method_label( $method ), $starshipit ) ;

							do_action( 'woocommerce_after_shipping_rate', $method, $index );

						?>
					    </li>

                    <?php endif; ?>

				<?php endforeach;
				else :
					//apply free shipping method if free shipping class on product data was set
					$flat_rate_cost = (int) $available_methods['flat_rate:8']->cost;
                    $free_shipping = $available_methods['free_shipping:1'];

					if ( $flat_rate_cost <= 0 ) {
						unset( $available_methods['flat_rate:8'] );

					} else {
						unset( $available_methods['free_shipping:1'] );
					}

					foreach ( WC()->cart->get_coupons() as $code => $coupon ) {

						if( $coupon->get_free_shipping() && $flat_rate_cost > 0 ) {
							$available_methods[] = $free_shipping;
							unset( $available_methods['free_shipping:7'] );
							unset( $available_methods['flat_rate:8'] );

						}

					}

					foreach ( $available_methods as $method ) : ?>
                    <li>
	                    <?php
	                    if ( $flat_rate_cost <= 0 ) {
		                    $chosen_method = ( $chosen_method == 'flat_rate:8' ) ? 'free_shipping:1' : $chosen_method;
	                    }

						printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />
								<label for="shipping_method_%1$d_%2$s">%5$s</label>',
							$index, sanitize_title( $method->id ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ), wc_cart_totals_shipping_method_label( $method ) );

						do_action( 'woocommerce_after_shipping_rate', $method, $index );
						?>
                    </li>
				    <?php endforeach;

				endif; ?>
			</ul>
		<?php elseif ( 1 === count( $available_methods ) ) :  ?>
			<?php

                if( ! in_array( 'wholesale_customer', $user->roles ) ) :
                    $method = current( $available_methods );
                    printf( '%3$s <input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d" value="%2$s" class="shipping_method" />', $index, esc_attr( $method->id ), wc_cart_totals_shipping_method_label( $method ) );
                    do_action( 'woocommerce_after_shipping_rate', $method, $index );
				endif;
			?>
		<?php elseif ( WC()->customer->has_calculated_shipping() ) : ?>
			<?php echo apply_filters( is_cart() ? 'woocommerce_cart_no_shipping_available_html' : 'woocommerce_no_shipping_available_html', wpautop( __( 'There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) ); ?>
		<?php elseif ( ! is_cart() ) : ?>
			<?php echo wpautop( __( 'Enter your full address to see shipping costs.', 'woocommerce' ) ); ?>
		<?php endif; ?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( ! empty( $show_shipping_calculator ) ) : ?>
			<?php woocommerce_shipping_calculator(); ?>
		<?php endif; ?>
	</td>
</tr>
