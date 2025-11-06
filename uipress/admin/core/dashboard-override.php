<?php

use UipressLite\Classes\Utils\URL;

!defined('ABSPATH') ? exit() : '';

class uip_dashboard_override
{
    private $default_template_title = 'New site home';
    private $default_template_id = 8;

    public function run()
    {
        add_action('load-index.php', [$this, 'redirect_to_custom_dashboard']);
    }

    public function redirect_to_custom_dashboard()
    {
        if (!is_admin() || !is_user_logged_in()) {
            return;
        }

        if (is_network_admin()) {
            return;
        }

        if (defined('uip_app_running') && uip_app_running === false) {
            return;
        }

        $enabled = apply_filters('uipress/dashboard/enable_redirect', true);
        if (!$enabled) {
            return;
        }

        $template_id = $this->resolve_template_id();
        if (!$template_id) {
            return;
        }

        $target_path = $this->with_template_context(function () use ($template_id) {
            $post = get_post($template_id);
            if (!$post || 'uip-ui-template' !== $post->post_type) {
                return '';
            }

            $template_type = get_post_meta($template_id, 'uip-template-type', true);
            if ('ui-admin-page' !== $template_type) {
                return '';
            }

            $slug = $this->resolve_template_slug($post);
            if (!$slug) {
                return '';
            }

            return 'admin.php?page=' . $slug;
        });

        if (!$target_path) {
            return;
        }

        $target_url = admin_url($target_path);

        // Avoid redirect loops if already on the target admin page
        if (!empty($_GET['page']) && strpos($target_path, $_GET['page']) !== false) {
            return;
        }

        wp_safe_redirect($target_url);
        exit;
    }

    private function resolve_template_slug($post)
    {
        $settings = get_post_meta($post->ID, 'uip-template-settings', true);
        $slug = '';

        if (is_object($settings) && isset($settings->slug) && $settings->slug && $settings->slug !== 'uipblank') {
            $slug = $settings->slug;
        } elseif (is_array($settings) && !empty($settings['slug']) && $settings['slug'] !== 'uipblank') {
            $slug = $settings['slug'];
        }

        if ($slug) {
            $slug = sanitize_title($slug);
        } else {
            $slug = URL::urlSafe($post->post_title, '-') . '-uiptp-' . $post->ID;
        }

        return $slug;
    }

    private function resolve_template_id()
    {
        $template_id = apply_filters('uipress/dashboard/template_id', null);
        if (is_numeric($template_id) && $template_id > 0) {
            return (int) $template_id;
        }

        $title = apply_filters('uipress/dashboard/template_title', $this->default_template_title);

        $found_id = $this->with_template_context(function () use ($title) {
            if (!$title) {
                return 0;
            }

            $template = get_page_by_title($title, OBJECT, 'uip-ui-template');
            if ($template instanceof WP_Post) {
                return (int) $template->ID;
            }

            return 0;
        });

        if ($found_id) {
            return (int) $found_id;
        }

        $fallback_id = apply_filters('uipress/dashboard/fallback_template_id', $this->default_template_id);

        $fallback_exists = $this->with_template_context(function () use ($fallback_id) {
            if (!$fallback_id) {
                return 0;
            }

            $post = get_post($fallback_id);
            if ($post && 'uip-ui-template' === $post->post_type) {
                return (int) $post->ID;
            }

            return 0;
        });

        if ($fallback_exists) {
            return (int) $fallback_id;
        }

        return 0;
    }

    private function with_template_context(callable $callback)
    {
        $switched = false;

        if ($this->should_switch_to_main_site()) {
            switch_to_blog(get_main_site_id());
            $switched = true;
        }

        $result = call_user_func($callback);

        if ($switched) {
            restore_current_blog();
        }

        return $result;
    }

    private function should_switch_to_main_site()
    {
        if (!is_multisite() || is_main_site()) {
            return false;
        }

        if (!function_exists('is_plugin_active_for_network')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return is_plugin_active_for_network(UIP_PLUGIN_BASENAME);
    }
}
