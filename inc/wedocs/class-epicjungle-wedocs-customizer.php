<?php
/**
 * EpicJungle WeDocs Customizer Class
 *
 * @package  epicjungle
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle_WeDocs_Customizer' ) ) :


    class EpicJungle_WeDocs_Customizer extends EpicJungle_Customizer {

        /**
         * Setup class.
         *
         * @since 1.0.0
         * @return void
         */
        public function __construct() {
            add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since 2.4.0
         */
        public function customize_register( $wp_customize ) {
            /**
             * Helpcenter
             */
           
            $wp_customize->add_section( 'epicjungle_helpcenter', [
                'priority'    => 100,
                'title'       => esc_html__( 'Helpcenter', 'epicjungle' ),
                'description' => esc_html__( 'This section contains settings related to single article', 'epicjungle' ),
            ] );

           
            $this->add_helpcenter_action_section( $wp_customize );
        }

        /**
         * Helpcenter Section
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        
        private function add_helpcenter_action_section( $wp_customize ) {
            
            $wp_customize->add_setting( 'ej_helpcenter_action_disable', [
                'default'           => false,
                'sanitize_callback' => 'sanitize_key',
            ] );


            $wp_customize->add_control( 'ej_helpcenter_action_disable', [
                'type'        => 'checkbox',
                'section'     => 'epicjungle_helpcenter',
                'label'       => esc_html__( 'Hide Action', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to hide action block.', 'epicjungle' ),
            ] );

            $wp_customize->add_setting(
                'ej_helpcenter_action_title',
                array(
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'wp_kses_post',
                    'default'           => esc_html__( "Haven't found the answer? We can help.", 'epicjungle' ),
                )
            );

            $wp_customize->add_control(
                'ej_helpcenter_action_title',
                array(
                    'label'       => esc_html__( 'Action Title', 'epicjungle' ),
                    'section'     => 'epicjungle_helpcenter',
                    'settings'    => 'ej_helpcenter_action_title',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'ej_helpcenter_action_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial(
                'ej_helpcenter_action_title', [
                'selector'        => '[data-ed-customizer="action_title"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'ej_helpcenter_action_title' ) );
                },
            ] );

            $wp_customize->add_setting( 'ej_helpcenter_action_icon_class', [
                'default'           => esc_html__( "fe-life-buoy", 'epicjungle' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'esc_attr',
            ] );
            $wp_customize->add_control( 'ej_helpcenter_action_icon_class', [
                'label'   => esc_html__( 'Icon Class', 'epicjungle' ),
                'section' => 'epicjungle_helpcenter',
                'type'    => 'text',
                'active_callback' => function() {
                    return (  get_theme_mod( 'ej_helpcenter_action_disable' ) == false );
                }
            ] );

            $wp_customize->selective_refresh->add_partial(
                'ej_helpcenter_action_icon_class', [
                'selector'        => '[data-ed-customizer="action_iconclass"]',
                'container_inclusive' => true,
                'render_callback' => function () {
                    return esc_attr( get_theme_mod( 'ej_helpcenter_action_icon_class' ) );
                },
            ] );

            $wp_customize->add_setting(
                'ej_helpcenter_action_btntext',
                array(
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'wp_kses_post',
                    'default'           => esc_html__( "Submit a request", 'epicjungle' ),
                )
            );

            $wp_customize->add_control(
                'ej_helpcenter_action_btntext',
                array(
                    'label'       => esc_html__( 'Action link Text', 'epicjungle' ),
                    'section'     => 'epicjungle_helpcenter',
                    'settings'    => 'ej_helpcenter_action_btntext',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'ej_helpcenter_action_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial(
                'ej_helpcenter_action_btntext', [
                'selector'        => '[data-ed-customizer="action_btntext"]',
                'render_callback' => function () {
                    return esc_url( get_theme_mod( 'ej_helpcenter_action_btntext' ) );
                },

            ] );

            $wp_customize->add_setting(
                'ej_helpcenter_action_subtitle',
                array(
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'wp_kses_post',
                    'default'           => esc_html__( "Contact us and we'll get back to you as soon as possible.", 'epicjungle' ),
                )
            );

            $wp_customize->add_control(
                'ej_helpcenter_action_subtitle',
                array(
                    'label'       => esc_html__( 'Action Sub Title', 'epicjungle' ),
                    'section'     => 'epicjungle_helpcenter',
                    'settings'    => 'ej_helpcenter_action_subtitle',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'ej_helpcenter_action_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial(
                'ej_helpcenter_action_subtitle', [
                'selector'        => '[data-ed-customizer="action_subtitle"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'ej_helpcenter_action_subtitle' ) );
                },
            ] );

            $wp_customize->add_setting( 'ej_helpcenter_action_link', [
                'default'           => '#',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'esc_url_raw',
            ] );

            $wp_customize->add_control( 'ej_helpcenter_action_link', [
                'label'   => esc_html__( 'Button text Url ', 'epicjungle' ),
                'section' => 'epicjungle_helpcenter',
                'settings'    => 'ej_helpcenter_action_link',
                'type'    => 'url',
                'active_callback' => function() {
                    return (  get_theme_mod( 'ej_helpcenter_action_is_modal' ) == false );
                }
            ] );

            $wp_customize->selective_refresh->add_partial(
                'ej_helpcenter_action_link', [
                'selector'        => '[data-ed-customizer="action_btn"]',
                'container_inclusive' => true,
                'render_callback' => function () {
                    return esc_url( get_theme_mod( 'ej_helpcenter_action_link' ) );
                },
            ] );

            $wp_customize->add_setting( 'ej_helpcenter_action_is_modal', [
                'default'           => true,
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'ej_helpcenter_action_is_modal', [
                'type'        => 'checkbox',
                'section'     => 'epicjungle_helpcenter',
                'label'       => esc_html__( 'Is modal enable?', 'epicjungle' ),
                'description' => esc_html__( 'This setting allows you to add custom url.', 'epicjungle' ),
                'active_callback' => function() {
                        return (  get_theme_mod( 'ej_helpcenter_action_disable' ) == false );
                    }
            ] );
        }
    }

endif;

return new epicjungle_WeDocs_Customizer();