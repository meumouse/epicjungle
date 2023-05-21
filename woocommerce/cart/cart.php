<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.4.0
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="cs-sidebar-enabled cs-sidebar-right">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 cs-content pt-4 pb-6">
				<div id="epicjungle-cart-notices" class="position-absolute">
					<?php do_action( 'woocommerce_before_cart' ); ?>
				</div>

				<?php epicjungle_breadcrumb(); ?>
				<?php epicjungle_page_header(); ?>

				<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
					<?php do_action( 'woocommerce_before_cart_table' ); ?>

					<div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">

						<?php do_action( 'woocommerce_before_cart_contents' ); ?>

						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
								
								<div class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item d-sm-flex justify-content-between align-items-center my-4 pb-3 border-bottom', $cart_item, $cart_item_key ) ); ?>">
									<div class="media d-block d-sm-flex align-items-center text-center text-sm-left">
										<div class="product-thumbnail d-inline-block mx-auto mr-sm-4 mb-2 mb-sm-0" style="width: 10rem;">
											<?php
											$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

											if ( ! $product_permalink ) {
												echo wp_kses_post( $thumbnail ); // PHPCS: XSS ok.
											} else {
												printf( '<a href="%s" class="d-block">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
											}
											?>
										</div>

										<div class="media-body">
											<div class="product-name nav-heading mb-2" data-title="<?php esc_attr_e( 'Product', 'epicjungle' ); ?>">
												<?php
												if ( ! $product_permalink ) {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
												} else {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
												}

												do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

												// Meta data.
												echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

												// Backorder notification.
												if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'epicjungle' ) . '</p>', $product_id ) );
												}
												?>
											</div>
											
											<div class="product-price font-size-base text-accent mb-2 mb-sm-0" data-title="<?php esc_attr_e( 'Price', 'epicjungle' ); ?>">
												<?php
													echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
												?>
											</div>

										</div>
									</div>

									<div class="pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="width: 9rem;">
										<div class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'epicjungle' ); ?>">
											<?php
											if ( $_product->is_sold_individually() ) {
												$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
											} else {
												$product_quantity = woocommerce_quantity_input(
													array(
														'input_name'   => "cart[{$cart_item_key}][qty]",
														'input_value'  => $cart_item['quantity'],
														'max_value'    => $_product->get_max_purchase_quantity(),
														'min_value'    => '0',
														'product_name' => $_product->get_name(),
													),
													$_product,
													false
												);
											}

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
											?>
										</div>

										<div class="product-remove">
												<?php
												echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													'woocommerce_cart_item_remove_link',
													sprintf(
														'<a href="%s" class="remove btn btn-link px-0 text-danger" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fe-x-circle mr-2"></i><span class="font-size-sm">%s</span></a>',
														esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
														esc_html__( 'Remove this item', 'epicjungle' ),
														esc_attr( $product_id ),
														esc_attr( $_product->get_sku() ),
														esc_html_x( 'Remove', 'front-end', 'epicjungle' )
													),
													$cart_item_key
												);
												?>
											</div>
									</div>
								</div>
								<?php
							}
						}
						?>

						<?php do_action( 'woocommerce_cart_contents' ); ?>

						<div class="actions row">
							<?php if ( wc_coupons_enabled() ) : ?>
								<div class="col-md-6 mb-3">
									<div class="cz-coupon-form mr-4 input-group">
										<input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'epicjungle' ); ?>">
										<div class="input-group-append">
											<button type="submit" class="btn btn-outline-primary" name="apply_coupon"><?php esc_html_e( 'Apply coupon', 'epicjungle' ); ?></button>
										</div>
										<?php do_action( 'woocommerce_cart_coupon' ); ?>
									</div>
								</div>
							<?php endif; ?>

							<div class="ej-update-cart col-md-6 mb-3 d-none">
								<button type="submit" class="btn btn-secondary btn-block" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'epicjungle' ); ?>">
									<i class="fe-refresh-cw font-size-base mr-2"></i>
									<?php esc_html_e( 'Update cart', 'epicjungle' ); ?>
								</button>
							</div>

							<?php do_action( 'woocommerce_cart_actions' ); ?>

	                    	<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
						</div>

						<?php do_action( 'woocommerce_after_cart_contents' ); ?>

					</div>

					<?php do_action( 'woocommerce_after_cart_table' ); ?>
				</form>

				<?php do_action( 'epicjungle_after_cart_form' ); ?>
			</div>

			<div class="col-lg-4 cs-sidebar bg-secondary pt-5 pl-lg-4 pb-md-2">
				<div class="pl-lg-4 mb-3 pb-5">
					<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

					<div class="cart-collaterals">
						<?php
							/**
							 * Cart collaterals hook.
							 *
							 * @hooked woocommerce_cross_sell_display
							 * @hooked woocommerce_cart_totals - 10
							 */
							do_action( 'woocommerce_cart_collaterals' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?php do_action( 'woocommerce_after_cart' ); ?>
