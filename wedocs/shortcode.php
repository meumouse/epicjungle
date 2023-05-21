<?php
/**
 * Template used to display docs content.
 *
 * @package epicjungle
 */

$column_classes = 'col-lg-'. ( 12 / $col ) .' col-12 col-md-6';

if ( $docs ) : ?>

<div class="wedocs-shortcode-wrap">
    <div class="wedocs-docs-list row">
        <?php foreach ( $docs as $main_doc ) : 
            $docs_border_top_color = ej_get_post_featured_icon_bg( $main_doc['doc']->ID);  
            if ( $docs_border_top_color ) {
                $border_color = $docs_border_top_color;
            } else {
                 $border_color = 'primary';
            }
        ?>  
        <div class="wedocs-docs-single mb-grid-gutter <?php echo esc_attr( $column_classes ); ?>">
            <a class="card h-100 border-0 box-shadow card-hover" href="<?php echo esc_url( get_permalink( $main_doc['doc']->ID ) ); ?>">
                <div class="card-body pl-grid-gutter pr-grid-gutter text-center">
                    <?php ej_wedocs_featured_icon( $main_doc['doc']->ID ); ?>

                    <h3 class="h5"><?php echo esc_html( $main_doc['doc']->post_title ); ?></h3>

                    <?php if ( ! empty( $main_doc['doc']->post_excerpt ) ) : ?>
                        <p class="font-size-sm text-body"><?php echo esc_html( $main_doc['doc']->post_excerpt ); ?></p>
                    <?php endif; ?>

                    
                    <div class="wedocs-doc-link btn btn-translucent-primary btn-sm mb-2" href="<?php echo get_permalink( $main_doc['doc']->ID ); ?>"><?php echo esc_html__( 'Learn more', 'epicjungle');?></div>
                    
                </div>
            </a>
        </div>
    <?php endforeach; ?>

    </div>
</div>

<?php endif;
