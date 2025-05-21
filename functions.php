<?php
/**
 * Providence Preservation Society 2025 functions and definitions.
 */

// Adds theme support for post formats.
if ( ! function_exists( 'pps_post_format_setup' ) ) :
  function pps_post_format_setup() {
    add_theme_support( 'post-formats', array( 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
  }
endif;
add_action( 'after_setup_theme', 'pps_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'pps_editor_style' ) ) :
  function pps_editor_style() {
    add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
  }
endif;
add_action( 'after_setup_theme', 'pps_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'pps_enqueue_styles' ) ) :
  function pps_enqueue_styles() {
    wp_enqueue_style(
      'twentytwentyfive-style',
      get_parent_theme_file_uri( 'style.css' ),
      array(),
      wp_get_theme()->get( 'Version' )
    );
  }
endif;
add_action( 'wp_enqueue_scripts', 'pps_enqueue_styles' );

// Add persistent classes to the body element
if ( ! function_exists( 'pps_body_classes' ) ) :
  function pps_body_classes( $classes ) {
    $classes[] = 'no-js';
    $classes[] = 'not-scrolled';

    // Optionally, add custom conditional classes
    //if ( is_page('contact') ) {
    //  $classes[] = 'contact-page-class';
    //}

    return $classes;
  }
endif;
add_filter( 'body_class', 'pps_body_classes' );

// Register menus
if ( ! function_exists( 'pps_register_menus' ) ) :
function pps_register_menus() {
  register_nav_menus( array(
    'utility'       => 'Utility Menu',
    'primary'       => 'Primary Menu',
  ) );
}
endif;
add_action( 'after_setup_theme', 'pps_register_menus' );
