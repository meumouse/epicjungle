<?php
/**
 * Navbar Home
 *
 */
$navbar_additional_class = '';

$epicjungle_navbar_skin = function_exists( 'epicjungle_navbar_skin' ) ? epicjungle_navbar_skin() : 'light';
if ( in_array( $epicjungle_navbar_skin, [ 'light', 'secondary' ] ) ) {
	$navbar_additional_class = 'light';
} else {
	$navbar_additional_class = 'dark';
}
?>
<header class="cs-header">
    <?php do_action( 'navbar_shop_topbar' ); ?>
    
    <div class="navbar navbar-expand-lg navbar-<?php echo esc_attr( $navbar_additional_class );?> bg-<?php echo  esc_attr( $epicjungle_navbar_skin ); ?><?php echo epicjungle_navbar_is_sticky() ? ' navbar-sticky' : ''; ?><?php echo epicjungle_navbar_is_boxshadow() ? ' navbar-box-shadow' :'';?>" data-scroll-header>
           <?php do_action( 'epicjungle_before_navbar' ); ?>
          <div class="container px-0 px-xl-3">
             <?php do_action( 'epicjungle_navbar_shop' ); ?>
          </div>
    </div>
</header>

