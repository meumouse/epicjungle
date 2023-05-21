<?php
/**
 * EpicJungle template functions.
 *
 * @package epicjungle
 */

if ( ! function_exists( 'epicjungle_page_header' ) ) :
    /**
     * Display the page header
     *
     * @since 1.0.0
     */
    function epicjungle_page_header() {


        if( apply_filters( 'epicjungle/page/show-header', true ) ) : 
        
            ?><div class="page__header pt-1 mt-2">
                <?php the_title( '<h1 class="page-title mb-5">', '</h1>' ); ?>
            </div><?php 
        
        endif;
    }
endif;

if ( ! function_exists( 'epicjungle_page_content' ) ) :
    /**
     * Display the page content
     *
     * @since 1.0.0
     */
    function epicjungle_page_content() {
        ?>
        <div class="article__content article__content--page">
            <div class="page__content">
                <?php the_content(); ?>
            </div>

            <?php
                $link_pages = wp_link_pages(
                array(
                    'before' => '<div class="page-links"><span class="d-block text-dark mb-3">' . esc_html__( 'Pages:', 'epicjungle' ) . '</span><nav class="pagination mb-0">',
                    'after'  => '</nav></div>',
                    'link_before' => '<span class="page-link">',
                    'link_after'  => '</span>',
                    'echo'   => 0,
                )
            ); 
                $link_pages = str_replace( 'post-page-numbers', 'post-page-numbers page-item', $link_pages );
                $link_pages = str_replace( 'current', 'current active', $link_pages );
                echo wp_kses_post( $link_pages );
            ?>

            <?php epicjungle_display_comments(); ?>

        </div><!-- .entry-content -->
        <?php
    }
endif;

if ( ! function_exists( 'epicjungle_display_comments' ) ) :
    /**
     * epicjungle display comments
     *
     * @since  1.0.0
     */
    function epicjungle_display_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || 0 !== intval( get_comments_number() ) ) :
            comments_template();
        endif;
    }
endif;

/**
 * Returns the registered name for a post type
 *
 * This function was designed to use on a search results page.
 *
 * @param string $post_type Post type
 *
 * @return string
 */
if( ! function_exists( 'epicjungle_search_post_type_name' ) ) {
    function epicjungle_search_post_type_name( $post_type ) {
        $post_type_name = '';

        if ( ! empty( $post_type ) ) {
            $post_type_obj = get_post_type_object( $post_type );
            if ( ! empty( $post_type_obj ) ) {
                $post_type_name = $post_type_obj->name;
            }
        }

        return $post_type_name;
    }
}

/**
 * Display scroll to top button
 *
 * @since 1.0.0
 */
if( ! function_exists( 'epicjungle_scroll_to_top' ) ) {
    function epicjungle_scroll_to_top() {
        if ( apply_filters( 'epicjungle_scroll_to_top', filter_var( get_theme_mod( 'enable_scroll_to_top', 'yes' ), FILTER_VALIDATE_BOOLEAN ) ) ) {

        ?>

            <a class="btn-scroll-top" href="#top" data-scroll="">
                <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">
                    <?php echo esc_html__( 'Top', 'epicjungle' ); ?>
                </span>
                <i class="btn-scroll-top-icon fe-arrow-up"></i>
            </a>
           
            <?php
        }
    }
}
