<?php if($featured_gallery->exists()): ?>
<div id="<?php echo $featured_gallery_uniqid; ?>" class="pods-photo-gallery fullbleed">
  <?php
    if($featured_gallery->field('photo')):
      $photos = $featured_gallery->field('photo');
      foreach($photos as $photo):
  ?>
  <img src="<?php echo wp_get_attachment_url($photo['ID']); ?>"<?php if($photo['post_title']) { ?> data-title="<?php echo $photo['post_title']; ?>"<?php }; if($photo['post_content']) { ?> data-description="<?php echo $photo['post_content']; ?>"<?php }; ?> />
  <?php
      endforeach; // ($photos as $photo)
    endif; // ($featured_gallery->field('photo'))
  ?>
</div>
<script>
jQuery(document).ready(function($) {
    Galleria.loadTheme('<?php echo get_stylesheet_directory_uri(); ?>/assets/vendor/galleria/themes/classic/galleria.classic.js');
    <?php if($featured_gallery->field('photo')): ?>
    Galleria.run('#<?php echo $featured_gallery_uniqid; ?>',
      { height: '0.6', lightbox: true, responsive: true }
    );
    <?php elseif($featured_gallery->field('flickr_code')): ?>  
    Galleria.run('#<?php echo $featured_gallery_uniqid; ?>',
      { flickr: 'set:<?php echo $featured_gallery->field('flickr_code'); ?>', height: '0.6', lightbox: true, responsive: true }
    );
    <?php elseif($featured_gallery->field('picasa_code')): ?>
    Galleria.run('#<?php echo $featured_gallery_uniqid; ?>',
      { picasa: 'useralbum:<?php echo $featured_gallery->field('picasa_code'); ?>', height: '0.6', lightbox: true, responsive: true }
    );
    <?php endif; ?>
});
</script>
<?php endif; // ($featured_gallery->exists()) ?>
