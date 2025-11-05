<?php
/**
 * Plugin Name: UiPress Modules
 * Description: Extends UiPress with optional modules such as FluentCart eCommerce.
 * Version: 1.0.0
 * Author: UiPress
 * Text Domain: uipress
 */

defined('ABSPATH') || exit;

define('UIPRESS_MODULES_VERSION', '1.0.0');
define('UIPRESS_MODULES_PLUGIN_FILE', __FILE__);
define('UIPRESS_MODULES_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('UIPRESS_MODULES_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once UIPRESS_MODULES_PLUGIN_PATH . 'includes/class-core.php';

\UiPress\Core::get_instance()->init();

register_activation_hook(__FILE__, ['\\UiPress\\Core', 'activate']);
