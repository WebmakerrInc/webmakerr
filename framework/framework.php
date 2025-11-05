<?php
/**
 * Plugin Name: Framework
 * Description: Core framework plugin that can load optional modules such as eCommerce.
 * Version: 1.0.0
 * Author: Framework Team
 * Text Domain: framework
 */

defined('ABSPATH') || exit;

define('FRAMEWORK_VERSION', '1.0.0');
define('FRAMEWORK_PLUGIN_FILE', __FILE__);
define('FRAMEWORK_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('FRAMEWORK_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once FRAMEWORK_PLUGIN_PATH . 'app/class-core.php';

\Framework\Core::get_instance()->init();

register_activation_hook(__FILE__, ['\\Framework\\Core', 'activate']);
