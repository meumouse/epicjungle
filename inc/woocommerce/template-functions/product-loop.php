<?php
/**
 * Template functions used in Product Loop
 *
 */


if ( ! function_exists( 'epicjungle_product_loop_start' ) ) {

    /**
     * Output the start of a product loop. By default this is a UL.
     *
     * @param bool $echo Should echo?.
     * @return string
     */
    function epicjungle_product_loop_start( $loop_start ) {
        $columns = apply_filters( 'epicjungle_loop_shop_columns', wc_get_loop_prop( 'columns' ) );
        $loop_start_html = '<div class="epicjungle products row row-cols-md-3 row-cols-lg-' . esc_attr( $columns ) . ' row-cols-2">';
        return $loop_start_html;
    }
}

if ( ! function_exists( 'epicjungle_get_sidebar' ) ) {
    /**
     * Display epicjungle sidebar
     *
     * @uses get_sidebar()
     * @since 1.0.0
     */
    function epicjungle_get_sidebar() {
        if ( epicjungle_is_product_archive() ) {
            get_sidebar( 'shop' );
        }
    }
}

if ( ! function_exists( 'epicjungle_product_loop_wrap_open' ) ) {
    function epicjungle_product_loop_wrap_open() {
        ?>
        <div class="card card-hover mb-grid-gutter card-product"><?php
    }
}


if ( ! function_exists( 'epicjungle_product_loop_sale' ) ) {
    function epicjungle_product_loop_sale() {
        global $post, $product;

        if ( $product->is_on_sale() ) : ?>
            <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="badge badge-floating badge-pill badge-danger">' . esc_html__( 'Sale!', 'epicjungle' ) . '</span>', $post, $product ); ?>
        <?php endif;
    }
}

if ( ! function_exists( 'epicjungle_product_loop_wrap_close' ) ) {
    function epicjungle_product_loop_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'epicjungle_product_loop_card_body_open' ) ) {
    function epicjungle_product_loop_card_body_open() {
        ?><div class="card-body"><?php
    }
}

if ( ! function_exists( 'epicjungle_product_loop_card_body_close' ) ) {
    function epicjungle_product_loop_card_body_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'epicjungle_product_loop_card_footer_open' ) ) {
    function epicjungle_product_loop_card_footer_open() {
        ?><div class="card-footer"><?php
    }
}

if ( ! function_exists( 'epicjungle_product_loop_wishlist' ) ) {
    function epicjungle_product_loop_wishlist() {
         // check if Add to wishlist button is enabled for loop
        $enabled_on_loop = 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' );
        // Add the link "Add to wishlist"
        $position = get_option( 'yith_wcwl_loop_position', 'after_add_to_cart' );

        if( $enabled_on_loop && $position === 'shortcode' ){ 
            epicjungle_add_to_wishlist_button();
        } 
          
    }
}

if ( ! function_exists( 'epicjungle_product_loop_action_wrap_start' ) ) {
    function epicjungle_product_loop_action_wrap_start() { ?>
        <div class = "ej-product-cart d-flex align-items-center ml-auto"><?php

    }
}

if ( ! function_exists( 'epicjungle_product_loop_action_wrap_end' ) ) {
    function epicjungle_product_loop_action_wrap_end() { ?>
        <?php //do_action( 'epicjungle_product_cart' ); ?>
        </div><?php


    }
}


if ( ! function_exists( 'epicjungle_wc_loop_add_to_cart_link' ) ) {
    function epicjungle_wc_loop_add_to_cart_link( $cart_link, $product, $args ) {
        $add_to_cart = '<i class="fe-shopping-cart"></i><span class="btn-tooltip">' . $product->add_to_cart_text() . '</span>';
        return sprintf(
            '<a href="%s" data-quantity="%s" class="%s btn-addtocart" %s title="%s">%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : '' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_attr( $product->add_to_cart_text() ),
            wp_kses_post( $add_to_cart )
        );
    }
}

if ( ! function_exists( 'epicjungle_product_loop_card_footer_close' ) ) {
    function epicjungle_product_loop_card_footer_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'epicjungle_product_loop_title_classes' ) ) {
    function epicjungle_product_loop_title_classes( $product_loop_title_class ) {
        $product_loop_title_class .= ' font-size-lg font-weight-medium mb-2';
        return $product_loop_title_class;
    }
}


if ( ! function_exists( 'epicjungle_template_loop_categories' ) ) {
    function epicjungle_template_loop_categories() {
        global $product;

        $taxonomy = 'product_cat';
        $terms    = get_the_terms( $product->get_id(), $taxonomy );
        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            return;
        }

        $links = [];
        foreach ( $terms as $term ) {
            $link = get_term_link( $term, $taxonomy );
            if ( is_wp_error( $link ) ) {
                continue;
            }

            $links[] = sprintf( '<a href="%s" class="meta-link mb-1" rel="tag">%s</a>',
                esc_url( $link ),
                esc_html( $term->name )
            );
        }


        echo apply_filters( 'cepicjungle_template_loop_categories_html', wp_kses_post( sprintf( '<span class="woocommerce-loop-product__categories font-size-xs meta-link">%s</span>', implode( ', ', $links  ) ) ));
    }
}


if ( ! function_exists( 'epicjungle_wc_template_loop_product_empty_rating' ) ) {
    function epicjungle_wc_template_loop_product_empty_rating( $html, $rating ) {
        if ( ! ( 0 < $rating ) && post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) {
            $html .= "<span class='star-rating'></span>";
        }

        return $html;
    }
}


if ( ! function_exists( 'epicjungle_wc_template_loop_product_rating' ) ) {
    function epicjungle_wc_template_loop_product_rating() {
        global $product;
        if ( post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) :
            $rating_count  = $product->get_rating_count();
            $review_count  = $product->get_review_count();
            $avg_rating    = $product->get_average_rating();
            ?><?php echo wc_get_rating_html( $product->get_average_rating(), $rating_count ) ?><?php
        endif;        
    }
}


if ( ! function_exists( 'epicjungle_mas_wcvs_loop_variation_enable' ) ) {
    function epicjungle_mas_wcvs_loop_variation_enable() {
        if ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) {
            return false;
        }

        return true;
    }
}