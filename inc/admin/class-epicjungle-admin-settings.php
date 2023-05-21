<?php

/**
 * EpicJungle Admin Settings
 *
 * @package  epicjungle
 * @since    1.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class EpicJungle_Admin_Settings_Controller {

    private $options;
        
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'epicjungle_admin_settings' ) );
        add_action( 'admin_menu', array( $this, 'books_register_ref_page' ) );
        add_action( 'admin_init', array( $this, 'rudr_settings_fields' ) );
        add_action( 'admin_notices', array( $this, 'rudr_notice' ) );
    }


    /**
     * Register EpicJungle admin page settings
     */
    public function epicjungle_admin_settings() {
        $icon_base64 = 'PHN2ZyBpZD0iZTdjOTM2OTAtNjM0YS00MjM2LTljNGYtZGQ1MjIxMTY4YWM1IiBkYXRhLW5hbWU9IkNhbWFkYSAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0ODEuMjUgMzg5LjI4Ij48cGF0aCBkPSJNMjMwLjgyLDIzNi41M2M4Ni0yLjg5LDEzNi43Ny0yNS4xMywxNDIuNTktNzksNy02NS4xNS02Mi42Ny0xMTYuMDktMTU5LTg0LjM2LTQzLjMzLDE0LjI4LTgxLjE5LDUwLjQ5LTEwMy43NCw5NS43NS00MiwxMi43LTc3LjMsNDIuMjMtOTAuNTEsMTA5Ljc2QzQwLjQ1LDI2NSw2My40OCwyNTYsODksMjUwLjA1YzI1LTUuOTIsNTIuNDEtOSw4Mi0xMC44N0MxOTAsMjM4LDIxMCwyMzcuMjIsMjMwLjgyLDIzNi41M1pNMjg3LjY4LDEwMC4xYzQ3Ljk0LTEuNTUsNDMuMTYsNDguNTItMTAuMDUsNTcuNDQtMjMuMTMsMy44NS01My4xNSwyLTg0LjYsMkMyMTcuMzMsMTIyLjMzLDI1Ni45MSwxMDEuMDksMjg3LjY4LDEwMC4xWiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTE2LjUzIC02MC45OSkiIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiNmZmY7c3Ryb2tlLW1pdGVybGltaXQ6MTA7c3Ryb2tlLXdpZHRoOjVweCIvPjxwYXRoIGQ9Ik0zMjYuNCwyNDMuNDhjLTE3LjE0LDQ5LjU2LTY3LjU3LDYzLjI2LTEyNCw3Ni45Mi0yOS45NCw3LjI3LTYxLjU3LDE0LjQ5LTkwLjc5LDI3LjA5LTI0LDEwLjMzLTQ2LjMzLDI0LjI3LTY0LjgxLDQ0Ljc0QzUwLjkxLDM0OCw2OC45MiwzMjAuOTIsOTQuMTEsMzA0djBjMjMuMTYtMTUuNjIsNTIuNDUtMjIuNzEsODIuNTctMjYuODRDMjM3LjE4LDI2OC44NSwzMDEuMTcsMjcyLjU2LDMyNi40LDI0My40OFoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xNi41MyAtNjAuOTkpIiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojZmZmO3N0cm9rZS1taXRlcmxpbWl0OjEwO3N0cm9rZS13aWR0aDo1cHgiLz48cGF0aCBkPSJNMjAyLjQyLDMyMC40cy00OS4xNCwyNywwLDU5LjkzUzMyNSwzOTQuMTQsMzU1LjM1LDM3MS45NHM0MC44LTM5LjU0LDU1LjgxLTYxLjk0LDM3LjQ0LTY3LjM1LDgwLTY2LjUzYzAsMC0yNy41OC0xMi42OS02NC44LDE2LjA3cy01My45LDU4Ljc1LTEwMi4xMyw3OC42N1MyMjQuNTIsMzQ0LjE0LDIwMi40MiwzMjAuNFoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xNi41MyAtNjAuOTkpIiBzdHlsZT0iZmlsbDojZmZmIi8+PHBhdGggZD0iTTMyNi40LDI0My40N0MyOTIuMjksMjk1LDIxMy44NSwyOTAuMzksMTM4LjMzLDMxMS4xNHMtOTEuNSw4MS4wOC05MS41LDgxLjA4LDAtNTIuMTgsNDIuMzEtODQuNjlTMjA5LDI3My41OSwyMDksMjczLjU5LDMxMS44NSwyNjkuODksMzI2LjQsMjQzLjQ3WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTE2LjUzIC02MC45OSkiIHN0eWxlPSJmaWxsOiNmZmYiLz48cGF0aCBkPSJNMTExLjYzLDM0Ny40OVMxNTMuMDgsNDMxLjksMjU1LjQsNDQ2czE0OS45Mi02MC40NywxNDkuOTItNjAuNDcsMjIuMi0yNy43NCwzNy45NC03OC41NSw0Ny45LTYzLjUxLDQ3LjktNjMuNTEtMjUuOTMtMTAuOTItNTQuNTQsOC45Mi00NC42LDM5LjY3LTczLjI3LDYzLjI4UzMxMC45NCwzNDcuMjUsMjY4LDM0Ni43NXMtNjUuNTYtMjYuMzUtNjUuNTYtMjYuMzVTMTQ2LjMsMzMxLjI2LDExMS42MywzNDcuNDlaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTYuNTMgLTYwLjk5KSIgc3R5bGU9ImZpbGw6bm9uZTtzdHJva2U6I2ZmZjtzdHJva2UtbWl0ZXJsaW1pdDoxMDtzdHJva2Utd2lkdGg6NXB4Ii8+PHBhdGggZD0iTTIwLjE1LDI3OC42OHMzNi43OC02Ny4zMywxMDkuNjUtNzcuMDUsMTA5LTEsMTQ5LjYxLTE1LjE1LDYwLjczLTUxLjg4LDM3LTc2LjY1YzAsMCwxNC43OSwxNy0xMCwzNi4yNywwLDAtMTUuNjMsMTQuNzgtNjYuMzMsMTMuODhzLTEwNy4zMS0yLjgyLTE0MS41MSwxMy4xNlMzNS4yOCwyMDkuNywyMC4xNSwyNzguNjhaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTYuNTMgLTYwLjk5KSIgc3R5bGU9ImZpbGw6I2ZmZiIvPjwvc3ZnPg==';
        $icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

        add_menu_page(
            __( 'EpicJungle', 'epicjungle' ),
            __( 'EpicJungle', 'epicjungle' ),
            'manage_options',
            'epicjungle-settings',
            array( $this, 'epicjungle_menu_page' ),
            $icon_data_uri,
            '30'
        );
    }


    /**
     * Display a custom menu page
     */
    public function epicjungle_menu_page(){
        echo 'teste';
    }


    /**
     * Adds a submenu page under a custom post type parent.
     */
    public function books_register_ref_page() {
        add_submenu_page(
            'epicjungle-settings',
            __( 'Configurações', 'epicjungle' ),
            __( 'Configurações', 'epicjungle' ),
            'manage_options',
            'epicjungle-wc-settings-page',
            array( $this, 'books_ref_page_callback' )
        );
    }


    /**
     * Display callback for the submenu page.
     */
    public function books_ref_page_callback() { 
        ?>
		<div class="wrap">
			<h1><?php echo get_admin_page_title() ?></h1>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'rudr_slider_settings' ); // settings group name
					do_settings_sections( 'rudr_slider' ); // just a page slug
					submit_button(); // "Save Changes" button
				?>
			</form>
		</div>
        <?php
    }

    /**
     * Register settings and fields
     */
    public function rudr_settings_fields(){
    
        // I created variables to make the things clearer
        $page_slug = 'rudr_slider';
        $option_group = 'rudr_slider_settings';
    
        /**
         * Create section
         */
        add_settings_section(
            'rudr_section_id', // section ID
            '', // title (optional)
            '', // callback function to display the section (optional)
            $page_slug
        );
    

        /**
         * Register fields
         */
        register_setting( $option_group, 'slider_on', 'rudr_sanitize_checkbox' );
        register_setting( $option_group, 'num_of_slides', 'absint' );
    
        // 3. add fields
        add_settings_field(
            'slider_on',
            'Display slider',
            'rudr_checkbox', // function to print the field
            $page_slug,
            'rudr_section_id' // section ID
        );
    
        add_settings_field(
            'num_of_slides',
            'Number of slides',
            'rudr_number',
            $page_slug,
            'rudr_section_id',
            array(
                'label_for' => 'num_of_slides',
                'class' => 'hello', // for <tr> element
                'name' => 'num_of_slides' // pass any custom parameters
            )
        );
    
    }
    
    // custom callback function to print field HTML
    public function rudr_number( $args ){
        printf(
            '<input type="number" id="%s" name="%s" value="%d" />',
            $args[ 'name' ],
            $args[ 'name' ],
            get_option( $args[ 'name' ], 2 ) // 2 is the default number of slides
        );
    }
    // custom callback function to print checkbox field HTML
    public function rudr_checkbox( $args ) {
        $value = get_option( 'slider_on' );
        ?>
            <label>
                <input type="checkbox" name="slider_on" <?php checked( $value, 'yes' ) ?> /> Yes
            </label>
        <?php
    }
    
    // custom sanitization function for a checkbox field
    public function rudr_sanitize_checkbox( $value ) {
        return 'on' === $value ? 'yes' : 'no';
    }

    /**
     * Admin notices
     */
    public function rudr_notice() {
    
        if(
            isset( $_GET[ 'page' ] ) 
            && 'rudr_slider' == $_GET[ 'page' ]
            && isset( $_GET[ 'settings-updated' ] ) 
            && true == $_GET[ 'settings-updated' ]
        ) {
            ?>
                <div class="notice notice-success is-dismissible">
                    <p>
                        <strong>Slider settings saved.</strong>
                    </p>
                </div>
            <?php
        }
    
    }

}

new EpicJungle_Admin_Settings_Controller();