<?php
  error_log('post-collection template: count la_slider_posts: ' . count($la_slider_posts));
  if(count($la_slider_posts)):
?>
  <div class="flexslider highlights">
      <ul class="slides">
        <?php
        foreach($la_slider_posts as $post): setup_postdata($post);
        ?>
        <li>
          <a href="<?php the_permalink(); ?>">
            <?php
            if(has_post_thumbnail($post->ID)) {
              echo get_the_post_thumbnail($post->ID, 'large');
            } // if(has_post_thumbnail($post->ID) ?>
          </a>
          <div class="content">
            <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'responsive'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
            <div><?php the_excerpt(); ?></div>
          </div>
        </li>
        <?php
        endforeach;
        ?>
      </ul>
  </div>
  <script>jQuery(document).ready(function($) { $('.flexslider.highlights').flexslider({slideshowSpeed: 10000, pauseOnHover: true,  animation: 'slide'}); });</script>
<?php
  endif; // (count($la_slider_posts))
?>
