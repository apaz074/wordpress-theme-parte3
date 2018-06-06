<?php
/**
 * kEnAi WP Starter Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage kenai
 * @since 1.0.0
 * @version 1.0.0
 */

function kenai_scripts () {
  wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.0.0', 'all' );

  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'script', get_template_directory_uri() . '/script.js', array('jquery'), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'kenai_scripts' );

function kenai_setup () {
  load_theme_textdomain( 'kenai', get_template_directory() . '/languages' );
}

add_action('after_setup_theme', 'kenai_setup');
