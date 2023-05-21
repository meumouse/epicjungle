<?php
/**
 * Footer v8
 *
 */
$footer_skin = function_exists( 'epicjungle_footer_skin' ) ? epicjungle_footer_skin() : 'dark'; 
?>
<footer id="colophon" class="cs-footer bg-<?php echo ( 'dark' === $footer_skin ? 'dark' : 'white' );?> pt-5 footer-v8">
	<div class="container pt-3 pt-md-0">
		<?php
	        /**
	         * Functions hooked in to epicjungle_footer action
	         *
	         * @hooked epicjungle_footer_widgets  - 10
	         */
	        do_action( 'epicjungle_footer_v8' );
	    ?>
	</div>
        
</footer><!-- #colophon --><?php 