<?php
/**
 * EpicJungle WooCommerce Class
 *
 * @package  epicjungle
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle_WooCommerce' ) ) :

    /**
     * The EpicJungle WooCommerce Integration class
     */
    class EpicJungle_WooCommerce {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            $this->includes();
            $this->init_hooks();

            add_action( 'admin_enqueue_scripts', array( $this, 'epicjungle_admin_enqueue_scripts_and_styles' ) );
        }

        public function includes() {
            require_once get_template_directory() . '/inc/woocommerce/classes/class-epicjungle-wc-helper.php';
            require_once get_template_directory() . '/inc/woocommerce/classes/class-epicjungle-product-cat-list-walker.php';
            require_once get_template_directory() . '/inc/woocommerce/classes/class-epicjungle-single-product-settings.php';
        }

        /**
         * Enqueue admin styles
         *
         * @return void
         * @since 1.7.0
         */
        public function epicjungle_admin_enqueue_scripts_and_styles() {
            $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

            if ( false !== strpos( $url, 'ejsp' ) ) {
                wp_enqueue_style( 'epicjungle-admin-styles', get_template_directory_uri() . '/assets/css/admin/wc-admin-styles.css' );
                wp_enqueue_script( 'epicjungle-admin-scripts', get_template_directory_uri() . '/assets/js/admin/wc-admin-scripts.js' );
            }
        }
        
        /**
         * Setup class.
         *
         * @since 1.0
         */
        private function init_hooks(){
            add_action( 'widgets_init', array( $this, 'widgets_init' ), 10 );
            add_action( 'after_setup_theme', array( $this, 'setup' ) );
            add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
            add_filter( 'body_class', array( $this, 'body_classes' ) );
            add_filter( 'woocommerce_post_class', array( $this, 'product_class' ), 10 );
            add_filter( 'woocommerce_show_page_title', '__return_false' );
        }

        public function product_class( $classes ) {
            $classes[] = 'col';  
            return $classes;
        }

        public function get_wc_shop_sidebar_args() {
            $sidebar_args['shop_sidebar'] = array(
                'name'        => esc_html__( 'Shop Sidebar', 'epicjungle' ),
                'id'          => 'sidebar-shop',
                'description' => '',
            );

            return apply_filters( 'epicjungle_wc_shop_sidebar_args', $sidebar_args );
        }

         public function widgets_init() {

            $sidebar_args = $this->get_wc_shop_sidebar_args();

            foreach ( $sidebar_args as $sidebar => $args ) {
                $widget_tags = array(
                    'before_widget' => '<div id="%1$s" class="cs-widget mb-5 %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="cs-widget-title">',
                    'after_title'   => '</h3>',
                );

                $filter_hook = sprintf( 'epicjungle_%s_widget_tags', $sidebar );
                $widget_tags = apply_filters( $filter_hook, $widget_tags );

                if ( is_array( $widget_tags ) ) {
                    register_sidebar( $args + $widget_tags );
                }
            }
        }

        /**
         * Sets up theme defaults and registers support for various WooCommerce features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         *
         * @since 1.0.0
         * @return void
         */
        public function setup() {
            // Declare WooCommerce support.
            add_theme_support( 'woocommerce', apply_filters( 'epicjungle_woocommerce_args', array(
                'thumbnail_image_width' => 350,
                'product_grid'          => array(
                    'default_columns' => 3,
                    'default_rows'    => 4,
                    'min_columns'     => 1,
                    'max_columns'     => 6,
                    'min_rows'        => 1
                )
            ) ) );

            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );

            /**
             * Add 'epicjungle_woocommerce_setup' action.
             *
             * @since  1.0.0
             */
            do_action( 'epicjungle_woocommerce_setup' );
        
        } 

        /**
         * Adds custom classes to the array of body classes.
         *
         * @param array $classes Classes for the body element.
         * @return array
         */
        public function body_classes( $classes ) {
            $shop_layout   = epicjungle_get_product_archive_layout();

            if( is_account_page() && is_user_logged_in() && ! is_wc_endpoint_url( 'lost-password' ) ) {
                $classes[] = 'bg-secondary';
            }

            if ( ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) &&  ( 'right-sidebar' === $shop_layout || 'left-sidebar' === $shop_layout ) ) {
                $classes[] = 'cs-is-sidebar';
            }
            

            return $classes;
        }

        
    }

endif;

return new EpicJungle_WooCommerce();
