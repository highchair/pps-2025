<?php
/*
 * Template Name: In the Press
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );
?>
  <main id="main" class="site-main">
    <article>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <header class="page__header has-grad-primary-gradient-background" style="padding-block: var(--wp--preset--spacing--md-xl); padding-inline: var(--space-container-inline);">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <?php bcn_display(); ?>
        </nav>
        <h1 class="page__title has-primary-color has-accent-light-weight"><?php the_title(); ?></h1>
      </header>
      <section class="editor-styles-wrapper" style="padding-block-start: var(--wp--preset--spacing--md-xl);">
    
      <?php
        /* Display allowed block content */
        the_content();
      ?>
    
      </section>
    <?php endwhile; endif; ?>
      <section class="in-the-press__posts" style="padding-block: var(--wp--preset--spacing--md-xl);">
      <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
          'post_type' => 'in-the-press',
          'orderby'   => 'date',
          'order'     => 'DESC',
          'paged'     => $paged,
        );

        $press_query = new WP_Query($args);

        if ($press_query->have_posts()) : 

          echo '<h2 class="sr">Press mentions, newest first. All links go to external news sources.</h2>';

          while ($press_query->have_posts()) : $press_query->the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="in-the-press__content editor-styles-wrapper">
              <hr class="wp-block-separator" />

              <?php the_content(); ?>

              <?php edit_post_link('Edit This Post', '<p class="edit-link">', '</p>', null, 'btn__secondary'); ?>
            </div>
          </article>
        <?php
          endwhile;

          echo '<footer class="recent-posts__pagination" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--space-container-inline);">';

          the_posts_pagination( array(
            'mid_size'  => 4,
            'prev_text' => 'Newer',
            'next_text' => 'Older',
          ) );

          echo '</footer>';
        
          wp_reset_postdata();
        else :
        
          get_template_part( 'template-parts/no-posts' );
        
        endif; ?>
      </section>
    </article>
  </main>
<?php
  get_template_part( 'template-parts/footer' );
