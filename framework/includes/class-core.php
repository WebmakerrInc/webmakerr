<?php
namespace Framework;

use Framework\Admin\Modules as ModulesPage;

defined('ABSPATH') || exit;

require_once FRAMEWORK_PLUGIN_PATH . 'includes/admin/class-modules.php';

class Core
{
    private const OPTION_NAME = 'framework_active_modules';

    /**
     * Singleton instance.
     *
     * @var Core|null
     */
    private static $instance = null;

    /**
     * Registered modules.
     *
     * @var array<string, array<string, mixed>>
     */
    private $modules = [];

    private function __construct()
    {
        $module_file = FRAMEWORK_PLUGIN_PATH . 'modules/ecommerce/fluent-cart.php';

        $this->modules = [
            'ecommerce' => [
                'title'       => 'eCommerce',
                'description' => 'Enable FluentCart-powered commerce features.',
                'module_file' => $module_file,
            ],
        ];
    }

    /**
     * Retrieve the Core singleton instance.
     */
    public static function get_instance(): Core
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Bootstrap the plugin.
     */
    public function init(): void
    {
        add_action('init', [$this, 'load_textdomain']);
        add_action('plugins_loaded', [$this, 'load_active_modules'], 20);

        ModulesPage::get_instance()->init($this);
    }

    /**
     * Register plugin translations after WordPress has initialised.
     */
    public function load_textdomain(): void
    {
        load_plugin_textdomain(
            'framework',
            false,
            dirname(plugin_basename(FRAMEWORK_PLUGIN_FILE)) . '/languages'
        );
    }

    /**
     * Ensure options are created on activation.
     */
    public static function activate(): void
    {
        if (get_option(self::OPTION_NAME, null) === null) {
            add_option(self::OPTION_NAME, [], '', false);
        }
    }

    /**
     * Retrieve the module registry.
     *
     * @return array<string, array<string, mixed>>
     */
    public function get_modules(): array
    {
        return $this->modules;
    }

    /**
     * Fetch the active modules.
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

        return array_values(array_intersect($allowed, array_map('strval', $active)));
    }

    /**
     * Persist the list of active modules.
     *
     * @param string[] $modules
     */
    public function set_active_modules(array $modules): void
    {
        $allowed = array_keys($this->modules);
        $modules = array_map('sanitize_key', $modules);
        $active = array_values(array_intersect($allowed, $modules));

        update_option(self::OPTION_NAME, $active);
    }

    /**
     * Determine if a module is currently active.
     */
    public function is_module_active(string $slug): bool
    {
        return in_array($slug, $this->get_active_modules(), true);
    }

    /**
     * Load active modules.
     */
    public function load_active_modules(): void
    {
        foreach ($this->get_active_modules() as $slug) {
            if (!isset($this->modules[$slug])) {
                continue;
            }

            $module = $this->modules[$slug];
            $module_file = isset($module['module_file']) ? (string) $module['module_file'] : '';

            if (!$module_file || !file_exists($module_file)) {
                continue;
            }

            if (!defined('FRAMEWORK_MODULE_' . strtoupper($slug) . '_LOADED')) {
                define('FRAMEWORK_MODULE_' . strtoupper($slug) . '_LOADED', true);
            }

            require_once $module_file;
        }
    }
}
