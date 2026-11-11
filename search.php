<?php
/**
 * The archive template file
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );
?>
  <main id="main" class="site-main">
    <article>
      <div class="cols-9-3">
        <section class="recent-posts" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--space-container-inline);">
    <?php
      echo '<h1 class="news-posts__title recent-posts__title has-default-font-family has-h-4-font-size"><b>Results for: ' . esc_attr( get_search_query() ) .'</b></h1>';

      // Now the Loop
      if ( have_posts() ) { 
        while ( have_posts() ) { the_post();
          get_template_part('template-parts/post-teaser');
        }
      } else {
        echo '<h2>No Results</h2>';
        echo '<p>We’re sorry but no results were found.</p>';
      }

      echo '</section>';
      if ( is_active_sidebar( 'news-aside' ) ) {
        dynamic_sidebar( 'news-aside' );
      }
      echo '</div>';
      echo '<footer class="recent-posts__pagination" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--space-container-inline);">';

      the_posts_pagination( array(
        'mid_size'  => 4,
        'prev_text' => 'Newer',
        'next_text' => 'Older',
      ) );

      echo '</footer>';
    ?>

    </article>
  </main>
<?php
  get_template_part( 'template-parts/footer' );
