<?php

  /* 
   * Custom code to enable more than one author on the built-in post type
   */

  /* Add meta box for multiple authors + guest author fields */
  if ( ! function_exists( 'pps_multi_author_metabox' ) ) :
    function pps_multi_author_metabox() {
      add_meta_box(
        'multi_author_box',
        'Authors',
        'pps_render_multi_author_box',
        'post',
        'side',
        'default'
      );
    }
    add_action( 'add_meta_boxes', 'pps_multi_author_metabox' );
  endif;

  /* Render the meta box content */
  if ( ! function_exists( 'pps_render_multi_author_box' ) ) :
    function pps_render_multi_author_box( $post ) {
      // Retrieve existing data
      $selected_authors = get_post_meta( $post->ID, '_co_authors', true );
      $guest_name       = get_post_meta( $post->ID, '_guest_author_name', true );
      $guest_title      = get_post_meta( $post->ID, '_guest_author_title', true );

      if ( ! is_array( $selected_authors ) ) {
        $selected_authors = [];
      }

      // Nonce
      wp_nonce_field( 'save_multi_authors', 'multi_authors_nonce' );

      // Get all users with authoring capability
      $users = get_users( [ 'who' => 'authors', 'orderby' => 'display_name' ] );

      // Get the value of a checkbox to replace main author with guest
      $guest_replace = get_post_meta( $post->ID, '_guest_author_replaces_main', true );
?>

<p><strong>Select Additional Authors:</strong></p>
<select name="co_authors[]" multiple style="width:100%; min-height:100px; margin-block-end: 1rem;">
  <?php foreach ( $users as $user ) : ?>
  <option value="<?php echo esc_attr( $user->ID ); ?>" <?php selected( in_array( $user->ID, $selected_authors ) ); ?>>
    <?php echo esc_html( $user->display_name ); ?>
  </option>
  <?php endforeach; ?>
</select>

<p><strong>or an optional Guest Author</strong></p>
<p>
  <label>Name:<br>
    <input type="text" name="guest_author_name" value="<?php echo esc_attr( $guest_name ); ?>" style="width:100%;">
  </label>
</p>
<p>
  <label>Title / Credentials:<br>
    <input type="text" name="guest_author_title" value="<?php echo esc_attr( $guest_title ); ?>" style="width:100%;">
  </label>
</p>
<p>
  <label>
    <input type="checkbox" name="guest_author_replaces_main" value="1" <?php checked( $guest_replace, '1' ); ?>>
    Replace Main Author with Guest Author?
  </label>
</p>
 <?php
    }
  endif;
  // No action required

  /*  Save the authors meta when the post is saved */
  if ( ! function_exists( 'pps_save_multi_author_meta' ) ) :
    function pps_save_multi_author_meta( $post_id ) {
      // Check nonce
      if ( ! isset( $_POST['multi_authors_nonce'] ) || ! wp_verify_nonce( $_POST['multi_authors_nonce'], 'save_multi_authors' ) ) {
        return;
      }

      // Check autosave and permissions
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
      if ( ! current_user_can( 'edit_post', $post_id ) ) return;

      // Save co-authors
      if ( isset( $_POST['co_authors'] ) && is_array( $_POST['co_authors'] ) ) {
        $authors = array_map( 'intval', $_POST['co_authors'] );
        update_post_meta( $post_id, '_co_authors', $authors );
      } else {
        delete_post_meta( $post_id, '_co_authors' );
      }

      // Get value of Guest Replace checkbox
      $guest_replace = isset( $_POST['guest_author_replaces_main'] ) ? '1' : '0';

      // Save guest author info
      update_post_meta( $post_id, '_guest_author_name', sanitize_text_field( $_POST['guest_author_name'] ?? '' ) );
      update_post_meta( $post_id, '_guest_author_title', sanitize_text_field( $_POST['guest_author_title'] ?? '' ) );
      update_post_meta( $post_id, '_guest_author_replaces_main', $guest_replace );
    }
    add_action( 'save_post_post', 'pps_save_multi_author_meta' );
  endif;

  /* Display authors and guest author info */
  if ( ! function_exists( 'pps_display_post_authors' ) ) :
    function pps_display_post_authors( $style = 'short', $post_id = null ) {
      $post_id = $post_id ?: get_the_ID();
      $author_names = [];

      // Get main author
      $main_author_id = get_post_field( 'post_author', $post_id );
      $main_author = get_userdata( $main_author_id );
      $author_names[] = $main_author->display_name;

      // Get co-authors if any are set
      $co_authors = (array) get_post_meta( $post_id, '_co_authors', true );
      foreach ( $co_authors as $aid ) {
        if ( $aid != $main_author_id ) {
          $u = get_userdata( $aid );
          if ( $u ) {
            $author_names[] = $u->display_name;
          }
        }
      }

      // Get guest author, if set
      $guest_name = get_post_meta( $post_id, '_guest_author_name', true );
      $guest_title = get_post_meta( $post_id, '_guest_author_title', true );
      $guest_replace = get_post_meta( $post_id, '_guest_author_replaces_main', true );
      if ( ! empty($guest_name) ) {
        $author_names[] = $guest_name;
      }

      // Start the Output

      // If the checkbox is true, than the Guest Author replaces the Main Author
      // At least the guest author name must also be set
      if ( $guest_replace === '1' && $guest_name ) {

        if ( $style == 'short' ) {
          // Guest replaces Main, short form for a post Card
          echo '<i class="has-accent-font-family">By '. $guest_name .'</i>';
        } else {
          // Guest replaces Main, long form for the Single article display
          echo '<p class="single__header__author">By '. $guest_name;
          if ( ! empty($guest_title) ) {
            echo '<span class="separator"></span>'.$guest_title;
          }
          echo '</p>';
        }

      } else {

        // Guest does not replace the Main Author

        // Are there co-authors?
        if ( count($author_names) > 1 ) {
 
          // If yes, only output the names as a list. No titles or emails, and it might include a guest author name as well
          if ( $style == 'short' ) {
            // Co-authors exist, authors as a list, short form for a post Card
            echo '<i class="has-accent-font-family">By '. esc_html( implode( ', ', $author_names ) ) .'</i>';
          } else {
            // Co-authors exist, authors as a list, long form for the Single article display
            echo '<p class="single__header__author">By '. esc_html( implode( ', ', $author_names ) ) .'</p>';
          }

        } else {

          // No, there are no co-authors. Main author only
          if ( $style == 'short' ) {
            // Main author only, short form
            echo '<i class="has-accent-font-family">By '. $main_author->display_name .'</i>';
          } else {
            // Main author only, long form
            $jobtitle = $main_author->user_description;
            echo '<p class="single__header__author">By <a href="'. esc_url( get_author_posts_url( $main_author_id ) ).'">'. $main_author->display_name .'</a><span class="separator"></span>';
            if ( $jobtitle ) {
              echo $jobtitle . '<span class="separator"></span>';
            }
            echo '<a href="mailto:'. $main_author->user_email .'">'. $main_author->user_email .'</a></p>';
          }

          // Done!
        }
      } // end if $guest_replace
    }
  endif;
  // No action needed
