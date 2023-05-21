<?php
/**
 * The template for displaying all single posts.
 *
 * @package epicjungle
 */

get_header();

    while ( have_posts() ) :

        the_post();

        do_action( 'epicjungle_single_post_before' );

        get_template_part( 'templates/contents/content', 'single' );

        do_action( 'epicjungle_single_post_after' );

    endwhile; // End of the loop.

get_footer();