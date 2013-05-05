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
    global $menu, $submenu, $wp_admin_bar;
    var_trace(var_export($menu, true), 'admin menu data structure');
    var_trace(var_export($submenu, true), 'admin submenu data structure');

    // $menu[60][1] = 'read';
    if(!current_user_can('switch_themes')) {
        remove_menu_page('themes.php');
        add_menu_page(
            __('Appearance'),
            __('Appearance'),
            'read',
            'themes.php',
            '',
            '',
            60);
        add_submenu_page(
            'themes.php',
            __('Header'),
            __('Header'),
            'read',
            'themes.php?page=custom-header');
    }
    
    var_trace(var_export($menu, true), 'admin menu data structure -- after update');
    var_trace(var_export($submenu, true), 'admin submenu data structure -- after update');
}
   
add_action('admin_menu', 'admin_menu_access_for_editors', 1111);

function page_access_for_editors($allcaps, $cap, $args) {
  global $current_screen;
  $admin_area = $_SERVER['PHP_SELF'];
  $admin_area_page = $_GET['page'];
  var_trace(var_export($allcaps, true), 'all user capabilities');
  var_trace(var_export($cap, true), 'required capability');
  var_trace(var_export($args, true), 'requested capability');
  var_trace(var_export($admin_area, true), 'PHP_SELF');
  var_trace(var_export($admin_area_page, true), 'action page');
  
  if($admin_area === 'themes.php' and $admin_area_page === 'custom-header') {
    $allcaps[$cap[0]] = true;
  }

  var_trace(var_export($allcaps, true), 'all user capabilities -- after');
  
  return $allcaps;
}

add_filter( 'user_has_cap', 'page_access_for_editors', 10, 3 );
?>
