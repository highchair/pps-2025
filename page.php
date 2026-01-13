<?php
/**
 *
 * Template Name: Basic Page with Header
 * The template file for a Page
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );
?>
  <main id="main" class="site-main">

  <?php if ( is_front_page() ) { ?>
    <article class="editor-styles-wrapper">
    <?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();
        the_content();
      endwhile; endif;
    ?>
    </article>

  <?php } else { ?>

    <article>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <header class="page__header has-grad-primary-gradient-background" style="padding-block: var(--wp--preset--spacing--md-xl); padding-inline: var(--space-container-inline);">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <?php bcn_display(); ?>
        </nav>
        <h1 class="page__title has-primary-color has-accent-light-weight"><?php the_title(); ?></h1>
      </header>
      <div class="editor-styles-wrapper" style="padding-block: var(--wp--preset--spacing--md-xl);">

      <?php the_content(); ?>

      </div>
      <?php endwhile; endif; ?>
    </article>
  <?php } ?>

  </main>
<?php
  get_template_part( 'template-parts/footer' );