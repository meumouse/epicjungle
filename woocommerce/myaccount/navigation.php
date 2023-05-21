<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

?>

<div class="d-lg-block collapse pb-2" id="account-menu">
	
	 <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<?php if ( $endpoint === 'dashboard' ) : ?>
				<h3 class="d-block bg-secondary font-size-sm font-weight-semibold text-muted mb-0 px-4 py-3"><a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> text-muted"><?php echo esc_html__( 'Dashboard', 'epicjungle'); ?></a></h3>
				
			<?php elseif ( $endpoint === 'orders' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3">
					<i class="fe-shopping-bag font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
					<span class="text-muted font-size-sm font-weight-normal ml-auto"><?php epicjungle_wc_account_orders_count(); ?></span>
				</a>

			<?php elseif ( $endpoint === 'downloads' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-download-cloud font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
					<span class="text-muted font-size-sm font-weight-normal ml-auto"><?php epicjungle_wc_account_downloads_count(); ?></span>
				</a>
	
			<?php elseif ( $endpoint === 'pontos-axis' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-award font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
				</a>

			<?php elseif ( $endpoint === 'edit-address' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-map-pin font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
				</a>
			
			<?php elseif ( $endpoint === 'afiliados' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-users font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
			
			<?php elseif ( $endpoint === 'cupons' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-tag font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
			
			<?php elseif ( $endpoint === 'edit-account' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-user font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
				</a>
				
			<?php elseif ( $endpoint === 'payment-methods' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-credit-card font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
				</a>

			<?php elseif ( $endpoint === 'favoritos' && apply_filters( 'epicjungle_enable_wishlist_endpoint', true ) && function_exists( 'YITH_WCWL' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-heart font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
					<span class="yith_wcwl_count text-muted font-size-sm font-weight-normal ml-auto"><?php echo yith_wcwl_count_products(); ?></span>
				</a>
			
			
			<?php elseif ( $endpoint === 'customer-logout' ) : ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> d-flex align-items-center nav-link-style px-4 py-3 border-top">
					<i class="fe-log-out font-size-lg opacity-60 mr-2"></i>
					<?php echo esc_html( $label ); ?>
				</a>
				
			<?php endif; ?>
		<?php endforeach; ?>
</div>
	

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
