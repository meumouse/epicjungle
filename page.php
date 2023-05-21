<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package epicjungle
 */

get_header();

    while ( have_posts() ) :
        
        the_post();

        do_action( 'epicjungle_page_before' );

        get_template_part( 'templates/contents/content', 'page' );

        /**
         * Functions hooked in to epicjungle_page_after action
         *
         * @hooked epicjungle_display_comments - 10
         */
        do_action( 'epicjungle_page_after' );

    endwhile; // End of the loop.

get_footer();
