<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class EMPDEV_WWPP_Wholesale_Price_Requirement {

	private $price_threshold;

	private $price_original_total;

	private $price_wholesale_total;

	private $price_non_wholesale_total;

	private $price_compose_original_total;

	private $price_compose_wholesale_total;

	public static $on_wholesale;

	public function __construct() {

		add_filter( 'wwp_apply_wholesale_price_cart_level' , array( $this, 'empdev_filter_if_apply_wholesale_price_cart_level'), 99 , 5 );
	}

	public function empdev_filter_if_apply_wholesale_price_cart_level( $apply_wholesale_price , $cart_total , $cart_items , $cart_object , $user_wholesale_role ) {
		$user_id                                = get_current_user_id();
		$minimum_cart_items                     = trim( get_option( 'wwpp_settings_minimum_order_quantity' ) );
		$minimum_cart_price                     = trim( get_option( 'wwpp_settings_minimum_order_price' ) );
		$minimum_requirements_conditional_logic = get_option( 'wwpp_settings_minimum_requirements_logic' );
		$notices                                = array();

		$WPP                             = new WWP_Wholesale_Prices();
		self::$on_wholesale              = false;
		$this->price_original_total      = 0;
		$this->price_wholesale_total     = 0;
		$this->price_non_wholesale_total = 0.00;

		//check if product is not on wholesale then exclude it to the cart_total
		foreach ( $cart_object->cart_contents as $cart_item_key => $cart_item ) {
			$product_id      = WWP_Helper_Functions::wwp_get_product_id( $cart_item['data'] );
			$wholesale_price = $WPP::get_product_wholesale_price_on_cart( $product_id, $user_wholesale_role, $cart_item, $cart_object );

			if ( empty( $wholesale_price ) ) {
				$original_price = get_post_meta( $product_id, '_price', true );
				$original_price = $original_price * $cart_item['quantity'];
				$this->price_non_wholesale_total += $original_price;
				//$cart_total     -= $original_price;
				//$this->price_wholesale_total -= $original_price;
			} else {
				$wp_price                    = $cart_item['data']->get_price();
				$wp_price                    = $wp_price * $cart_item['quantity'];
				$this->price_wholesale_total += $wp_price;

				$wpp_original_price         = get_post_meta( $product_id, '_price', true );
				$wpp_original_price         = $wpp_original_price * $cart_item['quantity'];
				$this->price_original_total += $wpp_original_price;
			}

		}

		//sum up original and wholesale total amount
		$this->price_compose_wholesale_total = $this->price_wholesale_total + $this->price_non_wholesale_total;
		$this->price_compose_original_total  = $this->price_original_total + $this->price_non_wholesale_total;

		// Check if there is an option that overrides wholesale price order requirement per role
		$override_per_wholesale_role = get_option( 'wwpp_settings_override_order_requirement_per_role' , false );

		if ( $override_per_wholesale_role === 'yes' ) {

			$per_wholesale_role_order_requirement = get_option( WWPP_OPTION_WHOLESALE_ROLE_ORDER_REQUIREMENT_MAPPING , array() );
			if ( !is_array( $per_wholesale_role_order_requirement ) )
				$per_wholesale_role_order_requirement = array();

			if ( array_key_exists( $user_wholesale_role[ 0 ] , $per_wholesale_role_order_requirement ) ) {

				// Use minimum order quantity set for this current wholesale role
				$minimum_cart_items                     = $per_wholesale_role_order_requirement[ $user_wholesale_role[ 0 ] ][ 'minimum_order_quantity' ];
				$minimum_cart_price                     = $per_wholesale_role_order_requirement[ $user_wholesale_role[ 0 ] ][ 'minimum_order_subtotal' ];
				$minimum_requirements_conditional_logic = $per_wholesale_role_order_requirement[ $user_wholesale_role[ 0 ] ][ 'minimum_order_logic' ];

			}

		}

		$user_min_order_qty_applied   = false;
		$user_min_order_price_applied = false;

		// Check if min order qty is overridden per wholesale user
		if ( get_user_meta( $user_id , 'wwpp_override_min_order_qty' , true ) === 'yes' ) {

			$user_min_order_qty = get_user_meta( $user_id , 'wwpp_min_order_qty' , true );

			if ( is_numeric( $user_min_order_qty ) || empty( $user_min_order_qty ) ) {

				$minimum_cart_items         = $user_min_order_qty;
				$user_min_order_qty_applied = true;

			}

		}

		// Check if min order price is overridden per wholesale user
		if ( get_user_meta( $user_id , 'wwpp_override_min_order_price' , true ) === 'yes' ) {

			$user_min_order_price = get_user_meta( $user_id , 'wwpp_min_order_price' , true );

			if ( is_numeric( $user_min_order_price ) || empty( $user_min_order_price ) ) {

				$minimum_cart_price           = $user_min_order_price;
				$user_min_order_price_applied = true;

			}

		}

		// Check if min order logic is overridden per wholesale user
		if ( $user_min_order_qty_applied && $user_min_order_price_applied ) {

			$user_min_order_logic = get_user_meta( $user_id , 'wwpp_min_order_logic' , true );

			if ( in_array( $user_min_order_logic , array( 'and' , 'or' ) ) )
				$minimum_requirements_conditional_logic = $user_min_order_logic;

		}

		if ( is_numeric( $minimum_cart_items ) && ( !is_numeric( $minimum_cart_price ) || strcasecmp( $minimum_cart_price , '' ) == 0 || ( ( float ) $minimum_cart_price <= 0) ) ) {

			$minimum_cart_items = (int) $minimum_cart_items;
			if ( $cart_items < $minimum_cart_items )
				$notices[] = array( 'type' => 'notice' , 'message' => sprintf( __( '<span class="wwpp-notice"></span>You have not met the minimum order quantity of <b>(%1$s)</b> to activate adjusted pricing. Retail  prices will be shown below until the minimum order threshold is met.' , 'woocommerce-wholesale-prices-premium' ) , $minimum_cart_items ) );

		} elseif ( is_numeric( $minimum_cart_price ) && ( !is_numeric( $minimum_cart_items ) || strcasecmp( $minimum_cart_items , '' ) == 0 || ( (int) $minimum_cart_items <= 0) ) ){

			$minimum_cart_price = (float) $minimum_cart_price;
			if ( $this->price_wholesale_total < $minimum_cart_price ) {

				$this->price_threshold = $minimum_cart_price - $this->price_wholesale_total;

				$notices[] = array(
					'type'    => 'notice',
					'message' => sprintf( __( '<span class="wwpp-notice"></span>You need <b>%1$s</b> (wholesale items) on your cart to activate adjusted pricing for wholesale. Retail prices will be shown below until the minimum order threshold is met.', 'woocommerce-wholesale-prices-premium' ), WWP_Helper_Functions::wwp_formatted_price( $this->price_threshold ) )
				);
			}

		} elseif ( is_numeric($minimum_cart_price) && is_numeric($minimum_cart_items) ) {

			if ( strcasecmp( $minimum_requirements_conditional_logic , 'and' ) == 0) {

				if ( $cart_items < $minimum_cart_items || $cart_total < $minimum_cart_price )
					$notices[] = array( 'type' => 'notice' , 'message' => sprintf( __( '<span class="wwpp-notice"></span>You have not met the minimum order quantity of <b>(%1$s)</b> and minimum order subtotal of <b>(%2$s)</b> to activate adjusted pricing. Retail prices will be shown below until the minimum order threshold is met. The cart subtotal calculated with wholesale prices is <b>%3$s</b>' , 'woocommerce-wholesale-prices-premium' ) , $minimum_cart_items , WWP_Helper_Functions::wwp_formatted_price( $minimum_cart_price ) , WWP_Helper_Functions::wwp_formatted_price( $cart_total ) ) );

			} else {

				if ( $cart_items < $minimum_cart_items && $cart_total < $minimum_cart_price )
					$notices[] = array( 'type' => 'notice' , 'message' => sprintf( __( '<span class="wwpp-notice"></span>You have not met the minimum order quantity of <b>(%1$s)</b> or minimum order subtotal of <b>(%2$s)</b> to activate adjusted pricing. Retail prices will be shown below until the minimum order threshold is met. The cart subtotal calculated with wholesale prices is <b>%3$s</b>' , 'woocommerce-wholesale-prices-premium' ) , $minimum_cart_items , WWP_Helper_Functions::wwp_formatted_price( $minimum_cart_price ) , WWP_Helper_Functions::wwp_formatted_price( $cart_total ) ) );

			}

		}

		//display notice if wholesale is activated
		if ( empty( $notices ) ) {
			add_action( 'woocommerce_before_cart', array( $this, 'empdev_wholesale_sucess_add_checkout_notice' ), 20 );
			add_action( 'woocommerce_before_checkout_form', array( $this, 'empdev_wholesale_sucess_add_checkout_notice' ), 20 );

			self::$on_wholesale = true;
		}

		//add cart subtotal row on cart page
		add_action( 'woocommerce_wholesale_sub_total_row', array( $this, 'empdev_wholesale_subtotal_cart_row' ), 20 , 1);


		$notices = apply_filters( 'wwpp_filter_wholesale_price_requirement_failure_notice' , $notices , $minimum_cart_items , $minimum_cart_price , $cart_items , $cart_total , $cart_object , $user_wholesale_role );

		return !empty( $notices ) ? $notices : $apply_wholesale_price;
	}

	public function empdev_wholesale_sucess_add_checkout_notice() {

		$discounted_amount = $this->price_original_total - $this->price_wholesale_total;

		wc_print_notice( sprintf( __( '<span class="wwpp-notice"></span>Great, you\'re on wholesale pricing now! All items for wholesale has been adjusted.', 'woocommerce' ), WWP_Helper_Functions::wwp_formatted_price( $discounted_amount ) ), 'notice' );

	}

	public function empdev_wholesale_subtotal_cart(){

		echo sprintf( __( '<span class="wholesale-amount">%1$s</span>', 'woocommerce' ), WWP_Helper_Functions::wwp_formatted_price( $this->price_wholesale_total ) );

	}

	public function empdev_wholesale_subtotal_cart_row( $wholesale = false ) {
		$wholesale_class = ( $wholesale == false ) ? 'off-wholesale' : 'on-wholesale';

		echo sprintf( __( '<tr class="cart-subtotal-summary"><th>Cart Items Summary</th><td>Wholesale: <span class="wholesale-summary">%1$s</span></td></tr>', 'woocommerce' ), WWP_Helper_Functions::wwp_formatted_price( $this->price_wholesale_total ) );

		echo sprintf( __( '<tr class="cart-subtotal-summary"><th></th><td><span tooltip="test">Non-wholesale:</span> <span class="wholesale-summary">%1$s</span></td></tr>', 'woocommerce' ), WWP_Helper_Functions::wwp_formatted_price( $this->price_non_wholesale_total ) );

		echo sprintf( __( '<tr class="cart-subtotal-wholesale %3$s"><th>Subtotal</th><td>(Wholesale Subtotal: <span class="wholesale-amount">%1$s</span>)<span class="orginal-amount">%2$s</span></td></tr>', 'woocommerce' ), WWP_Helper_Functions::wwp_formatted_price( $this->price_compose_wholesale_total ), WWP_Helper_Functions::wwp_formatted_price( $this->price_compose_original_total ), $wholesale_class );

	}
}

new EMPDEV_WWPP_Wholesale_Price_Requirement();