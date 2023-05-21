<?php
/**
 * The template for displaying product widget as media defined in EpicJungle.
 *
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

?>
<div class="media align-items-center pb-2 mb-1">
    <a class="d-block" href="<?php echo esc_url( $product->get_permalink() ); ?>">
        <?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'rounded' ) ) ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </a>
    <div class="media-body pl-2 ml-1">
        <h4 class="font-size-md nav-heading mb-1"><a class="font-weight-medium" href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h4>
        <p class="font-size-sm mb-0"><?php echo wp_kses_post( $product->get_price_html() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
    </div>
</div>