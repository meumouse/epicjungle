<?php
/**
* EpicJungle WeDocs Class
*
* @package  epicjungle
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'EpicJungle_WeDocs' ) ) :

/**
 * EpicJungle WeDocs Integration class
 */
class EpicJungle_WeDocs {

    /**
     * Setup class.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->init_hooks();
    }

    /**
     * Initialize Hooks
     *
     * @since 1.0.0
     */
    private function init_hooks(){
        add_action( 'wp_print_styles', array( $this, 'dequeue_default_wedoc_styles' ) );
        add_filter( 'wedocs_post_type', array( $this, 'post_type_args' ), 10 );
    }

    public function dequeue_default_wedoc_styles() {
        wp_dequeue_style( 'wedocs-styles' );
    }

    public function post_type_args( $args ) {
        $args['supports'][] = 'author';
        $args['supports'][] = 'excerpt';
        return $args;
    }
}

endif;

return new EpicJungle_WeDocs();
