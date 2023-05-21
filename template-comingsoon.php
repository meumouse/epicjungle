<?php
/**
 * Template name: Coming Soon
 *
 * @package epicjungle
 */


?>
<div class="cs-page-wrapper d-flex flex-column">

	<?php get_header( 'canvas'); ?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<?php do_action( 'coming_soon' ); ?>
			</main>
		</div><?php

	get_footer( 'canvas'); ?>
	          
</div><!-- .cs-page-wrapper -->

