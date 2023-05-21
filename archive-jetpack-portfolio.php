<?php
/**
 * The template for displaying the Portfolio archive page.
 *
 * @package epicjungle
 */

get_header();

    do_action( 'epicjungle_before_portfolio' );
    
    if ( have_posts() ) {
    
        get_template_part( 'loop', 'portfolio' );

    } else {
        
        get_template_part( 'templates/contents/content', 'none' );
    
    }

    do_action( 'epicjungle_after_portfolio' );

get_footer();