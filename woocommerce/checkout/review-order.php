<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table">
	<div class="widget widget_products">
		<ul class="product_list_widget">
			<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

					$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					?>
					<li class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item media align-items-center mb-4', $cart_item, $cart_item_key ) ); ?>">
						<?php echo sprintf( '<a href="%s" class="widget-product-thumb d-block">%s</a>', $product_permalink ? esc_url( $product_permalink ) : '#', $thumbnail ); // PHPCS: XSS ok.?>
						<div class="media-body pl-2 ml-1">
							<div class="d-flex align-items-center justify-content-between">
								<div class="mr-3">

									<h4 class="widget-product-title nav-heading font-size-md mb-1">
										<?php
										echo sprintf( '<a class="font-weight-medium" href="%1$s">%2$s</a>',  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											$product_permalink ? esc_url( $product_permalink ) : '#',
											apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key )
										); ?>
									</h4>

									<div class="d-flex align-items-center font-size-sm">
										<span class="mr-2"><?php echo wp_kses_post( $product_price ); ?></span>
										<span class="mr-2"><?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', sprintf( '&times; %s', $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div>

									<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>

							</div>
						</div>
					</li>

					<?php
					endif;
				endforeach;
				do_action( 'woocommerce_review_order_after_cart_contents' );
			?>
		</ul>
	</div>

	<hr class="mb-4">

	<div class="cart-subtotal d-flex justify-content-between mb-3">
		<span class="h6 mb-0"><?php esc_html_e( 'Subtotal:', 'epicjungle' ); ?></span>
		<span class="text-nav"><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>	

	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<div class="d-flex justify-content-between mb-3 cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
			<span class="h6 mb-0"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
			<span class="text-nav"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
		</div>
	<?php endforeach; ?>
	

		
	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

		<?php wc_cart_totals_shipping_html(); ?>

		<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

	<?php endif; ?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<div class="fee d-flex justify-content-between mb-3">
			<span class="h6 mb-0"><?php echo esc_html( $fee->name ); ?></span>
			<span class="text-nav"><?php wc_cart_totals_fee_html( $fee ); ?></span>
		</div>
	<?php endforeach; ?>

	<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
		<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
			<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
				<div class="d-flex justify-content-between mb-3 tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<span class="h6 mb-0"><?php echo esc_html( $tax->label ); ?></span>
					<span class="text-nav"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="tax-total d-flex justify-content-between mb-3">
				<span class="h6 mb-0"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
				<span class="text-nav"><?php wc_cart_totals_taxes_total_html(); ?></span>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

	<div class="order-total text-center border-top pt-4 mt-4 mb-2">
		<h3 class="font-weight-normal mb-0"><?php wc_cart_totals_order_total_html(); ?></h3>
	</div>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</div>