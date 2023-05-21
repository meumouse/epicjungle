<?php
/**
 * Wishlist page template - Standard Layout
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist                      \YITH_WCWL_Wishlist Current wishlist
 * @var $wishlist_items                array Array of items to show for current page
 * @var $wishlist_token                string Current wishlist token
 * @var $wishlist_id                   int Current wishlist id
 * @var $users_wishlists               array Array of current user wishlists
 * @var $current_page                  int Current page
 * @var $page_links                    array Array of page links
 * @var $is_user_owner                 bool Whether current user is wishlist owner
 * @var $show_price                    bool Whether to show price column
 * @var $show_dateadded                bool Whether to show item date of addition
 * @var $show_stock_status             bool Whether to show product stock status
 * @var $show_add_to_cart              bool Whether to show Add to Cart button
 * @var $show_remove_product           bool Whether to show Remove button
 * @var $show_price_variations         bool Whether to show price variation over time
 * @var $show_variation                bool Whether to show variation attributes when possible
 * @var $show_cb                       bool Whether to show checkbox column
 * @var $show_quantity                 bool Whether to show input quantity or not
 * @var $show_ask_estimate_button      bool Whether to show Ask an Estimate form
 * @var $show_last_column              bool Whether to show last column (calculated basing on previous flags)
 * @var $move_to_another_wishlist      bool Whether to show Move to another wishlist select
 * @var $move_to_another_wishlist_type string Whether to show a select or a popup for wishlist change
 * @var $additional_info               bool Whether to show Additional info textarea in Ask an estimate form
 * @var $price_excl_tax                bool Whether to show price excluding taxes
 * @var $enable_drag_n_drop            bool Whether to enable drag n drop feature
 * @var $repeat_remove_button          bool Whether to repeat remove button in last column
 * @var $available_multi_wishlist      bool Whether multi wishlist is enabled and available
 * @var $no_interactions               bool
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php if ( $wishlist && $wishlist->has_items() ) : ?>
	<div class="shop_table cart wishlist_table wishlist_view traditional responsive row no-gutters mx-n2 mb-4 epicjungle-wishlist mt-3"><?php
		foreach ( $wishlist_items as $item ) :
			$column_count = apply_filters( 'epicjungle_wishlist_column_count' , 'col-md-4 col-sm-6');
			// phpcs:ignore Generic.Commenting.DocComment
			/**
			 * @var $item \YITH_WCWL_Wishlist_Item
			 */
			global $product;

			$product      = $item->get_product();
			$availability = $product->get_availability();
			$stock_status = isset( $availability['class'] ) ? $availability['class'] : false;

			if ( $product && $product->exists() ) :
				?>
				<div class="<?php echo esc_attr( $column_count );?> px-2 mb-3" id="yith-wcwl-row-<?php echo esc_attr( $item->get_product_id() ); ?>" data-row-id="<?php echo esc_attr( $item->get_product_id() ); ?>">
					<div class="card card-product card-hover">
					<?php if ( $show_cb ) : ?>
						<td class="product-checkbox">
							<input type="checkbox" value="yes" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][cb]"/>
						</td>
					<?php endif ?>

					<?php if ( $show_remove_product ) : ?>
						
						<a href="<?php echo esc_url( add_query_arg( 'remove_from_wishlist', $item->get_product_id() ) ); ?>" class="btn-remove remove remove_from_wishlist" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'epicjungle' ) ) ); ?>"><i class="fe-trash-2"></i></a>
							
					<?php endif; ?>

					<?php do_action( 'yith_wcwl_table_before_product_thumbnail', $item, $wishlist ); ?>

					<a class="card-img-top" href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
						<?php echo wp_kses_post( $product->get_image() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>

					<?php do_action( 'yith_wcwl_table_after_product_thumbnail', $item, $wishlist ); ?>	

					<div class="card-body">

						<h3 class="font-size-md font-weight-medium mb-2 product-name">
							<?php do_action( 'yith_wcwl_table_before_product_name', $item, $wishlist ); ?>

							<a class="meta-link" href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>"><?php echo esc_html( apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ); ?></a>

							<?php
							if ( $show_variation && $product->is_type( 'variation' ) ) {
								// phpcs:ignore Generic.Commenting.DocComment
								/**
								 * @var $product \WC_Product_Variation
								 */
								echo wc_get_formatted_variation( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
							?>

							<?php do_action( 'yith_wcwl_table_after_product_name', $item, $wishlist ); ?>
						</h3>

						<?php if ( $show_price || $show_price_variations ) : ?>
							<span class="d-block text-heading font-weight-semibold product-price">
								<?php do_action( 'yith_wcwl_table_before_product_price', $item, $wishlist ); ?>

								<?php
								if ( $show_price ) {
									echo wp_kses_post( $item->get_formatted_product_price() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}

								if ( $show_price_variations ) {
									echo wp_kses_post( $item->get_price_variation() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>

								<?php do_action( 'yith_wcwl_table_after_product_price', $item, $wishlist ); ?>
							</span>
						<?php endif ?>

						<?php if ( $show_quantity ) : ?>
							<div class="product-quantity mt-1">
								<?php do_action( 'yith_wcwl_table_before_product_quantity', $item, $wishlist ); ?>

								<?php if ( ! $no_interactions && $wishlist->current_user_can( 'update_quantity' ) ) : ?>
									<input type="number" min="1" step="1" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][quantity]" value="<?php echo esc_attr( $item->get_quantity() ); ?>"/>
								<?php else : ?>
									<?php echo esc_html( $item->get_quantity() ); ?>
								<?php endif; ?>

								<?php do_action( 'yith_wcwl_table_after_product_quantity', $item, $wishlist ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $show_stock_status ) : ?>
							<div class="product-stock-status mt-1">
								<?php do_action( 'yith_wcwl_table_before_product_stock', $item, $wishlist ); ?>

								<?php echo 'out-of-stock' === $stock_status ? '<span class="wishlist-out-of-stock">' . esc_html( apply_filters( 'yith_wcwl_out_of_stock_label', __( 'Out of stock', 'epicjungle' ) ) ) . '</span>' : '<span class="wishlist-in-stock">' . esc_html( apply_filters( 'yith_wcwl_in_stock_label', __( 'In Stock', 'epicjungle' ) ) ) . '</span>'; ?>

								<?php do_action( 'yith_wcwl_table_after_product_stock', $item, $wishlist ); ?>
							</div>
						<?php endif ?>

						<!-- Date added -->
						<?php if ( $show_dateadded && $item->get_date_added() ) :
								// translators: date added label: 1 date added.
								echo '<span class="dateadded">' . esc_html( sprintf( __( 'Added on: %s', 'epicjungle' ), $item->get_date_added_formatted() ) ) . '</span>';
							endif; ?>

					</div>

					<div class="card-footer d-flex justify-content-end">
						<?php if ( $show_last_column ) : ?>
						
							<!-- Add to cart button -->
							<?php $show_add_to_cart = apply_filters( 'yith_wcwl_table_product_show_add_to_cart', $show_add_to_cart, $item, $wishlist ); ?>
							<?php if ( $show_add_to_cart && isset( $stock_status ) && 'out-of-stock' !== $stock_status ) : ?>
								<?php woocommerce_template_loop_add_to_cart( array( 'quantity' => $show_quantity ? $item->get_quantity() : 1 ) ); ?>
							<?php endif ?>

							<?php do_action( 'yith_wcwl_table_product_after_add_to_cart', $item, $wishlist ); ?>

						<?php endif; ?>

					</div>
					


				</div></div>
			<?php
			endif;
		endforeach; ?>
	</div><?php
else : ?>
		
	<p class="wishlist-empty text-center font-size-lg mt-5"><?php echo esc_html( apply_filters( 'yith_wcwl_no_product_to_remove_message', esc_html__( 'No products added to the wishlist', 'epicjungle' ), $wishlist ) ); ?></p>
		
<?php endif;

if ( ! empty( $page_links ) ) : ?>
	<nav class="pagination-row wishlist-pagination">
		<p><?php echo wp_kses_post( $page_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	</nav>
<?php endif ?>



