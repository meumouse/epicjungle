<?php
/**
 * Template functions used in My Account
 *
 */

if ( ! function_exists( 'silicon_wc_page_header' ) ) {
    function silicon_wc_page_header() {
        if ( apply_filters( 'silicon_wc_page_header', true ) && silicon_is_woocommerce_activated() && ( is_account_page() || is_cart() || is_checkout() ) ) {
            remove_action( 'silicon_page', 'silicon_breadcrumb', 10 );
            remove_action( 'silicon_page', 'silicon_page_header', 20 );
        }
    }
}

if ( ! function_exists( 'silicon_wc_account_orders_count' ) ) {
    function silicon_wc_account_orders_count() {
        $orders = wc_get_orders( apply_filters( 'silicon_wc_account_orders_count_args', [
            'status'   => [ 'pending', 'processing', 'pedido-enviado', 'on-hold', 'failed' ],
            'customer' => get_current_user_id(),
            'return'   => 'ids',
            'limit'    => - 1,
            'paginate' => false,
        ] ) );

        echo count( $orders );
    }
}

if ( ! function_exists( 'silicon_wc_account_downloads_count' ) ) {
    function silicon_wc_account_downloads_count() {
        $downloads = WC()->customer->get_downloadable_products();
        echo count( $downloads );
    }
}

if ( ! function_exists( 'silicon_wc_account_title' ) ) {
    function silicon_wc_account_title() {
        global $wp;

        $endpoints = wc_get_account_menu_items();
        $title     = esc_html_x( 'My Account', 'front-end', 'silicon' );
        foreach ( $endpoints as $endpoint => $label ) {
            if ( isset( $wp->query_vars[ $endpoint ] ) ) {
                $title = $label;
            } elseif ( isset( $wp->query_vars['orders'] ) ) {
                $title = esc_html_x( 'Orders history', 'front-end', 'silicon' );
                break;
            } elseif ( isset( $wp->query_vars['add-payment-method'] ) ) {
                $title = esc_html_x( 'Payment methods', 'front-end', 'silicon' );
                break;
            } elseif ( isset( $wp->query_vars['favoritos'] ) ) {
                $title = sprintf( wp_kses_post( 'Favoritos<span class="d-inline-block align-middle bg-faded-dark font-size-ms font-weight-medium rounded-sm py-1 px-2 ml-2">%s</span>', 'front-end', 'silicon' ), yith_wcwl_count_products() );
                break;
            } elseif ( isset( $wp->query_vars['page'] ) || empty( $wp->query_vars ) ) {
                // Dashboard is not an endpoint, so needs a custom check.
                $title = esc_html_x( 'Dashboard', 'front-end', 'silicon' );
                break;
            }
        }

        echo apply_filters( 'silicon_wc_account_title', $title );
    }
}

if ( ! function_exists( 'silicon_woocommerce_my_account_orders_limit' ) ) {
    function silicon_woocommerce_my_account_orders_limit( $args ) {
        // Set the posts per page
        $args['posts_per_page'] = silicon_get_woocommerce_my_account_orders_limit();
        return $args;
    }
}

if ( ! function_exists( 'silicon_get_woocommerce_my_account_orders_limit' ) ) {
    function silicon_get_woocommerce_my_account_orders_limit() {
        return apply_filters( 'silicon_get_woocommerce_my_account_orders_limit', 5 );
    }
}

if ( ! function_exists( 'silicon_woocommerce_save_account_form_profile_pic_field' ) ) {
    function silicon_woocommerce_save_account_form_profile_pic_field( $user_id ) {
        if ( ! current_user_can( 'edit_user', $user_id ) ) { return true; }
        update_user_meta( $user_id, '_silicon_custom_avatar_id', absint( $_POST['silicon_custom_avatar_id'] ) );
    
    }
}

if ( ! function_exists( 'silicon_row_open' ) ) {
    function silicon_row_open() { ?>
        <div class="row"><?php
    }
}

if ( ! function_exists( 'silicon_row_close' ) ) {
    function silicon_row_close() { ?>
        </div><?php
    }
}

if ( ! function_exists( 'silicon_wc_checkout_address_fields' ) ) {
    function silicon_wc_checkout_address_fields( $fields ) {
        foreach ( $fields as $field => &$args ) {
            switch ( $field ) {
                case 'first_name':
                case 'last_name':
                case 'company':
                case 'billing_phone':
                    $args['class']       = [ 'form-group', 'col-sm-6' ];
                    $args['input_class'] = [ 'form-control' ];
                    $args['label_class'] = [ 'form-label' ];
                    break;

                case 'country':
                    $args['class']       = [ 'form-group', 'col-sm-6', 'address-field', 'update_totals_on_change' ];
                    $args['input_class'] = [ 'form-control' ];
                    $args['label_class'] = [ 'form-label' ];
                    break;

                case 'address_1':
                case 'address_2':
                    $args['class']       = [ 'form-group', 'col-sm-12', 'address-field' ];
                    $args['input_class'] = [ 'form-control' ];
                    $args['label_class'] = [ 'form-label' ];
                    break;

                case 'city':
                case 'state':
                case 'postcode':
                    $args['class']       = [ 'form-group', 'col-sm-6', 'address-field' ];
                    $args['input_class'] = [ 'form-control' ];
                    $args['label_class'] = [ 'form-label' ];
                    break;
                case 'billing_email':
                    $args['class']       = [ 'form-group', 'col-sm-12' ];
                    $args['input_class'] = [ 'form-control' ];
                    $args['label_class'] = [ 'form-label' ];
                    break;
            }
        }

        return $fields;
    }
}

if ( ! function_exists( 'silicon_wc_checkout_fields' ) ) {
    function silicon_wc_checkout_fields( $fields ) {
        if ( ! empty( $fields['account'] ) ) {
            if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) {
                $fields['account']['account_username']['class']       = [ 'form-group', 'col-sm-12' ];
                $fields['account']['account_username']['input_class'] = [ 'form-control' ];
            }

            if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) {
                $fields['account']['account_password']['class']       = [ 'form-group', 'col-sm-12' ];
                $fields['account']['account_password']['input_class'] = [ 'form-control' ];
            }
        }

        if ( ! empty( $fields['order'] ) ) {
            if ( isset( $fields['order']['order_comments'] ) ) {
                $fields['order']['order_comments']['class']       = [ 'form-group' ];
                $fields['order']['order_comments']['input_class'] = [ 'form-control' ];
            }
        }


        return $fields;
    }
}

if ( ! function_exists( 'silicon_wc_order_item_name' ) ) {
    function silicon_wc_order_item_name( $name, $item ){
        $variation_id = $item['variation_id'];
        if( $variation_id > 0 ) {
            $product_id = $item['product_id'];
            $_product = wc_get_product( $product_id );
            $product_name = $_product->get_title();
            $_name = $product_name;
            $variation_name = str_replace( $product_name . ' -', '', $item->get_name() );
            $_name .= '<span class="text-muted d-block mt-1 font-weight-normal">' . $variation_name . '</span>';
            $updated_name = str_replace( $item->get_name(), $_name, $name );
            $name = $updated_name;
        }
        
        return $name;
    }
}
add_filter( 'woocommerce_order_item_name', 'silicon_wc_order_item_name', 10, 2 );