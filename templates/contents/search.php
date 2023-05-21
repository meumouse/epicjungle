<?php
/**
 * Template part for displaying the tile on a search results page.
 *
 * This template is reserving for post types that officially not supported by EpicJungle theme.
 *
 * @package EpicJungle
 */


?>
<article <?php post_class( 'search-results-item pb-3 mb-3 border-bottom' ); ?>>
	<div class="badge badge-warning p-1 mb-2">
		<?php echo epicjungle_search_post_type_name( get_post_type() ); ?>
	</div>
	<?php
	the_title(
		sprintf( '<h2 class="h5 nav-heading"><a href="%s">', esc_url( get_permalink() ) ),
		'</a></h2>'
	); ?>

	<p class="font-size-sm mb-0">
		<?php the_content(); ?>
	</p>
</article>
