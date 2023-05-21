<?php
/**
 * EpicJungle jetpack functions.
 *
 * @package epicjungle
 */

if ( ! function_exists( 'epicjungle_shares_jetpack' ) ) {
    function epicjungle_shares_jetpack( $provider ) {
        $provider = 'jetpack';
        return $provider;
    }
}

add_filter( 'epicjungle_shares_provider', 'epicjungle_shares_jetpack' );

if ( ! function_exists( 'epicjungle_display_jetpack_shares' ) ) {
    function epicjungle_display_jetpack_shares() {
        if ( function_exists( 'sharing_display' ) ) {
            echo sharing_display();
        }
    }
}

add_action( 'epicjungle_shares_jetpack', 'epicjungle_display_jetpack_shares' );

if ( ! function_exists( 'epicjungle_jetpack_sharing_filters' ) ) {
    function epicjungle_jetpack_sharing_filters() {
        
        if ( apply_filters( 'epicjungle_enable_epicjungle_jetpack_sharing', true ) ) {
            $options = get_option( 'sharing-options' );
        
            if ( isset( $options['global']['button_style'] ) && ( 'icon' == $options['global']['button_style'] || 'icon-text' == $options['global']['button_style'] ) ) {
                add_filter( 'jetpack_sharing_display_classes', 'epicjungle_jetpack_sharing_display_classes', 10, 4 );
                add_filter( 'jetpack_sharing_headline_html', 'epicjungle_jetpack_sharing_headline_html', 10, 3 );
                add_filter( 'jetpack_sharing_display_markup', 'epicjungle_jetpack_sharing_display_markup', 10, 2 );
            }
        }
    }
}


add_action( 'epicjungle_single_post_before', 'epicjungle_jetpack_sharing_filters', 5 );
add_action( 'woocommerce_before_single_product', 'epicjungle_jetpack_sharing_filters', 5 );

if ( ! function_exists( 'epicjungle_jetpack_sharing_display_classes' ) ) {
    function epicjungle_jetpack_sharing_display_classes( $klasses, $service, $id, $args ) {
        if ( 'icon' == $service->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }

            $klasses[] = 'social-btn';
            $klasses[] = 'sb-' . $service->shortname;
            $klasses[] = 'sb-outline';

            if ( is_a( $service, 'Share_Custom' ) ) {
                return $klasses;
            }

            if ( $service->shortname == 'print' ) {
                $klasses[] = 'fe-printer';
            } else {
                $klasses[] = 'fe-' . $service->shortname;
            }
            
        } elseif ( 'icon-text' == $service->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }

            $klasses[] = 'share-btn';
            $klasses[] = 'sb-' . $service->shortname;
            $klasses[] = 'sb-outline';

            if ( is_a( $service, 'Share_Custom' ) ) {
                return $klasses;
            }

            if ( $service->shortname == 'print' ) {
                $klasses[] = 'fe-printer';
            } else {
                $klasses[] = 'fe-' . $service->shortname;
            }

        } 

        return $klasses;
    }
}

if ( ! function_exists( 'epicjungle_jetpack_sharing_headline_html' ) ) {
    function epicjungle_jetpack_sharing_headline_html( $heading_html, $sharing_label, $action ) {
        return '<h6 class="sharing-title d-inline-block text-nowrap my-2 mr-3">%s</h6>';    
    }
}

if ( ! function_exists( 'epicjungle_jetpack_sharing_display_markup' ) ) {
    function epicjungle_jetpack_sharing_display_markup( $sharing_content, $enabled = array() ) {
        $sharing_content = str_replace( '<ul>', '', $sharing_content );
        // if( isset( $enabled['hidden'] ) && count( $enabled['hidden'] ) > 0 ) {
        //     // $sharing_content = str_replace( '</ul><div class="sharing-hidden">', '<div class="sharing-hidden">', $sharing_content );
        //     // $sharing_content = str_replace( '<ul style="background-image:none;">', '<div>', $sharing_content );
        //     // $sharing_content = str_replace( '<ul>', '<div class="d-flex flex-wrap mr-n2 mb-n2">', $sharing_content );
        //     // $sharing_content = str_replace( '</ul></div></div></div></div></div>', '</div></div></div></div></div>', $sharing_content );
        //     // $sharing_content = str_replace( '<div class="inner" style="display: none;', '<div class="inner" style="display: none; width:102px;', $sharing_content );
        // } else {
        //     //$sharing_content = str_replace( '</ul></div></div></div>', '</div></div>', $sharing_content );
        // }

        $sharing_content = str_replace( '<li class="share-end">', '<li class="share-end" style="display:none !important;">', $sharing_content );
        $sharing_content = str_replace( '</li>', '</span>', $sharing_content );
        $sharing_content = str_replace( '<span></span>', '<i></i>', $sharing_content );
        $sharing_content = str_replace( '<span style="background-image:', '<span style="display: block; background-position: center; background-size: contain; height: 100%; width: 100%; background-repeat: no-repeat; background-image:', $sharing_content );

        
        $sharing_content = str_replace( 'class="robots-nocontent', 'class="mt-3 d-flex align-items-center', $sharing_content );
        $sharing_content = str_replace( '<li class="share-', '<span class="d-inline-block align-middle ml-2 my-2 ', $sharing_content );
        $sharing_content = str_replace( '<li><a href="#" class="sharing-anchor sd-button share-more"><span>', '<span class="d-inline-block align-middle ml-2 my-2"><a href="#" class="align-middle social-btn share-btn sharing-anchor share-more share-alt"><i></i><span class="sr-only">', $sharing_content );
            

        return $sharing_content;
    }
}
