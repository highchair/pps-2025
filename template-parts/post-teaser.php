<?php

  /* PPS template for news item (post) teasers */
  /* Must be used inside a Wordpress while() loop */
?>
  <article <?php post_class( 'news-posts__item' ) ?>>
<?php
  if ( has_post_thumbnail() ) {
    echo '<div class="post-thumb news-posts__item__thumb" style="margin-block-end: var(--wp--preset--spacing--sm)">';
    the_post_thumbnail();
    echo '</div>';
  }
?>
    <div class="news-posts__item__content">
      <h3 class="news-posts__item__title" style="margin-block-end: var(--wp--preset--spacing--sm)"><a class="news-posts__item__link" href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
      <p class="news-posts__item__excerpt"><?php echo get_the_excerpt() ?> <i class="has-accent-font-family">By <?php the_author() ?></i></p>
    </div>
  </article>
