<?php

  /* PPS template for news item (post) teasers */
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
      <?php if ( 'events' == get_post_type() ) { ?>
        <?php if ( get_field('event_date') ) { ?>
          <p class="event-date pps__tag pps__tag--alt"><span role="time"><?php the_field('event_date'); ?></span></p>
        <?php } ?>
      <?php } ?>
      <h3 class="news-posts__item__title" style="margin-block-end: var(--wp--preset--spacing--sm)"><a class="news-posts__item__link" href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
      <p class="news-posts__item__excerpt">
        <?php echo get_the_excerpt() ?>
      <?php if ( 'events' != get_post_type() && !is_author() ) { ?>
        <i class="has-accent-font-family">By <?php the_author() ?></i>
      <?php } ?>
      </p>
    </div>
  </article>
