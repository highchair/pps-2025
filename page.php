<?php
/**
 * The template file for a Page
 *
 * @package PPS 2025
 */

$pps_header_path = locate_template( 'template-parts/header.php', false, false );
if ( $pps_header_path ) {
  load_template( $pps_header_path, true );
}
?>
  <main id="main" class="site-main">
    <article>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <header class="page__header has-grad-primary-gradient-background" style="padding-block: var(--wp--preset--spacing--md-xl); padding-inline: var(--space-container-inline);">
        <h1 class="page__title has-primary-color has-accent-light-weight"><?php the_title(); ?></h1>
      </header>
      <div class="editor-styles-wrapper" style="padding-block: var(--wp--preset--spacing--md-xl);">

      <?php the_content(); ?>

      </div>
      <?php endwhile; endif; ?>
    </article>
  </main>
<?php
$pps_footer_path = locate_template( 'template-parts/footer.php', false, false );
if ( $pps_footer_path ) {
  load_template( $pps_footer_path, true );
}