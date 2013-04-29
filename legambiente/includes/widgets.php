<?php

function legambiente_unregister_sidebars() {
  unregister_sidebar( 'home-widget-1' );
	unregister_sidebar( 'home-widget-2' );
	unregister_sidebar( 'home-widget-3' );
}

add_action( 'widgets_init', 'legambiente_unregister_sidebars', 20 );

?>
