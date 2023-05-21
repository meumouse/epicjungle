<?php
/**
 * Template used to display post content on single pages.
 *
 * @package epicjungle
 */


$sidebar     = function_exists( 'epicjungle_posts_sidebar' ) ? epicjungle_posts_sidebar() : 'left-sidebar';
$has_sidebar = in_array( $sidebar, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;


?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if( $has_sidebar ) : ?>
        <div class="cs-sidebar-enabled<?php echo esc_attr( $sidebar == 'right-sidebar' ? ' cs-sidebar-right' : '' );?>">
    <?php endif; ?>

    <div class="container">
        <div class="row justify-content-center">
           <div class="col-lg-9 cs-content py-4 mb-2 mb-sm-0 pb-sm-5<?php if( $sidebar == 'left-sidebar' ) echo esc_attr( ' order-lg-1' ); ?>"><?php
            
                do_action( 'epicjungle_single_post_top' );

                /**
                 * Functions hooked into epicjungle_single_post add_action
                 *
                 * @hooked epicjungle_post_header          - 10
                 * @hooked epicjungle_post_content         - 30
                 */
                do_action( 'epicjungle_single_post' );

                /**
                 * Functions hooked in to epicjungle_single_post_bottom action
                 *
                 * @hooked epicjungle_post_nav         - 10
                 * @hooked epicjungle_display_comments - 20
                 */
                do_action( 'epicjungle_single_post_bottom' );
        
            ?></div>
            <?php if( $has_sidebar ) : ?>
                <div class="cs-sidebar col-lg-3 pt-lg-5">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if( $has_sidebar ) : ?>
        </div>
    <?php endif; ?>
</div><!-- #post-## -->