<?php
/**
* EpicJungle OCDI Class
*
* @package  epicjungle
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle_OCDI' ) ) :

    class EpicJungle_OCDI {

        public $assets_url;

        public $demo_url;

        public function __construct() {
            $this->assets_url = 'https://transvelo.github.io/epicjungle/assets/';
            $this->demo_url   = 'https://epicjungle.meumouse.com/';

            add_filter( 'pt-ocdi/confirmation_dialog_options', [ $this, 'confirmation_dialog_options' ], 10, 1 );

            add_action( 'pt-ocdi/import_files', [ $this, 'import_files' ] );
            
            //add_action( 'pt-ocdi/before_widgets_import', [ $this, 'clear_default_widgets' ] );
            
            add_action( 'pt-ocdi/after_import', [ $this, 'import_wpforms'] );
            add_action( 'pt-ocdi/after_import', [ $this, 'set_nav_menus' ] );
            add_action( 'pt-ocdi/after_import', [ $this, 'set_site_options' ] );
            add_action( 'pt-ocdi/after_import', [ $this, 'replace_uploads_dir'] );

            add_action( 'pt-ocdi/enable_wp_customize_save_hooks', '__return_true' );
            add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
        }

        public function confirmation_dialog_options ( $options ) {
            return array_merge( $options, array(
                'width' => 410,
            ) );
        }

        public function trigger_ocdi_after_import() {
            $import_files = $this->import_files();
            $selected_import = end( $import_files );
            do_action( 'pt-ocdi/after_import', $selected_import );
        }

        public function replace_uploads_dir( $selected_import ) {
            if ( isset( $selected_import['uploads_dir'] ) ) {
                $from = $selected_import['uploads_dir'] . '/';
            } else {
                $from = 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads/';
            }
            
            $site_upload_dir = wp_get_upload_dir();
            $to = $site_upload_dir['baseurl'] . '/';
            \Elementor\Utils::replace_urls( $from, $to );
        }

        public function clear_default_widgets() {
            $sidebars_widgets = get_option('sidebars_widgets');
            $all_widgets = array();

            array_walk_recursive( $sidebars_widgets, function ($item, $key) use ( &$all_widgets ) {
                if( ! isset( $all_widgets[$key] ) ) {
                    $all_widgets[$key] = $item;
                } else {
                    $all_widgets[] = $item;
                }
            } );

            if( isset( $all_widgets['array_version'] ) ) {
                $array_version = $all_widgets['array_version'];
                unset( $all_widgets['array_version'] );
            }

            $new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

            $new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
            if( isset( $array_version ) ) {
                $new_sidebars_widgets['array_version'] = $array_version;
            }

            update_option( 'sidebars_widgets', $new_sidebars_widgets );
        }

        public function set_site_options( $selected_import ) {
            if ( isset( $selected_import['set_pages'] ) && $selected_import['set_pages'] ) {
                $front_page_title = isset( $selected_import['front_page_title'] ) ? $selected_import['front_page_title'] : 'Basic';
                $front_page_id    = get_page_by_title( $front_page_title );
                
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $front_page_id->ID );
            }

            update_option( 'posts_per_page', 9 );
        }

        public function set_nav_menus( $selected_import ) {
            if ( isset( $selected_import['set_nav_menus'] ) && $selected_import['set_nav_menus'] ) {
                $main_menu   = get_term_by( 'name', 'Main Menu', 'nav_menu' );
                $social_menu = get_term_by( 'name', 'Social Icons', 'nav_menu' );
                $locations   = [
                    'navbar_nav'   => $main_menu->term_id,
                    'social_media' => $social_menu->term_id
                ];

                set_theme_mod( 'nav_menu_locations', $locations );
            }
        }

        public function import_wpforms() {

            $assets_url = get_template_directory_uri() . '/assets/demo/';
            
            if ( ! function_exists( 'wpforms' ) || get_option( 'epicjungle_wpforms_imported', false ) ) {
                return;
            }

            $wpform_file_url = $assets_url . 'wpforms/all.json';
            $response        = wp_remote_get( $wpform_file_url );

            if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ) {
                return;
            }

            $form_json = wp_remote_retrieve_body( $response );

            if ( is_wp_error( $form_json ) ) {
                return;
            }

            $forms = json_decode( $form_json, true );

            foreach( $forms as $form_data ) {
                $form_title = $form_data['settings']['form_title'];

                if ( ! empty( $form_data['id'] ) ) {
                    $form_content = array(
                        'field_id' => '0',
                        'settings' => array(
                            'form_title' => sanitize_text_field( $form_title ),
                            'form_desc'  => '',
                        ),
                    );

                    // Merge args and create the form.
                    $form = array(
                        'import_id'     => (int) $form_data['id'],
                        'post_title'    => esc_html( $form_title ),
                        'post_status'   => 'publish',
                        'post_type'     => 'wpforms',
                        'post_content'  => wpforms_encode( $form_content ),
                    );

                    $form_id = wp_insert_post( $form );
                } else {
                    // Create initial form to get the form ID.
                    $form_id = wpforms()->form->add( $form_title );
                }

                if ( empty( $form_id ) ) {
                    continue;
                }

                $form_data['id'] = $form_id;
                // Save the form data to the new form.
                wpforms()->form->update( $form_id, $form_data );
            }

            update_option( 'epicjungle_wpforms_imported', true );
        }

        public function import_files() {
            $ocdi_host   = 'https://transvelo.github.io/epicjungle';
            $dd_url      = get_template_directory_uri() . '/assets/demo/';
            $preview_url = $ocdi_host . '/assets/img/demo/presentation/demos/';
            $notice      = esc_html__( 'This demo will import %s. It may take %s', 'epicjungle' );
            $notice      .= '<br><br>' . esc_html__( 'Menus, Widgets and Settings will not be imported. Content imported already will not be imported.', 'epicjungle' );
            $notice      .= '<br><br>' . esc_html__( 'Alternatively, you can import this template directly into your page via Edit with Elementor.', 'epicjungle' );

            return apply_filters( 'epicjungle_ocdi_files_args', array(
                array(
                    'import_file_name'         => 'Web Template Presentation',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/web-presentation.xml',
                    'import_preview_image_url' => $preview_url . 'template-presentation.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '56 items including 1 page & 55 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Business Consulting',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/business.xml',
                    'import_preview_image_url' => $preview_url . 'business-consulting.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '30 items including 1 page, 4 posts & 25 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto 2 minutes', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-business-consulting/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Shop Home',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/shop-home.xml',
                    'import_preview_image_url' => $preview_url . 'shop-homepage.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '59 items including 1 page, 46 images & 12 products', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-shop-homepage/',
                    'plugin_profile'           => 'shop',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                /*array(
                    'import_file_name'         => 'Booking/Directory',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/booking-directory.xml',
                    'import_preview_image_url' => $preview_url . 'booking.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '18 items including 1 page & 17 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-booking-directory/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),*/
                array(
                    'import_file_name'         => 'Creative Agency',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/creative-agency.xml',
                    'import_preview_image_url' => $preview_url . 'creative-agency.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '56 items including 1 page, 43 images, 4 posts & 8 projects', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-creative-agency',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Web Studio',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/web-studio.xml',
                    'import_preview_image_url' => $preview_url . 'web-studio.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '1 page, 24 images, 4 posts & 6 projects', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-web-studio/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Product - Software',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/product-software.xml',
                    'import_preview_image_url' => $preview_url . 'software-landing.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '23 items including 1 page & 22 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-product-software/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Product - Gadgets',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/product-gadgets.xml',
                    'import_preview_image_url' => $preview_url . 'gadget-landing.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '28 items including 1 page & 27 images', 'epicjungle' ) . '</strong>', esc_html__( '2-3 minutes', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-product-gadget/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Mobile App Showcase',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/mobile-app-showcase.xml',
                    'import_preview_image_url' => $preview_url . 'mobile-app.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '10 items including 1 page & 09 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-mobile-app/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Coworking Space',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/coworking-space.xml',
                    'import_preview_image_url' => $preview_url . 'coworking.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '35 items includes 1 page, 28 images & 6 projects', 'epicjungle' ) . '</strong>', esc_html__( '2-3 minutes', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-coworking-space/',
                    'plugin_profile'           => 'coworking',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Event Landing',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/event-landing.xml',
                    'import_preview_image_url' => $preview_url . 'event-landing.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '1 page & 28 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-event-landing/',
                    'plugin_profile'           => 'events',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Digital Marketing & SEO',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/digital-marketing.xml',
                    'import_preview_image_url' => $preview_url . 'marketing-seo.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '1 page & 14 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-marketing-seo/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Food Blog',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/food-blog.xml',
                    'import_preview_image_url' => $preview_url . 'food-blog.jpg',
                    'import_widget_file_url'   => $dd_url . 'widgets/blog.wie',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '44 items including 1 page, 30 images & 13 posts', 'epicjungle' ) . '</strong>', esc_html__( '1-2 minutes', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-food-blog/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Personal Portfolio',
                    'categories'               => array( 'Landing Pages' ),
                    'import_file_url'          => $dd_url . 'xml/personal-portfolio.xml',
                    'import_preview_image_url' => $preview_url . 'personal-portfolio.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '24 items including 1 page, 17 images & 6 projects', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo-personal-portfolio/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'About',
                    'categories'               => array( 'Secondary' ),
                    'import_file_url'          => $dd_url . 'xml/about.xml',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/about.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '23 items including 1 page & 22 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/about/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Contacts',
                    'categories'               => array( 'Secondary' ),
                    'import_file_url'          => $dd_url . 'xml/contacts.xml',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/contact.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '12 items including 3 pages & 9 images', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/contact-v1/',
                    'plugin_profile'           => 'default',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Coming Soon',
                    'categories'               => array( 'Secondary' ),
                    'import_file_url'          => $dd_url . 'xml/coming-soon.xml',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/coming-soon.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '9 items including 2 pages, 5 images & 2 static contents', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/coming-soon-image-2/',
                    'plugin_profile'           => 'static',
                    'uploads_dir'              => 'https://epicjungle.madrasthemes.com/demo/wp-content/uploads',
                ),
                array(
                    'import_file_name'         => 'Blog',
                    'categories'               => array( 'Templates' ),
                    'import_file_url'          => $dd_url . 'xml/blog.xml',
                    'import_widget_file_url'   => $dd_url . 'widgets/blog.wie',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/blog.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '41 blog posts, 6 pages, & 28 images', 'epicjungle' ) . '</strong>', esc_html__( '2-3 minutes', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/blog/',
                    'plugin_profile'           => 'default',

                ),
                array(
                    'import_file_name'         => 'Portfolio',
                    'categories'               => array( 'Templates' ),
                    'import_file_url'          => $dd_url . 'xml/portfolio.xml',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/portfolio.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '36 portfolio projects, 3 pages, & 30 images', 'epicjungle' ) . '</strong>', esc_html__( '2-3 minutes', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/portfolio-style-1/',
                    'plugin_profile'           => 'default',
                ),
                array(
                    'import_file_name'         => 'Shop',
                    'categories'               => array( 'Templates' ),
                    'import_file_url'          => $dd_url . 'xml/shop.xml',
                    'import_widget_file_url'   => $dd_url . 'widgets/shop.wie',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/shop.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '60 items including  3 pages,37 products, & 20 images', 'epicjungle' ) . '</strong>', esc_html__( '2-3 minutes', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/shop/',
                    'plugin_profile'           => 'shop',
                ),
                array(
                    'import_file_name'         => 'Footers & Static Contents',
                    'categories'               => array( 'Misc' ),
                    'import_file_url'          => $dd_url . 'xml/static-content.xml',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/footer.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '28 static contents', 'epicjungle' ) . '</strong>', esc_html__( '2-3 minutes', 'epicjungle' ) ),
                    'plugin_profile'           => 'static',
                ),
                array(
                    'import_file_name'         => 'Menus',
                    'categories'               => array( 'Misc' ),
                    'import_file_url'          => $dd_url . 'xml/menus.xml',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/menus.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '133 items', 'epicjungle' ) . '</strong>', esc_html__( '2-3 minutes', 'epicjungle' ) ),

                    'plugin_profile'           => 'static',
                ),
                array(
                    'import_file_name'         => 'Full Demo',
                    'categories'               => array( 'Full Demo', 'Demos' ),
                    'import_file_url'          => $dd_url . 'xml/full.xml',
                    // 'import_widget_file_url'   => $dd_url . 'widgets/full.wie',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/demos.jpg',
                    'import_notice'            => esc_html__( 'It imports the entire demo. It may take upto 5 minutes', 'epicjungle' ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo/',
                    'plugin_profile'           => 'all',
                    // 'import_customizer_file_url' => $dd_url . 'customizer/full.dat',
                    'set_nav_menus'            => true,
                    'set_pages'                => true,
                    'front_page_title'         => 'Basic'
                ),
                array(
                    'import_file_name'         => 'Help Center',
                    'categories'               => array( 'Demos' ),
                    'import_file_url'          => $dd_url . 'xml/helpcenter.xml',
                    'import_preview_image_url' => 'https://transvelo.github.io/epicjungle/assets/img/demo/screenshots/helpcenter.jpg',
                    'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '1 page, 7 docs, 11 articles, 2 static content & 6 image', 'epicjungle' ) . '</strong>', esc_html__( 'upto a minute', 'epicjungle' ) ),
                    'preview_url'              => 'https://epicjungle.madrasthemes.com/demo/',
                    'plugin_profile'           => 'docs',
                ),
            ) );
        }
    }

endif;

return new EpicJungle_OCDI();