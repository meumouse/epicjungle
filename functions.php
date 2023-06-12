<?php

/**
 * EpicJungle engine room
 *
 * @package epicjungle
 */

/**
 * Assign the EpicJungle version to a var
 */
$theme = wp_get_theme( 'epicjungle' );
$epicjungle_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 915; /* pixels */
}

$epicjungle = (object) array(
	'version'    => $epicjungle_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require get_template_directory() . '/inc/class-epicjungle.php',
	'customizer' => require get_template_directory() . '/inc/customizer/class-epicjungle-customizer.php',
);

if ( function_exists( 'wpforms' ) ) {
    require get_template_directory() . '/inc/wpforms/integration.php';

}

require get_template_directory() . '/inc/customizer/epicjungle-customizer-functions.php';

require get_template_directory() . '/inc/epicjungle-functions.php';
require get_template_directory() . '/inc/epicjungle-template-hooks.php';
require get_template_directory() . '/inc/epicjungle-template-functions.php';

/**
 * Menu Walker
 */
require get_template_directory() . '/inc/classes/class-wp-bootstrap-navwalker.php';

if ( epicjungle_is_woocommerce_activated() ) {
	$epicjungle->woocommerce            = require get_template_directory() . '/inc/woocommerce/class-epicjungle-woocommerce.php';
	$epicjungle->woocommerce_customizer = require get_template_directory() . '/inc/woocommerce/class-epicjungle-woocommerce-customizer.php';

	require get_template_directory() . '/inc/woocommerce/epicjungle-woocommerce-template-functions.php';
	require get_template_directory() . '/inc/woocommerce/epicjungle-woocommerce-function.php';
	require get_template_directory() . '/inc/woocommerce/epicjungle-woocommerce-template-hooks.php';
	require get_template_directory() . '/inc/woocommerce/epicjungle-wc-template-functions-overrides.php';
	require get_template_directory() . '/inc/woocommerce/integrations.php';
	require get_template_directory() . '/inc/core.php';
	require get_template_directory() . '/inc/epicjungle-functions-display.php';
	require get_template_directory() . '/shortcodes/profile-photo.php';
	
}
	
if ( function_exists( 'epicjungle_is_jetpack_activated' ) && epicjungle_is_jetpack_activated() ) {
	require get_template_directory() . '/inc/jetpack/epicjungle-jetpack-functions.php';
}

if ( epicjungle_is_wedocs_activated() ) {

	$epicjungle->wedocs_customizer    = require get_template_directory() . '/inc/wedocs/class-epicjungle-wedocs-customizer.php';

	require get_template_directory() . '/inc/wedocs/epicjungle-wedocs-template-hooks.php';
	require get_template_directory() . '/inc/wedocs/epicjungle-wedocs-template-functions.php';
	require get_template_directory() . '/inc/wedocs/epicjungle-wedocs-functions.php';
}

/**
 * TGM Plugin Activation class.
 */
require get_template_directory() . '/inc/classes/class-tgm-plugin-activation.php';

if ( is_admin() ) {
    require get_template_directory() . '/inc/classes/class-epicjungle-post-taxonomies.php';
}

if ( epicjungle_is_ocdi_activated() ) {
    $epicjungle->ocdi = require get_template_directory() . '/inc/ocdi/class-epicjungle-ocdi.php';
}

if ( is_admin() ) {
    $epicjungle->admin = require get_template_directory() . '/inc/admin/class-epicjungle-admin.php';
    require get_template_directory(). '/inc/admin/class-epicjungle-plugin-install.php';
}


require get_template_directory() . '/inc/classes/class-epicjungle-walker-comment.php';


/**
 * Functions used for EpicJungle Custom Theme Color
 */
require get_template_directory() . '/inc/epicjungle-custom-color-functions.php';


/**
 * EpicJungle Wizard
 */
require get_template_directory() . '/inc/wizard/vendor/autoload.php';
require get_template_directory() . '/inc/wizard/class-epicjungle-wizard.php';
require get_template_directory() . '/inc/wizard/epicjungle-wizard-config.php';

/**
 * EpicJungle Engine License
 */
require get_template_directory() . '/inc/updater/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker( 'https://raw.githubusercontent.com/meumouse/epicjungle/main/update-checker-epicjungle-wp.json', __FILE__, 'epicjungle' );