<?php if($featured_video->exists()): ?>
<div id="<?php echo $featured_video_uniqid; ?>" class="pods-video">
  <?php if($featured_video->field('youtube_id')): ?>
    <iframe type="text/html" width="100%" src="https://www.youtube.com/embed/<?php echo $featured_video->field('youtube_id'); ?>?autoplay=0&origin=http://<?php echo $_SERVER['HTTP_HOST']; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
  <?php elseif($featured_video->field('vimeo_id')): ?>
    <iframe type="text/html" width="100%" src="https://player.vimeo.com/video/<?php echo $featured_video->field('vimeo_id'); ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
  <?php elseif($featured_video->field('video_file_uri')): ?>
    <video id="<?php echo $featured_video_uniqid; ?>-player" preload="none" width="320" height="180" style="width: 100%; height: 100%; max-width: 100%;">
      <source type="video/webm" src="<?php echo $featured_video->field('video_file_uri'); ?>" />
    </video>
  <?php endif; ?>
</div>
<?php endif; // ($featured_video->exists()) ?>
