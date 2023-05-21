<?php
/**
 * epicjungle WooCommerce functions.
 *
 * @package epicjungle
 */

/**
 * Checks if the current page is a product archive
 *
 * @return boolean
 */
if ( ! function_exists( 'epicjungle_is_product_archive' ) ) {
    function epicjungle_is_product_archive() {
        if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
            return true;
        } else {
            return false;
        }
    }
}


// if ( ! function_exists( 'epicjungle_get_product_archive_layout' ) ) {
//     function epicjungle_get_product_archive_layout() {
//         $layout = '';
//         $is_brand = false;

//         if ( class_exists( 'Mas_WC_Brands' ) ) {
//             global $mas_wc_brands;
//             $brand_taxonomy = $mas_wc_brands->get_brand_taxonomy();
//             if ( is_tax ( $brand_taxonomy ) && is_product_taxonomy() ) {
//                 $is_brand = true;
//             }  
//         }

//          if ( epicjungle_is_product_archive() && ! $is_brand ) {
//             if ( !is_active_sidebar( 'sidebar-shop' )  ) {
//                 $layout = 'full-width';
//             } else {
//                 $layout = apply_filters( 'epicjungle_product_archive_layout', get_theme_mod( 'product_archive_layout', 'left-sidebar' ) );
//             }    
//         }
//         return $layout;
//     }
// }

/**
 * Returns if a sidebar for Shop is available or not
 */
if( ! function_exists( 'epicjungle_shop_has_sidebar' ) ) {
    function epicjungle_shop_has_sidebar() {
        $layout = epicjungle_get_product_archive_layout();

        return $layout !== 'full-width';
    }
}

/**
 * Returns the sidebar of shop page chosen by user
 */
if( ! function_exists( 'epicjungle_get_product_archive_layout' ) ) {
    function epicjungle_get_product_archive_layout() {

    $available_sidebars = array( 'left-sidebar', 'right-sidebar', 'full-width' );
    if ( epicjungle_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) ) {
        if( is_active_sidebar( 'sidebar-shop' ) ) {
            $sidebar = get_theme_mod( 'product_archive_layout', 'left-sidebar' );
        } else {
            $sidebar = 'full-width';
        }
    } else {
        $sidebar = 'left-sidebar';
    }

    if ( ! in_array( $sidebar, $available_sidebars ) ) {
        $sidebar = 'right-sidebar';
    }

    return sanitize_key( apply_filters( 'epicjungle_shop_sidebar', $sidebar ) );

    }
}


if ( ! function_exists( 'epicjungle_product_archive_has_sidebar' ) ) {
    function epicjungle_product_archive_has_sidebar() {
        $layout = epicjungle_get_product_archive_layout();
        return ( 'left-sidebar' === $layout || 'right-sidebar' === $layout );
    }
}



if ( ! function_exists( 'epicjungle_wc_handheld_toolbar_toggle_shop_sidebar' ) ) {
    function epicjungle_wc_handheld_toolbar_toggle_shop_sidebar() {

        if ( ( is_shop() || is_product_taxonomy() ) && ( is_active_sidebar( 'sidebar-shop' ) ) )  : ?>
            <button class="btn btn-primary btn-sm cs-sidebar-toggle" type="button" data-toggle="offcanvas" data-offcanvas-id="shop-sidebar">
                <i class="fe-filter font-size-base mr-2"></i>
                <?php echo esc_html_x( 'Filters', 'front-end', 'epicjungle' ); ?>
            </button>
        <?php
        endif;
    }
}
