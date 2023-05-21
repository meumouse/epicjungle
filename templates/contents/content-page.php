<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package epicjungle
 */

$additional_class = '';

if ( function_exists( 'is_cart' ) ) {
    if ( is_cart() ) {
        $additional_class .= ' article__cart';
    } elseif ( is_checkout() ) {
        $additional_class .= ' article__checkout';
    }elseif ( is_account_page() ) {
        $additional_class = ' article__myaccount';
    }
} 
$additional_class .= ' article__page container py-4 mb-2 mb-sm-0 pb-sm-5';
do_action( 'epicjungle_before_page' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $additional_class ); ?>>
    <div class="row justify-content-center">
        <div class="col-12"><?php
        
        /**
         * Functions hooked in to epicjungle_page add_action
         *
         * @hooked epicjungle_page_header          - 10
         * @hooked epicjungle_page_content         - 20
         */
        do_action( 'epicjungle_page' );
        
        ?></div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'epicjungle_after_page' ); ?>
