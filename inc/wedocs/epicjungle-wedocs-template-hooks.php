<?php
/**
 * EpicDrop WeDocs Hooks
 *
 * @package EpicDrop/WeDocs
 */

remove_action( 'wedocs_before_main_content', 'wedocs_template_wrapper_start', 10 );
remove_action( 'wedocs_after_main_content', 'wedocs_template_wrapper_end', 10 );
add_action( 'epicjungle_wedocs_entry_footer', 'ej_wedocs_submit_request_modal_single_doc', 20 );
add_action( 'epicjungle_wedocs_entry_footer', 'ej_wedocs_display_helpful_feedback', 10 );

/**
 * WeDocs Sidebar
 *
 */
add_action( 'ej_wedocs_sidebar', 'ej_wedocs_sidebed_search', 10 );
add_action( 'ej_wedocs_sidebar', 'ej_wedocs_sidebed_related_articles', 20 );