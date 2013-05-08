<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Theme's capabilities overrides for admin menus
 *
 *
 * @file           admin-menu-permissions.php
 * @package        Legambiente
 * @author         Andrea Rota
 * @author         Giovanni Biscuolo 
 * @copyright      2013 Xelera
 * @license        license.txt
 * @version        Release: 1.3
 * @filesource     wp-content/themes/legambiente/includes/admin-menu-permissions.php
 * @link           http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          available since Release 1.3
 */
?>
<?php

// toggle to enable/disable just for this file
$TRACE_ENABLED = false;

function admin_menu_access_for_editors() {
    global $menu, $submenu;
    var_trace(var_export($menu, true), 'admin menu data structure', $TRACE_ENABLED);
    var_trace(var_export($submenu, true), 'admin submenu data structure', $TRACE_ENABLED);

    /*
    if(!current_user_can('switch_themes')) {
        add_submenu_page(
            'themes.php',
            __('Header'),
            __('Header'),
            'read',
            'themes.php?page=custom-header');
    }
    */
    
    if(!current_user_can('switch_themes')) {
      $menu[60][1] = 'legambiente_edit_header';
      /*
      foreach ($submenu['themes.php'] as $dashboard => $key) {
          var_trace($key[0], 'current submenu item');
          if ($key[0] == __('Header')) {
              $submenu['themes.php'][$dashboard][1] = 'antani-manage-header';
          }
      }
      */
      unset($submenu['themes.php']);
      add_submenu_page(
            'themes.php',
            __('Header'),
            __('Header'),
            'legambiente_edit_header',
            'themes.php?page=custom-header');
    }

    var_trace(var_export($menu, true), 'admin menu data structure -- after update', $TRACE_ENABLED);
    var_trace(var_export($submenu, true), 'admin submenu data structure -- after update', $TRACE_ENABLED);
}
   
add_action('admin_menu', 'admin_menu_access_for_editors', 1111);

function page_access_for_editors($allcaps, $cap, $args) {
  $admin_area = $_SERVER['PHP_SELF'];
  $admin_area_page = $_GET['page'];
  var_trace(var_export($allcaps, true), 'all user capabilities', $TRACE_ENABLED);
  var_trace(var_export($cap, true), 'required capability', $TRACE_ENABLED);
  var_trace(var_export($args, true), 'requested capability', $TRACE_ENABLED);
  var_trace(var_export($admin_area, true), 'PHP_SELF', $TRACE_ENABLED);
  var_trace(var_export($admin_area_page, true), 'action page', $TRACE_ENABLED);
  
  if($admin_area === '/wp-admin/themes.php' and $admin_area_page === 'custom-header' and $cap[0] === 'edit_theme_options') {
    $allcaps[$cap[0]] = true;
  }
  
  if($args[0] == 'edit_theme_options' and current_user_can('legambiente_edit_header')) {
    $allcaps[$cap[0]] = true;
  }

  var_trace(var_export($allcaps, true), 'all user capabilities -- after', $TRACE_ENABLED);
  
  return $allcaps;
}

add_filter( 'user_has_cap', 'page_access_for_editors', 10, 3 );

function wptuts_screen_help( $contextual_help, $screen_id, $screen ) {
 
    // The add_help_tab function for screen was introduced in WordPress 3.3.
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
 
    global $hook_suffix;
 
    // List screen properties
    $variables = '<ul style="width:50%;float:left;"> <strong>Screen variables </strong>'
        . sprintf( '<li> Screen id : %s</li>', $screen_id )
        . sprintf( '<li> Screen base : %s</li>', $screen->base )
        . sprintf( '<li>Parent base : %s</li>', $screen->parent_base )
        . sprintf( '<li> Parent file : %s</li>', $screen->parent_file )
        . sprintf( '<li> Hook suffix : %s</li>', $hook_suffix )
        . '</ul>';
 
    // Append global $hook_suffix to the hook stems
    $hooks = array(
        "load-$hook_suffix",
        "admin_print_styles-$hook_suffix",
        "admin_print_scripts-$hook_suffix",
        "admin_head-$hook_suffix",
        "admin_footer-$hook_suffix"
    );
 
    // If add_meta_boxes or add_meta_boxes_{screen_id} is used, list these too
    if ( did_action( 'add_meta_boxes_' . $screen_id ) )
        $hooks[] = 'add_meta_boxes_' . $screen_id;
 
    if ( did_action( 'add_meta_boxes' ) )
        $hooks[] = 'add_meta_boxes';
 
    // Get List HTML for the hooks
    $hooks = '<ul style="width:50%;float:left;"> <strong>Hooks </strong> <li>' . implode( '</li><li>', $hooks ) . '</li></ul>';
 
    // Combine $variables list with $hooks list.
    $help_content = $variables . $hooks;
 
    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'wptuts-screen-help',
        'title'   => 'Screen Information',
        'content' => $help_content,
    ));
 
    return $contextual_help;
}

add_action( 'contextual_help', 'wptuts_screen_help', 10, 3 );

?>
