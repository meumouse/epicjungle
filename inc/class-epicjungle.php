<?php
/**
 * EpicJungle Class
 *
 * @since    1.0.0
 * @package  epicjungle
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle' ) ) :

    /**
     * The main EpicJungle class
     */
    class EpicJungle {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            add_action( 'after_setup_theme', array( $this, 'setup' ) );
            add_action( 'after_setup_theme', array( $this, 'wpforms_scripts' ) );
            add_action( 'widgets_init', array( $this, 'widgets_init' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
            add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 30 ); // After WooCommerce.
            add_action( 'admin_head', array( $this, 'wp_5_6_editor_block_width_fix' ) );
            add_filter( 'body_class', array( $this, 'body_classes' ) );
        }

        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        public function setup() {
            /*
             * Load Localisation files.
             *
             * Note: the first-loaded translation file overrides any following ones if the same translation is present.
             */

            // Loads wp-content/languages/themes/epicjungle-it_IT.mo.
            load_theme_textdomain( 'epicjungle', trailingslashit( WP_LANG_DIR ) . 'themes' );

            // Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
            load_theme_textdomain( 'epicjungle', get_stylesheet_directory() . '/languages' );

            // Loads wp-content/themes/epicjungle/languages/it_IT.mo.
            load_theme_textdomain( 'epicjungle', get_template_directory() . '/languages' );

            /**
             * Add default posts and comments RSS feed links to head.
             */
            add_theme_support( 'automatic-feed-links' );

            /*
             * Enable support for Post Thumbnails on posts and pages.
             *
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
             */
            add_theme_support( 'post-thumbnails' );

            /**
             * Enable support for site logo.
             */
            add_theme_support(
                'custom-logo',
                apply_filters(
                    'epicjungle_custom_logo_args',
                    array(
                        'height'      => 110,
                        'width'       => 470,
                        'flex-width'  => true,
                        'flex-height' => true,
                    )
                )
            );

            /**
             * Register menu locations.
             */
            register_nav_menus(
                apply_filters(
                    'epicjungle_register_nav_menus',
                    array(
                        'navbar_nav'        => esc_html__( 'Navbar Nav', 'epicjungle' ),
                        'social_media'      => esc_html_x( 'Social Media', 'menu location', 'epicjungle' ),
                        'footer_links'      => esc_html_x( 'Footer Menu', 'menu location', 'epicjungle' ),
                        'footer_shop_links' => esc_html_x( 'Footer Shop Menu', 'menu location', 'epicjungle' ),
                        'topbar_left'       => esc_html_x( 'Topbar Left', 'menu location', 'epicjungle' ),
                        'topbar_right'      => esc_html_x( 'Topbar Right', 'menu location', 'epicjungle' ),
                        'contact_links'     => esc_html_x( 'Contact Links', 'menu location', 'epicjungle' ),
                        
                    )
                )
            );

            /*
             * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
             * to output valid HTML5.
             */
            add_theme_support(
                'html5',
                apply_filters(
                    'epicjungle_html5_args',
                    array(
                        'search-form',
                        'comment-form',
                        'comment-list',
                        'gallery',
                        'caption',
                        'widgets',
                        'style',
                        'script',
                    )
                )
            );

            /**
             * Setup the WordPress core custom background feature.
             */
            add_theme_support(
                'custom-background',
                apply_filters(
                    'epicjungle_custom_background_args',
                    array(
                        'default-color' => apply_filters( 'epicjungle_default_background_color', 'ffffff' ),
                        'default-image' => '',
                    )
                )
            );

            /**
             * Setup the WordPress core custom header feature.
             */
            add_theme_support(
                'custom-header',
                apply_filters(
                    'epicjungle_custom_header_args',
                    array(
                        'default-image' => '',
                        'header-text'   => false,
                        'width'         => 1950,
                        'height'        => 500,
                        'flex-width'    => true,
                        'flex-height'   => true,
                    )
                )
            );

            /**
             *  Add support for the Site Logo plugin and the site logo functionality in JetPack
             *  https://github.com/automattic/site-logo
             *  http://jetpack.me/
             */
            add_theme_support(
                'site-logo',
                apply_filters(
                    'epicjungle_site_logo_args',
                    array(
                        'size' => 'full',
                    )
                )
            );


            /**
             * Declare support for title theme feature.
             */
            add_theme_support( 'title-tag' );

            /**
             * Declare support for selective refreshing of widgets.
             */
            add_theme_support( 'customize-selective-refresh-widgets' );

            /**
             * Add support for Block Styles.
             */
            add_theme_support( 'wp-block-styles' );

            /**
             * Add support for full and wide align images.
             */
            add_theme_support( 'align-wide' );

            /**
             * Add support for editor styles.
             */
            add_theme_support( 'editor-styles' );

            /**
             * Add support for editor font sizes.
             */
            add_theme_support(
                'editor-font-sizes',
                array(
                    array(
                        'name' => esc_html__( 'Small', 'epicjungle' ),
                        'size' => 14,
                        'slug' => 'small',
                    ),
                    array(
                        'name' => esc_html__( 'Normal', 'epicjungle' ),
                        'size' => 16,
                        'slug' => 'normal',
                    ),
                    array(
                        'name' => esc_html__( 'Medium', 'epicjungle' ),
                        'size' => 23,
                        'slug' => 'medium',
                    ),
                    array(
                        'name' => esc_html__( 'Large', 'epicjungle' ),
                        'size' => 26,
                        'slug' => 'large',
                    ),
                    array(
                        'name' => esc_html__( 'Huge', 'epicjungle' ),
                        'size' => 37,
                        'slug' => 'huge',
                    ),
                )
            );

            /**
             * Enqueue editor styles.
             */
            //add_editor_style( array( 'assets/css/base/gutenberg-editor.css', $this->google_fonts() ) );

            /**
             * Add support for responsive embedded content.
             */
            add_theme_support( 'responsive-embeds' );

            /**
             * Enqueue editor styles.
             */

            $editor_styles = [
                is_rtl() ? 'assets/css/gutenberg-editor-rtl.css' : 'assets/css/gutenberg-editor.css',
            ];

            add_editor_style( $editor_styles );
        }

        public function get_blog_sidebar_args() {
            $blog_sidebar_args['blog_sidebar'] = array(
                'name'        => esc_html__( 'Blog Sidebar', 'epicjungle' ),
                'id'          => 'blog-sidebar',
                'description' => '',
            );

            return apply_filters( 'epicjungle_blog_sidebar_args', $blog_sidebar_args );
        }

        /**
         * Register widget area.
         *
         * @link https://codex.wordpress.org/Function_Reference/register_sidebar
         */
        public function widgets_init() {

            $blog_sidebar_args  = $this->get_blog_sidebar_args();

            foreach ( $blog_sidebar_args  as $sidebar => $args ) {
                $widget_tags = array(
                    'before_widget' => '<div id="%1$s" class="cs-widget mb-5 %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="cs-widget-title">',
                    'after_title'   => '</h3>',
                );

                /**
                 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
                 *
                 * 'bookworm_shop_sidebar_widget_tags'
                 */
                $filter_hook = sprintf( 'epicjungle_%s_widget_tags', $sidebar );
                $widget_tags = apply_filters( $filter_hook, $widget_tags );

                if ( is_array( $widget_tags ) ) {
                    register_sidebar( $args + $widget_tags );
                }
            }

            $rows    = intval( apply_filters( 'epicjungle_footer_widget_rows', 1 ) );
            $regions = intval( apply_filters( 'epicjungle_footer_widget_columns', 3 ) );

            for ( $row = 1; $row <= $rows; $row++ ) {
                for ( $region = 1; $region <= $regions; $region++ ) {
                    $footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
                    $footer   = sprintf( 'footer_%d', $footer_n );

                    if ( 1 === $rows ) {
                        /* translators: 1: column number */
                        $footer_region_name = sprintf( esc_html__( 'Footer Column %1$d', 'epicjungle' ), $region );

                        /* translators: 1: column number */
                        $footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of the footer.', 'epicjungle' ), $region );
                    } else {
                        /* translators: 1: row number, 2: column number */
                        $footer_region_name = sprintf( esc_html__( 'Footer Row %1$d - Column %2$d', 'epicjungle' ), $row, $region );

                        /* translators: 1: column number, 2: row number */
                        $footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'epicjungle' ), $region, $row );
                    }

                    $sidebar_args[ $footer ] = array(
                        'name'        => $footer_region_name,
                        'id'          => sprintf( 'footer-%d', $footer_n ),
                        'description' => $footer_region_description,
                    );
                }
            }

            $sidebar_args = apply_filters( 'epicjungle_sidebar_args', $sidebar_args );

            foreach ( $sidebar_args as $sidebar => $args ) {
                $footer_skin    = epicjungle_footer_skin();
                $footer_variant = epicjungle_footer_variant();


                if ( $footer_variant === 'default' || $footer_variant === 'simple' || $footer_variant === 'v7' || $footer_variant === 'v8' ) {
                    if ($footer_skin === 'light') {
                        $widget_classes = 'dark';
                    } else {
                        $widget_classes = 'light';
                    }
                } else {
                    $widget_classes = 'light';
                }


                $widget_tags = array(
                    'before_widget' => '<div id="%1$s" class="cs-widget cs-widget-' .$widget_classes .' %2$s pb-1 mb-4">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h4 class="cs-widget-title">',
                    'after_title'   => '</h4>',
                );

                /**
                 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
                 *
                 * 'epicjungle_header_widget_tags'
                 * 'epicjungle_sidebar_widget_tags'
                 *
                 * 'epicjungle_footer_1_widget_tags'
                 * 'epicjungle_footer_2_widget_tags'
                 * 'epicjungle_footer_3_widget_tags'
                 * 'epicjungle_footer_4_widget_tags'
                 */
                $filter_hook = sprintf( 'epicjungle_%s_widget_tags', $sidebar );
                $widget_tags = apply_filters( $filter_hook, $widget_tags );

                if ( is_array( $widget_tags ) ) {
                    register_sidebar( $args + $widget_tags );
                }
            }
        }

        /**
         * Enqueue scripts and styles.
         *
         * @since  1.0.0
         */
        public function scripts() {
            global $epicjungle_version;

            /**
             * Styles
             */
            $css_files = $this->get_css_libraries();

            foreach( $css_files as $handle => $css_file ) {
                wp_enqueue_style( $handle, $css_file['src'], $css_file['dep'], $css_file['ver'] );
            }

            wp_enqueue_style( 'epicjungle-style', get_template_directory_uri() . '/style.css', '', $epicjungle_version );
            wp_style_add_data( 'epicjungle-style', 'rtl', 'replace' );

            if( apply_filters( 'epicjungle_use_predefined_colors', true ) && filter_var( get_theme_mod( 'epicjungle_enable_custom_color', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
                wp_enqueue_style( 'epicjungle-color', get_template_directory_uri() . '/assets/css/colors/' . 'color.css', '', $epicjungle_version );
            }

            /**
             * Fonts
             */
            wp_enqueue_style( 'epicjungle-fonts', $this->google_fonts(), array(), null );

            /**
             * Scripts
             */
            $js_files = $this->get_js_libraries();
            foreach( $js_files as $handle => $js_file ) {
                wp_enqueue_script( $handle, $js_file['src'], $js_file['dep'], $js_file['ver'], true );
            }

            wp_enqueue_script( 'epicjungle-js', get_template_directory_uri() . '/assets/js/theme.min.js', array( 'jquery', 'bootstrap-bundle' ), $epicjungle_version, true );

            wp_enqueue_script( 'epicjungle-scripts', get_template_directory_uri() . '/assets/js/epicjungle.js', array( 'jquery', 'bootstrap-bundle' ), $epicjungle_version, true );

            $admin_ajax_url = admin_url( 'admin-ajax.php' );
            
          
            $current_lang   = apply_filters( 'wpml_current_language', NULL );
            if ( $current_lang ) {
                $admin_ajax_url = add_query_arg( 'lang', $current_lang, $admin_ajax_url );
            }


            $epicjungle_options = apply_filters( 'epicjungle_localize_script_data', array(
                'ajax_url'                  => $admin_ajax_url,
                'ajax_loader_url'           => get_template_directory_uri() . '/assets/img/ajax-loader.gif',
                'deal_countdown_text'       => apply_filters( 'epicjungle_coming_soon_timer_clock_text', array(
                    'days_text'     => esc_html__( 'Days', 'epicjungle' ),
                    'hours_text'    => esc_html__( 'Hours', 'epicjungle' ),
                    'mins_text'     => esc_html__( 'Mins', 'epicjungle' ),
                    'secs_text'     => esc_html__( 'Secs', 'epicjungle' ),
                ) ),
            ) );

            wp_localize_script( 'epicjungle-scripts', 'epicjungle_options', $epicjungle_options );

            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
            }
           
        }

        /**
         * Get CSS Libraries used by EpicJungle
         *
         * @since 1.0.0
         */
        private function get_css_libraries() {
            global $epicjungle_version;

            return apply_filters( 'epicjungle_css_vendors', array(
                'aos' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/aos/dist/aos.css',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'tiny-slider' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/tiny-slider/dist/tiny-slider.css',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'lightgallery' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/lightgallery.js/dist/css/lightgallery.min.css',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'simplebar' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/simplebar/dist/simplebar.min.css',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'nouislider' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/nouislider/distribute/nouislider.min.css',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
            ) );
        }

        /**
         * Get JS Libraries used by EpicJungle
         */
        private function get_js_libraries() {
            global $epicjungle_version;

            return apply_filters( 'epicjungle_js_vendors', array(
                'jquery' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/jquery/dist/jquery-3.3.1.slim.min.js',
                    'dep' => array( '' ),
                    'ver' => $epicjungle_version
                ),
                'jquery-mask' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/jquery-mask/dist/jquery.mask.min.js',
                    'dep' => array( 'jquery' ),
                    'ver' => $epicjungle_version
                ),
                'bootstrap-bundle' => array(
                    'src'  => get_template_directory_uri() . '/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js',
                    'dep'  => array( 'jquery' ),
                    'ver'  => $epicjungle_version
                ),
                'simplebar' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/simplebar/dist/simplebar.min.js',
                    'dep' => array( 'jquery' ),
                    'ver' => $epicjungle_version
                ),
                'smooth-scroll' => array(
                    'src'  => get_template_directory_uri() . '/assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js',
                    'dep'  => array(),
                    'ver'  => $epicjungle_version
                ),
                'nouislider' => array(
                    'src'  => get_template_directory_uri() . '/assets/vendor/nouislider/distribute/nouislider.min.js',
                    'dep'  => array(),
                    'ver'  => $epicjungle_version
                ),
                'imagesloaded' => array(
                    'src'  => get_template_directory_uri() . '/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js',
                    'dep'  => array(),
                    'ver'  => $epicjungle_version
                ),
                'tiny-slider' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/tiny-slider/dist/min/tiny-slider.js',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'parallax' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/parallax-js/dist/parallax.min.js',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'lightgallery' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/lightgallery.js/dist/js/lightgallery.min.js',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'lg-video' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/lg-video.js/dist/lg-video.min.js',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'shufflejs' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/shufflejs/dist/shuffle.min.js',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'aos' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/aos/dist/aos.js',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'jarallax' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/jarallax/dist/jarallax.min.js',
                    'dep' => array(),
                    'ver' => $epicjungle_version
                ),
                'jarallax-element' => array(
                    'src' => get_template_directory_uri() . '/assets/vendor/jarallax/dist/jarallax-element.min.js',
                    'dep' => array( 'jarallax' ),
                    'ver' => $epicjungle_version
                ),
                
            ) );


        }

        /**
         * Enqueue child theme stylesheet.
         * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
         * primary css and the separate WooCommerce css.
         *
         * @since  1.5.3
         */
        public function child_scripts() {
            if ( is_child_theme() ) {
                $child_theme = wp_get_theme( get_stylesheet() );
                wp_enqueue_style( 'epicjungle-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );
            }
        }

        public function wpforms_scripts() {
            if ( function_exists( 'wpforms' ) && apply_filters( 'epicjungle_wpforms_disable_css', true ) ) {
                $settings = get_option( 'wpforms_settings', array() );
                if ( ! isset( $settings['disable-css'] ) || $settings['disable-css'] != 2 ) {
                    $settings['disable-css'] = 2;
                    update_option( 'wpforms_settings', $settings );
                }
            }
        }


        /**
         * Register Google fonts.
         *
         * @since 1.0.0
         * @return string Google fonts URL for the theme.
         */
        public function google_fonts() {
            $fonts_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap';
            return $fonts_url;
        }

        /**
         * Adds custom classes to the array of body classes.
         *
         * @param array $classes Classes for the body element.
         * @return array
         */
        public function body_classes( $classes ) {
            global $post;
            // Adds a class to blogs with more than 1 published author.

            $sidebar = epicjungle_posts_sidebar();
            

            if ( ( is_home() || is_singular( 'post' ) || ( 'post' == get_post_type() && ( is_category() || is_tag() || is_author() || is_date() || is_year() || is_month() || is_time() ) ) )
             && epicjungle_posts_sidebar() !== 'no-sidebar' ) {
                $classes[] = 'has-sidebar cs-is-sidebar';
             }

            
            if( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
                $clean_meta_data = get_post_meta( $post->ID, '_ar_page_options', true );
                $ar_page_options = maybe_unserialize( $clean_meta_data );

                if( isset( $ar_page_options['general'] ) && isset( $ar_page_options['general']['body_classes'] ) && ! empty( $ar_page_options['general']['body_classes'] ) ) {
                    $classes[] = $ar_page_options['general']['body_classes'];
                }
            }

            if ( filter_var( get_theme_mod( 'epicjungle_enable_custom_color', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
                $classes[] = 'custom-color-scheme';
            }

            return $classes;
        }

        /**
         * WordPress 5.6 editor width issue fix.
         *
         * @since 1.0.0
         */
        public function wp_5_6_editor_block_width_fix() {
            if( version_compare( get_bloginfo( 'version' ), '5.6', '>=' ) ) {
                echo '<style>.interface-interface-skeleton__editor { max-width: 100%; }</style>';
            }
        }

    }
endif;

return new EpicJungle();