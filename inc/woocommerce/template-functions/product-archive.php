<?php
/**
 * Template functions used in Product Archive
 *
 */

if ( ! function_exists( 'epicjungle_shop_control_bar' ) ) {
    function epicjungle_shop_control_bar() {
        ?><div class="d-flex justify-content-between align-items-center pt-4 pb-3 mb-3">
            <div class="d-flex justify-content-center align-items-center"><?php do_action( 'epicjungle_shop_control_bar_left' ); ?></div>
            <div class="d-none d-lg-flex justify-content-center align-items-center"><?php do_action( 'epicjungle_shop_control_bar_right' ); ?></div>
        </div><?php
    }
}

if ( ! function_exists( 'epicjungle_shop_pagination_bar' ) ) {
    function epicjungle_shop_pagination_bar() {
        ?><div class="d-md-flex justify-content-between align-items-center pt-3 pb-2">
            <div class="d-flex justify-content-center align-items-center mb-4"><?php do_action( 'epicjungle_pagination_bar_left' ); ?></div>
            <?php do_action( 'epicjungle_pagination_bar_right' ); ?>
        </div><?php
    }
}

if ( ! function_exists( 'epicjungle_wc_set_loop_shop_per_page' ) ) {
    /**
     * Set Shop Loop Per Page
     */
    function epicjungle_wc_set_loop_shop_per_page( $per_page ) {
        if ( isset( $_REQUEST['wppp_ppp'] ) ) :
            $per_page = intval( $_REQUEST['wppp_ppp'] );
            WC()->session->set( 'products_per_page', intval( $_REQUEST['wppp_ppp'] ) );
        elseif ( isset( $_REQUEST['ppp'] ) ) :
            $per_page = intval( $_REQUEST['ppp'] );
            WC()->session->set( 'products_per_page', intval( $_REQUEST['ppp'] ) );
        elseif ( WC()->session->__isset( 'products_per_page' ) ) :
            $per_page = intval( WC()->session->__get( 'products_per_page' ) );
        endif;

        return $per_page;
    }
}


if ( ! function_exists( 'epicjungle_wc_products_per_page' ) ) {
    /**
     * Outputs a dropdown for user to select how many products to show per page
     */
    function epicjungle_wc_products_per_page() {

        global $wp_query;
        global $wp;

        $action             = '';
        $cat                = '';
        $cat                = $wp_query->get_queried_object();
        $method             = apply_filters( 'epicjungle_wc_ppp_method', 'post' );
        $return_to_first    = apply_filters( 'epicjungle_wc_ppp_return_to_first', false );
        $total              = $wp_query->found_posts;
        $per_page           = $wp_query->get( 'posts_per_page' );
        $columns            = apply_filters( 'epicjungle_catalog_columns', wc_get_default_products_per_row() );
        $rows               = apply_filters( 'epicjungle_catalog_columns', wc_get_default_product_rows_per_page() );
        $_per_page          = $columns * $rows;

        // Generate per page options
        $products_per_page_options = array();
        
        while( $_per_page < $total ) {
            $products_per_page_options[] = $_per_page;
            $_per_page = $_per_page * 2;
        }

        if ( empty( $products_per_page_options ) ) {
            return;
        }

        $products_per_page_options[] = -1;

        // Set action url if option behaviour is true
        // Paste QUERY string after for filter and orderby support
        $query_string = null;

        if ( isset( $cat->term_id ) && isset( $cat->taxonomy ) && $return_to_first ) :
            $action = get_term_link( $cat->term_id, $cat->taxonomy ) . $query_string;
        elseif ( $return_to_first ) :
            $action = get_permalink( wc_get_page_id( 'shop' ) ) . $query_string;
        else :
            $action = home_url( $wp->request );
        endif;


        // Only show on product categories
        if ( ! woocommerce_products_will_display() ) :
            return;
        endif;


        do_action( 'epicjungle_wc_ppp_before_dropdown_form' );

        ?><form method="POST" action="<?php echo esc_url( $action ); ?>" class="d-none d-lg-flex justify-content-center align-items-center">
            <label class="pr-1 mr-2"><?php echo esc_html__( 'Show', 'epicjungle' )?></label><?php
             do_action( 'epicjungle_wc_ppp_before_dropdown' );
            ?><select name="ppp" onchange="this.form.submit()" class="form-control custom-select mr-2"  style="width: 5rem;"><?php

                foreach( $products_per_page_options as $key => $value ) :

                    ?><option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $per_page ); ?>><?php
                       
                        esc_html( printf( $value == -1 ? esc_html__( 'All', 'epicjungle' ) : $value ) ); // Set to 'All' when value is -1
                    ?></option><?php
                endforeach;

            ?></select>
            <div class="font-size-sm text-nowrap pl-1 mb-1"><?php echo esc_html__( 'products per page', 'epicjungle' )?></div><?php

            // Keep query string vars intact
            foreach ( $_GET as $key => $val ) :

                if ( 'ppp' === $key || 'submit' === $key ) :
                    continue;
                endif;
                if ( is_array( $val ) ) :
                    foreach( $val as $inner_val ) :
                        ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $inner_val ); ?>" /><?php
                    endforeach;
                else :
                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $val ); ?>" /><?php
                endif;
            endforeach;

            do_action( 'epicjungle_wc_ppp_after_dropdown' );

        ?></form><?php

        do_action( 'epicjungle_wc_ppp_after_dropdown_form' );
    }
}

if ( ! function_exists( 'epicjungle_wc_result_count' ) ) {
    function epicjungle_wc_result_count() {
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }
        $total    = wc_get_loop_prop( 'total' );
        $per_page = wc_get_loop_prop( 'per_page' );
        $current  = wc_get_loop_prop( 'current_page' );

        ?><div class="d-none d-sm-block font-size-sm text-nowrap pl-1 mb-1">
        <?php
            $first = ( $per_page * $current ) - $per_page + 1;
            $last  = min( $total, $per_page * $current );
            /* translators: 1: first result 2: last result 3: total results */
            printf( _nx( ' of %3$d result', ' of %3$d products', $total, 'with first and last result', 'epicjungle' ), $first, $last, $total );

        ?>
        </div><?php
    }
}

if ( ! function_exists( 'epicjungle_modify_wc_product_cat_widget_args' ) ) {
    function epicjungle_modify_wc_product_cat_widget_args( $args ) {
        require_once get_template_directory() . '/inc/woocommerce/classes/class-epicjungle-product-cat-list-walker.php';
        $args['walker'] = new EpicJungle_WC_Product_Cat_List_Walker;
        return $args;
    }
}

if ( ! function_exists( 'epicjungle_wc_layered_nav_term_html' ) ) {
    function epicjungle_wc_layered_nav_term_html( $term_html, $term, $link, $count ) {
        $count_html = '';
        if ( $count > 0 ) {
            $count_html = '<span class="font-size-xs text-muted ml-2">' . absint( $count ) . '</span>';    
        }
        
        if ( $link ) {
            $term_html = '<a class="woocommerce-widget-layered-nav-list__item__link" rel="nofollow" href="' . $link . '"><span class="checkbox-indicator"></span>' . esc_html( $term->name ) . '</a>' . $count_html;
        } else {
            $term_html = '<span>' . esc_html( $term->name ) . '</span>';
        }
        return '<div class="woocommerce-widget-layered-nav-list__item__inner">' . $term_html . '</div>';
    }
}

if ( ! function_exists( 'epicjungle_wc_active_filters' ) ) {
    function epicjungle_wc_active_filters() {
        ob_start();
        the_widget( 'WC_Widget_Layered_Nav_Filters', array( 'title' => esc_html__( 'Your selection:', 'epicjungle' ) ), array(
            'before_widget' => '<div class="d-flex flex-wrap align-items-center mb-2 widget %s">',
            'before_title'  => '<label class="mr-3 mt-1 mb-2">',
            'after_title'   => '</label>',
        ) );
        $active_filters_html = ob_get_clean();
        $active_filters_html = str_replace( '<ul>', '<ul class="list-unstyled m-0 d-flex">', $active_filters_html );
        $active_filters_html = str_replace( '<li class="', '<li class="mr-2 my-2 ', $active_filters_html );
        $active_filters_html = str_replace( '<a', '<a class="active-filter" ', $active_filters_html );
        echo wp_kses_post( $active_filters_html );
    }
}

