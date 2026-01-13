<?php
/**
 *
 * Template Name: Basic Page without Header
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );
?>
  <main id="main" class="site-main">

    <article>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1 class="page__title has-primary-color has-accent-light-weight screen-reader-text "><?php the_title(); ?></h1>
      <div class="editor-styles-wrapper">

      <?php the_content(); ?>

      </div>
      <?php endwhile; endif; ?>
    </article>

  </main>
<?php
  get_template_part( 'template-parts/footer' );