<?php
  if(count($slider_posts)):
?>
  <div class="widget-wrapper widget_la_post_collection">
    <div class="widget-title">Articoli in evidenza</div>
    <ul class="items">
      <?php
      foreach($slider_posts as $post): setup_postdata($post);
      ?>
      <li>
        <a href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
        </a>
      </li>
      <?php
      endforeach;
      ?>
    </ul>
  </div>
<?php
  endif; // (count($slider_posts))
?>
