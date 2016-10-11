<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Theme's capabilities overrides for admin menus
 *
 * This is just a bunch of monkeypatch stuff to get around WP's lack
 * of granularity in capability management - see support.xelera.eu#19950
 * for full details of mind-twisting antani required to make this work.
 * Do not even think to just look at the code below and update it
 * hoping that it will work if you haven't read the whole #19950
 * turnip and broad bean (la rava e la fava).
 *
 * SHADOW PERMISSIONS
 * Document here our own permissions and what is needed to access what
 *
 * Appearance: visible to users with legambiente_manage_appearance cap
 * Appearance->Header: visible to users with legambiente_edit_header cap
 * Appearance->Widget: visible to users with legambiente_edit_widgets cap
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

/**
 * This function hacks the admin menu so that Editors can be given
 * access to a small subset of settings.
 * The hacks are required because by default WordPress does not use
 * capabilities in a sufficient granular way, so it's not possible
 * e.g. to just give users access to the theme header management page
 * *but not to any other page under the Appearance menu*.
 * For the general monkey steps see inline comments; for full turnip
 * and broad bean see ticket referenced in comments above.
 */
function admin_menu_access_for_editors() {
    /**
     * We need access to some global vars to butcher them mercilessly.
     */
    global $menu, $submenu;

    var_trace(var_export($menu, true), 'admin menu data structure', $TRACE_ENABLED);
    var_trace(var_export($submenu, true), 'admin submenu data structure', $TRACE_ENABLED);

    /**
     *  Only butcher a menu section if needed.
     */

    /**
     * Specifically, if users already have switch_themes capabilities.
     * hacking this part of the menu only smones it for them.
     */
    if(!current_user_can('switch_themes')) {
      /**
       * Change capability required for the menu with hardcoded '60'
       * index (Appearance).
       */
      $menu[60][1] = 'legambiente_manage_appearance';
      /**
       * Then remove the whole set of submenu items under this.
       * This only works if we set this action hook so that it is
       * executed last - other earlier hooks will build the menu
       * but we smon it all here for our own good.
       */
      unset($submenu['themes.php']);

      /**
       * Now add in only the submenu pages we need, setting our own
       * shadow capability (see documentation at the top of this file)
       * as required capability for these submenu items to be shown.
       */
      add_submenu_page(
            'themes.php',
            __('Header'),
            __('Header'),
            'legambiente_edit_header',
            'themes.php?page=custom-header');
      add_submenu_page(
            'themes.php',
            __('Menu'),
            __('Menu'),
            'legambiente_edit_widgets',
            'nav-menus.php');
      add_submenu_page(
            'themes.php',
            __('Widgets'),
            __('Widgets'),
            'legambiente_edit_widgets',
            'widgets.php');
    }

    /**
     * Again, if users already have switch_themes capabilities,
     * hacking this part of the menu only smones it for them.
     * Technically the switch_themes cap doesn't have anything to
     * do with the Settings menu, but any capability that
     * lcircoloeditor members shouldn't have would do here.
     */
    if(!current_user_can('switch_themes')) {
      /**
       * Here we don't need to change capability as we already
       * grant manage_options to users - we only need to smon
       * the submenu items and re-add only those we need.
       */
      // $menu[80][1] = 'manage_options';
      /**
       * Then remove the whole set of submenu items under this.
       * This only works if we set this action hook so that it is
       * executed last - other earlier hooks will build the menu
       * but we smon it all here for our own good.
       */
      unset($submenu['options-general.php']);

      /**
       * Now add in only the submenu pages we need, setting our own
       * shadow capability (see documentation at the top of this file)
       * as required capability for these submenu items to be shown.
       */
      add_submenu_page(
            'options-general.php',
            __('General'),
            __('General'),
            'manage_options',
            'options-general.php');
      add_submenu_page(
            'options-general.php',
            __('Writing'),
            __('Writing'),
            'manage_options',
            'options-writing.php');
      add_submenu_page(
            'options-general.php',
            __('Reading'),
            __('Reading'),
            'manage_options',
            'options-reading.php');
      add_submenu_page(
            'options-general.php',
            __('Discussion'),
            __('Discussion'),
            'manage_options',
            'options-discussion.php');
    }

    /**
     * Capability required to do dangerous stuff in the Tools menu
     * is mental (manage_options): let's revoke access to this area.
     * We do this by setting a very high capability as required,
     * and only setting it for users who don't have it (koan style).
     */
    if(!current_user_can('update_core')) {
      /**
       * Change capability required for the menu with hardcoded '75'
       * index (Tools).
       */
      unset($menu[75]);
    }

    /**
     * And that's it. If you need to butcher a menu other than Appearance,
     * you are on your own. Be patient and remember what happened to
     * Molly la foca.
     */
    var_trace(var_export($menu, true), 'admin menu data structure -- after update', $TRACE_ENABLED);
    var_trace(var_export($submenu, true), 'admin submenu data structure -- after update', $TRACE_ENABLED);
}

/**
 * Now that we build all this wonderful menu-butchering function,
 * hook it up to the admin_menu action, using a suitably high priority
 * to ensure that we have some chance to run after any other
 * non-butchering, honest and innocent action function.
 */
add_action('admin_menu', 'admin_menu_access_for_editors', 1111);

/**
 * And just when you thought you were all set to go: no way, man.
 * Crazy upstream needs crazy workarounds.
 * Now that we have a suitably butchered menu showing the items we need,
 * we need to make sure that when users try to access these pages
 * or specific actions within these pages, they don't get blocked
 * by the hardcoded default capability checks.
 * For this, we need to cheat.
 * Basically we hook up to the user_has_cap filter, where we have
 * a chance to pretend that the user has a certain capability even if
 * they don't really have it.
 * Follow inline comments below, and always refer to the Ticket of
 * Wisdom referenced above for the full turnip and broad bean.
 */
function page_access_for_editors($allcaps, $cap, $args) {
  /**
   * Check which URI path we're on while being called.
   * This is our naive way to check if we are on a page (and action
   * within, if applicable) that users should have access to.
   * We could probably dig into the function stack, but let's leave
   * that alone for the moment to preserve some sanity.
   */
  $admin_area = $_SERVER['PHP_SELF'];

  /**
   * As some .php files within wp-admin might contain code for different
   * actions, check the 'page' HTTP GET parameter to build the
   * complete context from the URI.
   */
  $admin_area_page = $_GET['page'];

  var_trace(var_export($allcaps, true), 'all user capabilities', $TRACE_ENABLED);
  var_trace(var_export($cap, true), 'required capability', $TRACE_ENABLED);
  var_trace(var_export($args, true), 'requested capability', $TRACE_ENABLED);
  var_trace(var_export($admin_area, true), 'PHP_SELF', $TRACE_ENABLED);
  var_trace(var_export($admin_area_page, true), 'action page', $TRACE_ENABLED);

  /**
   * Now, the cheating action.
   * The general pattern is: to give access to specific pages/actions,
   * check that we are on a specific page/action and that the current
   * user has the capability that we want to regulate access to this
   * page/action. If so, let's pretend that the user has the capability
   * that WordPress wants them to have in order to access this
   * page/action.
   * We also need to make sure that if this function is called while
   * a menu is being built, we pretend that the user has the
   * capabilities that we set in the other monkey function as
   * capabilities required to *show* that menu item (n.b. *not* to
   * access the admin page linked from the menu item, as we deal
   * with access to that through the turn of the smoke (giro del fumo)
   * described just above in the previous sentence).
   * In this second case, we just check what the capability that the
   * user would normally be required to have is, and if they have
   * instead the capability we associate with that menu item, we're
   * golden and we pretend that they have the capability that WordPress
   * wants them to have.
   * Hello? Still there? Wakey-wakey! Yes, it's convoluted per se
   * and the fact that after two days of reverse engineering my brain
   * went hula-hoop does not contribute to a clear picture.
   * But if it works, it's correct until proven incorrect.
   * Just pay attention to the examples of the user_has_cap filter
   * in WordPress' documentation for the meaning of the parameters
   * passed to this filter function, and the sun will shine.
   * Only, on the other hemisphere.
   */

  /**
   * DENY ACTIONS
   * Actually, let's make sure we block what we don't want users to see
   * first.
   * This can happen. For example, i think that if you want to give
   * users access to the header editing page *but not* to the
   * Appearance main page, since the Appearance top level menu is an
   * active link and leads to /wp-admin/themes.php, you need to
   * explicitly deny access to this page as you can't remove the menu
   * item (which would remove the whole menu and its submenu items).
   * So let's block stuff we can't hide first.
   */

  /**
   * Themes menu
   */
  if($admin_area === '/wp-admin/themes.php' and $admin_area_page !== 'custom-header') {
    $allcaps[$cap[0]] = false;
    return $allcaps;
  }

  /**
   * Settings menu
   */
  if($admin_area === '/wp-admin/options-media.php') {
    $allcaps[$cap[0]] = false;
    return $allcaps;
  }

  if($admin_area === '/wp-admin/options-permalink.php') {
    $allcaps[$cap[0]] = false;
    return $allcaps;
  }

  /**
   * Tools menu
   */
  if($admin_area === '/wp-admin/tools.php') {
    $allcaps[$cap[0]] = false;
    return $allcaps;
  }

  if($admin_area === '/wp-admin/ms-delete-site.php') {
    $allcaps[$cap[0]] = false;
    return $allcaps;
  }

  if($admin_area === '/wp-admin/import.php') {
    $allcaps[$cap[0]] = false;
    return $allcaps;
  }

  if($admin_area === '/wp-admin/export.php') {
    $allcaps[$cap[0]] = false;
    return $allcaps;
  }

  /**
   * GRANT ACTIONS
   * With the bad boys out of the way, let's be nice and give access
   * to what users need, one thing at a time.
   * In theory we could return as soon as we have a match and we have
   * set the pretend-capability, but since we want to give access in any
   * of these cases, there should be no harm in letting the code run
   * until the end and just return at the end of the function.
   */
  if($args[0] == 'edit_theme_options' and current_user_can('legambiente_edit_header')) {
    $allcaps[$cap[0]] = true;
  }

  if($admin_area === '/wp-admin/themes.php' and $admin_area_page === 'custom-header' and $cap[0] === 'legambiente_edit_header') {
    $allcaps[$cap[0]] = true;
  }


  if($args[0] == 'edit_theme_options' and current_user_can('legambiente_edit_widgets')) {
    $allcaps[$cap[0]] = true;
  }

  if($admin_area === '/wp-admin/nav-menus.php' and $admin_area_page === '' and $cap[0] === 'legambiente_edit_widgets') {
    $allcaps[$cap[0]] = true;
  }

  if($admin_area === '/wp-admin/widgets.php' and $admin_area_page === '' and $cap[0] === 'legambiente_edit_widgets') {
    $allcaps[$cap[0]] = true;
  }

  var_trace(var_export($allcaps, true), 'all user capabilities -- after', $TRACE_ENABLED);

  /**
   * That's good. If we had a reason to cheat, we have done so: let's
   * return the array of this user's capabilities, which by now includes
   * the capability WordPress wants them to have to access X as set
   * above.
   */
  return $allcaps;
}

/**
 * And finally, hook this function to the user_has_cap filter.
 * This should really be user_has_crap or better yet user_is_full_of_crap
 * since we're cheating big time, but developers have a limited
 * sense of humour.
 */
add_filter( 'user_has_cap', 'page_access_for_editors', 10, 3 );

?>
