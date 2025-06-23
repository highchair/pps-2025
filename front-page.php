<?php
/**
 * The front-page (Home) template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );
?>

    <main id="main" class="l__main">
      <article class="editor-styles-wrapper">
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
  get_template_part( 'template-parts/footer' );
