<?php
// functions.php

// Add support for block styles
add_action( 'after_setup_theme', function() {
  add_theme_support( 'editor-styles' );
  add_theme_support( 'wp-block-styles' );
  add_theme_support( 'align-wide' );
});

add_action( 'init', function() {

  // Register the Lightbox Gallery block
  // Editor script
  wp_register_script(
    'hcd-lightbox-gallery-editor-script',
    get_template_directory_uri() . '/blocks/hcd-lightbox-gallery/hcd-lightbox-gallery-editor.js',
    array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
    '1.0',
    true
  );

  // Register the Lightbox Gallery block
  // Editor styles
  wp_register_style(
    'hcd-lightbox-gallery-editor-style',
    get_template_directory_uri() . '/blocks/hcd-lightbox-gallery/hcd-lightbox-gallery-editor.css',
    array( 'wp-edit-blocks' ),
    filemtime( get_template_directory() . '/blocks/hcd-lightbox-gallery/hcd-lightbox-gallery-editor.css' )
  );

  // Register the Lightbox Gallery block
  // Front-end script
  wp_register_script(
    'hcd-lightbox-gallery-render-script',
    get_template_directory_uri() . '/blocks/hcd-lightbox-gallery/hcd-lightbox-gallery-render.js',
    array(), // No dependencies needed - vanilla JS
    '1.0',
    true
  );

  // Register the Lightbox Gallery block
  // Front-end styles
  wp_register_style(
    'hcd-lightbox-gallery-render-style',
    get_template_directory_uri() . '/blocks/hcd-lightbox-gallery/hcd-lightbox-gallery-style.css',
    array(),
    filemtime( get_template_directory() . '/blocks/hcd-lightbox-gallery/hcd-lightbox-gallery-style.css' )
  );

  // Register the Lightbox Gallery block
  register_block_type(
    'hcd-lightbox-gallery/lightbox-gallery',
    array(
      'editor_script'   => 'hcd-lightbox-gallery-editor-script',
      'editor_style'    => 'hcd-lightbox-gallery-editor-style',
      'script'          => 'hcd-lightbox-gallery-render-script',
      'style'           => 'hcd-lightbox-gallery-render-style',
      'render_callback' => 'hcd_lightbox_gallery_render',
      'attributes'      => array(
        'images' => array(
          'type' => 'array',
          'default' => array(),
          'items' => array( 'type' => 'object' ),
        ),
      ),
    ),
  );
} );

// Render Lightbox Gallery callback for front-end
if ( ! function_exists( 'hcd_lightbox_gallery_render' ) ) :
  function hcd_lightbox_gallery_render( $attributes ) {
    if ( empty( $attributes['images'] ) ) return '';

    // Only enqueue modal/lightbox script if the block is present
    add_action( 'wp_footer', function() {
      static $enqueued = false;
      if ( $enqueued ) return;
      $enqueued = true;
      wp_enqueue_script(
        'hcd-lightbox-gallery-modal',
        get_template_directory_uri() . '/assets/js/fslightbox.js',
        array(),
        '3.0',
        true
      );
    }, 5 );

    $images = '<div class="hcd-lightbox-gallery__items"><div class="hcd-lightbox-gallery__placeholder" aria-hidden="true"></div>';
    $thumbs = '<nav class="hcd-lightbox-gallery__nav">';
    $first = true;
    foreach ( $attributes['images'] as $image ) {
      $checked = $first ? ' checked' : '';
      $first = false;
      $id = esc_attr( $image['id'] ?? '' );
      $url = esc_url( $image['url'] ?? '' );
      $alt = esc_attr( $image['alt'] ?? '' );

      // Get thumbnail (default size: 'thumbnail' or 'medium', 'large', 'full')
      $thumb = wp_get_attachment_image_src( $id, 'large' );
      $thumb_url = $thumb ? esc_url( $thumb[0] ) : esc_url( $image['url'] );

      $images .= "<input type=\"radio\" id=\"img-{$id}\"{$checked} name=\"gallery\" class=\"hcd-lightbox-gallery__selector\" />
        <a href=\"{$url}\" data-fslightbox=\"hcd-lightbox\" data-type=\"image\" class=\"hcd-lightbox-gallery__img\" role=\"button\" aria-hidden=\"true\" tabindex=\"-1\">
          <img src=\"{$url}\" alt=\"{$alt}\" loading=\"eager\" />
        </a>";
      $thumbs .= "<label for=\"img-{$id}\" class=\"hcd-lightbox-gallery__thumb{$checked}\"><img src=\"{$thumb_url}\" alt=\"{$alt}\" loading=\"eager\" /></label>";
    }
    $images .= '</div>';
    $thumbs .= '</nav>';
  
    return '<section class="hcd-lightbox-gallery">'.$images.$thumbs.'</section>';
  }
endif;