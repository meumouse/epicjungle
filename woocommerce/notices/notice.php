<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/notice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! $notices ) {
    return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="alert alert-info alert-with-icon alert-dismissible fade show box-shadow d-flex" role="alert">
		<div class="alert-icon-box mr-2">
			<i class="fe-alert-circle"></i>
		</div>
		<button type="button" class="close" data-dismiss="alert" aria-label="<?php echo esc_html_x( 'Fechar', 'front-end', 'epicjungle' ); ?>">
			<span aria-hidden="true">&times;</span>
		</button>
		<span class="font-size-ms mt-1 woocommerce-info"<?php echo wc_get_notice_data_attr( $notice ); ?>>
			<?php echo wc_kses_notice( $notice['notice'] ); ?>
		</span>
	</div>
<?php endforeach; ?>