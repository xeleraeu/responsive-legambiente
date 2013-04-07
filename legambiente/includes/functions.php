<?php
/* ONE TRUE GLOBAL VAR */

$GLOBALS['LEGAMBIENTE'] = array();
$GLOBALS['LEGAMBIENTE']['webfonts']['collection_uri'] = 'https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,700,700italic|Open+Sans+Condensed:300,700|Droid+Sans:400,700';
$GLOBALS['LEGAMBIENTE']['frontpage_slider']['category'] = 'fp';

/* setup */

/**
 * enable excerpt field for pages
 * (see http://lewayotte.com/2010/07/01/easily-add-excerpt-support-for-pages-in-wordpress/)
 */
/* functions */
add_post_type_support('page', 'excerpt');

function enable_webfonts_collection() {
  wp_enqueue_style('legambiente-webfonts', $GLOBALS['LEGAMBIENTE']['webfonts']['collection_uri']);
}

add_action('wp_enqueue_scripts', 'enable_webfonts_collection', '', '');

function enable_plugin_flexslider() {
  wp_enqueue_script('jquery-plugin-flexslider', get_stylesheet_directory_uri() . '/assets/javascripts/jquery.flexslider.js', array('jquery'), false, true); // TODO: use .min.js in production
  wp_enqueue_style('jquery-plugin-flexslider', get_stylesheet_directory_uri() . '/assets/stylesheets/plugins/jquery.flexslider/flexslider.css');
}

// enable flexslider plugin
add_action('wp_enqueue_scripts', 'enable_plugin_flexslider', '', '');

if(!function_exists('legambiente_logo_overlay') ) {
  function legambiente_logo_overlay() {
    locate_template('templates/legambiente-logo.php', true, false);
  }
}

// enable mediaelement plugin
if(!function_exists('enable_plugin_mediaelement')) {
  function enable_plugin_mediaelement() {
      wp_enqueue_script('plugin-mediaelement-js', get_stylesheet_directory_uri() . '/assets/javascripts/mediaelement/mediaelement-and-player.min.js', array('jquery'), false, true);
      wp_enqueue_style('plugin-mediaelement-js', get_stylesheet_directory_uri() . '/assets/stylesheets/plugins/mediaelement/mediaelementplayer.min.css');
  }
}

add_action('wp_enqueue_scripts', 'enable_plugin_mediaelement', '', '');

// enable galleria plugin
if(!function_exists('enable_plugin_galleria')) {
  function enable_plugin_galleria() {
      wp_enqueue_script('plugin-galleria', get_stylesheet_directory_uri() . '/assets/vendor/galleria/galleria-1.2.9.js', array('jquery'), false, true); // TODO: switch to min
      wp_enqueue_script('plugin-galleria-flickr', get_stylesheet_directory_uri() . '/assets/vendor/galleria/plugins/flickr/galleria.flickr.js', array('plugin-galleria'), false, true); // TODO: switch to min
      wp_enqueue_script('plugin-galleria-picasa', get_stylesheet_directory_uri() . '/assets/vendor/galleria/plugins/picasa/galleria.picasa.js', array('plugin-galleria'), false, true); // TODO: switch to min
      // wp_enqueue_script('plugin-galleria-theme-classic', get_stylesheet_directory_uri() . '/assets/vendor/galleria/themes/classic/galleria.classic.js', array('plugin-galleria'), false, true); // TODO: switch to min
      wp_enqueue_style('plugin-galleria', get_stylesheet_directory_uri() . '/assets/vendor/galleria/themes/classic/galleria.classic.css');
  }
}

add_action('wp_enqueue_scripts', 'enable_plugin_galleria', '', '');

// hook in custom logo overlay
add_action('responsive_in_header', 'legambiente_logo_overlay');

if(!function_exists('deprecate_internet_explorer')) {
  function deprecate_internet_explorer() {
    locate_template('templates/deprecate-internet-explorer.php', true, false);
  }
}

// hook in responsive container
add_action('responsive_container', 'deprecate_internet_explorer');

// Pods component: featured video

if(!function_exists('legambiente_insert_video')) {
  function legambiente_insert_video($video_id = null) {      
    $featured_video = pods('video', $video_id, true);
    if($featured_video->exists()) {
      error_log('featured_video title: ' . $featured_video->field('name'));
      set_query_var('featured_video', $featured_video);
      set_query_var('featured_video_uniqid', uniqid('legambiente-featured-video-' . $featured_video->field('id')));
      locate_template('templates/featured-video.php', true, false);
    }
  }
}

if(!function_exists('legambiente_shortcode_video')) {
  function legambiente_shortcode_video($attributes) {
    extract(shortcode_atts(array('id' => null), $attributes));
    ob_start();
    legambiente_insert_video($id);
    return ob_get_clean();
  }
}
if(!function_exists('legambiente_featured_video')) {
  function legambiente_featured_video() {
    $post_type = get_post_type();
    error_log('legambiente_featured_video: post ID: ' . get_the_ID());
    $featured_video_meta = get_post_meta(get_the_ID(), 'featured_video', true);
    error_log('legambiente_featured_video: featured_video_meta: ' . var_export($featured_video_meta, true));
    if(($post_type === 'page' or $post_type === 'post') and $featured_video_meta['id']) {
      legambiente_insert_video($featured_video_meta['id']);
    }
  }
}

// plug into hook in sidebar
add_action('responsive_widgets', 'legambiente_featured_video');
// and add shortcode
add_shortcode('la_video', 'legambiente_shortcode_video');


// Pods component: featured gallery
if(!function_exists('legambiente_insert_gallery')) {
  function legambiente_insert_gallery($gallery_id = null) {
    $featured_gallery = pods('photo_gallery', $gallery_id, true);
    if($featured_gallery->exists()) {
      set_query_var('featured_gallery', $featured_gallery);
      set_query_var('featured_gallery_uniqid', uniqid('legambiente-featured-gallery-' . $featured_gallery->field('id')));
      locate_template('templates/featured-gallery.php', true, false);
    }
  }
}

if(!function_exists('legambiente_shortcode_gallery')) {
  function legambiente_shortcode_gallery($attributes) {
    extract(shortcode_atts(array('id' => null), $attributes));
    ob_start();
    legambiente_insert_gallery($id);
    return ob_get_clean();
  }
}

if(!function_exists('legambiente_featured_gallery')) {
  function legambiente_featured_gallery() {
    $post_type = get_post_type();
    $featured_gallery_meta = get_post_meta(get_the_ID(), 'featured_photo_gallery', true);
    error_log('featured_gallery_meta: ' . var_export($featured_gallery_meta, true));
    if(($post_type === 'page' or $post_type === 'post') and $featured_gallery_meta['id']) {
      legambiente_insert_gallery($featured_gallery_meta['id']);
    }
  }
}

// plug into hook in sidebar
add_action('responsive_widgets', 'legambiente_featured_gallery');
// and add shortcode
add_shortcode('la_album', 'legambiente_shortcode_gallery');



// Pods component: featured items collection

/*
 * select posts or pages for a slider
 * 
 * if no category is provider, use sticky posts
 * otherwise use category
 */
if(!function_exists('legambiente_insert_collection')) {
  function legambiente_insert_collection($collection_data = array()) {
    $default_settings = array(
      'widget_type' => 'slider',
      'item_type' => 'posts',
      'collection_id' => null,
      'use_featured_posts' => false,
      'category_slug' => null,
      'max_items' => 5
    );
    
    $collection_data = array_merge($default_settings, $collection_data);
    error_log('legambiente_insert_collection: collection_data: ' . var_export($collection_data, true));
    
    // if no selection has been set, default to featured posts
    if($collection_data['collection_id'] === null and $collection_data['use_featured_posts'] === false and $collection_data['category_slug'] === null) {
      $collection_data['use_featured_posts'] = true;
    }
    
    $post__in = array();
    
    if($collection_data['use_featured_posts']) {
      $post__in = get_option('sticky_posts');
    } elseif($collection_data['collection_id']) {
      switch($collection_data['item_type']) {
        case 'posts': $item_type = 'post'; break;
        case 'pages': $item_type = 'page'; break;
      }
      $featured_collection = pods($item_type . '_collection', $collection_data['collection_id'], true);
      if($featured_collection->exists()) {
        foreach($featured_collection->field('posts') as $item) {
          $post__in[] = $item['ID'];
        }
      }
    } elseif($collection_data['category_slug']) {
      $category_object = get_category_by_slug($category_slug); 
      $category_id = $category_object->term_id;
    }
    
    error_log('legambiente_insert_collection: category: ' . $collection_data['category_slug']);
    error_log('legambiente_insert_collection: post__in: ' . var_export($post__in, true));
    
    $args = array(
      'numberposts' => $collection_data['max_items'],
      'category' => $collection_data['category_slug'],
      'post_type' => $item_type,
      'post__in' => $post__in
    );
  
    $slider_posts = get_posts($args);
   
    global $post;
    $original_post = $post;
    set_query_var('slider_posts', $slider_posts);
    if($collection_data['widget_type'] === 'sidebar' and count($slider_posts)) {
      locate_template('templates/post-collection-sidebar-widget.php', true, false);
    } elseif($collection_data['widget_type'] === 'slider' and count($slider_posts)) {
      error_log('loading post-collection.php template with collection_data: ' . var_export($collection_data, true));
      locate_template('templates/post-collection.php', true, false);
    }
    $post = $original_post;
  }
}

if(!function_exists('legambiente_shortcode_post_collection')) {
  function legambiente_shortcode_post_collection($attributes) {
    return legambiente_shortcode_collection($attributes, 'posts');
  }
}

if(!function_exists('legambiente_shortcode_page_collection')) {
  function legambiente_shortcode_page_collection($attributes) {
    return legambiente_shortcode_collection($attributes, 'pages');
  }
}

if(!function_exists('legambiente_shortcode_collection')) {
  function legambiente_shortcode_collection($attributes, $item_type) {
    extract(shortcode_atts(array('id' => null), $attributes));
    ob_start();
    legambiente_insert_collection(array('collection_id' => $id, 'item_type' => $item_type));
    return ob_get_clean();
  }
}

function legambiente_featured_post_collection() {
  if($featured_collection_meta = get_post_meta(get_the_ID(), 'featured_post_collection', true)) {
    legambiente_featured_collection($featured_collection_meta, 'posts');
  }
}

function legambiente_featured_page_collection() {
  if($featured_collection_meta = get_post_meta(get_the_ID(), 'featured_page_collection', true)) {
    legambiente_featured_collection($featured_collection_meta, 'pages');
  }
}

if(!function_exists('legambiente_featured_collection')) {
  function legambiente_featured_collection($featured_collection_meta, $item_type) {
    $post_type = get_post_type();
    error_log('featured_collection_meta: ' . var_export($featured_collection_meta, true));
    if(($post_type === 'page' or $post_type === 'post') and $featured_collection_meta['id']) {
      switch($item_type) {
        case 'posts':
          legambiente_insert_collection(array('widget_type' => 'sidebar', 'collection_id' => $featured_collection_meta['id'], 'item_type' => 'posts'));
          break;
        case 'pages':
          legambiente_insert_collection(array('widget_type' => 'sidebar', 'collection_id' => $featured_collection_meta['id'], 'item_type' => 'pages'));
          break;
      }
    }
  }
}

// plug into hook in sidebar
add_action('responsive_widgets', 'legambiente_featured_post_collection');
add_action('responsive_widgets', 'legambiente_featured_page_collection');
// and add shortcodes
add_shortcode('la_raccolta_articoli', 'legambiente_shortcode_post_collection');
add_shortcode('la_raccolta_pagine', 'legambiente_shortcode_page_collection');

/*
 * select posts for front page, one per category
 * 
 * @param array $temi_ids list of ids of categories from which to select latest post, or empty array for all top level categories
 * @return array of posts
 */
function do_temi_news($temi_ids = array()) {
  $categories = get_categories(array('incude' => $temi_ids));
  $posts_array = array();
  foreach($categories as $category) {
    $posts_array[] = array(
      'category_name' => $category->name,
      'category_id' => $category->term_id,
      'post' => get_posts(array(
        'numberposts' => 1,
        'category' => $category->term_id
      ))
    );
  }
  return $posts_array;
}

/*
 * select list of Temi
 * 
 * @param int $parent_page numeric id of parent page of the Temi pages
 * @return array of pages
 */
function do_temi_index($parent_page) {
  if(!$parent_page) {
    error_log('No parent page ID supplied');
  }
  
  $args = array(
    'child_of' => $parent_page,
    'sort_column' => 'menu_order'
  );
  
  $posts_array = get_pages($args);
  
  return $posts_array;
}

/* add 'read more' link at the end of excerpts
 */
function new_excerpt_more($more) {
  global $post;
	return ' <a href="'. get_permalink($post->ID) . '">Read the Rest...</a>';
}

add_filter('excerpt_more', 'new_excerpt_more');
?>
