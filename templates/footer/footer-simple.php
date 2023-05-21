<?php
/**
 * Footer Simple
 *
 */

$footer_skin = function_exists( 'epicjungle_footer_skin' ) ? epicjungle_footer_skin() : 'dark'; ?>
<footer class="cs-footer footer-simple <?php echo ( 'dark' === $footer_skin ? 'bg-dark pt-5 pb-4' : 'py-4' );?> mt-auto">
    <div class="container d-md-flex align-items-center justify-content-between <?php echo ( 'dark' === $footer_skin ? '' : 'py-2' );?> text-center text-md-left">
    	<?php do_action( 'epicjungle_footer_simple' ); ?>
     </div>
</footer>