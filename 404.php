<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package EpicJungle
 */
get_header( '404' );
$style_404    = apply_filters( 'epicjungle_404_style', get_theme_mod( '404_style', 'style-v1' ) ); 
$button_text = apply_filters( 'epicjungle_404_button_text', get_theme_mod( '404_button_text', esc_html__( 'Go to homepage', 'epicjungle' ) ) ); ?>

<div class="container d-flex flex-column justify-content-center pt-5 mt-n6" style="flex: 1 0 auto;">
	 <div class="pt-7 pb-5">
	 	 <div class="text-center mb-2 pb-4">
	 	 	<?php if ( apply_filters( 'epicjungle_404_image', (int) get_theme_mod( '404_image_option') > 0 ) ) : ?>

		 	 	<h1 class="<?php echo esc_attr( $style_404 == 'style-v1' ? 'mb-5' : 'mb-grid-gutter' ); ?>">
			 	 	<?php

					 $image = wp_get_attachment_image( get_theme_mod( '404_image_option' ), '480px', false, [
							'class' => 'd-inline-block erro-404',
							'alt'   => esc_html_x( 'Error 404', 'front-end', 'epicjungle' ),
						] );

					echo apply_filters('epicjungle_404_image_option', $image );
					?>
					
					<span class="sr-only"><?php echo esc_html__( 'Error 404', 'epicjungle');?></span>
					
					<?php if ( get_theme_mod( '404_pretitle' ) !== '' &&  $style_404 == 'style-v2' ): ?>
						<span class="d-block pt-3 font-size-sm font-weight-semibold text-danger"><?php echo esc_html( get_theme_mod( '404_pretitle', _x( 'Error code: 404', 'front-end', 'epicjungle' ) ) ); ?></span>
					<?php endif; ?>

				</h1>

			<?php elseif ( apply_filters( 'epicjungle_404_image', (int) get_theme_mod( '404_image_option') == 0 ) ) : ?>			
				<h1 class="<?php echo esc_attr( $style_404 == 'style-v1' ? 'mb-5' : 'mb-grid-gutter' ); ?>">
			 	 	<?php
			 	 	 $placeholder_404 = '<svg id="placeholder-404" data-name="placeholder 404" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352.52 342.54"><g id="epicjungle--404--inject-43"><path d="M147.68,287.64H86.83V260.17l60.85-72.34H176.8v73.9h15.09v25.91H176.8v22.48H147.68Zm0-25.91V223.89l-32.16,37.84Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M202.3,249.51q0-34.29,12.34-48t37.61-13.7q12.13,0,19.93,3a36.74,36.74,0,0,1,12.71,7.79,41.56,41.56,0,0,1,7.75,10.09A52.28,52.28,0,0,1,297.19,221a115.34,115.34,0,0,1,3.36,28q0,32.71-11.07,47.89T251.35,312.1q-15.18,0-24.53-4.84a39.78,39.78,0,0,1-15.33-14.19q-4.35-6.65-6.77-18.17A124.42,124.42,0,0,1,202.3,249.51Zm33.14.08q0,23,4.05,31.37t11.77,8.41a12.32,12.32,0,0,0,8.82-3.57q3.74-3.57,5.5-11.28t1.76-24q0-23.94-4.06-32.19t-12.18-8.24q-8.28,0-12,8.41T235.44,249.59Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M371.74,287.64H310.89V260.17l60.85-72.34h29.12v73.9H416v25.91H400.86v22.48H371.74Zm0-25.91V223.89l-32.15,37.84Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/></g><g id="epicjungle--Planets--inject-43"><g style="opacity:0.30000001192092896"><path d="M201,145.62a1.87,1.87,0,1,1-1.87-1.87h0a1.86,1.86,0,0,1,1.86,1.86Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><circle cx="1.32" cy="148.45" r="1.32" class="placeholder-error-404"/><circle cx="219.4" cy="340.65" r="1.89" class="placeholder-error-404"/><circle cx="264.85" cy="264.32" r="1.32" class="placeholder-error-404"/><path d="M424.17,95.62a1.32,1.32,0,1,1-1.32-1.32,1.32,1.32,0,0,1,1.32,1.32Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M172.75,69a1.32,1.32,0,1,1-1.32-1.32A1.32,1.32,0,0,1,172.75,69Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><circle cx="206.05" cy="69.26" r="1.32" class="placeholder-error-404"/></g><circle cx="69.58" cy="48.68" r="21.91" class="placeholder-error-404"/><circle cx="69.58" cy="48.68" r="21.91" style="fill:#fff;opacity:0.699999988079071;isolation:isolate"/><path d="M133.68,99.83A21.78,21.78,0,0,0,125,101.6a21.92,21.92,0,0,0,24.87,34.89h0a21.92,21.92,0,0,0-16.23-36.65Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.20000000298023224;isolation:isolate"/><path d="M131.5,105.62a2,2,0,1,1-2-2A2,2,0,0,1,131.5,105.62Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.20000000298023224;isolation:isolate"/><path d="M155.06,103.62a2,2,0,1,1-2-2A2,2,0,0,1,155.06,103.62Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.20000000298023224;isolation:isolate"/><path d="M151.06,117.9a3.28,3.28,0,1,1-3.28-3.28h0A3.28,3.28,0,0,1,151.06,117.9Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.20000000298023224;isolation:isolate"/><path d="M140.64,127.25a4.38,4.38,0,1,1-4.38-4.38,4.38,4.38,0,0,1,4.38,4.38Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.20000000298023224;isolation:isolate"/><circle cx="310.53" cy="308.55" r="19.23" class="placeholder-error-404"/><circle cx="310.53" cy="308.55" r="19.23" style="fill:#fff;opacity:0.30000001192092896;isolation:isolate"/><path d="M394.33,361.34a19.22,19.22,0,0,0-17.67,33.32,19.22,19.22,0,0,0,17.67-33.32Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.4000000059604645;isolation:isolate"/><path d="M363.83,382c-20.53,9.66-5.22,17.11,23.71,6.71,26.79-9.63,37-21.77,13-18C401.83,375.76,368.28,388.83,363.83,382Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/></g><g id="epicjungle--Astronaut--inject-43"><path d="M394.1,187.83C367.21,206,332.4,230,322.79,287.64h-2.05c9.35-57,42.89-81.57,69.79-99.81Z" transform="translate(-71.65 -67.68)" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M255,368.27c-17,0-33.81-7.67-42-20.19-5.05-7.74-10.92-23.95,6.56-45.58l1.55,1.26c-12.36,15.3-14.64,30.65-6.43,43.23,10,15.3,33.59,23,53.73,17.52C289,358.9,301.56,341,302.77,315.29c4.13-87.81,50.78-114.86,84.84-134.61,21.17-12.27,36.46-21.13,33.1-39.84-.47-2.59-1.5-4.38-3.17-5.48-4.35-2.87-12.85-.88-22.69,1.41-19.31,4.5-45.75,10.66-61.5-16.13l1.73-1c15,25.53,39.57,19.8,59.32,15.2,10.29-2.39,19.17-4.46,24.24-1.13,2.15,1.41,3.47,3.64,4,6.8,3.61,20.08-13,29.72-34.05,41.92-33.67,19.52-79.77,46.25-83.85,133-1.26,26.6-14.32,45.21-35.84,51.06A52.59,52.59,0,0,1,255,368.27Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M255,368.27c-17,0-33.81-7.67-42-20.19-5.05-7.74-10.92-23.95,6.56-45.58l1.55,1.26c-12.36,15.3-14.64,30.65-6.43,43.23,10,15.3,33.59,23,53.73,17.52C289,358.9,301.56,341,302.77,315.29c4.13-87.81,50.78-114.86,84.84-134.61,21.17-12.27,36.46-21.13,33.1-39.84-.47-2.59-1.5-4.38-3.17-5.48-4.35-2.87-12.85-.88-22.69,1.41-19.31,4.5-45.75,10.66-61.5-16.13l1.73-1c15,25.53,39.57,19.8,59.32,15.2,10.29-2.39,19.17-4.46,24.24-1.13,2.15,1.41,3.47,3.64,4,6.8,3.61,20.08-13,29.72-34.05,41.92-33.67,19.52-79.77,46.25-83.85,133-1.26,26.6-14.32,45.21-35.84,51.06A52.59,52.59,0,0,1,255,368.27Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.20000000298023224;isolation:isolate"/><path d="M312.76,97a46,46,0,0,1,13.58,2.13s11,18.77,12.3,23.07c-.46,4.24-7.61,11.19-7.61,11.19Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M312.76,97a46,46,0,0,1,13.58,2.13s11,18.77,12.3,23.07c-.46,4.24-7.61,11.19-7.61,11.19Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.30000001192092896;isolation:isolate"/><path d="M345.34,188.13a140.56,140.56,0,0,1-11.56-16.38q-1.26-2.17-2.39-4.42c-.43-.85-.84-1.7-1.24-2.56a11,11,0,0,1-1.21-2.69c-1.2-12.67,3.14-22-1-32.17l-16.48,6.44s1.4,18.12,4.6,29c2,6.73,6.48,12.55,10.81,17.94,1.35,1.68,2.65,3.41,4,5.1s2.71,3.06,4,4.65c1.95,2.41,2.59,4.72,1.12,7.56l-.25.45c-.42.74,1.54,1.58,2.78,0,2-2.58,1.72-2.42,3.46-4.62,1.06-1.33,2.27-2.78,3.32-4A3.38,3.38,0,0,0,345.34,188.13Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M345.34,188.13a140.56,140.56,0,0,1-11.56-16.38q-1.26-2.17-2.39-4.42c-.43-.85-.84-1.7-1.24-2.56a11,11,0,0,1-1.21-2.69c-1.2-12.67,3.14-22-1-32.17l-16.48,6.44s1.4,18.12,4.6,29c2,6.73,6.48,12.55,10.81,17.94,1.35,1.68,2.65,3.41,4,5.1s2.71,3.06,4,4.65c1.95,2.41,2.59,4.72,1.12,7.56l-.25.45c-.42.74,1.54,1.58,2.78,0,2-2.58,1.72-2.42,3.46-4.62,1.06-1.33,2.27-2.78,3.32-4A3.38,3.38,0,0,0,345.34,188.13Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.699999988079071;isolation:isolate"/><path d="M341.31,182.92a55.38,55.38,0,0,1-8.66,7.52c.43.48.85,1,1.28,1.46a44.06,44.06,0,0,0,8.5-7.51Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.30000001192092896;isolation:isolate"/><path d="M345.34,188.13l-.12-.14a5.43,5.43,0,0,0-.89,5.52l.95-1.13A3.37,3.37,0,0,0,345.34,188.13Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.30000001192092896;isolation:isolate"/><path d="M308.84,109a35.47,35.47,0,0,1-6.37,7.19,23.25,23.25,0,0,1-4.42,3,18.3,18.3,0,0,1-2.58,1.09l-.68.22-.22.06-.47.13a5.2,5.2,0,0,1-.88.14,7.6,7.6,0,0,1-2.51-.23,12.16,12.16,0,0,1-2.94-1.27,23.38,23.38,0,0,1-2.15-1.41,39.48,39.48,0,0,1-3.58-3,53.33,53.33,0,0,1-6-6.74,2.51,2.51,0,0,1,3.35-3.62h.08c2.36,1.5,4.74,3.08,7.06,4.49,1.18.69,2.32,1.39,3.45,1.93a16.15,16.15,0,0,0,1.59.72,3.05,3.05,0,0,0,1.07.26c.06,0,0-.07-.37-.06a2,2,0,0,0-.35,0l-.22,0h0l.33-.17a13.09,13.09,0,0,0,1.29-.79,18.69,18.69,0,0,0,2.5-2.12,63,63,0,0,0,4.9-5.79h0a5,5,0,0,1,8,5.93Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M308.84,109a35.47,35.47,0,0,1-6.37,7.19,23.25,23.25,0,0,1-4.42,3,18.3,18.3,0,0,1-2.58,1.09l-.68.22-.22.06-.47.13a5.2,5.2,0,0,1-.88.14,7.6,7.6,0,0,1-2.51-.23,12.16,12.16,0,0,1-2.94-1.27,23.38,23.38,0,0,1-2.15-1.41,39.48,39.48,0,0,1-3.58-3,53.33,53.33,0,0,1-6-6.74,2.51,2.51,0,0,1,3.35-3.62h.08c2.36,1.5,4.74,3.08,7.06,4.49,1.18.69,2.32,1.39,3.45,1.93a16.15,16.15,0,0,0,1.59.72,3.05,3.05,0,0,0,1.07.26c.06,0,0-.07-.37-.06a2,2,0,0,0-.35,0l-.22,0h0l.33-.17a13.09,13.09,0,0,0,1.29-.79,18.69,18.69,0,0,0,2.5-2.12,63,63,0,0,0,4.9-5.79h0a5,5,0,0,1,8,5.93Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.699999988079071;isolation:isolate"/><path d="M272.29,102.42l1.17,2s.89,2.62,2.68,3.1L281,106l-.25-.41h0c-.62-.94-.55-2.77-.34-4.29s-.57-1.57-1.15-1.19a3.81,3.81,0,0,0-.84,1.65,7.77,7.77,0,0,0-.79-.93l-1.48-1.48a1.71,1.71,0,0,0-2.34-.06l-1.2,1.07A1.7,1.7,0,0,0,272.29,102.42Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M272.29,102.42l1.17,2s.89,2.62,2.68,3.1L281,106l-.25-.41h0c-.62-.94-.55-2.77-.34-4.29s-.57-1.57-1.15-1.19a3.81,3.81,0,0,0-.84,1.65,7.77,7.77,0,0,0-.79-.93l-1.48-1.48a1.71,1.71,0,0,0-2.34-.06l-1.2,1.07A1.7,1.7,0,0,0,272.29,102.42Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.699999988079071;isolation:isolate"/><path d="M317.67,95.22a59.87,59.87,0,0,0-15.34,6.47,4.32,4.32,0,0,0-1.94,4.53c1.93,9.44,6.32,22.08,11.06,30.13l22.11-9.15c.15-3.9-5.22-16.52-10.69-28.72C321.89,96.29,320,94.66,317.67,95.22Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M317.67,95.22a59.87,59.87,0,0,0-15.34,6.47,4.32,4.32,0,0,0-1.94,4.53c1.93,9.44,6.32,22.08,11.06,30.13l22.11-9.15c.15-3.9-5.22-16.52-10.69-28.72C321.89,96.29,320,94.66,317.67,95.22Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.800000011920929;isolation:isolate"/><path d="M326.3,106.21l-4.39-1.47c1,2.57,4.53,5.82,7,7.73C328.11,110.47,327.22,108.37,326.3,106.21Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.30000001192092896;isolation:isolate"/><path d="M316.22,85.32c-1.83-3.48-5.78-5.23-10.52-4.84-4,.34-7.54,4.42-7.12,6.62s3.78,3.14,4.42,3.9l-2.77,2a3,3,0,0,0-.68,4.19l.08.1c1.17,1.48,2.71,3,3.6,4.12,7.66-.2,13.33-3.12,15.38-5.93C317.84,91.92,318,88.78,316.22,85.32Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M316.22,85.32c-1.83-3.48-5.78-5.23-10.52-4.84-4,.34-7.54,4.42-7.12,6.62s3.78,3.14,4.42,3.9l-2.77,2a3,3,0,0,0-.68,4.19l.08.1c1.17,1.48,2.71,3,3.6,4.12,7.66-.2,13.33-3.12,15.38-5.93C317.84,91.92,318,88.78,316.22,85.32Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.800000011920929;isolation:isolate"/><path d="M312.46,87.48a7.57,7.57,0,1,1-9.81-4.3A7.57,7.57,0,0,1,312.46,87.48Z" transform="translate(-71.65 -67.68)" style="fill:#263238"/><path d="M377.39,177.6c-.11-3.29-.26-3-.35-5.77-.06-1.7-.07-3.59-.08-5.22a3.36,3.36,0,0,0-2.7-3.28l-4-.8c-1.73-.37-3.44-.77-5.13-1.26-1.32-.38-2.62-.8-3.91-1.27s-2.74-1-4.08-1.62c-1.58-.67-3.14-1.39-4.68-2.14-1.73-.82-3.44-1.68-5.15-2.55-6.58-10.89-6.72-18.07-13.78-26.49l-15.16,6.86s11.14,19.76,18.72,28.14c4.37,4.82,11.22,7,17.33,8.58,4.41,1.13,8.88,2,13.35,2.83,1.74.32,3.63.44,5.13,1.48a5.75,5.75,0,0,1,2.14,3.45q.1.42.18.84C375.41,180.22,377.46,179.58,377.39,177.6Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M377.39,177.6c-.11-3.29-.26-3-.35-5.77-.06-1.7-.07-3.59-.08-5.22a3.36,3.36,0,0,0-2.7-3.28l-4-.8c-1.73-.37-3.44-.77-5.13-1.26-1.32-.38-2.62-.8-3.91-1.27s-2.74-1-4.08-1.62c-1.58-.67-3.14-1.39-4.68-2.14-1.73-.82-3.44-1.68-5.15-2.55-6.58-10.89-6.72-18.07-13.78-26.49l-15.16,6.86s11.14,19.76,18.72,28.14c4.37,4.82,11.22,7,17.33,8.58,4.41,1.13,8.88,2,13.35,2.83,1.74.32,3.63.44,5.13,1.48a5.75,5.75,0,0,1,2.14,3.45q.1.42.18.84C375.41,180.22,377.46,179.58,377.39,177.6Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.800000011920929;isolation:isolate"/><path d="M369.7,162.4c-.6-.13-1.2-.26-1.81-.41.05,3.46-1.57,9.42-2.16,11.23l1.9.36A38,38,0,0,0,369.7,162.4Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.30000001192092896;isolation:isolate"/><path d="M377,166.61a3.37,3.37,0,0,0-2.69-3.28l-1-.19a4.56,4.56,0,0,0,1.63,2.9,5.06,5.06,0,0,0,2,1.14A1.81,1.81,0,0,0,377,166.61Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.30000001192092896;isolation:isolate"/><path d="M311.05,87.54c.4,1.52-1.3,3.11-2.65,1.8a30.68,30.68,0,0,0-4.12-3.69c-1.39-.87.46-2.39,2.65-1.8A6,6,0,0,1,311.05,87.54Z" transform="translate(-71.65 -67.68)" style="fill:#fff"/><path d="M311.16,135.86c-.7.26.58,1.46.58,1.46s14-4.79,22.5-9.72a1.88,1.88,0,0,0-.68-1.58A214.48,214.48,0,0,1,311.16,135.86Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M311.16,135.86c-.7.26.58,1.46.58,1.46s14-4.79,22.5-9.72a1.88,1.88,0,0,0-.68-1.58A214.48,214.48,0,0,1,311.16,135.86Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.5;isolation:isolate"/><path d="M321.46,94.56c2.76,1.4,5.35,2.87,8,4.5,1.29.82,2.57,1.65,3.84,2.55s2.53,1.82,3.8,2.86l.47.39.59.54a11.8,11.8,0,0,1,1,1c.32.35.59.69.85,1s.54.68.77,1a45.41,45.41,0,0,1,2.58,4,58.7,58.7,0,0,1,4,8.35,2.52,2.52,0,0,1-4.19,2.62l-.05-.06c-2-2.13-3.93-4.37-5.87-6.46s-3.91-4.21-5.54-5.14c-2.27-1.41-4.8-2.82-7.31-4.2l-7.56-4.2h0a5,5,0,0,1,4.68-8.84Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M321.46,94.56c2.76,1.4,5.35,2.87,8,4.5,1.29.82,2.57,1.65,3.84,2.55s2.53,1.82,3.8,2.86l.47.39.59.54a11.8,11.8,0,0,1,1,1c.32.35.59.69.85,1s.54.68.77,1a45.41,45.41,0,0,1,2.58,4,58.7,58.7,0,0,1,4,8.35,2.52,2.52,0,0,1-4.19,2.62l-.05-.06c-2-2.13-3.93-4.37-5.87-6.46s-3.91-4.21-5.54-5.14c-2.27-1.41-4.8-2.82-7.31-4.2l-7.56-4.2h0a5,5,0,0,1,4.68-8.84Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.800000011920929;isolation:isolate"/><path d="M349.73,125.74l-.85-2.13s-.47-2.72-2.16-3.48l-5,.79.17.44h0c.46,1,.11,2.83-.34,4.29s.31,1.65.95,1.36c.36-.16.71-.81,1.09-1.5a9.35,9.35,0,0,0,.63,1l1.23,1.69a1.71,1.71,0,0,0,2.3.44l1.36-.87A1.7,1.7,0,0,0,349.73,125.74Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M349.73,125.74l-.85-2.13s-.47-2.72-2.16-3.48l-5,.79.17.44h0c.46,1,.11,2.83-.34,4.29s.31,1.65.95,1.36c.36-.16.71-.81,1.09-1.5a9.35,9.35,0,0,0,.63,1l1.23,1.69a1.71,1.71,0,0,0,2.3.44l1.36-.87A1.7,1.7,0,0,0,349.73,125.74Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.800000011920929;isolation:isolate"/><path d="M317.24,106.06l-1.22.1-7.49,18.08a3.86,3.86,0,0,0,1.22-.1s9.76-3.64,12.71-5C320.48,115.05,317.24,106.06,317.24,106.06Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.30000001192092896;isolation:isolate"/><path d="M303.57,110.8a43.36,43.36,0,0,0,5,13.44c3.66-1.26,9.76-3.64,12.72-5A134.44,134.44,0,0,1,316,106.16C312.87,106.37,306,109,303.57,110.8Z" transform="translate(-71.65 -67.68)" style="fill:#fff"/><path d="M311,114.71a2.58,2.58,0,1,1-1.73-3.21h0A2.58,2.58,0,0,1,311,114.71Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.30000001192092896;isolation:isolate"/><path d="M312.91,111.27a.84.84,0,0,1-1,.63.85.85,0,0,1-.64-1,.86.86,0,0,1,1-.63l.07,0A.83.83,0,0,1,312.91,111.27Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.6000000238418579;isolation:isolate"/><path d="M315.15,110.4a.84.84,0,0,1-1,.66.85.85,0,0,1-.67-1,.88.88,0,0,1,0-.15.84.84,0,0,1,1.05-.56h0A.84.84,0,0,1,315.15,110.4Z" transform="translate(-71.65 -67.68)" style="fill:var(--ej-primary);opacity:0.6000000238418579;isolation:isolate"/><polygon points="246.64 50.51 237.39 54.16 236.84 52.34 246.08 48.69 246.64 50.51" style="fill:var(--ej-primary);opacity:0.5;isolation:isolate"/></g><g id="epicjungle--Rocket--inject-43"><path d="M267.26,257.17a93.58,93.58,0,0,1-1.68,17.35q-1.77,7.71-5.5,11.28a12.3,12.3,0,0,1-8.81,3.57q-7.71,0-11.77-8.41a23.54,23.54,0,0,1-1.21-3.11,144,144,0,0,0-15.92,16l-5.31,6.26a38.56,38.56,0,0,0,9.77,7.19q9.34,4.83,24.52,4.84c1.78,0,3.5-.05,5.17-.15a143.5,143.5,0,0,0,15.1-29l14.85-38.72Z" transform="translate(-71.65 -67.68)" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M133.39,310l17.5,17.5,49-46.17C183,274.88,150.16,293.19,133.39,310Z" transform="translate(-71.65 -67.68)" style="fill:#263238"/><path d="M194.42,371c-5.59-5.6-17.5-17.5-17.5-17.5l46.17-49C229.5,321.35,211.19,354.22,194.42,371Z" transform="translate(-71.65 -67.68)" style="fill:#263238"/><path d="M261.4,260.7l19.09-36.81L243.68,243a144.18,144.18,0,0,0-32.44,23l-62.75,59.07,30.83,30.83,59.07-62.75A144.06,144.06,0,0,0,261.4,260.7Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M261.4,260.7l19.09-36.81L243.68,243a144.18,144.18,0,0,0-32.44,23l-62.75,59.07,30.83,30.83,59.07-62.75A144.06,144.06,0,0,0,261.4,260.7Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.6000000238418579;isolation:isolate"/><circle cx="150.55" cy="214.5" r="12.9" style="fill:#fff"/><circle cx="150.55" cy="214.5" r="8.29" class="placeholder-error-404"/><polygon points="118.1 277.14 87.91 246.95 112.63 223.69 141.36 252.43 118.1 277.14" style="fill:var(--ej-primary);opacity:0.30000001192092896;isolation:isolate"/><path d="M140.22,337.62c-22.6,1.83-30.09,16.3-32.65,35.53-1.3,9.81-1.88,19.74-10.11,25.48a2.77,2.77,0,0,0,1.63,5.06c30.34-.95,44.49-15.8,46.27-22a43.06,43.06,0,0,1-2.49,9.47,2.76,2.76,0,0,0,4,3.39c8.51-5.33,19.19-15.15,19.9-31.08C160.51,354.6,140.22,337.62,140.22,337.62Z" transform="translate(-71.65 -67.68)" class="placeholder-error-404"/><path d="M140.22,337.62c-22.6,1.83-30.09,16.3-32.65,35.53-1.3,9.81-1.88,19.74-10.11,25.48a2.77,2.77,0,0,0,1.63,5.06c30.34-.95,44.49-15.8,46.27-22a43.06,43.06,0,0,1-2.49,9.47,2.76,2.76,0,0,0,4,3.39c8.51-5.33,19.19-15.15,19.9-31.08C160.51,354.6,140.22,337.62,140.22,337.62Z" transform="translate(-71.65 -67.68)" style="fill:#fff;opacity:0.20000000298023224;isolation:isolate"/><polygon points="98.63 302.62 62.43 266.42 81.71 262.25 102.8 283.34 98.63 302.62" class="placeholder-error-404"/></g></svg>';

					echo apply_filters('epicjungle_404_image_option', $placeholder_404 );
					?>
					
					<span class="sr-only"><?php echo esc_html__( 'Error 404', 'epicjungle');?></span>
					
					<?php if ( get_theme_mod( '404_pretitle' ) !== '' &&  $style_404 == 'style-v2' ): ?>
						<span class="d-block pt-3 font-size-sm font-weight-semibold text-danger"><?php echo esc_html( get_theme_mod( '404_pretitle', _x( 'Error code: 404', 'front-end', 'epicjungle' ) ) ); ?></span>
					<?php endif; ?>

				</h1>
			<?php endif; ?>

			<?php if ( get_theme_mod( '404_title' ) !== '' ) : ?>
				<h2><?php echo esc_html( get_theme_mod( '404_title', _x( 'Página não encontrada!', 'front-end', 'epicjungle' ) ) ); ?></h2>
			<?php endif; ?>

			<?php if ( get_theme_mod( '404_subtitle' ) !== '' ) : ?>
				<p class="pb-2 subtitle">
					<?php echo esc_html( get_theme_mod( '404_subtitle', _x( 'It seems we can’t find the page you are looking for.', 'front-end', 'epicjungle' ) ) ); ?>
				</p>
			<?php endif; ?>

			<a class="mr-3 btn btn-<?php echo esc_attr( apply_filters( 'epicjungle_404_button_color', get_theme_mod( '404_button_color', 'primary' ) ) ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				 <?php echo esc_html( $button_text );?>
			</a>

			<?php if ( get_theme_mod( '404_subtitle_2' ) !== ''  ) : ?>
				<span><?php echo esc_html( get_theme_mod( '404_subtitle_2', _x( 'Or try', 'front-end', 'epicjungle' ) ) ); ?></span>
			<?php endif; ?>
	 	 </div>

	 	  <?php if ( filter_var( get_theme_mod( 'enable_form', 'yes' ), FILTER_VALIDATE_BOOLEAN ) ) : ?>
			<form role="search" method="get" class="search-form input-group-overlay" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	            <div class="input-group-overlay mx-auto" style="max-width: 390px;">
	                <div class="input-group-prepend-overlay">
	                    <span class="input-group-text"><i class="fe-search"></i></span>
	                </div>
	                <input type="search" class="form-control prepended-form-control" placeholder="<?php echo esc_attr_x( 'O que você procura?...', 'placeholder','epicjungle' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"/>
	            </div>
	        </form>
	    <?php endif; ?>
			
	</div>
</div><?php

get_footer( '404' );