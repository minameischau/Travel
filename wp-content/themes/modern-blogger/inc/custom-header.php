<?php
/**
 * @package Modern Blogger
 * @subpackage modern-blogger
 * Setup the WordPress core custom header feature.
 *
 * @uses modern_blogger_header_style()
*/

function modern_blogger_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'modern_blogger_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1400,
		'height'                 => 95,
		'wp-head-callback'       => 'modern_blogger_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'modern_blogger_custom_header_setup' );

if ( ! function_exists( 'modern_blogger_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see modern_blogger_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'modern_blogger_header_style' );
function modern_blogger_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$modern_blogger_custom_css = "
        .top-header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: left top;
			background-size: cover;
		}";
	   	wp_add_inline_style( 'modern-blogger-basic-style', $modern_blogger_custom_css );
	endif;
}
endif; //modern_blogger_header_style