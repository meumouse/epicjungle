<?php
/**
 * WooCommerce Third Party Plugin Compatibility
 *
 * @package epicjungle
 */

/**
 * Integrate plugin "YITH WooCommerce Wishlist" into the theme. 
 */

if ( epicjungle_is_yith_wcwl_activated() ) {

	global $yith_wcwl;

	/**
	 * Add provider for wishlist functionality.
	 */
	if( ! function_exists( 'epicjungle_wishlist_provider_yith' ) ){
		function epicjungle_wishlist_provider_yith() {
			return 'yith';
		}
	}


	/**grunt

	 * Output the "Add to Wishlist" button.
	 */
	function epicjungle_add_to_wishlist_button() {
		echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}

	add_action('epicjungle_add_to_wishlist_yith',  'epicjungle_add_to_wishlist_button');
	add_action( 'epicjungle_product_wishlist',     'epicjungle_add_to_wishlist_button', 30 );


	if( property_exists( $yith_wcwl, 'wcwl_init' ) ) {
		remove_action( 'wp_enqueue_scripts', array( $yith_wcwl->wcwl_init, 'enqueue_styles_and_stuffs' ) );
	}
	// Dequeue YITH styles.
	
	if( ! function_exists( 'epicjungle_yith_wcwl_dequeue_styles' ) ){
		function epicjungle_yith_wcwl_dequeue_styles() {
			wp_dequeue_style( 'yith-wcwl-main' );
			wp_deregister_style( 'yith-wcwl-main' );
		}

	}
	add_action( 'wp_print_styles',   'epicjungle_yith_wcwl_dequeue_styles', 10 );
	//add_action( 'wp_enqueue_scripts', 'epicjungle_yith_wcwl_dequeue_styles', 10 );


	function epicjungle_custom_wishlist_endpoints() {
		add_rewrite_endpoint( 'favoritos', EP_ROOT | EP_PAGES );
	}

	add_action( 'init', 'epicjungle_custom_wishlist_endpoints' );

	function my_custom_query_vars( $vars ) {
	    $vars[] = 'favoritos';

	    return $vars;
	}

	add_filter( 'query_vars', 'my_custom_query_vars', 0 );

	function my_flush_rewrite_rules() {
	    flush_rewrite_rules();
	}

	add_action( 'wp_loaded', 'my_flush_rewrite_rules' );

	function epicjungle_custom_my_account_menu_items( $items ) {

	    // Remove the logout menu item.
		$logout = $items['customer-logout'];
		unset( $items['customer-logout'] );
		 
		// Insert your custom endpoint.
		$items['favoritos'] = esc_html__( 'Favorites', 'epicjungle' );
		 
		// Insert back the logout item.
		$items['customer-logout'] = $logout;
		 
		return $items;

	    
	}

	add_filter( 'woocommerce_account_menu_items', 'epicjungle_custom_my_account_menu_items' );


	function epicjungle_custom_wishlist_endpoint_content() {
		echo do_shortcode('[yith_wcwl_wishlist]');
	}
	 
	add_action( 'woocommerce_account_favoritos_endpoint', 'epicjungle_custom_wishlist_endpoint_content' );
}


/**
 * Integrate plugin "MAS WooCommerce Variation Swatches" into the theme. 
 */

if( epicjungle_is_mas_wcvs_activated() ) {

    if( ! function_exists( 'epicjungle_mas_wcvs_loop_variation' ) ) {
        function epicjungle_mas_wcvs_loop_variation() {

            global $product;

             if ( apply_filters( 'mas_wcvs_loop_variation_enable', true ) && $product->is_type( 'variable' ) ) {
                remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
                //woocommerce_variable_add_to_cart();
                //add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
            }
        }
    }

    remove_action( 'woocommerce_after_shop_loop_item', 'mas_wcvs_loop_variation', 6 );

    //add_action( 'woocommerce_after_shop_loop_item_title', 'epicjungle_mas_wcvs_loop_variation', 40 );
    //add_action( 'woocommerce_after_shop_loop_item', 'epicjungle_mas_wcvs_loop_variation', 130 );
    
   
    add_action( 'wp_enqueue_scripts', 'mas_wcvs_enqueue_style' );

    function mas_wcvs_enqueue_style() {
        wp_enqueue_style( 'mas-wcvs-style' );
    }
}

