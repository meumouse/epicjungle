<?php
/**
 * EpicJungle Admin Class
 *
 * @package  storefront
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle_Admin' ) ) :
    /**
     * The EpicJungle admin class
     */
    class EpicJungle_Admin {
        
        public function __construct() {
            add_action( 'admin_init', [ $this, 'run_once' ] );
            add_action( 'admin_init', [ $this, 'disable_redirects' ], 1 );
        }

        public function disable_redirects() {
            if ( did_action( 'elementor/loaded' ) ) {
                remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
            }
        } 

        public function run_once() {
            if ( get_option( 'epicjungle_admin_run_once_completed', false ) ) {
                return;
            }

            update_option( 'job_manager_enable_categories', '1' );

            do_action( 'epicjungle/admin/run_once' );

            update_option( 'epicjungle_admin_run_once_completed', true );
        }
    }

endif;

return new EpicJungle_Admin();