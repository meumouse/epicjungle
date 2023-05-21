<?php
/**
 * Template functions used in Checkout
 *
 */

if ( ! function_exists( 'epicjungle_wc_checkout_before_page_wrap_open' ) ) {

   	function epicjungle_wc_checkout_before_page_wrap_open() {
   		if ( is_checkout() ) { ?>
   			<div class="cs-sidebar-enabled cs-sidebar-right needs-validation"><?php
   		}
   	}
}

if ( ! function_exists( 'epicjungle_wc_checkout_before_page_wrap_close' ) ) {

   	function epicjungle_wc_checkout_before_page_wrap_close() {
   		if ( is_checkout() ) { ?>
   			</div><?php
   		}
   	}
}

if ( ! function_exists( 'epicjungle_checkout_page_header' ) ) {
    function epicjungle_checkout_page_header() {
        if ( epicjungle_is_woocommerce_activated() && is_checkout() ) {
            remove_action( 'epicjungle_page', 'epicjungle_breadcrumb', 10 );
            remove_action( 'epicjungle_page', 'epicjungle_page_header', 20 );
       }
    }
}