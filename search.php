<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package EpicJungle
 */

get_header();

?>

<?php do_action( 'epicjungle_search_before' ); ?>

<div class="container pb-5 mb-2 mb-md-4">
	<div class="row justify-content-center pt-7">
		<section class="col-lg-8">

			<form role="search" method="get" class="search-form mb-4" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			    <label class="sr-only"><?php echo esc_html__( 'Search for:', 'epicjungle' ); ?></label>
			    <div class="input-group-overlay">
			        <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="fe-search"></i></span></div>
			        <input type="search" class="search-field form-control prepended-form-control" placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'epicjungle' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"/>
			    </div>
			</form>

			<?php
			if ( have_posts() ) :

				do_action( 'epicjungle_loop_before' );

				while ( have_posts() ) :
					the_post();
					get_template_part( 'templates/contents/search', get_post_type() );
				endwhile;

				do_action( 'epicjungle_loop_after' );

			else : ?>
				<div class="text-center pt-sm-5 pb-sm-3">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACHCAIAAABLZSaqAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MzJCMEQ1RDIwRTBGMTFFQTlDN0JDNTAzRUUyMzIxMDMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MzJCMEQ1RDMwRTBGMTFFQTlDN0JDNTAzRUUyMzIxMDMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozMkIwRDVEMDBFMEYxMUVBOUM3QkM1MDNFRTIzMjEwMyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozMkIwRDVEMTBFMEYxMUVBOUM3QkM1MDNFRTIzMjEwMyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pk97dYkAABCvSURBVHja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" width='70' class="d-inline-block mb-4" alt="Noting found">
					<p class="text-body mb-0"><?php echo esc_html_x( 'Nothing found! Please refine your search and try again.', 'front-end', 'epicjungle' ); ?></p>
				</div>
			<?php endif; ?>
		</section>
	</div>
</div>
<?php

do_action( 'epicjungle_search_after' );

get_footer();