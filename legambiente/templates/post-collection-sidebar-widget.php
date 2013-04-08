<?php
  if(count($la_slider_posts)):
?>
  <div class="widget-wrapper widget_la_post_collection">
    <div class="widget-title"><?php echo $la_section_title; ?></div>
    <ul class="items">
      <?php
      foreach($la_slider_posts as $post): setup_postdata($post);
      ?>
      <li>
        <a href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
        </a>
      </li>
      <?php
      endforeach; // ($la_slider_posts as $post)
      ?>
    </ul>
  </div>
<?php
  endif; // (count($la_slider_posts))
?>
