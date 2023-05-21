<?php
/**
 * Template Functions related to Blog
 *
 */

if( ! function_exists( 'epicjungle_posts_sidebar' ) ) {
    function epicjungle_posts_sidebar() {
        $sidebar = get_theme_mod( 'blog_sidebar', 'left-sidebar' );

        if( ! is_active_sidebar( 'blog-sidebar' ) ) {
            $sidebar = 'no-sidebar';
        }

        return sanitize_key( apply_filters( 'epicjungle_posts_sidebar', $sidebar ) );
    }
}

if( ! function_exists( 'epicjungle_posts_layout' ) ) {
    function epicjungle_posts_layout() {
        $layout = get_theme_mod( 'blog_layout', 'grid' );
        return sanitize_key( apply_filters( 'epicjungle_posts_layout', $layout ) );
    }
}

if( ! function_exists( 'epicjungle_post_get_categories' ) ) {
    function epicjungle_post_get_categories( $post_id = null ) {
        $post_id = $post_id ?: get_the_ID();

        $categories = get_the_terms( $post_id, 'category' );
        if ( empty( $categories ) || is_wp_error( $categories ) ) {
            return [];
        }

        return $categories;
    }
}



if( ! function_exists( 'epicjungle_loop_post_author' ) ) {
    function epicjungle_loop_post_author( ) { 
        $author = get_the_author(); ?>
        <a class="media meta-link font-size-sm align-items-center pt-3" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
            <?php echo wp_kses_post( get_avatar( get_the_author_meta( 'user_email' ), 36, '', '', array ( 'class' => 'avatar-img rounded-circle' ) ) ); 
            if ( !empty ( $author ) ) : ?>
                <div class="media-body pl-2 ml-1 mt-n1"><?php 
                    echo wp_kses_post( sprintf( __( 'by %s', 'epicjungle'), 
                        '<span class="font-weight-semibold ml-1">' . get_the_author() . '</span>' 
                    ) ); 
                ?></div>
            <?php endif; ?>
        </a><?php
    }
}

if( ! function_exists( 'epicjungle_loop_post_meta' ) ) {
    function epicjungle_loop_post_meta()  { 

        ?><div class="mt-3 text-right text-nowrap"><?php 

            if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) :

                ?><a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>">
                    <i class="fe-message-square mr-1"></i>&nbsp;<?php echo get_comments_number(); ?>
                </a>
                <span class="meta-divider"></span><?php 

            endif; 

            ?><a class="post-date meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>"><i class="fe fe-calendar mr-1 mt-n1"></i>&nbsp;<?php echo esc_html( get_the_date() ); ?></a>

        </div><?php
       
    }
}

if ( ! function_exists( 'epicjungle_archive_header' ) ) {
    function epicjungle_archive_header() {
        $title = wp_title( '', false );
        if ( !empty ( $title ) ) { ?>
            <div class="archive__header pt-1 mt-2">
                <h1 class="mb-5"><?php echo trim( $title ); ?></h1>
            </div><?php
        }
    }
}


if ( ! function_exists( 'epicjungle_loop_paging_nav_wrap_start' ) ) {
    function epicjungle_loop_paging_nav_wrap_start() { ?>
        <div class="d-md-flex justify-content-between align-items-center pt-3 pb-2"><?php
    }
}

if ( ! function_exists( 'epicjungle_loop_paging_nav_wrap_end' ) ) {
    function epicjungle_loop_paging_nav_wrap_end() { ?>
        </div><?php
    }
}

if ( ! function_exists( 'epicjungle_set_blog_posts_per_page' ) ) {
    function epicjungle_set_blog_posts_per_page( $query ) {
        if ( ! is_admin() && $query->is_main_query() && ! $query->get( 'post_type' ) ) {
            $per_page = $query->get( 'posts_per_page' );
            if ( isset( $_REQUEST['ppp'] ) ) :
                $per_page = intval( $_REQUEST['ppp'] );
                setcookie( 'posts_per_page', intval( $_REQUEST['ppp'] ), time() + 86400, "/");
            elseif ( isset( $_COOKIE[ 'posts_per_page' ] ) ) :
                $per_page = intval( $_COOKIE[ 'posts_per_page' ] );
            endif;

            $query->set( 'posts_per_page', $per_page );
        }
    }
}
add_action( 'pre_get_posts', 'epicjungle_set_blog_posts_per_page' );

if ( ! function_exists( 'epicjungle_results_count' ) ) {
    function epicjungle_results_count() {
        global $wp_query;
        
        $total        = $wp_query->found_posts;
        $total_pages  = $wp_query->max_num_pages;
        $per_page     = $wp_query->get( 'posts_per_page' );
        $current      = max( 1, $wp_query->get( 'paged', 1 ) );
        
        ?><div class="results-count mb-4 text-center text-md-left"><?php
            // phpcs:disable WordPress.Security
            if ( 1 === intval( $total ) ) {
                _e( 'Showing the single post', 'epicjungle' );
            } elseif ( $total <= $per_page || -1 === $per_page ) {
                /* translators: %d: total posts */
                printf( _n( 'Showing all %d post', 'Showing all %d posts', $total, 'epicjungle' ), $total );
            } else {
                $first = ( $per_page * $current ) - $per_page + 1;
                $last  = min( $total, $per_page * $current );
                /* translators: 1: first post 2: last post 3: total posts */
                printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d post', 'Showing %1$d&ndash;%2$d of %3$d posts', $total, 'with first and last post', 'epicjungle' ), $first, $last, $total );
            }
            // phpcs:enable WordPress.Security
        ?></div><?php
    }
}

if ( ! function_exists( 'epicjungle_posts_per_page' ) ) {
    /**
     * Outputs a dropdown for user to select how many jobs to show per page
     */
    function epicjungle_posts_per_page() {
        global $wp, $wp_query;

        $action             = '#';
        $cat                = '';
        $cat                = $wp_query->get_queried_object();
        $method             = apply_filters( 'epicjungle_post_method', 'post' );
        $return_to_first    = apply_filters( 'epicjungle_post_return_to_first', false );
        $total              = $wp_query->found_posts;
        $per_page           = $wp_query->get( 'posts_per_page' );
        $_per_page          = apply_filters( 'epicjungle_per_page_interval', 5 );

        // Generate per page options
        $posts_per_page_options = array();
        while( $_per_page < $total ) {
            $posts_per_page_options[] = $_per_page;
            $_per_page = $_per_page * 2;
        }

        if ( empty( $posts_per_page_options ) ) {
            return;
        }

        if( ( $per_page == get_option( 'posts_per_page' ) ) && ( get_option( 'posts_per_page' ) > $total ) ) {
            $posts_per_page_options[] = get_option( 'posts_per_page' );
        }

        $posts_per_page_options[] = -1;

        // Set action url if option behaviour is true
        // Paste QUERY string after for filter and orderby support

        $server_query_string = isset( $_POST['QUERY_STRING'] ) ? $_POST['QUERY_STRING'] : '';
        $query_string = ! empty( $server_query_string ) ? '?' . add_query_arg( array( 'ppp' => false ), $server_query_string ) : null;

        if ( isset( $cat->term_id ) && isset( $cat->taxonomy ) && $return_to_first ) :
            $action = get_term_link( $cat->term_id, $cat->taxonomy ) . $query_string;
        elseif ( $return_to_first ) :
            $action = get_permalink( get_option( 'posts_per_page' ) ) . $query_string;
        endif;

        
        do_action( 'epicjungle_posts_before_dropdown_form' );

        ?><form method="POST" action="<?php echo esc_url( $action ); ?>" class="d-flex justify-content-center align-items-center mb-4">

            <label class="pr-1 mr-2 text-nowrap"><?php echo esc_html__( 'Show', 'epicjungle' )?></label>
            <?php do_action( 'epicjungle_posts_before_dropdown' ); ?>
            <select name="ppp" onchange="this.form.submit()" class="form-control custom-select mr-2"><?php

                foreach( $posts_per_page_options as $key => $value ) :

                    ?><option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $per_page ); ?>><?php
                        esc_html( printf( $value == -1 ? esc_html__( 'All', 'epicjungle' ) : $value ) ); // Set to 'All' when value is -1
                    ?></option><?php

                endforeach;

            ?></select>
            <div class="font-size-sm text-nowrap pl-1 mb-1"><?php echo esc_html__( 'posts per page', 'epicjungle' )?></div><?php

            // Keep query string vars intact
            foreach ( $_GET as $key => $val ) :

                if ( 'ppp' === $key || 'submit' === $key ) :
                    continue;
                endif;
                if ( is_array( $val ) ) :
                    foreach( $val as $inner_val ) :
                        ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $inner_val ); ?>" /><?php
                    endforeach;
                else :
                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $val ); ?>" /><?php
                endif;
            endforeach;

            do_action( 'epicjungle_posts_after_dropdown' );

        ?></form><?php

        do_action( 'epicjungle_posts_after_dropdown_form' );
    }
}

if( ! function_exists( 'epicjungle_pagination' ) ) {
    function epicjungle_pagination() {
        $max_pages = isset( $GLOBALS['wp_query']->max_num_pages ) ? $GLOBALS['wp_query']->max_num_pages : 1;
        if ( $max_pages < 2 ) {
            return;
        }

        $paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
        $links = paginate_links( apply_filters( 'epicjungle_posts_pagination_args', [
            'type'      => 'array',
            'mid_size'  => 2,
            'prev_next' => false,
        ] ) );

        ?>
        <nav class="d-flex justify-content-between mb-4" aria-label="<?php
        /* translators: aria-label for posts navigation wrapper */
        echo esc_attr_x( 'Posts navigation', 'front-end', 'epicjungle' ); ?>">
            <ul class="pagination justify-content-center">
                <?php if ( $paged && 1 < $paged ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo esc_url( get_previous_posts_page_link() ); ?>">
                            <i class="fe-chevron-left"></i>
                            <span class="sr-only"><?php echo esc_html_x( 'Prev', 'front-end', 'epicjungle' ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="pagination justify-content-center">
                <li class="page-item d-sm-none">
                    <span class="page-link page-link-static"><?php echo esc_html( "{$paged} / {$max_pages}" ); ?></span>
                </li>
                <?php foreach ( $links as $link ) : ?>
                    <?php if ( false !== strpos( $link, 'current' ) ) : ?>
                        <li class="page-item active d-none d-sm-block">
                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                        </li>
                    <?php else : ?>
                        <li class="page-item d-none d-sm-block">
                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <ul class="pagination justify-content-center">
                <?php if ( $paged && $paged < $max_pages ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo esc_url( get_next_posts_page_link() ); ?>">
                            <span class="sr-only"><?php echo esc_html_x( 'Next', 'front-end', 'epicjungle' ); ?></span>
                            <i class="fe-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php
    }
}

if( ! function_exists( 'epicjungle_comment_reply_link' ) ) {
    function epicjungle_comment_reply_link( $link, $args ) {
        if ( apply_filters( 'epicjungle_comment_style_enable', false ) ):
            return str_replace(
                [
                    'comment-reply-link',
                    '\'>'
                ],
                [
                    'comment-reply-link btn btn-outline-primary btn-sm',
                    '\'><i class="fe-corner-up-left font-size-base mr-2 ml-n1"></i>'
                ],
                $link
            );
        endif;
    }
}


if( ! function_exists( 'epicjungle_edit_comment_link' ) ) {
    function epicjungle_edit_comment_link( $link, $comment_comment_id, $text ) {
        return str_replace(
            [
                'comment-edit-link',
                '\'>'
            ],
            [
                'comment-edit-link btn btn-outline-primary btn-sm ml-1',
                '\'>'
            ],
            $link
        );
    }
}

/**
 * Outputs the handheld toolbar
 *
 * @since 1.0.0
 */
if( ! function_exists( 'epicjungle_handheld_toolbar' ) ) {
    function epicjungle_handheld_toolbar() {
        /**
         * Display tools in toolbar
         */
        do_action( 'epicjungle_handheld_toolbar' );
       
    }
}

/**
 * Outputs the sidebar toggle in the handheld toolbar
 *
 * This toggle should be only the blog page.
 *
 * @since 1.0.0
 */

if( ! function_exists( 'epicjungle_handheld_toolbar_toggle_blog_sidebar' ) ) {
    function epicjungle_handheld_toolbar_toggle_blog_sidebar() {
        if ( ( is_home() || is_singular( 'post' ) || ( 'post' == get_post_type() && ( is_category() || is_tag() || is_author() || is_date() || is_year() || is_month() || is_time() ) ) )
             && epicjungle_posts_sidebar() !== 'no-sidebar'
        ) : ?>
                
        <button class="btn btn-primary btn-sm cs-sidebar-toggle" type="button" data-toggle="offcanvas" data-offcanvas-id="blog-sidebar"><i class="fe-sidebar font-size-base mr-2"></i><?php echo esc_html_x( 'Sidebar', 'front-end', 'epicjungle' ); ?></button>
            
        <?php
        endif;
    }
}




function epicjungle_get_post_breadcrumb( $crumbs, $obj ) {
    if ( is_home() ) {
        if( isset( $crumbs[2] ) && get_query_var( 'paged' ) < 2 ) {
            unset( $crumbs[2] );
        }

        if( empty( $crumbs[1][0] ) ) {
            $crumbs[1][0] = esc_html__( 'Blog', 'epicjungle' );
        }
    }
    return $crumbs;
}

if( ! function_exists( 'epicjungle_comments_navigation' ) ) {
    function epicjungle_comments_navigation() {
        if ( absint( get_comment_pages_count() ) === 1 ) {
            return;
        }

        /* translators: label for link to the previous comments page */
        $prev_text = esc_html__( 'Older comments', 'epicjungle' );
        $prev_link = get_previous_comments_link( '<i class="fe fe-arrow-left mr-2"></i>' . $prev_text );

        /* translators: label for link to the next comments page */
        $next_text = esc_html__( 'Newer comments','epicjungle' );
        $next_link = get_next_comments_link( $next_text . '<i class="fe fe-arrow-right ml-2"></i>' );

        ?>
        <nav class="navigation comment-navigation d-flex justify-content-between my-5" role="navigation">
            <h3 class="screen-reader-text sr-only"><?php
            /* translators: navigation through comments */
            echo esc_html__( 'Comment navigation','epicjungle' ); ?></h3>
            <?php if ( $prev_link ) : ?>
                <?php echo str_replace( '<a ', '<a class="text-decoration-none font-weight-medium" ', $prev_link ); ?>
            <?php endif; ?>
            <?php if ( $next_link ) : ?>
                <?php echo str_replace( '<a ', '<a class="text-decoration-none ml-auto font-weight-medium" ', $next_link ); ?>
            <?php endif; ?>
        </nav>
        <?php
    }
}