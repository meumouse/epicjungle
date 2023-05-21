<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package epicjungle
 */

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
    return;
}


if ( epicjungle_get_product_archive_layout() === 'left-sidebar' ) {
	 $cs_offcanvas_body_classes ='pl-lg-0 pr-lg-2 pr-xl-4';
} else {
  $cs_offcanvas_body_classes ='pr-lg-0 pl-lg-2 pl-xl-4';
}

?><div class="cs-offcanvas-collapse ed-sidebar" id="shop-sidebar">
	<div class="cs-offcanvas-cap navbar-box-shadow px-4 mb-3">
      	<h5 class="mt-1 mb-0"><?php echo esc_html__('Filter products', 'epicjungle') ?>
      	</h5>
      	<button class="close lead" type="button" data-toggle="offcanvas" data-offcanvas-id="shop-sidebar"><span aria-hidden="true">&times;</span></button>
    </div>
   <div class="cs-offcanvas-body px-4 pt-3 pt-lg-0 <?php echo esc_attr( $cs_offcanvas_body_classes );?>" data-simplebar data-simplebar-auto-hide="true">
       	<?php dynamic_sidebar( 'sidebar-shop' ); ?>
    </div>
</div><!-- #cs-sidebar -->
