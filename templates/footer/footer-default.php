<?php
/**
 * Footer Default
 *
 */

$footer_skin = function_exists( 'epicjungle_footer_skin' ) ? epicjungle_footer_skin() : 'dark'; ?>

<footer id="colophon" class="site-footer cs-footer <?php echo ( 'dark' === $footer_skin  ? 'bg-dark' : '' );?> pt-5 pt-md-6 footer-default">
    <div class="container pt-3 pt-md-0"><?php
        
        /**
         * Functions hooked in to epicjungle_footer action
         *
         * @hooked epicjungle_footer_widgets  - 10
         */
        do_action( 'epicjungle_footer' );
        
    ?></div><!-- .container -->
</footer>

<!-- #colophon --><?php 

