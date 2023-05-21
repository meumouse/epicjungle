<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section
 *
 * @package epicjungle
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); 

if ( apply_filters( 'epicjungle_page_animation', filter_var( get_theme_mod( 'enable_page_loading_animation', 'yes' ), FILTER_VALIDATE_BOOLEAN ) ) ) { ?>
	<div class="cs-page-loading active">
	    <div class="cs-page-loading-inner">
	        <div class="cs-page-spinner"></div><span><?php echo esc_html__('Loading...', 'epicjungle'); ?></span>
	    </div>
	</div><?php
}

do_action( 'epicjungle_before_canvas' ); 

