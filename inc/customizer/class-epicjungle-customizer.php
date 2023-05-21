<?php
/**
 * EpicJungle Customizer Class
 *
 * @package  epicjungle
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle_Customizer' ) ) :

    /**
     * The epicjungle Customizer class
     */
    class EpicJungle_Customizer {

        public $static_contents;

    	/**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            $this->init_hooks();
        }

      

        /**
         * Init EpicJungle_Customizer when Wordpress Initializes
         */
        public function init_hooks() {
            add_action( 'customize_register', array( $this, 'customize_logos' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_general' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_header' ), 10 ); 
            add_action( 'customize_register', array( $this, 'customize_footer' ), 10 ); 
            add_action( 'customize_register', array( $this, 'customize_blog' ), 10 );
            add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
            add_action( 'init',               array( $this, 'default_theme_mod_values' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_404' ), 10 );
            add_action( 'customize_controls_print_scripts', array( $this, 'add_scripts' ), 30 );
            add_action( 'customize_register', array( $this, 'customize_customcolor' ), 10 );

        }

        /**
         * Scripts to improve our form.
         */
        public function add_scripts() { 
            $args     = array( 'fields' => 'ids', 'post_type' => 'post', 'posts_per_page' => 1 );
            $posts    = get_posts( $args );

            $args     = array( 'fields' => 'ids', 'post_type' => 'jetpack-portfolio', 'posts_per_page' => 1 );
            $projects = get_posts( $args );

            
            $post_link = get_permalink( get_option( 'page_for_posts' ) );
            

            if ( isset( $projects[0] ) ) {
                $portfolio_link = get_permalink( $projects[0] );
            } else {
                $portfolio_link = get_post_type_archive_link( 'jetpack-portfolio' );
            }

            ?>
            <script type="text/javascript">
            jQuery( document ).ready( function( $ ) {
                wp.customize.section( 'epicjungle_blog', function( section ) {
                    section.expanded.bind( function( isExpanded ) {
                        if ( isExpanded ) {
                            wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $post_link ); ?>' );
                        }
                    } );
                } );

                wp.customize.section( 'epicjungle_portfolio', function( section ) {
                    section.expanded.bind( function( isExpanded ) {
                        if ( isExpanded ) {
                            wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $portfolio_link ) ; ?>' );
                        }
                    } );
                } );
            
            });
            </script><?php
        }

        /**
         * Customize site header
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_general( $wp_customize ) {
            $wp_customize->add_section( 'epicjungle_general', [
                'title'       => esc_html__( 'General', 'epicjungle' ),
                'description' => esc_html__( 'This section contains settings related to general.', 'epicjungle' ),
                'priority'    => 20,
            ] );

            $this->add_general_section( $wp_customize );
        }

        private function add_general_section( $wp_customize ) {
            $this->static_contents = epicjungle_static_content_options();

            $wp_customize->add_setting( 'enable_scroll_to_top', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_scroll_to_top', [
                'type'        => 'radio',
                'section'     => 'epicjungle_general',
                'label'       => esc_html__( 'Enable Scroll to Top', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_scroll_to_top', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'enable_page_loading_animation', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_page_loading_animation', [
                'type'        => 'radio',
                'section'     => 'epicjungle_general',
                'label'       => esc_html__( 'Enable Page Loading Animation', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_page_loading_animation', [
                'fallback_refresh'    => true
            ] );

        }




        /**
         * Customize all available site logos
         *
         * All logos located in title_tagline (Site Identity) section.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_logos( $wp_customize ) {
            $this->add_customize_logos( $wp_customize );
        }

        private function add_customize_logos( $wp_customize ) {
            $wp_customize->get_control( 'custom_logo' )->description = esc_html__(
                'Logo is optimized for retina displays, so the original image size should be twice
                as big as the final logo that appears on the website. For example, if you want logo to
                be 142x34 px you should upload image 284x68 px.',
                'epicjungle'
            );

            // Update the "custom_logo" partial with a new render callback
            // TODO: wrap into anonymous function with return context
            $wp_customize->selective_refresh->get_partial( 'custom_logo' )->render_callback = 'epicjungle_get_logo';
            //</editor-fold>

            //<editor-fold desc="mobile_logo">
            $wp_customize->add_setting( 'mobile_logo', [
                'transport'      => 'postMessage',
                'theme_supports' => 'custom-logo',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'mobile_logo', [
                'section'       => 'title_tagline',
                'label'         => esc_html__( 'Mobile Logo', 'epicjungle' ),
                'description'   => esc_html__( 'Mobile logo inherits the same behavior for retina displays as desktop logo.', 'epicjungle' ),
                'priority'      => 9,
                'width'         => 60,
                'height'        => 60,
                'flex_width'    => true,
                'flex_height'   => true,
                'button_labels' => [
                    'select'       => esc_html__( 'Select logo', 'epicjungle' ),
                    'change'       => esc_html__( 'Change logo', 'epicjungle' ),
                    'remove'       => esc_html__( 'Remove', 'epicjungle' ),
                    'default'      => esc_html__( 'Default', 'epicjungle' ),
                    'placeholder'  => esc_html__( 'No logo selected', 'epicjungle' ),
                    'frame_title'  => esc_html__( 'Select logo', 'epicjungle' ),
                    'frame_button' => esc_html__( 'Choose logo', 'epicjungle' ),
                ],
            ] ) );
            $wp_customize->selective_refresh->add_partial( 'mobile_logo', [
                'selector'            => '.mobile-logo-link',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_mobile_logo',
            ] );




            $wp_customize->add_setting( 'transparent_header_logo', [
                'transport'      => 'postMessage',
                'theme_supports' => 'custom-logo',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'transparent_header_logo', [
                'section'       => 'title_tagline',
                'label'         => esc_html__( 'Transparent Header Logo', 'epicjungle' ),
                'description'   => esc_html__( 'Upload logo for transparent header', 'epicjungle' ),
                'priority'      => 9,
                'width'         => 60,
                'height'        => 60,
                'flex_width'    => true,
                'flex_height'   => true,
                'button_labels' => [
                    'select'       => esc_html__( 'Select logo', 'epicjungle' ),
                    'change'       => esc_html__( 'Change logo', 'epicjungle' ),
                    'remove'       => esc_html__( 'Remove', 'epicjungle' ),
                    'default'      => esc_html__( 'Default', 'epicjungle' ),
                    'placeholder'  => esc_html__( 'No logo selected', 'epicjungle' ),
                    'frame_title'  => esc_html__( 'Select logo', 'epicjungle' ),
                    'frame_button' => esc_html__( 'Choose logo', 'epicjungle' ),
                ],
            ] ) );
            $wp_customize->selective_refresh->add_partial( 'transparent_header_logo', [
                'selector'            => '.sticky-logo-link',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_sticky_header_logo',
            ] );





            $wp_customize->add_setting( 'sticky_logo', [
                'transport'      => 'postMessage',
                'theme_supports' => 'custom-logo',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'sticky_logo', [
                'section'       => 'title_tagline',
                'label'         => esc_html__( 'Upload Scroll Logo', 'epicjungle' ),
                'description'   => esc_html__( 'Scroll Logo is the Logo that you want to appear when the user scrolls down and the header sticks in transparent header.', 'epicjungle' ),
                'priority'      => 9,
                'width'         => 60,
                'height'        => 60,
                'flex_width'    => true,
                'flex_height'   => true,
                'button_labels' => [
                    'select'       => esc_html__( 'Select logo', 'epicjungle' ),
                    'change'       => esc_html__( 'Change logo', 'epicjungle' ),
                    'remove'       => esc_html__( 'Remove', 'epicjungle' ),
                    'default'      => esc_html__( 'Default', 'epicjungle' ),
                    'placeholder'  => esc_html__( 'No logo selected', 'epicjungle' ),
                    'frame_title'  => esc_html__( 'Select logo', 'epicjungle' ),
                    'frame_button' => esc_html__( 'Choose logo', 'epicjungle' ),
                ],
            ] ) );
            $wp_customize->selective_refresh->add_partial( 'sticky_logo', [
                'selector'            => '.sticky-logo-link',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_sticky_header_logo',
            ] );





            //</editor-fold>

            //<editor-fold desc="footer_logo">
            $wp_customize->add_setting( 'footer_logo', [
                'transport'      => 'postMessage',
                'theme_supports' => 'custom-logo',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'footer_logo', [
                'section'       => 'title_tagline',
                /* translators: label field for setting in Customizer */
                'label'         => esc_html__( 'Footer Logo', 'epicjungle' ),
                /* translators: description field for setting in Customizer */
                'description'   => esc_html__( 'Footer logo inherits the same behavior for retina displays as desktop logo.', 'epicjungle' ),
                'priority'      => 9,
                'width'         => 153,
                'height'        => 55,
                'flex_width'    => true,
                'flex_height'   => true,
                'button_labels' => [
                    'select'       => esc_html__( 'Select logo', 'epicjungle' ),
                    'change'       => esc_html__( 'Change logo', 'epicjungle' ),
                    'remove'       => esc_html__( 'Remove', 'epicjungle' ),
                    'default'      => esc_html__( 'Default', 'epicjungle' ),
                    'placeholder'  => esc_html__( 'No logo selected', 'epicjungle' ),
                    'frame_title'  => esc_html__( 'Select logo', 'epicjungle' ),
                    'frame_button' => esc_html__( 'Choose logo', 'epicjungle' ),
                ],
            ] ) );
            $wp_customize->selective_refresh->add_partial( 'footer_logo', [
                'selector'            => '.footer-logo-link',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_footer_logo',
            ] );
        }


        /**
         * Customize site header
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_header( $wp_customize ) {
            $wp_customize->add_section( 'epicjungle_header', [
                'title'       => esc_html__( 'Header', 'epicjungle' ),
                'description' => esc_html__( 'Customize the theme header.', 'epicjungle' ),
                'priority'    => 90,
            ] );

            $this->add_header_section( $wp_customize );
         
        }

        private function add_header_section( $wp_customize ) {
            
            $wp_customize->add_setting( 'navbar_variant', [
                'default'           => 'solid',
                'sanitize_callback' => 'sanitize_key',
                'transport'         => 'refresh',

            ] );
            $wp_customize->add_control( 'navbar_variant', [
                'type'        => 'select',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Navbar Variant', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your header type.', 'epicjungle' ),
                'choices'     => [
                    'solid'      => esc_html__( 'Solid', 'epicjungle' ),
                    'dashboard'  => esc_html__( 'Dashboard', 'epicjungle' ),
                    'shop'       => esc_html__( 'Shop', 'epicjungle' ),
                    'button'     => esc_html__( 'Simple', 'epicjungle' ),
                    'social'     => esc_html__( 'Social', 'epicjungle' ),
                ],
                'transport'    => 'refresh'
            ] );

            $wp_customize->selective_refresh->add_partial( 'navbar_variant', [
                'selector'            => '.cs-header',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_navbar_variant',

            ] );


            $wp_customize->add_setting( 'enable_topbar', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_topbar', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Topbar?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'shop',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_topbar', [
                'selector'            => '.topbar',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_navbar_shop_topbar',
            ] );

            $wp_customize->add_setting( 'topbar_skin', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'topbar_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Topbar Skin', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your topbar skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'shop',
                    ] ) && filter_var( get_theme_mod( 'enable_topbar' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'topbar_skin', [
                'selector'            => '.topbar',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_navbar_shop_topbar',
            ] );

            $wp_customize->add_setting( 'navbar_skin', [
                'default'           => 'light',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'navbar_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Navbar Skin', 'epicjungle' ),
                'choices'     => [
                    'dark'         => esc_html__( 'Dark', 'epicjungle' ),
                    'primary'      => esc_html__( 'Primary', 'epicjungle' ),
                    'secondary'    => esc_html__( 'Gray', 'epicjungle' ),
                    'light'        => esc_html__( 'Light', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'solid', 'shop', 'social'
                    ] ) && 'no' === get_theme_mod( 'enable_transparent', 'no' );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'navbar_skin', [
                'selector'            => '.navbar',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_navbar_skin',
            ] );

            $wp_customize->add_setting( 'enable_boxshadow', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_boxshadow', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Box Shadow?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'shop','solid', 'social'
                    ] ) && 'no' === get_theme_mod( 'enable_transparent', 'no' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_boxshadow', [
                'selector'            => '.navbar',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_navbar_is_boxshadow',
            ] );

            $wp_customize->add_setting( 'enable_button_variant_boxshadow', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_button_variant_boxshadow', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Box Shadow?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'button'
                    ] ) && 'no' === get_theme_mod( 'enable_transparent', 'no' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_button_variant_boxshadow', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'enable_transparent', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_transparent', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Transparent', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'solid','button'
                    ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_transparent', [
                'selector'            => '.navbar',
                'container_inclusive' => true,
            ] );



            $wp_customize->add_setting( 'enable_transparent_logo', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_transparent_logo', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Transparent Logo', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'solid','button'
                    ] ) &&  'yes' === get_theme_mod( 'enable_transparent', 'no' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_transparent_logo', [
                'selector'            => '.navbar',
                'container_inclusive' => true,
            ] );




            $wp_customize->add_setting( 'transparent_text_color', [
                'default'           => 'light',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'transparent_text_color', [
                'type'        => 'select',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Text Color for Transparent Bg', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your topbar skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'solid','button'
                    ] ) && 'yes' === get_theme_mod( 'enable_transparent', 'no' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'transparent_text_color', [
                'selector'            => '.navbar',
                'container_inclusive' => true,
            ] );
     
       
            $wp_customize->add_setting( 'enable_sticky', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_sticky', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Sticky?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_sticky', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'enable_search', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_search', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Search?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'shop','social',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_search', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_account', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_account', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Show My Account?', 'epicjungle' ),
                'description' => esc_html__( 'Enable / disable account in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                     return in_array( get_theme_mod( 'navbar_variant' ), [
                        'shop','dashboard', 'solid'
                    ] ) && epicjungle_is_woocommerce_activated();
                    
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_account', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'enable_cart', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_cart', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Show Shopping Cart?', 'epicjungle' ),
                'description' => esc_html__( 'Enable / disable account in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                     return in_array( get_theme_mod( 'navbar_variant' ), [
                        'shop',
                    ] ) && epicjungle_is_woocommerce_activated();
                    
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_cart', [
                'fallback_refresh'    => true
            ] );





            $wp_customize->add_setting( 'enable_action_button', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_action_button', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Buy Now Button', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide Buy Now button', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                     return in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] );
                    
                }
                

            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_action_button', [
                'fallback_refresh'    => true
            ] );




            $wp_customize->add_setting( 'enable_header_social_menu', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_header_social_menu', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Social Menu', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide social menu links', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                     return in_array( get_theme_mod( 'navbar_variant' ), [
                        'social',
                    ] );
                    
                }
                

            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_header_social_menu', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'button_url', [
                'default'           => '#',
                'sanitize_callback' => 'esc_url_raw',
            ] );

            $wp_customize->add_control( 'button_url', [
                'type'            => 'url',
                'section'         => 'epicjungle_header',
                'label'           => esc_html__( 'Button Link', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change the button link', 'epicjungle' ),
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] ) && 'no' === get_theme_mod( 'enable_modal', 'no' ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'button_url', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'button_text', [
                'default'           => esc_html__( 'Buy Template', 'epicjungle' ),
                'sanitize_callback' => 'wp_kses_post',
                'transport'         => 'postMessage',
            ] );

            $wp_customize->add_control( 'button_text', [
                'type'            => 'text',
                'section'         => 'epicjungle_header',
                'label'           => esc_html__( 'Button Text', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change the button text', 'epicjungle' ),
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] );
                }

            ] );

            $wp_customize->selective_refresh->add_partial( 'button_text', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'button_css', [
                'default'           => '',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'button_css', [
                'type'            => 'text',
                'section'         => 'epicjungle_header',
                'label'           => esc_html__( 'Button CSS Class', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to add  button css', 'epicjungle' ),
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] );
                }

            ] );
            $wp_customize->selective_refresh->add_partial( 'button_css', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'enable_button_icon', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_button_icon', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Button Icon', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide button icon in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_button_icon', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'button_icon', [
                'default'           => esc_html__( 'fe-shopping-cart', 'epicjungle' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'button_icon', [
                'type'        => 'text',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enter Button Icon', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to enter the button icon.', 'epicjungle' ),
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] ) && 'yes' === get_theme_mod( 'enable_button_icon', 'yes' ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'button_icon', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'button_color', [
                'default'           => 'primary',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'button_color', [
                'type'        => 'select',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Button Primary Color', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your button color', 'epicjungle' ),
                'choices'     => [
                    'primary'  => esc_html__( 'Default', 'epicjungle' ),
                    'custom'   => esc_html__( 'Custom', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] );
                }

            ] );
            $wp_customize->selective_refresh->add_partial( 'button_color', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting(
                'epicjungle_header_button_background', array(
                    'default'           => apply_filters( 'epicjungle_default_button_color', '#fe696a' ),
                    'sanitize_callback' => 'sanitize_hex_color',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'epicjungle_header_button_background', array(
                        'label'    => __( 'Button Background', 'epicjungle' ),
                        'section'  => 'epicjungle_header',
                        'settings' => 'epicjungle_header_button_background',
                        'active_callback' => function () {
                            return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN )
                            && in_array( get_theme_mod( 'navbar_variant' ), [
                                'button',
                            ] ) && get_theme_mod( 'button_color', 'custom' ) === 'custom';
                        }
                    )
                )
            );


            $wp_customize->add_setting( 'enable_modal', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_modal', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Modal', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide modal in button.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_modal', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'modal_title', [
                'default'           => 'What project are you looking for?', 
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'modal_title', [
                'type'        => 'text',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enter Modal Title', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to enter the data toggle modal title.', 'epicjungle' ),
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                        'button',
                    ] )  && filter_var( get_theme_mod( 'enable_modal' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'modal_title', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting(
                'navbar_modal_content', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );

            $wp_customize->add_control(
                'navbar_modal_content', array (
                    'section'     => 'epicjungle_header',
                    'label'       => esc_html__( 'Modal Static Content', 'epicjungle' ),
                    'description' => esc_html__( 'Choose a static content that will be displayed as modal content.','epicjungle' ),
                    'type'        => 'select',
                    'choices'     => $this->static_contents,
                    'active_callback' => function () {
                        return filter_var( get_theme_mod( 'enable_action_button' ), FILTER_VALIDATE_BOOLEAN ) && in_array( get_theme_mod( 'navbar_variant' ), [
                            'button'
                        ] ) && filter_var( get_theme_mod( 'enable_modal' ), FILTER_VALIDATE_BOOLEAN );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'navbar_modal_content', [
                'fallback_refresh'    => true
            ] );




        }

        /**
         * Customize site footer
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_footer( $wp_customize ) {
            $wp_customize->add_section( 'epicjungle_footer', [
                'title'       => esc_html__( 'Footer', 'epicjungle' ),
                'description' => esc_html__( 'Customize the theme footer.', 'epicjungle' ),
                'priority'    => 90,
            ] );

            $this->add_footer_section( $wp_customize );
         
        }

        private function add_footer_section( $wp_customize ) {
            $this->static_contents = epicjungle_static_content_options();

            $wp_customize->add_setting( 'footer_variant', [
                'default'           => 'simple',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'footer_variant', [
                'type'        => 'select',
                'section'     => 'epicjungle_footer',
                'label'       => esc_html__( 'Footer Variant', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your footer type.', 'epicjungle' ),
                'choices'     => [
                    'default'      => esc_html__( 'Default', 'epicjungle' ),
                    'simple'       => esc_html__( 'Footer Simple', 'epicjungle' ),
                //    'simple-2'     => esc_html__( 'Footer Social Icons', 'epicjungle' ),
                    'shop'         => esc_html__( 'Footer Shop', 'epicjungle' ),
                    'blog'         => esc_html__( 'Footer Blog', 'epicjungle' ),
                //    'v6'           => esc_html__( 'Footer v6', 'epicjungle' ),
                //    'v7'           => esc_html__( 'Footer v7', 'epicjungle' ),
                //    'v8'           => esc_html__( 'Footer v8', 'epicjungle' ),
                //    'v9'           => esc_html__( 'Footer v9', 'epicjungle' ),
                //    'v10'          => esc_html__( 'Footer v10', 'epicjungle' ),

                ],
            ] );
            $wp_customize->selective_refresh->add_partial( 'footer_variant', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'footer_skin', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'footer_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_footer',
                'label'       => esc_html__( 'Footer Simple Skin', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your footer simple skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_variant' ), [
                        'default','simple','v7', 'v8', 'v9'
                    ] ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'footer_skin', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'contact_title', [
                'default'           => esc_html__( 'Contacts', 'epicjungle' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'contact_title', [
                'type'            => 'text',
                'section'         => 'epicjungle_footer',
                'label'           => esc_html__( 'Contact Title', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change "Contacts" word to something else in contact title.', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_variant' ), [
                        'v7',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'contact_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'epicjungle_copyright', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );
            $wp_customize->add_control( 'epicjungle_copyright', [
                'type'        => 'textarea',
                'section'     => 'epicjungle_footer',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Copyright', 'epicjungle' ),
                /* translators: description field for "Copyright" setting in Customizer */
                'description' => esc_html__( 'HTML is allowed in this field.', 'epicjungle' ),
            ] );

            $wp_customize->selective_refresh->add_partial( 'epicjungle_copyright', [
                'selector'        => '.epicjungle-copyright',
                'render_callback' => 'epicjungle_footer_copyright',
            ] );
           


            $wp_customize->add_setting(
                'footer_jumbotron', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );

            $wp_customize->add_control(
                'footer_jumbotron', array (
                    'section'     => 'epicjungle_footer',
                    'label'       => esc_html__( 'Footer Static Content', 'epicjungle' ),
                    'description' => esc_html__( 'Choose a static content that will be displayed in the footer area.','epicjungle' ),
                    'type'        => 'select',
                    'choices'     => $this->static_contents,
                    'active_callback' => function () {
                        return in_array( get_theme_mod( 'footer_variant' ), [
                            'shop','v8'
                        ] );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'footer_jumbotron', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'footer_payment_methods', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'absint',
            ] );

            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'footer_payment_methods', [
                'section'     => 'epicjungle_footer',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Payment Methods', 'epicjungle' ),
                /* translators: description field for "Payment Methods" setting in Customizer */
                'description' => esc_html__(
                    'This setting allows you to upload an image with available payment methods or anything you want.
                    This image as well as site logos is optimized for retina displays, so the original image size should
                    be twice as big as the final image that appears on the website.',
                    'epicjungle'
                ),
                'mime_type'   => 'image',
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_variant' ), [ 'shop' ] );
                }
            ] ) );

            $wp_customize->selective_refresh->add_partial( 'footer_payment_methods', [
                'selector'            => '.payment-methods',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_get_footer_pm',
            ] );


            $wp_customize->add_setting( 'enable_newsletter_form', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_newsletter_form', [
                'type'        => 'radio',
                'section'     => 'epicjungle_footer',
                'label'       => esc_html__( 'Enable Newsletter Form', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide newsletter form in Footer.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_variant' ), [
                        'blog',
                    ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_newsletter_form', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'epicjungle_newsletter_title', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'epicjungle_newsletter_title', [
                'type'            => 'text',
                'section'         => 'epicjungle_footer',
                'label'           => esc_html__( 'Newsletter Title', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change newsletter title', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_variant' ), [
                        'blog',
                    ] ) && get_theme_mod( 'enable_newsletter_form', 'no' ) === 'yes';
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'epicjungle_newsletter_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'epicjungle_newsletter_desc', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'epicjungle_newsletter_desc', [
                'type'            => 'textarea',
                'section'         => 'epicjungle_footer',
                'label'           => esc_html__( 'Newsletter Description', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change newsletter description', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_variant' ), [
                        'blog',
                    ] ) && get_theme_mod( 'enable_newsletter_form', 'no' ) === 'yes';
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'epicjungle_newsletter_desc', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'epicjungle_newsletter_form', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'epicjungle_newsletter_form', [
                'type'            => 'textarea',
                'section'         => 'epicjungle_footer',
                'label'           => esc_html__( 'Newsletter Form', 'epicjungle' ),
                'description'     => esc_html__( 'Paste your newsletter signup form or shortcode', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_variant' ), [
                        'blog',
                    ] ) && get_theme_mod( 'enable_newsletter_form', 'no' ) === 'yes';
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'epicjungle_newsletter_form', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'epicjungle_custom_html', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );
            $wp_customize->add_control( 'epicjungle_custom_html', [
                'type'        => 'textarea',
                'section'     => 'epicjungle_footer',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Download Our App Html', 'epicjungle' ),
                /* translators: description field for "Copyright" setting in Customizer */
                'description' => esc_html__( 'HTML is allowed in this field.', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_variant' ), [
                        'blog',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'epicjungle_custom_html', [
                'fallback_refresh'    => true
            ] );



        }

        /**
         * Customize site blog
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_blog( $wp_customize ) {
            $wp_customize->add_section( 'epicjungle_blog', [
                /* translators: title of section in Customizer */
                'title'       => esc_html__( 'Blog', 'epicjungle' ),
                'description' => esc_html__( 'This section contains settings related to posts listing archives and single post.', 'epicjungle' ),
                'priority'    => 50,
            ] );

            $this->add_blog_section( $wp_customize );
        }

        private function add_blog_section( $wp_customize ) {
            $wp_customize->add_setting( 'blog_layout', [
                'default'           => 'grid',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_layout', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                /* translators: label field of control in Customizer */
                'label'       => esc_html__( 'Blog Layout', 'epicjungle' ),
                'description' => esc_html__( 'This setting affects both the posts listing (your blog page) and archives.', 'epicjungle' ),
                'choices'     => [
                    /* translators: single item in a list of Blog Layout choices (in Customizer) */
                    'grid'            => esc_html__( 'Grid', 'epicjungle' ),
                    /* translators: single item in a list of Blog Layout choices (in Customizer) */
                    'list'            => esc_html__( 'List', 'epicjungle' ),
                ],
            ] );


            $wp_customize->add_setting( 'list_view_style', [
                'default'           => 'style-v1',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'list_view_style', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                /* translators: label field of control in Customizer */
                'label'       => esc_html__( 'List View Style', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your list view', 'epicjungle' ),
                'choices'     => [
                    'style-v1'  => esc_html__( 'Style v1', 'epicjungle' ),
                    'style-v2'  => esc_html__( 'Style v2', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_layout' ), [
                        'list',
                    ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'list_view_style', [
                'fallback_refresh'    => true
            ] );


            
            $wp_customize->add_setting( 'blog_sidebar', [
                'default'           => 'left-sidebar',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_sidebar', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                /* translators: label field of control in Customizer */
                'label'       => esc_html__( 'Blog Sidebar', 'epicjungle' ),
                'description' => esc_html__( 'This setting affects both the posts listing (your blog page) and archives. This works when blog sidebar has widgets', 'epicjungle' ),
                'choices'     => [
                    'left-sidebar'  => esc_html__( 'Left Sidebar', 'epicjungle' ),
                    'right-sidebar' => esc_html__( 'Right Sidebar', 'epicjungle' ),
                    'no-sidebar'    => esc_html__( 'No Sidebar', 'epicjungle' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_sidebar', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_related_posts', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_related_posts', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Blog Related Posts', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to enable related posts', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );






            $wp_customize->add_setting( 'enable_separate_header_for_blog', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_separate_header_for_blog', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Separate Header for single post Page', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide button icon in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_separate_header_for_blog', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'blog_navbar_variant', [
                'default'           => 'solid',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_navbar_variant', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Blog Navbar Variant', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your header type.', 'epicjungle' ),
                'choices'     => [
                    'solid'      => esc_html__( 'Solid', 'epicjungle' ),
                    'dashboard'  => esc_html__( 'Dashboard', 'epicjungle' ),
                    'shop'       => esc_html__( 'Shop', 'epicjungle' ),
                    'button'     => esc_html__( 'Simple', 'epicjungle' ),
                    'social'     => esc_html__( 'Social', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }

            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_navbar_variant', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_enable_topbar', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_enable_topbar', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Topbar?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'shop',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'blog_enable_topbar', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_topbar_skin', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_topbar_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Topbar Skin', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your topbar skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return ( 'yes' === get_theme_mod( 'enable_topbar', 'yes' ) ) && in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'shop',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_topbar_skin', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_navbar_skin', [
                'default'           => 'light',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_navbar_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Navbar Skin', 'epicjungle' ),
                'choices'     => [
                    'dark'         => esc_html__( 'Dark', 'epicjungle' ),
                    'primary'      => esc_html__( 'Primary', 'epicjungle' ),
                    'secondary'    => esc_html__( 'Gray', 'epicjungle' ),
                    'light'        => esc_html__( 'Light', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'solid', 'shop', 'social'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ) && 'no' === get_theme_mod( 'blog_enable_transparent', 'no' );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'blog_navbar_skin', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_enable_boxshadow', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_enable_boxshadow', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Box Shadow?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'shop','solid', 'social'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ) && 'no' === get_theme_mod( 'blog_enable_transparent', 'no' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_boxshadow', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_enable_button_variant_boxshadow', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_enable_button_variant_boxshadow', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Box Shadow?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'button'
                    ] ) && 'no' === get_theme_mod( 'enable_transparent', 'no' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_button_variant_boxshadow', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'blog_enable_transparent', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_enable_transparent', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Transparent', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'solid','button'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_transparent', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_enable_transparent_logo', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_enable_transparent_logo', [
                'type'        => 'radio',
                'section'     => 'epicjungle_header',
                'label'       => esc_html__( 'Enable Transparent Logo', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'navbar_variant' ), [
                        'solid','button'
                    ] ) &&  'yes' === get_theme_mod( 'blog_enable_transparent', 'no' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_transparent_logo', [
                'selector'            => '.navbar',
                'container_inclusive' => true,
            ] );




            $wp_customize->add_setting( 'blog_transparent_text_color', [
                'default'           => 'light',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_transparent_text_color', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Text Color for Transparent Bg', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your topbar skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return ( 'yes' === get_theme_mod( 'blog_enable_transparent', 'no' ) ) && in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'solid','button'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_transparent_text_color', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_enable_sticky', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_enable_sticky', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Sticky?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'blog_enable_sticky', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_enable_search', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_enable_search', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Search?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'shop','social',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ); 
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'blog_enable_search', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_enable_account', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_enable_account', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Show My Account?', 'epicjungle' ),
                'description' => esc_html__( 'Enable / disable account in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'shop','dashboard', 'solid'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ); 

                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_account', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_enable_cart', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_enable_cart', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Show Shopping Cart?', 'epicjungle' ),
                'description' => esc_html__( 'Enable / disable account in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'shop',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ); 

                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_cart', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_enable_action_button', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_enable_action_button', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Buy Now Button', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide Buy Now button', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'button',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ); 

                }

            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_action_button', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_enable_header_social_menu', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_enable_header_social_menu', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Social Menu', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide social menu links', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_navbar_variant' ), [
                        'social',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_blog' ), FILTER_VALIDATE_BOOLEAN ); 

                }


            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_header_social_menu', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'enable_separate_footer_for_blog', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_separate_footer_for_blog', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Separate Footer for Single Post Page', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide button icon in footer.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_separate_footer_for_blog', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'blog_footer_variant', [
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_footer_variant', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Blog Footer Variant', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your footer type.', 'epicjungle' ),
                'choices'     => [
                    'default'      => esc_html__( 'Default', 'epicjungle' ),
                    'simple'       => esc_html__( 'Footer Simple', 'epicjungle' ),
                    'simple-2'     => esc_html__( 'Footer with Social Icons', 'epicjungle' ),
                    'shop'         => esc_html__( 'Footer Shop', 'epicjungle' ),
                    'blog'         => esc_html__( 'Footer Blog', 'epicjungle' ),
                    'v6'           => esc_html__( 'Footer v6', 'epicjungle' ),
                    'v7'           => esc_html__( 'Footer v7', 'epicjungle' ),
                    'v8'           => esc_html__( 'Footer v8', 'epicjungle' ),
                    'v9'           => esc_html__( 'Footer v9', 'epicjungle' ),
                    'v10'          => esc_html__( 'Footer v10', 'epicjungle' ),

                ],
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'blog_footer_variant', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_footer_skin', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_footer_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Footer Simple Skin', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your footer simple skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_footer_variant' ), [
                        'default','simple','v7', 'v8'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_footer_skin', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_contact_title', [
                'default'           => esc_html__( 'Contacts', 'epicjungle' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'blog_contact_title', [
                'type'            => 'text',
                'section'         => 'epicjungle_blog',
                'label'           => esc_html__( 'Contact Title', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change "Contacts" word to something else in contact title.', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_footer_variant' ), [
                        'v7',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'blog_contact_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_epicjungle_copyright', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );
            $wp_customize->add_control( 'blog_epicjungle_copyright', [
                'type'        => 'textarea',
                'section'     => 'epicjungle_blog',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Blog Page Copyright', 'epicjungle' ),
                /* translators: description field for "Copyright" setting in Customizer */
                'description' => esc_html__( 'HTML is allowed in this field.', 'epicjungle' ),
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_epicjungle_copyright', [
                'selector'        => '.epicjungle-copyright',
                'render_callback' => 'epicjungle_footer_copyright',
            ] );

            $wp_customize->add_setting(
                'blog_footer_widgets', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );

            $wp_customize->add_control(
                'blog_footer_widgets', array (
                    'section'     => 'epicjungle_blog',
                    'label'       => esc_html__( 'Blog Footer Static Widgets', 'epicjungle' ),
                    'description' => esc_html__( 'Choose a static content that will be displayed in the footer widget area.','epicjungle' ),
                    'type'        => 'select',
                    'choices'     => $this->static_contents,
                    'active_callback' => function () {
                        return in_array( get_theme_mod( 'blog_footer_variant' ), [
                            'default', 'shop','v6', 'v7', 'blog'
                        ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'blog_footer_widgets', [
                'fallback_refresh'    => true
            ] );





            $wp_customize->add_setting(
                'blog_footer_jumbotron', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );

            $wp_customize->add_control(
                'blog_footer_jumbotron', array (
                    'section'     => 'epicjungle_blog',
                    'label'       => esc_html__( 'Blog Footer Static Content', 'epicjungle' ),
                    'description' => esc_html__( 'Choose a static content that will be displayed in the footer area.','epicjungle' ),
                    'type'        => 'select',
                    'choices'     => $this->static_contents,
                    'active_callback' => function () {
                        return in_array( get_theme_mod( 'blog_footer_variant' ), [
                            'shop','v8'
                        ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'blog_footer_jumbotron', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_footer_payment_methods', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'absint',
            ] );

            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'blog_footer_payment_methods', [
                'section'     => 'epicjungle_blog',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Blog Payment Methods', 'epicjungle' ),
                /* translators: description field for "Payment Methods" setting in Customizer */
                'description' => esc_html__(
                    'This setting allows you to upload an image with available payment methods or anything you want.
                    This image as well as site logos is optimized for retina displays, so the original image size should
                    be twice as big as the final image that appears on the website.',
                    'epicjungle'
                ),
                'mime_type'   => 'image',
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_footer_variant' ), [ 'shop' ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] ) );

            $wp_customize->selective_refresh->add_partial( 'blog_footer_payment_methods', [
                'selector'            => '.payment-methods',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_get_footer_pm',
            ] );


            $wp_customize->add_setting( 'blog_enable_newsletter_form', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_enable_newsletter_form', [
                'type'        => 'radio',
                'section'     => 'epicjungle_blog',
                'label'       => esc_html__( 'Enable Newsletter Form', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide newsletter form in Footer.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_footer_variant' ), [
                        'blog'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_enable_newsletter_form', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_epicjungle_newsletter_title', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'blog_epicjungle_newsletter_title', [
                'type'            => 'text',
                'section'         => 'epicjungle_blog',
                'label'           => esc_html__( 'Newsletter Title', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change newsletter title', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_footer_variant' ), [
                        'blog'
                    ] ) && get_theme_mod( 'blog_enable_newsletter_form', 'no' ) === 'yes' && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_epicjungle_newsletter_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_epicjungle_newsletter_desc', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'blog_epicjungle_newsletter_desc', [
                'type'            => 'textarea',
                'section'         => 'epicjungle_blog',
                'label'           => esc_html__( 'Newsletter Description', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change newsletter description', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_footer_variant' ), [
                        'blog'
                    ] ) && get_theme_mod( 'blog_enable_newsletter_form', 'no' ) === 'yes' && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_epicjungle_newsletter_desc', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'blog_epicjungle_newsletter_form', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'blog_epicjungle_newsletter_form', [
                'type'            => 'textarea',
                'section'         => 'epicjungle_blog',
                'label'           => esc_html__( 'Newsletter Form', 'epicjungle' ),
                'description'     => esc_html__( 'Paste your newsletter signup form or shortcode', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_footer_variant' ), [
                        'blog'
                    ] ) && get_theme_mod( 'blog_enable_newsletter_form', 'no' ) === 'yes' && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'blog_epicjungle_newsletter_form', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'blog_epicjungle_custom_html', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );
            $wp_customize->add_control( 'blog_epicjungle_custom_html', [
                'type'        => 'textarea',
                'section'     => 'epicjungle_blog',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Download Our App Html', 'epicjungle' ),
                /* translators: description field for "Copyright" setting in Customizer */
                'description' => esc_html__( 'HTML is allowed in this field.', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'blog_footer_variant' ), [
                        'blog'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_blog' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'blog_epicjungle_custom_html', [
                'fallback_refresh'    => true
            ] );

            
        }


        /**
         * Customize site 404
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_404( $wp_customize ) {
            $wp_customize->add_section( 'epicjungle_404', [
                'title'    => '404',
                'priority' => 31,
            ] );

            $this->add_404_section( $wp_customize );
        }

        private function add_404_section( $wp_customize ) {

            $wp_customize->add_setting( '404_image_option', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, '404_image_option', [
                'section'     => 'epicjungle_404',
                'label'       => esc_html__( '404 Image Upload', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to upload an image for 404 page.', 'epicjungle' ),
                'mime_type'   => 'image',
            ] ) );
            $wp_customize->selective_refresh->add_partial( '404_image_option', [
                'fallback_refresh' => true
            ] );


            $wp_customize->add_setting( '404_title', [
                'default'           => esc_html_x( '404', 'front-end', 'epicjungle' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_title', [
                'type'            => 'text',
                'section'         => 'epicjungle_404',
                'label'           => esc_html__( '404 Title', 'epicjungle' ),
            ] );
            $wp_customize->selective_refresh->add_partial( '404_title', [
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_title' ) );
                },
            ] );
            

        
            $wp_customize->add_setting( '404_subtitle', [
                'default'           => esc_html_x( 'It seems we can’t find the page you are looking for.', 'front-end', 'epicjungle' ),
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_subtitle', [
                'type'            => 'textarea',
                'section'         => 'epicjungle_404',
                'label'           => esc_html__( 'Subtitle', 'epicjungle' ),
            ] );
            $wp_customize->selective_refresh->add_partial( '404_subtitle', [
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_subtitle' ) );
                },
            ] );

            $wp_customize->add_setting( '404_subtitle_2', [
                'default'           => esc_html_x( 'Or try', 'front-end', 'epicjungle' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_subtitle_2', [
                'type'            => 'text',
                'section'         => 'epicjungle_404',
                'label'           => esc_html__( 'Subtitle 2', 'epicjungle' ),
                
            ] );
            $wp_customize->selective_refresh->add_partial( '404_subtitle_2', [
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_subtitle_2' ) );
                },
            ] );

            $wp_customize->add_setting( '404_button_text', [
                'default'           => esc_html__( 'Go to homepage', 'epicjungle' ),
                'sanitize_callback' => 'wp_kses_post',
                'transport'         => 'postMessage',
            ] );

            $wp_customize->add_control( '404_button_text', [
                'type'            => 'text',
                'section'         => 'epicjungle_404',
                'label'           => esc_html__( 'Button Text', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change the button text', 'epicjungle' ),
                
            ] );

            $wp_customize->selective_refresh->add_partial( '404_button_text', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( '404_button_color', [
                'default'           => 'translucent-primary',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( '404_button_color', [
                'type'    => 'select',
                'section' => 'epicjungle_404',
                'label'   => esc_html__( '"Back to Home" button color', 'epicjungle' ),
                'choices' => [
                    'translucent-primary'   => esc_html_x( 'Primary', 'button', 'epicjungle' ),
                    'translucent-success'   => esc_html_x( 'Success', 'button', 'epicjungle' ),
                    'translucent-danger'    => esc_html_x( 'Danger', 'button', 'epicjungle' ),
                    'translucent-warning'   => esc_html_x( 'Warning', 'button', 'epicjungle' ),
                    'translucent-info'      => esc_html_x( 'Info', 'button', 'epicjungle' ),
                    'translucent-dark'      => esc_html_x( 'Dark', 'button', 'epicjungle' ),
                    'translucent-gradient'  => esc_html_x( 'Gradient', 'button', 'epicjungle' ),
                    'translucent-link'      => esc_html_x( 'Link', 'button', 'epicjungle' ),
                ],
            ] );


            $wp_customize->add_setting( 'enable_form', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_form', [
                'type'        => 'radio',
                'section'     => 'epicjungle_404',
                'label'       => esc_html__( 'Enable Search Form?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_form', [
                'fallback_refresh'    => true
            ] );

        }


        /**
         * Returns an array of the desired default EpicJungle Options
         *
         * @return array
         */
        public function get_epicjungle_default_setting_values() {
            return apply_filters(
                'epicjungle_setting_default_values', $args = array(
                    'epicjungle_header_button_background' => '#766df4',
                )
            );
        }

        /**
         * Adds a value to each epicjungle setting if one isn't already present.
         *
         * @uses get_epicjungle_default_setting_values()
         */
        public function default_theme_mod_values() {
            foreach ( $this->get_epicjungle_default_setting_values() as $mod => $val ) {
                add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
            }
        }

        /**
         * Get theme mod value.
         *
         * @param string $value Theme modification value.
         * @return string
         */
        public function get_theme_mod_value( $value ) {
            $key = substr( current_filter(), 10 );

            $set_theme_mods = get_theme_mods();

            if ( isset( $set_theme_mods[ $key ] ) ) {
                return $value;
            }

            $values = $this->get_epicjungle_default_setting_values();

            return isset( $values[ $key ] ) ? $values[ $key ] : $value;
        }

        /**
         * Set Customizer setting defaults.
         * These defaults need to be applied separately as child themes can filter epicjungle_setting_default_values
         *
         * @param  array $wp_customize the Customizer object.
         * @uses   get_epicjungle_default_setting_values()
         */
        public function edit_default_customizer_settings( $wp_customize ) {
            foreach ( $this->get_epicjungle_default_setting_values() as $mod => $val ) {
                $wp_customize->get_setting( $mod )->default = $val;
            }
        }


        /**
         * Get all of the epicjungle theme mods.
         *
         * @return array $epicjungle_theme_mods The epicjungle Theme Mods.
         */
        public function get_epicjungle_theme_mods() {
            $epicjungle_theme_mods = array(
                'header_button_background'  => get_theme_mod( 'epicjungle_header_button_background' ),
            );
            

            return apply_filters( 'epicjungle_theme_mods', $epicjungle_theme_mods );
        }

        /**
         * Get Customizer css.
         *
         * @see get_epicjungle_theme_mods()
         * @return array $styles the css
         */
        public function get_css() {
            $epicjungle_theme_mods = $this->get_epicjungle_theme_mods();
            $button_color = $epicjungle_theme_mods['header_button_background'];
            $button_color_yiq = epicjungle_sass_yiq( $button_color );
            $button_color_darken_10p = epicjungle_adjust_color_brightness( $button_color, -10 );

            $styles = '
            .btn-primary {
                background-color: ' . $button_color  .';
                border-color: ' . $button_color  .';
                color: ' . $button_color_yiq .';
            }

            .btn-primary:hover,
            .btn-primary:focus {
                 background-color: ' . $button_color_darken_10p . ';
                 border-color: ' . $button_color_darken_10p  .';
                 color: ' . $button_color_yiq .';
            }';
           
            return apply_filters( 'epicjungle_customizer_css', $styles );
        }
  
        /**
         * Add CSS in <head> for styles handled by the theme customizer
         *
         * @since 1.0.0
         * @return void
         */
        public function add_customizer_css() {
            if ( get_theme_mod( 'button_color' ) === 'custom' ) {
                wp_add_inline_style( 'epicjungle-style', $this->get_css() );
            }
        }

        /**
         * Customize site Custom Theme Color
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_customcolor( $wp_customize ) {
            
            /*
             * Custom Color Enable / Disable Toggle
             */
            $wp_customize->add_setting( 'epicjungle_enable_custom_color', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'epicjungle_enable_custom_color', [
                'type'        => 'radio',
                'section'     => 'colors',
                'label'       => esc_html__( 'Enable Custom Color?', 'epicjungle' ),
                'description' => esc_html__(
                    'This settings allow you to apply your custom color option.',
                    'epicjungle'
                ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );

            /**
             * Primary Color
             */
            $wp_customize->add_setting(
                'epicjungle_primary_color', array(
                    'default'           => apply_filters( 'epicjungle_default_primary_color', '#058c42' ),
                    'sanitize_callback' => 'sanitize_hex_color',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'epicjungle_primary_color', array(
                        'label'    => esc_html__( 'Primary color', 'epicjungle' ),
                        'section'  => 'colors',
                        'settings' => 'epicjungle_primary_color',
                        'active_callback' => function () {
                            return get_theme_mod( 'epicjungle_enable_custom_color', 'no' ) === 'yes';
                        }
                    )
                )
            );

        }
    }
endif;

return new EpicJungle_Customizer();