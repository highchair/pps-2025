<?php

  // Register custom post types and associated taxonomies
  if ( ! function_exists( 'pps_custom_post_types' ) ) :
    function pps_custom_post_types() {

      // In the Press custom post type
      register_post_type('in-the-press',
        array(
          'labels'          => array(
            'name'          => 'In the Press',
            'singular_name' => 'In the Press',
          ),
          'public'             => true,
          'has_archive'        => false,
          'publicly_queryable' => true,
          'query_var'          => false, // Makes single view not accessible (redirects to homepage)
          'show_in_nav_menus'  => true,
          'show_in_admin_bar'  => true,
          'show_in_rest'       => true,
          'menu_icon'          => 'dashicons-feedback',
          'supports'           => array('title', 'editor', 'page-attributes'),
        )
      );

      // Advocacy custom post type
      register_post_type('advocacy',
        array(
          'labels' => array(
            'name'          => 'Advocacy',
            'singular_name' => 'Advocacy',
          ),
          'public'             => true,
          'has_archive'        => false,
          'publicly_queryable' => true,
          'show_in_nav_menus'  => true,
          'show_in_admin_bar'  => true,
          'show_in_rest'       => true,
          'menu_icon'          => 'dashicons-megaphone',
          'supports'           => array('title', 'editor', 'author', 'page-attributes'),
          'rewrite'            => array('slug' => 'active-advocacy', 'with_front' => false),
        )
      );

      // Advocacy custom taxonomy
      register_taxonomy('advocacy-project', 'advocacy',
        array(
        'labels' => array(
          'name'          => 'Advocacy Projects',
          'singular_name' => 'Advocacy Project'
        ),
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rest_base'         => 'advocacy-project',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
      ));
 
      // Events custom post type
      register_post_type('events',
        array(
          'labels' => array(
            'name'          => 'Events',
            'singular_name' => 'Event',
          ),
          'public'             => true,
          'has_archive'        => true,
          'publicly_queryable' => true,
          'show_in_nav_menus'  => true,
          'show_in_admin_bar'  => true,
          'show_in_rest'       => true,
          'menu_icon'          => 'dashicons-calendar-alt',
          'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        )
      );
    }
  endif;
  add_action('init', 'pps_custom_post_types');


  // Events custom post-type: Add support for date fields
  if ( ! function_exists( 'pps_event_post_type_meta_boxes' )) :
    function pps_event_post_type_meta_boxes() {
      add_meta_box(
        'event_date_string',            // Unique ID
        'Event Date(s)',                // Box title
        'pps_event_render_meta_boxes',  // Callback function
        'events',                       // Post type
        'side',                         // Context (normal, side, advanced)
        'high'                          // Priority (default, high, low)
      );
    }
  endif;
  add_action( 'add_meta_boxes', 'pps_event_post_type_meta_boxes' );


  // Events custom post-type: Define callback function to render custom field
  if ( ! function_exists( 'pps_event_render_meta_boxes' )) :
    function pps_event_render_meta_boxes( $post ) {
      // Add a nonce field for security
      wp_nonce_field( 'save_event_meta', 'event_meta_nonce' );

      // Retrieve existing values
      $event_start_date = get_post_meta( $post->ID, '_event_start_date', true );
      $event_end_date = get_post_meta( $post->ID, '_event_end_date', true );
  
      // Output the form fields
      echo '<p>';
      echo '<label for="event_start_date">Event Start Date (required):</label>';
      echo '<input type="date" id="event_start_date" name="event_start_date" value="' . esc_attr( $event_start_date ) . '" style="width: 100%;" required />';
      echo '</p>';
  
      echo '<p>';
      echo '<label for="event_end_date">Event End Date:</label>';
      echo '<input type="date" id="event_end_date" name="event_end_date" value="' . esc_attr( $event_end_date ) . '" style="width: 100%;" />';
      echo '</p>';
    }
  endif;


  // Events custom post-type: Save meta box data on post save
  if ( ! function_exists( 'pps_save_event_meta' )) :
    function pps_save_event_meta( $post_id ) {
      // Verify the nonce
      if ( ! isset( $_POST['event_meta_nonce'] ) || ! wp_verify_nonce( $_POST['event_meta_nonce'], 'save_event_meta' ) ) {
        return;
      }
  
      // Check if the current user can edit the post
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
      }
  
      // Save the custom fields
      if ( isset( $_POST['event_start_date'] ) ) {
        update_post_meta( $post_id, '_event_start_date', sanitize_text_field( $_POST['event_start_date'] ) );
      }
      if ( isset( $_POST['event_end_date'] ) ) {
        update_post_meta( $post_id, '_event_end_date', sanitize_text_field( $_POST['event_end_date'] ) );
      }
    }
  endif;
  add_action( 'save_post', 'pps_save_event_meta' );


  // Events custom post-type — Admin display: Add a column to the event post type list for date
  if ( ! function_exists( 'pps_add_event_date_column' ) ) :
    function pps_add_event_date_column( $columns ) {
      // To place the column in a specific position, we create a new array
      $new_columns = array();
      foreach ( $columns as $key => $title ) {
        $new_columns[$key] = $title;
        // Add our custom column after the 'title' column
        if ( $key === 'title' ) {
          $new_columns['event_start_date'] = 'Event Start Date';
        }
      }
      return $new_columns;
    }
  endif;
  add_filter( 'manage_events_posts_columns', 'pps_add_event_date_column' );


  // Events custom post-type — Admin display: Display the date in the custom column
  if ( ! function_exists( 'pps_display_event_date_column' ) ) :
    function pps_display_event_date_column( $column, $post_id ) {
      // Check if this is our custom column
      if ( 'event_start_date' === $column ) {
        $start_date = get_post_meta( $post_id, '_event_start_date', true );

        if ( $start_date ) {
          // Format the date for display
          echo date( 'F j, Y', strtotime( $start_date ) );
        } else {
          // Display a dash if no date is set
          echo '—';
        }
      }
    }
  endif;
  add_action( 'manage_events_posts_custom_column', 'pps_display_event_date_column', 10, 2 );


  // Events custom post-type — Admin display: Make the custom column sortable
  if ( ! function_exists( 'pps_event_date_column_sortable' ) ) :
    function pps_event_date_column_sortable( $columns ) {
      $columns['event_start_date'] = 'event_start_date';
      return $columns;
    }
  endif;
  add_filter( 'manage_edit-events_sortable_columns', 'pps_event_date_column_sortable' );


  // Events custom post-type — Admin display: Handle the sorting logic for the custom column
  if ( ! function_exists( 'pps_event_date_column_orderby' ) ) :
    function pps_event_date_column_orderby( $query ) {
      // Check if we are in the admin area and this is the main query
      if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
      }

      // Check if the query is ordered by our custom column
      if ( 'event_start_date' === $query->get( 'orderby' ) ) {
        $query->set( 'meta_key', '_event_start_date' );
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'meta_type', 'DATE' );
      }
    }
  endif;
  add_action( 'pre_get_posts', 'pps_event_date_column_orderby' );
