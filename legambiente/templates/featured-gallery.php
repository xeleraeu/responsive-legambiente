<?php if($featured_gallery->exists()): ?>
<div id="legambiente-featured-gallery-<?php echo $featured_gallery->field('id'); ?>" class="pods-gallery">
  <?php if($featured_gallery->field('photo')): ?>
  <?php endif; // ($featured_gallery->field('photo')) ?>
</div>
<script>
jQuery(document).ready(function($) {
    Galleria.loadTheme(get_stylesheet_directory_uri() . '/assets/vendor/galleria/themes/classic/galleria.classic.js'');
    <?php if($featured_gallery->field('photo')): ?>
    Galleria.run('#legambiente-featured-gallery-<?php echo $featured_gallery->field('id'); ?>');
    <?php elseif($featured_gallery->field('flickr_code')): ?>  
    Galleria.run('#legambiente-featured-gallery-<?php echo $featured_gallery->field('id'); ?>',
      { flickr: 'set:<?php echo $featured_gallery->field('flickr_code'); ?>' }
    );
    <?php elseif($featured_gallery->field('picasa_code')): ?>
    Galleria.run('#legambiente-featured-gallery-<?php echo $featured_gallery->field('id'); ?>',
      { picasa: 'useralbum:<?php echo $featured_gallery->field('picasa_code'); ?>' }
    );
    <?php endif; ?>
});
</script>
<?php endif; // ($featured_gallery->exists()) ?>
