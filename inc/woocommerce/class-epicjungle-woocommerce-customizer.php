<?php
/**
 * EpicJungle WooCommerce Customizer Class
 *
 * @package  epicjungle
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle_WooCommerce_Customizer' ) ) :

    /**
     * The epicjungle Customizer class
     */
    class EpicJungle_WooCommerce_Customizer extends EpicJungle_Customizer {

        /**
         * Setup class.
         *
         * @since 1.0.0
         * @return void
         */
        public function __construct() {
            add_action( 'customize_register', array( $this, 'customize_myaccount_settings' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_shop_settings' ), 10 );

        }


        /**
         * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since 1.0.0
         */
        public function customize_myaccount_settings( $wp_customize ) {

            /**
             * Shop page
             */

            global $epicjungle;

            $wp_customize->add_setting( 'account_enable_separate_header', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'account_enable_separate_header', [
                'type'        => 'radio',
                'section'     => 'epicjungle_myaccount',
                'label'       => esc_html__( 'Enable Dashboard Header for User Login', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide dashboard Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'account_enable_separate_header', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'account_enable_separate_footer', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'account_enable_separate_footer', [
                'type'        => 'radio',
                'section'     => 'epicjungle_myaccount',
                'label'       => esc_html__( 'Enable Footer v10 for User Login', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide dashboard Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'account_enable_separate_footer', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_section(
                'epicjungle_myaccount', array(
                    'title'       => esc_html__( 'My Account', 'epicjungle' ),
                    'description' => esc_html__( 'This section contains settings related to my account.', 'epicjungle' ),
                    'priority'    => 30,
                    'panel'       => 'woocommerce',
                )
            );


            $wp_customize->add_setting( 'myaccount_style', array(
                    'default'           => 'style-v3',
                    'sanitize_callback' => 'sanitize_key',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control( 'myaccount_style', array(
                    'type'        => 'select',
                    'section'     => 'epicjungle_myaccount',
                    'label'       => esc_html__( 'My Account Page Style', 'epicjungle' ),
                    'description' => esc_html__( 'Select the style for My Account page', 'epicjungle' ),
                    'choices'     => [
                        'style-v1'            => esc_html__( 'Sign In - Sign Up', 'epicjungle' ),
                        'style-v2'            => esc_html__( 'Sign In - Illustration', 'epicjungle' ),
                        'style-v3'            => esc_html__( 'Sign In - Image', 'epicjungle' ),
                        
                    ],
                )
            );

            $wp_customize->selective_refresh->add_partial( 'myaccount_style', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'myaccount_image', [
                'default'           => 0,
                'sanitize_callback' => 'absint',
            ] );

            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'myaccount_image', [
                'label'       => esc_html__( 'Upload an image', 'epicjungle' ),
                'description' => esc_html__( 'If you have a cool picture that you want to display on the 404 page you can upload it here.', 'epicjungle' ),
                'section'     => 'epicjungle_myaccount',
                'mime_type'   => 'image',
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'myaccount_style' ), [ 'style-v2', 'style-v3' ] 
                    ); 
                }
            ] ) );

            $wp_customize->selective_refresh->add_partial( 'myaccount_image', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'login_title', [
                'default'           => esc_html__( 'Sign in', 'epicjungle' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( 'login_title', [
                'section'     => 'epicjungle_myaccount',
                'type'        => 'text',
                /* translators: label field of setting responsible for keeping the page title of blog in posts listing (no Static Front Page). */
                'label'       => esc_html__( 'Login Form Title', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set login form title','epicjungle' ),
            ] );
            $wp_customize->selective_refresh->add_partial( 'login_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'login_desc', [
                'default'           => esc_html__( 'Sign in to your account using email and password provided during registration.','epicjungle' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( 'login_desc', [
                'section'     => 'epicjungle_myaccount',
                'type'        => 'textarea',
                /* translators: label field of setting responsible for keeping the page title of blog in posts listing (no Static Front Page). */
                'label'       => esc_html__( 'Login Form Description', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set login form description','epicjungle' ),
            ] );
            $wp_customize->selective_refresh->add_partial( 'login_desc', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'login_heading_alignment', [
                'default'           => 'text-left',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'login_heading_alignment', [
                'type'        => 'select',
                'section'     => 'epicjungle_myaccount',
                'label'       => esc_html__( 'Login Heading Alignment', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set login heading alignment', 'epicjungle' ),
                'choices'     => [
                    'text-left'    => esc_html__( 'Left', 'epicjungle' ),
                    'text-center'  => esc_html__( 'Center', 'epicjungle' ),
                    'text-right'   => esc_html__( 'Right', 'epicjungle' ),
                ],

            ] );

            $wp_customize->selective_refresh->add_partial( 'login_heading_alignment', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'register_title', [
                'default'           => esc_html__( 'Sign up', 'epicjungle' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( 'register_title', [
                'section'     => 'epicjungle_myaccount',
                'type'        => 'text',
                /* translators: label field of setting responsible for keeping the page title of blog in posts listing (no Static Front Page). */
                'label'       => esc_html__( 'Register Form Title', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set register form title','epicjungle' ),
                'active_callback' => function () {
                    get_option( 'woocommerce_enable_myaccount_registration' === 'yes' );
                }
                
            ] );
            $wp_customize->selective_refresh->add_partial( 'register_title', [
                'fallback_refresh'    => true
            ] );




            $wp_customize->add_setting( 'register_desc', [
                'default'           => esc_html__('Registration takes less than a minute but gives you full control over your orders.', 'epicjungle' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( 'register_desc', [
                'section'     => 'epicjungle_myaccount',
                'type'        => 'textarea',
                /* translators: label field of setting responsible for keeping the page title of blog in posts listing (no Static Front Page). */
                'label'       => esc_html__( 'Register Form Description', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set register form description','epicjungle' ),
                'active_callback' => function () {
                    get_option( 'woocommerce_enable_myaccount_registration' === 'yes' );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'register_desc', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'register_heading_alignment', [
                'default'           => 'text-left',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'register_heading_alignment', [
                'type'        => 'select',
                'section'     => 'epicjungle_myaccount',
                'label'       => esc_html__( 'Register Heading Alignment', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set register heading alignment', 'epicjungle' ),
                'choices'     => [
                    'text-left'    => esc_html__( 'Left', 'epicjungle' ),
                    'text-center'  => esc_html__( 'Center', 'epicjungle' ),
                    'text-right'   => esc_html__( 'Right', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    get_option( 'woocommerce_enable_myaccount_registration' === 'yes' );
                }

            ] );

            $wp_customize->selective_refresh->add_partial( 'register_heading_alignment', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'forget_password_title', [
                'default'           => esc_html__( 'Forgot your password?', 'epicjungle' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( 'forget_password_title', [
                'section'     => 'epicjungle_myaccount',
                'type'        => 'text',
                /* translators: label field of setting responsible for keeping the page title of blog in posts listing (no Static Front Page). */
                'label'       => esc_html__( 'Forget Password Title', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set forget password form title','epicjungle' ),

                
            ] );
            $wp_customize->selective_refresh->add_partial( 'forget_password_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'forget_password_desc', [
                'default'           => esc_html__('Change your password in three easy steps. This helps to keep your new password secure.', 'epicjungle' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( 'forget_password_desc', [
                'section'     => 'epicjungle_myaccount',
                'type'        => 'textarea',
                /* translators: label field of setting responsible for keeping the page title of blog in posts listing (no Static Front Page). */
                'label'       => esc_html__( 'Forget Password Form Description', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set forget password form description','epicjungle' ),

            ] );
            $wp_customize->selective_refresh->add_partial( 'forget_password_desc', [
                'fallback_refresh'    => true
            ] );





            $wp_customize->add_setting( 'form_footer_alignment', [
                'default'           => 'text-left',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'form_footer_alignment', [
                'type'        => 'select',
                'section'     => 'epicjungle_myaccount',
                'label'       => esc_html__( 'Form Footer Alignment', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to set form footer alignment', 'epicjungle' ),
                'choices'     => [
                    'text-left'    => esc_html__( 'Left', 'epicjungle' ),
                    'text-center'  => esc_html__( 'Center', 'epicjungle' ),
                    'text-right'   => esc_html__( 'Right', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    get_option( 'woocommerce_enable_myaccount_registration' === 'yes' );
                }

            ] );

            $wp_customize->selective_refresh->add_partial( 'form_footer_alignment', [
                'fallback_refresh'    => true
            ] );


        }

        public function customize_shop_settings( $wp_customize ) {
        $this->static_contents = epicjungle_static_content_options();
        /**
         * Shop page
         */

        global $epicjungle;

            $wp_customize->add_section(
                'epicjungle_shop', array(
                    'title'       => esc_html__( 'Shop Page', 'epicjungle' ),
                    'description' => esc_html__( 'This section contains settings related to products listing and archives.', 'epicjungle' ),
                    'priority'    => 30,
                    'panel'       => 'woocommerce',
                )
            );

            $wp_customize->add_setting(
                'product_archive_layout', array(
                    'default'           => 'left-sidebar',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_key',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'product_archive_layout', array(
                    'type'        => 'select',
                    'section'     => 'epicjungle_shop',
                    /* translators: label field of control in Customizer */
                    'label'       => esc_html__( 'Shop Sidebar', 'epicjungle' ),
                    'description' => esc_html__( 'Select from the three sidebar layouts for shop', 'epicjungle' ),
                    'choices'     => [
                        'left-sidebar'  => esc_html__( 'Left Sidebar', 'epicjungle' ),
                        'right-sidebar' => esc_html__( 'Right Sidebar', 'epicjungle' ),
                        'full-width'    => esc_html__( 'Full Width', 'epicjungle' ),
                    ],
                    'priority'    => 10,
                )
            );

            $wp_customize->selective_refresh->add_partial( 'product_archive_layout', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_separate_header_for_shop', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_separate_header_for_shop', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Separate Header for Shop Page', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide button icon in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_separate_header_for_shop', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'shop_navbar_variant', [
                'default'           => 'shop',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'shop_navbar_variant', [
                'type'        => 'select',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Navbar Variant', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your header type.', 'epicjungle' ),
                'choices'     => [
                    'solid'      => esc_html__( 'Solid', 'epicjungle' ),
                    'dashboard'  => esc_html__( 'Dashboard', 'epicjungle' ),
                    'shop'       => esc_html__( 'Shop', 'epicjungle' ),
                    'button'     => esc_html__( 'Simple', 'epicjungle' ),
                    'social'     => esc_html__( 'Social', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                 }


            ] );
            $wp_customize->selective_refresh->add_partial( 'shop_navbar_variant', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_enable_topbar', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'shop_enable_topbar', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Topbar?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'shop',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'shop_enable_topbar', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_topbar_skin', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_topbar_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Topbar Skin', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your topbar skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return ( 'yes' === get_theme_mod( 'enable_topbar', 'yes' ) ) && in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'shop',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_topbar_skin', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_navbar_skin', [
                'default'           => 'light',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'shop_navbar_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Navbar Skin', 'epicjungle' ),
                'choices'     => [
                    'dark'         => esc_html__( 'Dark', 'epicjungle' ),
                    'primary'      => esc_html__( 'Primary', 'epicjungle' ),
                    'secondary'    => esc_html__( 'Gray', 'epicjungle' ),
                    'light'        => esc_html__( 'Light', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'solid', 'shop', 'social'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ) && 'no' === get_theme_mod( 'shop_enable_transparent', 'no' );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'shop_navbar_skin', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'shop_enable_boxshadow', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_enable_boxshadow', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Box Shadow?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'shop','solid', 'social'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ) && 'no' === get_theme_mod( 'shop_enable_transparent', 'no' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_enable_boxshadow', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'shop_enable_button_variant_boxshadow', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_enable_button_variant_boxshadow', [
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

            $wp_customize->selective_refresh->add_partial( 'shop_enable_button_variant_boxshadow', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_enable_transparent', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_enable_transparent', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Transparent', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'solid','button'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_enable_transparent', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_enable_transparent_logo', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_enable_transparent_logo', [
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

            $wp_customize->selective_refresh->add_partial( 'shop_enable_transparent_logo', [
                'selector'            => '.navbar',
                'container_inclusive' => true,
            ] );

            $wp_customize->add_setting( 'shop_transparent_text_color', [
                'default'           => 'light',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_transparent_text_color', [
                'type'        => 'select',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Text Color for Transparent Bg', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your topbar skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return ( 'yes' === get_theme_mod( 'shop_enable_transparent', 'no' ) ) && in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'solid','button'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_transparent_text_color', [
                'fallback_refresh'    => true
            ] );

            // $wp_customize->add_setting( 'shop_enable_slanted_bg', [
            //     'default'           => 'yes',
            //     'sanitize_callback' => 'sanitize_key',
            // ] );
            // $wp_customize->add_control( 'shop_enable_slanted_bg', [
            //     'type'        => 'radio',
            //     'section'     => 'epicjungle_shop',
            //     'label'       => esc_html__( 'Enable Slanted Background', 'epicjungle' ),
            //     'choices'     => [
            //         'yes' => esc_html__( 'Yes', 'epicjungle' ),
            //         'no'  => esc_html__( 'No', 'epicjungle' ),
            //     ],
            //     'active_callback' => function () {
            //         return in_array( get_theme_mod( 'shop_navbar_variant' ), [
            //             'dashboard'
            //         ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN );
            //     }
            // ] );
            // $wp_customize->selective_refresh->add_partial( 'shop_enable_slanted_bg', [
            //     'fallback_refresh'    => true
            // ] );

            $wp_customize->add_setting( 'shop_enable_sticky', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'shop_enable_sticky', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Sticky?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                 'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'shop_enable_sticky', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_enable_search', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'shop_enable_search', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Search?', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'shop','social',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ); 
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'shop_enable_search', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_enable_account', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_enable_account', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Show My Account?', 'epicjungle' ),
                'description' => esc_html__( 'Enable / disable account in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                     return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'shop','dashboard', 'solid'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ); 
                    
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_enable_account', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_enable_cart', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'shop_enable_cart', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Show Shopping Cart?', 'epicjungle' ),
                'description' => esc_html__( 'Enable / disable account in Header.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                     return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'shop',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ); 
                    
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_enable_cart', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_enable_action_button', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_enable_action_button', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Buy Now Button', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide Buy Now button', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                     return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'button',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ); 
                    
                }
                

            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_enable_action_button', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_enable_header_social_menu', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_enable_header_social_menu', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Social Menu', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide social menu links', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                     return in_array( get_theme_mod( 'shop_navbar_variant' ), [
                        'social',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_header_for_shop' ), FILTER_VALIDATE_BOOLEAN ); 
                    
                }
                

            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_enable_header_social_menu', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'enable_separate_footer_for_shop', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_separate_footer_for_shop', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Separate Footer for Shop Page', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide button icon in footer.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_separate_footer_for_shop', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'shop_footer_variant', [
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'shop_footer_variant', [
                'type'        => 'select',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Shop Footer Variant', 'epicjungle' ),
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
                    return filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                 }
            ] );
            $wp_customize->selective_refresh->add_partial( 'shop_footer_variant', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_footer_skin', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_footer_skin', [
                'type'        => 'select',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Footer Simple Skin', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to choose your footer simple skin.', 'epicjungle' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'epicjungle' ),
                    'dark'  => esc_html__( 'Dark', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_footer_variant' ), [
                        'default','simple','v7', 'v8'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_footer_skin', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'shop_contact_title', [
                'default'           => esc_html__( 'Contacts', 'epicjungle' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'shop_contact_title', [
                'type'            => 'text',
                'section'         => 'epicjungle_shop',
                'label'           => esc_html__( 'Contact Title', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change "Contacts" word to something else in contact title.', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_footer_variant' ), [
                        'v7',
                    ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'shop_contact_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'shop_epicjungle_copyright', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );
            $wp_customize->add_control( 'shop_epicjungle_copyright', [
                'type'        => 'textarea',
                'section'     => 'epicjungle_shop',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Shop Page Copyright', 'epicjungle' ),
                /* translators: description field for "Copyright" setting in Customizer */
                'description' => esc_html__( 'HTML is allowed in this field.', 'epicjungle' ),
                'active_callback' => function () {
                    return filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                 }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_epicjungle_copyright', [
                'selector'        => '.epicjungle-copyright',
                'render_callback' => 'epicjungle_footer_copyright',
            ] );

            $wp_customize->add_setting(
                'shop_footer_widgets', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );

            $wp_customize->add_control(
                'shop_footer_widgets', array (
                    'section'     => 'epicjungle_shop',
                    'label'       => esc_html__( 'Shop Footer Static Widgets', 'epicjungle' ),
                    'description' => esc_html__( 'Choose a static content that will be displayed in the footer widget area.','epicjungle' ),
                    'type'        => 'select',
                    'choices'     => $this->static_contents,
                    'active_callback' => function () {
                        return in_array( get_theme_mod( 'shop_footer_variant' ), [
                           'default', 'shop','v6', 'v7', 'blog'
                        ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'shop_footer_widgets', [
                'fallback_refresh'    => true
            ] );


           


            $wp_customize->add_setting(
                'shop_footer_jumbotron', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );

            $wp_customize->add_control(
                'shop_footer_jumbotron', array (
                    'section'     => 'epicjungle_shop',
                    'label'       => esc_html__( 'Shop Footer Static Content', 'epicjungle' ),
                    'description' => esc_html__( 'Choose a static content that will be displayed in the footer area.','epicjungle' ),
                    'type'        => 'select',
                    'choices'     => $this->static_contents,
                    'active_callback' => function () {
                        return in_array( get_theme_mod( 'shop_footer_variant' ), [
                            'shop','v8'
                        ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'shop_footer_jumbotron', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'shop_footer_payment_methods', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'absint',
            ] );

            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'shop_footer_payment_methods', [
                'section'     => 'epicjungle_shop',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Shop Payment Methods', 'epicjungle' ),
                /* translators: description field for "Payment Methods" setting in Customizer */
                'description' => esc_html__(
                    'This setting allows you to upload an image with available payment methods or anything you want.
                    This image as well as site logos is optimized for retina displays, so the original image size should
                    be twice as big as the final image that appears on the website.',
                    'epicjungle'
                ),
                'mime_type'   => 'image',
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_footer_variant' ), [ 'shop' ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] ) );

            $wp_customize->selective_refresh->add_partial( 'shop_footer_payment_methods', [
                'selector'            => '.payment-methods',
                'container_inclusive' => true,
                'render_callback'     => 'epicjungle_get_footer_pm',
            ] );


            $wp_customize->add_setting( 'shop_enable_newsletter_form', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'shop_enable_newsletter_form', [
                'type'        => 'radio',
                'section'     => 'epicjungle_shop',
                'label'       => esc_html__( 'Enable Newsletter Form', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to show or hide newsletter form in Footer.', 'epicjungle' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'epicjungle' ),
                    'no'  => esc_html__( 'No', 'epicjungle' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_footer_variant' ), [
                        'blog'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_enable_newsletter_form', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'shop_epicjungle_newsletter_title', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'shop_epicjungle_newsletter_title', [
                'type'            => 'text',
                'section'         => 'epicjungle_shop',
                'label'           => esc_html__( 'Newsletter Title', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change newsletter title', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_footer_variant' ), [
                        'blog'
                    ] ) && get_theme_mod( 'shop_enable_newsletter_form', 'no' ) === 'yes' && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_epicjungle_newsletter_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'shop_epicjungle_newsletter_desc', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'shop_epicjungle_newsletter_desc', [
                'type'            => 'textarea',
                'section'         => 'epicjungle_shop',
                'label'           => esc_html__( 'Newsletter Description', 'epicjungle' ),
                'description'     => esc_html__( 'This setting allows you to change newsletter description', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_footer_variant' ), [
                        'blog'
                    ] ) && get_theme_mod( 'shop_enable_newsletter_form', 'no' ) === 'yes' && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_epicjungle_newsletter_desc', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'shop_epicjungle_newsletter_form', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'shop_epicjungle_newsletter_form', [
                'type'            => 'textarea',
                'section'         => 'epicjungle_shop',
                'label'           => esc_html__( 'Newsletter Form', 'epicjungle' ),
                'description'     => esc_html__( 'Paste your newsletter signup form or shortcode', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_footer_variant' ), [
                        'blog'
                    ] ) && get_theme_mod( 'shop_enable_newsletter_form', 'no' ) === 'yes' && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'shop_epicjungle_newsletter_form', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'shop_epicjungle_custom_html', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );
            $wp_customize->add_control( 'shop_epicjungle_custom_html', [
                'type'        => 'textarea',
                'section'     => 'epicjungle_shop',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Download Our App Html', 'epicjungle' ),
                /* translators: description field for "Copyright" setting in Customizer */
                'description' => esc_html__( 'HTML is allowed in this field.', 'epicjungle' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'shop_footer_variant' ), [
                        'blog'
                    ] ) && filter_var( get_theme_mod( 'enable_separate_footer_for_shop' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'shop_epicjungle_custom_html', [
                'fallback_refresh'    => true
            ] );

           
        }

    }

endif;

return new EpicJungle_WooCommerce_Customizer();