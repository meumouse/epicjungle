<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EpicJungle
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}


$sidebar = function_exists( 'epicjungle_posts_sidebar' ) ? epicjungle_posts_sidebar() : 'left-sidebar';

if ( $sidebar === 'left-sidebar') {
  $cs_offcanvas_body_classes ='pl-lg-0 pr-lg-2 pr-xl-4';
  $collapse_wrap_classes ='';
} else {
  $cs_offcanvas_body_classes ='pr-lg-0 pl-lg-2 pl-xl-4';
  $collapse_wrap_classes =' cs-offcanvas-right';
}

?>
<div class="cs-offcanvas-collapse blog-sidebar<?php echo esc_attr( $collapse_wrap_classes ); ?>" id="blog-sidebar">
	<div class="cs-offcanvas-cap navbar-box-shadow px-4 mb-3">
      	<h5 class="mt-1 mb-0"><?php echo esc_html( 'Sidebar', 'epicjungle' ); ?></h5>
      	<button class="close lead" type="button" data-toggle="offcanvas" data-offcanvas-id="blog-sidebar"><span aria-hidden="true">&times;</span></button>
  </div>

  <div class="cs-offcanvas-body px-4 pt-3 pt-lg-0 <?php echo esc_attr( $cs_offcanvas_body_classes );?>" data-simplebar data-simplebar-auto-hide="true">
    	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
  </div>

</div>

