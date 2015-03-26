<?php


//************KÖPFE************//

add_action( 'init', 'create_heads' );
function create_heads() {
  $labels = array(
    'name' => _x('Personen', 'post type general name'),
    'singular_name' => _x('Person', 'post type singular name'),
    'add_new' => _x('Neue hinzufügen', 'Personen'),
    'add_new_item' => __('Neue Person hinzufügen'),
    'edit_item' => __('Person bearbeiten'),
    'new_item' => __('Neue Person'),
    'view_item' => __('Person anschauen'),
    'search_items' => __('Person suchen'),
    'not_found' =>  __('Keine Person gefunden'),
    'not_found_in_trash' => __('Keine Person im Papierkorb gefunden'),
    'parent_item_colon' => ''
  );
 
  $supports = array('title', 'editor', 'revisions', 'thumbnail');
 
  register_post_type( 'person',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports
    )
  );
}

?>