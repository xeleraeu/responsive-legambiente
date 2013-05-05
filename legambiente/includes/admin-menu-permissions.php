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
            'custom-header');
    }
}
   
add_action('admin_menu', 'admin_menu_access_for_editors', 1111);
?>
