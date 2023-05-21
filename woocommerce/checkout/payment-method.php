<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="card border-0 box-shadow wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	<div class="card-header p-3">
		<div class="p-1">
			<div class="custom-control custom-radio" data-toggle="collapse" data-target="#payment_method_<?php echo esc_attr( $gateway->id ); ?>" aria-expanded="false">
				<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="custom-control-input input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

				<label class="custom-control-label d-flex align-items-center h6 mb-0" for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
					<?php echo wp_kses_post( $gateway->get_title() ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> <?php echo wp_kses_post( $gateway->get_icon() ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
				</label>

             </div>

		</div>
	</div>

	<div class="collapse<?php if ( $gateway->chosen ) echo esc_attr( ' show' ); ?>" id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" data-parent="#payment-methods" style="">
		<div class="card-body">
			<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
				<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
					<?php $gateway->payment_fields(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
