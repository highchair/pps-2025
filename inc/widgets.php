<?php

  // Register Widgets
  if ( ! function_exists( 'pps_register_widgets' ) ) :
    function pps_register_widgets() {

      // News sidebar widget for Categories
      register_sidebar( array(
        'name'           => 'News Aside',
        'id'             => 'news-aside',
        'description'    => 'News landing page sidebar',
        'before_widget'  => '',
        'after_widget'   => '',
        'before_sidebar' => '<aside class="news-posts__aside">',
        'after_sidebar'  => '</aside>',
        'before_title'   => '<h3 class="widget-title has-base-font-size has-secondary-color">',
        'after_title'    => '</h3>',
      ) );

      register_sidebar( array(
        'name'           => 'Footer Contact',
        'id'             => 'footer-contact',
        'description'    => 'Footer Contact widget',
        'before_widget'  => '',
        'after_widget'   => '',
        'before_sidebar' => '<address class="footer__address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">',
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
  add_action( 'widgets_init', 'pps_register_widgets' );
