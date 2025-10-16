<?php
/**
 * The single post template file
 * The design features a 50/50 column split header for desktop with optional Featured image
 *
 * In this theme, the Single template is used by posts and events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );
?>
  <main id="main" class="site-main">
    <article>
      <?php while ( have_posts() ) : the_post(); ?>
      <header class="single__header">
        <div class="single__header__start">
        <?php

          // If an event single, show the breadcrumbs
          if ( 'events' == get_post_type() ) {
            echo '<nav class="breadcrumb" aria-label="Breadcrumb">';
            bcn_display();
            echo '</nav>';
          } 

          // If there are categories, display the first one in the array
          $categories = get_the_category();
          if ( ! empty( $categories ) ) {
            echo '<p class="single__header__meta">';
            $category = $categories[0];
            echo '<a class="pps__tag--alt" href="' . esc_url( get_category_link( $category->term_id ) ) . '">'. esc_html( $category->name ) .'</a>';
            echo '</p>';
          }

          // Display post title
          echo '<h1 class="single__header__title has-xl-font-size">' . get_the_title() . '</h1>';

          // If an event, show the start and/or end dates
          if ( 'events' == get_post_type() ) {
            //$startdate = $enddate = new datetime();
            $startdate = strtotime( get_post_meta( get_the_ID(), '_event_start_date', true ) );
            $enddate = strtotime( get_post_meta( get_the_ID(), '_event_end_date', true ) );
            if ( !empty( $startdate ) ) {
              echo '<p class="single__header__event">';
              echo '<time class="event__start" datetime="'. date( 'Y-m-d', $startdate ) .'">'. date( 'l jS \of F\, Y', $startdate ) .'</time>';
              if ( !empty( $enddate ) ) {
                echo '<span class="event__join"> through </span>';
                echo '<time class="event__start" datetime="'. date( 'Y-m-d', $enddate ) .'">'. date( 'l jS \of F\, Y', $enddate ) .'</time>';
              }
              echo '</p>';
            }
          } else { 

            pps_display_post_authors( 'long' );

          }
        ?>
        </div>
        <div class="single__header__end">
        <?php
          if ( has_post_thumbnail() ) {
            $post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
            $post_thumbnail_class = '';

            if ( $post_thumbnail_id ) {
              $metadata = wp_get_attachment_metadata( $post_thumbnail_id );

              if ( $metadata ) {
                $width = intval( $metadata[ 'width' ] );
                $height = intval( $metadata[ 'height' ] );
                if ( $width < $height ) {
                  $post_thumbnail_class = "post-thumb--vertical";
                }
              }
            }
            echo '<div class="post-thumb '. $post_thumbnail_class .'">';
            echo get_the_post_thumbnail();
            echo '</div>';
          }
        ?>
        </div>
      </header>
      <div class="editor-styles-wrapper">

        <?php the_content(); ?>

      </div>
      <footer class="single__footer">
        <div class="single__category">
          <?php
            if ( ! empty( $categories ) ) {
              $category = $categories[0]; // First category
              echo '<p class="single__category__label">Published ' . get_the_date() . ' in ' . esc_html( $category->name ) . '. <a href="' . esc_url( get_category_link( $category->term_id ) ) . '">More from '. esc_html( $category->name ) .' category</a>.</p>';
            } else {
              echo '<p class="single__category__label">Published ' . get_the_date() . '.</p>';
            }
          ?>
        </div>
        <?php
          $tags = get_the_tags();
          if ( ! empty( $tags ) ) {
            echo '<div class="single__tags"><p class="single__tags__label">Tags:</p><ul class="single__tags__list" role="list">';
            foreach( $tags as $tag ) {
              echo '<li><a class="pps__tag" href="'. esc_attr( get_tag_link( $tag->term_id ) ) .'">'. $tag->name .'</a></li>';
            }
            echo '</ul></div>';
          }
        ?>
        <?php
          the_post_navigation(
            array(
              'prev_text' => '<span class="nav-label">Older</span><span class="nav-title">%title</span>',
              'next_text' => '<span class="nav-label">Newer</span><span class="nav-title">%title</span>',
            )
          );
        ?>
      </footer>
      <?php
        endwhile;
      ?>

    </article>
  </main>
<?php
  get_template_part( 'template-parts/footer' );
