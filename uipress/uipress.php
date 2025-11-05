<?php
/*
Plugin Name: UiPress
Plugin URI: https://uipress.co
Description: UiPress combines the power of the original UiPress Lite and UiPress Pro plugins into a single experience for tailoring your WordPress admin. Build custom dashboards, profile pages, and entire admin frameworks with a unified set of features and templates.
Version: 3.6.0
Author: Admin 2020
Text Domain: uipress
Domain Path: /languages/
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

// If this file is called directly, abort.
!defined('ABSPATH') ? exit() : '';

define('UIP_PLUGIN_MAIN_FILE', __FILE__);
define('uip_plugin_version', '3.6.0');
define('uip_plugin_name', 'UiPress');
define('uip_plugin_path', plugin_dir_path(__FILE__));
define('uip_plugin_url', plugin_dir_url(__FILE__));
define('uip_plugin_shortname', 'uip');
define('UIP_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('uip_plugin_path_name', dirname(UIP_PLUGIN_BASENAME));

define('uip_pro_plugin_version', uip_plugin_version);
define('uip_pro_plugin_path', uip_plugin_path . 'pro/');
$uip_pro_url = function_exists('trailingslashit') ? trailingslashit(uip_plugin_url . 'pro') : rtrim(uip_plugin_url . 'pro', '/') . '/';
define('uip_pro_plugin_url', $uip_pro_url);

define('UIP_PLUGIN_LANG_DOMAIN_LITE', 'uipress-lite');
define('UIP_PLUGIN_LANG_DOMAIN_PRO', 'uipress-pro');
if (!function_exists('uipress_seed_pro_license')) {
  function uipress_seed_pro_license() {
    $license_key = 'DUMMY-KEY-1234-5678-DUMMY-KEY-1234';
    $instance_id = 'DUMMY-INSTANCE-ID-12345678';

    $options = get_option('uip-global-settings');

    if (!isset($options['uip_pro']) || !is_array($options['uip_pro'])) {
      $options['uip_pro'] = [];
    }

    $options['uip_pro']['key'] = $license_key;
    $options['uip_pro']['instance'] = $instance_id;

    update_option('uip-global-settings', $options);
  }
}

uipress_seed_pro_license();

require uip_plugin_path . 'admin/vendor/autoload.php';
require uip_plugin_path . 'admin/uipress-compiler.php';

require uip_pro_plugin_path . 'admin/vendor/autoload.php';
require uip_pro_plugin_path . 'admin/compiler.php';

$uipress = new uipress_compiler();
$uipress->run();

$uipress_pro = new uipress_pro_compiler();
$uipress_pro->run();
