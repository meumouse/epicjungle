<?php
/**
 * Template part for displaying the "List" blog layout (with sidebar)
 *
 * @package EpicJungle
 */

$posts_layout = function_exists( 'epicjungle_posts_layout' ) ? epicjungle_posts_layout() : 'grid';
get_template_part( 'templates/blog/loop', $posts_layout );
