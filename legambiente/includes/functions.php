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

// hook in custom logo overlay
add_action('responsive_in_header', 'legambiente_logo_overlay');

if(!function_exists('deprecate_internet_explorer')) {
  function deprecate_internet_explorer() {
    locate_template('templates/deprecate-internet-explorer.php', true, false);
  }
}

// hook in responsive container
add_action('responsive_container', 'deprecate_internet_explorer');

if(!function_exists('legambiente_featured_video')) {
  function legambiente_featured_video() {
    $post_type = get_post_type();
    $featured_video_id = get_post_meta(get_the_ID(), 'featured_video', true);
    if(($post_type === 'page' or $post_type === 'post') and $featured_video_id) {
      
      $featured_video = pods('video', $featured_video_id, true);
      
      locate_template('templates/featured-video.php', true, true);
    }
  }
}

// plug into hook in sidebar
add_action('responsive_widgets', 'legambiente_featured_video');

/*
 * select posts for a slider
 * 
 * if no category is provider, use sticky posts
 * otherwise use category
 */
function do_flex_slider($category_slug = '', $max = 5) {
  if($category_slug) {
    $category_object = get_category_by_slug($category_slug); 
    $category_id = $category_object->term_id;
  } else {
    $post__in = get_option('sticky_posts');
  }
  
  $args = array(
    'numberposts' => $max,
    'category' => $category_id,
    'post__in' => $post__in
  );
  
  $posts_array = get_posts($args);
  
  return $posts_array;
}

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
