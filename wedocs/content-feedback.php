<?php global $post; ?>
<!-- Resolved -->
<div class="d-flex align-items-center border-top border-bottom mt-5 py-4 wedocs-feedback-wrap wedocs-hide-print mb-0">
    <?php
    $positive = (int) get_post_meta( $post->ID, 'positive', true );
    $negative = (int) get_post_meta( $post->ID, 'negative', true );

    $positive_title = $positive ? sprintf( _n( '%d person found this useful', '%d persons found this useful', $positive, 'epicjungle' ), number_format_i18n( $positive ) ) : esc_html__( 'No votes yet', 'epicjungle' );
    $negative_title = $negative ? sprintf( _n( '%d person found this not useful', '%d persons found this not useful', $negative, 'epicjungle' ), number_format_i18n( $negative ) ) : esc_html__( 'No votes yet', 'epicjungle' );
    ?>

    <h3 class="h5 my-2 pr-sm-2 mr-4"><?php echo esc_html__( 'Did you find this article helpful?', 'epicjungle' ); ?></h3>

    <div class="text-nowrap">

        <a href="#" class="btn-like" data-id="<?php the_ID(); ?>" data-type="positive" title="<?php echo esc_attr( $positive_title ); ?>">
           

            <?php if (  0 && $positive ) { ?>
                <span class="count ml-0"><?php echo number_format_i18n( $positive ); ?></span>
            <?php } ?>
        </a>

        <a href="#" class="btn-dislike" data-id="<?php the_ID(); ?>" data-type="negative" title="<?php echo esc_attr( $negative_title ); ?>">
           

            <?php if ( 0 && $negative ) { ?>
                <span class="count ml-0"><?php echo number_format_i18n( $negative ); ?></span>
            <?php } ?>
        </a>
        
    </div>
    
</div>

    