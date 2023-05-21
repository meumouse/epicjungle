<?php
/**
 * EpicJungle Theme Customizer
 *
 * @package EpicJungle
 */

if ( ! function_exists( 'epicjungle_sass_hex_to_rgba' ) ) {
	function epicjungle_sass_hex_to_rgba( $hex, $alpa = '' ) {
		$hex = sanitize_hex_color( $hex );
		preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches);
		for($i = 1; $i <= 3; $i++) {
			$matches[$i] = hexdec($matches[$i]);
		}
		if( !empty( $alpa ) ) {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ', ' . $alpa .')';
		} else {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ')';
		}
		return $rgb;
	}
}

if ( ! function_exists( 'epicjungle_sass_yiq' ) ) {
	function epicjungle_sass_yiq( $hex ) {
		$hex = sanitize_hex_color( $hex );
		$length = strlen( $hex );
		if( $length < 5 ) {
			$hex = ltrim($hex,"#");
			$hex = '#' . $hex . $hex;
		}

		preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches);

		for($i = 1; $i <= 3; $i++) {
			$matches[$i] = hexdec($matches[$i]);
		}
		$yiq = (($matches[1]*299)+($matches[2]*587)+($matches[3]*114))/1000;
		return ($yiq >= 128) ? '#000' : '#fff';
	}
}

/**
 * Get all of the epicjungle theme colors.
 *
 * @return array $epicjungle_theme_colors The epicjungle Theme Colors.
 */
if( ! function_exists( 'epicjungle_get_theme_colors' ) ) {
	function epicjungle_get_theme_colors() {
		$epicjungle_theme_colors = array(
			'primary_color'     => get_theme_mod( 'epicjungle_primary_color', apply_filters( 'epicjungle_default_primary_color', '#766df4' ) ),
		);

		return apply_filters( 'epicjungle_get_theme_colors', $epicjungle_theme_colors );
	}
}

/**
 * Get Customizer Color css.
 *
 * @see epicjungle_get_custom_color_css()
 * @return array $styles the css
 */
if( ! function_exists( 'epicjungle_get_custom_color_css' ) ) {
	function epicjungle_get_custom_color_css() {
		$epicjungle_theme_colors = epicjungle_get_theme_colors();

		$primary_color = $epicjungle_theme_colors['primary_color'];
		$primary_color_yiq = epicjungle_sass_yiq( $primary_color );
		$primary_color_darken_10p = epicjungle_adjust_color_brightness( $primary_color, -10 );
		$primary_color_darken_15p = epicjungle_adjust_color_brightness( $primary_color, -15 );
		$primary_color_lighten_20p = epicjungle_adjust_color_brightness( $primary_color, 20 );

		$styles =
'
/*
 * Primary Color
 */
    

';



		return apply_filters( 'epicjungle_get_custom_color_css', $styles );
	}
}


/**
 * Add CSS in <head> for styles handled by the theme customizer
 *
 * @since 1.0.0
 * @return void
 */
if( ! function_exists( 'epicjungle_enqueue_custom_color_css' ) ) {
	function epicjungle_enqueue_custom_color_css() {
		if( get_theme_mod( 'epicjungle_enable_custom_color', 'no' ) === 'yes' ) {
			$epicjungle_theme_colors = epicjungle_get_theme_colors();

			$primary_color             = $epicjungle_theme_colors['primary_color'];
			$primary_color_yiq         = epicjungle_sass_yiq( $primary_color );
			$primary_color_darken_10p  = epicjungle_adjust_color_brightness( $primary_color, -10 );
			$primary_color_darken_15p  = epicjungle_adjust_color_brightness( $primary_color, -15 );
			$primary_color_lighten_10p = epicjungle_adjust_color_brightness( $primary_color, 10 );
			$primary_color_opacity     = epicjungle_sass_hex_to_rgba( $primary_color, '.05' );
			$primary_color_outline_35  = epicjungle_sass_hex_to_rgba( $primary_color, '.35' );
			$primary_color_bg_outline  = epicjungle_sass_hex_to_rgba( $primary_color, '.08' );
			$primary_color_outline_70  = epicjungle_sass_hex_to_rgba( $primary_color, '.7' );
			$primary_color_outline_15  = epicjungle_sass_hex_to_rgba( $primary_color, '.15' );


			$start_percent = '0%';
			$end_percent = '100%';
			$mid_percent = '30%';

			$color_root = ':root { --ej-primary: ' . $epicjungle_theme_colors['primary_color'] . ';  --ej-primary-bg-d
			: ' . $primary_color_darken_10p . '; --ej-primary-border-d: ' . $primary_color_darken_15p . ';  --ej-primary-o-5: ' . $primary_color_opacity . ';  --ej-primary-outline-35: ' . $primary_color_outline_35 . '; --ej-primary-outline-bg: ' . $primary_color_bg_outline . ';  --ej-primary-bg-gradient: linear-gradient( to right, ' . $primary_color. ' '. $start_percent .', ' . $primary_color .' ' . $mid_percent .', ' . $primary_color_lighten_10p .' ' . $end_percent .');  --ej-primary-outline-70: ' . $primary_color_outline_70 . ';  --ej-primary-outline-15: ' . $primary_color_outline_15 . ';}';
			$styles = $color_root  . epicjungle_get_custom_color_css();;

			wp_add_inline_style( 'epicjungle-color', $styles );
		}
	}
}


add_action( 'wp_enqueue_scripts', 'epicjungle_enqueue_custom_color_css', 130 );
