<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EpicJungle
 */
?>

<div class="article__page no-results not-found">
    <div class="container">
      

	    <div class="page__header py-3 py-lg-7">
	        <h6 class="font-weight-medium font-size-7 text-center my-1"><?php esc_html_e( 'Nothing Found', 'epicjungle' ); ?></h6>
	    </div>


	    <div class="article__content article__content--page">
	        <div class="space-bottom-2">
	            <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	                <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'epicjungle' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

	            <?php elseif ( is_search() ) : ?>

	                <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'epicjungle' ); ?></p>
	                <?php get_search_form(); ?>

	            <?php else : ?>

	                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'epicjungle' ); ?></p>
	                <?php get_search_form(); ?>

	            <?php endif; ?>
	        </div>
	    </div><!-- .entry-content -->
	</div>
</div><!-- .no-results -->