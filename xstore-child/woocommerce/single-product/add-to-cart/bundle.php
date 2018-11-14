<?php
/**
 * Product Bundle single-product template
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/add-to-cart/bundle.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 5.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** WC Core action. */
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<?php
$user = wp_get_current_user();
$new_customers_val = trim( get_post_meta( $product_id, '_empdev_limit_new_customers', true ) );
$start_date_val    = trim( get_post_meta( $product_id, '_empdev_limit_new_customers_start_date', true ) );

$start_date_restriction = date( "F j, Y, g:i a", strtotime( $start_date_val ) );
$start_date_restriction = strtotime( $start_date_restriction );
$user_registration      = strtotime( $user->user_registered );

if( $new_customers_val ): ?>

    <?php if( $user->ID && $user_registration < $start_date_restriction ) {
        echo '<p style="color:red;font-size:18px">This offer is only valid for new customers!</p>';
    }
    else {
        if( is_user_logged_in() ){
            ?>
            <form method="post" enctype="multipart/form-data" id="" class="cart cart_group bundle_form <?php echo esc_attr( $classes ); ?>"><?php

		        /**
		         * 'woocommerce_before_bundled_items' action.
		         *
		         * @param WC_Product_Bundle $product
		         */
		        do_action( 'woocommerce_before_bundled_items', $product );

		        foreach ( $bundled_items as $bundled_item ) {

			        /**
			         * 'woocommerce_bundled_item_details' action.
			         *
			         * @hooked wc_pb_template_bundled_item_details_wrapper_open  -   0
			         * @hooked wc_pb_template_bundled_item_thumbnail             -   5
			         * @hooked wc_pb_template_bundled_item_details_open          -  10
			         * @hooked wc_pb_template_bundled_item_title                 -  15
			         * @hooked wc_pb_template_bundled_item_description           -  20
			         * @hooked wc_pb_template_bundled_item_product_details       -  25
			         * @hooked wc_pb_template_bundled_item_details_close         -  30
			         * @hooked wc_pb_template_bundled_item_details_wrapper_close - 100
			         */
			        do_action( 'woocommerce_bundled_item_details', $bundled_item, $product );
		        }

		        /**
		         * 'woocommerce_after_bundled_items' action.
		         *
		         * @param  WC_Product_Bundle  $product
		         */
		        do_action( 'woocommerce_after_bundled_items', $product );

		        /**
		         * 'woocommerce_bundles_add_to_cart_wrap' action.
		         *
		         * @since  5.5.0
		         *
		         * @param  WC_Product_Bundle  $product
		         */
		        do_action( 'woocommerce_bundles_add_to_cart_wrap', $product );

		        ?></form>
            <?php
        } else {

            $product_permalink = get_permalink( $product_id );
            echo '<a href="/my-account/?redirect_permalink=' . esc_url( $product_permalink ) . '"><button class="single_add_to_cart_button bundle_add_to_cart_button button alt">Login required</button></a>';

        }

    } ?>

<?php else: ?>

    <form method="post" enctype="multipart/form-data" id="product-bundled-emp-<?php echo $product_id;?>" class="cart cart_group bundle_form <?php echo esc_attr( $classes ); ?>"><?php

        /**
         * 'woocommerce_before_bundled_items' action.
         *
         * @param WC_Product_Bundle $product
         */
        do_action( 'woocommerce_before_bundled_items', $product );

        foreach ( $bundled_items as $bundled_item ) {

            /**
             * 'woocommerce_bundled_item_details' action.
             *
             * @hooked wc_pb_template_bundled_item_details_wrapper_open  -   0
             * @hooked wc_pb_template_bundled_item_thumbnail             -   5
             * @hooked wc_pb_template_bundled_item_details_open          -  10
             * @hooked wc_pb_template_bundled_item_title                 -  15
             * @hooked wc_pb_template_bundled_item_description           -  20
             * @hooked wc_pb_template_bundled_item_product_details       -  25
             * @hooked wc_pb_template_bundled_item_details_close         -  30
             * @hooked wc_pb_template_bundled_item_details_wrapper_close - 100
             */
            do_action( 'woocommerce_bundled_item_details', $bundled_item, $product );
        }

        /**
         * 'woocommerce_after_bundled_items' action.
         *
         * @param  WC_Product_Bundle  $product
         */
        do_action( 'woocommerce_after_bundled_items', $product );

        /**
         * 'woocommerce_bundles_add_to_cart_wrap' action.
         *
         * @since  5.5.0
         *
         * @param  WC_Product_Bundle  $product
         */
        do_action( 'woocommerce_bundles_add_to_cart_wrap', $product );

    ?></form>

<?php endif; ?>
<?php
	/** WC Core action. */
	do_action( 'woocommerce_after_add_to_cart_form' );
?>
