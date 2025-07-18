<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 *
 * For the PPS theme, this powers the News landing page and nothing else
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );
?>
  <main id="main" class="site-main">
    <article>
      <header class="prov-post has-grad-primary-gradient-background" style="padding-block: var(--wp--preset--spacing--md); padding-inline: var(--space-container-inline);">
        <h1 class="sr">The Providence Post</h1>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/prov-post-masthead_transparent.png" alt="" />
        <nav aria-label="Providence Post" class="prov-post-nav">
          <ul role="list">
            <li><a href="/news/about-the-providence-post/">About the Post</a></li>
            <li><a href="/news/editorial-policies/">Editorial Policies</a></li>
            <li><a href="/news/submit/">Submit</a></li>
          </ul>
        </nav>
        <p class="has-accent-font-family"><i>Preservation, planning and urban design across Providence’s communities and neighborhoods.</i></p>
        <div class="newsletter">
          <p class="newsletter__description">Weekly alerts, news, and updates from PPS</p>
          <form class="newsletter__form" name="ccoptin" action="https://lp.constantcontactpages.com/sl/7HXon1T/providencepost" target="_blank" method="post">
            <input type="hidden" name="m" value="1102165220207">
            <input type="hidden" name="p" value="oi">
            <label for="email" class="sr">Email</label>
            <input type="email" id="email" name="ea" spellcheck="false" placeholder="email@domain.com">
            <input type="submit" name="go" class="btn__secondary" value="Subscribe">
          </form>
        </div>
      </header>
    <?php
      $sticky = get_option( 'sticky_posts' );
  
      if ( ! empty( $sticky ) && !is_paged() ) {
        // Query the most recent 3 sticky posts
        $sticky_query = new WP_Query( array(
          'post__in'           => $sticky,
          'posts_per_page'     => 3,
          'ignore_sticky_posts'=> 1,
          'orderby'            => 'date',
          'order'              => 'DESC'
        ) );
  
        /* Check for Sticky and Start the Loop */
        if ( $sticky_query->have_posts() ) :
          echo '<section class="sticky-posts" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--space-container-inline);">';
          echo '<h2 class="news-posts__title sticky-posts__title has-default-font-family has-h-4-font-size"><b>Featured Posts</b></h2>';
  
          while ( $sticky_query->have_posts() ) : $sticky_query->the_post();

            get_template_part( 'template-parts/post-teaser' );

          endwhile;
  
          echo '</section>';
          wp_reset_postdata();
        endif;
      }

      $non_sticky_query = new WP_Query( array(
        'post_type'           => 'post',
        'ignore_sticky_posts' => 1,
        'post__not_in'        => get_option( 'sticky_posts' ),
        'orderby'             => 'date',
        'order'               => 'DESC',
        'paged'               => $paged,
        'category__not_in'   => array(3), // Hide announcements category
      ) );

      echo '<div class="cols-9-3">';

      if ( $non_sticky_query->have_posts() ) :
        echo '<section class="recent-posts" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--space-container-inline);">';
        echo '<h2 class="news-posts__title recent-posts__title has-default-font-family has-h-4-font-size"><b>More Stories';
        if ( is_paged() ) {
          $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
          echo ' (page ' . $paged .')'; 
        }
        echo '</b></h2>';

        /* Start the Loop */
        while ( $non_sticky_query->have_posts() ) : $non_sticky_query->the_post();

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

