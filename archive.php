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
      echo '<h2 class="news-posts__title recent-posts__title has-default-font-family has-h-4-font-size"><b>';

      // Start the title
      if (is_category()) { 
        echo 'From Category: ';
      } elseif (is_tag()) {
        echo 'From Tag: ';
      } elseif (is_author()) {
        echo 'From Author: ';
      }

      // Main portion of the title
      if ( is_category() ) { 
        single_cat_title();
      } elseif ( is_tag() ) {
        single_tag_title();
      } elseif ( is_author() ) {
        global $post;
        $author_id = $post->post_author;
        echo get_the_author_meta( 'display_name', $author_id );
      } else {
        echo 'Archives';
      }

      // Now add a page number if there is one
      if ( is_paged() ) {
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        echo ' (page ' . $paged .')'; 
      }
      echo '</b></h2>';

      // Now the Loop
      if ( have_posts() ) { 
        while ( have_posts() ) { the_post();
          get_template_part('template-parts/post-teaser');
        }
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
