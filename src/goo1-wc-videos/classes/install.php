<?php

namespace plugins\goo1\wc\videos;

class install {
	
  public static function activation() {
    $args = array(
      'label' => __( 'Videos', 'kp_workshops' ),
      'description' => __( 'Videos für den Memberbereich', 'kp_workshops' ),
      /*'labels' => $labels,*/
      'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
      'taxonomies' => array( 'category', 'post_tag' ),
      'hierarchical' => false,
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 4,
      'menu_icon' => 'dashicons-format-video',
      'rewrite'     => array( 'slug' => 'videos' ),
      'show_in_admin_bar' => true,
      'show_in_nav_menus' => true,
      'can_export' => true,
      'has_archive' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'capability_type' => 'post',
      'show_in_rest' => true,
    );
      register_post_type( "videos", $args );
      flush_rewrite_rules();
  }

  public static function deactivation() {
    
  }
  
}