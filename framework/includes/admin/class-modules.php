<?php
namespace Framework\Admin;

use Framework\Core;

defined('ABSPATH') || exit;

class Modules
{
    /**
     * @var Modules|null
     */
    private static $instance = null;

    /**
     * @var Core|null
     */
    private $core = null;

    /**
     * Stored modules metadata.
     *
     * @var array<string, array<string, mixed>>
     */
    private $modules = [];

    /**
     * @var string|null
     */
    private $menu_hook = null;

    private function __construct()
    {
    }

    public static function get_instance(): Modules
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function init(Core $core): void
    {
        $this->core    = $core;
        $this->modules = $core->get_modules();

        add_action('admin_menu', [$this, 'register_page']);
        add_action('admin_init', [$this, 'handle_form_submission']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function register_page(): void
    {
        $this->menu_hook = add_menu_page(
            __('Modules', 'framework'),
            __('Framework', 'framework'),
            'manage_options',
            'framework-modules',
            [$this, 'render_page'],
            'dashicons-admin-site',
            56
        );
    }

    public function handle_form_submission(): void
    {
        if (!isset($_POST['framework_modules_nonce'])) {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        check_admin_referer('framework_save_modules', 'framework_modules_nonce');

        $active = [];
        if (isset($_POST['framework_modules']) && is_array($_POST['framework_modules'])) {
            foreach ($_POST['framework_modules'] as $slug => $value) {
                if ((string) $value !== '1') {
                    continue;
                }

                $active[] = sanitize_key($slug);
            }
        }

        if ($this->core instanceof Core) {
            $this->core->set_active_modules($active);
        }

        $redirect = add_query_arg(
            [
                'page'                      => 'framework-modules',
                'framework-modules-updated' => '1',
            ],
            admin_url('admin.php')
        );

        wp_safe_redirect($redirect);
        exit;
    }

    public function enqueue_assets(string $hook): void
    {
        if (!$this->menu_hook || $hook !== $this->menu_hook) {
            return;
        }

        wp_enqueue_style(
            'framework-admin-modules',
            FRAMEWORK_PLUGIN_URL . 'assets/css/uip-app.css',
            [],
            FRAMEWORK_VERSION
        );
    }

    public function render_page(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.', 'framework'));
        }

        $active_modules = $this->core instanceof Core ? $this->core->get_active_modules() : [];
        $updated        = isset($_GET['framework-modules-updated']);
        ?>
        <div class="wrap uip-app uip-padding-l uip-text-normal">
            <h1 class="uip-text-2xl uip-margin-bottom-m"><?php esc_html_e('Modules', 'framework'); ?></h1>
            <?php if ($updated) : ?>
                <div class="notice notice-success is-dismissible uip-margin-bottom-m">
                    <p><?php esc_html_e('Module settings saved.', 'framework'); ?></p>
                </div>
            <?php endif; ?>
            <form method="post">
                <?php wp_nonce_field('framework_save_modules', 'framework_modules_nonce'); ?>
                <div class="uip-grid uip-grid-col-1 uip-grid-gap-large">
                    <?php foreach ($this->modules as $slug => $module) :
                        $is_active   = in_array($slug, $active_modules, true);
                        $title       = $this->get_module_text($module, 'title', ucfirst($slug));
                        $description = $this->get_module_text($module, 'description', '');
                        ?>
                        <div class="uip-background-default uip-border uip-border-round uip-padding-l">
                            <div class="uip-flex uip-flex-between uip-flex-center uip-gap-l">
                                <div class="uip-flex uip-flex-column uip-gap-xs">
                                    <span class="uip-text-xl uip-text-bold"><?php echo esc_html($title); ?></span>
                                    <?php if ($description !== '') : ?>
                                        <span class="uip-text-muted"><?php echo esc_html($description); ?></span>
                                    <?php endif; ?>
                                </div>
                                <label class="uip-toggle uip-flex uip-flex-center">
                                    <input type="checkbox" name="framework_modules[<?php echo esc_attr($slug); ?>]" value="1" <?php checked($is_active); ?> />
                                    <span class="uip-toggle-slider" aria-hidden="true"></span>
                                    <span class="screen-reader-text">
                                        <?php echo $is_active
                                            ? esc_html__('Disable module', 'framework')
                                            : esc_html__('Enable module', 'framework'); ?>
                                    </span>
                                </label>
                            </div>
                            <div class="uip-margin-top-s uip-text-muted">
                                <?php echo $is_active
                                    ? esc_html__('Status: Enabled', 'framework')
                                    : esc_html__('Status: Disabled', 'framework'); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="submit uip-margin-top-l">
                    <button type="submit" class="button button-primary uip-button">
                        <?php esc_html_e('Save Changes', 'framework'); ?>
                    </button>
                </p>
            </form>
        </div>
        <?php
    }

    /**
     * Retrieve a translated string for module metadata.
     *
     * @param array<string, mixed> $module
     */
    private function get_module_text(array $module, string $key, string $fallback = ''): string
    {
        if (!array_key_exists($key, $module)) {
            return $fallback;
        }

        $value = $module[$key];

        if (is_callable($value)) {
            $value = (string) $value($module);
        }

        if (!is_string($value)) {
            return $fallback;
        }

        $translated = __($value, 'framework');

        if (!is_string($translated) || $translated === '') {
            return $fallback;
        }

        return $translated;
    }
}
