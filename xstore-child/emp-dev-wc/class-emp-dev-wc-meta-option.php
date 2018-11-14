<?php

/**
 * Created by PhpStorm.
 * User: web
 * Date: 8/27/2018
 * Time: 11:38 AM
 */

if( class_exists('WooCommerce' ) ) {
	class EMPDEV_WC_Meta_Option {
		public function __construct() {
			add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'emddev_conditional_product_in_cart_dynamic' ), 10, 2 );
			add_action( 'woocommerce_init', array( $this,'empdev_woocommerce_redirect_product_url' ) );
			add_action( 'woocommerce_product_options_advanced', array( $this, 'empdev_woocommerce_product_options_advanced' ) );
			add_action( 'woocommerce_process_product_meta', array( $this, 'empdev_woocommerce_purchase_limit_save_product' ) );
		}

		function empdev_woocommerce_redirect_product_url() {

			if ( is_user_logged_in() ) {

				if ( isset( $_GET['redirect_permalink'] ) ) {
					wp_safe_redirect( $_GET['redirect_permalink'], 302 );
					exit;
				}
			}
		}

		function empdev_woocommerce_purchase_limit_save_product( $post_id ) {

			$new_customers_val = trim( get_post_meta( $post_id, '_empdev_limit_new_customers', true ) );

			$new_customers_val_update = $_POST['_empdev_limit_new_customers'];

			if ( $new_customers_val != $new_customers_val_update ) {

				update_post_meta( $post_id, '_empdev_limit_new_customers', $new_customers_val_update );

			}

			$meta_purchase = trim( get_post_meta( $post_id, '_empdev_purchase_one_at_time', true ) );
			$meta_purchase_new = $_POST['_empdev_purchase_one_at_time'];

			if ( $meta_purchase != $meta_purchase_new ) {

				$this->create_post_option_array_value($meta_purchase_new, $post_id, '_empdev_purchase_one_at_time', 'empdev_purchase_one_at_time' );

			}


			$start_date_val = trim( get_post_meta( $post_id, '_empdev_limit_new_customers_start_date', true ) );
			$start_date_val_update = sanitize_text_field( $_POST['_empdev_limit_new_customers_start_date'] );


			if ( $start_date_val != $start_date_val_update ) {

				update_post_meta( $post_id, '_empdev_limit_new_customers_start_date', $start_date_val_update );

			}

			$pre_sale_text = trim( get_post_meta( $post_id, '_empdev_custom_pre_sale_text', true ) );
			$pre_sale_text_update = sanitize_text_field( $_POST['_empdev_custom_pre_sale_text'] );

			if ( $pre_sale_text != $pre_sale_text_update ) {

				update_post_meta( $post_id, '_empdev_custom_pre_sale_text', $pre_sale_text_update );

			}

			$sale_text = trim( get_post_meta( $post_id, '_empdev_custom_sale_text', true ) );
			$sale_text_update = sanitize_text_field( $_POST['_empdev_custom_sale_text'] );

			if ( $sale_text != $sale_text_update ) {

				update_post_meta( $post_id, '_empdev_custom_sale_text', $sale_text_update );

			}

			$meta_related = trim( get_post_meta( $post_id, '_empdev_exclude_related_posts', true ) );
			$meta_related_new = $_POST['_empdev_exclude_related_posts'];
			//delete_option( 'empdev_exclude_related_posts');
			if ( $meta_related != $meta_related_new ) {

				update_post_meta( $post_id, '_empdev_exclude_related_posts', $meta_related_new );

				$get_related_ids = get_option( 'empdev_exclude_related_posts', false );

				if ( ! $get_related_ids ) {

					update_option( 'empdev_exclude_related_posts', array($post_id) );

				} else {

					$check_related_ids = in_array( $post_id, $get_related_ids );
					$new_related_ids = array();

					if ( $check_related_ids ) {

						$i = 0;
						foreach ( $new_related_ids as $pid ) {
							if ( $pid == $post_id ) {
								unset( $new_related_ids[ $i ] );
							} else {
								$new_related_ids[] = $pid;
							}
							$i ++;

						}
						update_option( 'empdev_exclude_related_posts', $new_related_ids );

					} else {
						//array_push($get_product_ids, $post_id)
						array_push($get_related_ids, $post_id);

						update_option( 'empdev_exclude_related_posts', $get_related_ids );

					}
				}

			}


		}

		function empdev_woocommerce_product_options_advanced() {

			echo '<div class="options_group">';

			woocommerce_wp_checkbox(
				array(
					'id' => '_empdev_exclude_related_posts',
					'label' => __( 'Hide in related products', 'woocommerce' ),
					'placeholder' => '',
					'desc_tip' => 'true',
					'description' => __( 'Check this option to exclude in related products.', 'woocommerce' )
				)

			);

			woocommerce_wp_checkbox(
				array(
					'id' => '_empdev_purchase_one_at_time',
					'label' => __( 'Enable purchase one at a time', 'woocommerce' ),
					'placeholder' => '',
					'desc_tip' => 'true',
					'description' => __( 'This will add to the list of products that can\'t be added in the cart at the same time.', 'woocommerce' )
				)

			);

			woocommerce_wp_text_input(
				array(
					'id'          => '_empdev_custom_pre_sale_text',
					'label'       => __( 'Pre sale label text on image.', 'woocommerce' ),
					'placeholder' => ''
				)
			);

			woocommerce_wp_text_input(
				array(
					'id'          => '_empdev_custom_sale_text',
					'label'       => __( 'Replace sale label text on image.', 'woocommerce' ),
					'placeholder' => ''
				)
			);

			woocommerce_wp_checkbox(
				array(
					'id' => '_empdev_limit_new_customers',
					'label' => __( 'Enable new customers only', 'woocommerce' ),
					'placeholder' => '',
					'desc_tip' => 'true',
					'description' => __( 'Only new customers can purchase this product.', 'woocommerce' )
				)

			);

			woocommerce_wp_text_input(
				array(
					'id'          => '_empdev_limit_new_customers_start_date',
					'label'       => __( 'Enter start date to restrict new customers limit.', 'woocommerce' ),
					'placeholder' => ''
				)
			);

			echo '</div>';

		}

		function emddev_conditional_product_in_cart_dynamic( $passed, $product_id ) {

			// HERE define your 4 specific product Ids
			//$products_ids = array( 7131, 9026 );
			$products_ids = get_option( 'empdev_purchase_one_at_time', false );

			$addon_product_ids = get_option( 'empdev_enable_addon_checkout', false );

			// Searching in cart for IDs
			if ( ! WC()->cart->is_empty() && $products_ids != false  ) {
				foreach ( WC()->cart->get_cart() as $cart_item ) {
					$item_pid = $cart_item['product_id'];
					$product_message_title_cart = trim( get_post_meta( $item_pid, '_empdev_purchase_product_title_message', true ) );

					$product_message_title_cart = ($product_message_title_cart != '') ? $product_message_title_cart : get_the_title( $item_pid );

					//	// If current product is from the targeted IDs and a another targeted product id in cart
					if ( in_array( $item_pid, $products_ids ) && in_array( $product_id, $products_ids ) && $product_id != $item_pid ) {
						$passed = false; // Avoid add to cart
						$message_title = "Sorry, this product can't be purchased at the same time with other special offers!";
						break; // Stop the loop
					}
				}
			}

			if ( WC()->cart->is_empty() ) {

				if ( in_array( $product_id, $addon_product_ids ) ) {
					$passed        = false; // Avoid add to cart
					$message_title = "Sorry, you can only purchase this product as an add on, please add item to your cart.";

				}
			}

			//	$product_message_title = trim( get_post_meta( $product_id, '_empdev_purchase_product_title_message', true ) );
			//	$product_message_title = ($product_message_title != '') ? $product_message_title : get_the_title( $product_id );

			if ( ! $passed ) {
				// Displaying a custom message
				$message = __( $message_title, "woocommerce" );
				wc_add_notice( $message, 'error' );
			}

			if( $passed ){
				return $passed;
			}

		}

		private function create_post_option_array_value( $meta_value_new, $post_id, $post_meta_name, $option_meta_name ){

			update_post_meta( $post_id, $post_meta_name, $meta_value_new );

			$product_ids     = array();
			$get_product_ids = get_option( $option_meta_name, false );

			if ( ! $get_product_ids ) {

				update_option( $option_meta_name, array($post_id) );

			} else {

				$check_product_ids = in_array( $post_id, $get_product_ids );
				$new_product_ids = array();

				if ( $check_product_ids ) {

					$i = 0;
					foreach ( $get_product_ids as $pid ) {
						if ( $pid == $post_id ) {
							unset( $get_product_ids[ $i ] );
						} else {
							$new_product_ids[] = $pid;
						}
						$i ++;

					}
					update_option( $option_meta_name, $new_product_ids );

				} else {
					//array_push($get_product_ids, $post_id)
					array_push($get_product_ids, $post_id);

					update_option( $option_meta_name, $get_product_ids );

				}
			}


		}
	}
	new EMPDEV_WC_Meta_Option();
}




