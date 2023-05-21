<?php
/**
 * Template part for displaying a post tile in grid layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EpicJungle
 */
$_categories = epicjungle_post_get_categories();
?>
<div class="cs-grid-item">
	<article <?php post_class( 'card card-hover blog-grid' ); ?>>
		
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
			<a class="card-img-top" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'epicjungle-275x183-crop', [
					'class' => 'img-fluid w-100',
					'alt'   => the_title_attribute( [ 'echo' => false ] ),
				] ); ?>
			</a>
		<?php endif; ?>

        <?php if ( is_sticky() ) : ?>
        <span class="badge badge-primary badge-floating badge-floating-right"><?php echo esc_html__( 'Featured', 'epicjungle' ); ?></span>
        <?php endif; ?>

		<div class="card-body">
			<?php if ( ! empty( $_categories ) ) : ?>
				<?php
					echo implode( '<span class="cat-separator meta-link font-size-sm mb-2">,</span> ', array_map( function ( $category ) {
					return sprintf( '<a href="%s" class="meta-link font-size-sm mb-2">%s</a>',
						esc_url( get_category_link( $category ) ),
						esc_html( $category->name )
					);
				}, $_categories ) ); ?>
            <?php endif; unset( $_categories ); 

            the_title(
            	sprintf( '<h2 class="post__title h5 nav-heading mb-4"><a href="%s">', esc_url( get_permalink() ) ),
            	'</a></h2>'
        	); 

            if ( apply_filters( 'epicjungle_loop_post_author', true ) ): 
                epicjungle_loop_post_author(); 
            endif; 
            epicjungle_loop_post_meta(); ?>

		</div>
		
	</article>
</div>
