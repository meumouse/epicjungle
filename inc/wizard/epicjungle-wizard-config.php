<?php

/**
 * EpicJungle Wizard configuration file
 *
 * @package MeuMouse.com
 * @since 1.2.0
 */

if ( ! class_exists( 'EpicJungle_Wizard' ) ) {
	return;
}


/**
 * Disable PHP errors and warnings if any, and WP_DEBUG_DISPLAY is true in wp-config.php
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);


/**
 * Set directory locations, text strings, and settings.
 */
$wizard = new EpicJungle_Wizard(

	$config = array(
		'directory' => 'wizard', // Location / directory where EpicJungle_Wizard WP is placed in your theme.
		'epicjungle_wizard_url' => 'epicjungle-wizard', // The wp-admin page slug where EpicJungle_Wizard WP loads.
		'parent_slug' => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability' => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://docs.epicjunglewp.com.br/tema-filho/', // URL for the 'child-action-link'.
		'dev_mode' => true, // Enable development mode for testing.
		'license_step' => true, // EDD license activation step.
		'license_required' => false, // Require the license activation step.
		'license_help_url' => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url' => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name' => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug' => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => get_site_url(), // Link for the big button on the ready step.
	),

	$strings = array(
		'admin-menu' => esc_html__( 'Configuração do tema', 'epicjungle' ),
		'title%s%s%s%s' => esc_html__( '%1$s%2$s Temas &lsaquo; Configuração do tema: %3$s%4$s', 'epicjungle' ),
		'return-to-dashboard' => esc_html__( 'Retornar ao painel', 'epicjungle' ),
		'ignore' => esc_html__( 'Desativar o assistente', 'epicjungle' ),
		'btn-skip' => esc_html__( 'Pular', 'epicjungle' ),
		'btn-next' => esc_html__( 'Próximo', 'epicjungle' ),
		'btn-start' => esc_html__( 'Iniciar', 'epicjungle' ),
		'btn-no' => esc_html__( 'Cancelar', 'epicjungle' ),
		'btn-plugins-install' => esc_html__( 'Instalar', 'epicjungle' ),
		'btn-child-install' => esc_html__( 'Instalar', 'epicjungle' ),
		'btn-content-install' => esc_html__( 'Instalar', 'epicjungle' ),
		'btn-import' => esc_html__( 'Importar', 'epicjungle' ),
		'btn-license-activate' => esc_html__( 'Ativar', 'epicjungle' ),
		'btn-license-skip' => esc_html__( 'Depois', 'epicjungle' ),
		'license-header%s' => esc_html__( 'Ativar %s', 'epicjungle' ),
		'license-header-success%s' => esc_html__( '%s está ativo', 'epicjungle' ),
		'license%s' => esc_html__( 'Insira a chave de licença para habilitar os recursos Pro do tema.', 'epicjungle' ),
		'license-label' => esc_html__( 'Chave da licença', 'epicjungle' ),
		'license-success%s' => esc_html__( 'O tema já está registrado, então você pode ir para a próxima etapa!', 'epicjungle' ),
		'license-json-success%s' => esc_html__( 'Seu tema está ativado! Atualizações e suporte ao tema estão ativados.', 'epicjungle' ),
		'license-tooltip' => esc_html__( 'Precisa de ajuda?', 'epicjungle' ),
		'welcome-header%s' => esc_html__( 'Bem vindo ao %s', 'epicjungle' ),
		'welcome-header-success%s' => esc_html__( 'Olá! Bem vindo de volta', 'epicjungle' ),
		'welcome%s' => esc_html__( 'Este assistente irá configurar seu tema, instalar plugins e importar um conteúdo demonstrativo para te ajudar a se familiarizar com seu novo tema. É opcional e deve levar apenas alguns minutos.', 'epicjungle' ),
		'welcome-success%s' => esc_html__( 'Você pode já ter executado este assistente de configuração de tema. Se você quiser continuar de qualquer maneira, clique no botão "Iniciar" abaixo.', 'epicjungle' ),
		'child-header' => esc_html__( 'Instalar tema filho', 'epicjungle' ),
		'child-header-success' => esc_html__( 'Você está pronto para continuar!', 'epicjungle' ),
		'child' => esc_html__( 'Vamos criar e ativar um tema filho para que você possa facilmente fazer alterações no no código do tema.', 'epicjungle' ),
		'child-success%s' => esc_html__( 'Seu tema filho já foi instalado e agora está ativado, caso ainda não tenha sido.', 'epicjungle' ),
		'child-action-link' => esc_html__( 'O que é um tema filho?', 'epicjungle' ),
		'child-json-success%s' => esc_html__( 'Incrível. Seu tema filho já foi instalado e agora está ativado.', 'epicjungle' ),
		'child-json-already%s' => esc_html__( 'Incrível. Seu tema filho foi criado e agora está ativado.', 'epicjungle' ),
		'plugins-header' => esc_html__( 'Instalar plugins', 'epicjungle' ),
		'plugins-header-success' => esc_html__( 'Você está atualizado!', 'epicjungle' ),
		'plugins' => esc_html__( 'Vamos instalar alguns plugins essenciais do WordPress para que tudo funcione corretamente.', 'epicjungle' ),
		'plugins-success%s' => esc_html__( 'Os plugins necessários do WordPress estão todos instalados e atualizados. Pressione "Próximo" para continuar o assistente de configuração.', 'epicjungle' ),
		'plugins-action-link' => esc_html__( 'Avançado', 'epicjungle' ),
		'import-header' => esc_html__( 'Importar conteúdo demonstrativo', 'epicjungle' ),
		'import' => esc_html__( 'Vamos importar um conteúdo demonstrativo para seu site, para ajudar você a se familiarizar com o tema.', 'epicjungle' ),
		'import-action-link' => esc_html__( 'Avançado', 'epicjungle' ),
		'ready-header' => esc_html__( 'Tudo feito. Aproveite!', 'epicjungle' ),
		'ready%s' => esc_html__( 'Seu tema foi configurado. Aproveite seu novo tema desenvolvido por %s.', 'epicjungle' ),
		'ready-action-link' => esc_html__( 'Extras', 'epicjungle' ),
		'ready-big-button' => esc_html__( 'Veja seu site', 'epicjungle' ),
		'ready-link-1' => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://docs.epicjunglewp.com.br/', esc_html__( 'Ver documentação do tema', 'epicjungle' ) ),
		'ready-link-2' => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://epicjunglewp.com.br/suporte/', esc_html__( 'Obter suporte do tema', 'epicjungle' ) ),
		'ready-link-3' => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Iniciar personalização', 'epicjungle' ) ),
	)
);


/**
* Import Demo Content
*/
add_filter( 'epicjungle_wizard_import_files', 'epicjungle_wizard_local_import_files' );

function epicjungle_wizard_local_import_files() {
	return array(
		array(
			'import_file_name' => 'Conteúdo demonstrativo',
			'local_import_file' => get_parent_theme_file_path( '/assets/demo/content.xml' ),
			'local_import_widget_file' => get_parent_theme_file_path( '/assets/demo/widgets.wie' ),
			'local_import_customizer_file' => get_parent_theme_file_path( '/assets/demo/customizer.dat' ),
			'import_preview_image_url' => 'https://epicjunglewp.com.br/wp-content/uploads/2022/07/Banner-EpicJungle-1x1-1.png',
			'import_notice' => __( 'Alguns conteúdos demonstrativos para você se familiarizar com o tema.', 'epicjungle' ),
			'preview_url' => 'https://epicjunglewp.com.br/wp-content/uploads/2022/07/Banner-EpicJungle-1x1-1.png',
		),
	);
}
