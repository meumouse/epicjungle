<?php
/**
 * General Template Functions
 *
 */
if ( ! function_exists( 'epicjungle_breadcrumb' ) ) {

    /**
     * Output the WooCommerce Breadcrumb.
     *
     * @param array $args Arguments.
     */
    function epicjungle_breadcrumb( $args = array() ) {
        $args = wp_parse_args(
            $args,
            apply_filters(
                'epicjungle_breadcrumb_defaults',
                array(
                    'delimiter'   => '',
                    'wrap_before' => '<nav aria-label="breadcrumb"><ol class="pt-1 mt-2 breadcrumb breadcrumb-scroll">',
                    'wrap_after'  => '</ol></nav>',
                    'before'      => '<li class="breadcrumb-item mb-0">',
                    'after'       => '</li>',
                    'home'        => _x( 'Home', 'breadcrumb', 'epicjungle' ),
                )
            )
        );

        require_once get_template_directory() . '/inc/classes/class-epicjungle-breadcrumb.php';

        $breadcrumbs = new EpicJungle_Breadcrumb();

        if ( ! empty( $args['home'] ) ) {
            $breadcrumbs->add_crumb( $args['home'], apply_filters( 'epicjungle_breadcrumb_home_url', home_url() ) );
        }

        $args['breadcrumb'] = $breadcrumbs->generate();

        /**
         * WooCommerce Breadcrumb hook
         *
         * @hooked WC_Structured_Data::generate_breadcrumblist_data() - 10
         */
        do_action( 'epicjungle_breadcrumb', $breadcrumbs, $args );

        extract( $args );

        if ( ! empty( $breadcrumb ) ) {

            echo wp_kses_post( $wrap_before );

            foreach ( $breadcrumb as $key => $crumb ) {

                if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
                    echo sprintf( '%s<a href="%s" class="text-gray-700">%s</a>%s',
                        wp_kses_post( $before ),
                        esc_url( $crumb[1] ),
                        esc_html( $crumb[0] ),
                        wp_kses_post( $after )

                    );
                } else {
                    echo '<li class="breadcrumb-item active"><span>' . esc_html( $crumb[0] ) . '</span></li>';
                }
            }

            echo wp_kses_post( $wrap_after );

        }
    }
}

if ( ! function_exists( 'epicjungle_display_comments' ) ) {
    /**
     * EpicJungle display comments
     *
     * @since  1.0.0
     */
    function epicjungle_display_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || 0 !== intval( get_comments_number() ) ) :
            comments_template();
        endif;
    }
}

if ( ! function_exists( 'epicjungle_comment' ) ) {
    /**
     * EpicJungle comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int   $depth the comment depth.
     * @since 1.0.0
     */
    function epicjungle_comment( $comment, $args, $depth ) {
        if ( 'div' === $args['style'] ) {
            $tag       = 'div';
            $add_below = 'comment-reply-target';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }

        $comment_class = 'cs-comment';

        if ( ! empty( $args['has_children'] ) ) {
            $comment_class .= ' parent';
        }

        ?>
        <<?php echo esc_attr( $tag ); ?> <?php comment_class( $comment_class ); ?> id="comment-<?php comment_ID(); ?>">
        
        <div class="comment-body">
        
        <?php if ( 'div' !== $args['style'] ) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
        <?php endif; ?>
        
        <div class="comment-text">
           <?php comment_text(); ?>
        </div>
        
        <div class="comment-meta commentmetadata d-md-flex justify-content-between align-items-center">
            
            <div class="comment-author vcard media media-ie-fix align-items-center">

                <?php echo get_avatar( $comment, 42, '', get_comment_author( $comment ), [
                    'class' => 'rounded-circle mr-3',
                ] ); ?>
                <div class="media-body">
                    <?php printf( wp_kses_post( '<h4 class="fn font-size-sm mb-1">%s</h4>', 'epicjungle' ), str_replace( "class='url'", "class='url text-reset text-decoration-none'", get_comment_author_link() ) ); ?>
                    <div class="text-muted font-size-xs">
                        <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date text-reset">
                            <?php echo '<time datetime="' . esc_html( get_comment_date( 'c' ) ) . '">' . esc_html( get_comment_date() ) . '</time>'; ?>
                        </a>
                        <?php
                        if ( '0' === $comment->comment_approved ) : ?>
                        <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'epicjungle' ); ?></em>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="reply mt-4 mt-md-0"><?php
            
                comment_reply_link(
                    array_merge(
                        $args,
                        array(
                            'add_below' => $add_below,
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                        )
                    )
                );
                
                edit_comment_link( esc_html__( 'Edit', 'epicjungle' ), '  ', '' ); 
            
            ?></div>
        
        </div>
        
        <div id="comment-reply-target-<?php comment_ID(); ?>" class="comment-reply-target"></div>
        
        <?php if ( 'div' !== $args['style'] ) : ?>
        </div>
        <?php endif; ?>
    </div>
        
        <?php
    }
}


if ( ! function_exists( 'epicjungle_custom_uploaded_pre_avatar_override' ) ) :
    function epicjungle_custom_uploaded_pre_avatar_override( $args, $id_or_email ) {
        // Get user data.
        if ( is_numeric( $id_or_email ) ) {
            $user = get_user_by( 'id', (int) $id_or_email );
        } elseif ( is_object( $id_or_email ) ) {
            if( $id_or_email instanceof WP_User ) {
                $user = $id_or_email;
            } elseif ( $id_or_email instanceof WP_Post ) {
                // Post object.
                $user = get_user_by( 'id', (int) $id_or_email->post_author );
            } elseif ( $id_or_email instanceof WP_Comment ) {
                $comment = $id_or_email;
                if ( empty( $comment->user_id ) ) {
                    $user = get_user_by( 'id', $comment->user_id );
                } else {
                    $user = get_user_by( 'email', $comment->comment_author_email );
                }
                if ( ! $user ) {
                    return $args;
                }
            } else {
                return $args;
            }
        } elseif ( is_string( $id_or_email ) ) {
            $user = get_user_by( 'email', $id_or_email );
        } else {
            return $args;
        }
        if ( ! $user ) {
            return $args;
        }
        $user_id = $user->ID;

        // Get the post the user is attached to.
        $size = $args['size'];

        $img_id = get_user_meta( $user_id, '_epicjungle_custom_avatar_id', true );

        // Attempt to get the image in the right size.
        if( 0 < absint( $img_id ) ) {
            $args['url'] = wp_get_attachment_image_url( $img_id, array( $size, $size ) );
        }
        return $args;
    }
endif;

if ( ! function_exists( 'epicjungle_custom_uploaded_avatar_url_override' ) ) :
    function epicjungle_custom_uploaded_avatar_url_override( $url, $id_or_email, $args ) {
        // Get user data.
        if( $id_or_email instanceof WP_User ) {
            $user = $id_or_email;
        } elseif ( $id_or_email instanceof WP_Post ) {
            // Post object.
            $user = get_user_by( 'id', (int) $id_or_email->post_author );
        } elseif ( $id_or_email instanceof WP_Comment ) {
            if( is_a( $id_or_email, 'WP_User' ) ) {
                $user = $id_or_email;
            } elseif( is_a( $id_or_email, 'WP_Comment' ) ) {
                $comment = $id_or_email;
                if ( empty( $comment->user_id ) ) {
                    $user = get_user_by( 'id', $comment->user_id );
                } else {
                    $user = get_user_by( 'email', $comment->comment_author_email );
                }
                if ( ! $user ) {
                    return $url;
                }
            } else {
                return $url;
            }
        } elseif ( is_string( $id_or_email ) ) {
            $user = get_user_by( 'email', $id_or_email );
        } else {
            return $url;
        }
        if ( ! $user ) {
            return $url;
        }
        $user_id = $user->ID;

        // Get the post the user is attached to.
        $size = $args['size'];

        //Find ID of attachment saved user meta
        $img_id = get_user_meta( $user_id, '_epicjungle_custom_avatar_id', true );

        if( 0 < absint( $img_id ) ) {
            //return image url
            return wp_get_attachment_image_url( $img_id, array( $size, $size ) );
        }

        //return normal
        return $url;
    }
endif;

if ( ! function_exists( 'epicjungle_custom_uploaded_avatar_override' ) ) :
    function epicjungle_custom_uploaded_avatar_override( $args, $id_or_email ) {
        $email_hash = '';
        $user       = false;
        $email      = false;

        // Process the user identifier.
        if ( is_numeric( $id_or_email ) ) {
            $user = get_user_by( 'id', absint( $id_or_email ) );
        } elseif ( is_string( $id_or_email ) ) {
            if ( strpos( $id_or_email, '@md5.gravatar.com' ) ) {
                // MD5 hash.
                list( $email_hash ) = explode( '@', $id_or_email );
            } else {
                // Email address.
                $email = $id_or_email;
            }
        } elseif ( $id_or_email instanceof WP_User ) {
            // User object.
            $user = $id_or_email;
        } elseif ( $id_or_email instanceof WP_Post ) {
            // Post object.
            $user = get_user_by( 'id', (int) $id_or_email->post_author );
        } elseif ( $id_or_email instanceof WP_Comment ) {
            if ( ! empty( $id_or_email->user_id ) ) {
                $user = get_user_by( 'id', (int) $id_or_email->user_id );
            }
            if ( ( ! $user || is_wp_error( $user ) ) && ! empty( $id_or_email->comment_author_email ) ) {
                $email = $id_or_email->comment_author_email;
            }
        }
     
        if ( ! $email_hash ) {
            if ( $user ) {
                $email = $user->user_email;
            }
     
            if ( $email ) {
                $email_hash = md5( strtolower( trim( $email ) ) );
            }
        }
     
        if ( $email_hash ) {
            $args['found_avatar'] = true;
            $gravatar_server      = hexdec( $email_hash[0] ) % 3;
        } else {
            $gravatar_server = rand( 0, 2 );
        }
     
        $url_args = array(
            's' => $args['size'],
            'd' => $args['default'],
            'f' => $args['force_default'] ? 'y' : false,
            'r' => $args['rating'],
        );
     
        if ( is_ssl() ) {
            $url = 'https://secure.gravatar.com/avatar/' . $email_hash;
        } else {
            $url = sprintf( 'http://%d.gravatar.com/avatar/%s', $gravatar_server, $email_hash );
        }
     
        $url = add_query_arg(
            rawurlencode_deep( array_filter( $url_args ) ),
            set_url_scheme( $url, $args['scheme'] )
        );

        if( isset( $args['extra_attr'] ) ) {
            //$args['extra_attr'] .= ' gurl="' . $url . '"';
        } else {
            //$args['extra_attr'] = 'gurl="' . $url . '"';
        }

        return $args;
    }
endif;

if( ! function_exists( 'epicjungle_shares' ) ) {
    function epicjungle_shares() {
        /**
         * Share buttons provider
         *
         * @param string $provider
         */
        $provider = apply_filters( 'epicjungle_shares_provider', 'default' );

        /**
         * Display the share buttons by specific provider
         *
         * The dynamic part refers to provider. See filter "epicjungle_shares_provider" above.
         */
        do_action( "epicjungle_shares_{$provider}" );

        /**
         * Display the share buttons
         *
         * @param string $provider Share buttons provider
         */
        do_action( 'epicjungle_shares', $provider );
    }
}