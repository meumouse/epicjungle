<?php
/**
 * Footer v7
 *
 */

$footer_skin = function_exists( 'epicjungle_footer_skin' ) ? epicjungle_footer_skin() : 'dark'; ?>
<footer id="colophon" class="site-footer cs-footer jarallax bg-<?php echo ( 'dark' === $footer_skin ? 'dark' : 'secondary' );?> pt-5 pt-md-6 pt-lg-7 footer-v7">
	<?php
        /**
         * Functions hooked in to epicjungle_footer action
         *
         * @hooked epicjungle_footer_widgets  - 10
         */
        do_action( 'epicjungle_footer_v7' );
    ?>
        
</footer><!-- #colophon --><?php 