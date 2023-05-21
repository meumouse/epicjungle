<?php
/**
 * EpicJungle WooCommerce hooks
 *
 * @package epicjungle
 */

// Remove default subcatgories
remove_action( 'woocommerce_after_shop_loop_item_title',  'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_shop_loop',            'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop',            'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop_item', 	  'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_main_content',         'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content',         'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',          'woocommerce_output_content_wrapper_end', 10 );

remove_action( 'woocommerce_after_shop_loop',             'woocommerce_pagination', 10 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 ); 
remove_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_product_link_close', 5 );


/**
 * My Account
 */
add_filter( 'woocommerce_my_account_my_orders_query', 'epicjungle_woocommerce_my_account_orders_limit' );
add_action( 'woocommerce_save_account_details', 'epicjungle_woocommerce_save_account_form_profile_pic_field' );

add_action( 'woocommerce_credit_card_form_start', 'epicjungle_row_open', 10 );
add_action( 'woocommerce_credit_card_form_end', 'epicjungle_row_close', 10 );

add_filter( 'woocommerce_default_address_fields', 'epicjungle_wc_checkout_address_fields' );
add_filter( 'woocommerce_billing_fields', 'epicjungle_wc_checkout_address_fields' );
add_filter( 'woocommerce_checkout_fields', 'epicjungle_wc_checkout_fields' );

add_action( 'epicjungle_page', 'epicjungle_wc_page_header', 5 );
add_filter( 'epicjungle_is_navbar_variant',   'epicjungle_wc_page_navbar_variant', 10 );
add_filter( 'epicjungle_is_footer_variant',   'epicjungle_wc_page_footer_variant', 10 );


add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );



/**
 * Products
 */

add_filter( 'mas_wcvs_loop_variation_enable',               'epicjungle_mas_wcvs_loop_variation_enable' );

add_filter( 'woocommerce_product_get_rating_html', 			'epicjungle_wc_template_loop_product_empty_rating', 10, 2 );
add_filter( 'woocommerce_loop_add_to_cart_link',          	'epicjungle_wc_loop_add_to_cart_link', 10, 3 );
add_filter( 'woocommerce_product_loop_start',				'epicjungle_product_loop_start', 10 );
add_filter( 'woocommerce_product_loop_title_classes',		'epicjungle_product_loop_title_classes', 10 );


add_filter( 'woocommerce_product_categories_widget_args', 'epicjungle_modify_wc_product_cat_widget_args', 10 );
add_filter( 'woocommerce_layered_nav_term_html', 		  'epicjungle_wc_layered_nav_term_html', 10, 4 );


add_filter( 'loop_shop_per_page',                        'epicjungle_wc_set_loop_shop_per_page', 10 );

add_action( 'woocommerce_before_shop_loop',              'epicjungle_breadcrumb', 10 );
add_action( 'woocommerce_before_shop_loop',              'epicjungle_wc_active_filters', 20 );
add_action( 'woocommerce_before_shop_loop',              'epicjungle_shop_control_bar', 30 );
add_action( 'epicjungle_shop_control_bar_left',           	 'woocommerce_catalog_ordering', 10 );
add_action( 'epicjungle_shop_control_bar_left',              'epicjungle_wc_result_count', 20 );
add_action( 'epicjungle_shop_control_bar_right',             'epicjungle_wc_products_per_page', 30 );

add_action( 'woocommerce_before_shop_loop_item', 		'epicjungle_product_loop_wrap_open',  0 );
add_action( 'woocommerce_before_shop_loop_item', 		'epicjungle_product_loop_sale',  20 );

add_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_template_loop_product_link_open', 9 ); 
add_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_template_loop_product_link_close', 11 ); 
add_action( 'woocommerce_before_shop_loop_item_title', 	'epicjungle_product_loop_card_body_open', 90 );
add_action( 'woocommerce_shop_loop_item_title', 		'epicjungle_template_loop_categories', 5 );
add_action( 'woocommerce_shop_loop_item_title',         'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title',   'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 	'epicjungle_product_loop_card_body_close', 20 );
add_action( 'woocommerce_after_shop_loop_item_title', 	'epicjungle_product_loop_card_footer_open', 25 );
add_action( 'woocommerce_after_shop_loop_item_title',   'epicjungle_wc_template_loop_product_rating', 30 );

add_action( 'woocommerce_after_shop_loop_item',     	'epicjungle_product_loop_action_wrap_start', 5 );
add_action( 'woocommerce_after_shop_loop_item',     	'epicjungle_product_loop_wishlist', 8 );
add_action( 'woocommerce_after_shop_loop_item',     	'epicjungle_product_loop_action_wrap_end', 35 );
 
add_action( 'woocommerce_after_shop_loop_item', 		'epicjungle_product_loop_card_footer_close', 60 );
add_action( 'woocommerce_after_shop_loop_item', 		'epicjungle_product_loop_wrap_close', 80 );

add_action( 'woocommerce_after_shop_loop',              'epicjungle_shop_pagination_bar', 10 );
add_action( 'epicjungle_pagination_bar_left',              	'epicjungle_wc_products_per_page', 10 );
add_action( 'epicjungle_pagination_bar_right',              'woocommerce_pagination', 10 );

/**
 * Sidebar Filter
 */

add_action( 'epicjungle_handheld_toolbar', 'epicjungle_wc_handheld_toolbar_toggle_shop_sidebar', 10 );

/**
 * Single Product
 */
remove_action( 'woocommerce_before_main_content',           'woocommerce_breadcrumb', 20, 0 );

remove_action( 'woocommerce_before_single_product',         'woocommerce_output_all_notices', 10 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_single_product_summary',        'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary',        'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary',        'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary',        'woocommerce_template_single_excerpt',  20 );
remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_output_related_products',  20 );
remove_action( 'woocommerce_single_product_summary',        'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_upsell_display', 15 );

add_filter('woocommerce_format_sale_price',                    'epicjungle_wc_format_sale_price', 10, 3);


add_action( 'woocommerce_before_single_product_summary',               'epicjungle_wc_product_wrap_open',           5 );
add_action( 'woocommerce_before_single_product_summary',               'epicjungle_wc_product_container_open',      20 );
add_action( 'woocommerce_before_single_product_summary',               'epicjungle_wc_product_images',              30 );
add_action( 'woocommerce_before_single_product_summary',               'epicjungle_wc_product_summary_wrap_open',   40 );

add_action( 'woocommerce_single_product_summary',                       'epicjungle_wc_product_rating', 5 );
add_action( 'woocommerce_single_product_summary',                       'epicjungle_wc_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary',                       'woocommerce_template_single_excerpt', 35 );

add_action( 'woocommerce_after_single_product_summary',                 'epicjungle_wc_product_summary_wrap_close',   5 );

add_action( 'woocommerce_after_single_product_summary',                'epicjungle_wc_product_container_close',      8 );
add_action( 'woocommerce_after_single_product_summary',                'epicjungle_wc_product_wrap_close',   9 );

add_action( 'woocommerce_after_single_product_summary',                 'epicjungle_wc_product_description', 10 );

add_action( 'woocommerce_after_single_product_summary',                 'epicjungle_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary',                 'epicjungle_wc_reviews', 30 );
add_action( 'woocommerce_after_single_product_summary',                 'woocommerce_upsell_display', 40 );


add_action( 'template_redirect', 'epicjungle_wc_product_remove_sidebar' );

add_action( 'epicjungle_wc_product_left_column', 'woocommerce_output_all_notices', 5 );
add_action( 'epicjungle_wc_product_left_column', 'epicjungle_breadcrumb', 10 );
//add_action( 'epicjungle_wc_product_left_column', 'epicjungle_wc_product_title', 20 );
add_action( 'epicjungle_wc_product_left_column', 'woocommerce_show_product_images', 30 );
add_action( 'epicjungle_wc_product_left_column ', 'epicjungle_wc_product_share_wrap', 40 );

/** 
 * Remove on single product panel 'Additional Information' since it already says it on tab.
 */
add_filter('woocommerce_output_related_products_args', 'epicjungle_output_related_products_args');

/**
 * Reviews
 */
remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );
remove_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
remove_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );

add_action( 'epicjungle_single_product_reviews_before', 'epicjungle_wc_reviews_overall' );
add_action( 'woocommerce_review_before_comment_text', 'epicjungle_wc_review_before' );

/**
 * WC Pages
 */
remove_action( 'woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
add_filter( 'woocommerce_add_to_cart_fragments', 'epicjungle_cart_link_fragment', 10 );

/**
 * Checkout
 */
add_action( 'epicjungle_before_checkout_form', 'epicjungle_breadcrumb', 10 );
add_action( 'epicjungle_before_checkout_form', 'epicjungle_page_header', 20 );


add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'epicjungle_after_cart_form', 'epicjungle_output_cross_sell_products' ); 