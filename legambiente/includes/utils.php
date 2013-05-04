<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Utility/helper functions used across the theme
 *
 *
 * @file           utils.php
 * @package        Legambiente
 * @author         Andrea Rota
 * @author         Giovanni Biscuolo 
 * @copyright      2013 Xelera
 * @license        license.txt
 * @version        Release: 1.3
 * @filesource     wp-content/themes/legambiente/includes/utils.php
 * @since          available since Release 1.3
 */
?>
<?php

define('TRACE_ENABLED', is_user_logged_in());
define('TRACE_PREFIX', __FILE__);

/**
 * tracing/debugging output
 * 
 * This function can either return a formatted dump of the variable to
 * debug, or send the dump to the defined error_log. Ideally this
 * should be coupled with PHP INI settings to enable error log, to
 * disable error output on pages and to send logs to a specific
 * file instead
 * 
 * @param mixed $var The variable to dump
 * @param string $prefix Text to prepend to the variable to be dumped
 * @param bool $enabled Only if true will the function do anything
 * @param string $destination Whether to return a string ('page') or to
 *        send output to error_log ('error_log')
 * @return bool the tracing output if $destination == 'page' or the
 *         return value of error_log() if $destination == 'error_log'
 */
function var_trace($var, $prefix = 'responsive-legambiente', $enabled = TRACE_ENABLED, $destination = 'error_log') {
  if($enabled) {
    $output_string = "tracing $prefix : " . var_export($var, true) . "\n\n";
    
    if($destination == 'page') {
      return "<!-- $output_string -->";
    } elseif($destination == 'error_log') {
      return error_log($output_string);
    }
  }
}
