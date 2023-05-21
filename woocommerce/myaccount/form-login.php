<?php
/**
* Login Form
*
* This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see     https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce\Templates
* @version 7.0.1
*/

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly.
}

$is_registration_enabled = false;

if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ){
	$is_registration_enabled = true;

}


$account_style = apply_filters( 'epicjungle_my_account_style', get_theme_mod( 'myaccount_style', 'style-v3' ) );


$epicjungle_login_form_title            = apply_filters( 'epicjungle_login_title',          get_theme_mod('login_title',    'Entrar' ) );
$epicjungle_login_form_desc             = apply_filters( 'epicjungle_login_description',    get_theme_mod('login_desc',     'Entre em sua conta usando o e-mail e a senha fornecidos durante o registro.'));
$epicjungle_register_form_title         = apply_filters( 'epicjungle_register_title',       get_theme_mod('register_title', 'Registrar-se') );
$epicjungle_register_form_desc          = apply_filters( 'epicjungle_register_description', get_theme_mod('register_desc',  'O registro leva menos de um minuto, mas oferece controle total sobre seus pedidos.'));
$epicjungle_login_heading_alignment     = apply_filters( 'epicjungle_login_heading_alignment', get_theme_mod( 'login_heading_alignment', 'text-left' ) );
$epicjungle_register_heading_alignment  = apply_filters( 'epicjungle_register_heading_alignment', get_theme_mod( 'register_heading_alignment', 'text-left' ) );
$epicjungle_form_footer_alignment       = apply_filters( 'epicjungle_form_footer_alignment', get_theme_mod( 'form_footer_alignment', 'text-left' ) );


if ( $account_style == 'style-v3' ) {
	$container_additional_classes = 'd-flex align-items-center pt-7 pb-3 pb-md-4';
	$title_class                  = 'h2';
	$desc_class                   ='font-size-ms text-muted mb-4';
} elseif ( $account_style == 'style-v2' ) {
	$container_additional_classes = 'd-flex justify-content-center align-items-center pt-7 pb-4';
	$title_class                  = 'h2';
	$desc_class                   ='font-size-ms text-muted mb-4';
} else {
	$container_additional_classes = 'sigin-container py-5 py-md-7';
	$title_class                  = 'h3 pt-1';
	$desc_class                   ='font-size-ms text-muted';
} 

if ( $account_style == 'style-v3' && (int) get_theme_mod( 'myaccount_image') > 0 ) : ?>
	<div class="d-none d-md-block position-absolute w-50 h-100 bg-size-cover" style="top: 0; right:0; background-image: url( <?php echo( wp_get_attachment_image_url( get_theme_mod( 'myaccount_image' ), 'full' ) ); ?> );">
	</div>
<?php endif; ?>

<section class="<?php echo esc_attr( $container_additional_classes ); ?>" style="flex: 1 0 auto;">
	<?php

	if ( $account_style == 'style-v3' ) {
		?>
		<div class="w-100 pt-3">
			<div class="row">
			<?	if ( $account_style == 'style-v3' && (int) get_theme_mod( 'myaccount_image') == 0 ) { ?>

				<div class="col-md-6 col-lg-5 p-sm-5">
				<svg id="placeholder-myaccount" data-name="placeholder myaccount" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 405.86 393.86">
					<defs>
						<clipPath id="clip-path" transform="translate(-44.73 -43.82)">
						<polygon points="122.68 213.83 89.75 203.08 86.82 195.34 80.13 195.13 67.99 192.83 69.45 195.34 84.73 206.43 88.5 208.31 122.94 226.3 122.68 213.83" style="fill:none" />
						</clipPath>
						<clipPath id="clip-path-2" transform="translate(-44.73 -43.82)">
						<polygon points="86.82 195.34 83.68 193.46 77.41 195.76 78.45 197.01 86.82 195.34" style="fill:none" />
						</clipPath>
						<clipPath id="clip-path-3" transform="translate(-44.73 -43.82)">
						<path d="M129.67,144.06s-.51,4.5.76,7.39,8.32,12.68,8.32,12.68l-13.16,10.55s-5.46-11-6.5-12.78-2.29-9.44,1.1-14.93S128.46,140,129.67,144.06Z" style="fill:none" />
						</clipPath>
						<clipPath id="clip-path-4" transform="translate(-44.73 -43.82)">
						<path d="M133.75,135.82c-.81-5-6.54-15.17-15.63-14.78-5.9.26-8.66,1.45-11.22,2.9a32.73,32.73,0,0,0-5.8,4.34c-4.44,5.33-6,6.79-5.14,10.87a12.17,12.17,0,0,0,.75,4.78c1.36,3.63,2.29,6,3.47,7.73-.36,1.69-1.3,6.15-1.35,7.17s3,.31,4.54-.08c2.86,6.4,8.1,10.84,9.73,11.35,2.84.89,7.33-3.78,9.71-7.4s.58-7.69.59-9.31,5.35-5.18,7.33-6.31S134.55,140.81,133.75,135.82Z" style="fill:none" />
						</clipPath>
						<clipPath id="clip-path-5" transform="translate(-44.73 -43.82)">
						<path d="M144.65,171.54s7.09,4.83,7.25,16.24c.07,5-.45,9.67-1.6,17.86s-8.29,34.86-13.85,38.1-14.19-2.88-14.19-2.88L80.52,213.15,70.43,205l-5-9.44,1.57-3L79.31,202l-6.63-6.13,1.3-1.65,2.4,1.67,7,2.62,1.53,10L87.07,210,127,224.58s-.5-21.49-.13-25.6.88-14.44,5.28-21.93" style="fill:none" />
						</clipPath>
					</defs>
					<g id="epicjungle--background-simple--inject-1--inject-2" class="placeholder-my-account">
						<path d="M409.13,103c-24.88-56.73-84.6-78.09-131.72-40C259,77.86,247.53,101.51,225,111c-21.14,8.9-47.92,6.28-70.78,11.1C105.54,132.3,40,171,45,230.63c2.19,26.12,19.81,55.13,28.52,79.57,10,28.12,16,63.3,42.47,80.11,45.38,28.86,100.12,5.27,141-18,22-12.51,34.11-20.2,57.8-15.91,21.93,4,41.68,18,63.11,1.39,16.09-12.47,17.42-37.74,30.93-52.58,15.22-16.72,30.65-17.93,38.56-43.06,9.59-30.49-4.54-49.54-14.09-76.78S420.85,129.69,409.13,103Z" transform="translate(-44.73 -43.82)"/>
						<g style="opacity:0.699999988079071">
						<path d="M409.13,103c-24.88-56.73-84.6-78.09-131.72-40C259,77.86,247.53,101.51,225,111c-21.14,8.9-47.92,6.28-70.78,11.1C105.54,132.3,40,171,45,230.63c2.19,26.12,19.81,55.13,28.52,79.57,10,28.12,16,63.3,42.47,80.11,45.38,28.86,100.12,5.27,141-18,22-12.51,34.11-20.2,57.8-15.91,21.93,4,41.68,18,63.11,1.39,16.09-12.47,17.42-37.74,30.93-52.58,15.22-16.72,30.65-17.93,38.56-43.06,9.59-30.49-4.54-49.54-14.09-76.78S420.85,129.69,409.13,103Z" transform="translate(-44.73 -43.82)" style="fill:#fff" />
						</g>
					</g>
					<g id="epicjungle--Shadow--inject-1--inject-2" class="placeholder-my-account">
						<ellipse cx="175.08" cy="384.23" rx="154.58" ry="9.63"/>
						<ellipse cx="175.08" cy="384.23" rx="154.58" ry="9.63" style="fill:#fff;opacity:0.800000011920929;isolation:isolate" />
					</g>
					<g id="epicjungle--Device--inject-1--inject-2" class="placeholder-my-account">
						<rect x="116.38" y="18.04" width="194.29" height="367" rx="19.43" style="fill:#263238" />
						<rect x="125.01" y="58.34" width="177.02" height="286.4" style="fill:#fff;stroke:#263238;stroke-miterlimit:10;stroke-width:1.3373899459838867px" />
						<circle cx="213.52" cy="147.18" r="38.37"/>
						<path d="M308.63,370.55H207.89a1.72,1.72,0,0,1-1.73-1.71h0a1.72,1.72,0,0,1,1.71-1.73H308.63a1.72,1.72,0,0,1,1.72,1.72h0a1.72,1.72,0,0,1-1.72,1.72Z" transform="translate(-44.73 -43.82)"/>
						<rect x="155.86" y="207.12" width="115.33" height="20.67" rx="4.01"/>
						<rect x="155.86" y="245.78" width="115.33" height="20.67" rx="4.01"/>
						<path d="M277.36,210.14l-11.29-6.5v-5.37a17.74,17.74,0,0,0,3.47-6.77,3.58,3.58,0,0,0,1.21.21c1.4,0,2.29-4.34,2.44-7.44,1.63-3.45-.59-5.47-.59-5.47s.92-.92,1.53-4.61-2.15-2.15-4.3-5.53-3.69-7.06-10.75-7.06a9.71,9.71,0,0,0-9.22,5.84,23.49,23.49,0,0,0-5.22.61c-2.16.61-2.77,7.68-.93,10.45a10.61,10.61,0,0,1,1.28,4.93c-.49-.6-1-.76-1.28.6-.61,3.07,1.85,7.37,1.85,7.37l1.27-.36a18,18,0,0,0,3.61,7.23v5.37l-11.29,6.5a8.68,8.68,0,0,0-4.34,7.51v3.72a38.34,38.34,0,0,0,46.89,0v-3.72A8.66,8.66,0,0,0,277.36,210.14Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M215.2,305.13a1,1,0,0,1-.69-.29.93.93,0,0,1-.31-.7.92.92,0,0,1,.15-.51l1.8-2.88-3.51.11a.92.92,0,0,1-.72-.27,1,1,0,0,1,0-1.33.89.89,0,0,1,.72-.28l3.46.13-1.78-2.87a1,1,0,0,1-.15-.52.93.93,0,0,1,.31-.7,1,1,0,0,1,.69-.29.89.89,0,0,1,.81.52l1.71,3.09,1.69-3.07a1,1,0,0,1,.87-.56.89.89,0,0,1,.67.3,1,1,0,0,1,.28.71,1.05,1.05,0,0,1-.13.49l-1.81,2.9,3.51-.13a.89.89,0,0,1,.72.28,1,1,0,0,1,.26.66,1,1,0,0,1-.26.67.92.92,0,0,1-.72.27l-3.53-.11L221,303.6a1,1,0,0,1,.15.53,1,1,0,0,1-1,1,.88.88,0,0,1-.8-.54l-1.67-3-1.66,3A.94.94,0,0,1,215.2,305.13Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M231.42,305.13a1,1,0,0,1-.69-.29.93.93,0,0,1-.31-.7.92.92,0,0,1,.15-.51l1.8-2.88-3.5.11a1,1,0,0,1-.73-.27,1,1,0,0,1,.73-1.61l3.45.13-1.78-2.87a1,1,0,0,1-.15-.52.93.93,0,0,1,.31-.7,1,1,0,0,1,.69-.29.89.89,0,0,1,.81.52l1.71,3.09,1.69-3.07a1,1,0,0,1,.87-.56.89.89,0,0,1,.67.3,1,1,0,0,1,.29.71,1,1,0,0,1-.14.49l-1.81,2.9L239,299a.86.86,0,0,1,.71.28,1,1,0,0,1,.26.66,1,1,0,0,1-.26.67.91.91,0,0,1-.71.27l-3.54-.11,1.76,2.85a1,1,0,0,1,.15.53,1,1,0,0,1-1,1,.88.88,0,0,1-.8-.54l-1.67-3-1.66,3A1,1,0,0,1,231.42,305.13Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M247.65,305.13a1,1,0,0,1-.7-.29.93.93,0,0,1-.31-.7.92.92,0,0,1,.15-.51l1.8-2.88-3.5.11a1,1,0,0,1-1-.91,1,1,0,0,1,.26-.69,1,1,0,0,1,.73-.28l3.45.13-1.78-2.87a1,1,0,0,1-.15-.52,1,1,0,0,1,.31-.7,1,1,0,0,1,.7-.29.92.92,0,0,1,.8.52l1.71,3.09,1.69-3.07a1,1,0,0,1,.87-.56.89.89,0,0,1,.67.3,1,1,0,0,1,.29.71,1,1,0,0,1-.14.49l-1.81,2.9,3.52-.13a.91.91,0,0,1,1,.81v.13a1,1,0,0,1-.25.67.92.92,0,0,1-.72.27l-3.53-.11,1.75,2.85a1,1,0,0,1,.15.53,1,1,0,0,1-.31.7.93.93,0,0,1-.68.3.87.87,0,0,1-.79-.54l-1.68-3-1.66,3A.94.94,0,0,1,247.65,305.13Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M263.87,305.13a1,1,0,0,1-.7-.29,1,1,0,0,1-.3-.7,1,1,0,0,1,.14-.51l1.8-2.88-3.5.11a1,1,0,0,1-.73-.27.95.95,0,0,1,.73-1.61l3.46.13L263,296.24a1,1,0,0,1-.15-.52,1,1,0,0,1,.31-.7,1,1,0,0,1,.7-.29.89.89,0,0,1,.81.52l1.7,3.09,1.69-3.07a1,1,0,0,1,.87-.56.89.89,0,0,1,.67.3,1,1,0,0,1,.29.71,1,1,0,0,1-.14.49l-1.81,2.9,3.52-.13a.91.91,0,0,1,1,.81v.13a1,1,0,0,1-.25.67.92.92,0,0,1-.72.27l-3.53-.11,1.75,2.85a1,1,0,0,1,.15.53,1,1,0,0,1-1,1,.87.87,0,0,1-.79-.54l-1.68-3-1.66,3A.93.93,0,0,1,263.87,305.13Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M280.09,305.13a1,1,0,0,1-.7-.29,1,1,0,0,1-.15-1.21l1.79-2.88-3.5.11a1,1,0,0,1-.73-.27.95.95,0,0,1,.73-1.61l3.46.13-1.78-2.87a1,1,0,0,1,.15-1.22,1,1,0,0,1,.7-.29.89.89,0,0,1,.81.52l1.7,3.09,1.69-3.07a1,1,0,0,1,.87-.56.92.92,0,0,1,.68.3,1,1,0,0,1,.28.71,1,1,0,0,1-.14.49l-1.81,2.9,3.52-.13a.91.91,0,0,1,1,.81v.13a1,1,0,0,1-.25.67.92.92,0,0,1-.72.27l-3.53-.11,1.75,2.85a1,1,0,0,1,.15.53,1,1,0,0,1-1,1,.87.87,0,0,1-.79-.54l-1.68-3-1.66,3A.94.94,0,0,1,280.09,305.13Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M296.31,305.13a1,1,0,0,1-.69-.29.93.93,0,0,1-.31-.7.92.92,0,0,1,.15-.51l1.79-2.88-3.5.11a.94.94,0,0,1-1-.86v-.08a1,1,0,0,1,.27-.66.89.89,0,0,1,.72-.28l3.46.13-1.78-2.87a1,1,0,0,1,.15-1.22,1,1,0,0,1,.7-.29.89.89,0,0,1,.81.52l1.7,3.09,1.7-3.07a1,1,0,0,1,.86-.56.92.92,0,0,1,.68.3,1,1,0,0,1,.28.71,1.05,1.05,0,0,1-.13.49l-1.81,2.9,3.51-.13a.89.89,0,0,1,.72.28,1,1,0,0,1,.26.66,1,1,0,0,1-.26.67.92.92,0,0,1-.72.27l-3.53-.11,1.75,2.85a1,1,0,0,1,.15.53,1,1,0,0,1-.3.7,1,1,0,0,1-.69.3.87.87,0,0,1-.79-.54l-1.68-3-1.66,3A.93.93,0,0,1,296.31,305.13Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<rect x="125.01" y="58.72" width="177.02" height="11.09"/>
						<path d="M277.5,82.11H239a2.62,2.62,0,0,1-2.62-2.62h0A2.62,2.62,0,0,1,239,76.87h38.5a2.62,2.62,0,0,1,2.62,2.62h0A2.62,2.62,0,0,1,277.5,82.11Z" transform="translate(-44.73 -43.82)";stroke:#263238;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.3373899459838867px" />
						<path d="M268.75,404.74a10.5,10.5,0,1,0-10.51,10.49h0A10.51,10.51,0,0,0,268.75,404.74Z" transform="translate(-44.73 -43.82)"/>
						<rect x="208.21" y="355.6" width="10.64" height="10.64";stroke:#263238;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.3373899459838867px" />
					</g>
					<g id="epicjungle--Plant--inject-1--inject-2" class="placeholder-my-account">
						<path d="M385,284s-13.94-35.42-1.53-39.63c12.92-4.39,12.35,19,11.85,30.4-1.05,24.36-3.74,28.89-5.75,22.94Zm-4.19,27.63c3.83,5,4.91-.18-2-23.57-3.24-11-10.28-33.25-21.08-24.9-10.37,8,14.31,37,14.31,37Zm-7.4,20.3c3.65,3.24,3.72-.85-5-17.74-4.07-7.91-12.68-23.92-19.73-16C342,305.83,365,324.4,365,324.4Zm-8,24.14c3.65,3.25,3.72-.85-5-17.73-4.07-7.91-12.68-23.93-19.73-16C334,330,357,348.57,357,348.57Zm23.1-49.14c-5.84,2.28-1.2,4.76,23.19,4.69,11.44,0,34.8-.52,29.82-13.23-4.77-12.21-39.51,3.34-39.51,3.34Zm-6.65,16.24c-6.18,1.07-2.12,4.43,21.8,9.21,11.21,2.25,34.2,6.4,31.85-7-2.25-12.92-39.39-4.58-39.39-4.58ZM374.42,343c-5.26.76-1.9,3.69,18.21,8.29,9.43,2.16,28.78,6.21,27.1-5.22-1.6-11-33.2-4.78-33.2-4.78Zm-5.65,18.37c-5.15,1.31-1.5,3.87,19,6.31,9.6,1.14,29.27,3.12,26.4-8.07-2.77-10.74-33.53-1.23-33.53-1.23ZM398.91,287c-3,6.72,3.23,5.7,24.41-12.78,9.92-8.67,29.82-26.81,14.06-35.84-15.13-8.68-31.4,33.2-31.4,33.2Zm-29.36,98.3c-3.17,1.85-.06,2.57,14.48-.33,6.82-1.35,20.69-4.35,16-10.27-4.54-5.7-23.14,6.3-23.14,6.3Z" transform="translate(-44.73 -43.82)"/>
						<path d="M385,284s-13.94-35.42-1.53-39.63c12.92-4.39,12.35,19,11.85,30.4-1.05,24.36-3.74,28.89-5.75,22.94Zm-4.19,27.63c3.83,5,4.91-.18-2-23.57-3.24-11-10.28-33.25-21.08-24.9-10.37,8,14.31,37,14.31,37Zm-7.4,20.3c3.65,3.24,3.72-.85-5-17.74-4.07-7.91-12.68-23.92-19.73-16C342,305.83,365,324.4,365,324.4Zm-8,24.14c3.65,3.25,3.72-.85-5-17.73-4.07-7.91-12.68-23.93-19.73-16C334,330,357,348.57,357,348.57Zm23.1-49.14c-5.84,2.28-1.2,4.76,23.19,4.69,11.44,0,34.8-.52,29.82-13.23-4.77-12.21-39.51,3.34-39.51,3.34Zm-6.65,16.24c-6.18,1.07-2.12,4.43,21.8,9.21,11.21,2.25,34.2,6.4,31.85-7-2.25-12.92-39.39-4.58-39.39-4.58ZM374.42,343c-5.26.76-1.9,3.69,18.21,8.29,9.43,2.16,28.78,6.21,27.1-5.22-1.6-11-33.2-4.78-33.2-4.78Zm-5.65,18.37c-5.15,1.31-1.5,3.87,19,6.31,9.6,1.14,29.27,3.12,26.4-8.07-2.77-10.74-33.53-1.23-33.53-1.23ZM398.91,287c-3,6.72,3.23,5.7,24.41-12.78,9.92-8.67,29.82-26.81,14.06-35.84-15.13-8.68-31.4,33.2-31.4,33.2Zm-29.36,98.3c-3.17,1.85-.06,2.57,14.48-.33,6.82-1.35,20.69-4.35,16-10.27-4.54-5.7-23.14,6.3-23.14,6.3Z" transform="translate(-44.73 -43.82)" style="fill:#fff;opacity:0.30000001192092896;isolation:isolate" />
						<path d="M391.15,300.49l-2.43-40.43m-5.26,53.77L368.1,279.06m55,24.66L386.29,309M375.5,332.57,355.57,307M379,324.73l27.46,1.38m-34,18.23,21,2.08M367.43,356.8,357,341.11m9.23,21.23,24.69.23m-29.69,46.09a.64.64,0,0,0,.58-.67c-1.57-23.58,7.55-62.2,22.18-93.9,9.35-20.26,46-60.08,46.39-60.48a.63.63,0,0,0-.88-.89h0c-.37.4-37.17,40.37-46.6,60.81C368,346,359,383.92,360.6,408.07A.64.64,0,0,0,361.23,408.66Zm29.91-107.55a.63.63,0,0,0,.59-.66L389.34,260a.62.62,0,0,0-.65-.59h0a.63.63,0,0,0-.59.66l2.43,40.43a.62.62,0,0,0,.62.59Zm-7.46,13.29a.64.64,0,0,0,.32-.82l-15.37-34.77a.62.62,0,0,0-1.14.5h0l15.36,34.77a.66.66,0,0,0,.87.32Zm2.66-4.8,36.79-5.26a.63.63,0,1,0,0-1.26l-.14,0-36.79,5.26a.62.62,0,0,0,.08,1.24Zm-10.49,23.47a.63.63,0,0,0,.11-.88L356,306.57a.63.63,0,0,0-.88-.12.64.64,0,0,0-.12.89L375,333a.63.63,0,0,0,.49.24.66.66,0,0,0,.4-.17ZM407,326.14a.64.64,0,0,0-.6-.65L379,324.1a.63.63,0,0,0-.59.67.64.64,0,0,0,.53.58l27.46,1.39h0a.64.64,0,0,0,.65-.6Zm-12.93,20.34a.62.62,0,0,0-.54-.69h0l-21-2.07a.62.62,0,0,0-.68.55h0a.63.63,0,0,0,.56.68l21,2.08h.06a.62.62,0,0,0,.66-.56Zm-26.35,10.84a.63.63,0,0,0,.18-.87l-10.38-15.69a.64.64,0,0,0-.87-.17.63.63,0,0,0-.18.87l10.38,15.69a.66.66,0,0,0,.53.28.57.57,0,0,0,.38-.11Zm23.82,5.25a.65.65,0,0,0-.62-.63l-24.69-.23h0a.62.62,0,0,0-.62.62.61.61,0,0,0,.59.63h0l24.69.23h0a.63.63,0,0,0,.66-.6v0Zm-33.13,36.92c.05-.11,4.26-11.71,16.92-14.48a.63.63,0,0,0,.48-.75.64.64,0,0,0-.75-.47c-13.35,2.92-17.78,15.17-17.83,15.29a.64.64,0,0,0,.39.8h.2a.63.63,0,0,0,.63-.39Zm2.81,9.17a.64.64,0,0,0,.58-.67c-1.57-23.58,7.55-62.2,22.18-93.9,9.35-20.26,46-60.08,46.39-60.48a.63.63,0,0,0-.88-.89h0c-.37.4-37.17,40.37-46.6,60.81C368,346,359,383.92,360.6,408.07a.64.64,0,0,0,.63.59Zm29.91-107.55a.63.63,0,0,0,.59-.66L389.34,260a.62.62,0,0,0-.65-.59h0a.63.63,0,0,0-.59.66l2.43,40.43a.62.62,0,0,0,.62.59Zm-7.46,13.29a.64.64,0,0,0,.32-.82l-15.37-34.77a.62.62,0,0,0-1.14.5l15.36,34.77a.66.66,0,0,0,.87.32Zm2.66-4.8,36.79-5.26a.63.63,0,1,0,0-1.26l-.14,0-36.79,5.26a.62.62,0,0,0,.08,1.24Zm-10.49,23.47a.63.63,0,0,0,.11-.88L356,306.57a.63.63,0,0,0-.88-.12.64.64,0,0,0-.12.89L375,333a.63.63,0,0,0,.49.24.66.66,0,0,0,.4-.17ZM407,326.14a.64.64,0,0,0-.6-.65L379,324.1a.63.63,0,0,0-.59.67.64.64,0,0,0,.53.58l27.46,1.39h0a.64.64,0,0,0,.65-.6Zm-12.93,20.34a.62.62,0,0,0-.54-.69h0l-21-2.07a.62.62,0,0,0-.68.55h0a.63.63,0,0,0,.56.68l21,2.08h.06a.62.62,0,0,0,.66-.56Zm-26.35,10.84a.63.63,0,0,0,.18-.87l-10.38-15.69a.64.64,0,0,0-.87-.17.63.63,0,0,0-.18.87l10.38,15.69a.66.66,0,0,0,.53.28.57.57,0,0,0,.38-.11Zm23.82,5.25a.65.65,0,0,0-.62-.63l-24.69-.23h0a.62.62,0,0,0-.62.62.61.61,0,0,0,.59.63h0l24.69.23h0a.63.63,0,0,0,.66-.6v0Zm-33.13,36.92c.05-.11,4.26-11.71,16.92-14.48a.63.63,0,0,0,.48-.75.64.64,0,0,0-.75-.47c-13.35,2.92-17.78,15.17-17.83,15.29a.64.64,0,0,0,.39.8h.2a.63.63,0,0,0,.63-.39Z" transform="translate(-44.73 -43.82)"/>
						<path d="M391.15,300.49l-2.43-40.43m-5.26,53.77L368.1,279.06m55,24.66L386.29,309M375.5,332.57,355.57,307M379,324.73l27.46,1.38m-34,18.23,21,2.08M367.43,356.8,357,341.11m9.23,21.23,24.69.23m-29.69,46.09a.64.64,0,0,0,.58-.67c-1.57-23.58,7.55-62.2,22.18-93.9,9.35-20.26,46-60.08,46.39-60.48a.63.63,0,0,0-.88-.89h0c-.37.4-37.17,40.37-46.6,60.81C368,346,359,383.92,360.6,408.07A.64.64,0,0,0,361.23,408.66Zm29.91-107.55a.63.63,0,0,0,.59-.66L389.34,260a.62.62,0,0,0-.65-.59h0a.63.63,0,0,0-.59.66l2.43,40.43a.62.62,0,0,0,.62.59Zm-7.46,13.29a.64.64,0,0,0,.32-.82l-15.37-34.77a.62.62,0,0,0-1.14.5h0l15.36,34.77a.66.66,0,0,0,.87.32Zm2.66-4.8,36.79-5.26a.63.63,0,1,0,0-1.26l-.14,0-36.79,5.26a.62.62,0,0,0,.08,1.24Zm-10.49,23.47a.63.63,0,0,0,.11-.88L356,306.57a.63.63,0,0,0-.88-.12.64.64,0,0,0-.12.89L375,333a.63.63,0,0,0,.49.24.66.66,0,0,0,.4-.17ZM407,326.14a.64.64,0,0,0-.6-.65L379,324.1a.63.63,0,0,0-.59.67.64.64,0,0,0,.53.58l27.46,1.39h0a.64.64,0,0,0,.65-.6Zm-12.93,20.34a.62.62,0,0,0-.54-.69h0l-21-2.07a.62.62,0,0,0-.68.55h0a.63.63,0,0,0,.56.68l21,2.08h.06a.62.62,0,0,0,.66-.56Zm-26.35,10.84a.63.63,0,0,0,.18-.87l-10.38-15.69a.64.64,0,0,0-.87-.17.63.63,0,0,0-.18.87l10.38,15.69a.66.66,0,0,0,.53.28.57.57,0,0,0,.38-.11Zm23.82,5.25a.65.65,0,0,0-.62-.63l-24.69-.23h0a.62.62,0,0,0-.62.62.61.61,0,0,0,.59.63h0l24.69.23h0a.63.63,0,0,0,.66-.6v0Zm-33.13,36.92c.05-.11,4.26-11.71,16.92-14.48a.63.63,0,0,0,.48-.75.64.64,0,0,0-.75-.47c-13.35,2.92-17.78,15.17-17.83,15.29a.64.64,0,0,0,.39.8h.2a.63.63,0,0,0,.63-.39Zm2.81,9.17a.64.64,0,0,0,.58-.67c-1.57-23.58,7.55-62.2,22.18-93.9,9.35-20.26,46-60.08,46.39-60.48a.63.63,0,0,0-.88-.89h0c-.37.4-37.17,40.37-46.6,60.81C368,346,359,383.92,360.6,408.07a.64.64,0,0,0,.63.59Zm29.91-107.55a.63.63,0,0,0,.59-.66L389.34,260a.62.62,0,0,0-.65-.59h0a.63.63,0,0,0-.59.66l2.43,40.43a.62.62,0,0,0,.62.59Zm-7.46,13.29a.64.64,0,0,0,.32-.82l-15.37-34.77a.62.62,0,0,0-1.14.5l15.36,34.77a.66.66,0,0,0,.87.32Zm2.66-4.8,36.79-5.26a.63.63,0,1,0,0-1.26l-.14,0-36.79,5.26a.62.62,0,0,0,.08,1.24Zm-10.49,23.47a.63.63,0,0,0,.11-.88L356,306.57a.63.63,0,0,0-.88-.12.64.64,0,0,0-.12.89L375,333a.63.63,0,0,0,.49.24.66.66,0,0,0,.4-.17ZM407,326.14a.64.64,0,0,0-.6-.65L379,324.1a.63.63,0,0,0-.59.67.64.64,0,0,0,.53.58l27.46,1.39h0a.64.64,0,0,0,.65-.6Zm-12.93,20.34a.62.62,0,0,0-.54-.69h0l-21-2.07a.62.62,0,0,0-.68.55h0a.63.63,0,0,0,.56.68l21,2.08h.06a.62.62,0,0,0,.66-.56Zm-26.35,10.84a.63.63,0,0,0,.18-.87l-10.38-15.69a.64.64,0,0,0-.87-.17.63.63,0,0,0-.18.87l10.38,15.69a.66.66,0,0,0,.53.28.57.57,0,0,0,.38-.11Zm23.82,5.25a.65.65,0,0,0-.62-.63l-24.69-.23h0a.62.62,0,0,0-.62.62.61.61,0,0,0,.59.63h0l24.69.23h0a.63.63,0,0,0,.66-.6v0Zm-33.13,36.92c.05-.11,4.26-11.71,16.92-14.48a.63.63,0,0,0,.48-.75.64.64,0,0,0-.75-.47c-13.35,2.92-17.78,15.17-17.83,15.29a.64.64,0,0,0,.39.8h.2a.63.63,0,0,0,.63-.39Z" transform="translate(-44.73 -43.82)" style="opacity:0.20000000298023224;isolation:isolate" />
						<polygon points="332.83 347.21 304.52 347.21 304.52 353.07 306.99 353.07 312.1 385.04 325.25 385.04 330.36 353.07 332.83 353.07 332.83 347.21"/>
						<polygon points="332.83 347.21 304.52 347.21 304.52 353.07 306.99 353.07 312.1 385.04 325.25 385.04 330.36 353.07 332.83 353.07 332.83 347.21" style="fill:#fff;opacity:0.30000001192092896;isolation:isolate" />
					</g>
					<g id="epicjungle--Character--inject-1--inject-2" class="placeholder-my-account">
						<polygon points="77.95 170.01 45.02 159.26 42.09 151.52 35.4 151.31 23.26 149.01 24.72 151.52 40 162.61 43.77 164.49 78.21 182.48 77.95 170.01" style="fill:#fff;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<polygon points="42.09 151.52 38.95 149.64 32.68 151.94 33.72 153.19 42.09 151.52" style="fill:#fff;stroke:#263238;stroke-linejoin:round;stroke-width:1.0039600133895874px" />
						<polygon points="77.95 170.01 45.02 159.26 42.09 151.52 35.4 151.31 23.26 149.01 24.72 151.52 40 162.61 43.77 164.49 78.21 182.48 77.95 170.01" style="fill:#fff" />
						<g style="clip-path:url(#clip-path)">
						<polygon points="77.95 170.01 45.02 159.26 42.09 151.52 35.4 151.31 23.26 149.01 24.72 151.52 40 162.61 43.77 164.49 78.21 182.48 77.95 170.01";stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px;opacity:0.5;isolation:isolate" />
						</g>
						<polygon points="77.95 170.01 45.02 159.26 42.09 151.52 35.4 151.31 23.26 149.01 24.72 151.52 40 162.61 43.77 164.49 78.21 182.48 77.95 170.01" style="fill:none;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<polygon points="42.09 151.52 38.95 149.64 32.68 151.94 33.72 153.19 42.09 151.52" style="fill:#fff" />
						<g style="clip-path:url(#clip-path-2)">
						<polygon points="42.09 151.52 38.95 149.64 32.68 151.94 33.72 153.19 42.09 151.52";stroke:#263238;stroke-linejoin:round;stroke-width:1.0039600133895874px;opacity:0.5;isolation:isolate" />
						</g>
						<polygon points="42.09 151.52 38.95 149.64 32.68 151.94 33.72 153.19 42.09 151.52" style="fill:none;stroke:#263238;stroke-linejoin:round;stroke-width:1.0039600133895874px" />
						<path d="M129.67,144.06s-.51,4.5.76,7.39,8.32,12.68,8.32,12.68l-13.16,10.55s-5.46-11-6.5-12.78-2.29-9.44,1.1-14.93S128.46,140,129.67,144.06Z" transform="translate(-44.73 -43.82)" style="fill:#fff" />
						<g style="clip-path:url(#clip-path-3)">
						<polygon points="78.18 114.7 83.89 126.54 80.85 130.87 75.11 120.62 78.18 114.7";opacity:0.5;isolation:isolate" />
						</g>
						<path d="M129.67,144.06s-.51,4.5.76,7.39,8.32,12.68,8.32,12.68l-13.16,10.55s-5.46-11-6.5-12.78-2.29-9.44,1.1-14.93S128.46,140,129.67,144.06Z" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M133.75,135.82c-.81-5-6.54-15.17-15.63-14.78-5.9.26-8.66,1.45-11.22,2.9a32.73,32.73,0,0,0-5.8,4.34c-4.44,5.33-6,6.79-5.14,10.87a12.17,12.17,0,0,0,.75,4.78c1.36,3.63,2.29,6,3.47,7.73-.36,1.69-1.3,6.15-1.35,7.17s3,.31,4.54-.08c2.86,6.4,8.1,10.84,9.73,11.35,2.84.89,7.33-3.78,9.71-7.4s.58-7.69.59-9.31,5.35-5.18,7.33-6.31S134.55,140.81,133.75,135.82Z" transform="translate(-44.73 -43.82)" style="fill:#fff" />
						<g style="clip-path:url(#clip-path-4)">
						<path d="M96,139.15a12.17,12.17,0,0,0,.75,4.78c1.36,3.63,2.29,6,3.47,7.73-.36,1.69-1.3,6.15-1.35,7.17s3,.31,4.54-.08c2.86,6.4,8.1,10.84,9.73,11.35,2.84.89,7.33-3.78,9.71-7.4a7.35,7.35,0,0,0,1.13-3c-.13-.47-.22-.76-.22-.76s-1.34,5.15-4,4.48-6.73-6-9-7.84-1.34-4.26-1.79-7-7.17-5.15-7.62-6.72,1.12-8.07,1.12-8.07,2.55-3.4,2-2a9.52,9.52,0,0,0,.67,7.39,5.1,5.1,0,0,0,4.71,2.91L112.29,130l-5.15-4.26-6,2.5C96.66,133.61,95.13,135.07,96,139.15Z" transform="translate(-44.73 -43.82)";opacity:0.5;isolation:isolate" />
						</g>
						<path d="M133.75,135.82c-.81-5-6.54-15.17-15.63-14.78-5.9.26-8.66,1.45-11.22,2.9a32.73,32.73,0,0,0-5.8,4.34c-4.44,5.33-6,6.79-5.14,10.87a12.17,12.17,0,0,0,.75,4.78c1.36,3.63,2.29,6,3.47,7.73-.36,1.69-1.3,6.15-1.35,7.17s3,.31,4.54-.08c2.86,6.4,8.1,10.84,9.73,11.35,2.84.89,7.33-3.78,9.71-7.4s.58-7.69.59-9.31,5.35-5.18,7.33-6.31S134.55,140.81,133.75,135.82Z" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#263238;stroke-miterlimit:10" />
						<path d="M101.42,148.64l1,2.86s2.15.71,4.77-2.15" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#263238;stroke-linecap:round;stroke-miterlimit:10" />
						<path d="M108.81,162s2.38-.24,3.34-3.58" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#263238;stroke-linecap:round;stroke-miterlimit:10" />
						<path d="M99.75,146.25s.71-2.15,5-2.15" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#263238;stroke-linecap:round;stroke-miterlimit:10" />
						<path d="M121.74,117.06a70.59,70.59,0,0,0-9.41-.72s-9.42-5.43-18.47.36-4.7,15.93-4.7,18.46-2.9,2.54-1.09,5.8S96,142.42,96,142.42a8.69,8.69,0,0,1,3.27-6.35c3.26-2.53,5.86-3.08,6.94-2.35,0,0-.72,5.43.36,7.6,0,0,3.62,1.81,4.71,1.81s-.71,1.53,2.9,2.89a4.53,4.53,0,0,0,4-.47c.53-2.2,1.69-5.51,3.85-4.74,3.17,1.13,6.06,8.93,1.77,11.59,5.16.94,11.41-8.19,11.78-16.51S127.1,118,121.74,117.06Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M106.37,130.15s2.66-1.43,5.92,1.63,9.6,7.15,18,4.9" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:0.5px" />
						<path d="M106,127.7s1.83-2.86,4.89-2.86,10.21,4.29,15.92,4.29" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:0.5px" />
						<path d="M103.92,133.21s-3.47-4.28-6.73-.81S96,139.15,96,139.15" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:0.5px" />
						<path d="M90.05,136.07a10.6,10.6,0,0,0,3.46-6.94c.41-4.49,6.54-8.37,10.41-4.69" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:0.5px" />
						<path d="M96.37,119.74s6.13-5.92,11.23,1.63" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:0.5px" />
						<path d="M146.26,410.81s3.77,5.86,3.35,9.63l-.41,3.77S135.37,428,132.44,428,114,426.53,114,426.53l-.67-2.66a.88.88,0,0,1,.48-1l13.83-6.45,4.36-4.77Z" transform="translate(-44.73 -43.82)" style="fill:#fff;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M134.54,425.05c3.75.29,10.87-2,15-3.46l-.29,2.62S135.37,428,132.44,428,114,426.53,114,426.53l-.48-1.9C116,424.64,129.58,424.67,134.54,425.05Z" transform="translate(-44.73 -43.82)";stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M127.66,416.42l-20.13,8.76s-1.72,4.31,0,5.17,39.22,0,39.22,0,2.59-6.81-1.5-11.38S127.66,416.42,127.66,416.42Z" transform="translate(-44.73 -43.82)" style="fill:#fff;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M146.75,430.35s-37.5.86-39.22,0c-.83-.42-.86-1.63-.67-2.78h40.55A14.61,14.61,0,0,1,146.75,430.35Z" transform="translate(-44.73 -43.82)";stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M118.14,264.21s-5.26,23.31-7.25,37.89-3.16,43.79-2.74,47.14,21.36,59.48,21.36,59.48l2.09,5,14.66-2.93s-6.7-21.36-9.21-33.09-8-31-8-34.35,13-67.33,13.93-71.53,5.15-10.65,5.15-10.65l-28.07-.57Z" transform="translate(-44.73 -43.82)";stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M118.14,264.21s-3.08,21.29-1.81,36.09,4,46.31,4,51,7.57,32.7,8,41.5c.67,12.71-.27,19-.27,19l-.45,4.61s8.83,1.26,10.76,1.81a24.19,24.19,0,0,0,6.83.74s3.21-14.13,3.21-26.17-2.67-36.82-4-46.86,2.86-48.77,5.24-56,7.58-22.54,4.08-30.36S118.14,264.21,118.14,264.21Z" transform="translate(-44.73 -43.82)";stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M157.62,255.65l-.32,9.52s-5.7,1.13-13.38,2.46c-6.34,1.1-22.26-.29-27.62-.81a1.86,1.86,0,0,1-1.69-2l.52-8.6Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M135.34,160.75s-9,9.73-12.39,15.78-4.73,15.32-6,22.62,2.17,24.44,1.2,32.31l-3.07,24.79s-.66,1.68,1.55,3.52,13,2.51,22.75,3c3.56.18,14.19-2.11,15.93-2.22,2.1-.13,2.17-2.8,2.26-4.9.42-9.87,2.2-36.18,3.37-47.64C163.35,184.64,150.16,162.08,135.34,160.75Z" transform="translate(-44.73 -43.82)" style="fill:#fff;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M159.84,221.3c.4-5.19.8-9.9,1.15-13.29.1-1,.16-2,.21-3l-23.91,4-20.54-7a112.59,112.59,0,0,0,.72,12.72l20.15,5.64Z" transform="translate(-44.73 -43.82)"/>
						<path d="M134.45,161.73c-1.36,1.51-4.06,4.58-6.63,7.84L143,185l5-2Z" transform="translate(-44.73 -43.82)"/>
						<path d="M135.34,160.75s-9,9.73-12.39,15.78a30.5,30.5,0,0,0-2.43,5.78l18.1-20.91A17.47,17.47,0,0,0,135.34,160.75Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M117.65,195.21l19.64,6.46,23.85-2.74a55.75,55.75,0,0,0-3.91-17.31L138,189.33l-17.19-7.79A90.3,90.3,0,0,0,117.65,195.21Z" transform="translate(-44.73 -43.82)"/>
						<path d="M151.46,245.78a60.81,60.81,0,0,1-29.74-2.43l-4.79-1.64-1.49,12,5.46,1.53a82.33,82.33,0,0,0,31.93,2.46l4.41-.53a4,4,0,0,0,.38-1.55c.12-2.67.33-6.55.6-11Z" transform="translate(-44.73 -43.82)"/>
						<path d="M154.13,229.44A60.57,60.57,0,0,1,124.39,227l-6.1-2.09a39.67,39.67,0,0,1-.09,6.54l-.71,5.77,6.08,1.7a82.29,82.29,0,0,0,31.92,2.47l3-.36c.25-4,.54-8.26.85-12.47Z" transform="translate(-44.73 -43.82)"/>
						<rect x="69.73" y="182" width="1.33" height="24.81" transform="translate(-169.95 83.64) rotate(-51.2)" style="fill:#263238" />
						<path d="M144.65,171.54s7.09,4.83,7.25,16.24c.07,5-.45,9.67-1.6,17.86s-8.29,34.86-13.85,38.1-14.19-2.88-14.19-2.88L80.52,213.15,70.43,205l-5-9.44,1.57-3L79.31,202l-6.63-6.13,1.3-1.65,2.4,1.67,7,2.62,1.53,10L87.07,210,127,224.58s-.5-21.49-.13-25.6.88-14.44,5.28-21.93" transform="translate(-44.73 -43.82)" style="fill:#fff" />
						<g style="clip-path:url(#clip-path-5)">
						<path d="M126.72,208.34c0,7.42.25,16.24.25,16.24L87.08,210.05l-2.16-1.48-1.53-10-7-2.62L74,194.25l-1.3,1.65,6.61,6.1L67,192.56l-1.49,2.95,5,9.44,10.09,8.2,2.54,1.69,55.15,17.77Z" transform="translate(-44.73 -43.82)";opacity:0.5;isolation:isolate" />
						</g>
						<path d="M144.65,171.54s7.09,4.83,7.25,16.24c.07,5-.45,9.67-1.6,17.86s-8.29,34.86-13.85,38.1-14.19-2.88-14.19-2.88L80.52,213.15,70.43,205l-5-9.44,1.57-3L79.31,202l-6.63-6.13,1.3-1.65,2.4,1.67,7,2.62,1.53,10L87.07,210,127,224.58s-.5-21.49-.13-25.6.88-14.44,5.28-21.93" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M127,224.58l15.24,11,3.95-7s2.73-2.15,3.13-3.77-.11-4.25.3-5.87,2.45-3.14,2.64-7.06,0-7.19,0-7.19,3.3-13.57,2.94-19.47-6-16.33-10.61-16.56-10.49.46-15.09,7.42-3.66,27.28-4.38,28.55.28,7.54.28,7.54a3.49,3.49,0,0,0-1.4,2.53c-.08,1.63,1.68,5.64,1.68,5.64Z" transform="translate(-44.73 -43.82)" style="fill:#fff;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<path d="M125.52,199.41a28.44,28.44,0,0,1-.39,5.21c-.64,1.14.09,6.29.25,7.34a59.34,59.34,0,0,0,26.51,2,10.28,10.28,0,0,0,.34-2.13,71.88,71.88,0,0,0,0-7.19s.29-1.21.69-3A96.67,96.67,0,0,1,125.52,199.41Z" transform="translate(-44.73 -43.82)"/>
						<path d="M128.88,177.19c-1.43,2.87-2.23,7.18-2.69,11.55a59.58,59.58,0,0,0,28.51,3.47,38.17,38.17,0,0,0,.51-7,19.37,19.37,0,0,0-1.3-5.4A98.54,98.54,0,0,1,128.88,177.19Z" transform="translate(-44.73 -43.82)"/>
						<path d="M125.68,220.45l1.29,4.13,15.24,11,3.95-7s2.73-2.15,3.13-3.77a5,5,0,0,0,.13-.86A93.48,93.48,0,0,1,125.68,220.45Z" transform="translate(-44.73 -43.82)" style="fill:#263238" />
						<path d="M136.71,418.09s.34-8.66,2-21.32-2.33-30.64-3-33.64.34-9.66-.33-12-3.91-12.32-2-23.9S136.84,285,136.84,285s-4.81-3.91-6.22-9-.33-6.69-.33-6.69" transform="translate(-44.73 -43.82)" style="fill:none;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
						<line x1="94.21" y1="226" x2="92.36" y2="236.24" style="fill:none;stroke:#263238;stroke-miterlimit:10;stroke-width:1.0039600133895874px" />
					</g>
					</svg>
				</div>
				
				<div class="<?php echo esc_attr( (int) get_theme_mod( 'myaccount_image') == 0  ? 'col-md-6 col-lg-5 mb-5 bg-secondary px-4 py-5 p-sm-5 rounded-lg' : 'col-lg-4 col-md-6 offset-lg-1' ); ?>">

				<?
			}
	}
				elseif ( $account_style == 'style-v2' ) {
					?>

					<div class="cs-signin-form mt-3 mx-auto bg-size-cover" style="bottom: 0; left: 0; background-image: url(<?php echo ( wp_get_attachment_image_url( get_theme_mod( 'myaccount_image' ), 'full' ) ); ?>);	">
						<div class="cs-signin-form-inner pb-4">

						<?php } else { ?>

							<div class="row form-login-row align-items-center pt-2">
							<?php } 

							do_action( 'woocommerce_before_customer_login_form' ); ?>
							<?php if ( $account_style == 'style-v1' ): ?>

								<div class="col-md-6 col-lg-5 mb-5 mb-md-0<?php if ( ! $is_registration_enabled ) echo esc_attr( ' mx-auto');?> ">
									<div class="bg-secondary px-4 py-5 p-sm-5 rounded-lg">
										<?php else: ?>

											<div class="cs-view show" id="signin-view">
											<?php endif; ?>
											<?php if ( ! empty ( $epicjungle_login_form_title ) || ! empty ( $epicjungle_login_form_desc ) ): ?>
											<div class="form-heading <?php echo esc_attr( $epicjungle_login_heading_alignment ); ?>">
												<?php if ( ! empty ( $epicjungle_login_form_title ) ): ?>
													<h1 class="<?php echo esc_attr( $title_class ); ?>"><?php echo esc_html( $epicjungle_login_form_title ); ?></h1>
												<?php endif; ?>

												<?php if ( ! empty ( $epicjungle_login_form_desc ) ): ?>
													<p class="<?php echo esc_attr( $desc_class ); ?>"><?php echo esc_html( $epicjungle_login_form_desc ); ?></p>
												<?php endif; ?>
											</div>
										<?php endif; ?>


										<form class="woocommerce-form woocommerce-form-login login" method="post">

											<?php do_action( 'woocommerce_login_form_start' ); ?>

											<div class="input-group-overlay form-group">
												<div class="input-group-prepend-overlay">
													<span class="input-group-text"><i class="fe-mail"></i></span>
												</div>

												<label class="sr-only p-0" for="username"><?php esc_html_e( 'Username or email address', 'epicjungle' ); ?></label>

												<input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text form-control prepended-form-control" name="username" placeholder="<?php echo esc_html_e( 'Email', 'epicjungle' ); ?>" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
											</div>

											<div class="input-group-overlay cs-password-toggle form-group">
												<div class="input-group-prepend-overlay">
													<span class="input-group-text"><i class="fe-lock"></i></span>
												</div>

												<label class="sr-only p-0" for="password"><?php esc_html_e( 'Password', 'epicjungle' ); ?></label>
												<input class="woocommerce-Input woocommerce-Input--text input-text form-control prepended-form-control" type="password" name="password" placeholder="<?php echo esc_html_e( 'Password', 'epicjungle' ); ?>" id="password" autocomplete="current-password" />

												<label class="cs-password-toggle-btn">
													<input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only"><?php echo esc_html__( 'Show password', 'epicjungle'); ?></span>
												</label>
											</div>

											<?php do_action( 'woocommerce_login_form' ); ?>

											<div class="forget-password-row d-flex justify-content-between align-items-center form-group">

												<div class="custom-control custom-checkbox">
													<input class="woocommerce-form__input woocommerce-form__input-checkbox custom-control-input" name="rememberme" type="checkbox" id="keep-signed-2" value="forever">
													<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme custom-control-label p-0" for="keep-signed-2"><?php echo esc_html__( 'Keep me signed in', 'epicjungle' ); ?>
													</label>
												</div>
												<span class="woocommerce-LostPassword lost_password mt-3 mt-lg-0">
													<a class="nav-link-style font-size-ms" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot password?', 'epicjungle' ); ?></a>
												</span>
											</div>

											<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
											<button type="submit" class="woocommerce-button btn btn-primary btn-block woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Sign in', 'epicjungle' ); ?>"><?php esc_html_e( 'Sign in', 'epicjungle' ); ?></button>

											<?php if ( $is_registration_enabled && $account_style !== 'style-v1' ) : ?>
												<p class="font-size-sm pt-3 mb-0 <?php echo esc_attr( $epicjungle_form_footer_alignment ); ?>"><?php esc_html_e( 'Don&#039;t have an account?', 'epicjungle' ); ?>
												<a id="register-tab" class="font-weight-medium login-register-tab-switcher" href="#" data-view="#signup-view"><?php esc_html_e( 'Sign up', 'epicjungle' ); ?></a></p>
											<?php endif; ?>

											<?php do_action( 'woocommerce_login_form_end' ); ?>

										</form>
										<?php if ( $account_style == 'style-v1' ): ?>

										</div><!-- bg-secondary -->
									</div><!-- col-md-6 -->

									<?php else: ?>

									</div><!-- #signin-view -->


								<?php endif; ?>


								<?php if ( $is_registration_enabled ) : ?>
									<?php if ( $account_style == 'style-v1') : ?>
										<div class="col-md-6 offset-lg-1">
											<?php else: ?>
												<div class="cs-view" id="signup-view">
												<?php endif; ?>

												<?php if ( ! empty ( $epicjungle_register_form_title ) || ! empty ( $epicjungle_register_form_desc ) ): ?>
												<div class="form-heading <?php echo esc_attr( $epicjungle_register_heading_alignment ); ?>">
													<?php if ( ! empty ( $epicjungle_register_form_title ) ): ?>
														<h1 class="<?php echo esc_attr( $title_class ); ?>"><?php echo esc_html( $epicjungle_register_form_title ); ?></h1>
													<?php endif; ?>

													<?php if ( ! empty ( $epicjungle_register_form_desc ) ): ?>
														<p class="<?php echo esc_attr( $desc_class ); ?>"><?php echo esc_html( $epicjungle_register_form_desc ); ?></p>
													<?php endif; ?>
												</div>
											<?php endif; ?>

											<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

												<?php do_action( 'woocommerce_register_form_start' ); ?>
												<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

													<div class="form-group">
														<label class="sr-only p-0" for="reg_username"><?php esc_html_e( 'Username', 'epicjungle' ); ?></label>
														<input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" placeholder="<?php echo esc_html_e( 'Full name', 'epicjungle' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
													</div>

												<?php endif; ?>
												<div class="form-group">
													<label class="sr-only p-0" for="reg_email"><?php esc_html_e( 'Email address', 'epicjungle' ); ?></label>
													<input type="email" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" placeholder="<?php echo esc_html_e( 'Email', 'epicjungle' ); ?>" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>


												</div>

												<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

													<div class="cs-password-toggle form-group">

														<label class="sr-only p-0" for="reg_password"><?php esc_html_e( 'Password', 'epicjungle' ); ?></label>

														<input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password" id="reg_password" placeholder="<?php echo esc_html_e( 'Password', 'epicjungle' ); ?>" autocomplete="new-password" />

														<label class="cs-password-toggle-btn">
															<input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only"><?php echo esc_html__( 'Show password', 'epicjungle'); ?></span>
														</label>

													</div>


													<div class="cs-password-toggle form-group">
														<label class="form-label sr-only p-0" for="con_password"><?php esc_html_e( 'Confirm Password', 'epicjungle' ); ?></label>
														<input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="password" id="con_password" placeholder="<?php echo esc_html_e( 'Confirm Password', 'epicjungle' ); ?>" autocomplete="new-password" />
														<label class="cs-password-toggle-btn">
															<input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only">Show password</span>
														</label>
													</div>

													<?php else : ?>

														<p><?php esc_html_e( 'A password will be sent to your email address.', 'epicjungle' ); ?></p>

													<?php endif; ?>

													<?php do_action( 'woocommerce_register_form' ); ?>

													<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
													<button type="submit" class="woocommerce-Button woocommerce-button btn btn-primary btn-block woocommerce-form-register__submit<?php if ( $account_style == 'style-v1' ) echo esc_attr( ' w-50' ); ?>" name="register" value="<?php esc_attr_e( 'Sign up', 'epicjungle' ); ?>"><?php esc_html_e( 'Sign up', 'epicjungle' ); ?></button>

													<?php if (  $account_style !== 'style-v1' ) : ?>
														<p class="font-size-sm pt-3 mb-0 <?php echo esc_attr( $epicjungle_form_footer_alignment ); ?>"><?php esc_html_e( 'Already have an account? ', 'epicjungle' );?><a id="login-tab" class="font-weight-medium login-register-tab-switcher" href="#" data-view="#signin-view"><?php echo esc_html__( 'Sign in', 'epicjungle' ); ?></a></p>
													<?php endif; ?>


													<?php do_action( 'woocommerce_register_form_end' ); ?>

												</form>

												<?php if ( $account_style == 'style-v1') : ?>
												</div><!-- col-md-6 offset-lg-1 -->
												<?php else: ?>
												</div><!-- #signup-view -->
											<?php endif; ?>
										<?php endif; ?>

		
									<?php if ( $account_style == 'style-v3' ){ ?>
									</div><!--.col-lg-4 col-md-6 offset-lg-1-->
								</div><!--.row-->
							</div><!--.w-100 pt-3-->
						<?php } elseif (  $account_style == 'style-v2' ) { ?>
						</div><!--.cs-signin-form-inner-->
					</div><!--.cs-signin-form-->
				<?php } else { ?>
			</div><!--.row-->
	<?php } ?>

</section>
		<?php do_action( 'woocommerce_after_customer_login_form' ); ?>