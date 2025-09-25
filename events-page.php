<?php
/**
 * Template Name: Upcoming Events
 *
 * The template file for an Events archive
 *
 * @package PPS 2025
 */

  get_template_part( 'template-parts/header' );
?>

  <main id="main" class="l__main">
    <article>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <header class="page__header has-grad-primary-gradient-background" style="padding-block: var(--wp--preset--spacing--md-xl); padding-inline: var(--space-container-inline);">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <?php bcn_display(); ?>
        </nav>
        <h1 class="page__title has-primary-color has-accent-light-weight"><?php single_post_title() ?></h1>
      </header>
    <?php
      $content = apply_filters( 'the_content', get_the_content() );
      if ( !empty($content) ) {
        echo '<section class="editor-styles-wrapper" style="padding-block-start: var(--wp--preset--spacing--md-xl);">';

        /* Display allowed block content */
        echo $content;

        echo '</section>';
      }
      endwhile; endif;

      /*
       * Loop through events and find what is upcoming
       * Get today's date but subtract a week so that we don’t immediately remove dates in the past
       * (this also negates the need for us to check the end date, which would complicate things)
       */
      $one_week_ago = date('Y-m-d', strtotime('-1 week'));
      $two_months_ago = date('Y-m-d', strtotime('-2 months'));

      // Custom query for upcoming
      $upcoming_events = new WP_Query( array(
        'post_type'      => 'events',
        'posts_per_page' => -1,
        'meta_query'     => array(
          array(
            'key'        => '_event_start_date',
            'value'      => $one_week_ago,
            'compare'    => '>=',
            'type'       => 'DATE',
          ),
        ),
        'orderby'        => 'meta_value',
        'meta_type'      => 'DATE',
        'order'          => 'ASC', // Show the nearest event to last week’s date first
      ) );

      if ( $upcoming_events->have_posts() ) {
        echo '<section class="events-list upcoming-events" style="padding-block: var(--wp--preset--spacing--lg); margin-inline: auto; max-width: var(--wp--style--global--content-size);">';

        while ( $upcoming_events->have_posts() ) :    
          $upcoming_events->the_post();
          get_template_part('template-parts/post-teaser');
        endwhile;

        wp_reset_postdata();

        echo '</section>';
      }

      // Another custom query for past events
      $past_events = new WP_Query( array(
        'post_type'      => 'events',
        'posts_per_page' => -1,
        'meta_query'     => array(
          'relation' => 'AND', // Both conditions must be true
          array(
            'key'        => '_event_start_date',
            'value'      => $two_months_ago,
            'compare'    => '>=', // Must be on or after two months ago
            'type'       => 'DATE',
          ),
          array(
            'key'        => '_event_start_date',
            'value'      => $one_week_ago,
            'compare'    => '<=', // Must be on or before this week
            'type'       => 'DATE',
          ),
        ),
        'orderby'        => 'meta_value',
        'meta_type'      => 'DATE',
        'order'          => 'DESC', // Show the most recent past events first
      ) );

      if ( $past_events->have_posts() ) {
        echo '<section class="has-primary-tint-lt-background-color" style="padding-block: var(--wp--preset--spacing--lg);"><div class="events-list past-events" style="margin-inline: auto; max-width: var(--wp--style--global--content-size);"><h2 class="has-h-4-font-size" style="margin-block-end: var(--wp--preset--spacing--md)"><i>Events you just missed…</i></h2>';
      
        while ( $past_events->have_posts() ) :    
          $past_events->the_post();
          get_template_part('template-parts/post-teaser');
        endwhile;

        wp_reset_postdata();

        echo '</div></section>';
      }
    ?>
  </article>
</main>

<?php
  get_template_part( 'template-parts/footer' );