<?php
/**
 * Front Posts Widget Template
 *
 */
global $post;

if ( $fpw_query->have_posts() ) :

    while ( $fpw_query->have_posts () ) : $fpw_query->the_post (); ?>

    <div class="media pb-1 mb-3">
        <a class="d-block" href="<?php echo esc_url( get_the_permalink() ); ?>">
            <?php echo the_post_thumbnail( array( 64, 64 ), [ 'class' => 'rounded' ] ); ?>
        </a>
        <div class="media-body pl-2 ml-1">
            <h4 class="font-size-md nav-heading mb-1">
            <a class="font-weight-medium" href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
        </h4>
        <p class="font-size-xs text-muted mb-0"><?php esc_html('by', 'epicjungle-elementor'); ?><?php the_author(); ?></p>
        </div>
    </div>

<?php endwhile;

else : ?>

<div class="fpw-not-found">
    <?php esc_html_e( 'No posts found.', 'epicjungle' ); ?>
</div><?php 

endif;

