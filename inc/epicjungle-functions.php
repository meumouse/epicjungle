<?php
/**
 * EpicJungle functions.
 *
 * @package epicjungle
 */

use Elementor\Plugin;

if ( ! function_exists( 'epicjungle_is_woocommerce_activated' ) ) {
    /**
     * Query WooCommerce activation
     */
    function epicjungle_is_woocommerce_activated() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
}

if ( ! function_exists( 'epicjungle_option_enabled_post_types' ) ) {
    function epicjungle_option_enabled_post_types() {
        $post_types = [ 'post', 'page', 'docs', 'jetpack-portfolio' ];
        return apply_filters( 'epicjungle_option_enabled_post_types', $post_types );
    }

}

if ( ! function_exists( 'epicjungle_is_extensions_activated' ) ) {
    function epicjungle_is_extensions_activated() {
        return class_exists( 'EpicJungle_Extensions' ) ? true : false;
    }
}

function epicjungle_is_woocommerce_extension_activated( $extension ) {

	if( epicjungle_is_woocommerce_activated() ) {
		$is_activated = class_exists( $extension ) ? true : false;
	} else {
		$is_activated = false;
	}

	return $is_activated;
}

if( ! function_exists( 'epicjungle_is_yith_wcwl_activated' ) ) {
	
	function epicjungle_is_yith_wcwl_activated() {
		return epicjungle_is_woocommerce_extension_activated( 'YITH_WCWL' );
	}
}

if( ! function_exists( 'epicjungle_is_ocdi_activated' ) ) {
    /**
     * Check if One Click Demo Import is activated
     */
    function epicjungle_is_ocdi_activated() {
        return class_exists( 'OCDI_Plugin' ) ? true : false;
    }
}

if( ! function_exists( 'epicjungle_is_mas_wcvs_activated' ) ) {
    /**
     * Checks if MAS WooCommerce Variation Swatches activated
     *
     * @return boolean
     */
    function epicjungle_is_mas_wcvs_activated() {
        return epicjungle_is_woocommerce_extension_activated( 'MAS_WCVS' );
    }
}

if ( ! function_exists( 'epicjungle_is_jetpack_activated' ) ) {
    /**
     * Query JetPack activation
     */
    function epicjungle_is_jetpack_activated() {
        return class_exists( 'Jetpack' ) ? true : false;
    }
}

if ( ! function_exists( 'epicjungle_is_mas_static_content_activated' ) ) {
    /**
     * Query MAS Static Content activation
     */
    function epicjungle_is_mas_static_content_activated() {
        return class_exists( 'Mas_Static_Content' ) ? true : false;
    }
}

if ( ! function_exists( 'epicjungle_form_errors' ) ) {
    // used for tracking error messages
    function epicjungle_form_errors(){
        static $wp_error; // Will hold global variable safely
        return isset( $wp_error ) ? $wp_error : ( $wp_error = new WP_Error( null, null, null ) );
        
    }
}

if ( ! function_exists( 'epicjungle_show_error_messages' ) ) {
    function epicjungle_show_error_messages() {
        if( $codes = epicjungle_form_errors()->get_error_codes() ) {
            echo '<div class="notification alert alert-danger">';
                // Loop error codes and display errors
               foreach( $codes as $code ) {
                    $message = epicjungle_form_errors()->get_error_message( $code );
                    echo '<span>' . $message . '</span><br/>';
                
                }
            echo '</div>';
        }
    }
}

function epicjungle_form_success(){
    static $wp_error; // Will hold global variable safely
    return isset( $wp_error ) ? $wp_error : ( $wp_error = new WP_Error( null, null, null ) );
}

function epicjungle_bootstrap_pagination( \WP_Query $wp_query = null, $echo = true, $ul_class = '' ) {

    if ( null === $wp_query ) {
        global $wp_query;
    }

    $pages = paginate_links( [
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'format'       => '?paged=%#%',
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'total'        => $wp_query->max_num_pages,
            'type'         => 'array',
            'show_all'     => false,
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => esc_html__( '&laquo; Prev', 'epicjungle' ),
            'next_text'    => esc_html__( 'Next &raquo;', 'epicjungle' ),
            'add_args'     => false,
            'add_fragment' => ''
        ]
    );

    if ( is_array( $pages ) ) {

        if ( ! empty( $ul_class ) ) {
            $ul_class = ' ' . $ul_class;
        }

        $pagination = '<nav aria-label="' . esc_attr__( 'Page navigation', 'epicjungle' ) . '"><ul class="pagination' . esc_attr( $ul_class ) . '">';

        foreach ( $pages as $page ) {
            $pagination .= '<li class="page-item ' . ( strpos( $page, 'current' ) !== false ? 'active' : '' ) . '">' . str_replace( 'page-numbers', 'page-link', $page ) . '</li>';
        }

        $pagination .= '</ul></nav>';

        if ( $echo ) {
            echo wp_kses_post( $pagination );
        } else {
            return $pagination;
        }
    }

    return null;
}

function epicjungle_show_success_messages() {
    if( $codes = epicjungle_form_success()->get_error_codes() ) {
        echo '<div class="notification alert alert-success">';
            // Loop success codes and display success
           foreach( $codes as $code ) {
                $message = epicjungle_form_success()->get_error_message( $code );
                echo '<span>' . $message . '</span><br/>';
            }
        echo '</div>';
    }
}


// logs a member in after submitting a form
if ( ! function_exists( 'epicjungle_login_member' ) ) {
    function epicjungle_login_member() {
    
        if( isset( $_POST['epicjungle_login_check'] )  && wp_verify_nonce( $_POST['epicjungle_login_nonce'], 'epicjungle-login-nonce') ) {
            // this returns the user ID and other info from the user name
            if ( is_email( $_POST['username'] ) ) {
                $user =  get_user_by( 'email', $_POST['username'] );
            } else {
                $user =  get_user_by( 'login', $_POST['username'] );
            }

            if( ! $user ) {
                // if the user name doesn't exist
                epicjungle_form_errors()->add('empty_username', esc_html__('Invalid username or email address','epicjungle'));
            }

            do_action( 'epicjungle_custom_wp_login_form_custom_field_validation' );

            if ( ! empty( $user ) ) {
                 if( ! isset($_POST['password']) || $_POST['password'] == '' ) {
                    // if no password was entered
                    epicjungle_form_errors()->add('empty_password', esc_html__('Please enter a password','epicjungle'));
                }

                if( isset( $_POST['password'] ) && ! empty( $_POST['password'] ) ){
                    // check the user's login with their password
                    if( ! wp_check_password( $_POST['password'], $user->user_pass, $user->ID ) ) {
                        // if the password is incorrect for the specified user
                        epicjungle_form_errors()->add('empty_password', esc_html__('Incorrect password','epicjungle'));
                    }
                }

                // retrieve all error messages
                $errors = epicjungle_form_errors()->get_error_messages();

                // only log the user in if there are no errors
                if( empty( $errors ) ) {

                    $creds = array();
                    $creds['user_login'] = $user->user_login;
                    $creds['user_password'] = $_POST['password'];
                    $creds['remember'] = true;

                    $user = wp_signon( $creds, false );
                    // send the newly created user to the home page after logging them in
                    if ( is_wp_error($user) ){
                        echo wp_kses_post( $user->get_error_message() );
                    } else {
                        $oUser = get_user_by( 'login', $creds['user_login'] );
                        $aUser = get_object_vars( $oUser );
                        $sRole = $aUser['roles'][0];

                        if ( isset ( $_POST['redirect_to'] ) && ! empty( $_POST['redirect_to'] ) ) {
                            $redirect_url = wp_sanitize_redirect( wp_unslash( $_POST['redirect_to'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
                        } else {
                            $redirect_url = home_url( '/' );
                        }


                        wp_redirect( wp_validate_redirect( apply_filters( 'epicjungle_redirect_login_url', $redirect_url )) );
                    }
                    exit;
                }
            }
        }
    }
}

add_action( 'wp_loaded', 'epicjungle_login_member' );

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function epicjungle_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $located = epicjungle_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
        return;
    }

    // Allow 3rd party plugin filter template file from their plugin
    $located = apply_filters( 'epicjungle_get_template', $located, $template_name, $args, $template_path, $default_path );

    do_action( 'epicjungle_before_template_part', $template_name, $template_path, $located, $args );

    include( $located );
}


// register a new user
if ( ! function_exists( 'epicjungle_add_new_member' ) ) {
    function epicjungle_add_new_member() {
        if( isset( $_POST['epicjungle_register_check'] )  && wp_verify_nonce( $_POST['epicjungle_register_nonce'], 'epicjungle-register-nonce') ) {
            $register_user_name_enabled = apply_filters( 'epicjungle_register_user_name_enabled', true );
            $default_role = 'subscriber';
            $available_roles = array( 'subscriber' );

            if ( function_exists( 'epicjungle_is_wp_job_manager_activated' ) && epicjungle_is_wp_job_manager_activated() ) {
                $available_roles[] = 'employer';
            }

            
            $user_email     = sanitize_email( $_POST["email"] );
            $user_role      = ! empty( $_POST["epicjungle_user_role"] ) && in_array( $_POST["epicjungle_user_role"], $available_roles ) ? sanitize_text_field( $_POST["epicjungle_user_role"] ) : $default_role;


            if ( ! empty( $_POST["username"] ) ) {
                $user_login = sanitize_user( $_POST["username"] );
            } else {
                $user_login = sanitize_user( current( explode( '@', $user_email ) ), true );

                // Ensure username is unique.
                $append     = 1;
                $o_user_login = $user_login;

                while ( username_exists( $user_login ) ) {
                    $user_login = $o_user_login . $append;
                    $append++;
                }
            }

            if( username_exists( $user_login ) && $register_user_name_enabled ) {
                // Username already registered
                epicjungle_form_errors()->add('username_unavailable', esc_html__('Username already taken','epicjungle'));
            }
            if( ! validate_username( $user_login ) && $register_user_name_enabled ) {
                // invalid username
                epicjungle_form_errors()->add('username_invalid', esc_html__('Invalid username','epicjungle'));
            }
            if( $user_login == '' && $register_user_name_enabled ) {
                // empty username
                epicjungle_form_errors()->add('username_empty', esc_html__('Please enter a username','epicjungle'));
            }
            if( ! is_email( $user_email ) ) {
                //invalid email
                epicjungle_form_errors()->add('email_invalid', esc_html__('Invalid email','epicjungle'));
            }
            if( email_exists( $user_email ) ) {
                //Email address already registered
                epicjungle_form_errors()->add('email_used', esc_html__('Email already registered','epicjungle'));
            }


            $password = wp_generate_password();
            $password_generated = true;

            if ( apply_filters( 'epicjungle_register_password_enabled', true ) && ! empty( $_POST['password'] ) && ! empty( $_POST['confirmPassword'] ) ) {
                $password = $_POST['password'];
                $password_generated = false;
            }


            if ( $_POST['password'] != $_POST['confirmPassword'] ) {
                //Mismatched Password
                epicjungle_form_errors()->add( 'wrong_password', esc_html__('Password you entered is mismatched','epicjungle' ));
            }

            do_action( 'epicjungle_wp_register_form_custom_field_validation' );

            $errors = epicjungle_form_errors()->get_error_messages();

            // only create the user in if there are no errors
            if( empty( $errors ) ) {

                $new_user_data = array(
                    'user_login'        => $user_login,
                    'user_pass'         => $password,
                    'user_email'        => $user_email,
                    'role'              => $user_role,
                );

                $new_user_id = wp_insert_user( $new_user_data );

                if( $new_user_id ) {
                    // send an email to the admin alerting them of the registration
                    if( apply_filters( 'epicjungle_new_user_notification', false )  ) {
                        wc()->mailer()->customer_new_account( $new_user_id, $new_user_data, $password_generated );
                    } else {
                        wp_new_user_notification( $new_user_id, null, 'both' );
                    }

                    // log the new user in
                    $creds = array();
                    $creds['user_login'] = $user_login;
                    $creds['user_password'] = $password;
                    $creds['remember'] = true;
                    if( $password_generated ) {
                        epicjungle_form_success()->add('verify_user', esc_html__('Account created successfully. Please check your email to create your account password','epicjungle'));
                    } else {
                        $user = wp_signon( $creds, false );
                        // send the newly created user to the home page after logging them in
                        if ( is_wp_error( $user ) ) {
                            echo wp_kses_post( $user->get_error_message() );
                        } else {
                            $oUser = get_user_by( 'login', $creds['user_login'] );
                            $aUser = get_object_vars( $oUser );
                            $sRole = $aUser['roles'][0];

                            if( get_option( 'woocommerce_myaccount_page_id' ) ) {
                                $account_url = get_permalink( get_option('woocommerce_myaccount_page_id'));
                            } else {
                                $account_url = home_url( '/' );
                            }

                            if ( get_option( 'job_manager_job_dashboard_page_id' ) ) {
                                $job_url = get_permalink( get_option( 'job_manager_job_dashboard_page_id' ) );
                            } else {
                                $job_url = home_url( '/' );
                            }

                            switch( $sRole ) {
                                case 'subscriber':
                                    $redirect_url = $account_u;
                                    break;
                                case 'employer':
                                    $redirect_url = $job_url;
                                    break;

                                default:
                                    $redirect_url = home_url( '/' );
                                    break;
                            }

                            wp_redirect( apply_filters( 'epicjungle_redirect_register_url', $redirect_url, $user ));
                        }
                        exit;
                    }
                }
            }
        }
    }
}


add_action( 'wp_loaded', 'epicjungle_add_new_member' );

// logs a member in after submitting a form
if ( ! function_exists( 'epicjungle_lost_password' ) ) {
    function epicjungle_lost_password() {
    
        if( isset( $_POST['epicjungle_lost_password_check'] )  && wp_verify_nonce( $_POST['epicjungle_lost_password_nonce'], 'epicjungle-lost-password-nonce') ) {
            $login = isset( $_POST['user_login'] ) ? sanitize_user( wp_unslash( $_POST['user_login'] ) ) : ''; // WPCS: input var ok, CSRF ok.
            $user_data = get_user_by( 'login', $login );

            if ( empty( $login ) ) {
                epicjungle_form_errors()->add('empty_user_login', esc_html__('Enter a username or email address','epicjungle'));

            } else {
                // Check on username first, as customers can use emails as usernames.
                $user_data = get_user_by( 'login', $login );
            }
            // If no user found, check if it login is email and lookup user based on email.
            if ( ! $user_data && is_email( $login ) ) {
                $user_data = get_user_by( 'email', $login );
            }

            do_action( 'lostpassword_post');


            if( ! $user_data ) {
                // if the user name doesn't exist
                epicjungle_form_errors()->add( 'empty_user_login', esc_html__('There is no account with that username or email address.','epicjungle'));
            }


            if ( is_multisite() && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
                epicjungle_form_errors()->add('empty_user_login', esc_html__('Invalid username or email address.','epicjungle'));

                return false;
            }

            $errors = epicjungle_form_errors()->get_error_messages();

            // only create the user in if there are no errors
            if( empty( $errors ) ) {
                epicjungle_form_success()->add('verify_user', esc_html__('Passord has been sent to your email','epicjungle'));
                
            }
    
        }

    }
}
add_action( 'wp_loaded', 'epicjungle_lost_password' );

if ( ! function_exists( 'cs_gallery_shortcode' ) ) :

    function cs_gallery_shortcode( $attr ) {
        $post = get_post();

        static $instance = 0;
        $instance++;


        if ( ! empty( $attr['ids'] ) ) {
            if ( empty( $attr['orderby'] ) ) {
                $attr['orderby'] = 'post__in';
            }
            $attr['include'] = $attr['ids'];
        }

        $output = apply_filters( 'post_gallery', '', $attr, $instance );

        if ( ! empty( $output ) ) {
            return $output;
        }

        $html5 = current_theme_supports( 'html5', 'gallery' );
        $atts  = shortcode_atts(
            array(
                'order'      => 'ASC',
                'orderby'    => 'menu_order ID',
                'id'         => $post ? $post->ID : 0,
                'itemtag'    => $html5 ? 'div' : 'dl',
                'icontag'    => $html5 ? 'div' : 'dt',
                'captiontag' => $html5 ? 'div' : 'dd',
                'columns'    => 3,
                'size'       => 'thumbnail',
                'include'    => '',
                'exclude'    => '',
                'link'       => '',
            ),
            $attr,
            'gallery'
        );

        $id = intval( $atts['id'] );

        if ( ! empty( $atts['include'] ) ) {
            $_attachments = get_posts(
                array(
                    'include'        => $atts['include'],
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[ $val->ID ] = $_attachments[ $key ];
            }
        } elseif ( ! empty( $atts['exclude'] ) ) {
            $attachments = get_children(
                array(
                    'post_parent'    => $id,
                    'exclude'        => $atts['exclude'],
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );
        } else {
            $attachments = get_children(
                array(
                    'post_parent'    => $id,
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );
        }

        if ( empty( $attachments ) ) {
            return '';
        }

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                if ( ! empty( $atts['link'] ) ) {
                    if ( 'none' === $atts['link'] ) {
                        $output .= wp_get_attachment_image( $att_id, $atts['size'], false, $attr );
                    } else {
                        $output .= wp_get_attachment_link( $att_id, $atts['size'], false );
                    }
                } else {
                    $output .= wp_get_attachment_link( $att_id, $atts['size'], true );
                }
                $output .= "\n";
            }
            return $output;
        }

        $itemtag    = tag_escape( $atts['itemtag'] );
        $captiontag = tag_escape( $atts['captiontag'] );
        $icontag    = tag_escape( $atts['icontag'] );
        $valid_tags = wp_kses_allowed_html( 'post' );

        if ( ! isset( $valid_tags[ $itemtag ] ) ) {
            $itemtag = 'dl';
        }
        if ( ! isset( $valid_tags[ $captiontag ] ) ) {
            $captiontag = 'dd';
        }
        if ( ! isset( $valid_tags[ $icontag ] ) ) {
            $icontag = 'dt';
        }

        $columns   = intval( $atts['columns'] );
        $itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
        $float     = is_rtl() ? 'right' : 'left';

        $selector = "gallery-{$instance}";

        $size_class  = sanitize_html_class( $atts['size'] );
        $gallery_div = "<div id='$selector' class='cs-gallery galleryid-{$id} row row-cols-{$columns} gallery-size-{$size_class}'>";

        $output = apply_filters( 'gallery_style', $gallery_div );

        $i = 0;
        $total = count( $attachments );

        foreach ( $attachments as $id => $attachment ) {
            

            $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
     
            if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
                $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
            } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
                $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
                //$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
            } else {
                $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
            }

            $image_meta = wp_get_attachment_metadata( $id );

            $orientation = '';

            if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
                $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
            }

            if ( $i  === ( $total / 2 ) ) {
                $output .= "</div><div class='col-6 px-2 px-md-3 pt-md-6'>";
            } elseif ( $i === 0 ) {
                $output .= "<div class='col-6 px-2 px-md-3'>";
            }

            $output .= "$image_output";

            $output .= '<div class="d-none d-md-block mb-grid-gutter"></div>';

            if ( $captiontag && trim( $attachment->post_excerpt ) ) {
               /// $output .= 
               /// "
               // <span class='cs-gallery-caption' id='$selector-$id'>
               // " . wptexturize( $attachment->post_excerpt ) . "
              //  </span>";
            }



            $i++;
        }

        $output .= "</div></div>";

        return $output;
    }

endif;

if ( ! function_exists( 'cs_gallery_shortcode_light' ) ) :

    function cs_gallery_shortcode_light( $attr ) {
        $post = get_post();

        static $instance = 0;
        $instance++;

        if ( ! empty( $attr['ids'] ) ) {
            if ( empty( $attr['orderby'] ) ) {
                $attr['orderby'] = 'post__in';
            }
            $attr['include'] = $attr['ids'];
        }

        $output = apply_filters( 'post_gallery', '', $attr, $instance );

        if ( ! empty( $output ) ) {
            return $output;
        }

        $html5 = current_theme_supports( 'html5', 'gallery' );
        $atts  = shortcode_atts(
            array(
                'order'      => 'ASC',
                'orderby'    => 'menu_order ID',
                'id'         => $post ? $post->ID : 0,
                'itemtag'    => $html5 ? 'div' : 'dl',
                'icontag'    => $html5 ? 'div' : 'dt',
                'captiontag' => $html5 ? 'div' : 'dd',
                'columns'    => 3,
                'size'       => 'thumbnail',
                'include'    => '',
                'exclude'    => '',
                'link'       => '',
            ),
            $attr,
            'gallery'
        );

        $id = intval( $atts['id'] );

        if ( ! empty( $atts['include'] ) ) {
            $_attachments = get_posts(
                array(
                    'include'        => $atts['include'],
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[ $val->ID ] = $_attachments[ $key ];
            }
        } elseif ( ! empty( $atts['exclude'] ) ) {
            $attachments = get_children(
                array(
                    'post_parent'    => $id,
                    'exclude'        => $atts['exclude'],
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );
        } else {
            $attachments = get_children(
                array(
                    'post_parent'    => $id,
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );
        }

        if ( empty( $attachments ) ) {
            return '';
        }

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                if ( ! empty( $atts['link'] ) ) {
                    if ( 'none' === $atts['link'] ) {
                        $output .= wp_get_attachment_image( $att_id, $atts['size'], false, $attr );
                    } else {
                        $output .= wp_get_attachment_link( $att_id, $atts['size'], false );
                    }
                } else {
                    $output .= wp_get_attachment_link( $att_id, $atts['size'], true );
                }
                $output .= "\n";
            }
            return $output;
        }

        $itemtag    = tag_escape( $atts['itemtag'] );
        $captiontag = tag_escape( $atts['captiontag'] );
        $icontag    = tag_escape( $atts['icontag'] );
        $valid_tags = wp_kses_allowed_html( 'post' );

        if ( ! isset( $valid_tags[ $itemtag ] ) ) {
            $itemtag = 'dl';
        }
        if ( ! isset( $valid_tags[ $captiontag ] ) ) {
            $captiontag = 'dd';
        }
        if ( ! isset( $valid_tags[ $icontag ] ) ) {
            $icontag = 'dt';
        }

        $columns   = intval( $atts['columns'] );
        $itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
        $float     = is_rtl() ? 'right' : 'left';

        $selector = "gallery-{$instance}";

        $size_class  = sanitize_html_class( $atts['size'] );
        $gallery_div = "<div id='$selector' class='cs-gallery galleryid-{$id} row row-cols-{$columns} gallery-size-{$size_class}'>";

        $output = apply_filters( 'gallery_style', $gallery_div );

        $i = 0;

        foreach ( $attachments as $id => $attachment ) {

            $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';

            if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
                $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
            } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
                $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
                //$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
            } else {
                $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
            }

            $image_meta = wp_get_attachment_metadata( $id );

            $orientation = '';

            if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
                $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
            }

            $output .= "<{$itemtag} class='mb-grid-gutter'>";
            $output .= "$image_output";

            if ( $captiontag && trim( $attachment->post_excerpt ) ) {
               /// $output .= 
               /// "
               // <span class='cs-gallery-caption' id='$selector-$id'>
               // " . wptexturize( $attachment->post_excerpt ) . "
              //  </span>";
            }

            $output .= "</{$itemtag}>";

            if ( ! $html5 && $columns > 0 && 0 === ++$i % $columns ) {
                $output .= '<br style="clear: both" />';
            }
        }

        if ( ! $html5 && $columns > 0 && 0 !== $i % $columns ) {
            $output .= "
            <br style='clear: both' />";
        }

        $output .= "
        </div>\n";

        return $output;
    }

endif;

if ( ! function_exists( 'epicjungle_is_wedocs_activated' ) ) {
    /**
     * Query weDocs Activation
     */
    function epicjungle_is_wedocs_activated() {
        return class_exists( 'WeDocs' ) ? true: false;
    }
}

function epicjungle_implode_html_attributes( $raw_attributes ) {
    $attributes = array();
    foreach ( $raw_attributes as $name => $value ) {
        $attributes[] = esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
    }
    return implode( ' ', $attributes );
}

function epicjungle_selected( $value, $options ) {
    if ( is_array( $options ) ) {
        $options = array_map( 'strval', $options );
        return selected( in_array( (string) $value, $options, true ), true, false );
    }

    return selected( $value, $options, false );
}

function epicjungle_clean( $var ) {
    if ( is_array( $var ) ) {
        return array_map( 'epicjungle_clean', $var );
    } else {
        return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
    }
}

/**
 * Clean variables using wp_kses_post.
 * @param string|array $var
 * @return string|array
 */
function epicjungle_clean_kses_post( $var ) {
    return is_array( $var ) ? array_map( 'epicjungle_clean_kses_post', $var ) : wp_kses_post( stripslashes( $var ) );
}


function epicjungle_render_content( $post_id, $echo = false ) {
    if ( did_action( 'elementor/loaded' ) ) {
        $content = Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
    } else {
        $content = get_the_content( null, false, $post_id );
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
    }

    if ( $echo ) {
        echo wp_kses_post( $content );
    } else {
        return $content;
    }
}


function ar_has_children() {
    global $post;
    return count( get_posts( array( 'post_parent' => $post->ID, 'post_type' => $post->post_type ) ) );
}



function ar_get_current_page_depth(){
    global $wp_query;
     
    $object = $wp_query->get_queried_object();
    $parent_id  = $object->post_parent;
    $depth = 0;
    while($parent_id > 0){
        $page = get_page($parent_id);
        $parent_id = $page->post_parent;
        $depth++;
    }

    return $depth;
}

if ( ! function_exists( 'epicjungle_sass_yiq' ) ) {
    function epicjungle_sass_yiq( $hex ) {
        $hex = sanitize_hex_color( $hex );
        $length = strlen( $hex );
        if( $length < 5 ) {
            $hex = ltrim($hex,"#");
            $hex = '#' . $hex . $hex;
        }

        preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches);

        for($i = 1; $i <= 3; $i++) {
            $matches[$i] = hexdec($matches[$i]);
        }
        $yiq = (($matches[1]*299)+($matches[2]*587)+($matches[3]*114))/1000;
        return ($yiq >= 128) ? '#000' : '#fff';
    }
}

/**
 * Enables template debug mode
 *
 */
if ( ! function_exists( 'epicjungle_template_debug_mode' ) ) {
    function epicjungle_template_debug_mode() {
        if ( ! defined( 'EPICDROP_TEMPLATE_DEBUG_MODE' ) ) {
            $status_options = get_option( 'woocommerce_status_options', array() );
            if ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) {
                define( 'EPICDROP_TEMPLATE_DEBUG_MODE', true );
            } else {
                define( 'EPICDROP_TEMPLATE_DEBUG_MODE', false );
            }
        }
    }
}
add_action( 'after_setup_theme', 'epicjungle_template_debug_mode', 10 );


/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *      yourtheme       /   $template_path  /   $template_name
 *      yourtheme       /   $template_name
 *      $default_path   /   $template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
if ( ! function_exists( 'epicjungle_locate_template' ) ) {

    function epicjungle_locate_template( $template_name, $template_path = '', $default_path = '' ) {
        if ( ! $template_path ) {
            $template_path = 'templates/';
        }

        if ( ! $default_path ) {
            $default_path = 'templates/';
        }

        // Look within passed path within the theme - this is priority
        $template = locate_template(
            array(
                trailingslashit( $template_path ) . $template_name,
                $template_name
            )
        );

        // Get default template
        if ( ! $template || EPICDROP_TEMPLATE_DEBUG_MODE ) {
            $template = $default_path . $template_name;
        }

        // Return what we found
        return apply_filters( 'epicjungle_locate_template', $template, $template_name, $template_path );
    }
}
/**
 * Adjust a hex color brightness
 * Allows us to create hover styles for custom link colors
 *
 * @param  strong  $hex   hex color e.g. #111111.
 * @param  integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
 * @return string        brightened/darkened hex color
 * @since  1.0.0
 */
function epicjungle_adjust_color_brightness( $hex, $steps ) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter.
    $steps = max( -255, min( 255, $steps ) );

    // Format the hex color string.
    $hex = str_replace( '#', '', $hex );

    if ( 3 === strlen( $hex ) ) {
        $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
    }

    // Get decimal values.
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );

    // Adjust number of steps and keep it inside 0 to 255.
    $r = max( 0, min( 255, $r + $steps ) );
    $g = max( 0, min( 255, $g + $steps ) );
    $b = max( 0, min( 255, $b + $steps ) );

    $r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
    $g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
    $b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

    return '#' . $r_hex . $g_hex . $b_hex;
}

// Botões de compartilhamento
if ( ! function_exists( 'epicjungle_share_display' ) ) {

    function epicjungle_share_display() {

        if ( ! class_exists( 'EpicJungle_SocialShare' ) ) {
            return;
        }
        $services = EpicJungle_SocialShare::get_share_services();

        ?><h6 class="text-nowrap my-2 mr-3"><?php echo esc_html__( 'Share:', 'epicjungle' ); ?></h6>
        <ul class="d-inline list-unstyled list-inline list-social mb-0 pl-1">

        <?php foreach( $services as $service ) : if ( ! isset( $service['share'] ) ) { continue; } 
            $icon_class= str_replace( 'fe-', 'sb-',  $service['icon'] );
        ?>
            <li class="list-inline-item list-social-item mr-0 mb-0">
                <a href="<?php echo esc_url( $service[ 'share' ] ); ?>" class="social-btn sb-outline ml-1 my-2 <?php echo esc_attr( $icon_class ); ?>" target="_blank" rel="noopener noreferrer">
                    <?php if ( isset( $service['icon'] ) ) : ?>
                    <i class="list-social-icon <?php echo esc_attr( $service['icon'] ); ?>"></i>
                    <?php endif; ?>

                    <?php if ( isset( $service['name'] ) ) : ?>
                    <span class="sr-only"><?php echo sprintf( esc_html__( 'Share this on %s', 'epicjungle' ), $service['name' ] ); ?></span>
                    <?php endif; ?>
                </a>
            </li>

        <?php endforeach; ?>

        </ul><?php
    }
}
// ========

if ( ! function_exists( 'epicjungle_default_colors' ) ) :

    function epicjungle_default_colors() {
        $epicjungle_colors = [ [
            '_id'   => 'primary',
            'title' => esc_html__( 'Primary', 'epicjungle' ),
            'color' => '#00b774',
        ],[
            '_id'   => 'secondary',
            'title' => esc_html__( 'Secondary', 'epicjungle' ),
            'color' => '#f7f7fc',
        ],[
            '_id'   => 'success',
            'title' => esc_html__( 'Success', 'epicjungle' ),
            'color' => '#16c995',
        ],[
            '_id'   => 'info',
            'title' => esc_html__( 'Info', 'epicjungle' ),
            'color' => '#6a9bf4',
        ],[
            '_id'   => 'warning',
            'title' => esc_html__( 'Warning', 'epicjungle' ),
            'color' => '#ffb15c',
        ],[
            '_id'   => 'danger',
            'title' => esc_html__( 'Danger', 'epicjungle' ),
            'color' => '#f74f78',
        ],[
            '_id'   => 'light',
            'title' => esc_html__( 'Light', 'epicjungle' ),
            'color' => '#ffffff',
        ],[
            '_id'   => 'dark',
            'title' => esc_html__( 'Dark', 'epicjungle' ),
            'color' => '#37384e',
        ],[
            '_id'   => 'white',
            'title' => esc_html__( 'White', 'epicjungle' ),
            'color' => '#ffffff',
        ],[
            '_id'   => 'black',
            'title' => esc_html__( 'Black', 'epicjungle' ),
            'color' => '#000000',
        ],[
            '_id'   => 'text',
            'title' => esc_html__( 'Text', 'epicjungle' ),
            'color' => '#737491',
        ],[
            '_id'   => 'textmuted',
            'title' => esc_html__( 'Text Muted', 'epicjungle' ),
            'color' => '#9e9fb4',
        ],[
            '_id'   => 'gray100',
            'title' => esc_html__( 'Gray 100', 'epicjungle' ),
            'color' => '#f7f7fc',
        ],[
            '_id'   => 'gray200',
            'title' => esc_html__( 'Gray 200', 'epicjungle' ),
            'color' => '#f3f3f9',
        ],[
            '_id'   => 'gray300',
            'title' => esc_html__( 'Gray 300', 'epicjungle' ),
            'color' => '#e9e9f2',
        ],[
            '_id'   => 'gray400',
            'title' => esc_html__( 'Gray 400', 'epicjungle' ),
            'color' => '#dfdfeb',
        ],[
            '_id'   => 'gray500',
            'title' => esc_html__( 'Gray 500', 'epicjungle' ),
            'color' => '#9e9fb4',
        ],[
            '_id'   => 'gray600',
            'title' => esc_html__( 'Gray 600', 'epicjungle' ),
            'color' => '#737491',
        ],[
            '_id'   => 'gray700',
            'title' => esc_html__( 'Gray 700', 'epicjungle' ),
            'color' => '#5a5b75',
        ],[
            '_id'   => 'gray800',
            'title' => esc_html__( 'Gray 800', 'epicjungle' ),
            'color' => '#4a4b65',
        ],[
            '_id'   => 'gray900',
            'title' => esc_html__( 'Gray 900', 'epicjungle' ),
            'color' => '#37384e',
        ],[
            '_id'   => 'accent',
            'title' => esc_html__( 'Accent', 'epicjungle' ),
            'color' => '#766df4',
        ] ];

        return apply_filters( 'epicjungle_default_colors', $epicjungle_colors );
    }
endif;

function remove_jquery_migrate_notice() {
    $m= $GLOBALS['wp_scripts']->registered['jquery-migrate'];
    $m->extra['before'][]='temp_jm_logconsole = window.console.log; window.console.log=null;';
    $m->extra['after'][]='window.console.log=temp_jm_logconsole;';
}
add_action( 'init', 'remove_jquery_migrate_notice', 5 );


// Settings default for display avatar in details page of user woocommerce

// 1=sidebar, 2=account, 3=avatar on left column, upload on settings page, 4=dashboard
$wpp_location = get_option( 'wpp_photo_location', 2 );

// if the profile photo is overlapping the sidebar, try increasing this setting
$wpp_sidebar_top_margin = get_option( 'wpp_sidebar_top_margin' );

// profile photo side bar
$wpp_sidebar_profile_pic_width = get_option( 'wpp_sidebar_profile_pic_width', 100 ); // 100 default

// Max Upload Size in Bytes
$epicjungle_avatar_max_upload_size = 5000000;

// Allowed Mime Types
$epicjungle_allowed_mime_types = array(
	"jpg", 
	"jpeg", 
	"gif",
	"png",
	"webp",
  ); 

// Avatar size
$wpp_left_col_avatar_size  = 150;
$wpp_right_col_avatar_size = 300; 



/* this functions handles the photo upload */
function wc_cus_upload_picture( $profilepicture ) {   
	
	global $epicjungle_avatar_max_upload_size;
	global $epicjungle_allowed_mime_types;

	$wordpress_upload_dir = wp_upload_dir();
	// $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
	// $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
	$i = 1; // number of tries when the file with the same name is already exists
	$new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
	
	$image_raw_type = explode( '/', $profilepicture['type'] );
	$image_raw_type = $image_raw_type[1];
	
	if( !in_array( $image_raw_type, $epicjungle_allowed_mime_types )):
		$msg = 'Este tipo de arquivo não é permitido.';
		return $msg;
	endif;  
	
	/* we fixed this, mime_content_type() was not working */
	//$file_mime = mime_content_type( $profilepicture['tmp_name'] );
	$check         = getimagesize($profilepicture['tmp_name']);
	$file_mime_raw = $check["mime"];
	$file_mime     = explode( '/', $check["mime"] );
	$file_mime     = $file_mime[1]; 
	
	$log = new WC_Logger();        
	
	if( empty( $profilepicture ) ):
		$msg = 'Nenhum arquivo selecionado.';
		return $msg;
	endif;    
		
	if( $profilepicture['error'] ):
		$msg = $profilepicture['error'];
		return $msg;
	endif;  
		
	if( $profilepicture['size'] > $epicjungle_avatar_max_upload_size ): // wp_max_upload_size() or 50000 (ie)
		$msg = 'O arquivo é muito grande.';
		return $msg;
	endif;  
	
	if( !in_array( $file_mime, $epicjungle_allowed_mime_types )):
		$msg = 'Este tipo de arquivo não é permitido.';
		return $msg;
	endif;  
		       
	while( file_exists( $new_file_path ) ) :
		$i++;
		$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
	endwhile;
	
	// looks like everything is OK
	if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) :
		
		$upload_id = wp_insert_attachment( array(
		'guid'           => $new_file_path, 
		'post_mime_type' => $file_mime_raw,
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
		'post_content'   => '',
		'post_status'    => 'inherit'
		), $new_file_path );
		/* we fixed this, get_admin_url() was not working by itself */
		// wp_generate_attachment_metadata() won't work if you do not include this file
		require_once( str_replace( get_bloginfo( 'url' ) . '/', ABSPATH, get_admin_url() ) . 'includes/image.php' );
		// Generate and save the attachment metas into the database
		wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
		
		return $upload_id;
	endif;
}


// check if the user is in the dashboard section
function cust_is_user_in_dashboard(){
	
	// check if the user is in the dashboard section
	$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$dashboard_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );

	if( $dashboard_url == $current_url ): // to show only on dashboard section
		//echo 'WC Dashboard';
		return true;
	else:
		//echo 'no WC Dashboard';
		return false;
	endif;
}


//dirty solution to know what woocommerce user tab the current user is at
function cust_get_current_wc_tab(){
	
	// check if the user is in the dashboard section
	$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$current_url = explode( 'my-account', $current_url );
	//print_r($current_url);
	if( count( $current_url ) > 1 ):
		$current_url = explode( '?', $current_url[1] );
		$current_url = ltrim( $current_url[0], '/');
		$current_url = explode( '/', $current_url );
		$slug = $current_url[0];
		
		return $slug;
	else:
		return '';
	endif;
}


/**
 * Allow upload .svg files
 * 
 * @since 1.0.0
 */
add_filter('upload_mimes', 'epicjungle_allow_upload_svg_files');
function epicjungle_allow_upload_svg_files($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}


/**
 * Input terms and conditions checked is default
 * 
 * @since 1.0.0
 */
add_filter( 'woocommerce_terms_is_checked_default', '__return_true' );


/**
 * Input shipping to different address checked is not checked default
 * 
 * @since 1.0.0
 */
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );


/**
 * Output option free shipping in editor product
 * 
 * @since 1.7.0
 */
function epicjungle_options_shipping_product() {
    global $woocommerce, $post;

    echo '<div class="options_group">';

    woocommerce_wp_checkbox( 
    array( 
        'id'            => '_free_shipping_product', 
        'wrapper_class' => '', 
        'label'         => __( 'Frete grátis', 'epicjungle' ), 
        'description'   => __( 'Se ativo, este produto ficará com frete grátis, independente da regra de frete utilizada.', 'epicjungle' ) 
        )
    );
    
    echo '</div>';
}
add_action( 'woocommerce_product_options_shipping', 'epicjungle_options_shipping_product' );


/**
 * Save option free shipping in editor product
 *
 * @param int $post_id Post ID.
 */
function epicjungle_save_option_free_shipping( $post_id ) {
    $woocommerce_checkbox = isset( $_POST['_free_shipping_product'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_free_shipping_product', $woocommerce_checkbox );
}
add_action( 'woocommerce_process_product_meta', 'epicjungle_save_option_free_shipping' );


/**
 * Free shipping
 * 
 * @since 1.0.0
 */
function epicjungle_free_shipping_banner_single_product() { 
    global $product;

    $product_id = $product->get_id();
    $product_stock = $product->is_in_stock();
    $enable_free_shipping = get_post_meta( $product_id, '_free_shipping_product', true );
    $airplane_icon = get_template_directory_uri() . '/assets/img/airplane.png';
    $label_free_shipping_loading =  __( 'Carregando, aguarde...', 'epicjungle' );

    if ( $enable_free_shipping == 'yes' )  {
        echo '<div class="shipping-preview-line"><img class="shipping-country-flag fadeIn lazyloaded" id="img-envio-flag" src=" '.$airplane_icon.' "><p class="shipping-preview-loading">'.$label_free_shipping_loading.'</p><p class="custom-address"></p><p class="shipping-estimated"></p></div>';

        echo '<style>#shipping-calc{display:none;}</style>';
    }

    if ( ! $product->is_in_stock() ) {
        echo '<style>#shipping-calc, .shipping-preview-line{display:none;}</style>';
    }
}
add_action('woocommerce_product_meta_start', 'epicjungle_free_shipping_banner_single_product');


/**
 * Badge free shipping on loop products page
 * 
 * @since 1.0.0
 */
function epicjungle_badge_free_shipping() {
    global $product;
	$product_id = $product->get_id();
//    $product_price = $product->get_price();
	$get_free_shipping_option = get_post_meta( $product_id, '_free_shipping_product', true );
    $label_free_shipping =  __( 'Frete grátis', 'epicjungle' );
//    $get_free_shipping_settings = get_option('woocommerce_free_shipping_1_settings');
//    $amount_for_free_shipping = $get_free_shipping_settings['min_amount'];

    if ( $get_free_shipping_option == 'yes' )  {
        echo '<div class="msg-frete-gratis"><span class="txt-frete-gratis text-uppercase">'.$label_free_shipping.'</span></div>'; 
    }

}
add_action( 'woocommerce_before_shop_loop_item', 'epicjungle_badge_free_shipping', 20 );


/**
 * Hide other shipping methods if free shipping is available
 * 
 * @since 1.0.0
 */
add_filter( 'woocommerce_package_rates', 'epicjungle_hide_shipping_free_is_available', 100 );
function epicjungle_hide_shipping_free_is_available( $rates ) {

    $free = array();
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id && 'yes' == get_option( 'ejsp_hide_shipping_methods_if_free_shipping_available' ) ) {
            $free[ $rate_id ] = $rate;
            break;
        }
    }

    return ! empty( $free ) ? $free : $rates;
}


/**
 * Allow cancel orders
 * 
 * @since 1.0.0
 */
add_filter( 'woocommerce_valid_order_statuses_for_cancel', 'epicjungle_cancel_orders_frontend', 10, 2 );
function epicjungle_cancel_orders_frontend( $statuses, $order ){

    $custom_statuses    = array( 'pending', 'on-hold', 'failed' );
    $duration = 3;

    if( isset($_GET['order_id']))
        $order = wc_get_order( absint( $_GET['order_id'] ) );

    $delay = $duration*24*60*60;
    $date_created_time  = strtotime($order->get_date_created()); // Creation date time stamp
    $date_modified_time = strtotime($order->get_date_modified()); // Modified date time stamp
    $now = strtotime("now"); // Now  time stamp

    // Using Creation date time stamp
    if ( ( $date_created_time + $delay ) >= $now ) return $custom_statuses;
    else return $statuses;
}


/**
 * Rename WooCommerce status 'processing'
 * 
 * @since 1.0.0
 */
add_filter( 'wc_order_statuses', 'epicjungle_renaming_order_status' );
function epicjungle_renaming_order_status( $order_statuses ) {
    foreach ( $order_statuses as $key => $status ) {
        if ( 'wc-processing' === $key ) 
            $order_statuses['wc-processing'] = _x( 'Pedido em separação', 'Order status', 'woocommerce' );
    }
    return $order_statuses;
}


/**
 * Create a new status order for WooCommerce
 * 
 * @since 1.0.0
 */
function epicjungle_register_new_status() {
    register_post_status( 'wc-pedido-enviado', array(
        'label'                     => 'Pedido enviado',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Pedido enviado (%s)', 'Pedido enviado (%s)' )
    ) );
}
add_action( 'init', 'epicjungle_register_new_status' );

// Add on order list of WooCommerce
function epicjungle_order_shipped( $order_statuses ) {
    $new_order_statuses = array();

    // add new status after processing order status
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
			if ( 'wc-processing' === $key ) {
				$new_order_statuses['wc-pedido-enviado'] = 'Pedido enviado';
			}
    }
   return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'epicjungle_order_shipped' );


/**
 * Rename WooCommerce Myaccount navigation title
 * 
 * @since 1.0.0
 */
add_filter ( 'woocommerce_account_menu_items', 'epicjungle_renaming_itens_myaccount' );
 function epicjungle_renaming_itens_myaccount( $menu_items ){
    $menu_items['edit-address'] = 'Meus dados';
	$menu_items['edit-account'] = 'Perfil';

    return $menu_items;
}


/**
 * Rename button text in loop products
 * 
 * @since 1.0.0
 */
add_filter( 'woocommerce_product_add_to_cart_text', 'epicjungle_renaming_add_to_cart_text_archives' );  
function epicjungle_renaming_add_to_cart_text_archives() {
    return __( 'Adicionar ao carrinho', 'woocommerce' );
}


/**
 * Enable scroll default on editor text admin product
 * 
 * @since 1.0.0
 */
function epicjungle_disable_expand_editor_text_product_admin( $expand, $post_type ) {
    return false;
}
add_filter( 'wp_editor_expand', 'epicjungle_disable_expand_editor_text_product_admin', 10, 2);


/**
 * Display percentage discount in promotional price
 * 
 * @since 1.0.0
 */
add_filter( 'woocommerce_sale_flash', 'epicjungle_badge_sale', 20, 3 );
function epicjungle_badge_sale( $html, $post, $product ) {
    if( $product->is_type('variable')){
        $percentages = array();
        $prices = $product->get_variation_prices();
        
        foreach( $prices['price'] as $key => $price ){
            if( $prices['regular_price'][$key] !== $price ){
                $percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
            }
        }
        $percentage = max($percentages) . '%';
    }
    else {
        $regular_price = (float) $product->get_regular_price();
        $sale_price    = (float) $product->get_sale_price();
        $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
    }
    return '<span class="badge badge-danger font-size-ms ml-1 onsale"> ' . $percentage . ' '. __( 'OFF', 'epicjungle' ) .'</span>';
}


/**
 * Change position billing fields in checkout WooCommerce
 * 
 * @since 1.0.0
 */
add_filter( 'woocommerce_checkout_fields', 'epicjungle_change_priority_fields_checkout' );
function epicjungle_change_priority_fields_checkout( $checkout_fields ) {

    // Billing
    $checkout_fields[ 'billing' ][ 'billing_first_name' ][ 'priority' ] = 10;
    $checkout_fields[ 'billing' ][ 'billing_last_name' ][ 'priority' ] = 20;
    $checkout_fields[ 'billing' ][ 'billing_phone' ][ 'priority' ] = 40;
    $checkout_fields[ 'billing' ][ 'billing_email' ][ 'priority' ] = 60;
    $checkout_fields[ 'billing' ][ 'billing_postcode' ][ 'priority' ] = 70;
    $checkout_fields[ 'billing' ][ 'billing_address_1' ][ 'priority' ] = 80;
    $checkout_fields[ 'billing' ][ 'billing_address_2' ][ 'priority' ] = 95;
    $checkout_fields[ 'billing' ][ 'billing_city' ][ 'priority' ] = 110;
    $checkout_fields[ 'billing' ][ 'billing_state' ][ 'priority' ] = 120;
    $checkout_fields[ 'billing' ][ 'billing_country' ][ 'priority' ] = 130;

    return $checkout_fields;
}
// Integration with Brazilian Market on WooCommerce plugin
add_filter( 'woocommerce_checkout_fields', 'epicjungle_priority_fields_integrate_brazilian_market', 20, 1 );
function epicjungle_priority_fields_integrate_brazilian_market( $checkout_fields ) {
    if ( class_exists( 'Extra_Checkout_Fields_For_Brazil' ) ) {
        $checkout_fields[ 'billing' ][ 'billing_cpf' ][ 'priority' ] = 30;
        $checkout_fields[ 'billing' ][ 'billing_cellphone' ][ 'priority' ] = 45;
        $checkout_fields[ 'billing' ][ 'billing_number' ][ 'priority' ] = 90;
        $checkout_fields[ 'billing' ][ 'billing_neighborhood' ][ 'priority' ] = 100;

        return $checkout_fields;
    }
    else {
        return $checkout_fields;
    }
}



/**
 * Add to cart in AJAX
 * 
 * @since 1.6.0
 */        
function epicjungle_ajax_add_to_cart() {
    $product_id = apply_filters('ql_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('ql_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);
    
    if ( $passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
        do_action('ql_woocommerce_ajax_added_to_cart', $product_id);
        
        if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX::get_refreshed_fragments();
    }

    else {
        $data = array(
            'error' => true,
            'product_url' => apply_filters('ql_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));
        echo wp_send_json( $data );
    }

    wp_die();
}
add_action('wp_ajax_epicjungle_ajax_add_to_cart', 'epicjungle_ajax_add_to_cart'); 
add_action('wp_ajax_nopriv_epicjungle_ajax_add_to_cart', 'epicjungle_ajax_add_to_cart');

/**
 * Custom login page admin WordPress
 * 
 * @since 1.6.0
 */
function epicjungle_custom_wp_login() {
    $epicjungle_logo = get_template_directory_uri() . '/assets/img/epicjungle-logo.svg';
    ?>
    <style type="text/css">
    body {
        background-color: #f6f9fc !important;
    }

    #login h1 a, .login h1 a {
        background-image: url("<?php echo $epicjungle_logo; ?>");
        height: 6em;
        width: 6em;
        background-size: auto;
        background-repeat: no-repeat;
        padding-bottom: 10px;
    }

    #login h1 a:hover, .login h1 a:hover {
        opacity: 0.9;
    }

    #login {
        width: 400px !important;
    }

    .login form {
        padding: 1.5rem;
        border: 1px solid #dfdfeb !important;
        border-radius: .75rem;
    }

    input#rememberme {
        width: 2.875em;
        height: 1.5rem;
        margin-top: unset;
        border: unset;
        background-color: #b4bbc3;
        filter: none;
        float: left;
        border-radius: 2.875em;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        background-position: left center;
        transition: background-position .15s ease-in-out;
        background-size: contain;
        background-repeat: no-repeat;
        box-shadow: none;
        outline: none;
    }

    input#rememberme:checked::before {
        content: none;
    }

    input#rememberme:checked {
        background-color: #00b774;
        background-position: right center;
    }

    p.forgetmenot {
        margin-top: .5rem;
    }

    .login .forgetmenot label, .login .pw-weak label {
        margin-left: 0.25rem;
    }

    input#user_login, input#user_pass, input#user_email {
        display: block;
        width: 100%;
        height: calc(1.5em + 1.125rem + 2px);
        padding: 0.5625rem 1.125rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #737491;
        background-color: #fff !important;
        background-clip: padding-box;
        border: 1px solid #dfdfeb;
        border-radius: 0.5rem;
        box-shadow: 0 0 0 0 transparent;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    input#user_login:focus, input#user_pass:focus, input#user_email:focus {
        box-shadow: 0 0 0 0 transparent, 0 0.375rem 0.625rem -0.3125rem rgba(0, 183, 116, .15);
        border-color: rgba(0, 183, 116, .35);
    }

    #wp-submit, #correct-admin-email {
        display: inline-block;
        font-weight: 500;
        color: #fff !important;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: #00b774;
        border: 1px solid #00b774;
        padding: 0.5625rem 1.25rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.5rem;
        box-shadow: none;
        outline: none;
        transition: color 0.25s ease-in-out, background-color 0.25s ease-in-out, border-color 0.25s ease-in-out;
    }

    #wp-submit:hover, #correct-admin-email:hover {
        transform: translate(0px, 0px) !important;
        background-color: #00ad6a;
        border-color: #00a865;
    }

    .login label {
        color: #4a4b65;
        font-size: 0.875rem !important;
    }

    .login .button.wp-hide-pw:focus {
        box-shadow: none !important;
        outline: none !important;
        border: none !important;
    }
    
    .wp-core-ui .button, .wp-core-ui .button-secondary {
        color: #00b774 !important;
    }

    .login #backtoblog, .login #nav {
        display: inline-block;
    }

    .login #backtoblog {
        float: right;
        margin: 24px 0 0;
    }

    .login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover, .login #backtoblog a:focus, .login #nav a:focus, .login h1 a:focus {
        color: #00b774 !important;
        box-shadow: none;
    }

    form#language-switcher {
        border: none !important;
        margin-top: 2rem;
    }

    select#language-switcher-locales {
        padding: 0.825rem 3rem 0.825rem 1rem;
        -moz-padding-start: calc(1rem - 3px);
        font-size: 1em;
        font-weight: 400;
        line-height: 1.4;
        color: #576071;
        background-color: rgba(0,0,0,0);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23697488' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        border: 1px solid #d7dde2;
        border-radius: 0.5rem;
        transition: border-color .15s ease-in-out;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    select#language-switcher-locales:focus {
        box-shadow: 0 0 0 0 transparent, 0 0.375rem 0.625rem -0.3125rem rgba(0, 183, 116, .15);
        border-color: rgba(0, 183, 116, .35);
    }

    form#language-switcher input.button, .admin-email__actions-primary .button {
        display: inline-block;
        font-weight: 500;
        color: #00b774;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid #00b774;
        padding: 0.5625rem 1.25rem;
        font-size: 1rem;
        line-height: 1.5;
        margin-left: 0.5rem;
        border-radius: 0.5rem;
        outline: none;
        transition: color 0.25s ease-in-out, background-color 0.25s ease-in-out, border-color 0.25s ease-in-out;
    }

    form#language-switcher input.button:hover, admin-email__actions-primary .button:hover {
        color: #fff !important;
        background-color: #00b774;
        border-color: #00b774;
    }

    form#language-switcher input.button:focus, admin-email__actions-primary .button:focus {
        box-shadow: none !important;
    }

    </style> <?php
}
add_action( 'login_enqueue_scripts', 'epicjungle_custom_wp_login' );


/**
 * Product search in AJAX
 * 
 * @since 1.6.0
 */
function epicjungle_ajax_search_product() {

    global $wpdb, $woocommerce;

    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {

        $keyword = $_POST['keyword'];

        if (isset($_POST['category']) && !empty($_POST['category'])) {

            $category = $_POST['category'];

            $querystr = "SELECT DISTINCT * FROM $wpdb->posts AS p
            LEFT JOIN $wpdb->term_relationships AS r ON (p.ID = r.object_id)
            INNER JOIN $wpdb->term_taxonomy AS x ON (r.term_taxonomy_id = x.term_taxonomy_id)
            INNER JOIN $wpdb->terms AS t ON (r.term_taxonomy_id = t.term_id)
            WHERE p.post_type IN ('product')
            AND p.post_status = 'publish'
            AND x.taxonomy = 'product_cat'
            AND (
                (x.term_id = {$category})
                OR
                (x.parent = {$category})
            )
            AND (
                (p.ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_sku' AND meta_value LIKE '%{$keyword}%'))
                OR
                (p.post_content LIKE '%{$keyword}%')
                OR
                (p.post_title LIKE '%{$keyword}%')
            )
            ORDER BY t.name ASC, p.post_date DESC;";

        } else {
            $querystr = "SELECT DISTINCT $wpdb->posts.*
            FROM $wpdb->posts, $wpdb->postmeta
            WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id
            AND (
                ($wpdb->postmeta.meta_key = '_sku' AND $wpdb->postmeta.meta_value LIKE '%{$keyword}%')
                OR
                ($wpdb->posts.post_content LIKE '%{$keyword}%')
                OR
                ($wpdb->posts.post_title LIKE '%{$keyword}%')
            )
            AND $wpdb->posts.post_status = 'publish'
            AND $wpdb->posts.post_type = 'product'
            ORDER BY $wpdb->posts.post_date DESC";
        }

        $query_results = $wpdb->get_results($querystr);

        if (!empty($query_results)) {

            $output = '';

            foreach ($query_results as $result) {

                $categories = wp_get_post_terms($result->ID, 'product_cat');

                $output .= '<li class="search-results-product-item">';
                    $output .= '<a href="'.get_post_permalink($result->ID).'">';
                        $output .= '<div class="product-image">';
                            $output .= '<img src="'.esc_url(get_the_post_thumbnail_url($result->ID,'thumbnail')).'">';
                        $output .= '</div>';
                        $output .= '<div class="product-data">';
                            $output .= '<h3>'.$result->post_title.'</h3>';
                            if (!empty($categories)) {
                                $output .= '<div class="product-categories">';
                                    foreach ($categories as $category) {
                                        if ($category->parent) {
                                            $parent = get_term_by('id',$category->parent,'product_cat');
                                            $output .= '<span>'.$parent->name.'</span>';
                                        }
                                        $output .= '<span>'.$category->name.'</span>';
                                    }
                                $output .= '</div>';
                            }

                        $output .= '</div>';
                        $output .= '</a>';
                $output .= '</li>';
            }

            if (!empty($output)) {
                echo $output;
            }
        }
    }

    wp_die();
}
add_action( 'wp_ajax_search_product', 'epicjungle_ajax_search_product' );
add_action( 'wp_ajax_nopriv_search_product', 'epicjungle_ajax_search_product' );

function epicjungle_enqueue_scripts_search(){
    if (class_exists("Woocommerce")) {

        wp_register_script( 'epicjungle-ajax-search', get_template_directory_uri() . '/assets/js/ajax-search.js', array('jquery'), '', true);
        wp_localize_script(
            'epicjungle-ajax-search',
            'opt',
            array(
                'ajaxUrl'   => admin_url('admin-ajax.php'),
                'noResults' => esc_html__( 'Nenhum produto foi encontrado.', 'epicjungle' ),
            )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'epicjungle_enqueue_scripts_search' );

