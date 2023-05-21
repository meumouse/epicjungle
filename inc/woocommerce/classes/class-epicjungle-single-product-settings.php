<?php 

/**
 * EpicJungle Settings in WooCommerce Single Product Class
 *
 * @package  epicjungle
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; }

class EpicJungle_Single_Product_Settings {

	public function __construct() {
		add_filter( 'woocommerce_get_sections_products', array( $this, 'add_section' ), 10, 1 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'get_settings' ), 10, 2 );
	}

	public function add_section( $sections ) {
		$sections['ejsp'] = __( 'Produto individual', 'epicjungle' );
		return $sections;
	}

	public function get_settings( $settings, $current_section ) {
		if ( 'ejsp' == $current_section ) {
	
		  $epicjungle_single_product_settings = array(
			array(
				'name' => __( 'Configurações do tema na página de produto individual', 'epicjungle' ),
				'type' => 'title',
				'id' => 'ejsp',
			),
	
			array(
				'title'   => __( 'Exibir quantidade vendida do produto?', 'epicjungle' ),
				'desc'    => __( 'Se ativo, irá exibir o emblema de quantidade de vendas do produto.', 'epicjungle' ),
				'id'      => 'ej_display_sale_badge',
				'class'   => 'toggle-switch',
				'default' => 'yes',
				'type'    => 'checkbox'
			),
	
			array(
				'title'   => __( 'Exibir botão comprar agora?', 'epicjungle' ),
				'desc'    => __( 'Se ativo, irá exibir o botão comprar agora na página do produto.', 'epicjungle' ),
				'id'      => 'ej_display_buy_now',
				'class'   => 'toggle-switch',
				'default' => 'yes',
				'type'    => 'checkbox'
			),

			array(
				'title'   => __( 'Exibir calculadora de frete?', 'epicjungle' ),
				'desc'    => __( 'Se ativo, irá exibir a calculadora de frete na página do produto.', 'epicjungle' ),
				'id'      => 'ejsp_show_calculator',
				'class'   => 'toggle-switch',
				'default' => 'no',
				'type'    => 'checkbox'
			),
/*
			array(
				'title'   => __( 'Exibir emblema de frete grátis por valor mínimo?', 'epicjungle' ),
				'desc'    => __( 'Se ativo, irá exibir emblema de frete grátis página do produto e arquivos, quando o valor do produto for superior ao valor mínimo do pedido.', 'epicjungle' ),
				'id'      => 'ejsp_display_free_shipping_badge_min_value',
				'class'   => 'toggle-switch',
				'default' => 'yes',
				'type'    => 'checkbox'
			),*/

			array(
				'title'   => __( 'Ocultar outros métodos de envio se frete grátis estiver disponível?', 'epicjungle' ),
				'desc'    => __( 'Se ativo, irá ocultar outros métodos de envio se frete grátis estiver disponível.', 'epicjungle' ),
				'id'      => 'ejsp_hide_shipping_methods_if_free_shipping_available',
				'class'   => 'toggle-switch',
				'default' => 'yes',
				'type'    => 'checkbox'
			),

			array(
				'title'   => __( 'Exibir prazo de garantia?', 'epicjungle' ),
				'desc'    => __( 'Se ativo, irá exibir o prazo de garantia na página do produto.', 'epicjungle' ),
				'id'      => 'ejsp_show_warranty_term',
				'class'   => 'toggle-switch',
				'default' => 'yes',
				'type'    => 'checkbox'
			),

			array(
				'title'    => __( 'Prazo de garantia', 'epicjungle' ),
				'desc'     => __( 'Defina o prazo para garantia dos produtos, o prazo mínimo recomendado é de 90 dias.', 'epicjungle' ),
				'id'       => 'ejsp_warranty_single_product',
				'class'    => 'form-control',
				'type'     => 'text',
				'default'  => __( '90 dias', 'epicjungle' ),
          		'css'      => 'width: 250px;',
				'autoload' => false,
				'desc_tip' => true
			),

			array(
				'title'   => __( 'Exibir prazo de devoluções?', 'epicjungle' ),
				'desc'    => __( 'Se ativo, irá exibir o prazo de devoluções na página do produto.', 'epicjungle' ),
				'id'      => 'ejsp_show_return_term',
				'class'   => 'toggle-switch',
				'default' => 'yes',
				'type'    => 'checkbox'
			),

			array(
				'title'    => __( 'Prazo de devoluções', 'epicjungle' ),
				'desc'     => __( 'Defina o prazo para devolução dos produtos, o prazo recomendado é de 7 dias.', 'epicjungle' ),
				'id'       => 'ejsp_return_single_product',
				'class'    => 'form-control',
				'type'     => 'text',
				'default'  => __( '7 dias', 'epicjungle' ),
          		'css'      => 'width: 250px;',
				'autoload' => false,
				'desc_tip' => true
			),
	
			array(
				'type' => 'sectionend',
				'id' => 'ejsp'
			),
		  );
	
		  return apply_filters( 'epicjungle_single_product_settings', $epicjungle_single_product_settings );
		} 
	
		else {
		  return $settings;
		}
	  }
}

new EpicJungle_Single_Product_Settings();