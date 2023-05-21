<?php
/**
 * Template part for displaying the "Grid" blog layout (with sidebar)
 *
 * @package EpicJungle
 */

$sidebar     = function_exists( 'epicjungle_posts_sidebar' ) ? epicjungle_posts_sidebar() : 'left-sidebar';
$has_sidebar = in_array( $sidebar, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;
$columns     = $has_sidebar ? 3 : 4;

/**
 * Fires before the posts section
 */
do_action( 'epicjungle_posts_before' ); ?>
	<?php if( $has_sidebar ) : ?>
		<div class="cs-sidebar-enabled<?php echo esc_attr( $sidebar == 'right-sidebar' ? ' cs-sidebar-right' : '' );?>">
	<?php endif; ?>
			<div class="epicjungle-post-container container<?php if( !$has_sidebar ) echo esc_attr( ' py-4 mb-2 mb-sm-0 pb-sm-5' ); ?>">
				
				<?php if( $has_sidebar ) : ?>
				
					<div class="row">
						<div class="epicjungle-post-content col-lg-9 cs-content py-4 mb-2 mb-sm-0 pb-sm-5<?php if( $sidebar == 'left-sidebar' ) echo esc_attr( ' order-lg-1' ); ?>">
							<?php do_action( 'epicjungle_posts_content_before' );

				else:
								do_action( 'epicjungle_posts_content_before' );
							
				endif; ?>

							<?php 
							/**
							 * Fires right before the blog loop starts
							 */
							do_action( 'epicjungle_loop_before' ); ?>
							
							<div class="cs-masonry-grid overflow-hidden" data-columns="<?php echo esc_attr( $columns ); ?>"><?php
							
								while ( have_posts() ) : the_post();
							
									get_template_part( 'templates/blog/content', 'grid' );
							
								endwhile; 

							?></div>

							<?php
							/**
							 * Fires right after the blog loop
							 */
							do_action( 'epicjungle_loop_after' ); ?>
						
						<?php if( $has_sidebar ) : ?>
						</div>
							<div class="cs-sidebar col-lg-3 pt-lg-5">
								<?php get_sidebar(); ?>
							</div>
						</div><!-- .row -->
						<?php endif; ?>
					
				</div><!-- .container -->
				
		    	<?php do_action( 'epicjungle_posts_content_after' ); ?>
			
	<?php if( $has_sidebar ) : ?>
		</div><!-- .cs-sidebar -->	
	<?php endif; ?>
	
<?php

/**
 * Fires after the posts section
 */
do_action( 'epicjungle_posts_after' );