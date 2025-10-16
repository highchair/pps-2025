<?php
/**
 * Providence Preservation Society 2025 functions and definitions.
 */


  // Adds theme supports
  if ( ! function_exists( 'pps_post_format_setup' ) ) :
    function pps_post_format_setup() {
      // Force HTML5 options when present in function output
      add_theme_support( 'html5', array( 'search-form' ) );
    
      //add_theme_support( 'post-formats', array( 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
    
      // Not sure why I need this, default posts are missing Featured Images
      add_theme_support('post-thumbnails', array(
        'post',
        'page',
        'events',
      ));
    }
  endif;
  add_action( 'after_setup_theme', 'pps_post_format_setup' );


  // Enqueues block editor-specific JS and CSS
  if ( ! function_exists( 'pps_gutenberg_scripts' ) ) :
  function pps_gutenberg_scripts() {

      wp_enqueue_style(
        'pps-2025-type',
        'https://use.typekit.net/msx3awg.css',
      );

      wp_enqueue_style(
        'pps-editor-style',
        get_template_directory_uri() . '/assets/css/editor-style.css'
      );

      wp_enqueue_script(
        'pps-editor-script',
        get_template_directory_uri() . '/assets/js/editor.js',
        array(
          'wp-dom',
          'wp-blocks',
          'wp-element',
          'wp-components',
          'wp-data',
          'wp-edit-post',
          'wp-hooks'
        ),
        wp_get_theme()->get('Version'),
        filemtime( get_template_directory() . '/assets/js/editor.js' ),
        true
      );
    }
  endif;
  add_action( 'enqueue_block_editor_assets', 'pps_gutenberg_scripts' );


  // Enqueues Theme CSS and JS for front-end
  if ( ! function_exists( 'pps_enqueue_theme' ) ) :
    function pps_enqueue_theme() {
      wp_enqueue_style(
        'pps-2025-type',
        'https://use.typekit.net/msx3awg.css',
      );

      wp_enqueue_style(
        'pps-2025-style',
        get_parent_theme_file_uri( 'style.css' ),
        array(),
        filemtime( get_template_directory() . '/style.css' ), // Versioning (auto-busts cache)
        //wp_get_theme()->get( 'Version' )
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


  // Include external files
  include_once get_theme_file_path('inc/extras.php');
  include_once get_theme_file_path('inc/menus.php');
  include_once get_theme_file_path('inc/post-types.php');
  include_once get_theme_file_path('inc/widgets.php');
  include_once get_theme_file_path('inc/multiple-authors.php');
