Responsive Legambiente child theme - development notes
======================================================

This WordPress theme is a child theme of Responsive
(http://themeid.com/responsive-theme/) and uses their example child theme as
skeleton (http://themeid.com/public/responsive-child-theme.zip).

The actual theme to be installed in WordPress is in the
``legambiente`` folder.

The theme's CSS styles are generated via Compass, using Susy as semantic grid
system. Compass is used to compile the SCSS sources (located in the
/compass folder) a single style.css file, which is then
copied over to legambiente/assets/stylesheets/style.css and
included from the theme's base style.css.

The development environment depends on the Debian package
``compass-susy-plugin``, which brings in all the dependencies needed to run
Compass with Susy.
