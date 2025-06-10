<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PPS 2025
 */

$pps_header_path = locate_template( 'template-parts/header.php', false, false );
if ( $pps_header_path ) {
  load_template( $pps_header_path, true );
}
?>

  <main id="main" class="site-main">
    <article class="">
      <pre>
        This is the single-post.php template
      </pre>
      <?php
      if ( have_posts() ) :

        if ( (is_home()) && (! is_paged()) ) :
          ?>
          <header class="page-header">
            <h1>Function is_home() is true!</h1>
            <p>index.php file</p>
          </header>
          <?php
        endif;

        /* Start the Loop */
        while ( have_posts() ) :
          the_post();

          /*
          * Include the Post-Type-specific template for the content.
          * If you want to override this in a child theme, then include a file
          * called content-___.php (where ___ is the Post Type name) and that will be used instead.
          */
          get_template_part( 'template-parts/content', get_post_type() );

        endwhile;

        //pps_pagination();

      else :

        get_template_part( 'template-parts/content', 'none' );

      endif;
    ?>

    </article>
  </main>

<?php
$pps_footer_path = locate_template( 'template-parts/footer.php', false, false );
if ( $pps_footer_path ) {
  load_template( $pps_footer_path, true );
}
