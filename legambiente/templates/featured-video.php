<?php if($featured_video->exists()): ?>
<div id="legambiente-featured-video-<?php echo $featured_video->field('id'); ?>">
  <video id="legambiente-featured-video-<?php echo $featured_video->field('id'); ?>-player" preload="none">
  <?php if($featured_video->field('youtube_id')): ?>
    <source type="video/youtube" src="http://www.youtube.com/watch?v=<?php echo $featured_video->field('youtube_id'); ?>" />
  <?php elseif($featured_video->field('video_file_uri')): ?>
    <source type="video/webm" src="<?php echo $featured_video->field('video_file_uri'); ?>" />
  <?php endif; // ($featured_video->field('youtube_id')) ?>
  </video>
</div>
<script>
jQuery(document).ready(function($) {
    $('#legambiente-featured-video-<?php echo $featured_video->field('id'); ?>-player').mediaelementplayer();
});
</script>
<?php endif; // ($featured_video->exists()) ?>
