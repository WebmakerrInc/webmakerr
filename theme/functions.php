<?php

use Webmakerr\Framework\Assets\ViteCompiler;
use Webmakerr\Framework\Features\MenuOptions;
use Webmakerr\Framework\Theme;

if (! defined('WEBMAKERR_LICENSE_SERVER_URL')) {
    define('WEBMAKERR_LICENSE_SERVER_URL', 'https://xyz.com/api/validate-license.php');
}

if (is_file(__DIR__.'/vendor/autoload_packages.php')) {
    require_once __DIR__.'/vendor/autoload_packages.php';
} else {
    spl_autoload_register(function (string $class): void {
        if (str_starts_with($class, 'Webmakerr\\')) {
            $baseDir = __DIR__.'/src/';
            $relativeClass = substr($class, strlen('Webmakerr\\'));
            $file = $baseDir.str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass).'.php';

            if (is_file($file)) {
                require_once $file;
            }
        }
    });
}

if (! function_exists('webmakerr_setup')) {
    function webmakerr_setup(): void
    {
        load_theme_textdomain('webmakerr', get_template_directory().'/languages');

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');

        register_nav_menus(
            [
                'primary' => esc_html__('Primary Menu', 'webmakerr'),
                'footer'  => esc_html__('Footer Menu', 'webmakerr'),
            ]
        );

        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );

        add_theme_support(
            'custom-background',
            apply_filters(
                'webmakerr_custom_background_args',
                [
                    'default-color' => 'ffffff',
                    'default-image' => '',
                ]
            )
        );

        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support(
            'custom-logo',
            [
                'height'      => 37,
                'width'       => 142,
                'flex-width'  => false,
                'flex-height' => false,
            ]
        );
    }
}

add_action('after_setup_theme', 'webmakerr_setup');

function webmakerr(): Theme
{
    return Theme::instance()
        ->assets(static fn ($manager) => $manager
            ->withCompiler(new ViteCompiler(), static fn ($compiler) => $compiler
                ->registerAsset('build/assets/app.css')
                ->registerAsset('build/assets/app.js')
                ->editorStyleFile('build/assets/editor-style.css')
            )
            ->enqueueAssets()
        )
        ->features(static fn ($manager) => $manager->add(MenuOptions::class))
        ->menus(static fn ($manager) => $manager
            ->add('primary', __('Primary Menu', 'webmakerr'))
            ->add('footer', __('Footer Menu', 'webmakerr'))
        )
        ->themeSupport(static fn ($manager) => $manager->add([
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
        ]));
}

add_filter(
    'nav_menu_css_class',
    static function (array $classes, $item, $args, int $depth): array {
        if (($args->theme_location ?? null) !== 'footer') {
            return $classes;
        }

        $normalized = ['menu-item', 'list-none'];

        if ($depth === 0) {
            $normalized[] = 'footer-menu-item';
        } else {
            $normalized[] = 'footer-submenu-item';
        }

        return array_values(array_unique($normalized));
    },
    10,
    4
);

add_filter(
    'nav_menu_submenu_css_class',
    static function (array $classes, $args, int $depth): array {
        if (($args->theme_location ?? null) !== 'footer') {
            return $classes;
        }

        $classes[] = 'list-none';

        return array_values(array_unique(array_filter($classes)));
    },
    10,
    3
);

add_filter(
    'nav_menu_link_attributes',
    static function (array $atts, $item, $args, int $depth): array {
        if (($args->theme_location ?? null) !== 'footer') {
            return $atts;
        }

        $baseClasses = 'transition-colors duration-200 ease-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-900';

        if ($depth === 0) {
            $linkClasses = 'no-underline text-sm font-semibold text-neutral-900 hover:opacity-70 md:text-base';
        } else {
            $linkClasses = 'block no-underline text-sm text-neutral-500 hover:text-neutral-900';
        }

        $atts['class'] = trim($linkClasses.' '.$baseClasses);

        return $atts;
    },
    10,
    4
);

add_action(
    'after_setup_theme',
    static function (): void {
        webmakerr();
    },
    11
);

add_action(
    'admin_menu',
    static function (): void {
        add_theme_page(
            __('Theme License', 'webmakerr'),
            __('Theme License', 'webmakerr'),
            'manage_options',
            'webmakerr-theme-license',
            'webmakerr_render_license_settings_page'
        );
    }
);

add_filter(
    'template_include',
    static function ($template) {
        $customTemplate = trailingslashit(get_stylesheet_directory()) . 'fluentcart/templates/theme-compatible-checkout.php';

        if (! class_exists('\\FluentCart\\App\\Services\\TemplateService')) {
            return $template;
        }

        if (! \FluentCart\App\Services\TemplateService::isFcPageType('checkout')) {
            return $template;
        }

        if (is_readable($customTemplate)) {
            return $customTemplate;
        }

        return $template;
    },
    60
);

if (! function_exists('webmakerr_render_license_settings_page')) {
    function webmakerr_render_license_settings_page(): void
    {
        if (! current_user_can('manage_options')) {
            return;
        }

        $savedKey = get_option('webmakerr_theme_license_key', '');
        $savedStatus = get_option('webmakerr_theme_license_status', 'inactive');
        $statuses = [
            'active'   => __('Active', 'webmakerr'),
            'revoked'  => __('Revoked', 'webmakerr'),
            'invalid'  => __('Invalid', 'webmakerr'),
            'inactive' => __('Inactive', 'webmakerr'),
        ];
        $statusLabel = $statuses[$savedStatus] ?? $statuses['inactive'];
        ?>
        <div class="wrap webmakerr-license-page">
            <h1 class="webmakerr-license-title"><?php esc_html_e('Theme License', 'webmakerr'); ?></h1>
            <p class="webmakerr-license-description"><?php esc_html_e('Activate your Webmakerr theme license to unlock updates and premium support.', 'webmakerr'); ?></p>

            <div class="webmakerr-license-card">
                <label for="webmakerr-license-key" class="webmakerr-license-label"><?php esc_html_e('License Key', 'webmakerr'); ?></label>
                <input type="text" id="webmakerr-license-key" class="webmakerr-license-input" value="<?php echo esc_attr($savedKey); ?>" placeholder="<?php esc_attr_e('Enter your license key', 'webmakerr'); ?>" />

                <div class="webmakerr-license-actions">
                    <button type="button" class="button button-primary webmakerr-license-button" id="webmakerr-activate-license">
                        <?php esc_html_e('Activate License', 'webmakerr'); ?>
                    </button>
                    <span class="webmakerr-license-spinner" hidden></span>
                </div>

                <div class="webmakerr-license-status" data-stored-status="<?php echo esc_attr($savedStatus); ?>">
                    <strong><?php esc_html_e('Current Status:', 'webmakerr'); ?></strong>
                    <span id="webmakerr-license-status-text" class="status-<?php echo esc_attr($savedStatus); ?>"><?php echo esc_html($statusLabel); ?></span>
                </div>

                <div id="webmakerr-license-feedback" class="webmakerr-license-feedback" aria-live="polite"></div>
            </div>
        </div>
        <?php
    }
}

add_action(
    'admin_enqueue_scripts',
    static function (string $hook): void {
        if ($hook !== 'appearance_page_webmakerr-theme-license') {
            return;
        }

        wp_enqueue_style(
            'webmakerr-license-admin',
            get_template_directory_uri().'/resources/css/license-admin.css',
            [],
            wp_get_theme()->get('Version')
        );

        wp_enqueue_script(
            'webmakerr-license-admin',
            get_template_directory_uri().'/resources/js/license-admin.js',
            [],
            wp_get_theme()->get('Version'),
            true
        );

        wp_localize_script(
            'webmakerr-license-admin',
            'webmakerrLicenseData',
            [
                'endpoint'   => esc_url_raw(rest_url('webmakerr/v1/check-license')),
                'nonce'      => wp_create_nonce('wp_rest'),
                'messages'   => [
                    'empty'   => __('Please enter a license key before activating.', 'webmakerr'),
                    'success' => __('✅ License Activated Successfully', 'webmakerr'),
                    'error'   => __('❌ Invalid or Revoked License Key.', 'webmakerr'),
                ],
                'labels'     => [
                    'active'   => __('Active', 'webmakerr'),
                    'revoked'  => __('Revoked', 'webmakerr'),
                    'invalid'  => __('Invalid', 'webmakerr'),
                    'inactive' => __('Inactive', 'webmakerr'),
                ],
                'storedStatus' => get_option('webmakerr_theme_license_status', 'inactive'),
            ]
        );
    }
);

add_action(
    'rest_api_init',
    static function (): void {
        register_rest_route(
            'webmakerr/v1',
            '/check-license',
            [
                'methods'             => 'POST',
                'callback'            => 'webmakerr_rest_check_license',
                'permission_callback' => static function (): bool {
                    return current_user_can('manage_options');
                },
                'args'                => [
                    'license_key' => [
                        'required'          => true,
                        'sanitize_callback' => static function ($value) {
                            return sanitize_text_field(wp_unslash($value));
                        },
                    ],
                ],
            ]
        );
    }
);

if (! function_exists('webmakerr_get_template_popup_settings')) {
    /**
     * Retrieve popup configuration for a specific template.
     */
    function webmakerr_get_template_popup_settings(string $template_file): array
    {
        static $cache = [];

        $template_key = basename($template_file);

        if (isset($cache[$template_key])) {
            return $cache[$template_key];
        }

        $defaults = [
            'form_id'  => 0,
            'headline' => '',
            'enabled'  => false,
        ];

        $config_path = get_template_directory().'/templates/config/popup-content.php';

        if (! is_readable($config_path)) {
            $cache[$template_key] = $defaults;

            return $defaults;
        }

        $config = include $config_path;

        if (! is_array($config)) {
            $cache[$template_key] = $defaults;

            return $defaults;
        }

        if (! isset($config[$template_key]) || ! is_array($config[$template_key])) {
            $cache[$template_key] = $defaults;

            return $defaults;
        }

        $settings = $config[$template_key];
        $form_id  = isset($settings['form_id']) ? absint($settings['form_id']) : 0;
        $headline = isset($settings['headline']) ? (string) $settings['headline'] : '';

        $resolved = [
            'form_id'  => $form_id,
            'headline' => $headline,
            'enabled'  => $form_id > 0,
        ];

        $cache[$template_key] = $resolved;

        return $resolved;
    }
}

if (! function_exists('webmakerr_get_popup_link_attributes')) {
    /**
     * Normalize CTA link attributes when a popup is available.
     */
    function webmakerr_get_popup_link_attributes(string $fallback_url, bool $popup_enabled): array
    {
        if ($popup_enabled) {
            return [
                'href'       => '#ff-popup',
                'attributes' => ' data-popup-trigger aria-controls="ff-popup"',
            ];
        }

        return [
            'href'       => $fallback_url,
            'attributes' => '',
        ];
    }
}

if (! function_exists('webmakerr_render_template_popup')) {
    /**
     * Render the Fluent Form popup when enabled for the template.
     */
    function webmakerr_render_template_popup(array $popup_settings): void
    {
        $form_id = isset($popup_settings['form_id']) ? absint($popup_settings['form_id']) : 0;

        if ($form_id <= 0) {
            return;
        }

        $popup_partial = get_template_directory().'/partials/fluentform-popup.php';

        if (! is_readable($popup_partial)) {
            return;
        }

        $popup_headline = isset($popup_settings['headline']) ? (string) $popup_settings['headline'] : '';

        include $popup_partial;
    }
}

if (! function_exists('webmakerr_validate_license_remotely')) {
    /**
     * Validate a license key against the remote server.
     */
    function webmakerr_validate_license_remotely(string $licenseKey): array
    {
        $response = wp_remote_post(
            WEBMAKERR_LICENSE_SERVER_URL,
            [
                'timeout' => 15,
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'body'    => wp_json_encode([
                    'license_key' => $licenseKey,
                ]),
            ]
        );

        if (is_wp_error($response)) {
            return [
                'is_valid'      => false,
                'message'       => __('Unable to reach the license server. Please try again shortly.', 'webmakerr'),
                'status_code'   => 0,
                'request_error' => true,
            ];
        }

        $statusCode = (int) wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $decoded = json_decode($body, true);

        if (! is_array($decoded)) {
            return [
                'is_valid'      => false,
                'message'       => __('Unexpected response from the license server.', 'webmakerr'),
                'status_code'   => $statusCode >= 400 ? $statusCode : 500,
                'request_error' => true,
            ];
        }

        $serverStatus = strtolower((string) ($decoded['status'] ?? 'error'));
        $message = is_string($decoded['message'] ?? null) ? $decoded['message'] : '';
        $isValid = $serverStatus === 'success';

        if ($message === '') {
            $message = $isValid
                ? __('License activated successfully.', 'webmakerr')
                : __('Invalid license key.', 'webmakerr');
        }

        return [
            'is_valid'      => $isValid,
            'message'       => $message,
            'status_code'   => $statusCode,
            'request_error' => false,
        ];
    }
}

if (! function_exists('webmakerr_revalidate_saved_license')) {
    /**
     * Revalidate the stored license key and handle activation notices.
     */
    function webmakerr_revalidate_saved_license(): void
    {
        delete_transient('webmakerr_license_invalid_notice');

        $licenseKey = (string) get_option('webmakerr_theme_license_key', '');

        if ($licenseKey === '') {
            update_option('webmakerr_theme_license_status', 'inactive');

            return;
        }

        $validation = webmakerr_validate_license_remotely($licenseKey);

        if (! $validation['is_valid'] && ! $validation['request_error']) {
            update_option('webmakerr_theme_license_status', 'inactive');
            set_transient(
                'webmakerr_license_invalid_notice',
                __('Your license is no longer valid. Please reactivate your theme license.', 'webmakerr'),
                MINUTE_IN_SECONDS * 10
            );

            return;
        }

        if ($validation['is_valid']) {
            update_option('webmakerr_theme_license_status', 'active');
        }
    }
}

add_action(
    'after_switch_theme',
    static function (): void {
        webmakerr_revalidate_saved_license();
    }
);

add_action(
    'admin_notices',
    static function (): void {
        $notice = get_transient('webmakerr_license_invalid_notice');

        if ($notice === false) {
            return;
        }

        delete_transient('webmakerr_license_invalid_notice');

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
            esc_html($notice)
        );
    }
);

if (! function_exists('webmakerr_rest_check_license')) {
    function webmakerr_rest_check_license(\WP_REST_Request $request): \WP_REST_Response
    {
        $licenseKey = (string) $request->get_param('license_key');

        if ($licenseKey === '') {
            update_option('webmakerr_theme_license_status', 'inactive');

            return new WP_REST_Response(
                [
                    'valid'   => false,
                    'status'  => 'inactive',
                    'message' => __('Please provide a license key.', 'webmakerr'),
                ],
                400
            );
        }

        $validation = webmakerr_validate_license_remotely($licenseKey);

        if ($validation['request_error']) {
            update_option('webmakerr_theme_license_status', 'invalid');

            return new WP_REST_Response(
                [
                    'valid'   => false,
                    'status'  => 'invalid',
                    'message' => $validation['message'],
                ],
                $validation['status_code'] >= 400 ? $validation['status_code'] : 500
            );
        }

        if ($validation['is_valid']) {
            update_option('webmakerr_theme_license_key', $licenseKey);
            update_option('webmakerr_theme_license_status', 'active');
            delete_transient('webmakerr_license_invalid_notice');
        } else {
            update_option('webmakerr_theme_license_status', 'inactive');
        }

        $responseCode = $validation['is_valid'] ? 200 : ($validation['status_code'] >= 400 ? $validation['status_code'] : 400);

        return new WP_REST_Response(
            [
                'valid'   => $validation['is_valid'],
                'status'  => $validation['is_valid'] ? 'active' : 'inactive',
                'message' => $validation['message'],
            ],
            $responseCode
        );
    }
}

$GLOBALS['webmakerr_pricing_template_bootstrap_only'] = true;
require_once get_template_directory().'/page-pricing.php';
unset($GLOBALS['webmakerr_pricing_template_bootstrap_only']);
