<?php if($featured_video->exists()): ?>
<div id="<?php echo $featured_video_uniqid; ?>" class="pods-video">
  <video id="<?php echo $featured_video_uniqid; ?>-player" preload="none" width="320" height="180" style="width: 100%; height: 100%; max-width: 100%;">
  <?php if($featured_video->field('youtube_id')): ?>
    <source type="video/youtube" src="https://www.youtube.com/watch?v=<?php echo $featured_video->field('youtube_id'); ?>" />
  <?php elseif($featured_video->field('vimeo_id')): ?>
    <source type="video/vimeo" src="https://www.vimeo.com/<?php echo $featured_video->field('vimeo_id'); ?>" />
  <?php elseif($featured_video->field('video_file_uri')): ?>
    <source type="video/webm" src="<?php echo $featured_video->field('video_file_uri'); ?>" />
  <?php endif; ?>
  </video>
</div>
<?php endif; // ($featured_video->exists()) ?>
