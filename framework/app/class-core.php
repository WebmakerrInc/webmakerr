<?php
namespace Framework;

use Framework\Admin\Modules as ModulesPage;

require_once FRAMEWORK_PLUGIN_PATH . 'admin/class-modules.php';

defined('ABSPATH') || exit;

class Core
{
    private const OPTION_NAME = 'framework_active_modules';

    /**
     * @var Core|null
     */
    private static $instance = null;

    /**
     * @var array<string, array<string, mixed>>
     */
    private $modules = [];

    private function __construct()
    {
        $modulePath = dirname(__DIR__, 2) . '/eCommerce/fluent-cart.php';

        $this->modules = [
            'ecommerce' => [
                'title'       => __('eCommerce', 'framework'),
                'description' => __('Sell products and manage orders directly from the Framework plugin.', 'framework'),
                'module_file' => $modulePath,
                'plugin_file' => $modulePath,
            ],
        ];
    }

    /**
     * Get singleton instance
     */
    public static function get_instance(): Core
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Set up hooks
     */
    public function init(): void
    {
        add_action('plugins_loaded', [$this, 'load_active_modules'], 20);
        add_filter('all_plugins', [$this, 'filter_module_plugins']);

        ModulesPage::get_instance()->init($this, $this->modules);
    }

    /**
     * Ensure the option exists with default disabled modules.
     */
    public static function activate(): void
    {
        $value = get_option(self::OPTION_NAME, null);
        if ($value === null || $value === false) {
            add_option(self::OPTION_NAME, []);
        }
    }

    /**
     * Return the list of registered modules.
     *
     * @return array<string, array<string, mixed>>
     */
    public function get_modules(): array
    {
        return $this->modules;
    }

    /**
     * Retrieve active module slugs.
     *
     * @return string[]
     */
    public function get_active_modules(): array
    {
        $active = get_option(self::OPTION_NAME, []);
        if (!is_array($active)) {
            return [];
        }

        $allowed = array_keys($this->modules);

        return array_values(array_intersect($allowed, $active));
    }

    /**
     * Persist active modules list.
     *
     * @param string[] $modules
     */
    public function set_active_modules(array $modules): void
    {
        $allowed = array_keys($this->modules);
        $active = array_values(array_intersect($allowed, array_map('strval', $modules)));
        update_option(self::OPTION_NAME, $active);
    }

    /**
     * Determine if a module is active.
     */
    public function is_module_active(string $slug): bool
    {
        return in_array($slug, $this->get_active_modules(), true);
    }

    /**
     * Load each active module.
     */
    public function load_active_modules(): void
    {
        foreach ($this->get_active_modules() as $slug) {
            if (!isset($this->modules[$slug])) {
                continue;
            }

            $module = $this->modules[$slug];
            $moduleFile = $module['module_file'] ?? '';

            if (!$moduleFile || !file_exists($moduleFile)) {
                continue;
            }

            if (!defined('FRAMEWORK_MODULE_' . strtoupper($slug) . '_LOADED')) {
                define('FRAMEWORK_MODULE_' . strtoupper($slug) . '_LOADED', true);
            }

            require_once $moduleFile;
        }
    }

    /**
     * Remove merged modules from the WordPress plugins list.
     *
     * @param array<string, array<string, mixed>> $plugins
     *
     * @return array<string, array<string, mixed>>
     */
    public function filter_module_plugins(array $plugins): array
    {
        foreach ($this->modules as $module) {
            if (empty($module['plugin_file'])) {
                continue;
            }

            $basename = plugin_basename($module['plugin_file']);
            if (isset($plugins[$basename])) {
                unset($plugins[$basename]);
            }
        }

        return $plugins;
    }
}
