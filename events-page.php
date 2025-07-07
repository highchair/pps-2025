<?php
/**
 * The template file for an Events archive
 *
 * @package PPS 2025
 */

  $featured_event = get_field('featured_event');
  if ( $featured_event ) {
    $featured_id = $featured_event->ID;
  } else {
    $featured_id = null;
  }
  get_template_part( 'template-parts/header' );
?>

  <main id="main" class="l__main">
    <article>
      <header class="page__header has-grad-primary-gradient-background" style="padding-block: var(--wp--preset--spacing--md-xl); padding-inline: var(--space-container-inline);">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <?php bcn_display(); ?>
        </nav>
        <h1 class="page__title has-primary-color has-accent-light-weight">Upcoming Events</h1>
      </header>
      <section class="events-list" style="padding-block: var(--wp--preset--spacing--lg); margin-inline: auto; max-width: var(--wp--style--global--content-size);">

      <?php // featured event
        if( $featured_event ) { 
          $post = $featured_event;
          setup_postdata( $post );

          get_template_part('template-parts/post-teaser');

          wp_reset_postdata();
        }

        // loop through the rest of the events
        // How to not include past events in the query?
        $loop = new WP_Query( array(
          'post_type' => 'events',
          'posts_per_page' => -1,
          'post__not_in' => array($featured_id)
        ) );
        
        if ( $loop->have_posts() ) { 
          while ( $loop->have_posts() ) { 
            $loop->the_post();

            get_template_part('template-parts/post-teaser');

          }
        }

        // Pagination?
      ?>
      </section>
  </article>
</main>

<?php
  get_template_part( 'template-parts/footer' );