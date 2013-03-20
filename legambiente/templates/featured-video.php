<?php if($featured_video->exists()): ?>
<div id="legambiente-featured-video-<?php echo $featured_video->field('id'); ?>" class="pods-video">
  <video id="legambiente-featured-video-<?php echo $featured_video->field('id'); ?>-player" preload="none" width="320" height="180" style="width: 100%; height: 100%; max-width: 100%;">
  <?php if($featured_video->field('youtube_id')): ?>
    <source type="video/x-youtube" src="https://www.youtube.com/watch?v=<?php echo $featured_video->field('youtube_id'); ?>" />
  <?php elseif($featured_video->field('vimeo_id')): ?>
    <source type="video/x-vimeo" src="https://www.vimeo.com/<?php echo $featured_video->field('vimeo_id'); ?>" />
  <?php elseif($featured_video->field('video_file_uri')): ?>
    <source type="video/webm" src="<?php echo $featured_video->field('video_file_uri'); ?>" />
  <?php endif; // ($featured_video->field('youtube_id')) ?>
  </video>
</div>
<script>
jQuery(document).ready(function($) {
    $('#legambiente-featured-video-<?php echo $featured_video->field('id'); ?>-player').mediaelementplayer({ videoWidth: '100%' });
});
</script>
<?php endif; // ($featured_video->exists()) ?>
