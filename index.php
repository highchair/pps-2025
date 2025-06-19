<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

  <main id="main" class="site-main">
    <article class="">
      <header class="prov-post has-grad-primary-gradient-background" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--wp--preset--spacing--md);">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/prov-post-masthead_transparent.png" alt="Providence Post" />
        <p class="has-accent-font-family"><i>Preservation, planning and urban design across Providence’s communities and neighborhoods.</i></p>
        <div class="newsletter">
          <div class="newsletter__description">
            <h2 class="has-h-3-font-size has-primary-color">Subscribe</h2>
            <p>Weekly alerts, news, and updates from PPS</p>
          </div>
          <form class="newsletter__form" name="ccoptin" action="https://visitor.constantcontact.com/d.jsp" target="_blank" method="post">
            <input type="hidden" name="m" value="1102165220207">
            <input type="hidden" name="p" value="oi">
            <label for="email" class="sr">Email</label>
            <input type="email" id="email" name="ea" spellcheck="false" placeholder="email@domain.com">
            <input type="submit" name="go" class="btn__secondary" value="Get our E-News">
          </form>
        </div>
      </header>
    <?php
      $sticky = get_option( 'sticky_posts' );
      $pps_post_teaser_path = locate_template( 'template-parts/post-teaser.php', false, false );
  
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
          echo '<section class="sticky-posts" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--wp--preset--spacing--md);">';
          echo '<h2 class="news-posts__title sticky-posts__title has-default-font-family has-h-4-font-size"><b>Featured Posts</b></h2>';
  
          while ( $sticky_query->have_posts() ) : $sticky_query->the_post();

            if ( $pps_post_teaser_path ) {
              load_template( $pps_post_teaser_path, false );
            }

          endwhile;
  
          echo '</section>';
          wp_reset_postdata();
        endif;
      }

      $non_sticky_query = new WP_Query( array(
        'post_type'           => 'post',
        'ignore_sticky_posts' => 1,
        'post__not_in'        => get_option( 'sticky_posts' ),
        'orderby'            => 'date',
        'order'              => 'DESC'
      ) );

      echo '<div class="cols-9-3">';

      if ( $non_sticky_query->have_posts() ) :
        echo '<section class="recent-posts" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--wp--preset--spacing--md);">';
        echo '<h2 class="news-posts__title recent-posts__title has-default-font-family has-h-4-font-size"><b>More Stories';
        if ( is_paged() ) {
          $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
          echo ' (page ' . $paged .')'; 
        }
        echo '</b></h2>';

        /* Start the Loop */
        while ( $non_sticky_query->have_posts() ) : $non_sticky_query->the_post();

          if ( $pps_post_teaser_path ) {
            load_template( $pps_post_teaser_path, false );
          }

        endwhile;

        echo '</section>';
        if ( is_active_sidebar( 'news-aside' ) ) {
          dynamic_sidebar( 'news-aside' );
        }
        echo '</div>';
        echo '<footer class="recent-posts__pagination" style="padding-block: var(--wp--preset--spacing--lg); padding-inline: var(--wp--preset--spacing--md);">';
  
        the_posts_pagination( array(
          'mid_size'  => 4,
          'prev_text' => 'Newer',
          'next_text' => 'Older',
        ) );

        echo '</footer>';
      else :

        // A message in case there is no content to show

      endif;
    ?>

    </article>
  </main>

<?php
$pps_footer_path = locate_template( 'template-parts/footer.php', false, false );
if ( $pps_footer_path ) {
  load_template( $pps_footer_path, true );
}
