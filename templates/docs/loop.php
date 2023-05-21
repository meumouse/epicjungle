<?php
/**
 * Template part for displaying the docs loop
 *
 * @author  MeuMouse.com
 * @package EpicJungle
 */

/**
 * Fires before the docs section
 */
do_action( 'epicjungle_docs_before' ); 
    global $post;
    $thepostid = isset( $thepostid )? $thepostid : $post->ID;
    ?>

<div class="container">
    <div class="wedocs-docs-list row pt-4">
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="wedocs-docs-single mb-grid-gutter col-lg-4 col-sm-6">
            <a class="card border-0 box-shadow" href="<?php the_permalink(); ?>">
                <div class="card-body text-center">

                    <?php if ( function_exists( 'ej_wedocs_featured_icon' ) ) {
                        ej_wedocs_featured_icon( $thepostid, 'h2 text-primary mt-2 mb-4' ); 
                    } ?>
                    
                    <h6><?php the_title(); ?></h6>
                    
                    <div class="wedocs-doc-link btn btn-outline-primary btn-sm mb-2"><?php echo esc_html__( 'View More', 'epicjungle' ); ?></div>
                
                </div>
            </a>
        </div>
    <?php endwhile; ?>
    </div>
</div>