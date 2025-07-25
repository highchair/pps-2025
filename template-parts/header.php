<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PPS 2025
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
    wp_head();

    function pps_GA_snippet($current_id) {
      $GA_UA = null;

      if ( $current_id == '1') {
        // This is the main PPS site
        $GA_UA = 'G-HPSKNW241K';
      }
      if ( $current_id == '2') {
        // This is the PPS Architectural Guide site
        $GA_UA = 'G-CYJ3R9M540';
      }
      if ( $current_id == '3') {
        // This is the Atlantic Mills site
        $GA_UA = 'G-575H92CV3K';
      }
      if ( $GA_UA ) {
      echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id=" . $GA_UA . "\"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
    
          gtag('config', '" . $GA_UA . "');
        </script>";
      }
    }
    pps_GA_snippet( get_current_blog_id() );
  ?>

  </head>
  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <a href="#main" class="sr sr--focusable btn__secondary skip-link">Skip to Content</a>
    <header class="l__header header">
      <div class="container header__wrap">
        <div class="header__wrap__start">
          <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img class="brand__logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/pps-logo-circle.svg" alt="" />
            <svg class="brand__wordmark" viewBox="0 0 170 66">
              <title><?php bloginfo( 'name' ); ?></title>
              <use xlink:href="#wordmark"></use>
            </svg>
          </a>
        </div><!-- end .header__wrap__start -->
        <button class="reset nav__trigger js__toggle" aria-controls="navContent" aria-haspopup="true" aria-expanded="false" aria-label="Toggle navigation">
          <span class="menu">&equiv;</span>
          <span class="close">&#x2715;</span>
          <span class="label">Menu</span>
        </button>
        <nav id="navContent" class="header__wrap__end nav" aria-label="Primary">
          <div class="nav__inner">

            <?php get_search_form(); ?>

            <?php
              $menu_primary = wp_nav_menu( array(
                'theme_location' => 'primary',
                'depth'			     => 2,
                'menu_class'     => 'nav__main nav__list',
                'container'      => 'ul',
                'echo'           => FALSE,
              ) );

              if ( ! empty ( $menu_primary ) ) :
                echo $menu_primary;
              endif;

              $menu_utility = wp_nav_menu( array(
                'theme_location' => 'utility',
                'depth'			     => 1,
                'menu_class'     => 'nav__utility nav__list',
                'container'      => 'ul',
                'echo'           => FALSE,
              ) );

              if ( ! empty ( $menu_utility ) ) :
                echo $menu_utility;
              endif;
            ?>

          </div>
        </nav>
      </div><!-- end .header__wrap -->
    </header>
    <div id="header" class="js__observer"></div>
