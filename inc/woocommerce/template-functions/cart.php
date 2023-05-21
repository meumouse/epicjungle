<?php
/**
 * Template functions used in Cart
 *
 */
if ( ! function_exists( 'epicjungle_cart_link_fragment' ) ) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     * @return array            Fragments to refresh via AJAX
     */
    function epicjungle_cart_link_fragment( $fragments ) {
        global $woocommerce;

        ob_start();
        epicjungle_wc_offcanvas_mini_cart_content();
        $fragments['div.epicjungle-minicart1'] = ob_get_clean();

        ob_start();
        epicjungle_cart_link_count();
        $fragments['span.cart-contents-count'] = ob_get_clean();
            
        return $fragments;

    }
}

if ( ! function_exists( 'epicjungle_output_cross_sell_products' ) ) {
    function epicjungle_output_cross_sell_products() {
        if ( apply_filters( 'front_enable_cross_sell_products', true ) ) {
            woocommerce_cross_sell_display( 2, 2 );
        }
    }
}