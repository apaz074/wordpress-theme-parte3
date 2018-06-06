<?php
/**
 * My Awesome WordPress Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage mawt
 * @since 1.0.0
 * @version 1.0.0
 */

 //https://codex.wordpress.org/Content_Width
//Establecer el ancho máximo permitido para cualquier contenido en el tema, como oEmbeds e imágenes
if ( !isset( $content_width ) ) {
  $content_width = 800;
}

if ( !function_exists('mawt_scripts') ):
  function mawt_scripts () {
    wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.0.0', 'all' );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'script', get_template_directory_uri() . '/script.js', array('jquery'), '1.0.0', true );
  }
endif;

add_action('wp_enqueue_scripts', 'mawt_scripts');
