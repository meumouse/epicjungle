<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products pt-3 pt-md-6 pb-5 mb-3 mb-sm-0 pt-sm-0 pb-sm-6 border-top">
		<div class="container">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'epicjungle' ) );

		if ( $heading ) :
			?>
			<h2 class="h3 text-center mb-5"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; 

		$defaults = apply_filters( 'epicjungle_related_products_carousel_args', array(
	            
	            'carousel_args'     => array(
	            	'infinite'       => true,
	                'items'          => 2,
	                'nav'            => true,
	                'autoplay'       => true,
	                'controls'       => false,
	                'responsive'     => array (
	                   
	                    '0'      => array(
	                        'items'      => 1,
	                        'gutter'    => 16
	                    
	                    ),
	                    
	                    '500'      => array(
	                        'items'      => 2,
	                        'gutter'    => 16
	                        
	                    ),
	                    
	                
	                    '780'      => array(
	                        'items'      => 3,
	                        'gutter'    => 16
	                       
	                    ),
	                    
	                 
	                    '1000'      => array(
	                        'items'      => 4,
	                        'gutter'    => 23
	                        
	                    ),
	                    
                
            		)
	            )
	        ) );

	        $args = wp_parse_args( $args, $defaults );

	        if( is_rtl() ) {
	            $args['carousel_args']['rtl'] = true;
	            if( isset( $args['carousel_args']['prevArrow'] ) && isset( $args['carousel_args']['nextArrow'] ) ) {
	                $carousel_args_temp_arrow = $args['carousel_args']['prevArrow'];
	                $args['carousel_args']['prevArrow'] = $args['carousel_args']['nextArrow'];
	                $args['carousel_args']['nextArrow'] = $carousel_args_temp_arrow;
	            }
	        }

            ?>
            
            <div class="cs-carousel related-product-carousel mb-5">
            	<?php woocommerce_product_loop_start(); ?>
	            <div class="products-carousel-wrap cs-carousel-inner" data-carousel-options="<?php echo esc_attr( json_encode( $args['carousel_args'] ), ENT_QUOTES, 'UTF-8' ); ?>">

					<?php foreach ( $related_products as $related_product ) : ?>
						<div class="pb-2">

							<?php
							$post_object = get_post( $related_product->get_id() );

							setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

							wc_get_template_part( 'content', 'product' );
							?>
						</div>

					<?php endforeach; ?>

				</div>
				<?php woocommerce_product_loop_end(); ?>
			</div>
		</div>
			
	</section>
	<?php
endif;

wp_reset_postdata();
