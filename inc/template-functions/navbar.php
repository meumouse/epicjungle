<?php
/**
 * Navbar Template functions
 *
 */
if ( ! function_exists( 'epicjungle_navbar_toggler' ) ) {
    function epicjungle_navbar_toggler() {
        ?><button class="navbar-toggler ml-n2 mr-2" type="button" data-toggle="offcanvas" data-offcanvas-id="primaryMenu">
            <span class="navbar-toggler-icon"></span>
        </button><?php
    }
}

if ( ! function_exists( 'epicjungle_navbar_brand' ) ) {
    function epicjungle_navbar_brand() {
        $header_variant = epicjungle_navbar_variant();

        epicjungle_site_title_or_logo();

        if ( ( ( epicjungle_navbar_is_transparent() && epicjungle_is_transparent_logo() ) || $header_variant === 'dashboard' ) && epicjungle_navbar_is_sticky() && (int) get_theme_mod( 'sticky_logo') > 0  ):
            epicjungle_sticky_header_logo();
        endif;
        epicjungle_mobile_logo();
    }
}

if ( ! function_exists( 'epicjungle_navbar_brand_icon' ) ) {
    function epicjungle_navbar_brand_icon() {
        $site_icon_url = get_site_icon_url( 58 );
        if ( ! empty( $site_icon_url ) ) {
            ?><img class="d-lg-none" width="58" src="<?php echo esc_url( $site_icon_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php
        }
    }
}

if( ! function_exists( 'epicjungle_topbar_skin' ) ) {
    function epicjungle_topbar_skin() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $topbar_skin = isset( $ej_page_options['header']['topbar_skin'] ) ? $ej_page_options['header']['topbar_skin'] : 'dark';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $topbar_skin = get_theme_mod( 'shop_topbar_skin', 'dark' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $topbar_skin = get_theme_mod( 'blog_topbar_skin', 'dark' );
        } else {
            $topbar_skin = get_theme_mod( 'topbar_skin', 'dark' );
        }


        return sanitize_key( apply_filters( 'epicjungle_topbar_skin', $topbar_skin ) );
    }
}

if( ! function_exists( 'epicjungle_navbar_skin' ) ) {
    function epicjungle_navbar_skin() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $navbar_skin = isset( $ej_page_options['header']['navbar_skin'] ) ? $ej_page_options['header']['navbar_skin'] : 'light';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $navbar_skin = get_theme_mod( 'shop_navbar_skin', 'light' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $navbar_skin = get_theme_mod( 'blog_navbar_skin', 'light' );
        } else {
            $navbar_skin = get_theme_mod( 'navbar_skin', 'light' );
        }

        return sanitize_key( apply_filters( 'epicjungle_navbar_skin', $navbar_skin ) );
    }
}

if( ! function_exists( 'epicjungle_navbar_is_boxshadow' ) ) {
    function epicjungle_navbar_is_boxshadow() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_boxshadow = isset( $ej_page_options['header']['enable_boxshadow'] ) ? $ej_page_options['header']['enable_boxshadow'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_boxshadow = get_theme_mod( 'shop_enable_boxshadow', 'yes' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_boxshadow = get_theme_mod( 'blog_enable_boxshadow', 'yes' );
        } else {
            $enable_boxshadow = get_theme_mod( 'enable_boxshadow', 'yes' );
        }

        return apply_filters( 'epicjungle_enable_boxshadow', filter_var( $enable_boxshadow, FILTER_VALIDATE_BOOLEAN ) );
    }
}

if( ! function_exists( 'epicjungle_navbar_button_variant_boxshadow' ) ) {
    function epicjungle_navbar_button_variant_boxshadow() {

        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_button_variant_boxshadow = isset( $ej_page_options['header']['enable_button_variant_boxshadow'] ) ? $ej_page_options['header']['enable_button_variant_boxshadow'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_button_variant_boxshadow = get_theme_mod( 'shop_enable_button_variant_boxshadow', 'no' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_button_variant_boxshadow = get_theme_mod( 'blog_enable_button_variant_boxshadow', 'no' );
        } else {
            $enable_button_variant_boxshadow = get_theme_mod( 'enable_button_variant_boxshadow', 'no' );
        }


        return apply_filters( 'epicjungle_enable_button_variant_boxshadow', filter_var( $enable_button_variant_boxshadow, FILTER_VALIDATE_BOOLEAN ) );
    }
}



if ( ! function_exists( 'epicjungle_404_page_boxshadow' ) ) {
    function epicjungle_404_page_boxshadow( $enable_boxshadow ) {
        if ( is_404() ) {
            $enable_boxshadow='';
        }
        
        return $enable_boxshadow;
    }
}


if ( ! function_exists( 'epicjungle_navbar_is_search' ) ) {
    /**
     * Enable Search
     */
    function epicjungle_navbar_is_search() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_search = isset( $ej_page_options['header']['enable_search'] ) ? $ej_page_options['header']['enable_search'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_search = get_theme_mod( 'shop_enable_search', 'yes' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_search = get_theme_mod( 'blog_enable_search', 'yes' );
        } else {
            $enable_search = get_theme_mod( 'enable_search', 'yes' );
        }

        return apply_filters( 'epicjungle_enable_search', filter_var( $enable_search, FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'epicjungle_navbar_is_sticky' ) ) {
    /**
     * Enable Sticky
     */
    function epicjungle_navbar_is_sticky() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_sticky = isset( $ej_page_options['header']['enable_sticky'] ) ? $ej_page_options['header']['enable_sticky'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_sticky = get_theme_mod( 'shop_enable_sticky', 'yes' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_sticky = get_theme_mod( 'blog_enable_sticky', 'yes' );
        } else {
            $enable_sticky = get_theme_mod( 'enable_sticky', 'yes' );
        }

        return apply_filters( 'epicjungle_enable_sticky', filter_var( $enable_sticky, FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'epicjungle_navbar_is_transparent' ) ) {
    /**
     * Enable Transparent
     */
    function epicjungle_navbar_is_transparent() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_transparent     = isset( $ej_page_options['header']['enable_transparent'] ) ? $ej_page_options['header']['enable_transparent'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_transparent     = get_theme_mod( 'shop_enable_transparent', 'no' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_transparent     = get_theme_mod( 'blog_enable_transparent', 'no' );
        } else {
            $enable_transparent     = get_theme_mod( 'enable_transparent', 'no' );
        }

        return apply_filters( 'epicjungle_enable_transparent', filter_var( $enable_transparent, FILTER_VALIDATE_BOOLEAN ) );
    }
}


if ( ! function_exists( 'epicjungle_navbar_transparent_text_color' ) ) {
    /**
     * Enable Transparent
     */
    function epicjungle_navbar_transparent_text_color() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $transparent_text_color = isset( $ej_page_options['header']['transparent_text_color'] ) ? $ej_page_options['header']['transparent_text_color'] : 'dark';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $transparent_text_color = get_theme_mod( 'shop_transparent_text_color', 'dark' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $transparent_text_color = get_theme_mod( 'blog_transparent_text_color', 'dark' );
        } else {
            $transparent_text_color = get_theme_mod( 'transparent_text_color', 'dark' );
        }

        return sanitize_key( apply_filters( 'epicjungle_transparent_text_color', $transparent_text_color ) );
    }
}


if ( ! function_exists( 'epicjungle_is_transparent_logo' ) ) {
    /**
     * Enable Search
     */
    function epicjungle_is_transparent_logo() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_transparent_logo = isset( $ej_page_options['header']['enable_transparent_logo'] ) ? $ej_page_options['header']['enable_transparent_logo'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_search = get_theme_mod( 'shop_enable_transparent_logo', 'yes' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_search = get_theme_mod( 'blog_enable_transparent_logo', 'yes' );
        } else {
            $enable_transparent_logo = get_theme_mod( 'enable_transparent_logo', 'yes' );
        }

        return apply_filters( 'epicjungle_is_transparent_logo', filter_var( $enable_transparent_logo, FILTER_VALIDATE_BOOLEAN ) );
    }
}



if ( ! function_exists( 'epicjungle_navbar_is_account' ) ) {
    /**
     * Enable Search
     */
    function epicjungle_navbar_is_account() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_account = isset( $ej_page_options['header']['enable_account'] ) ? $ej_page_options['header']['enable_account'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_account = get_theme_mod( 'shop_enable_account', 'yes' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_account = get_theme_mod( 'blog_enable_account', 'yes' );
        } else {
            $enable_account = get_theme_mod( 'enable_account', 'yes' );
        }

        return apply_filters( 'epicjungle_enable_account', filter_var( $enable_account, FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'epicjungle_navbar_is_cart' ) ) {
    /**
     * Enable Cart
     */
    function epicjungle_navbar_is_cart() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_cart = isset( $ej_page_options['header']['enable_cart'] ) ? $ej_page_options['header']['enable_cart'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_cart = get_theme_mod( 'shop_enable_cart', 'yes' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_cart = get_theme_mod( 'blog_enable_cart', 'yes' );
        } else {
            $enable_cart = get_theme_mod( 'enable_cart', 'yes' );
        }

        return apply_filters( 'epicjungle_enable_cart', filter_var( $enable_cart, FILTER_VALIDATE_BOOLEAN ) );
    }
}

/**
 * Returns a logo for 
 *
 * @return string
 */
if( ! function_exists( 'epicjungle_sticky_header_logo' ) ) {
    function epicjungle_sticky_header_logo( $echo = true, $classes = array() ) {

        $defaults = array(
            'custom-logo-link' => 'navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4 navbar-stuck-logo sticky-logo-link',
            'custom-logo'      => 'navbar-stuck-logo',
            'site-title'       => 'navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4 navbar-stuck-logo'
        );
        $classes  = wp_parse_args( $classes, $defaults );

        $sticky_logo_id = (int) get_theme_mod( 'sticky_logo' );
        
        if ( $sticky_logo_id ) {
            // User uploads a sticky logo via Customizer
            $sticky_logo_attr = [
                'class' => 'navbar-stuck-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $sticky_logo_alt = get_post_meta( $sticky_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $sticky_logo_alt ) ) {
                $sticky_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $sticky_logo_meta  = wp_get_attachment_metadata( $sticky_logo_id );
            $sticky_logo_width = isset( $sticky_logo_meta['width'] ) ? (int) $sticky_logo_meta['width'] : 148;

            $html = sprintf(
                '<a href="%1$s" class="navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4 navbar-stuck-logo" rel="home">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $sticky_logo_id, 'full', false, $sticky_logo_attr )
                
            );


        } elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
            $html = get_custom_logo();
        } else {
            $html = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="site-title">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
        }

        foreach ( $classes as $search => $replace ) {
            $html = str_replace( $search, $replace, $html );
        }

        if ( ! $echo ) {
            return $html;
        }

        echo wp_kses_post ( apply_filters( 'epicjungle_sticky_logo', $html ));
    }
}


/**
 * Returns a logo for mobile
 *
 * @return string
 */
if( ! function_exists( 'epicjungle_mobile_logo' ) ) {
    function epicjungle_mobile_logo( $echo = true, $classes = array() ) {

        $defaults = array (
            'custom-logo-link' => 'navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4 d-lg-none mobile-logo-link',
            'custom-logo'      => 'navbar-brand-img d-lg-none',
            'site-title'       => 'navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4 d-lg-none'
        );
        $classes  = wp_parse_args( $classes, $defaults );

        $mobile_logo_id = (int) get_theme_mod( 'mobile_logo' );
        
        if ( $mobile_logo_id ) {
            // User uploads a mobile logo via Customizer
            $mobile_logo_attr = [
                'class' => 'd-lg-none',
            ];

            // If the logo alt attribute is empty, get the site title
            $mobile_logo_alt = get_post_meta( $mobile_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $mobile_logo_alt ) ) {
                $mobile_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $mobile_logo_meta  = wp_get_attachment_metadata( $mobile_logo_id );
            $mobile_logo_width = isset( $mobile_logo_meta['width'] ) ? (int) $mobile_logo_meta['width'] : 148;

            $html = sprintf(
                '<a href="%1$s" class="navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4 d-lg-none" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $mobile_logo_id, 'full', false, $mobile_logo_attr ),
                (float) $mobile_logo_width / 2
                
            );
            
        } elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
            $html = get_custom_logo();
        } else {
            $html = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="site-title">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
        }

        foreach ( $classes as $search => $replace ) {
            $html = str_replace( $search, $replace, $html );
        }

        if ( ! $echo ) {
            return $html;
        }


        echo wp_kses_post ( apply_filters( 'epicjungle_mobile_logo', $html ) ); // WPCS: XSS ok.
    }
}


if ( ! function_exists( 'epicjungle_site_title_or_logo' ) ) {
    /**
     * Display the site title or logo
     *
     * @since 1.0.0
     * @param bool $echo Echo the string or return it.
     * @return string
     */
    function epicjungle_site_title_or_logo( $echo = true, $classes = array() ) {
        $header_variant=epicjungle_navbar_variant();

        $additional_class='';
        if ( ( ( epicjungle_navbar_is_transparent() && epicjungle_is_transparent_logo() && ( $header_variant === 'solid' || $header_variant === 'button' ) ) || $header_variant === 'dashboard' )  && epicjungle_navbar_is_sticky() && (int) get_theme_mod( 'sticky_logo') > 0 ):
            $additional_class=" navbar-floating-logo";
        endif;

        $defaults = array(
            'custom-logo-link' => 'navbar-brand order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4 d-none d-lg-block logo-link' . $additional_class . '',
            'custom-logo'      => 'navbar-brand-img d-none d-lg-block' . $additional_class . '',
            'site-title'       => 'navbar-brand font-weight-bold order-lg-1 mx-auto ml-lg-0 pr-lg-2 mr-lg-4 d-none d-lg-block' . $additional_class . '',
        );

        
        $classes  = wp_parse_args( $classes, $defaults );

        $transparent_logo_id = (int) get_theme_mod( 'transparent_header_logo' );

        if ( $transparent_logo_id && ( ( epicjungle_navbar_is_transparent() && ( $header_variant === 'solid' || $header_variant === 'button' ) && epicjungle_is_transparent_logo() ) || $header_variant === 'dashboard' )  ) {
            // User uploads a transparent logo via Customizer
            $transparent_logo_attr = [
                'class' => $defaults['custom-logo'],
            ];

            // If the logo alt attribute is empty, get the site title
            $transparent_logo_alt = get_post_meta( $transparent_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $transparent_logo_alt ) ) {
                $transparent_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $transparent_logo_meta  = wp_get_attachment_metadata( $transparent_logo_id );
            $transparent_logo_width = isset( $transparent_logo_meta['width'] ) ? (int) $transparent_logo_meta['width'] : 161;

            $html = sprintf(
                '<a href="%1$s" class="%3$s" rel="home">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $transparent_logo_id, 'full', false, $transparent_logo_attr ),
                $defaults['custom-logo-link']
                
            );
            
        }  elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
            $html = get_custom_logo();
        } else {
            $html = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="site-title">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
        }

        foreach ( $classes as $search => $replace ) {
            $html = str_replace( $search, $replace, $html );
        }

        if ( ! $echo ) {
            return $html;
        }

        echo wp_kses_post( apply_filters( 'epicjungle_logo', $html ));
    }
}


if ( ! function_exists( 'epicjungle_navbar_nav' ) ) {
    function epicjungle_navbar_nav() {
        wp_nav_menu( array(
            'theme_location' => 'navbar_nav',
            'container'      => false,
            'menu_class'     => 'navbar-nav ml-auto flex-wrap',
            'walker'         => new WP_Bootstrap_Navwalker(),
            'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback'
        ) );
    }
}


if ( ! function_exists( 'epicjungle_offcanvas' ) ) {
    function epicjungle_offcanvas() {
        ?><div class="cs-offcanvas-collapse order-lg-2" id="primaryMenu">
            <div class="cs-offcanvas-cap navbar-box-shadow">
                <div class="navbar-tool">
                    <a class="user-avatar" id="avatar-offcanvas-mobile" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
                        <?php echo do_shortcode( '[epicjungle_avatar]' ); ?>
                    </a>

                    <a class="navbar-tool-label" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
                        <small>
                            <?php
                            echo esc_html_x( 'Hello,', 'front-end', 'epicjungle' ); ?>
                        </small>
                        <?php
                        $user = wp_get_current_user();
                        
                        if (is_user_logged_in() === TRUE) {
                          echo esc_html( $user->display_name );
                        }
                        else {
                          echo esc_html_x( 'Visitante', 'front-end', 'epicjungle' ); ?>
                          <div class="navbar-user-login ml-3 d-flex">
                            <a class="btn btn-primary" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php esc_html_e( 'Sign in', 'epicjungle' ); ?></a>
                          </div><?php
                        }
                        ?>
                    </a>
                    <?php epicjungle_wc_my_account_endpoint_dropdown(); ?>
                </div>
                
                <button class="close lead" type="button" data-toggle="offcanvas" data-offcanvas-id="primaryMenu"><span aria-hidden="true">×</span></button>
            </div>

            <div class="cs-offcanvas-body">
                <?php epicjungle_navbar_nav(); ?>
            </div>
            <div class="cs-offcanvas-footer">
                <?php //epicjungle_navbar_nav(); ?>
            </div>
        </div><?php
    }
}

if( ! function_exists( 'epicjungle_navbar_variant' ) ) {
    function epicjungle_navbar_variant() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $variant = isset( $ej_page_options['header']['navbar_variant'] ) ? $ej_page_options['header']['navbar_variant'] : 'solid';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout()  ) ) {
            $variant = get_theme_mod( 'shop_navbar_variant', 'shop' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $variant = get_theme_mod( 'blog_navbar_variant', 'solid' );
        } else {
            $variant = get_theme_mod( 'navbar_variant', 'solid' );
        }

        return sanitize_key( apply_filters( 'epicjungle_is_navbar_variant', $variant ) );
    }
}

if ( ! function_exists( 'epicjungle_wc_page_navbar_variant' ) ) {
    function epicjungle_wc_page_navbar_variant( $variant ) {
        if ( epicjungle_is_woocommerce_activated() && is_account_page() && is_user_logged_in() && apply_filters( 'epicjungle_acount_header',filter_var( get_theme_mod( 'account_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) ) ) {
            $variant ='dashboard';
        } 

        return $variant;
    }
}


if ( ! function_exists( 'epicjungle_wc_my_account_endpoint_dropdown' ) ) {
    function epicjungle_wc_my_account_endpoint_dropdown() {
        $endpoints = wc_get_account_menu_items();
        if( array_filter( $endpoints ) ) {
            $default_icons = [
                'dashboard'        => 'fe-home',
                'orders'           => 'fe-shopping-bag',
                'downloads'        => 'fe-download-cloud',
				'pontos-axis'      => 'fe-award',
                'edit-address'     => 'fe-map-pin',
                'cupons'           => 'fe-tag',
				'afiliados'        => 'fe-users',
                'edit-account'     => 'fe-user',
                'payment-methods'  => 'fe-credit-card',
                'favoritos'		   => 'fe-heart',
                'customer-logout'  => 'fe-log-out',
            ];
            ?><ul class="dropdown-menu dropdown-menu-right" style="min-width: 15rem;">
			<?php foreach( $endpoints as $endpoint => $label ) :
                    $default_icon = isset( $default_icons[$endpoint] ) ? $default_icons[$endpoint] : '';
                    $icon_class   = get_theme_mod( "epicjungle_wc_endpoint_{$endpoint}_icon", $default_icon );
                    ?>

                    <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                            <?php if( ! empty( $icon_class ) ) : ?>
                                <i class="<?php echo esc_attr( $icon_class ); ?> font-size-base opacity-60 mr-2"></i>
                            <?php endif; ?>
                            <?php echo esc_html( $label ); ?>
                            <?php if( $endpoint === 'orders' ) : ?>
                                <span class="ml-auto font-size-xs text-muted"><?php epicjungle_wc_account_orders_count(); ?></span>
                            <?php elseif( $endpoint === 'downloads' ) : ?>
                                <span class="ml-auto font-size-xs text-muted"><?php is_a( WC()->customer, 'WC_Customer' ) ? epicjungle_wc_account_downloads_count() : 0; ?></span>
                            <?php elseif( $endpoint === 'yith-my-wishlist' ) : ?>
                                <span class="ml-auto font-size-xs text-muted"><?php echo yith_wcwl_count_products(); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php if ( $endpoint !== 'customer-logout' ) : ?>
                        <li class="dropdown-divider"></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul><?php
        }
    }
}

if ( ! function_exists( 'epicjungle_wc_modal_in_navbar' ) ) {
    function epicjungle_wc_modal_in_navbar() {
        if ( epicjungle_is_woocommerce_activated() && epicjungle_navbar_is_account() && !is_user_logged_in() ) {
        
            $has_registration_form = get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes';
            ?>

            <div class="modal fade" id="modal-signin" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0">
                        <div class="cs-view show" id="modal-signin-view">
                            <div class="modal-header border-0 bg-dark px-4">
                                <h4 class="modal-title text-light"><?php echo esc_html_x( 'Sign in', 'front-end', 'epicjungle' ); ?></h4>
                                <button class="close text-light" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>

                            <div class="modal-body px-4">
                                <p class="font-size-ms text-muted"><?php echo esc_html__(' Sign in to your account using email and password provided during registration.', 'epicjungle' );?></p>
                                <?php woocommerce_login_form( [
                                'redirect' => get_permalink( wc_get_page_id( 'myaccount' ) ),
                            ] ); ?>
                            </div>
                        </div>

                        <?php if ( $has_registration_form ): ?>
                            <div class="cs-view show" id="modal-signup-view">
                                <div class="modal-header border-0 bg-dark px-4">
                                    <h4 class="modal-title text-light"><?php echo esc_html_x( 'Sign up', 'front-end', 'epicjungle' ); ?></h4>
                                    <button class="close text-light" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>

                                <div class="modal-body px-4">
                                    <p class="font-size-ms text-muted"><?php echo esc_html__(' Registration takes less than a minute but gives you full control over your orders.', 'epicjungle' );?></p>
                                    <?php epicjungle_wc_registration_form(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'epicjungle_wc_registration_form' ) ) {
    /**
     * Registration Form
     */
    function epicjungle_wc_registration_form() {
        ?><form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                <div class="form-group">
                    <label class="sr-only p-0" for="reg_username"><?php esc_html_e( 'Username', 'epicjungle' ); ?></label>
                    <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" placeholder="<?php echo esc_html_e( 'Full name', 'epicjungle' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </div>
            <?php endif; ?>


            <div class="form-group">
                <label class="sr-only p-0" for="reg_email"><?php esc_html_e( 'Email address', 'epicjungle' ); ?></label>
                <input type="email" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" placeholder="<?php echo esc_html_e( 'Email', 'epicjungle' ); ?>" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </div>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                <div class="cs-password-toggle form-group">
                    <label class="sr-only p-0" for="reg_password"><?php esc_html_e( 'Password', 'epicjungle' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password" id="reg_password" placeholder="<?php echo esc_html_e( 'Password', 'epicjungle' ); ?>" autocomplete="new-password" />
                    <label class="cs-password-toggle-btn">
                        <input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only"><?php echo esc_html__( 'Show password', 'epicjungle'); ?></span>
                    </label>
                </div>
            <?php else : ?>
                <p class="font-size-sm text-muted"><?php esc_html_e( 'A password will be sent to your email address.', 'epicjungle' ); ?></p>
            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <button type="submit" class="woocommerce-Button woocommerce-button btn btn-primary btn-block woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Sign up', 'epicjungle' ); ?>"><?php esc_html_e( 'Sign up', 'epicjungle' ); ?></button>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

            <p class="font-size-sm pt-3 mb-0"><?php esc_html_e( 'Already have an account? ', 'epicjungle' );?><a class="font-weight-medium" href="#" data-view="#modal-signin-view"><?php echo esc_html__( 'Sign in', 'epicjungle' ); ?></a></p>
        </form><?php
    }
}


if ( ! function_exists( 'epicjungle_user_account' ) ) {
    function epicjungle_user_account( $user_login_nav_link_classes ='', $nav_link_classes='', $icon_classes='', $nav_link_label=false, $signup_modal=false ) {
        if ( epicjungle_is_woocommerce_activated() ): 
            if ( is_user_logged_in() ) : ?>
                
                <div class="navbar-tool dropdown mr-4 ml-2">
                    <a class="<?php echo esc_attr( $user_login_nav_link_classes ); ?>" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
                        <?php echo do_shortcode( '[epicjungle_avatar]' ); ?>
                    </a>

                    <a class="navbar-tool-label dropdown-toggle" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
                        <small>
                            <?php
                            /* translators: a small text before "log in" link in Navbar */
                            echo esc_html_x( 'Hello,', 'front-end', 'epicjungle' ); ?>
                        </small>
                        <?php
                        $user = wp_get_current_user();
                        echo esc_html( $user->display_name ); ?>
                    </a>
                    <?php epicjungle_wc_my_account_endpoint_dropdown(); ?>
                </div>
           
            <?php else: ?>
                
                <a class="<?php echo esc_attr( $nav_link_classes ); ?>" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                    <i class="<?php echo esc_attr( $icon_classes ); ?>"></i>
                    <?php if ( $nav_link_label ) : 
                        echo esc_html_x( 'Sign in', 'front-end', 'epicjungle' ); 
                    endif; ?>
                </a>
                <?php if ( $signup_modal ) : ?>
                    <a class="btn btn-primary ml-grid-gutter d-none d-lg-inline-block" href="#modal-signin" data-toggle="modal" data-view="#modal-signup-view"><?php echo esc_html_x( 'Sign up', 'front-end', 'epicjungle' ); ?></a>
                <?php endif; ?>
                
            <?php endif; 
        endif;
    }
}


if ( ! function_exists( 'epicjungle_dashboard_user_account' ) ) {
    function epicjungle_dashboard_user_account() { 
        if ( epicjungle_is_woocommerce_activated() && epicjungle_navbar_is_account() ) :?>
            <div class="d-flex align-items-center order-lg-3 ml-lg-auto">
                <?php epicjungle_user_account('navbar-tool-icon-box', 'nav-link-style font-size-sm text-nowrap', 'fe-user font-size-xl mr-1', true, true ); ?>
            </div><?php
        endif;
    }
}

if ( ! function_exists( 'epicjungle_shop_user_account' ) ) {
    function epicjungle_shop_user_account() { 
        if ( epicjungle_is_woocommerce_activated() && epicjungle_navbar_is_account() ) :?>
            <div class="navbar-tool d-none d-sm-flex">
                <?php epicjungle_user_account('navbar-tool-icon-box', 'navbar-tool-icon-box mr-2', 'fe-user', false, false ); ?>
            </div><?php
        endif;
    }
}



if ( ! function_exists( 'epicjungle_navbar_shop_topbar' ) ) {
   
    function epicjungle_navbar_shop_topbar() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_topbar = isset( $ej_page_options['header']['enable_topbar'] ) ? $ej_page_options['header']['enable_topbar'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_topbar = get_theme_mod( 'shop_enable_topbar', 'yes' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_topbar = get_theme_mod( 'blog_enable_topbar', 'yes' );
        } else {
            $enable_topbar = get_theme_mod( 'enable_topbar', 'yes' );
        }

        if ( apply_filters( 'epicjungle_enable_topbar', filter_var( $enable_topbar, FILTER_VALIDATE_BOOLEAN ) && ( has_nav_menu( 'topbar_left' ) || has_nav_menu( 'topbar_right' ) ) ) ):
            ?><div class="topbar <?php echo epicjungle_topbar_skin() === 'dark' ? 'topbar-dark bg-dark' : 'topbar-light bg-secondary'; ?>">
                <div class="container d-md-flex align-items-center px-0 px-xl-3 topbar__nav">
                    
                    <?php if ( has_nav_menu( 'topbar_left' ) ) {
                        $topbar_left_menu_args = apply_filters( 'epicjungle_topbar_left_args', [
                            'theme_location'        => 'topbar_left',
                            'walker'                => new WP_Bootstrap_Navwalker(),
                            'container'             => false,
                            'menu_id_prefix'        => 'topbar-left',
                            'menu_class'            => 'list-unstyled topbar__nav--left d-none d-md-flex flex-wrap text-nowrap mr-3 p-0 mb-0',
                            'item_class'            => [ 'mb-0'],
                            'anchor_class'          => [ 'topbar-link', 'mr-1', 'p-0 ' ],
                            'icon_class'            => ['font-size-base', 'text-muted', 'mr-1' ],
                            'submenu_link_class'    => 'dropdown-item',

                        ] );

                        wp_nav_menu( $topbar_left_menu_args );
                    }

                    if ( has_nav_menu( 'topbar_right' ) ) {
                        $topbar_right_menu_args = apply_filters( 'epicjungle_topbar_right_args', [
                            'theme_location'        => 'topbar_right',
                            'walker'                => new WP_Bootstrap_Navwalker(),
                            'container'             => false,
                            'menu_id_prefix'        => 'topbar-right',
                            'menu_class'            => 'list-unstyled topbar__nav--right d-flex flex-wrap text-md-right ml-md-auto mb-0',
                            'item_class'            => [ 'mb-0'],
                            'anchor_class'          => [ 'topbar-link', 'mr-1', 'p-0 ' ],
                            'icon_class'            => [ 'font-size-base', 'opacity-60 mr-1', 'mr-1' ],
                            'depth'                 => 2,
                            'submenu_link_class'    => 'dropdown-item',

                        ] );

                        wp_nav_menu( $topbar_right_menu_args );
                    } ?>
                    
                </div>
            </div><?php
        endif; 
        //endif;
    }
}

if ( ! function_exists( 'epicjungle_header_icons_links' ) ) {
   
    function epicjungle_header_icons_links() { 
        if ( epicjungle_navbar_is_search() || ( epicjungle_is_woocommerce_activated() && epicjungle_navbar_is_account() ) || ( epicjungle_is_woocommerce_activated() && epicjungle_navbar_is_cart() ) ) { ?>
            <div class="d-flex align-items-center order-lg-3 ml-lg-auto">
                <?php do_action( 'epicjungle_header_links' ); ?>
            </div><?php
        }
    }
}


if ( ! function_exists( 'epicjungle_navbar_is_social_links' ) ) {
    /**
     * Enable Search
     */
    function epicjungle_navbar_is_social_links() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_header_social_menu = isset( $ej_page_options['header']['enable_header_social_menu'] ) ? $ej_page_options['header']['enable_header_social_menu'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_header_social_menu = get_theme_mod( 'shop_enable_header_social_menu', 'yes' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_header_social_menu = get_theme_mod( 'blog_enable_header_social_menu', 'yes' );
        } else {
            $enable_header_social_menu = get_theme_mod( 'enable_header_social_menu', 'yes' );
        }


        return apply_filters( 'epicjungle_enable_social_links', filter_var( $enable_header_social_menu, FILTER_VALIDATE_BOOLEAN ) );
    }
}


if ( ! function_exists( 'epicjungle_navbar_social_tool_links' ) ) {
   
    function epicjungle_navbar_social_tool_links() { 
        
        if( ( has_nav_menu( 'social_media' ) && epicjungle_navbar_is_social_links() ) || epicjungle_navbar_is_search() ) { ?>

            <div class="d-flex align-items-center order-lg-3 ml-lg-auto">
                <?php do_action( 'epicjungle_social_header_links' ); ?>
            </div><?php
        }
    }
}

if ( ! function_exists( 'epicjungle_navbar_search' ) ) {
    function epicjungle_navbar_search() {
        if ( epicjungle_navbar_is_search() ) : ?>
            <div class="navbar-tool">
                <a class="navbar-tool-icon-box mr-2" href="#" data-toggle="search">
                    <i class="fe-search"></i>
                </a>
            </div>
        <?php endif;
    }
}

if ( ! function_exists( 'epicjungle_navbar_cart' ) ) {
    function epicjungle_navbar_cart() {
        if ( epicjungle_is_woocommerce_activated() && epicjungle_navbar_is_cart() ) {
            ?>
            
            <div class="epicjungle-cart navbar-tool mr-2">
                <div class="border-left mr-2" style="height: 30px;"></div>
                <a class="navbar-tool-icon-box" href="<?php echo esc_url( wc_get_cart_url() ); ?>" data-toggle="offcanvas" data-offcanvas-id="shoppingCart">
                    <i class="fe-shopping-cart"></i>
                    <span class="navbar-tool-badge"><?php epicjungle_cart_link_count(); ?></span>
                </a>
            </div>

            <?php
        }
    }
}

if ( ! function_exists( 'epicjungle_cart_link_count' ) ) {
    function epicjungle_cart_link_count() {
        ?><span class="cart-contents-count"><?php echo absint( is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_cart_contents_count() : 0 ); ?></span><?php
    }
}

if ( ! function_exists( 'epicjungle_wc_offcanvas_mini_cart' ) ) {
    /**
     * Offcanvas Mini cart
     */
    function epicjungle_wc_offcanvas_mini_cart() {
    ?>

    <div class="cs-offcanvas cs-offcanvas-collapse-always cs-offcanvas-right" id="shoppingCart">
        <div class="cs-offcanvas-cap navbar-box-shadow px-4 mb-2">
            <h5 class="mt-1 mb-0"><?php echo esc_html__( 'Your cart', 'epicjungle' ); ?></h5>
            <button class="close lead" type="button" data-toggle="offcanvas" data-offcanvas-id="shoppingCart"><span aria-hidden="true">×</span></button>
        </div>
        <?php epicjungle_wc_offcanvas_mini_cart_content(); ?>
          
    </div><?php
        
    }
}

if ( ! function_exists( 'epicjungle_wc_offcanvas_mini_cart_content' ) ) {
    
    function epicjungle_wc_offcanvas_mini_cart_content() { ?>
        <div class="epicjungle-minicart1">
            <?php woocommerce_mini_cart(); ?>
        </div><?php
    }
}

if ( ! function_exists( 'epicjungle_offcanvas_toggler' ) ) {
    
    function epicjungle_offcanvas_toggler() {
         if ( epicjungle_is_woocommerce_activated()):
            epicjungle_wc_offcanvas_mini_cart();
        endif;
    }
}

if ( ! function_exists( 'epicjungle_navbar_action_button' ) ) {
    function epicjungle_navbar_action_button() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $btn_classes = '';

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['header'] ) && isset( $ej_page_options['header']['enable_custom_header'] ) && $ej_page_options['header']['enable_custom_header'] === 'yes' ) {
            $enable_button = isset( $ej_page_options['header']['enable_action_button'] ) ? filter_var( $ej_page_options['header']['enable_action_button'] ) : '';
            $btn_classes .= ' custom-button';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_header_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_button = apply_filters( 'epicjungle_shop_enable_buy_button' , filter_var( get_theme_mod( 'shop_enable_action_button', 'no' ), FILTER_VALIDATE_BOOLEAN ) );
            $btn_classes .= ' shop-button';
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_button = apply_filters( 'epicjungle_blog_enable_buy_button' , filter_var( get_theme_mod( 'blog_enable_action_button', 'no' ), FILTER_VALIDATE_BOOLEAN ) );
            $btn_classes .= ' blog-button';
        } else {
            $enable_button = apply_filters( 'epicjungle_enable_buy_button' , filter_var( get_theme_mod( 'enable_action_button', 'no' ), FILTER_VALIDATE_BOOLEAN ) );
            $btn_classes .= ' default-button';
        }

        $button_url    = apply_filters( 'epicjungle_buy_button_url', get_theme_mod( 'button_url', '#' ) );
        $button_text   = apply_filters( 'epicjungle_buy_button_text', get_theme_mod( 'button_text', esc_html__( 'Buy Template', 'epicjungle' ) ) );
        $button_css    = apply_filters( 'epicjungle_buy_button_css', get_theme_mod( 'button_css', '' ) );
        $button_icon   = apply_filters( 'epicjungle_buy_button_icon', get_theme_mod( 'button_icon', 'fe-shopping-cart' ) );
        $enable_modal  = apply_filters( 'epicjungle_buy_button_enable_modal' , filter_var( get_theme_mod( 'enable_modal', 'no' ), FILTER_VALIDATE_BOOLEAN ) );
    
        if( ! empty( $button_css ) ) {
            $btn_classes .= ' ' . $button_css;
        }

        if ( $enable_button && ! empty ( $button_text ) ) : ?>
            <div class="d-flex align-items-center order-lg-3 ml-lg-auto">
                <?php if ( $enable_modal ): ?>
                    <a class="btn btn-primary<?php echo esc_attr( $btn_classes ); ?>" href="#modal-contact" data-toggle="modal">
                <?php else: ?>
                    <a class="btn btn-primary<?php echo esc_attr( $btn_classes ); ?>" href="<?php echo esc_url( $button_url ); ?>" target="_self" rel="noopener">
                <?php endif; ?>

                    <?php if ( apply_filters('epicjungle_navbar_button_icon', 'yes' === get_theme_mod( 'enable_button_icon', 'yes' ) ) ): ?>
                        <i class="<?php echo esc_attr( $button_icon ); ?> font-size-lg mr-2"></i>
                    <?php endif; ?>
                    <?php echo esc_html( $button_text );?>

                <?php if ( $enable_modal ): ?>
                    </a>
                <?php else: ?>
                    </a>
                <?php endif; ?>
            </div><?php
        endif;
    }
}

if ( ! function_exists( 'epicjungle_site_search' ) ) {

    function epicjungle_site_search() {
        wp_enqueue_script('epicjungle-ajax-search');

        if ( epicjungle_navbar_is_search() ) : 
        ?><div class="navbar-search bg-light">
            <div class="container d-flex flex-nowrap align-items-center">
            <?php if ( epicjungle_is_woocommerce_activated() ) : ?>

                    <div class="epicjungle-product-search">
                        <form name="product-search" method="POST">
                            <div class="search-wrapper d-flex align-items-center">
                                <i class="fe-search font-size-xl"></i>
                                <input type="search" name="search" id="epicjungle-input-search" class="search form-control form-control-xl navbar-search-field border-0" onkeydown="return (event.keyCode!=13);" placeholder="<?php echo esc_html__( 'O que você procura?', 'epicjungle' ); ?>">
                                <div class="d-flex align-items-center">
                                    <a id="clear-search-results" class="btn btn-link text-danger btn-icon mr-5 d-none">
                                        <i class="fe-delete font-size-xl"></i>
                                    </a>
                                    <span id="preloader-search-products" class="spinner-border spinner-border-md d-none"></span>
                                </div>
                            </div>
                        </form>
                        <div class="search-results d-none"></div>
                    </div>

                    <div class="d-flex align-items-center"><span class="text-muted font-size-xs mt-1 d-none d-sm-inline"><?php echo esc_html__( 'Close', 'epicjungle');?></span>
                        <button class="close p-2" type="button" data-toggle="search">&times;</button>
                    </div>

            <?php else : ?>
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="w-100 form-inline my-2 my-xl-0">
                    <i class="fe-search font-size-xl"></i>
                    <input class="form-control form-control-xl navbar-search-field" name="s" id="s" value="<?php echo get_search_query(); ?>" type="text" placeholder="<?php esc_attr_e( 'Search site', 'epicjungle' ); ?>">
                    <input type="hidden" id="search-param" name="post_type" value="post" />
                    <div class="d-none d-sm-block flex-shrink-0 pl-2 mr-4 border-left border-right" style="width: 10rem;">
                        <?php $selected_cat = isset( $_GET['category'] ) ? $_GET['category'] : 0;
                        $navbar_search_dropdown_text = apply_filters( 'bookworm_navbar_search_category_dropdown_default_text', esc_html__( 'All Categories', 'epicjungle' ) );
                            wp_dropdown_categories( apply_filters( 'epicjungle_search_dropdown_categories_filter_args', array(
                                'show_option_all'   => $navbar_search_dropdown_text,
                                'taxonomy'          => 'category',
                                'hide_if_empty'     => 1,
                                'name'              => 'category',
                                'selected'          => $selected_cat,
                                'value_field'       => 'slug',
                                'id'                => 'inputGroupSelect01',
                                'class'             => 'w-100 form-control custom-select pl-2 pr-0'
                            ) ) );
                        ?>
                  </div>

                  <div class="d-flex align-items-center"><span class="text-muted font-size-xs mt-1 d-none d-sm-inline">Close</span>
                        <button class="close p-2" type="button" data-toggle="search">&times;</button>
                  </div>
                </form>
            <?php endif; ?>
        </div></div><?php
    endif;
    }
}

if( ! function_exists( 'epicjungle_navbar_social_links' ) ) {
    function epicjungle_navbar_social_links() { 
        
         if ( has_nav_menu( 'social_media' ) && epicjungle_navbar_is_social_links() ) { ?>

            <div class="d-lg-block d-none border-left mr-4" style="height: 30px;"></div><?php

            wp_nav_menu( array(
                'theme_location' => 'social_media',
                'container'      => false,
                'menu_class'     => 'd-lg-block d-none epicjungle-navbar-social-menu mb-0 p-0 mr-n1',
                'item_class'     => [ 'list-inline-item', 'list-social-item', 'mr-1', 'mb-0' ],
                'anchor_class'   => [ 'social-btn', 'sb-outline' ],
                'icon_class'     => [ 'list-social-icon' ],
                'walker'         => new WP_Bootstrap_Navwalker()
            ) );
        }
    }
}


if ( ! function_exists( 'epicjungle_navbar_modal' ) ) {
    function epicjungle_navbar_modal() {
        $modal_content = get_theme_mod( 'navbar_modal_content' );
        $modal_title   = apply_filters( 'epicjungle_buy_button_modal_title', get_theme_mod ( 'modal_title', esc_html__( 'What project are you looking for?', 'epicjungle' ) ) );
        $enable_modal  = apply_filters( 'epicjungle_buy_button_enable_modal' , filter_var( get_theme_mod( 'enable_modal', 'no' ), FILTER_VALIDATE_BOOLEAN ) );

        if ( $modal_content && $enable_modal ) { ?>
            <div class="modal fade" id="modal-contact" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header mb-1">
                            <h4 class="modal-title"><?php echo esc_html( $modal_title ); ?></h4>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>  

                        <div class="modal-body py-4">
                            <?php print( epicjungle_render_content( $modal_content, false ) ); ?>
                        </div>
                    </div>
                </div>
            </div><?php
        }
    }
}