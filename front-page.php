<?php
/**
 * The front-page (Home) template file
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

    <main id="main" class="l__main">
      <article class="v__rhythm editor-styles-wrapper">
        <pre>
          This is the front-page.php template
        </pre>
      <?php
        if ( have_posts() ) :
          while ( have_posts() ) : the_post();
            the_content();
          endwhile;
        endif;
      ?>
  
      </article>
    </main>

<?php
$pps_footer_path = locate_template( 'template-parts/footer.php', false, false );
if ( $pps_footer_path ) {
  load_template( $pps_footer_path, true );
}
