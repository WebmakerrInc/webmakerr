<?php
namespace UiPress;

use UiPress\Admin\Modules as ModulesPage;

defined('ABSPATH') || exit;

require_once UIPRESS_MODULES_PLUGIN_PATH . 'includes/admin/class-modules.php';

class Core
{
    private const OPTION_ACTIVE_MODULES = 'uipress_active_modules';
    private const OPTION_ECOMMERCE_INITIALISED = 'uipress_module_ecommerce_initialized';

    /**
     * Singleton instance.
     */
    private static ?Core $instance = null;

    /**
     * Registered modules.
     *
     * @var array<string, array<string, mixed>>
     */
    private array $modules = [];

    private function __construct()
    {
        $module_file = UIPRESS_MODULES_PLUGIN_PATH . 'modules/ecommerce/fluent-cart.php';

        $this->modules = [
            'ecommerce' => [
                'title'       => __('eCommerce', 'uipress'),
                'description' => __('Sell products and manage orders with FluentCart directly inside UiPress.', 'uipress'),
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
            'uipress',
            false,
            dirname(plugin_basename(UIPRESS_MODULES_PLUGIN_FILE)) . '/languages'
        );
    }

    /**
     * Ensure options are created on activation.
     */
    public static function activate(): void
    {
        if (get_option(self::OPTION_ACTIVE_MODULES, null) === null) {
            add_option(self::OPTION_ACTIVE_MODULES, [], '', false);
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
        $active = get_option(self::OPTION_ACTIVE_MODULES, []);
        if (!is_array($active)) {
            return [];
        }

        $allowed = array_keys($this->modules);
        $sanitised = array_map('sanitize_key', $active);

        return array_values(array_intersect($allowed, $sanitised));
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

        update_option(self::OPTION_ACTIVE_MODULES, $active, false);
    }

    /**
     * Determine if a module is currently active.
     */
    public function is_module_active(string $slug): bool
    {
        return in_array(sanitize_key($slug), $this->get_active_modules(), true);
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

            if ($module_file === '' || !file_exists($module_file)) {
                continue;
            }

            require_once $module_file;

            if ($slug === 'ecommerce') {
                $this->maybe_initialize_ecommerce();
            }
        }
    }

    /**
     * Run the FluentCart installer when required tables are missing.
     */
    private function maybe_initialize_ecommerce(): void
    {
        $status = get_option(self::OPTION_ECOMMERCE_INITIALISED, '');
        if ($status === 'done') {
            return;
        }

        if (!$this->fluentcart_tables_missing()) {
            update_option(self::OPTION_ECOMMERCE_INITIALISED, 'done', false);
            return;
        }

        if ($status === 'pending') {
            return;
        }

        update_option(self::OPTION_ECOMMERCE_INITIALISED, 'pending', false);

        if (!class_exists('\\FluentCart\\App\\Hooks\\Handlers\\ActivationHandler')) {
            update_option(self::OPTION_ECOMMERCE_INITIALISED, '', false);
            return;
        }

        try {
            (new \FluentCart\App\Hooks\Handlers\ActivationHandler())->handle();
        } catch (\Throwable $exception) {
            update_option(self::OPTION_ECOMMERCE_INITIALISED, '', false);
            return;
        }

        if ($this->fluentcart_tables_missing()) {
            update_option(self::OPTION_ECOMMERCE_INITIALISED, '', false);
            return;
        }

        update_option(self::OPTION_ECOMMERCE_INITIALISED, 'done', false);
    }

    /**
     * Determine whether key FluentCart tables exist.
     */
    private function fluentcart_tables_missing(): bool
    {
        global $wpdb;

        if (!($wpdb instanceof \wpdb)) {
            return true;
        }

        $tables = [
            'fct_orders',
            'fct_order_items',
            'fct_customers',
            'fct_products',
        ];

        foreach ($tables as $table) {
            $table_name = $wpdb->prefix . $table;
            $like = $wpdb->esc_like($table_name);
            $result = $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $like));

            if ($result !== $table_name) {
                return true;
            }
        }

        return false;
    }
}
