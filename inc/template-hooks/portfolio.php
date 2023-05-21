<?php
/**
 * Template Hooks for Portfolio
 */

/**
 * Portfolio
 *
 */
add_action( 'epicjungle_before_site',           'epicjungle_page_wrapper_start', 10 );
add_action( 'epicjungle_loop_portfolio_before', 'epicjungle_section_portfolio_content_start', 10 );
add_action( 'epicjungle_loop_portfolio',        'epicjungle_loop_portfolio', 20 );
add_action( 'epicjungle_loop_portfolio_after',  'epicjungle_section_portfolio_content_end', 20 );
add_action( 'epicjungle_loop_portfolio_after',  'epicjungle_portfolio_pagination', 30 );
add_action( 'epicjungle_before_footer',         'epicjungle_page_wrapper_end', 10 );