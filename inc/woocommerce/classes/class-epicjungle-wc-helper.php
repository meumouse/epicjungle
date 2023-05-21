<?php
/**
 * EpicJungle Helper Class for WooCommerce
 */

class EpicJungle_WC_Helper {

public static function init() {

        // Add Size Guide Tab
        add_action( 'woocommerce_product_write_panel_tabs',             array( 'EpicJungle_WC_Helper', 'add_product_sizeguide_panel_tab' ) );
        add_action( 'woocommerce_product_data_panels',                  array( 'EpicJungle_WC_Helper', 'add_product_sizeguide_panel_data' ) );

        // Save Size Guide Tab
        add_action( 'woocommerce_process_product_meta_simple',          array( 'EpicJungle_WC_Helper', 'save_product_sizeguide_panel_data' ) );
        add_action( 'woocommerce_process_product_meta_variable',        array( 'EpicJungle_WC_Helper', 'save_product_sizeguide_panel_data' ) );
        add_action( 'woocommerce_process_product_meta_grouped',         array( 'EpicJungle_WC_Helper', 'save_product_sizeguide_panel_data' ) );
        add_action( 'woocommerce_process_product_meta_external',        array( 'EpicJungle_WC_Helper', 'save_product_sizeguide_panel_data' ) );   

    }

    public static function add_product_sizeguide_panel_tab() {
        ?>
        <li class="sizeguide_options sizeguide_tab">
            <a href="#sizeguide_product_data"><span><?php echo esc_html__( 'Size Guide', 'epicjungle' ); ?></span></a>
        </li>
        <?php
    }

    public static function add_product_sizeguide_panel_data() {
        global $post;
        ?>
        <div id="sizeguide_product_data" class="panel woocommerce_options_panel">
            <div class="options_group">
                <?php
                    $sizeguide = get_post_meta( $post->ID, '_sizeguide', true );
                    wp_editor( wp_specialchars_decode( $sizeguide ), '_sizeguide', array() );
                ?>
            </div>
        </div>
        <?php
    }

    public static function save_product_sizeguide_panel_data( $post_id ) {
        $sizeguide = isset( $_POST['_sizeguide'] ) ? $_POST['_sizeguide'] : '';
        update_post_meta( $post_id, '_sizeguide', $sizeguide );
    }       

}

EpicJungle_WC_Helper::init();