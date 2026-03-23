<?php
/*
 * Template Name: In the Press
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );

  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
?>
  <main id="main" class="site-main">
    <article>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <header class="page__header has-grad-primary-gradient-background" style="padding-block: var(--wp--preset--spacing--md-xl); padding-inline: var(--space-container-inline);">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <?php bcn_display(); ?>
        </nav>
        <h1 class="page__title has-primary-color has-accent-light-weight">
          <?php
            the_title();

            // Now add a page number if there is one
            if ( is_paged() ) {
              echo ' <b>(page ' . $paged .')'; 
            }
            echo '</b>';
          ?>
        </h1>
      </header>
    <?php
      $content = apply_filters( 'the_content', get_the_content() );
      if ( !empty($content) ) {
        echo '<section class="editor-styles-wrapper" style="padding-block-start: var(--wp--preset--spacing--md-xl);">';
      
        /* Display allowed block content */
        echo $content;
      
        echo '</section>';
      }
      endwhile; endif;

      $press_query = new WP_Query( array(
        'post_type' => 'in-the-press',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 12,
        'paged' => $paged,
      ) );

      if ( $press_query->have_posts() ) {
        echo '<section class="in-the-press__posts" style="padding-block: var(--wp--preset--spacing--md-xl);">';
        echo '<h2 class="sr">Press mentions, newest first. All links go to external news sources.</h2>';


        while ($press_query->have_posts()) {
          $press_query->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <div class="in-the-press__content editor-styles-wrapper">
            <hr class="wp-block-separator" />

            <?php the_content(); ?>

            <?php edit_post_link('Edit This Post', '<p class="edit-link">', '</p>', null, 'btn__secondary'); ?>
          </div>
        </article>
      <?php
        } // endwhile

        echo '<footer class="in-the-press__pagination pagination" style="margin-block-start: var(--wp--preset--spacing--lg); padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--space-container-inline);"><nav class="nav-links" aria-label="Pagination">';

        echo paginate_links( array(
          'total' => $press_query->max_num_pages,
          'mid_size'  => 4,
          'current' => $paged,
          'format' => 'page/%#%',
          'prev_text' => 'Newer',
          'next_text' => 'Older',
          'add_args' => false,
        ) );

        echo '</nav></footer>';
        wp_reset_postdata();

      } else {

        get_template_part( 'template-parts/no-posts' );

        echo '</section>';
      }
    ?>
    </article>
  </main>
<?php
  get_template_part( 'template-parts/footer' );
