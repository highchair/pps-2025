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
    <?php
      $category = get_queried_object();

      $category_query = new WP_Query( array(
        'post_type'           => 'post',
        'ignore_sticky_posts' => 1,
        'cat'                 => $category->term_id,
        'orderby'             => 'date',
        'order'               => 'DESC',
        'paged'               => $paged,
      ) );

      echo '<div class="cols-9-3">';

      if ( $category_query->have_posts() ) :
        echo '<section class="recent-posts" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--space-container-inline);">';
        echo '<h2 class="news-posts__title recent-posts__title has-default-font-family has-h-4-font-size"><b>';
        // The name of the category
        echo single_cat_title( '', false );
        if ( is_paged() ) {
          $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
          echo ' (page ' . $paged .')'; 
        }
        echo '</b></h2>';

        /* Start the Loop */
        while ( $category_query->have_posts() ) : $category_query->the_post();

          get_template_part( 'template-parts/post-teaser' );

        endwhile;

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
      else :

        get_template_part( 'template-parts/no-posts' );

      endif;
    ?>

    </article>
  </main>
<?php
  get_template_part( 'template-parts/footer' );
