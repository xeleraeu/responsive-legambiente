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
function admin_menu_access_for_editors() {
    global $menu, $submenu;
    var_trace(var_export($menu, true), 'admin menu data structure');
    var_trace(var_export($submenu, true), 'admin submenu data structure');

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
      $menu[60][1] = 'antani-manage-header';
      /*
      foreach ($submenu['themes.php'] as $dashboard => $key) {
          var_trace($key[0], 'current submenu item');
          if ($key[0] == __('Header')) {
              $submenu['themes.php'][$dashboard][1] = 'antani-manage-header';
          }
      }
      */
      unset($submenu['temes.php']);
      add_submenu_page(
            'themes.php',
            __('Header'),
            __('Header'),
            'legambiente_edit_header',
            'themes.php?page=custom-header');
    }

    var_trace(var_export($menu, true), 'admin menu data structure -- after update');
    var_trace(var_export($submenu, true), 'admin submenu data structure -- after update');
}
   
add_action('admin_menu', 'admin_menu_access_for_editors');

function page_access_for_editors($allcaps, $cap, $args) {
  $admin_area = $_SERVER['PHP_SELF'];
  $admin_area_page = $_GET['page'];
  var_trace(var_export($allcaps, true), 'all user capabilities');
  var_trace(var_export($cap, true), 'required capability');
  var_trace(var_export($args, true), 'requested capability');
  var_trace(var_export($admin_area, true), 'PHP_SELF');
  var_trace(var_export($admin_area_page, true), 'action page');
  
  if($admin_area === '/wp-admin/themes.php' and $admin_area_page === 'custom-header' and $cap[0] === 'edit_theme_options') {
    $allcaps[$cap[0]] = true;
  }
  
  if($args[0] == 'antani-manage-header' and current_user_can('read')) {
    $allcaps[$cap[0]] = true;
  }

  var_trace(var_export($allcaps, true), 'all user capabilities -- after');
  
  return $allcaps;
}

add_filter( 'user_has_cap', 'page_access_for_editors', 10, 3 );

function filter_menu($parent_file = '') {
  global $menu, $submenu;
  global $_wp_menu_nopriv; //Caution: Modifying this array could lead to unexpected consequences.

  //Remove sub-menus which the user shouldn't be able to access,
  //and ensure the rest are visible.
  foreach ($submenu as $parent => $items) {
    foreach ($items as $index => $data) {
      if($parent == 'themes.php') {
        if($data[2] == __('Header')) {
          $submenu[$parent][$index][1] = 'antani-manage-header';
        }
        else {
          unset($submenu[$parent][$index]);
        }
      } elseif ( ! current_user_can($data[1]) ) {
        unset($submenu[$parent][$index]);
        $_wp_submenu_nopriv[$parent][$data[2]] = true;
      } else {
        //The menu might be set to some kind of special capability that is only valid
        //within this plugin and not WP in general. Ensure WP doesn't choke on it.
        //(This is safe - we'll double-check the caps when the user tries to access a page.)
        $submenu[$parent][$index][1] = 'exist'; //All users have the 'exist' cap.
      }
    }

    if ( empty($submenu[$parent]) ) {
      unset($submenu[$parent]);
    }
  }

  //Remove menus that have no accessible sub-menus and require privileges that the user does not have.
  //Ensure the rest are visible. Run re-parent loop again.
  foreach ( $menu as $id => $data ) {
    if ( ! current_user_can($data[1]) ) {
      $_wp_menu_nopriv[$data[2]] = true;
    } else {
      $menu[$id][1] = 'exist';
    }

    //If there is only one submenu and it is has same destination as the parent,
    //remove the submenu.
    if ( ! empty( $submenu[$data[2]] ) && 1 == count ( $submenu[$data[2]] ) ) {
      $subs = $submenu[$data[2]];
      $first_sub = array_shift($subs);
      if ( $data[2] == $first_sub[2] ) {
        unset( $submenu[$data[2]] );
      }
    }

    //If submenu is empty...
    if ( empty($submenu[$data[2]]) ) {
      // And user doesn't have privs, remove menu.
      if ( isset( $_wp_menu_nopriv[$data[2]] ) ) {
        unset($menu[$id]);
      }
    }
  }
  unset($id, $data, $subs, $first_sub);

  //Remove any duplicated separators
  $separator_found = false;
  foreach ( $menu as $id => $data ) {
    if ( 0 == strcmp('wp-menu-separator', $data[4] ) ) {
              if ($separator_found) {
                  unset($menu[$id]);
              }
              $separator_found = true;
          } else {
      $separator_found = false;
    }
  }
  unset($id, $data);

  //Remove the last menu item if it is a separator.
  $last_menu_key = array_keys( $menu );
  $last_menu_key = array_pop( $last_menu_key );
  if (!empty($menu) && 'wp-menu-separator' == $menu[$last_menu_key][4]) {
    unset($menu[$last_menu_key]);
  }
  unset( $last_menu_key );

  //Add display-specific classes like "menu-top-first" and others.
  $menu = add_menu_classes($menu);

  return array($menu, $submenu);
}

// add_filter('parent_file', 'filter_menu');


add_action( 'contextual_help', 'wptuts_screen_help', 10, 3 );
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

?>
