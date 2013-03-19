<?php if($featured_video->exists()): ?>
<div id="legambiente-featured-video-<?php echo $featured_video->field('id'); ?>">
  <video id="legambiente-featured-video-<?php echo $featured_video->field('id'); ?>-player" preload="none">
  <?php if($featured_video->field('youtube_id')): ?>
    <source type="video/youtube" src="http://www.youtube.com/watch?v=<?php echo $featured_video->field('youtube_id'); ?>" />
  <?php endif; // ($featured_video->field('youtube_id')) ?>
  </video>
</div>
<?php endif; // ($featured_video->exists()) ?>
