<div class="flexslider highlights">
    <ul class="slides">
      <?php
      foreach($slider_posts as $post): setup_postdata($post);
      ?>
      <li>
        <a href="<?php the_permalink(); ?>">
          <?php echo get_the_post_thumbnail($post->ID, 'large'); ?>
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
<script>jQuery(document).ready(function($) { $('.flexslider.highlights').flexslider({slideshowSpeed: 10000, pauseOnHover: true}); });</script>
