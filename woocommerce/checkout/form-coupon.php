<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
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

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="row epicjungle-coupon">
	<div class="py-2">
		<div class="font-size-md my-4">
			<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', '<i class="fe-alert-circle font-size-xl mt-n1 mr-2"></i>' . esc_html__( 'Have a coupon code?', 'epicjungle' ) . ' <a href="#modal-coupon" data-toggle="modal" class="alert-link epicjungleshowcoupon">' . esc_html__( 'Click here to enter your code', 'epicjungle' ) . '</a>' ), 'info' ); ?>
		</div>

		<div class="epicjungle-form-coupon modal fade" id="modal-coupon" tabindex="-1">
			 <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
		            <div class="modal-header">
		                <h4 class="modal-title"><?php echo esc_html__( 'Coupon code', 'epicjungle' ); ?></h4>
		                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		            </div>

			      <form class="checkout_coupon woocommerce-form-coupon modal-body" method="post">
			        <p class="span-coupon-body"><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'epicjungle' ); ?></p>
			        <div class="input-group">
		                <input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php esc_attr_e( 'Your coupon code', 'epicjungle' ); ?>" id="coupon_code" value="" />
		                <div class="input-group-append">
		                    <button type="submit" class="button btn btn-primary apply_coupon" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'epicjungle' ); ?>"><?php esc_html_e( 'Apply code', 'epicjungle' ); ?></button>
		                </div>
		            </div>

			        <div class="clear"></div>
			      </form>
			    </div>
			</div>
		</div>
	</div>
</div>








