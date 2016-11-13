<?php
namespace LegambienteWPTheme;

class EuCookieControlSettings {
  /**
   * @var String Identifier of the settings pod
   */
  const SETTINGS_PODS_NAME = 'eu_cookie_control';

  /**
   * Default cookie policy version
   */
  const DEFAULT_COOKIE_POLICY_VERSION = '0';

  /**
   * Default text for cookie info message if none is set by admins
   */
  const DEFAULT_COOKIE_INFO_TEXT = 'Questo sito utilizza cookies.';

  /**
   * Default 'read more' text
   */
  const DEFAULT_READ_MORE_TEXT = 'Maggiori informazioni...';

  /**
   * Default 'accept'/dismiss text
   */
  const DEFAULT_DISMISS_TEXT = 'Va bene, grazie';

  /**
   * @var Whether to enable the cookie information widget
   */
  public $enable_cookie_control;

  /**
   * @var Text for the widget
   */
  public $cookie_info_text;

  /**
   * @var Page holding full cookie policy
   */
  public $cookie_policy_page_uri;

  /**
   * @var Cookie policy version (used to reset any cookies storing visitor
   * preference regarding acceptance of previous policy versions)
   */
  public $cookie_policy_version;

  function __construct() {
    /**
     * Fetch settings
     */
    $settings_pod = pods(self::SETTINGS_PODS_NAME);
    $settings_pod->find();

    if($settings_pod->total_found()) {
      $this->enable_cookie_control = $settings_pod->field('enable_cookie_control');
      $this->cookie_info_text = $settings_pod->field('cookie_info_text');
      $this->cookie_policy_page_uri = $settings_pod->field('cookie_policy_page') ?
        get_page_uri($settings_pod->field('cookie_policy_page.ID')) :
        '';
      $this->cookie_policy_version = $settings_pod->field('cookie_policy_version') ? $settings_pod->field('cookie_policy_version') : self::DEFAULT_COOKIE_POLICY_VERSION;
    }
  }

  /**
   * Return HTML snippet
   */
  function get_snippet() {
    if($this->enable_cookie_control) {
      $cookie_info_text = !empty($this->cookie_info_text) ? $this->cookie_info_text : self::DEFAULT_COOKIE_INFO_TEXT;
      $widget_content = $cookie_info_text;
      if($this->cookie_policy_page_uri) {
        $widget_content .= '<span class="read-more"><a href="' . $this->cookie_policy_page_uri . '">' . self::DEFAULT_READ_MORE_TEXT . '</a></span>';
      }
      $widget_content .= '<span><button class="dismiss">' . self::DEFAULT_DISMISS_TEXT . '</button></span>';

      return '<div class="eu-cookie-control"><div class="content">' . $widget_content . '</div></div>';
    }
  }
}
