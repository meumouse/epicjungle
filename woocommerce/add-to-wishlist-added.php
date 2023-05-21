<?php
/**
 * Add to wishlist button template - Added to list
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist_url string Url to wishlist page
 * @var $exists bool Whether current product is already in wishlist
 * @var $show_exists bool Whether to show already in wishlist link on multi wishlist
 * @var $product_id int Current product id
 * @var $product_type string Current product type
 * @var $label string Button label
 * @var $browse_wishlist_text string Browse wishlist text
 * @var $already_in_wishslist_text string Already in wishlist text
 * @var $product_added_text string Product added text
 * @var $icon string Icon for Add to Wishlist button
 * @var $link_classes string Classed for Add to Wishlist button
 * @var $available_multi_wishlist bool Whether add to wishlist is available or not
 * @var $disable_wishlist bool Whether wishlist is disabled or not
 * @var $template_part string Template part
 * @var $loop_position string Loop position
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;
$icon = '<i class="fas fa-heart"></i>';
?>
<script src="https://kit.fontawesome.com/f6bf37e2e4.js" crossorigin="anonymous"></script>
<!-- ADDED TO WISHLIST MESSAGE -->

<button type="button" class="btn btn-primary rounded-pill btn-icon" id="yith-wcwl-wishlistaddedbrowse" data-toggle="tooltip" data-placement="bottom" title="Remover dos favoritos">
    <span class="feedback sr-only">
        <?php echo wp_kses_post( $icon ); ?>
    </span>
	<a href="<?php echo esc_url( $wishlist_url )?>" rel="nofollow">
		<?php //echo wp_kses_post( ( ! $is_single && 'before_image' == $loop_position ) ? $icon : false ); ?>
		<?php echo wp_kses_post( $icon ); ?>
	</a>
</button>