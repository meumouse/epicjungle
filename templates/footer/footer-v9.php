<?php
/**
 * Footer v9
 *
 */
$footer_skin = function_exists( 'epicjungle_footer_skin' ) ? epicjungle_footer_skin() : 'dark'; 

?>
<footer class="cs-footer pb-4 mt-sm-n5 position-relative <?php echo ( 'dark' === $footer_skin ? 'bg-dark p-5' : '' );?>">
    <div class="container font-size-sm text-center">
    	<?php do_action( 'epicjungle_footer_v9' ); ?>
     </div>
</footer>