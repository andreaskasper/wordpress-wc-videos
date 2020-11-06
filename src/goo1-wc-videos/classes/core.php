<?php

namespace plugins\goo1\wc\videos;

class core {
	
  public static function init() {
    add_action("woocommerce_loaded", [__CLASS__, "woocommerce_loaded"] );
  }
  
  public static function goo1_loaded() {


    //add_action( 'init', function() {
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
          register_post_type( 'videos', $args );
      //});

      
    

    /*Registriere die neuen Elementor Elemente*/
    add_action( 'elementor/widgets/widgets_registered', function() {
      add_action( 'elementor/elements/categories_registered', function($elements_manager) {
        $elements_manager->add_category(
          'andreaskasper',
          [
            'title' => "Andreas Kasper",
            'icon' => 'fa fa-plug',
          ]
        );
        $elements_manager->add_category(
          'tanzschule',
          [
            'title' => __("Dancestudio", "goo1-wc-videos"),
            'icon' => 'fa fa-plug',
          ]
        );
      });
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \plugins\goo1\wc\videos\elementor\widgets\Player());
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \plugins\goo1\wc\videos\elementor\widgets\Videolist());
    });
	
  }

  public static function woocommerce_loaded() {
    \plugins\goo1\wc\videos\woocommerce::init();
    
    /*add_filter( 'product_type_selector', function($types) {
      $types['video'] = __( 'Video', 'goo1-wc-videos' );
      return $types;
    });*/
    //$a = new plugins\goo1\wc\videos\woocommerce\Product_Type_Video();
  }
  
}