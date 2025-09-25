<?php

  /* PPS template for news item (post) teasers */
  /* Also used for Events custom post type teasers when using the Upcoming Events template (events-page.php) */
  /* Must be used inside a Wordpress while() loop */
  
  $classes = 'news-posts__item';
  if ( !has_post_thumbnail() ) {
    $classes .= ' without-post-thumb';
  }
?>
  <article <?php post_class( $classes ) ?>>
<?php
  if ( has_post_thumbnail() ) {
    echo '<div class="post-thumb news-posts__item__thumb" style="margin-block-end: var(--wp--preset--spacing--sm)">';
    the_post_thumbnail();
    echo '</div>';
  }
?>
    <div class="news-posts__item__content">
      <?php
        if ( 'events' == get_post_type() ) {
          $startdate = strtotime( get_post_meta( get_the_ID(), '_event_start_date', true ) );
          $enddate = strtotime( get_post_meta( get_the_ID(), '_event_end_date', true ) );
          if ( !empty( $startdate ) ) {
            echo '<p class="event-date pps__tag pps__tag--alt">';
            echo '<time class="event__start" datetime="'. date( 'Y-m-d', $startdate ) .'">'. date( 'F j, Y', $startdate ) .'</time>';
            if ( !empty( $enddate ) ) {
              echo '<span class="event__join"> through </span>';
              echo '<time class="event__start" datetime="'. date( 'Y-m-d', $enddate ) .'">'. date( 'F j, Y', $enddate ) .'</time>';
            }
            echo '</p>';
          }
        }
      ?>
      <h3 class="news-posts__item__title" style="margin-block-end: var(--wp--preset--spacing--sm)"><a class="news-posts__item__link" href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
      <p class="news-posts__item__excerpt">
        <?php echo get_the_excerpt() ?>
      <?php if ( get_post_type() != 'events' && !is_author() ) { ?>
        <?php if ( ! empty( get_the_author() ) ) { ?>
        <i class="has-accent-font-family">By <?php the_author() ?></i>
        <?php } ?>
      <?php } ?>
      </p>
    </div>
  </article>
