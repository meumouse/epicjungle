<?php
/**
 * Template part for displaying a post tile in grid layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EpicJungle
 */
$style = get_theme_mod( 'list_view_style', 'style-v1' );

$_categories = epicjungle_post_get_categories();
?>
<?php if ( $style === 'style-v2') { ?>

    <article <?php post_class( 'card card-horizontal card-hover mb-grid-gutter' ); ?>>
        <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
            <a class="card-img-top" href="<?php the_permalink(); ?>" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
            </a>

            <?php if ( ! empty( $_categories ) ) :
                $links = [];
                foreach ( $_categories as $term ){
                    $cat_bg = get_term_meta( $term->term_id, 'category_bg', true );

                    $links[] = sprintf( '<span href="%s" class="badge badge-lg badge-floating badge-primary text-white" rel="tag" style="background-color:' . $cat_bg .'">%s</span>',
                        esc_url( get_category_link( $term ) ),
                        esc_html( $term->name )
                    );
                }
                echo apply_filters( 'epicjungle_list_view_category_badge', wp_kses_post( sprintf( implode( '', $links  ) ) ));

            endif; unset( $_categories ); ?>
        <?php endif; ?>

        <div class="card-body"><?php 
    
            the_title(
                sprintf( '<h3 class="card-body__heading h4 nav-heading text-capitalize mb-3"><a href="%s">', esc_url( get_permalink() ) ),
                '</a></h3>'
            ); ?>

            <p class="mb-0 font-size-sm text-muted"><?php echo esc_html( get_the_excerpt() ); ?></p>
            
            <?php epicjungle_loop_post_meta(); ?>

        </div>
    </article><?php

} else { ?>

    <article <?php post_class( 'card card-horizontal card-hover mb-grid-gutter' ); ?>>
        <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
            <a class="card-img-top" href="<?php the_permalink(); ?>" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
            </a>
        <?php endif; ?>

        <div class="card-body"><?php 

            if ( ! empty( $_categories ) ) :
                
                echo implode( ', ', array_map( function ( $category ) {
                    return sprintf( '<a href="%s" class="meta-link font-size-sm mb-2">%s</a>',
                        esc_url( get_category_link( $category ) ),
                        esc_html( $category->name )
                    );
                }, $_categories ) );
            
            endif; unset( $_categories );

            the_title(
                sprintf( '<h2 class="post__title h4 nav-heading mb-4"><a href="%s">', esc_url( get_permalink() ) ),
                is_sticky() ? sprintf('<span class="sticky-badge badge badge-pill badge-primary ml-2 py-1 font-size-sm">%s</span>', esc_html__('Featured', 'epicjungle') ) .'</a></h2>' : '</a></h2>'
            ); 

            epicjungle_loop_post_author(); 
            
            epicjungle_loop_post_meta(); 

        ?></div>
    </article><?php

} 