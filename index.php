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
    <?php
      $sticky = get_option( 'sticky_posts' );
  
      if ( ! empty( $sticky ) ) {
        // Query the most recent 3 sticky posts
        $sticky_query = new WP_Query( array(
          'post__in'           => $sticky,
          'posts_per_page'     => 3,
          'ignore_sticky_posts'=> 1,
          'orderby'            => 'date',
          'order'              => 'DESC'
        ) );
  
        if ( $sticky_query->have_posts() ) :
          echo '<section class="sticky-posts" style="padding-block: var(--wp--preset--spacing--xl); padding-inline: var(--wp--preset--spacing--md);">';
          echo '<h2 class="news-posts__title sticky-posts__title has-default-font-family has-h-4-font-size"><b>Featured Posts</b></h2>';
  
          while ( $sticky_query->have_posts() ) : $sticky_query->the_post();
            echo '<article ';
            post_class( 'sticky-posts__item' );
            echo '>';
            if ( has_post_thumbnail() ) {
              echo '<div class="post-thumb sticky-posts__thumb" style="margin-block-end: var(--wp--preset--spacing--sm)">';
              echo get_the_post_thumbnail();
              echo '</div>';
            }
            echo '<h3 class="sticky-posts__item__title" style="margin-block-end: var(--wp--preset--spacing--sm)"><a href="'. get_permalink() .'">'. get_the_title() . '</a></h3>';
            echo '<p class="sticky-posts__excerpt">';
            echo get_the_excerpt();
            echo '<i>By '. get_the_author() .'</i>';
            echo '</p>';
            echo '</article>';
          endwhile;
  
          echo '</section>';
          wp_reset_postdata();
        endif;
      }

      if ( have_posts() ) :

        /* Start the Loop */
        while ( have_posts() ) :
          the_post();

          echo '<h3>'. the_title() .'</h3>';

        endwhile;

        //pps_pagination();

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
