<?php
!defined("ABSPATH") ? exit() : "";

class uipress_compiler
{
  /**
   * Loads UiPress Classes and plugins
   *
   * @since 3.0.0
   */
  public function run()
  {
    require_once uip_plugin_path . "admin/core/app.php";
    require_once uip_plugin_path . "admin/core/ajax-functions.php";
    require_once uip_plugin_path . "admin/core/uiBuilder.php";
    require_once uip_plugin_path . "admin/core/site-settings.php";
    require_once uip_plugin_path . "admin/core/dashboard-override.php";

    $this->check_for_uipress_pro_version();

    // Load main app
    $uip_app = new uip_app();
    $uip_app->run();

    // Load ajax functions
    $uip_ajax = new uip_ajax();
    $uip_ajax->load_ajax();

    // Load uiBuilder
    $uip_ui_builder = new uip_ui_builder();
    $uip_ui_builder->run();

    // Load global settings
    $uip_global_site = new uip_site_settings();
    $uip_global_site->run();

    $uip_dashboard_override = new uip_dashboard_override();
    $uip_dashboard_override->run();

    $this->load_plugin_textdomain();
    $this->activations_hooks();
  }

  /**
   * Adds hooks for activation and deativation of uipress
   *
   * @since 3.0.0
   */
  public function activations_hooks()
  {
    if (defined('UIP_PLUGIN_MAIN_FILE')) {
      register_activation_hook(UIP_PLUGIN_MAIN_FILE, [$this, 'add_required_caps']);
      register_deactivation_hook(UIP_PLUGIN_MAIN_FILE, [$this, 'remove_required_caps']);
    }
  }

  /**
   * Adds required caps for uipress
   *
   * @since 3.0.0
   */
  public function add_required_caps()
  {
    $role = get_role("administrator");

    //If current role doesn't have the administrator role
    if (!$role || is_null($role)) {
      global $current_user;
      $user_roles = $current_user->roles;
      $user_role = array_shift($user_roles);
      $role = get_role($user_role);
    }

    if (!$role || is_null($role)) {
      return;
    }

    $role->add_cap("uip_manage_ui", true);
    $role->add_cap("uip_delete_ui", true);
  }

  /**
   * Removes caps when plugin gets deactivated
   *
   * @since 3.0.0
   */
  public function remove_required_caps()
  {
    $role = get_role("administrator");
    //If current role doesn't have the administrator role
    if (!$role) {
      global $current_user;
      $user_roles = $current_user->roles;
      $user_role = array_shift($user_roles);
      $role = get_role($user_role);
    }
    $role->remove_cap("uip_manage_ui", true);
    $role->remove_cap("uip_delete_ui", true);
  }

  /**
   * translation files action
   *
   * @since 1.4
   */
  public function load_plugin_textdomain()
  {
    add_action('init', [$this, 'uipress_languages_loader']);
  }

  /**
   * Loads translation files
   *
   * @since 1.4
   */
  public function uipress_languages_loader()
  {
    $base = dirname(plugin_basename(UIP_PLUGIN_MAIN_FILE));
    load_plugin_textdomain('uipress', false, $base . '/languages');
    load_plugin_textdomain(UIP_PLUGIN_LANG_DOMAIN_LITE, false, $base . '/languages');
    load_plugin_textdomain(UIP_PLUGIN_LANG_DOMAIN_PRO, false, $base . '/pro/languages');
  }

  /**
   * Checks for legacy pro plugin installations and gracefully disables them
   *
   * @since 3.3.0
   */
  public function check_for_uipress_pro_version()
  {
    if (!function_exists("get_plugins")) {
      require_once ABSPATH . "wp-admin/includes/plugin.php";
    }
    $all_plugins = get_plugins();

    $plugin_slug = "uipress-pro/uipress-pro.php";

    if (!isset($all_plugins[$plugin_slug])) {
      return;
    }

    if (function_exists('is_plugin_active') && is_plugin_active($plugin_slug)) {
      deactivate_plugins($plugin_slug);
    }

    add_action('admin_notices', [$this, 'flag_uipress_pro_version_error']);
  }

  /**
   * Flags deactivation of uipress pro
   *
   * @since 3.3.0
   */
  public function flag_uipress_pro_version_error()
  {
    $class = 'notice notice-warning';
    $message = __('The legacy UiPress Pro plugin has been detected and deactivated because all Pro features are now included in UiPress. You can safely remove the old plugin.', UIP_PLUGIN_LANG_DOMAIN_PRO);

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
  }
}
