<?php
/**
 * Providence Preservation Society 2025 functions and definitions.
 */

// Adds theme support for post formats.
if ( ! function_exists( 'pps_post_format_setup' ) ) :
  function pps_post_format_setup() {
    // Force HTML5 options when present in function output
    add_theme_support( 'html5', array( 'search-form' ) );
    
    add_theme_support( 'post-formats', array( 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
  }
endif;
add_action( 'after_setup_theme', 'pps_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'pps_editor_style' ) ) :
  function pps_editor_style() {
    add_theme_support( 'editor-style' );
    add_editor_style( get_template_directory_uri() . '/assets/css/editor-style.css' );
    add_editor_style( 'https://use.typekit.net/msx3awg.css' );
  }
endif;
add_action( 'enqueue_block_editor_assets', 'pps_editor_style' );

// Enqueues Theme CSS and JS
if ( ! function_exists( 'pps_enqueue_theme' ) ) :
  function pps_enqueue_theme() {
    wp_enqueue_style(
      'pps-2025-style',
      get_parent_theme_file_uri( 'style.css' ),
      array(),
      wp_get_theme()->get( 'Version' )
    );
    wp_enqueue_script(
      'pps-2025-scripts', // Handle (used for dependencies or deregistering)
      get_template_directory_uri() . '/assets/js/general.js',
      array(), // Dependencies (e.g., array('jquery'))
      filemtime( get_template_directory() . '/assets/js/general.js' ), // Versioning (auto-busts cache)
      true // Load in footer
    );
  }
endif;
add_action( 'wp_enqueue_scripts', 'pps_enqueue_theme' );

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

// Register Footer Widgets
if ( ! function_exists( 'pps_register_footer_widgets' ) ) :
  function pps_register_footer_widgets() {
    register_sidebar( array(
      'name'           => 'Footer Contact',
      'id'             => 'footer-contact',
      'description'    => 'Footer Contact widget',
      'before_widget'  => '',
      'after_widget'   => '',
      'before_sidebar' => '<address class="footer__address">',
      'after_sidebar'  => '</address>',
      'before_title'   => '<h3 class="sr widget-title">',
      'after_title'    => '</h3>',
    ) );

    register_sidebar( array(
      'name'           => 'Footer Quick Links',
      'id'             => 'footer-links',
      'description'    => 'Common links widget',
      'before_widget'  => '',
      'after_widget'   => '',
      'before_sidebar' => '<nav class="footer__nav" aria-label="secondary">',
      'after_sidebar'  => '</nav>',
      'before_title'   => '<h3 class="sr widget-title">',
      'after_title'    => '</h3>',
    ) );

    register_sidebar( array(
      'name'           => 'Footer Copyright',
      'id'             => 'footer-colophon',
      'description'    => 'Footer copyright information',
      'before_widget'  => '',
      'after_widget'   => '',
      'before_sidebar' => '<div class="footer__legal">',
      'after_sidebar'  => '</div>',
      'before_title'   => '<h3 class="sr widget-title">',
      'after_title'    => '</h3>',
    ) );
  }
endif;
add_action( 'widgets_init', 'pps_register_footer_widgets' );
