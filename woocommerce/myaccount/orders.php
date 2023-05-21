<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

<div class="accordion" id="orders-accordion">
	<table class="border-0 mb-0 woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr class="card d-none">
				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php
			foreach ( $customer_orders->orders as $key =>  $customer_order ) {

				$uniqueid   = uniqid(); 
				$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$item_count = $order->get_item_count() - $order->get_item_count_refunded();
				?>

				<tr class="card-heading px-4 py-3 collapsed d-flex flex-wrap align-items-center justify-content-between border rounded-lg woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order<?php if ( $key !== 0 ) echo esc_attr( ' mt-3' ); ?>" data-toggle="collapse" aria-expanded="true" aria-controls="order-<?php echo esc_attr( $uniqueid );?>" data-target="#order-<?php echo esc_attr( $uniqueid );?>">

					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<?php 
							$text_color = '';
							$bg_color = '';
							switch ($order->get_status()){
								case 'on-hold':
								case 'pending':
								$bg_color = 'bg-faded-info';
								$text_color = 'text-info';
								break; 
								case 'completed':
								case 'processing':
								case 'pedido-enviado':
								$bg_color = 'bg-faded-success';
								$text_color = 'text-success';
								break;
								case 'cancelled':
								case 'refunded':
								case 'failed':
								$bg_color = 'bg-faded-danger';
								$text_color = 'text-danger';
								break;
							}
						?>

						<td class="p-0 border-0 woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								<div class="d-block my-1 mr-2">
									<i class="fe-hash font-size-base mr-1"></i><span class="order-number font-size-sm font-weight-medium text-nowrap d-inline-block align-middle"><?php echo esc_html( $order->get_order_number() ); ?></span>
									
								</div>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<div class="text-nowrap text-body font-size-sm font-weight-normal my-1 mr-2">
									<i class="fe-clock text-muted mr-1"></i><time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
								</div>

							<?php elseif ( 'order-status' === $column_id ) : ?>
								<div class="font-size-xs font-weight-medium py-1 px-3 rounded-sm my-1 mr-2 <?php echo esc_attr( $bg_color );?> <?php echo esc_attr( $text_color ); ?>">
									<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
								</div>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<div class="text-body font-size-sm font-weight-medium my-1">
									<?php
									/* translators: 1: formatted order total 2: total order items */
									echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'epicjungle' ), $order->get_formatted_order_total(), $item_count ) );
									?>
								</div>

							<?php elseif ( 'order-actions' === $column_id ) : ?>
							<?php
							$actions = wc_get_account_orders_actions( $order );

							if ( ! empty( $actions ) ) {
								foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
									echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
								}
							}
							?>
						<?php endif; ?>

						</td>
						
					<?php endforeach; ?>
				</tr>

				<tr class="collapse border-0" id="order-<?php echo esc_attr( $uniqueid );?>" data-parent="#orders-accordion">
					<td class="p-0 border-0">
						<div class="card-body pt-4 border bg-secondary">
							<?php $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) ); ?>


							<?php foreach ( $order_items as $item_id => $item ) {
								$product           = $item->get_product(); 
								$product_image_id  = $product->get_image_id();
								$is_visible        = $product && $product->is_visible();
								$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

								$qty          = $item->get_quantity();
								$refunded_qty = $order->get_qty_refunded_for_item( $item_id );
								

								if ( $refunded_qty ) {
									$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
								} else {
									$qty_display = esc_html( $qty );
								}

							?>

								<div class="woocommerce-order-details d-sm-flex justify-content-between mb-3 pb-1">

									<div class="order-item media media-ie-fix d-block d-sm-flex mr-sm-3">
										
										<a class="d-table mx-auto" href="<?php echo esc_url( $product_permalink ); ?>">
											<?php echo wp_get_attachment_image( $product_image_id, array( '105', '105' ), '', array( 'class' => 'd-block rounded' ) ); ?>
										</a>

										<div class="media-body font-size-sm pt-2 pl-sm-3 text-center text-sm-left">
											<h5 class="nav-heading font-size-sm mb-2">
												<?php echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible ); // phpcs:ignore ?>
											</h5>
										</div>
									</div>

									<div class="font-size-sm text-center pt-2 mr-sm-3">
										<div class="text-muted"><?php echo esc_html__( 'Quantity:', 'epicjungle' ); ?></div>
										<?php echo apply_filters( 'woocommerce_order_item_quantity_html', '<div class="font-weight-medium">' . sprintf( '%s', $qty_display ) . '</div>', $item ); ?>
									</div>

									<div class="font-size-sm text-center pt-2">
										<div class="text-muted"><?php echo esc_html__( 'Subtotal:', 'epicjungle' ); ?></div>
										<div class="font-weight-medium"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
									</div>

									<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
								</div>
							<?php } ?>

							<div class="d-flex flex-wrap align-items-center justify-content-between pt-3 border-top">
								<?php foreach ( $order->get_order_item_totals() as $key => $total ) { ?>
									<div class="font-size-sm my-2 mr-2">
										<span class="text-muted mr-1"><?php echo esc_html( $total['label'] ); ?></span>
										<span class="font-weight-medium"><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); 
										//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</div><?php
								} ?>
								
							</div>

						</td>
					</tr>
				
				<?php
			}
			?>
		</tbody>
	</table>
</div>


<nav class="d-md-flex justify-content-end pt-grid-gutter">
	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( apply_filters( ' epicjungle_showing_order_result_count', false ) ): ?>
		<div class="d-md-flex align-items-center w-100">
			<?php
			$per_page = function_exists( 'epicjungle_get_woocommerce_my_account_orders_limit' ) ? epicjungle_get_woocommerce_my_account_orders_limit() : 5;
			$current_page_orders = count( $customer_orders->orders );
			$total = $customer_orders->total;
			$max_num_pages = $customer_orders->max_num_pages; ?>

			<span class="font-size-sm text-muted mr-md-3">
				<?php

				// phpcs:disable WordPress.Security
				if ( 1 === intval( $total ) ) {
					_e( 'Showing the single order', 'epicjungle' );
				} elseif ( $max_num_pages === 1 ) {
					/* translators: %d: total results */
					printf( _n( 'Showing all %d order', 'Showing all %d orders', $total, 'epicjungle' ), $total );
				} else {
					$first = ( $per_page * $current_page ) - $per_page + 1;
					$last  = min( $total, $per_page * $current_page );
					if( $first === $last ) {
						/* translators: 1: first result 2: last result 3: total results */
						printf( _nx( 'Showing %1$d of %2$d order', 'Showing %1$d of %2$d order', $total, 'with first and last order', 'epicjungle' ), $first, $total );
					} else {
						/* translators: 1: first result 2: last result 3: total results */
						printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d order', 'Showing %1$d&ndash;%2$d of %3$d orders', $total, 'with first and last order', 'epicjungle' ), $first, $last, $total );
					}
				}
				// phpcs:enable WordPress.Security
				?>
			</span>

			<?php $percentage = ( $current_page_orders / $total * 100 ); ?>
			<div class="progress w-100 my-3 mx-auto mx-md-0" style="max-width: 10rem; height: 4px;">
				<div class="progress-bar" role="progressbar" style="width: <?php echo esc_attr( $percentage ); ?>%;" aria-valuenow="<?php echo esc_attr( $percentage ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="order-pagination woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="btn btn-outline-primary btn-sm woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php echo apply_filters( 'epicjungle_button_prev_text', esc_html__( 'Load Previous Orders', 'epicjungle' ) ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="btn btn-outline-primary btn-sm woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php echo apply_filters( 'epicjungle_button_next_text', esc_html__( 'Load More Orders', 'epicjungle' ) ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php else : ?>
		<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
			<a class="woocommerce-Button btn btn-primary mr-3" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'epicjungle' ); ?></a>
			<?php esc_html_e( 'No order has been made yet.', 'epicjungle' ); ?>
		</div>
	<?php endif; ?>
	<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
</nav>
