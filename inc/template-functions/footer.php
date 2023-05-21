<?php
/**
 * Template functions for Footer
 *
 */

if( ! function_exists( 'epicjungle_footer_variant' ) ) {
    function epicjungle_footer_variant() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $variant = isset( $ej_page_options['footer']['footer_variant'] ) ? $ej_page_options['footer']['footer_variant'] : 'default';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $variant = get_theme_mod( 'shop_footer_variant', 'default' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $variant = get_theme_mod( 'blog_footer_variant', 'blog' );
        } else {
            $variant = get_theme_mod( 'footer_variant', 'simple' );
        }

        return sanitize_key( apply_filters( 'epicjungle_is_footer_variant', $variant ) );
    }
}

if ( ! function_exists( 'epicjungle_wc_page_footer_variant' ) ) {
    function epicjungle_wc_page_footer_variant( $variant ) {
        if ( epicjungle_is_woocommerce_activated() && is_account_page() && apply_filters( 'epicjungle_acount_footer',filter_var( get_theme_mod( 'account_enable_separate_footer', 'no' ), FILTER_VALIDATE_BOOLEAN ) )){
            $variant ='v10';
        }
        return $variant;
    }
}

if( ! function_exists( 'epicjungle_footer_skin' ) ) {
    function epicjungle_footer_skin() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $footer_skin = isset( $ej_page_options['footer']['footer_skin'] ) ? $ej_page_options['footer']['footer_skin'] : 'dark';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $footer_skin = get_theme_mod( 'shop_footer_skin', 'dark' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $footer_skin = get_theme_mod( 'blog_footer_skin', 'dark' );
        } else {
            $footer_skin = get_theme_mod( 'footer_skin', 'dark' );
        }



        return sanitize_key( apply_filters( 'epicjungle_footer_skin', $footer_skin ) );
    }
}



/**
 * Returns a logo for mobile
 *
 * @return string
 */
if( ! function_exists( 'epicjungle_footer_logo' ) ) {
    function epicjungle_footer_logo( $echo = true, $classes = array() ) {
        $footer_variant = epicjungle_footer_variant();

        $defaults = array (
            'custom-logo-link' => 'navbar-brand footer-logo-link',
            'custom-logo'      => 'navbar-brand-img',
            'site-title'       => 'navbar-brand'
        );
        $classes  = wp_parse_args( $classes, $defaults );

        if ( $footer_variant === 'shop') {
            $footer_classes = 'd-block mr-grid-gutter mt-n1 mb-3';
        } elseif( $footer_variant === 'blog') {
            $footer_classes = 'd-block mr-grid-gutter mb-3';
        } elseif( $footer_variant === 'v6') {
            $footer_classes = 'd-inline-block mb-3';
        } else {
            $footer_classes = 'd-block mb-3';
        }

        $footer_logo_id = (int) get_theme_mod( 'footer_logo' );
        
        if ( $footer_logo_id ) {

            // If the logo alt attribute is empty, get the site title
            $footer_logo_alt = get_post_meta( $footer_logo_id, '_wp_attachment_image_alt', true );
//echo '<pre>' . print_r( $footer_logo_alt, 1 ) . '</pre>';
            if ( empty( $footer_logo_alt ) ) {
                $footer_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $footer_logo_meta  = wp_get_attachment_metadata( $footer_logo_id );
            $footer_logo_width = isset( $footer_logo_meta['width'] ) ? (int) $footer_logo_meta['width'] : 153;

            $html = sprintf(
                '<a href="%1$s" class="%4$s" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $footer_logo_id, 'full', false, $footer_logo_attr ),
                (float) $footer_logo_width / 2,
                $footer_classes
                
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

        echo wp_kses_post( apply_filters( 'epicjungle_footer_logo', $html ));

    }
}

if ( ! function_exists( 'epicjungle_social_media_links' ) ) {
    /**
     * Displays social media links
     *
     */
    function epicjungle_social_media_links() {
        $footer_variant = epicjungle_footer_variant();
        $footer_skin    = epicjungle_footer_skin();

        if ( has_nav_menu( 'social_media' ) ){

            if ( $footer_variant === 'shop') {
                $item_class   ='ml-2 mb-2 mr-0';
                $anchor_class ='sb-light';
            } elseif ( $footer_variant === 'simple-2') {
                $item_class   ='mr-2 mb-0';
                $anchor_class ='sb-outline sb-light';
            } elseif ( $footer_variant === 'default') {
                if ( $footer_skin === 'light') {
                    $item_class   ='mr-1 mb-2';
                    $anchor_class ='sb-outline sb-lg';
                } else {
                    $item_class   ='mr-1 mb-2';
                    $anchor_class ='sb-outline sb-lg sb-light';
                }
            } elseif ( $footer_variant === 'v7') {
                if ( $footer_skin === 'light') {
                    $item_class   ='mr-1 mb-0';
                    $anchor_class ='sb-outline sb-lg';
                } else {
                    $item_class   ='mr-2 mb-0';
                    $anchor_class ='sb-lg sb-light';
                }
            } else {
                $item_class   ='mr-2 mb-2';
                $anchor_class ='sb-outline sb-lg sb-light';
            }

            wp_nav_menu( array(
                'theme_location' => 'social_media',
                'container'      => false,
                'menu_class'     => 'list-unstyled list-inline list-social mb-0',
                'item_class'     => [ 'list-inline-item', 'list-social-item', $item_class ],
                'anchor_class'   => [ 'social-btn', $anchor_class ],
                'icon_class'     => [ 'list-social-icon' ],
                'walker'         => new WP_Bootstrap_Navwalker()
            ) );
        }
    }
}

if ( ! function_exists( 'epicjungle_contact_links' ) ) {
    /**
     * Displays Contact Links
     *
     * @since  1.0.0
     * @return void
     */
    function epicjungle_contact_links( $nav_link_classes='', $footer_version='' ) {
        $footer_skin = epicjungle_footer_skin();

        if ( has_nav_menu( 'contact_links' ) && apply_filters( 'epicjungle_enable_contact_links', true ) ) {
            if ( $footer_skin === 'dark') {
                $anchor_classes = 'nav-link-light';
            } else {
                $anchor_classes = '';
            }

            $nav_menu_args = apply_filters( 'epicjungle_contact_menu_args', [
                'theme_location' => 'contact_links',
                'container'      => false,
                'menu_class'     => 'list-unstyled font-size-sm mb-4 pb-2',
                'item_class'     => [ '' ],
                'anchor_class'   => [ 'nav-link-style p-0 ' .$anchor_classes .'' ],
                'walker'         => new WP_Bootstrap_Navwalker()
            ] );

            wp_nav_menu( $nav_menu_args );
        }
    }
}

if( ! function_exists( 'epicjungle_footer_copyright' ) ) {
    function epicjungle_footer_copyright() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();
        $default   = wp_kses_post( __( '<a href="https://epicjunglewp.com.br" target="_blank" rel="noopener noreferrer">Tema EpicJungle para WordPress</a> - by MeuMouse.com &copy; Todos os direitos reservados.', 'epicjungle' ) );

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );
            //$_ej_page_options = json_decode( stripslashes( $clean_meta_data ), true );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $copyright = isset( $ej_page_options['footer']['copyright'] ) ? wp_kses_post ( $ej_page_options['footer']['copyright'] ) : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $copyright = get_theme_mod( 'shop_epicjungle_copyright',  $default );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $copyright = get_theme_mod( 'blog_epicjungle_copyright',  $default );
        } else {
            $copyright = get_theme_mod( 'epicjungle_copyright',  $default );

        }


        return (string) apply_filters( 'epicjungle_footer_copyright', $copyright );
    }
}


if( ! function_exists( 'epicjungle_is_copyright' ) ) {
    function epicjungle_is_copyright() {
        return (bool) apply_filters( 'epicjungle_is_copyright', '' !== get_theme_mod( 'epicjungle_copyright' ) );
    }
}

if ( ! function_exists( 'epicjungle_footer_default_widgets' ) ) {
    function epicjungle_footer_default_widgets() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();
        $footer_skin    = epicjungle_footer_skin();
        $footer_variant = epicjungle_footer_variant();


        if ( epicjungle_is_extensions_activated() ) {
            $footer_0_classes             = 'col-md-4 mt-n2 pb-3 pb-md-0 mb-4 logo-footer';
            $footer_static_widget_classes = 'col-md-8 mt-n2 pb-3 pb-md-0 mb-4';
            $footer_1_classes             = 'col-lg-2 col-md-3 col-sm-4 ml-auto';
            $footer_2_classes             = 'col-lg-2 col-md-3 col-sm-4';
            $footer_3_classes             = 'col-lg-2 col-md-3 col-sm-4';
        } else {
            $footer_0_classes             = 'col-md-4 col-lg-3';
            $footer_static_widget_classes = 'col-md-8 col-lg-9';
            $footer_1_classes             = 'col-md-4 col-lg-3';
            $footer_2_classes             = 'col-md-4 col-lg-3';
            $footer_3_classes             = 'col-md-4 col-lg-3';
        }

        if ( $footer_variant === 'default' ) {
            if ($footer_skin === 'light') {
                $text_classes = 'heading';
            } else {
                $text_classes = 'light';
            }
        } else {
            $text_classes = 'light';
        }

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        } ?>

        <div class="row pb-3 footer-widgets__default">
            <div class="<?php echo esc_attr( $footer_0_classes ); ?>"><?php 
                
                epicjungle_footer_logo ( true, array (
                     'site-title' => 'navbar-brand text-'. $text_classes . ' d-block mb-3' 
                ) );

                $desc = apply_filters( 'epicjungle_blog_info', get_bloginfo( 'description' ) );

                if ( ! empty( $desc ) && apply_filters( 'epicjungle_site_desc', true ) ) {
                    echo wp_kses( '<p class="site-desc font-size-sm text-'. $text_classes . ' pb-2 pb-sm-3">' . $desc . '</p>', array( 'p' => array( 'class' => array() ) ) );
                }

                if ( has_nav_menu( 'social_media' ) ){
                    epicjungle_social_media_links();
                }

            ?></div>

            <?php if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
                $footer_static_widgets = isset( $ej_page_options['footer']['footer_static_widgets'] ) ? $ej_page_options['footer']['footer_static_widgets'] : '';


                if( epicjungle_is_mas_static_content_activated() && ! empty( $footer_static_widgets ) ) { ?>
                    <div class="<?php echo esc_attr( $footer_static_widget_classes ); ?>">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                 } 

            } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() ) &&  (int) get_theme_mod( 'shop_footer_widgets') > 0  ) {
                $footer_static_widgets = get_theme_mod( 'shop_footer_widgets' );  

                if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'shop_footer_widgets') > 0 ) { ?>
                    <div class="<?php echo esc_attr( $footer_static_widget_classes ); ?>">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                 } 
                
            } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN )  &&  (int) get_theme_mod( 'blog_footer_widgets') > 0  ) {
                $footer_static_widgets = get_theme_mod( 'blog_footer_widgets' ); 

                if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'blog_footer_widgets') > 0 ) { ?>
                    <div class="<?php echo esc_attr( $footer_static_widget_classes ); ?>">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                 } 
            } else {

                if ( is_active_sidebar( 'footer-1' ) ) : ?><div class="<?php echo esc_attr( $footer_1_classes ); ?>"><?php
                    dynamic_sidebar( 'footer-1' );
                ?></div><?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?><div class="<?php echo esc_attr( $footer_2_classes ); ?>"><?php
                    dynamic_sidebar( 'footer-2' );
                ?></div><?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?><div class="<?php echo esc_attr( $footer_3_classes ); ?>"><?php
                    dynamic_sidebar( 'footer-3' );
                ?></div><?php endif; 
            } ?>

            
        </div>
        <hr class="border-light"><?php
        
    }
}


if ( ! function_exists( 'epicjungle_footer_default_copyright' ) ) {
    function epicjungle_footer_default_copyright() {
        ?><div class="row align-items-center my-3 pt-4">

            <?php if ( has_nav_menu( 'footer_links' ) ) { ?>
                <div class="col-md-6 order-md-2 text-md-right mb-3"><?php epicjungle_footer_links();?></div>
            <?php } ?>
           
           <?php if ( epicjungle_is_copyright() ): ?>
                <div class="col-md-6 order-md-1 mb-3">
                    <?php epicjungle_footer_default_copyright_text(); ?>
                </div>
            <?php endif; ?>
        </div><?php
    }
}

if ( ! function_exists( 'epicjungle_footer_default_copyright_text' ) ) {
    function epicjungle_footer_default_copyright_text() { 
        
        $copyright = function_exists( 'epicjungle_footer_copyright' ) && ! empty( epicjungle_footer_copyright() ) ? epicjungle_footer_copyright() : '';
        $footer_variant   = epicjungle_footer_variant(); 


        if ( $footer_variant == 'default' || $footer_variant == 'shop' || is_404() ) {
            $additional_class ="mb-0";
        } elseif ( $footer_variant == 'blog' ) {
            $additional_class ="mr-1 pt-2 mb-3";
        } elseif ( $footer_variant == 'simple' ) {
            $additional_class ="text-md-nowrap mb-3 mr-3 order-md-1";
        } elseif ( $footer_variant == 'v6' ) {
            $additional_class ="text-center mb-0";
        } elseif ( $footer_variant == 'v7' ) {
            $additional_class ="mb-3 order-md-1";
        } elseif ( $footer_variant == 'v8' ) {
            $additional_class ="font-size-sm text-center mb-4 py-3";
        } elseif ( $footer_variant == 'simple-2' ) {
            $additional_class ="mb-4 mb-md-0";
        } else {
            $additional_class ="mb-0";
        }
        

        if( !empty( $copyright ) ) { ?>
            <p class="font-size-sm epicjungle-copyright <?php echo esc_attr( $additional_class ); ?>"><?php  '</pre>';
                echo wp_kses_post( $copyright );
            ?></p><?php
        }
    }
}

if ( ! function_exists( 'epicjungle_footer_shop_widgets' ) ) {
    function epicjungle_footer_shop_widgets() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        } 

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $footer_static_widgets = isset( $ej_page_options['footer']['footer_static_widgets'] ) ? $ej_page_options['footer']['footer_static_widgets'] : '';

            if( epicjungle_is_mas_static_content_activated() && ! empty( $footer_static_widgets ) ) { ?>
                <div class="epicjungle-custom-footer-shop-top pt-5 pt-md-6">
                    <div class="container pt-3 pb-0 pt-md-0 pb-md-3"> 
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div>
                </div><?php
            }

        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout()  )  &&  (int) get_theme_mod( 'shop_footer_widgets') > 0  ) {
            $footer_static_widgets = get_theme_mod( 'shop_footer_widgets' );  

            if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'shop_footer_widgets') > 0 ) { ?>
                <div class="epicjungle-custom-footer-shop-top pt-5 pt-md-6"> 
                    <div class="container pt-3 pb-0 pt-md-0 pb-md-3">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div>
                </div><?php
            }    
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN )  &&  (int) get_theme_mod( 'blog_footer_widgets') > 0  ) {
                $footer_static_widgets = get_theme_mod( 'blog_footer_widgets' ); 

                if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'blog_footer_widgets') > 0 ) { ?>
                    <div class="epicjungle-custom-footer-shop-top pt-5 pt-md-6"> 
                        <div class="container pt-3 pb-0 pt-md-0 pb-md-3">  
                            <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                        </div>
                    </div><?php
                 } 
        } else {
            if ( apply_filters( 'epicjungle_enable_footer_widgets', true ) && ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) ): ?> 
                <div class="epicjungle-footer-shop-top pt-5 pt-md-6">
                    <div class="container pt-3 pb-0 pt-md-0 pb-md-3">
                        <div class="row mb-4">
                            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                                <div class="col-md-4">
                                    <?php dynamic_sidebar( apply_filters('epicjungle_footer_widget_1', 'footer-1' ) ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                                <div class="col-md-4">
                                    <?php dynamic_sidebar( apply_filters('epicjungle_footer_widget_2', 'footer-2' ) ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                                <div class="col-md-4">
                                    <?php dynamic_sidebar( apply_filters('epicjungle_footer_widget_3', 'footer-3' ) ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
               
            <?php endif; 
        }

    }
}

if ( ! function_exists( 'epicjungle_footer_blog_top_bar' ) ) {
    function epicjungle_footer_blog_top_bar() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $enable_newsletter = isset( $ej_page_options['footer']['enable_newsletter_form'] ) ? filter_var( $ej_page_options['footer']['enable_newsletter_form'], FILTER_VALIDATE_BOOLEAN ) : false;
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_newsletter = filter_var( get_theme_mod( 'shop_enable_newsletter_form', 'no' ), FILTER_VALIDATE_BOOLEAN );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_newsletter = filter_var( get_theme_mod( 'blog_enable_newsletter_form', 'no' ), FILTER_VALIDATE_BOOLEAN );
        } else {
            $enable_newsletter = filter_var( get_theme_mod( 'enable_newsletter_form', 'no' ), FILTER_VALIDATE_BOOLEAN );
        }

        if ( epicjungle_is_extensions_activated() ) {
            $footer_1_classes = 'col-md-7 mb-3';
            $footer_2_classes = 'col-md-4 ml-auto mb-3';
            
        } else {
            $footer_1_classes = 'col-md-12 col-xl-8';
            $footer_2_classes = 'col-md-12 col-xl-4 mb-3';
           
        } ?>

        <div class="epicjungle-footer-blog-top pt-5 pt-md-6">        
            <div class="container pt-3 pt-md-0">
                <div class="row mb-4">
                    <div class="mb-3 <?php echo esc_attr( $enable_newsletter ? $footer_1_classes : 'col-md-12' );?>">
                        <?php if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
                            $footer_static_widgets = isset( $ej_page_options['footer']['footer_static_widgets'] ) ? $ej_page_options['footer']['footer_static_widgets'] : '';

                            if( epicjungle_is_mas_static_content_activated() && ! empty( $footer_static_widgets ) ) { 
                                print( epicjungle_render_content( $footer_static_widgets, false ) );  

                            }

                         } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout()  )  &&  (int) get_theme_mod( 'shop_footer_widgets') > 0  ) {
                            $footer_static_widgets = get_theme_mod( 'shop_footer_widgets' );  

                            if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'shop_footer_widgets') > 0 ) { 

                                print( epicjungle_render_content( $footer_static_widgets, false ) );  

                            }    
                        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN )  &&  (int) get_theme_mod( 'blog_footer_widgets') > 0  ) {
                            $footer_static_widgets = get_theme_mod( 'blog_footer_widgets' ); 

                            if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'blog_footer_widgets') > 0 ) { 
                               
                                print( epicjungle_render_content( $footer_static_widgets, false ) ); 

                             } 
        
                        } else { ?> 
                            <div class="d-sm-flex justify-content-between footer-blog-widgets">
                                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                                    <div class="cs-widget cs-widget-light pb-1 mb-4">
                                        <?php dynamic_sidebar( apply_filters('epicjungle_footer_widget_1', 'footer-1' ) ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                                    <div class="cs-widget cs-widget-light pb-1 mb-4">
                                        <?php dynamic_sidebar( apply_filters('epicjungle_footer_widget_2', 'footer-2' ) ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                                    <div class="cs-widget cs-widget-light pb-1 mb-4">
                                        <?php dynamic_sidebar( apply_filters('epicjungle_footer_widget_3', 'footer-3' ) ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php } ?>
                    </div>

                    <?php if ( $enable_newsletter ): ?>
                        <div class="<?php echo esc_attr( $footer_2_classes );?>">
                            <?php epicjungle_footer_newsletter(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><?php
        
    }
}



if ( ! function_exists( 'epicjungle_footer_shop_bottom_bar' ) ) {
    function epicjungle_footer_shop_bottom_bar() { 
        $has_footer_pm = ! empty( epicjungle_get_footer_pm() ) ? true : false;
        ?>
        <div class="footer-content">
            <div class="footer-body">
                <?php if ( apply_filters( 'epicjungle_enable_footer_static_content' , true )) :
                    epicjungle_footer_static_content(); ?>
                <?php endif; ?>

                <div class="d-sm-flex align-items-center mb-4 pb-3">
                    <div class="d-flex flex-wrap align-items-center mr-3">
                        
                         <?php epicjungle_footer_logo ( true, array (
                            'site-title' => 'navbar-brand text-light d-block mr-grid-gutter mt-n1 mb-3' 
                        ) ); ?>

                        <?php if ( apply_filters( 'epicjungle_enable_footer_links' , true )) : ?>
                            <?php epicjungle_footer_shop_links(); ?>
                        <?php endif; ?>
                    </div>

                    <?php if ( has_nav_menu( 'social_media' ) && apply_filters( 'epicjungle_enable_footer_social_icons', true ) ) : ?>
                        <div class="d-flex pt-2 pt-sm-0 ml-auto">
                            <?php epicjungle_social_media_links(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-sm-flex justify-content-between align-items-center pb-4 pb-sm-2">
                    <?php if ( $has_footer_pm ) : ?>
                        <div class="order-sm-2 mb-4 mb-sm-3">
                            <?php echo epicjungle_get_footer_pm(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( epicjungle_is_copyright() ): ?>
                        <div class="order-sm-1 mb-3">
                            <?php epicjungle_footer_default_copyright_text(); ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div><?php

    }
 }

if ( ! function_exists( 'epicjungle_footer_blog_bottom_bar' ) ) {
    function epicjungle_footer_blog_bottom_bar() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();


        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $custom_html = isset( $ej_page_options['footer']['epicjungle_custom_html'] ) ? $ej_page_options['footer']['epicjungle_custom_html'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $custom_html = get_theme_mod( 'shop_epicjungle_custom_html' ); 
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $custom_html = get_theme_mod( 'blog_epicjungle_custom_html' ); 
        } else {
            $custom_html = get_theme_mod( 'epicjungle_custom_html' ); 
        }

        ?>
        <div class="bg-darker py-4 py-md-3">
            <div class="container d-md-flex align-items-center justify-content-between pt-3">
                <?php if (  '' !== $custom_html ) : ?>
                    <div class="d-flex flex-wrap flex-sm-nowrap order-md-2 mb-3 mb-md-0">
                        <?php epicjungle_footer_blog_download_app(); ?>
                    </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap align-items-center order-md-1">
                    <?php epicjungle_footer_logo ( true, array (
                        'site-title' => 'navbar-brand text-light d-block mr-grid-gutter mb-3' 
                    ) ); ?>

                    <?php if ( epicjungle_is_copyright() ): ?>
                        <?php epicjungle_footer_default_copyright_text(); ?>
                    <?php endif; ?>
                </div>

            </div>
        </div><?php

    }
}

if ( ! function_exists( 'epicjungle_footer_blog_download_app' ) ) {
    function epicjungle_footer_blog_download_app() { 
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $custom_html = isset( $ej_page_options['footer']['epicjungle_custom_html'] ) ? $ej_page_options['footer']['epicjungle_custom_html'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $custom_html = get_theme_mod( 'shop_epicjungle_custom_html' ); 
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $custom_html = get_theme_mod( 'blog_epicjungle_custom_html' ); 
        } else {
            $custom_html = get_theme_mod( 'epicjungle_custom_html' ); 
        }
        echo wp_kses_post( $custom_html );
    }
}

/**
 * Display the footer menu
 */
if( ! function_exists( 'epicjungle_footer_links' ) ) {
    function epicjungle_footer_links() {
        if ( ! has_nav_menu( 'footer_links' ) ) {
            return;
        }

        $footer_variant = epicjungle_footer_variant();
        $footer_skin    = epicjungle_footer_skin();
        //$footer_template= get_template_part( 'templates/footer/footer', 'v10' );

        //echo '<pre>' . print_r( $footer_template, 1 ) . '</pre>';


        if ( $footer_variant === 'shop') {
            $menu_class   = 'pt-2 mb-3';
            $item_class   = '';
            $anchor_class = 'nav-link-light';
        } elseif ( $footer_variant === 'default') {
            if ( 'dark' === $footer_skin ) {
                $menu_class   = 'mb-0';
                $item_class   = '';
                $anchor_class = 'nav-link-light';
            } else {
                $menu_class   = 'mb-0';
                $item_class   = '';
                $anchor_class = '';
            }
        } elseif ( $footer_variant === 'simple') {
            if ( 'dark' === $footer_skin ) {
                $menu_class   = 'mb-3 order-md-2';
                $item_class   = 'my-1';
                $anchor_class = 'nav-link-style nav-link-light';
            } else {
                $menu_class   = 'mb-3 mb-md-0 order-md-2';
                $item_class   = 'my-1';
                $anchor_class = 'nav-link-style';
            }
        } elseif ( $footer_variant === 'v7') {
            $menu_class   = 'mb-0 order-md-2';
            $item_class   = '';
            $anchor_class = 'nav-link-light';
        } elseif ( $footer_variant === 'v10' || is_404() ) {
            $menu_class   = 'mb-3 mb-md-0 order-md-2';
            $item_class   = 'my-1';
            $anchor_class = '';
        } else {
            $menu_class   = 'mb-0';
            $item_class   = '';
            $anchor_class = 'nav-link-light';
        }

        $nav_links_args = apply_filters( 'epicjungle_footer_links_args', [
            'theme_location' => 'footer_links',
            'container'      => false,
            'menu_class'     => 'footer-links list-inline font-size-sm ' . $menu_class .'',
            'walker'         => new WP_Bootstrap_Navwalker(),
            'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
            'item_class'     => [ 'list-inline-item', $item_class ],
            'anchor_class'   => [ 'nav-link-style', 'p-0', $anchor_class ],
            'depth'          => 1
            
        ] );


        wp_nav_menu( $nav_links_args );
    }
}


/**
 * Display the footer menu
 */
if( ! function_exists( 'epicjungle_footer_shop_links' ) ) {
    function epicjungle_footer_shop_links() {
        if ( ! has_nav_menu( 'footer_shop_links' ) ) {
            return;
        }

        $footer_variant = epicjungle_footer_variant();
        $footer_skin    = epicjungle_footer_skin();

        
        $nav_links_args = apply_filters( 'epicjungle_footer_shop_links_args', [
            'theme_location' => 'footer_shop_links',
            'container'      => false,
            'menu_class'     => 'footer-links list-inline font-size-sm pt-2 mb-3',
            'walker'         => new WP_Bootstrap_Navwalker(),
            'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
            'item_class'     => [ 'list-inline-item' ],
            'anchor_class'   => [ 'nav-link-style', 'nav-link-light', 'p-0' ],
            
        ] );


        wp_nav_menu( $nav_links_args );
    }
}


if ( ! function_exists( 'epicjungle_footer_static_content' ) ) {
    function epicjungle_footer_static_content() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();
        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $footer_content = isset( $ej_page_options['footer']['footer_jumbotron'] ) ? $ej_page_options['footer']['footer_jumbotron'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $footer_content = get_theme_mod( 'shop_footer_jumbotron' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $footer_content = get_theme_mod( 'blog_footer_jumbotron' );
        } else {
            $footer_content = get_theme_mod( 'footer_jumbotron' );
        }

        if( epicjungle_is_mas_static_content_activated() && ! empty( $footer_content ) ) {
            print( epicjungle_render_content( $footer_content, false ) ); 
            
        }
    }
}

if( ! function_exists( 'epicjungle_get_footer_pm' ) ) {
    function epicjungle_get_footer_pm() {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $html = '';
        if ( apply_filters( 'epicjungle_enable_footer_payment_method' , true ) ) {
            $ej_page_options  = array();
            if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
                $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
                $_ej_page_options = maybe_unserialize( $clean_meta_data );

                if( is_array( $_ej_page_options ) ) {
                    $ej_page_options = $_ej_page_options;
                }
            }

            if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
                $attachment_id = isset( $ej_page_options['footer']['footer_payment_methods'] ) ? $ej_page_options['footer']['footer_payment_methods'] : '';
            } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
                $attachment_id = get_theme_mod( 'shop_footer_payment_methods' );
            } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
                $attachment_id = get_theme_mod( 'blog_footer_payment_methods' );
            } else {
                $attachment_id = get_theme_mod( 'footer_payment_methods' );
            }

            //echo '<pre>' . print_r( $attachment_id, 1 ) . '</pre>';
            if ((int) $attachment_id && $attachment_id > 0 ) {
                $meta  = wp_get_attachment_metadata( $attachment_id );
                $width = (int) $meta['width'];

                $html = sprintf( '<div class="d-inline-block payment-methods" style="width: %dpx">%s</div>',
                    (float) $width / 2,
                    wp_get_attachment_image( $attachment_id, 'full' )
                );
            } elseif ( is_customize_preview() ) {
                $html = '<div class="d-inline-block payment-methods"><img></div>';
            }
        }

        return (string) apply_filters( 'epicjungle_footer_payment_methods', $html );
    }
}

if ( ! function_exists( 'epicjungle_footer_newsletter' ) ) {
    /**
    * Displays Footer Newsletter
    *
    */
    function epicjungle_footer_newsletter(  $footer_version='' ) {
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();
        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        $enable_custom_footer = isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ? true : false;

        if( $enable_custom_footer ) {
            $enable_newsletter = isset( $ej_page_options['footer']['enable_newsletter_form'] ) ? $ej_page_options['footer']['enable_newsletter_form'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $enable_newsletter = get_theme_mod( 'shop_enable_newsletter_form', 'no' );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
            $enable_newsletter = get_theme_mod( 'blog_enable_newsletter_form', 'no' );
        } else {
            $enable_newsletter = get_theme_mod( 'enable_newsletter_form', 'no' );
        }

        if( apply_filters( 'epicjungle_footer_newsletter', filter_var( $enable_newsletter, FILTER_VALIDATE_BOOLEAN )  ) ) {
            $newsletter_title_default = esc_html__( 'Don’t miss a single story', 'epicjungle' );
            $newsletter_desc_default = esc_html__( 'Subscribe to our newsletter to receive latest articles to your inbox weekly.', 'epicjungle' );
            if( $enable_custom_footer ) {
                $newsletter_title = isset( $ej_page_options['footer']['epicjungle_newsletter_title'] ) ? $ej_page_options['footer']['epicjungle_newsletter_title'] : $newsletter_title_default;
                $newsletter_desc  = isset( $ej_page_options['footer']['epicjungle_newsletter_desc'] ) ? $ej_page_options['footer']['epicjungle_newsletter_desc'] : $newsletter_desc_default;
                $newsletter_form =isset( $ej_page_options['footer']['epicjungle_newsletter_form'] ) ? $ej_page_options['footer']['epicjungle_newsletter_form'] : '';
            } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
                $newsletter_title = apply_filters( 'epicjungle_shop_footer_newsletter_title', get_theme_mod( 'shop_epicjungle_newsletter_title', $newsletter_title_default ) );
                $newsletter_desc  = apply_filters( 'epicjungle_shop_footer_newsletter_desc', get_theme_mod( 'shop_epicjungle_newsletter_desc', $newsletter_desc_default ) );
                $newsletter_form = apply_filters( 'epicjungle_shop_footer_newsletter_shortcode', get_theme_mod('shop_epicjungle_newsletter_form') );
            } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) { 
                $newsletter_title = apply_filters( 'epicjungle_blog_footer_newsletter_title', get_theme_mod( 'blog_epicjungle_newsletter_title', $newsletter_title_default ) );
                $newsletter_desc  = apply_filters( 'epicjungle_blog_footer_newsletter_desc', get_theme_mod( 'blog_epicjungle_newsletter_desc', $newsletter_desc_default ) );
                $newsletter_form = apply_filters( 'epicjungle_blog_footer_newsletter_shortcode', get_theme_mod('blog_epicjungle_newsletter_form') );
            } else {
                $newsletter_title = apply_filters( 'epicjungle_footer_newsletter_title', get_theme_mod( 'epicjungle_newsletter_title', $newsletter_title_default ) );
                $newsletter_desc  = apply_filters( 'epicjungle_footer_newsletter_desc', get_theme_mod( 'epicjungle_newsletter_desc', $newsletter_desc_default ) );
                $newsletter_form = apply_filters( 'epicjungle_footer_newsletter_shortcode', get_theme_mod('epicjungle_newsletter_form') );
            }

            if ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
                    $newsletter_title = apply_filters( 'epicjungle_footer_newsletter_title', $newsletter_title );
                    $newsletter_desc  = apply_filters( 'epicjungle_footer_newsletter_desc', $newsletter_desc );
                    $newsletter_form = apply_filters( 'epicjungle_footer_newsletter_shortcode', $newsletter_form );
                } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) { 
                    $newsletter_title = apply_filters( 'epicjungle_footer_newsletter_title', $newsletter_title );
                    $newsletter_desc  = apply_filters( 'epicjungle_footer_newsletter_desc', $newsletter_desc );
                    $newsletter_form = apply_filters( 'epicjungle_footer_newsletter_shortcode', $newsletter_form );
                } else {

                $newsletter_title = apply_filters( 'epicjungle_footer_newsletter_title', $newsletter_title );
                $newsletter_desc  = apply_filters( 'epicjungle_footer_newsletter_desc', $newsletter_desc );
                $newsletter_form = apply_filters( 'epicjungle_footer_newsletter_shortcode', $newsletter_form );
            }

            ?><div class="cs-widget cs-widget-light mb-4">
                <?php if ( ! empty( $newsletter_title ) || ! empty( $newsletter_desc )  ): ?>
                    <?php if ( ! empty( $newsletter_title ) ) : ?>
                        <h4 class="cs-widget-title"><?php echo esc_html( $newsletter_title ); ?></h4>
                    <?php endif; ?>
                    <?php if ( ! empty( $newsletter_desc ) ) : ?>
                        <p class="font-size-sm text-light opacity-60"><?php echo esc_html( $newsletter_desc ); ?></p>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if ( ! empty( $newsletter_form ) ) :
                    echo do_shortcode( $newsletter_form );
                else :
                    footer_newsletter_form();
                endif; ?>
            </div><?php

        }
    }
}

if ( ! function_exists( 'footer_newsletter_form' ) ) {
    /**
     * epicjungle Footer Newsletter Form
     */
    function footer_newsletter_form() {
        ob_start();
        ?>

        <form class="cs-subscribe-form validate" action="#" method="post" name="mc-embedded-subscribe-form" target="_blank" novalidate="">
            <div class="input-group input-group-overlay flex-nowrap">
                <div class="input-group-prepend-overlay">
                    <span class="input-group-text text-muted"><i class="fe-mail"></i></span>
                </div>

                <input class="form-control prepended-form-control" type="email" name="EMAIL" placeholder="Your email">

                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="subscribe">Subscribe</button>
                </div>
            </div>
        </form>
        <?php
        $footer_newsletter_form = ob_get_clean();

        echo apply_filters( 'epicjungle_footer_newsletter_form', $footer_newsletter_form );
    }
}

if ( ! function_exists( 'epicjungle_footer_v6_widgets' ) ) {
    function epicjungle_footer_v6_widgets() { 
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();

        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        } 

        if ( epicjungle_is_extensions_activated() ) {
            $footer_0_classes = 'col-lg-3 col-md-4 pb-4';
            $footer_1_classes = 'col-lg-3 col-md-4 pb-4';
            $footer_2_classes = 'col-md-3 pb-4';
            $footer_3_classes = 'col-md-3 pb-4';
            
        } else {
            $footer_0_classes = 'col-lg-3 col-md-4 pb-4';
            $footer_1_classes = 'col-lg-3 col-md-4 pb-4';
            $footer_2_classes = 'col-lg-3 col-md-4 pb-4';
            $footer_3_classes = 'col-lg-3 col-md-4 pb-4';
           
        }

        ?>


        <div class="row pt-md-2 pb-3">
            <div class="<?php echo esc_attr( $footer_0_classes ); ?>">
                <?php epicjungle_footer_logo ( true, array (
                     'site-title' => 'navbar-brand text-light d-block mb-3' 
                ) );

                $desc = get_bloginfo( 'description' );


                if ( ! empty( $desc ) && apply_filters( 'epicjungle_footer_v6_site_desc', true ) ) {
                    echo wp_kses( '<p class="font-size-sm text-light opacity-50 mb-0">' . $desc . '</p>', array( 'p' => array( 'class' => array() ) ) );
                } ?>
            </div>

            <?php if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
                $footer_static_widgets = isset( $ej_page_options['footer']['footer_static_widgets'] ) ? $ej_page_options['footer']['footer_static_widgets'] : '';

                if( epicjungle_is_mas_static_content_activated() && ! empty( $footer_static_widgets ) ) { ?>
                    <div class="col-lg-9 col-md-8 pb-4">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                }
            } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() ) &&  (int) get_theme_mod( 'shop_footer_widgets') > 0  ) {
                $footer_static_widgets = get_theme_mod( 'shop_footer_widgets' );  

                if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'shop_footer_widgets') > 0 ) { ?>
                    <div class="col-lg-9 col-md-8 pb-4">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                }    
            
            } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN )  &&  (int) get_theme_mod( 'blog_footer_widgets') > 0  ) {
                $footer_static_widgets = get_theme_mod( 'blog_footer_widgets' ); 

                if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'blog_footer_widgets') > 0 ) { ?>
                    <div class="col-lg-9 col-md-8 pb-4">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                 } 
            } else {

                if ( is_active_sidebar( 'footer-1' ) ) : ?><div class="<?php echo esc_attr( $footer_1_classes ); ?>"><?php
                    dynamic_sidebar( 'footer-1' );
                ?></div><?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?><div class="<?php echo esc_attr( $footer_2_classes ); ?>"><?php
                    dynamic_sidebar( 'footer-2' );
                ?></div><?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?><div class="<?php echo esc_attr( $footer_3_classes ); ?>"><?php
                    dynamic_sidebar( 'footer-3' );
                ?></div><?php endif; 
            } ?>
            
        </div><?php
    }
}

if ( ! function_exists( 'epicjungle_footer_v7_widgets' ) ) {
    function epicjungle_footer_v7_widgets() { 
        $woocommerce = function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated();
        $ej_page_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_page_options', true );
            $_ej_page_options = maybe_unserialize( $clean_meta_data );

            if( is_array( $_ej_page_options ) ) {
                $ej_page_options = $_ej_page_options;
            }
        }

        if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
            $contact_title = isset( $ej_page_options['footer']['contact_title'] ) ? $ej_page_options['footer']['contact_title'] : '';
        } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() )  ) ) {
            $contact_title = get_theme_mod( 'shop_contact_title', esc_html__( 'Contacts', 'epicjungle' ) );
        } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) { 
            $contact_title = get_theme_mod( 'blog_contact_title', esc_html__( 'Contacts', 'epicjungle' ) );
        } else {
            $contact_title = get_theme_mod( 'contact_title', esc_html__( 'Contacts', 'epicjungle' ) );
        }




        $footer_skin   = epicjungle_footer_skin();
        ?>
        <div class="container py-3 pt-md-0">
            <div class="row pb-2 pb-md-5">
            <?php if( isset( $ej_page_options['footer'] ) && isset( $ej_page_options['footer']['enable_custom_footer'] ) && $ej_page_options['footer']['enable_custom_footer'] === 'yes' ) {
                $footer_static_widgets = isset( $ej_page_options['footer']['footer_static_widgets'] ) ? $ej_page_options['footer']['footer_static_widgets'] : '';

                if( epicjungle_is_mas_static_content_activated() && ! empty( $footer_static_widgets ) ) { ?>
                    <div class="col-xl-6 col-lg-7 col-md-7 mb-5">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                }
            } elseif ( filter_var( get_theme_mod( 'enable_separate_footer_for_shop', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout()  ) &&  (int) get_theme_mod( 'shop_footer_widgets') > 0  ) {
                $footer_static_widgets = get_theme_mod( 'shop_footer_widgets' );  

                if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'shop_footer_widgets') > 0 ) { ?>
                    <div class="col-xl-6 col-lg-7 col-md-7 mb-5">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                }    
            } elseif ( is_singular( 'post' ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog', 'no' ), FILTER_VALIDATE_BOOLEAN )  &&  (int) get_theme_mod( 'blog_footer_widgets') > 0  ) {
                $footer_static_widgets = get_theme_mod( 'blog_footer_widgets' ); 

                if( epicjungle_is_mas_static_content_activated() && (int) get_theme_mod( 'blog_footer_widgets') > 0 ) { ?>
                    <div class="col-xl-6 col-lg-7 col-md-7 mb-5">  
                        <?php print( epicjungle_render_content( $footer_static_widgets, false ) );  ?>
                    </div><?php
                }
            } else {
                if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="col-xl-6 col-lg-7 col-md-7 mb-5">
                        <?php dynamic_sidebar( 'footer-1' );?>
                    </div>
                
                <?php endif; 
            } ?>
            <?php if ( !empty ( $contact_title ) || has_nav_menu( 'social_media' ) || has_nav_menu( 'contact_links' ) ) { ?>
                <div class="col-xl-3 col-lg-4 offset-xl-3 offset-lg-1 col-md-5 mb-5">
                    <?php if ( !empty ( $contact_title ) ): ?>
                        <h2 class="text-<?php echo esc_attr( $footer_skin === 'light' ? 'dark' : 'light' );?> pb-2"><?php echo esc_html( $contact_title ); ?></h2>
                    <?php endif; ?>

                    <?php epicjungle_contact_links(); ?>
                    <?php if ( has_nav_menu( 'social_media' ) ): ?>
                        <h3 class="h6 pb-2 text-<?php echo esc_attr( $footer_skin === 'light' ? 'dark' : 'light' );?>"><?php echo apply_filters('epicjungle_social_menu_title', esc_html__( 'Or connect with us on:', 'epicjungle' ) );?></h3>
                    <?php endif; 
                    epicjungle_social_media_links(); ?>

                </div>
            <?php } ?>
            </div>
        </div>

        <?php if ( apply_filters ('epicjungle_enable_footer_v7_copyright', true ) ): ?>
            <div class="bg-dark pt-5 pb-4">
                <div class="container d-md-flex justify-content-between align-items-center text-center">
                    
                    <?php epicjungle_footer_links(); ?>
                    <?php epicjungle_footer_default_copyright_text(); ?>
                </div>
            </div><?php
        endif;
    }
}


if ( ! function_exists( 'epicjungle_footer_v8_widgets' ) ) {
    function epicjungle_footer_v8_widgets() { 
        if ( apply_filters( 'epicjungle_enable_footer_v8_static_content' , true )) :
            epicjungle_footer_static_content(); 
            epicjungle_footer_default_copyright_text();
        endif; 
    }
}

if ( ! function_exists( 'epicjungle_custom_widget_nav_menu_options' ) ) :
    function epicjungle_custom_widget_nav_menu_options( $widget, $return, $instance ) {
        // Are we dealing with a nav menu widget?
        if ( 'nav_menu' == $widget->id_base ) {
            $is_social_icon_menu = isset( $instance['is_social_icon_menu'] ) ? $instance['is_social_icon_menu'] : '';
            ?>
                <p>
                    <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $widget->get_field_id('is_social_icon_menu') ); ?>" name="<?php echo esc_attr( $widget->get_field_name('is_social_icon_menu') ); ?>" <?php checked( true , $is_social_icon_menu ); ?> />
                    <label for="<?php echo esc_attr( $widget->get_field_id('is_social_icon_menu') ); ?>">
                        <?php esc_html_e( 'Is Social Icon Menu', 'epicjungle' ); ?>
                    </label>
                </p>
            <?php
        }
    }
endif;

if ( ! function_exists( 'epicjungle_custom_widget_nav_menu_options_update' ) ) :
    function epicjungle_custom_widget_nav_menu_options_update( $instance, $new_instance, $old_instance, $widget ) {
        if ( 'nav_menu' == $widget->id_base ) {
            if ( isset( $new_instance['is_social_icon_menu'] ) && ! empty( $new_instance['is_social_icon_menu'] ) ) {
                $instance['is_social_icon_menu'] = 1;
            }
        }

        return $instance;
    }
endif;

if ( ! function_exists( 'epicjungle_custom_widget_nav_menu_args' ) ) :
    function epicjungle_custom_widget_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {
       
        $footer_variant = epicjungle_footer_variant();
        if( isset( $instance['is_social_icon_menu'] ) && ! empty( $instance['is_social_icon_menu'] ) ) {

            if ( $footer_variant === 'shop') {
                $item_class   ='ml-2 mb-2 mr-0';
                $anchor_class ='';
            } elseif ( $footer_variant === 'simple-2') {
                $item_class   ='mr-2 mb-0';
                $anchor_class ='sb-outline';
            } else {
                $item_class   ='mr-2 mb-2';
                $anchor_class ='sb-outline sb-lg';
            }

            $social_nav_menu_args =   array(
                'theme_location' => 'social_media',
                'container'      => false,
                'menu_class'     => 'list-unstyled list-inline list-social mb-0',
                'item_class'     => [ 'list-inline-item', 'list-social-item', $item_class ],
                'anchor_class'   => [ 'social-btn', 'sb-light', $anchor_class ],
                'icon_class'     => [ 'list-social-icon' ],
                'walker'         => new WP_Bootstrap_Navwalker(),
                'disable_schema'    => true,
                'disable_data_attr' => true,
            );
                

            $nav_menu_args = array_merge( $nav_menu_args, $social_nav_menu_args );
        }

        return $nav_menu_args;
    }
endif;