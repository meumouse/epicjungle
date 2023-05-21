<?php
/**
* EpicJungle Template Functions used in WeDocs Integration
*
* @package EpicJungle/WeDocs
*
*/

if ( ! function_exists( 'ej_wedocs_sidebed_search' ) ) :
/**
* Displays Search in Sidebar
*
* @since 1.0.0
*/
function ej_wedocs_sidebed_search(){?>
    <div class="cs-widget mb-5">
        <h3 class="cs-widget-title"><?php esc_html_e( 'Search Help', 'epicjungle' ); ?></h3>
        <form role="search" method="get" class="search-form input-group-overlay" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="input-group-overlay">
                <div class="input-group-prepend-overlay">
                    <span class="input-group-text"><i class="fe-search"></i></span>
                </div>
                <input type="search" class="form-control prepended-form-control" placeholder="<?php echo esc_attr_x( 'Pesquisar...', 'placeholder', 'epicjungle' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"/>

            </div>
        </form>
    </div><?php  

}

endif;

if ( ! function_exists( 'ej_wedocs_sidebed_related_articles' ) ) :
/**
* Displays Related Articles in Sidebar
*
* @since 1.0.0
*/
function ej_wedocs_sidebed_related_articles() {

    global $post;

    $orig_post = $post;

    $related_articles_number = apply_filters( 'ej_wedocs_related_articles_number', 12 );

    $tags       = wp_get_post_tags( $post->ID );
    $categories = get_the_category( $post->ID );

    if ( $tags ) {
    
        $tag_ids = array();
        foreach( $tags as $tag ) {
            $tag_ids[] = $tag->term_id;
        }

        $related_articles_query_args = apply_filters( 'ej_wedocs_related_articles_query_args', array(
            'tag__in'             => $tag_ids,
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
            'ignore_sticky_posts' => 1,
            'post_type'           => $post->post_type,
        ), 'tags', $tag_ids );
    
    } elseif ( $categories ) {

        $category_ids = array();

        foreach( $categories as $category ) {
            $category_ids[] = $category->term_id;
        }

        $related_articles_query_args = apply_filters( 'ej_wedocs_related_articles_query_args', array(
            'category__in'        => $category_ids,
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
            'ignore_sticky_posts' => 1,
            'post_type'           => $post->post_type,
            ), 'categories', $category_ids );
    } else {

        $related_articles_query_args = apply_filters( 'ej_wedocs_related_articles_query_args', array(
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
            'ignore_sticky_posts' => 1,
            'post_type'           => $post->post_type,
            ) );

        if ( $post->post_parent ) {
            $related_articles_query_args['post_parent'] = $post->post_parent;
        } else {
            $related_articles_query_args['post_parent'] = $post->ID;
        }
    }

    $related_articles_query = new wp_query( $related_articles_query_args );

    if ( ! $related_articles_query->have_posts() ) {
        $related_articles_query_args = apply_filters( 'ej_wedocs_related_articles_query_args', array(
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
            'ignore_sticky_posts' => 1,
            'post_type'           => $post->post_type,
        ) );
        $related_articles_query = new wp_query( $related_articles_query_args );
    }

    if( $related_articles_query->have_posts() ):

        ?><div class="cs-widget mb-5">
            <h3 class="cs-widget-title"><?php esc_html_e( 'Related Articles', 'epicjungle' ); ?></h3>
            <ul><?php
            while( $related_articles_query->have_posts() ): $related_articles_query->the_post();  ?>
                <li class="d-flex">
                    <i class="fe-book text-muted mt-2 mr-2"></i>
                    <a class="cs-widget-link" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
        
        </div><?php

    endif;

    $post = $orig_post;
    wp_reset_postdata();
}
endif;


function epicjungle_get_docs_meta( $merge_default = true ) {
    global $post;

    if ( isset( $post->ID ) ) {

        $clean_docs_options = get_post_meta( $post->ID, '_docs_options', true );

        $docs_options = maybe_unserialize( $clean_docs_options );

        if( ! is_array( $docs_options ) ) {
            $docs_options = json_decode( $clean_docs_options, true );
        }

        $docs = $docs_options;

        return apply_filters( 'epicjungle_docs_meta', $docs, $post );
    }
}

if ( ! function_exists( 'ej_get_post_featured_icon' ) ) {
/**
* Displays Post Featured Icon
*
* @return boolean
*
*/
function ej_get_post_featured_icon( $thepostid = null ) {
    global $post;

    $thepostid = isset( $thepostid )? $thepostid : $post->ID;

    $clean_docs_meta_values = get_post_meta( $thepostid, '_docs_options', true );
    $post_featured_icon = maybe_unserialize( $clean_docs_meta_values );

    $featured_icon = isset( $post_featured_icon['post_featured_icon'] ) && ! empty( $post_featured_icon['post_featured_icon'] ) ? $post_featured_icon['post_featured_icon'] : false;

    return $featured_icon;
}
}


if ( ! function_exists( 'ej_get_post_featured_icon_bg' ) ) {
/**
* Displays Post Featured Icon
*
* @return boolean
*
*/
function ej_get_post_featured_icon_bg( $thepostid = null ) {
    global $post;

    $thepostid = isset( $thepostid )? $thepostid : $post->ID;

    $clean_docs_meta_values = get_post_meta( $thepostid, '_docs_options', true );
    $post_featured_icon     = maybe_unserialize( $clean_docs_meta_values );

    $featured_icon_bg = isset( $post_featured_icon['post_featured_icon_bg'] ) && ! empty( $post_featured_icon['post_featured_icon_bg'] ) ? $post_featured_icon['post_featured_icon_bg'] : false;

    return $featured_icon_bg;
}
}

if ( ! function_exists( 'ej_wedocs_featured_icon' ) ):
/**
* Displays Docs Featured Icon
*/
function ej_wedocs_featured_icon( $thepostid = null, $wrap_css = 'h2 mt-2 mb-4' ) {
    $featured_icon    = ej_get_post_featured_icon( $thepostid );
    $featured_icon_bg = ej_get_post_featured_icon_bg( $thepostid );

    if ( $featured_icon ) {
        $icon    = $featured_icon;
        $icon_bg = $featured_icon_bg;
    } else {
        $icon    = 'fe fe-users';
        $icon_bg = 'primary';
    }

    $icon_wrap_css = 'text-' . $icon_bg .'';

    if ( ! empty( $wrap_css ) ) {
        $icon_wrap_css .= ' ' . $wrap_css;
    }

    ?><i class="<?php echo esc_attr( $icon .' '. $icon_wrap_css ); ?>"></i>
    <?php
}
endif;

if ( ! function_exists( 'ej_wedocs_submit_request_modal' ) ) :
    /**
     * Displays Submit a Request button and the modal box
     *
     * @since 1.0.0
     */
    function ej_wedocs_submit_request_modal( $spacing_class = 'py-6' ) {
        $hide_action = get_theme_mod( 'ej_helpcenter_action_disable', false );
        $is_modal = get_theme_mod( 'ej_helpcenter_action_is_modal', true );

        if ($hide_action == false) {
            if ( wedocs_get_option( 'email', 'wedocs_settings', 'on' ) == 'on' ): ?>
                <div class="bg-secondary <?php echo esc_attr( $spacing_class ); ?>">
                    <div class="container text-center">
                        <h2 class="h3 pb-2 mb-4" data-ed-customizer="action_title">
                            <?php echo wp_kses_post( get_theme_mod( 'ej_helpcenter_action_title', 'Não encontrou a resposta? Nós podemos ajudar!' ) ); ?>
                        </h2>
                        <i class="<?php echo esc_attr( get_theme_mod( 'ej_helpcenter_action_icon_class', 'fe-life-buoy' ) ); ?> d-block h2 pb-2 mb-4 text-primary" data-ed-customizer="action_iconclass"></i>
                        <a<?php echo esc_attr( $is_modal == true ? ' id=wedocs-stuck-modal data-toggle=modal data-target=#wedocs-contact-modal' : '' ) ?> class="btn btn-primary mb-4" href="<?php echo esc_url( get_theme_mod( 'ej_helpcenter_action_link', '#' ) ); ?>" data-ed-customizer="action_btntext"><?php echo wp_kses_post( get_theme_mod( 'ej_helpcenter_action_btntext', 'Entrar em contato' ) ); ?></a>
                        <p class="font-size-sm mb-0" data-ed-customizer="action_subtitle">
                            <?php echo wp_kses_post( get_theme_mod( 'ej_helpcenter_action_subtitle', 'Entre em contato conosco e retornaremos o mais breve possível.' ) ); ?>
                        </p>
                    </div>
                </div>
            <?php endif;
        }
    }
endif;


if ( ! function_exists( 'ej_wedocs_submit_request_modal_single_doc' ) ) :
    /**
     * Displays Submit a Request button and the modal box
     *
     * @since 1.0.0
     */
    function ej_wedocs_submit_request_modal_single_doc() {
        $hide_action = get_theme_mod( 'ej_helpcenter_action_disable', false );
        $is_modal = get_theme_mod( 'ej_helpcenter_action_is_modal', true );

        if ($hide_action == false) {
            if ( wedocs_get_option( 'email', 'wedocs_settings', 'on' ) == 'on' ): ?>
               
                <div class="submit-request text-center pt-6 pb-5 pb-md-6">
                    <h2 class="h3 pb-2 mb-4" data-ed-customizer="action_title">
                        <?php echo wp_kses_post( get_theme_mod( 'ej_helpcenter_action_title', 'Não encontrou a resposta? Nós podemos ajudar!' ) ); ?>
                    </h2>

                    <i class="<?php echo esc_attr( get_theme_mod( 'ej_helpcenter_action_icon_class', 'fe-life-buoy' ) ); ?> d-block h2 pb-2 mb-4 text-primary" data-ed-customizer="action_iconclass"></i>

                    <a<?php echo esc_attr( $is_modal == true ? ' id=wedocs-stuck-modal data-toggle=modal data-target=#wedocs-contact-modal' : '' ) ?> class="btn btn-primary mb-4" href="<?php echo esc_url( get_theme_mod( 'ej_helpcenter_action_link', '#' ) ); ?>" data-ed-customizer="action_btntext"><?php echo wp_kses_post( get_theme_mod( 'ej_helpcenter_action_btntext', 'Entrar em contato' ) ); ?></a>

                    <p class="font-size-sm mb-0" data-ed-customizer="action_subtitle">
                        <?php echo wp_kses_post( get_theme_mod( 'ej_helpcenter_action_subtitle', 'Entre em contato conosco e retornaremos o mais breve possível.' ) ); ?>
                    </p>
                </div>

                <?php wedocs_get_template_part( 'content', 'modal' ); ?>
         
            <?php endif;
        }
    }
endif;

if ( ! function_exists( 'ej_wedocs_single_doc_content' ) ):
    function ej_wedocs_single_doc_content() {
        global $post;
        ?><div class="entry-content mt-0" itemprop="articleBody">
            <?php
                the_content( sprintf(
                    /* translators: %s: Name of current post. */
                    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'epicjungle' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );
                do_action( 'epicjungle_wedocs_entry_footer' );?>
        </div><!-- .entry-content --><?php

    }
endif;

if ( ! function_exists( 'ej_wedocs_article_published_date' ) ):
    function ej_wedocs_article_published_date() {
        ?><meta itemprop="datePublished" content="<?php echo get_the_time( 'c' ); ?>"/>
        <time class="blog-entry-meta-link" itemprop="dateModified" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"   ><?php printf( esc_html__( 'Posted on %s', 'epicjungle' ), get_the_modified_date() ); ?></time><?php
    }
endif;

if ( ! function_exists( 'ej_wedocs_display_helpful_feedback' ) ):
    /**
     * Displays Helpful Feedback Links
     *
     * @since 1.0.0
     */
    function ej_wedocs_display_helpful_feedback() {
         if ( wedocs_get_option( 'helpful', 'wedocs_settings', 'on' ) == 'on' ):
            wedocs_get_template_part( 'content', 'feedback' );
        endif;
    }
endif;