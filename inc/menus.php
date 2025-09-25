<?php

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
