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
     * @var Core
     */
    private $core;

    /**
     * @var array<string, array<string, mixed>>
     */
    private $modules = [];

    /**
     * Keep menu hook name for asset loading.
     *
     * @var string|null
     */
    private $menuHook = null;

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

    /**
     * Bootstrap the admin screen.
     *
     * @param Core  $core
     * @param array $modules
     */
    public function init(Core $core, array $modules): void
    {
        $this->core = $core;
        $this->modules = $modules;

        add_action('admin_menu', [$this, 'register_page']);
        add_action('admin_init', [$this, 'maybe_handle_form']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function register_page(): void
    {
        $this->menuHook = add_menu_page(
            __('Framework Modules', 'framework'),
            __('Framework', 'framework'),
            'manage_options',
            'framework-modules',
            [$this, 'render_page'],
            'dashicons-admin-site',
            56
        );
    }

    /**
     * Process form submission.
     */
    public function maybe_handle_form(): void
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
                if ((string) $value === '1') {
                    $active[] = sanitize_key($slug);
                }
            }
        }

        $this->core->set_active_modules($active);

        $redirect = add_query_arg(
            [
                'page'                         => 'framework-modules',
                'framework-modules-updated'    => '1',
            ],
            admin_url('admin.php')
        );

        wp_safe_redirect($redirect);
        exit;
    }

    /**
     * Load Framework styles so the page matches the rest of the plugin.
     */
    public function enqueue_assets(string $hook): void
    {
        if (!$this->menuHook || $hook !== $this->menuHook) {
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

        $activeModules = $this->core->get_active_modules();
        $updated = isset($_GET['framework-modules-updated']);
        ?>
        <div class="wrap uip-app uip-padding-l uip-text-normal">
            <h1 class="uip-text-2xl uip-margin-bottom-m"><?php esc_html_e('Framework Modules', 'framework'); ?></h1>
            <?php if ($updated) : ?>
                <div class="notice notice-success is-dismissible uip-margin-bottom-m">
                    <p><?php esc_html_e('Module settings saved.', 'framework'); ?></p>
                </div>
            <?php endif; ?>
            <form method="post">
                <?php wp_nonce_field('framework_save_modules', 'framework_modules_nonce'); ?>
                <div class="uip-grid uip-grid-col-1 uip-grid-gap-large">
                    <?php foreach ($this->modules as $slug => $module) :
                        $isActive = in_array($slug, $activeModules, true);
                        ?>
                        <div class="uip-background-default uip-border uip-border-round uip-padding-l">
                            <div class="uip-flex uip-flex-between uip-flex-center uip-gap-l">
                                <div class="uip-flex uip-flex-column uip-gap-xs">
                                    <span class="uip-text-xl uip-text-bold"><?php echo esc_html($module['title'] ?? ucfirst($slug)); ?></span>
                                    <?php if (!empty($module['description'])) : ?>
                                        <span class="uip-text-muted"><?php echo esc_html($module['description']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <label class="uip-toggle uip-flex uip-flex-center">
                                    <input type="checkbox" name="framework_modules[<?php echo esc_attr($slug); ?>]" value="1" <?php checked($isActive); ?> />
                                    <span class="uip-toggle-slider" aria-hidden="true"></span>
                                    <span class="screen-reader-text">
                                        <?php echo $isActive
                                            ? esc_html__('Disable module', 'framework')
                                            : esc_html__('Enable module', 'framework'); ?>
                                    </span>
                                </label>
                            </div>
                            <div class="uip-margin-top-s uip-text-muted">
                                <?php echo $isActive
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
}
