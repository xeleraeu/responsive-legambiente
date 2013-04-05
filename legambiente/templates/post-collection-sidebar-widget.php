<?php
  error_log('post-collection template: slider_posts: ' . var_export($slider_posts, true));
  if(count($slider_posts)):
?>
  <div class="widget-wrapper widget_la_post_collection">
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
