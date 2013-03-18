<?php
/* Let's define structural taxonomies */

if(!function_exists('legambiente_taxonomy_event_types') ) {
  function legambiente_taxonomy_event_types() {
    register_taxonomy(
      'event_types',
      'null',
      array(
        'label' => __( 'Tipi di evento' ),
        'rewrite' => array( 'slug' => 'event_types' ),
        'capabilities' => array(
          'assign_terms' => 'edit_taxonomies',
          'edit_terms' => 'publish_taxonomies'
        )
      )
    );
  }
}

add_action('init', 'legambiente_taxonomy_event_types');

?>
