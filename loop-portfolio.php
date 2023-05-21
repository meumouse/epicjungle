<?php
/**
 * The loop template file for post type jetpack-portfolio.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package epicjungle
 */

do_action( 'epicjungle_loop_portfolio_before' );

global $epicjungle_loop_portfolio_index;
$epicjungle_loop_portfolio_index = 0;

while ( have_posts() ) :
    
    the_post();
    /**
     * Include the Post-Format-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
     */
    get_template_part( 'templates/portfolio/content', 'portfolio' );
    $epicjungle_loop_portfolio_index++;

endwhile;

unset( $GLOBALS['epicjungle_loop_portfolio_index'] );

do_action( 'epicjungle_loop_portfolio_after' );