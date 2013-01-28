<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Theme's Action Hooks
 *
 *
 * @file           hooks.php
 * @package        Legambiente
 * @author         andrea rota
 * @copyright      2013 Xelera
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/includes/hooks.php
 * @link           http://codex.wordpress.org/Plugin_API/Hooks
 * @since          available since Release 1.1
 */
?>
<?php

/**
 * Just after opening <div id="logo">
 *
 * @see header.php
 */
function responsive_in_logo() {
    do_action('responsive_in_logo');
}

?>
