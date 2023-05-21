<?php
/**
 * Navbar Button
 *
 */


if ( 'dark' == epicjungle_navbar_transparent_text_color() ) {
    $navbar_color = 'dark';
} else {
    $navbar_color = 'light';
}

if ( epicjungle_navbar_is_transparent() ) : ?>
	<header class="navbar-button cs-header navbar navbar-expand-lg navbar-<?php echo esc_attr( $navbar_color );?><?php echo epicjungle_navbar_is_sticky() ? ' navbar-sticky' : ''; ?><?php echo epicjungle_navbar_is_transparent() ? ' navbar-floating' : ''; ?>">
<?php else: ?>
	<header class="navbar-button cs-header navbar navbar-expand-lg navbar-<?php echo esc_attr( $navbar_color );?><?php echo epicjungle_navbar_is_sticky() ? ' navbar-sticky' : ''; ?><?php echo epicjungle_navbar_is_transparent() ? ' navbar-floating' : ''; ?><?php echo epicjungle_navbar_button_variant_boxshadow() ? ' navbar-box-shadow' : ''; ?>">
<?php endif; ?>

    <div class="container px-0 px-xl-3">
         <?php do_action( 'epicjungle_navbar_button' ); ?>
    </div>
</header>

