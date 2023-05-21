<?php
/**
 * Template Functions related to Coming Soon
 *
 */
function epicjungle_get_coming_soon_meta( $merge_default = true ) {
    global $post;

    if ( isset( $post->ID ) ) {

        $clean_coming_soon_options = get_post_meta( $post->ID, '_ej_coming_soon_options', true );

        $ej_coming_soon_options = maybe_unserialize( $clean_coming_soon_options );

        if( ! is_array( $ej_coming_soon_options ) ) {
            $ej_coming_soon_options = json_decode( $clean_coming_soon_options, true );
        }

        $coming_soon = $ej_coming_soon_options;

        return apply_filters( 'epicjungle_coming_soon_meta', $coming_soon, $post );
    }
}


if ( ! function_exists( 'epicjungle_coming_soon_content' ) ) {
    /**
     * Displays a deal and tabs Block
     */
    function epicjungle_coming_soon_content() {

    global $post;

    $thepostid                 = isset( $thepostid )? $thepostid : $post->ID;

    $clean_coming_soon_options = get_post_meta( $post->ID, '_ej_coming_soon_options', true );

    $ej_coming_soon_options       = maybe_unserialize( $clean_coming_soon_options );

    $ej_coming_soon_options  = array();
        if ( function_exists( 'epicjungle_option_enabled_post_types' ) && is_singular( epicjungle_option_enabled_post_types() ) ) {
            $clean_meta_data = get_post_meta( get_the_ID(), '_ej_coming_soon_options', true );
            $_ej_coming_soon_options = maybe_unserialize( $clean_meta_data );

        if( is_array( $_ej_coming_soon_options ) ) {
            $ej_coming_soon_options = $_ej_coming_soon_options;
        }
    } 

    $title                     = isset( $ej_coming_soon_options['title'] ) && ! empty( $ej_coming_soon_options['title'] ) ? $ej_coming_soon_options['title'] : '';

    $subtitle                  = isset( $ej_coming_soon_options['subtitle'] ) && ! empty( $ej_coming_soon_options['subtitle'] ) ? $ej_coming_soon_options['subtitle'] : '';

    $timer_value               = isset( $ej_coming_soon_options['timer_value'] ) ? $ej_coming_soon_options['timer_value'] : '+8';

    $attachment_id             = isset( $ej_coming_soon_options['bg']['image'] ) ? $ej_coming_soon_options['bg']['image'] : '';

    $subscription_title        = isset( $ej_coming_soon_options['subscription']['title'] ) && ! empty( $ej_coming_soon_options['subscription']['title'] ) ? $ej_coming_soon_options['subscription']['title'] : '';

    $subscription_subtitle     = isset( $ej_coming_soon_options['subscription']['subtitle'] ) && ! empty( $ej_coming_soon_options['subscription']['subtitle'] ) ? $ej_coming_soon_options['subscription']['subtitle'] : '';

    $form_shortcode            = isset( $ej_coming_soon_options['form']['shortcode'] ) && ! empty( $ej_coming_soon_options['form']['shortcode'] ) ? $ej_coming_soon_options['form']['shortcode'] : '';

    $header_static_id          = isset( $ej_coming_soon_options['top']['content'] ) ? $ej_coming_soon_options['top']['content'] : '';

    $footer_static_id          = isset( $ej_coming_soon_options['bottom']['content'] ) ? $ej_coming_soon_options['bottom']['content'] : '';


    ?>

	<div class="row no-gutters d-lg-flex min-vh-100" style="flex: 1 0 auto;">

	    <div class="col-lg-6 d-flex flex-column pt-4 pb-3 px-4 position-relative bg-size-cover" <?php if ( has_post_thumbnail() ) : ?>style="flex: 1 0 auto; background-image: url( <?php echo get_the_post_thumbnail_url(); ?> );"<?php endif; ?>>
	        <span class="bg-overlay bg-gradient" style="opacity: .9;"></span>

            <?php  if( epicjungle_is_mas_static_content_activated() && ! empty( $header_static_id ) ) { ?>
	            <div class="bg-overlay-content text-center mb-4 mb-lg-0">
	            	<?php print( epicjungle_render_content( $header_static_id, false ) );  ?>
	       		</div>
	        <?php } ?>

    		<div class="bg-overlay-content mx-auto my-auto text-center" style="max-width: 500px;">

    		  	<?php if ( ! empty ( $title ) ) : ?>
    				<h1 class="mb-3 text-light"><?php echo wp_kses_post( $title ); ?></h1>
    			<?php endif ; ?>

    			<?php if ( ! empty ( $subtitle ) ) : ?>
    				<p class="mb-grid-gutter text-light"><?php echo wp_kses_post( $subtitle ); ?></p>
    			<?php endif ; ?>

    			<?php if( ! empty( $timer_value ) ) :

                    $deal_end_time = strtotime( $timer_value );
                    $current_time = strtotime( 'now' );
                    $time_diff = ( $deal_end_time - $current_time );
                        
                    if( $time_diff > 0 ) : ?>

                        <div class="deal-countdown-timer">
                            <span class="deal-time-diff" style="display:none;"><?php echo esc_html( $time_diff ); ?></span>
                            <div class="deal-countdown countdown cs-countdown h2 text-light justify-content-center"></div>
                        </div>
                    <?php endif;
                endif; ?>
		
		    </div>

            <?php  if( epicjungle_is_mas_static_content_activated() && ! empty( $footer_static_id ) ) { ?>
	            <div class="bg-overlay-content text-center py-4 py-lg-0">
	            	<?php print( epicjungle_render_content( $footer_static_id, false ) );  ?>
	       		</div>
	        <?php } ?>
		
		    <div class="cs-shape cs-shape-right bg-body d-none d-lg-block">
           	 	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 228.4 2500">
              		<path fill="currentColor" d="M228.4,0v2500H0c134.9-413.7,202.4-830.4,202.4-1250S134.9,413.7,0,0H228.4z"></path>
            	</svg>
          	</div>

          <div class="cs-shape cs-shape-bottom cs-shape-curve bg-body d-lg-none">
            	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
              		<path fill="currentColor" d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
            	</svg>
          </div>
      	</div>

      	<div class="col-lg-6 py-5 pb-lg-6 px-4 align-self-center">
      		<div class="mx-auto text-center py-2 py-lg-0 mt-lg-n6" style="max-width: 500px;">
	      		<?php if ( ! empty ( $subscription_title ) ) : ?>
	        		<h2 class="h1 mb-3"><?php echo wp_kses_post( $subscription_title ); ?></h2>
	        	<?php endif; ?>

	        	<?php if ( ! empty ( $subscription_subtitle ) ) : ?>
	        		<p class="mb-grid-gutter"><?php echo wp_kses_post( $subscription_subtitle ); ?></p>
	        	<?php endif; ?>

				<?php echo do_shortcode( $form_shortcode ); ?>
      		</div>
    	</div>

	</div><!-- .row --><?php
  
        
    }
}