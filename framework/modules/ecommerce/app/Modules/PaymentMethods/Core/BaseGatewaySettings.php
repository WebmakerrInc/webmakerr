<?php

namespace FluentCart\App\Modules\PaymentMethods\Core;

use FluentCart\App\App;
use FluentCart\App\Models\Meta;
use FluentCart\Framework\Support\Arr;

abstract class BaseGatewaySettings
{
    public static array $allSettings = [];
    private static bool $settingsLoaded = false;

    public $settings;
    public $methodHandler;

    public function __construct()
    {
        if (!self::$settingsLoaded) {
            try {
                self::$allSettings = Meta::query()
                    ->whereLike('meta_key', 'fluent_cart_payment_settings\\_%')
                    ->get()
                    ->pluck('meta_value', 'meta_key')
                    ->toArray();
            } catch (\Throwable $exception) {
                self::$allSettings = [];

                if (defined('WP_DEBUG') && WP_DEBUG) {
                    error_log('[FluentCart] Failed to load payment gateway settings: ' . $exception->getMessage());
                }
            }

            self::$settingsLoaded = true;
        }

        try {
            $settings = Arr::get(self::$allSettings, $this->methodHandler, []);
        } catch (\Exception $e) {
            $settings = [];
        }

        if (!is_array($settings)) {
            $settings = [];
        }

        $this->settings = wp_parse_args($settings, static::getDefaults());
    }

    abstract public function get($key = '');
    abstract public function getMode();
    abstract public function isActive();

    public function getCachedSettings()
    {
        return Arr::get(self::$allSettings, $this->methodHandler);
    }
}

