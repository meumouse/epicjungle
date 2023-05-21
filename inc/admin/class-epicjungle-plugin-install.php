<?php
/**
 * EpicJungle Plugin Install Class
 *
 * @package  EpicJungle
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle_Plugin_Install' ) ) :
    /**
     * The EpicJungle plugin install class
     */
    class EpicJungle_Plugin_Install {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'plugin_install_scripts' ) );
            add_action( 'tgmpa_register', [ $this, 'register_required_plugins' ] );
        }

        /**
         * Wrapper epicjungle the core WP get_plugins function, making sure it's actually available.
         *
         * @since 2.5.0
         *
         * @param string $plugin_folder Optional. Relative path to single plugin folder.
         * @return array Array of installed plugins with plugin information.
         */
        public function get_plugins( $plugin_folder = '' ) {
            if ( ! function_exists( 'get_plugins' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            return get_plugins( $plugin_folder );
        }

        /**
         * Helper function to extract the file path of the plugin file from the
         * plugin slug, if the plugin is installed.
         *
         * @since 2.0.0
         *
         * @param string $slug Plugin slug (typically folder name) as provided by the developer.
         * @return string Either file path for plugin if installed, or just the plugin slug.
         */
        protected function _get_plugin_basename_from_slug( $slug ) {
            $keys = array_keys( $this->get_plugins() );

            foreach ( $keys as $key ) {
                if ( preg_match( '|^' . $slug . '/|', $key ) ) {
                    return $key;
                }
            }

            return $slug;
        }

        /**
         * Check if all plugins profile are installed
         *
         */
        public function requires_install_plugins( $plugins ) {
            $requires = false;
            
            foreach( $plugins as $plugin ) {
                $plugin['file_path']   = $this->_get_plugin_basename_from_slug( $plugin['slug'] );
                $plugin['is_callable'] = '';

                if ( ! TGM_Plugin_Activation::is_active( $plugin ) ) {
                    $requires = true;
                    break;
                }
            }

            return $requires;
        }

        /**
         * Load plugin install scripts
         *
         * @param string $hook_suffix the current page hook suffix.
         * @return void
         * @since  1.4.4
         */
        public function plugin_install_scripts( $hook_suffix ) {
            global $epicjungle, $epicjungle_version;

            $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

            wp_register_script( 'epicjungle-plugin-install', get_template_directory_uri() . '/assets/js/admin/plugin-install' . $suffix . '.js', array( 'jquery', 'updates' ), $epicjungle_version, 'all' );

            $params = [
                'tgmpa_url'   => admin_url( add_query_arg( 'page', 'tgmpa-install-plugins', 'themes.php' ) ),
                'txt_install' => esc_html__( 'Install Plugins', 'epicjungle' ),
                'profiles'    => $this->get_profile_params(),
            ];

            if ( epicjungle_is_ocdi_activated() ) {
                $params['file_args'] = $epicjungle->ocdi->import_files();
            }
            wp_localize_script( 'epicjungle-plugin-install', 'ocdi_params', $params );
            wp_enqueue_script( 'epicjungle-plugin-install' );

            wp_enqueue_style( 'epicjungle-plugin-install', get_template_directory_uri() . '/assets/css/admin/plugin-install.css', array(), $epicjungle_version, 'all' );
        }

        public function get_profile_params() {
            $profiles = $this->get_demo_profiles();
            $params   = [];
            foreach( $profiles as $key => $profile ) {
                $plugins = $this->get_demo_plugins( $key );
                $params[$key]['requires_install'] = $this->requires_install_plugins( $plugins );
                if ( $params[$key]['requires_install'] ) {
                    $params['all']['requires_install'] = true;
                }
            }
            return $params;
        }

        public function get_demo_profiles() {
            return array(
                'default' => array(
                    array(
                        'name'     => 'Elementor',
                        'slug'     => 'elementor',
                        'required' => true,
                    ),
                    array(
                        'name'     => 'EpicJungle Elementor',
                        'slug'     => 'epicjungle-elementor',
                        'source'   => 'https://github.com/meumouse/epicjungle-elementor/raw/main/epicjungle-elementor.zip',
                        'required' => true
                    ),
                    array(
                        'name'     => 'EpicJungle Extensions',
                        'slug'     => 'epicjungle-extensions',
                        'source'   => 'https://github.com/meumouse/epicjungle-extensions/raw/main/epicjungle-extensions.zip',
                        'required' => true
                    ),
                    array(
                        'name'     => 'Safe SVG',
                        'slug'     => 'safe-svg',
                        'required' => false,
                    ),
                    array(
                        'name'     => 'WooCommerce',
                        'slug'     => 'woocommerce',
                        'required' => true,
                    ),
                    array(
                        'name'     => 'WCBoost - Variation Swatches',
                        'slug'     => 'wcboost-variation-swatches',
                        'required' => true,
                    ),
                    array(
                        'name'     => 'WebP Express',
                        'slug'     => 'webp-express',
                        'required' => false,
                    ),
                    array(
                        'name'     => 'Wordfence Security',
                        'slug'     => 'wordfence',
                        'required' => false,
                    ),
                )
            );
        }

        public function get_demo_plugins( $demo = 'default' ) {
            $profiles = $this->get_demo_profiles();
            $plugins  = [];

            foreach ( $profiles as $key => $profile ) {
                if ( 'all' === $demo || 'default' === $key || $key === $demo ) {
                    $plugins = array_merge( $plugins, $profile );
                }
            }

            return $plugins;
        }

        /**
         * Register the required plugins for this theme.
         *
         * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
         */
        public function register_required_plugins() {
            /*
             * Array of plugin arrays. Required keys are name and slug.
             * If the source is NOT from the .org repo, then source is also required.
             */

            $profile = isset( $_GET['demo'] ) ? $_GET['demo']: '' ;

            $plugins = $this->get_demo_plugins( $profile );

            $config = array(
                'id'           => 'epicjungle', // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',        // Default absolute path to bundled plugins.
                'menu'         => 'tgmpa-install-plugins', // Menu slug.
                'has_notices'  => true,      // Show admin notices or not.
                'dismissable'  => true,      // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',        // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => false,     // Automatically activate plugins after installation or not.
                'message'      => '',        // Message to output right before the plugins table.
            );

            tgmpa( $plugins, $config );
        }
    }

endif;

return new EpicJungle_Plugin_Install();