<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'epicjungle' ) : esc_html__( 'Shipping address', 'epicjungle' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<form method="post">

<script type="text/javascript" src="/wp-content/themes/epicjungle/assets/js/jquery.mask.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function( $ ) {


$("#billing_cpf").mask("000.000.000-00");
$("#billing_phone").mask("(99) 99999-9999");
$("#shipping_postcode").mask("00000-000");
});
</script>

		<h3 class="h4 pb-3"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h3><?php // @codingStandardsIgnoreLine ?>

		<div class="woocommerce-address-fields">
			<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

			<div class="woocommerce-address-fields__field-wrapper row">
				<?php
				foreach ( $address as $key => $field ) {
					woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
				}
				?>
			</div>

			<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>


			<div class="button-group pt-2">
				<hr class="mb-4">
				<div class="d-flex flex-wrap justify-content-end align-items-center">
					<button type="submit" class="btn btn-primary" name="save_address" value="<?php esc_attr_e( 'Save address', 'epicjungle' ); ?>"><i class="fe-save font-size-lg mr-2"></i><?php esc_html_e( 'Save address', 'epicjungle' ); ?></button>
					<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
					<input type="hidden" name="action" value="edit_address" />
				</div>
			</div>
		</div>

	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
