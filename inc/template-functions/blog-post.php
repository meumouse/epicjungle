<?php
/**
 * Template functions related to Single Post
 *
 */

if ( ! function_exists( 'epicjungle_single_post_header' ) ) {
    function epicjungle_single_post_header() {
        ?><div class="pb-4" style="max-width:38rem"><?php 
            epicjungle_breadcrumb();
            the_title( '<h1 class="post-title pt-1 mt-2">', '</h1>' );
        ?></div><?php
    }
}

if ( ! function_exists( 'epicjungle_single_post_meta' ) ) {
    function epicjungle_single_post_meta() {
        ?><div class="row position-relative no-gutters align-items-center border-top border-bottom mb-4 epicjungle-post-author-and-sharing">
            <div class="py-3 pr-md-3 epicjungle-post-author">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                    <div class="media media-ie-fix align-items-center mr-grid-gutter">
                        <a class="d-block" href="#">
                            <?php echo get_avatar( get_the_author_meta( 'user_email' ), 64, '', '', array( 'class' => 'rounded-circle mr-1' ) ); ?>
                        </a>
                        <div class="media-body pl-2">
                            <h6 class="nav-heading mb-1"><a href="#"><?php echo get_the_author_meta( 'display_name' ); ?></a></h6>
                            <div class="text-nowrap">
                                <?php
                                // Posted on.
                                $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

                                if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                                    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
                                }

                                $time_string = sprintf(
                                    $time_string,
                                    esc_attr( get_the_date( 'c' ) ),
                                    esc_html( get_the_date() ),
                                    esc_attr( get_the_modified_date( 'c' ) ),
                                    esc_html( get_the_modified_date() )
                                );

                                $output_time_string = sprintf( '<a href="%1$s" rel="bookmark" class="text-decoration-none text-reset">%2$s</a>', esc_url( get_permalink() ), $time_string );

                                ?>
                                <div class="meta-link font-size-xs">
                                    <i class="fe-calendar mr-1 mt-n1"></i>&nbsp;<?php echo wp_kses( $output_time_string, array(
                                        'a'    => array(
                                            'href'  => array(),
                                            'title' => array(),
                                            'rel'   => array(),
                                            'class' => array(),
                                        ),
                                        'time' => array(
                                            'datetime' => array(),
                                            'class'    => array(),
                                        ),
                                    ) ); ?>
                                </div>
                                <?php if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) : ?>
                                <span class="meta-divider"></span>
                                <a class="meta-link font-size-xs" href="<?php echo esc_url( get_comments_link() ); ?>" data-scroll>
                                    <i class="fe-message-square mr-1"></i>&nbsp;<?php echo get_comments_number(); ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <?php if ( class_exists( 'EpicJungle_SocialShare' ) && apply_filters('epicjungle_social_share', true ) ): ?>
                <div class="pl-md-3 post-share">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                      <?php epicjungle_share_display(); ?>
                    </div>
                </div>
            <?php endif; ?>

            
        </div><?php
    }
}

if ( ! function_exists( 'epicjungle_single_post_content' ) ) :
    /**
     * Display the page content
     *
     * @since 1.0.0
     */
    function epicjungle_single_post_content() {
        ?>
        <div class="article__content article__content--post pt-3 mb-5 font-size-md"><?php 

            /**
             * Functions hooked in to epicjungle_post_content_before action.
             *
             */
            do_action( 'epicjungle_post_content_before' ); ?>

            <div class="post__content single_post__content">
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


        ?></div><!-- .entry-content -->
        <?php
    }
endif;


if ( ! function_exists( 'epicjungle_single_post_footer' ) ) {
    function epicjungle_single_post_footer() {

         $tags_list = get_the_tag_list( '', esc_html__( ' ', 'epicjungle' ) );

        if ( !empty ( $tags_list ) || function_exists( 'epicjungle_display_jetpack_shares' ) ) : ?>
        <div class="row no-gutters position-relative align-items-center border-top border-bottom my-5 epicjungle-tags-share-wrap">
            <?php if ( $tags_list && apply_filters( 'epicjungle_single_post_tags_enabled', true ) ) { 

                printf(
                    '<div class="post-tags py-2 py-md-3 pr-md-3 text-center text-md-left"><span class="sr-only">%1$s </span>%2$s</div>',
                    esc_html__( 'Tags:', 'epicjungle' ),
                    $tags_list
                ); // WPCS: 
            } ?>

            <?php if ( class_exists( 'EpicJungle_SocialShare' ) && apply_filters('epicjungle_social_share', true ) ): ?>
                <div class="post-share pl-md-3">
                    <div class="d-flex align-items-center justify-content-center py-md-3 justify-content-md-end">
                      <?php epicjungle_share_display(); ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div><?php
    endif;
    }
}



if ( ! function_exists( 'epicjungle_single_post_nav' ) ) {
    function epicjungle_single_post_nav() {

        if ( ! class_exists( 'EpicJungle_Extensions' ) ) {
            return;
        }

        $prev_post = get_previous_post();
        $next_post = get_next_post();

        ?><nav class="d-md-flex justify-content-between pb-4 mb-5 mt-5" aria-label="<?php echo esc_attr__( 'Entry navigation', 'epicjungle' ); ?>">
            <?php if ( $prev_post ) : ?>
            <a class="cs-entry-nav mr-0 mr-md-3" href="<?php echo esc_url( get_permalink( $prev_post ) );?>">
                <h3 class="h5 pb-sm-2"><?php echo esc_html__( 'Prev post', 'epicjungle' ); ?></h3>
                <div class="media">
                    <?php if ( has_post_thumbnail( $prev_post ) ) : ?>
                    <div class="cs-entry-nav-thumb d-none d-sm-block pr-sm-3">
                        <?php echo get_the_post_thumbnail( $prev_post, 'thumbnail' ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="media-body">
                        <h4 class="nav-heading font-size-md font-weight-medium mb-0"><?php echo get_the_title( $prev_post ); ?></h4>
                        <span class="font-size-xs text-muted"><?php echo sprintf( esc_html__( 'by %s', 'epicjungle' ), get_the_author_meta( 'display_name', $prev_post->post_author ) ); ?></span>
                    </div>
                </div>
            </a>
            <?php endif; ?>

            <?php if ( $next_post ) : ?>
            <a class="cs-entry-nav ml-0 ml-md-3 mt-3 mt-md-0" href="<?php echo esc_url( get_permalink( $next_post ) );?>">
                <h3 class="h5 pb-sm-2 text-right"><?php echo esc_html__( 'Next post', 'epicjungle' ); ?></h3>
                <div class="media">
                    <div class="media-body text-right">
                        <h4 class="nav-heading font-size-md font-weight-medium mb-0"><?php echo get_the_title( $next_post ); ?></h4>
                        <span class="font-size-xs text-muted"><?php echo sprintf( esc_html__( 'by %s', 'epicjungle' ), get_the_author_meta( 'display_name', $next_post->post_author ) ); ?></span>
                    </div>
                    <?php if ( has_post_thumbnail( $next_post ) ) : ?>
                    <div class="cs-entry-nav-thumb d-none d-sm-block pl-sm-3">
                        <?php echo get_the_post_thumbnail( $next_post, 'thumbnail' ); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </a>
            <?php endif; ?>
        </nav><?php
    }
}

if( ! function_exists( 'epicjungle_comment_form_default_fields' ) ) {
    function epicjungle_comment_form_default_fields( $fields ) {
        $commenter = wp_get_current_commenter();
        $is_req    = (bool) get_option( 'require_name_email', 1 );

        // Remove url field
        unset( $fields['url'] );

        // Update other fields
        $fields['author'] = sprintf(
            '<div class="form-group comment-form-author">
                <label for="author" class="p-0">%1$s%4$s</label>
                <input type="text" name="author" id="author" class="form-control" value="%2$s" maxlength="245" %3$s>
            </div>',
            /* translators: comment author name */
            esc_html_x( 'Your name', 'front-end', 'epicjungle' ),
            esc_attr( $commenter['comment_author'] ),
            $is_req ? 'required' : '',
            $is_req ? '<span class="text-danger">*</span>' : ''
        );

        $fields['email'] = sprintf(
            '<div class="form-group comment-form-email">
                <label for="email" class="p-0">%1$s%4$s</label>
                <input type="email" name="email" id="email" class="form-control" value="%2$s" maxlength="100" aria-describedby="email-notes" %3$s>
            </div>',
            /* translators: comment author e-mail */
            esc_html_x( 'Your email', 'front-end', 'epicjungle' ),
            esc_attr( $commenter['comment_author_email'] ),
            $is_req ? 'required' : '',
            $is_req ? '<span class="text-danger">*</span>' : ''
        );

        if ( isset( $fields['cookies'] ) ) {
            $consent           = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
            $fields['cookies'] = sprintf(
                '<div class="custom-control custom-checkbox mb-3 comment-form-cookies-consent">
                    <input type="checkbox" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="custom-control-input" value="yes"' . $consent . '>
                    <label class="custom-control-label" for="wp-comment-cookies-consent">%s</label>
                </div>',
                esc_html_x( 'Save my name and email in this browser for the next time I comment.', 'front-end', 'epicjungle' )
            );
        }

        return $fields;
    }
}

if ( ! function_exists( 'epicjungle_post_protected_password_form' ) ) :
    function epicjungle_post_protected_password_form() {
        global $post;

        $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID ); ?>

        <form class="protected-post-form input-group epicjungle-protected-post-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
            <p><?php echo esc_html__( 'This content is password protected. To view it please enter your password below:', 'epicjungle' ); ?></p>
            <div class="d-flex align-items-center w-md-85">
                <label class="mb-0 mr-3 d-none d-md-block" for="<?php echo esc_attr( $label ); ?>"><?php echo esc_html__( 'Password:', 'epicjungle' ); ?></label>
                <div class="d-flex flex-grow-1">
                    <input class="input-text form-control" name="post_password" id="<?php echo esc_attr( $label ); ?>" type="password" style="border-top-right-radius: 0; border-bottom-right-radius: 0;"/>
                    <input type="submit" name="Submit" class="btn btn-primary font-weight-medium" value="<?php echo esc_attr( "Submit" ); ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; transform: none;"/>
                </div>
            </div>
        </form><?php
    }
endif;

if ( ! function_exists( 'epicjungle_single_related_posts' ) ) {
    function epicjungle_single_related_posts() {
        if ( apply_filters( 'epicjungle_enable_related_posts', filter_var( get_theme_mod( 'blog_related_posts', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) ) {
            if( empty( $post_id ) ) {
                $post_id = get_the_ID();
            }

            $tags = wp_get_post_terms( $post_id, 'post_tag', ['fields' => 'ids'] );

            if ( empty( $tags ) ) {
                return;
            }
            
            $related_post = new WP_Query(array( 
                'post_type'             => 'post',
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => 1,
                'orderby'               => 'date',
                'order'                 => 'desc',
                'posts_per_page'        => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_tag',
                        'terms'    => $tags
                    ),
                ),
            ));



                
            $carousel_args     = apply_filters( 'epicjungle_related_posts_carousel_args', array(
                'infinte'        => false,
                'items'          => 4,
                'autoplay'       => false,
                'autoHeight'     => true,
                'nav'            => true,
                'controls'       => false,
                'responsive'        => array(
                   
                    '0'      => array(
                        'items'      => 1,
                        'gutter'    => 16
                    
                    ),
                    
                    '500'      => array(
                        'items'      => 2,
                        'gutter'    => 16
                        
                    ),
                    
                
                    '850'      => array(
                        'items'      => 3,
                        'gutter'    => 16
                       
                    ),
                    
                 
                    '1100'      => array(
                        'items'      => 3,
                        'gutter'    => 23
                        
                    ),    
                
                 )
            ));


            if ( $related_post->have_posts() ) : ?>  
                <div class="pb-4 pb-md-5">
                    <h2 class="h3 pb-4"><?php echo apply_filters( 'epicjungle_related_post_heading', esc_html__( 'Related posts','epicjungle') ); ?></h2>  

                    <div class="cs-carousel">
                        <div class="products-carousel-wrap cs-carousel-inner related-post-carousel" data-carousel-options="<?php echo esc_attr( json_encode( $carousel_args ), ENT_QUOTES, 'UTF-8' ); ?>">
                            
                            <?php
                            while ( $related_post->have_posts() ):
                                $related_post->the_post();
                                get_template_part( 'templates/blog/loop', 'related' );
                            endwhile;
                            wp_reset_postdata(); ?>
                            
                        </div>
                    </div>
                </div><?php
            endif;
        }
    }
}