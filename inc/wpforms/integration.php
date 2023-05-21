<?php
/**
 * WP Forms Integration
 *
 */
add_filter( 'transient_wpforms_activation_redirect', '__return_false' );

add_filter( 'wpforms_field_properties', 'epicjungle_wpforms_field_properties', 10, 3 );

add_filter( 'wpforms_field_properties_text', 'epicjungle_wpforms_inputs_properties', 10, 3 );
add_filter( 'wpforms_field_properties_textarea', 'epicjungle_wpforms_inputs_properties', 10, 3 );
add_filter( 'wpforms_field_properties_number', 'epicjungle_wpforms_inputs_properties', 10, 3 );
add_filter( 'wpforms_field_properties_email', 'epicjungle_wpforms_inputs_properties', 10, 3 );
add_filter( 'wpforms_field_properties_select', 'epicjungle_wpforms_select_properties', 10, 3 );
add_filter( 'wpforms_field_properties_name', 'epicjungle_wpforms_name_properties', 10, 3 );

add_filter( 'wpforms_field_properties_checkbox', 'epicjungle_wpforms_check_properties', 10, 3 );
add_filter( 'wpforms_field_properties_radio', 'epicjungle_wpforms_check_properties', 10, 3 );

add_filter( 'wpforms_frontend_form_atts', 'epicjungle_wpforms_frontend_form_atts', 10, 2 );

add_action( 'wpforms_form_settings_general',  'epicjungle_wpforms_settings_general', 10, 1 );

add_action( 'wpforms_display_fields_before', 'epicjungle_wpforms_row_start', 10 );
add_action( 'wpforms_display_fields_after', 'epicjungle_wpforms_row_end', 10 );

function epicjungle_wpforms_radio_properties( $properties, $field, $form_data ) {
    return $properties;
}

function epicjungle_wpforms_check_properties( $properties, $field, $form_data ) {

    if ( isset( $field['button_toggle'] ) && $field['button_toggle'] == '1' ) {
        $properties['input_container']['class'][] = 'list-unstyled';
        $properties['input_container']['class'][] = 'btn-group-toggle';
        $properties['label']['class'][] = 'h6';
        $properties['label']['class'][] = 'pb-2';

        if ( isset( $field['is_dark'] ) && $field['is_dark'] == '1' ){
            $properties['label']['class'][] = 'text-light';
        }

        foreach( $properties['inputs'] as $key => $input ) {
            unset( $properties['inputs'][$key]['label']['class'] );
            if ( isset( $field['is_dark'] ) && $field['is_dark'] == '1' ){
                $properties['inputs'][$key]['label']['class'] = [ 'btn', 'btn-outline-light' ];
            } else {
                $properties['inputs'][$key]['label']['class'] = [ 'btn', 'btn-outline-primary' ];
            }
            $properties['inputs'][$key]['class'][] = 'form-check-input';
            $properties['inputs'][$key]['class'][] = 'visually-hidden';
            $properties['inputs'][$key]['class'][] = 'sr-only';
        }
    } else {
        $properties['input_container']['class'][] = 'list-unstyled';
        foreach( $properties['inputs'] as $key => $input ) {
            $properties['inputs'][$key]['container']['class'][] = 'form-group';
            $properties['inputs'][$key]['container']['class'][] = 'form-check';
            $properties['inputs'][$key]['label']['class'][] = 'form-check-label';
            $properties['inputs'][$key]['class'][] = 'form-check-input';
        }
    }

    
    return $properties;
}

function epicjungle_wpforms_field_properties( $properties, $field, $form_data ) {
    $properties = epicjungle_wpforms_label_properties( $properties, $field, $form_data );
    $properties = epicjungle_wpforms_container_properties( $properties, $field, $form_data );
    $properties = epicjungle_wpforms_field_description_properties( $properties, $field, $form_data );
    $properties = epicjungle_wpforms_error_properties( $properties, $field, $form_data );
    
    return $properties;
}

function epicjungle_wpforms_error_properties( $properties, $field, $form_data ) {
    $error_classes = $properties['error']['class'];
    foreach( $error_classes as $error_class ) {
        switch( $error_class ) {
            case 'wpforms-error':
                $properties['error']['class'][] = 'is-invalid';
            break;
        }
    }
    return $properties;
}

function epicjungle_wpforms_field_description_properties( $properties, $field, $form_data ) {
    $desc_classes = $properties['description']['class'];

    foreach( $desc_classes as $desc_class ) {
        switch( $desc_class ) {
            case 'wpforms-field-description':
                $properties['description']['class'][] = 'form-text';
                $properties['description']['class'][] = 'text-muted';
                $properties['description']['class'][] = 'small';
            break;
        }
    }

    return $properties;
}

function epicjungle_wpforms_label_properties( $properties, $field, $form_data ) {
    $label_classes = $properties['label']['class'];

    foreach( $label_classes as $label_class ) {
        switch( $label_class ) {
            case 'wpforms-label-hide':
                $properties['label']['class'][] = 'sr-only';
            break;
            
        }
    }

    return $properties;
}

function epicjungle_wpforms_container_properties( $properties, $field, $form_data ) {
    $properties['container']['class'][] = 'form-group';
    
    return $properties;
}


function epicjungle_wpforms_inputs_properties( $properties, $field, $form_data ) {
    $properties['inputs']['primary']['class'][] = 'form-control';
    if ( 'textarea' === $field['type'] ) {
        $properties['inputs']['primary']['attr']['rows'] = '5';
    }


    return $properties;
}

function epicjungle_wpforms_select_properties( $properties, $field, $form_data ) {
    $properties['input_container']['class'][] = 'custom-select';
    return $properties;
}

function epicjungle_wpforms_name_properties( $properties, $field, $form_data ) {
    $properties['container']['class'][] = 'form-group';

    foreach( $properties['inputs'] as $key => $input ) {
        $properties['inputs'][$key]['class'][] = 'form-control';

    }
   
   
    return $properties;
}


function epicjungle_wpforms_frontend_form_atts( $form_atts, $form_data ) {
    if( isset( $form_data['settings']['enable'] ) && isset( $form_data['settings']['enable']['make_row'] ) && !empty( $form_data['settings']['enable']['make_row'] ) ){
        $form_atts['class'][]="d-flex";
    }

    return $form_atts;
}

if ( ! function_exists( 'epicjungle_wpforms_settings_general' ) ) {

    function epicjungle_wpforms_settings_general( $settings ) {  

        wpforms_panel_field (
            'checkbox',
            'enable',
            'make_row',
            $settings->form_data,
            esc_html__( 'Enable Form Row', 'epicjungle' ),
            array(
                'class'       => 'wpforms-panel-field-enable-make_row-wrap',
                'input_class' => 'wpforms-panel-field-enable-make_row',
                'parent'      => 'settings',

            )
        );
    }
}

function epicjungle_wpforms_row_start() {
    ?><div class="row"><?php
}

function epicjungle_wpforms_row_end() {
    ?></div><?php
}

add_action( 'wpforms_field_options_bottom_advanced-options', 'epicjungle_button_toggle_radio', 10, 2 );

function epicjungle_button_toggle_radio( $field, $instance ) {
    if ( 'radio' === $field['type'] ) {
        $instance->field_element(
            'row',
            $field,
            array(
                'slug'    => 'button_toggle',
                'content' => $instance->field_element(
                    'checkbox',
                    $field,
                    array(
                        'slug'    => 'button_toggle',
                        'value'   => isset( $field['button_toggle'] ) ? '1' : '0',
                        'desc'    => esc_html__( 'Button Toggle?', 'epicjungle' ),
                        'tooltip' => esc_html__( 'Check this option to use buttons for radio buttons.', 'epicjungle' ),
                    ),
                    false
                ),
            )
        );

        $instance->field_element(
            'row',
            $field,
            array(
                'slug'    => 'is_dark',
                'content' => $instance->field_element(
                    'checkbox',
                    $field,
                    array(
                        'slug'    => 'is_dark',
                        'value'   => isset( $field['is_dark'] ) ? '1' : '0',
                        'desc'    => esc_html__( 'Is Dark?', 'epicjungle' ),
                        'tooltip' => esc_html__( 'Check this option to change button classes in Dark Background. ( This option will work when Button Toggle option enabled )', 'epicjungle' ),
                    ),
                    false
                ),
            )
        );
    }
}