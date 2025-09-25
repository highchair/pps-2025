<?php

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


  // Allow SVG uploads
  if ( ! function_exists( 'pps_allow_svg' ) ) :
    function pps_allow_svg( $mimes ) {
      $mimes['svg'] = 'image/svg+xml';
      $mimes['svgz'] = 'image/svg+xml';
      return $mimes;
    }
  endif;
  add_filter( 'upload_mimes', 'pps_allow_svg' );


  // Modify the Read More default […] text
  if ( ! function_exists( 'pps_excerpt_more' ) ) :
    function pps_excerpt_more( $more ) {
      return '… ';
    }
  endif;
  add_filter( 'excerpt_more', 'pps_excerpt_more' );


  // Modify the excerpt length
  if ( ! function_exists( 'pps_excerpt_length' ) ) :
    function pps_excerpt_length( $length ) {
      return 32; // length in words. Default is 55
    }
  endif;
  add_filter( 'excerpt_length', 'pps_excerpt_length', 999 );
