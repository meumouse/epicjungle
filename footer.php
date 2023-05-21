<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package epicjungle
 */

do_action( 'epicjungle_before_footer' ); 

$footer = function_exists( 'epicjungle_footer_variant' ) ? epicjungle_footer_variant() : 'default';
get_template_part( 'templates/footer/footer', $footer );

do_action( 'epicjungle_after_footer' ); 

wp_footer(); 

?></body>
</html>