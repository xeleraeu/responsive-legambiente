<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Home Page
 *
 * Note: You can overwrite home.php as well as any other Template in Child Theme.
 * Create the same file (name) include in /responsive-child-theme/ and you're all set to go!
 * @see            http://codex.wordpress.org/Child_Themes
 *
 * @file           home.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/home.php
 * @link           http://codex.wordpress.org/Template_Hierarchy
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>

        <div id="features">
        
        <div class="flexslider highlights">

              <?php
  global $post;
  $original_post = $post;
  $slider_posts = do_flex_slider();
  if(count($slider_posts)):
  ?>
  <div class="flexslider highlights">
      <ul class="slides">
        <?php
        foreach($slider_posts as $post): setup_postdata($post);
        ?>
        <li>
          <a href="<?php the_permalink(); ?>">
            <?php echo get_the_post_thumbnail($slide->ID, 'large'); ?>
          </a>
          <div class="content">
            <h2><?php the_title(); ?></h2>
            <div><?php the_time(get_option('date_format')); ?></div>
            <div><?php the_excerpt(); ?></div>
          </div>
        </li>
        <?php
        endforeach;
        ?>
      </ul>
  </div>
  <script>jQuery('.flexslider.highlights').flexslider({slideshowSpeed: 10000, pauseOnHover: true});</script>
  <?php
  endif; // (count($slider_posts))
  $post = $original_post;
  ?>
            
        </div><!-- end of .flexslider.highlights -->
        
        </div><!-- end of #features -->
               
<?php get_sidebar('home'); ?>
<?php get_footer(); ?>
