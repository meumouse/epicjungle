<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EpicJungle
 */

get_header();

/**
 * Fires at the most top of the archive page content
 *
 * Note: at this moment we don't know whether we have posts or not.
 */
do_action( 'epicjungle_archive_before' );

if ( have_posts() ) {
	
    do_action( 'epicjungle_archive_loop_before' );

	get_template_part( 'templates/blog/loop', '' );
	
	do_action( 'epicjungle_archive_loop_after' );

} else {
    
    get_template_part( 'templates/contents/content', 'none' );
	
}

/**
 * Fires at the most bottom of the archive page content
 *
 * This action doesn't consider where we have posts or not.
 */
do_action( 'epicjungle_archive_after' );

get_footer();
