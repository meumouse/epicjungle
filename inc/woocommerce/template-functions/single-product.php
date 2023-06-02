<?php
/**
 * Template functions used in Single Product
 *
 */

if ( ! function_exists( 'epicjungle_wc_product_remove_sidebar' ) ) {
    function epicjungle_wc_product_remove_sidebar() {
        if ( is_product() ) {
            remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
        }
    }
}


if ( ! function_exists( 'epicjungle_wc_product_wrap_open' ) ) {
    function epicjungle_wc_product_wrap_open() { ?>
    	<section class="cs-sidebar-enabled cs-sidebar-right"><?php
    }
}

if ( ! function_exists( 'epicjungle_wc_product_wrap_close' ) ) {
    function epicjungle_wc_product_wrap_close() { ?>
    	</section><?php
    }
}

if ( ! function_exists( 'epicjungle_wc_product_container_open' ) ) {
    function epicjungle_wc_product_container_open() { ?>
    	<div class="container"><div class="row"><?php
    }
}

if ( ! function_exists( 'epicjungle_wc_product_container_close' ) ) {
    function epicjungle_wc_product_container_close() { ?>
    	</div></div><?php
    }
}

if ( ! function_exists( 'epicjungle_wc_product_images' ) ) {
    function epicjungle_wc_product_images() { 
    	?>
    	<div class="col-lg-8 cs-content py-4">
            <?php do_action('epicjungle_wc_product_left_column'); ?> 
        </div><!--.col--><?php
  
    }
}

/**
 * Product title
 * 
 * @since 1.0.0
 */
function epicjungle_wc_product_title() {

    if ( epicjungle_is_yith_wcwl_activated() ) { ?>
        <div class="product-title">
            <h1 class="mb-3 pb-4"><?php single_post_title(); ?></h1>
        </div>
        <div class="favoritos-single-product">
                <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
        </div><?php
    }
    else { ?>
        <div class="product-title">
            <h1 class="mb-3 pb-4"><?php single_post_title(); ?></h1>
        </div><?php
    }
}
add_action( 'epicjungle_wc_product_left_column', 'epicjungle_wc_product_title', 20 );


if ( ! function_exists( 'epicjungle_wc_product_share_wrap' ) ) {
    function epicjungle_wc_product_share_wrap() {
        if ( ! class_exists( 'EpicJungle_SocialShare' ) ) {
            return;
        } ?>

        <div class="d-flex align-items-center justify-content-center justify-content-md-end py-4 pt-md-0 pt-lg-5">
        <?php epicjungle_share_display(); ?>
        </div><!--.d-flex-->
        <?php
    }
}

if ( ! function_exists( 'epicjungle_wc_product_summary_wrap_open' ) ) {
    function epicjungle_wc_product_summary_wrap_open() { ?>
    	<div class="col-lg-4 cs-sidebar bg-secondary pt-5 pl-lg-4 pb-md-2"><div class="pl-lg-4 pb-5"><?php
    }
}

if ( ! function_exists( 'epicjungle_wc_product_summary_wrap_close' ) ) {
    function epicjungle_wc_product_summary_wrap_close() { ?>
    	</div></div><?php
    }
}

if ( ! function_exists( 'epicjungle_wc_product_rating' ) ) {
    function epicjungle_wc_product_rating() {
   		global $product;
        if ( post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) :
            $rating_count  = $product->get_rating_count();
            $review_count  = $product->get_review_count();
            $avg_rating    = $product->get_average_rating();
            if ( $rating_count > 0 ) : ?>
                <a class="mb-4 d-inline-block text-decoration-none" href="#reviews" rel="nofollow" data-scroll>
                    <?php echo wc_get_rating_html( $product->get_average_rating(), $rating_count ) ?>
                    <span class="text-body font-size-sm">
                        <?php printf( _n( '(%s) based on %s review', '(%s) based on %s reviews', $review_count, 'epicjungle' ), esc_html( $avg_rating ), esc_html( $review_count ) ); ?>
                    </span>
                </a>
            <?php endif; 
        endif; 

    
       
    }
}

if ( ! function_exists( 'epicjungle_wc_template_single_price' ) ) {
    function epicjungle_wc_template_single_price() {
        global $post, $product;
    
        if ( $price_html = $product->get_price_html() ) : ?>
            <div class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
                <?php echo wp_kses_post( $price_html ); ?>
                <?php if ( $product->is_on_sale() ) : ?>
                    <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="badge badge-danger font-size-ms ml-1">' . esc_html_x( 'Sale', 'front-end', 'epicjungle' ) . '</span>', $post, $product ); ?>
                <?php endif; ?>
            </div>
        <?php endif;

    }
}


if ( ! function_exists( 'epicjungle_wc_format_sale_price' ) ) {
    function epicjungle_wc_format_sale_price( $price, $regular_price, $sale_price ) {
        $price = '<del class="font-size-base text-muted mr-1 font-weight-normal">' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del> <ins class="text-decoration-none">' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> ';
        return $price;
    }
}

if( ! function_exists( 'epicjungle_wc_reviews_overall' ) ) {
    function epicjungle_wc_reviews_overall() {
        /** @var WC_Product $product */
        global $product;

        // Count the total number of stars per each rating value (e.g. total number of fives, fours, etc)
        $comments = get_comments( [
            'fields'  => 'ids',
            'post_id' => $product->get_id(),
            'status'  => 'approve',
        ] );

        if ( empty( $comments ) ) {
            return;
        }

        // Count per rating.
        // Create an array with keys from 0 to 5 where each key is rating provided by user.
        // A key 0 will be used for invalid meta and will not be taken into account.
        $cpr = array_fill( 0, 6, 0 );
        foreach ( array_map( 'intval', $comments ) as $comment_ID ) {
            // TODO: may we get rid of get_comment_meta and make this query a little bit more performant?
            $comment_rating = (int) get_comment_meta( $comment_ID, 'rating', true );
            $cpr[ $comment_rating ] ++;
        }
        unset( $comment_ID );

        // Total recommended is a sum of fives and fours
        $total_recommended = $cpr[4] + $cpr[5];

        // A total number of reviews and an average product rating
        $total_reviews = $product->get_review_count();
        $avg_rating    = $product->get_average_rating();

        // With per rating.
        // Count the width of each progress bar for total number of fives, fours, etc.
        $wpr = array_fill( 0, 6, 0 );
        foreach ( $cpr as $k => $v ) {
            $wpr[ $k ] = round( ( $v * 100 ) / $total_reviews );
        }

        ?>
        <div class="row pb-3">
            <div class="col-lg-4 col-md-5">
                <h2 class="h3 mb-4"><?php
                    /* translators: 1: reviews count */
                    $reviews_title = sprintf( esc_html( _n( '%s Review', '%s Reviews', $total_reviews, 'epicjungle' ) ), esc_html( $total_reviews ) );
                    echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $total_reviews, $product ); // WPCS: XSS ok.
                ?></h2>

                <?php echo wc_get_rating_html( $avg_rating ); ?>
               <?php if ( $avg_rating > 0  ) { ?>
                    <span class="text-heading"><?php
                        /* translators: 1: average rating */
                        echo sprintf( esc_html_x( '%s overall rating', 'front-end', 'epicjungle'), esc_html( $avg_rating ) );
                    ?></span>
                <?php } ?>

                <p class="pt-3 font-size-sm text-muted"><?php
                    /* translators: 1: sum of fives and fours, 2: total number of reviews, 3: ratio (in percentage) of recommended to total */
                    echo sprintf( esc_html_x( '%d out of %d (%d%%)', 'front-end', 'epicjungle'),
                        $total_recommended,
                        $total_reviews,
                        round( ( $total_recommended * 100 ) / $total_reviews )
                    );
                ?><br><?php echo esc_html_x( 'customers recommended this product', 'front-end', 'epicjungle' ); ?></p>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="d-flex align-items-center mb-2">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle">5</span>
                        <i class="fe-star font-size-sm ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo absint( $wpr[5] ); ?>%;" aria-valuenow="<?php echo absint( $wpr[5] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="ml-3"><?php echo absint( $cpr[5] ); ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle">4</span>
                        <i class="fe-star font-size-sm ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo absint( $wpr[4] ); ?>%; background-color: #a7e453;" aria-valuenow="<?php echo absint( $wpr[4] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="ml-3"><?php echo absint( $cpr[4] ); ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle">3</span>
                        <i class="fe-star font-size-sm ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo absint( $wpr[3] ); ?>%; background-color: #ffda75;" aria-valuenow="<?php echo absint( $wpr[3] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="ml-3"><?php echo absint( $cpr[3] ); ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle">2</span>
                        <i class="fe-star font-size-sm ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo absint( $wpr[2] ); ?>%; background-color: #fea569;" aria-valuenow="<?php echo absint( $wpr[2] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="ml-3"><?php echo absint( $cpr[2] ); ?></span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle">1</span>
                        <i class="fe-star font-size-sm ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo absint( $wpr[1] ); ?>%;" aria-valuenow="<?php echo absint( $wpr[1] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="ml-3"><?php echo absint( $cpr[1] ); ?></span>
                </div>
            </div>
        </div>
        <hr class="mt-4 pb-4 mb-3">
        <?php
    }
}

if( ! function_exists( 'epicjungle_wc_review_before' ) ) {
    function epicjungle_wc_review_before( $comment ) {
        $verified = wc_review_is_from_verified_owner( $comment->comment_ID );
        $rating   = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

        ?>
        <div class="d-flex align-items-center mb-2 pb-1">
            <?php if ( $rating && wc_review_ratings_enabled() ) :
                echo wc_get_rating_html( $rating ); // WPCS: XSS ok.
            endif; ?>
        </div>
        <?php echo epicjungle_wc_review( $comment ); ?>

        <div class="d-flex align-items-center justify-content-between">
            <div class="media media-ie-fix align-items-center mr-3">
                <?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', 42 ), '', get_comment_author( $comment ), [
                    'class' => 'rounded-circle',
                ] ); ?>

                <div class="media-body pl-2 ml-1">
                    <h6 class="font-size-sm mb-n1">
                        <?php comment_author( $comment ); ?>
                        <?php if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) : ?>
                            <i class="czi-check-circle ml-2 mt-n1 font-size-base align-middle text-success" data-toggle="tooltip" data-original-title="<?php echo esc_attr__( 'verified owner', 'epicjungle' ); ?>"></i>
                        <?php endif; ?>
                    </h6>
                    <span class="font-size-xs text-muted"><?php echo esc_html( get_comment_date( wc_date_format(), $comment ) ); ?></span>
                </div>
            </div>
        </div>

        <?php
    }
}

 
if( ! function_exists( 'epicjungle_wc_review' ) ) {
    function epicjungle_wc_review( $comment ) {
        ?>
        <div class="font-size-md">
            <?php if ( '0' === $comment->comment_approved ) : ?>
                <em class="woocommerce-review__awaiting-approval">
                    <?php esc_html_e( 'Your review is awaiting approval', 'epicjungle' ); ?>
                </em>
            <?php else : ?>
                <?php comment_text( $comment ); ?>
            <?php endif; ?>
        </div>
        <?php
    }
}

/**
 * Output product reviews
 *
 * @hooked woocommerce_after_single_product_summary 240
 *
 * @since 1.0.0
 */
if( ! function_exists( 'epicjungle_wc_reviews' ) ) {
    function epicjungle_wc_reviews() {
        if ( ! comments_open() ) {
            return;
        }

        comments_template();
    }
}

/**
 * Output the product description
 *
 * @hooked woocommerce_after_single_product_summary 220
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'epicjungle_wc_product_description' ) ) {
    function epicjungle_wc_product_description() {
       if( get_the_content() ) { ?>
            <section class="pt-3 pt-md-6 pb-5 pb-md-6 border-top epicjungle-wc-product-tabs" id="more-info">
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </section>
            <?php
        }
    }
}

if ( ! function_exists( 'epicjungle_output_related_products' ) ) {
    function epicjungle_output_related_products() {
        if ( apply_filters( 'epicjungle_enable_related_products', get_theme_mod( 'enable_related_products', 'yes' ) ) ) {
            woocommerce_output_related_products();
        }
    }
}

if ( ! function_exists( 'epicjungle_output_related_products_args' ) ) {
    function epicjungle_output_related_products_args( $args ) {

        $args = array(
            'posts_per_page' => 8,
            'columns'        => apply_filters( 'epicjungle_related_products_columns', 4 )
        );
        return $args;
    }
}


if ( ! function_exists( 'epicjungle_single_product_size_cart' ) ) {
    function epicjungle_single_product_size_cart() {
        global $product;
        $product_id = $product->get_id();

        $sizeguide = get_post_meta( $product_id, '_sizeguide', true );

        $size_guide_link = apply_filters( 'epicjungle_single_product_size_guide_link', '#' );
        $size_guide_icon = apply_filters( 'epicjungle_single_product_size_guide_icon', 'la la-info-circle' );
        $size_guide_text = apply_filters( 'epicjungle_single_product_size_guide_link', esc_html__( 'Size Guide', 'epicjungle' ) );

        if ( $product && ! empty( $sizeguide ) ) {
        ?>
            <div class="size-guid-wrapper" data-toggle="modal" data-target="#size-guid-<?php echo esc_attr( $product_id ); ?>">
                <a class="nav-link-style font-size-sm size-guid-link" href="<?php echo esc_url( $size_guide_link  ); ?>">
                    <i class="<?php echo esc_attr( $size_guide_icon ); ?>"></i>
                    <span class="size-guide-text"><?php echo esc_html( $size_guide_text ); ?></span>
                </a>
            </div>
           
            <div class="size-guid-inner modal fade" id="size-guid-<?php echo esc_attr( $product_id ); ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="la la-close"></i></span></button>
                        </div>
                        <div class="modal-body"><?php
                            echo wp_kses_post( $sizeguide );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
        <?php
        }
    }
}

if ( ! function_exists( 'epicjungle_wc_product_information_tab' ) ) {
    function epicjungle_wc_product_information_tab() { ?>
         <section class="pt-3 pt-md-6 pb-5 pb-md-6 border-top epicjungle-wc-product-tabs" id="more-info">
            <div class="container">
                <?php woocommerce_product_additional_information_tab(); ?>
            </div>
        </section><?php

    }
}

/**
 * Buy now button
 * 
 * @since 1.3.0
 */
function epicjungle_wc_add_buy_now_button_single() {
    global $product;

    if( is_product() && 'yes' == get_option('ej_display_buy_now','yes') ){ ?>
        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" id="epicjungle_buy_now" class="btn btn-primary m-0 ej_buy_now_button button alt w-100">
            <i id="icon-buy-now-button" class="fe-shopping-cart mr-2"></i>
            <span id="span-buy-now-button" class="text-buy-now"><?php echo __( 'Comprar agora', 'epicjungle' ); ?></span>
            <span id="preloader-buy-now-button" class="spinner-border spinner-border-md d-none"></span>
            </button>
        <input type="hidden" name="is_buy_now" id="is_buy_now" value="0" /> <?php
    }
}
add_action('woocommerce_after_add_to_cart_button', 'epicjungle_wc_add_buy_now_button_single');

function buy_now_submit_form(){
?>
<script>
   jQuery(document).ready(function(){
    jQuery('#is_buy_now') . val('0');
    jQuery('#epicjungle_buy_now').click(function(){
    jQuery('#is_buy_now').val('1');
    jQuery('form.cart').submit();
   });
});
</script>
 <?php
}
add_action('woocommerce_after_add_to_cart_form', 'buy_now_submit_form');

add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout( $redirect_url ){
    if ( isset($_POST['is_buy_now']) && $_POST['is_buy_now'] ) {
        global $woocommerce;
        
        $redirect_url = wc_get_cart_url();
    }
    return $redirect_url;
}

function display_css_buy_now() {
    if( is_product() && 'yes' == get_option('ej_display_buy_now','yes') ) {
        ?>
        <style type="text/css">
            #epicjungle_buy_now {
                order: 1;
            }
            
            .product-quantity-group {
                margin-top: 1.85rem;
                order: 2;
            }
        </style> <?php
    }
}
add_action( 'wp_head', 'display_css_buy_now' );

/**
 * Info return and warranty in single product page
 * 
 * @since 1.7.0
 */
function epicjungle_warranty_and_returns_single_product() {
    $term_warranty = get_option( 'ejsp_warranty_single_product' );
    $term_return = get_option( 'ejsp_return_single_product' );

    if( is_product() && 'yes' == get_option('ejsp_show_warranty_term', 'yes') ){
        echo '<div id="epicjungle-warranty-container" class="mt-3">
            <span id="epicjungle-warranty-product" class="font-size-ms">
            <i class="fe-check-circle mr-1"></i>Garantia de '.$term_warranty.' direto em nossa loja</span>
        </div>';
    }

    if( is_product() && 'yes' == get_option('ejsp_show_return_term', 'yes') ){
        echo '<div id="epicjungle-return-container" class="mb-3">
            <span id="epicjungle-return-product" class="font-size-ms">
            <i class="fe-rotate-ccw mr-1"></i>'.$term_return.' para trocas e devoluções</span>
        </div>';
    }
}

add_action( 'woocommerce_product_meta_start', 'epicjungle_warranty_and_returns_single_product', 20 );


/**
 * Display sales product
 * 
 * @since 1.0.0
 */
function epicjungle_display_sales_single_product() {
    global $product;
    $units_sold = $product->get_total_sales();

    if( is_product() && 'yes' == get_option('ej_display_sale_badge','yes') ) {
        echo '<p class="qtd-vendida badge bg-primary font-size-sm"><i class="fe-package mr-1"></i>' . sprintf( __( 'Vendidos: %s', 'woocommerce' ), $units_sold ) . '</p>';
    }
}
add_action( 'woocommerce_single_product_summary', 'epicjungle_display_sales_single_product', 5 );

/**
 * Enable add to cart for simple products
 * 
 * @since 1.7.0
 */
function epicjungle_enable_add_to_cart() {
   global $product;

   if ( $product->is_type( 'simple' ) ) {
      wc_enqueue_js( "$('#epicjungle_buy_now').attr('disabled', false );
      $('#epicjungle-add-to-cart').attr('disabled', false );" );
   }
}
add_action( 'woocommerce_before_add_to_cart_quantity', 'epicjungle_enable_add_to_cart' );
