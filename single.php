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
        while ( have_posts() ) :
          the_post();
      ?>

      <header class="">
        <div class="">
          <p>
            <?php
              $categories = get_the_category();
              if ( ! empty( $categories ) ) {
                $category = $categories[0];
                echo '<a class="pps__tag" href="' . esc_url( get_category_link( $category->term_id ) ) . '">'. esc_html( $category->name ) .'</a>';
              }
            ?>
          </p>
          <h1><?php single_post_title(); ?></h1>
          <p>
            By <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
            <span class="separator"></span>
            <?php
              $jobtitle = get_the_author_meta( 'user_description' );
              if ($jobtitle) {
                echo $jobtitle . '<span class="separator"></span>';
              }
              echo '<a href="mailto:'. get_the_author_meta( 'user_email' ) .'">'. get_the_author_meta( 'user_email' ) .'</a>';
            ?>
          </p>
        </div>
        <div class="">
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
      <div class="">

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
        <div class="single__tags">
          <?php
            $tags = get_the_tags();
            if ( ! empty( $tags ) ) {
              echo '<p class="single__tags__label">Tags:</p><ul class="single__tags__list" role="list">';
              foreach( $tags as $tag ) {
                echo '<li><a class="pps__tag" href="'. esc_attr( get_tag_link( $tag->term_id ) ) .'">'. $tag->name .'</a></li>';
              }
              echo '</ul>';
            }
          ?>
        </div>
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
$pps_footer_path = locate_template( 'template-parts/footer.php', false, false );
if ( $pps_footer_path ) {
  load_template( $pps_footer_path, true );
}
