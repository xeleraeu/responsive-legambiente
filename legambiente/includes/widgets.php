<?php

function legambiente_unregister_sidebars() {
  unregister_sidebar( 'home-widget-1' );
	unregister_sidebar( 'home-widget-2' );
	unregister_sidebar( 'home-widget-3' );
  unregister_sidebar( 'right-sidebar' );
  unregister_sidebar( 'left-sidebar' );
  unregister_sidebar( 'left-sidebar-half' );
  unregister_sidebar( 'right-sidebar-half' );
  unregister_sidebar( 'gallery-widget' );
  unregister_sidebar( 'top-widget' );
}

add_action( 'widgets_init', 'legambiente_unregister_sidebars', 20 );

?>
