<?php

namespace FluentCart\App\Hooks\Handlers;

use FluentCart\App\Services\TemplateService;

class ReceiptPageTemplateHandler
{
    public function register(): void
    {
        add_filter('template_include', [$this, 'maybeOverrideTemplate'], 60);
    }

    public function maybeOverrideTemplate($template)
    {
        if (!TemplateService::isFcPageType('receipt')) {
            return $template;
        }

        if (!is_page()) {
            return $template;
        }

        $receiptTemplate = FLUENTCART_PLUGIN_PATH . 'templates/receipt-page.php';

        if (!file_exists($receiptTemplate)) {
            return $template;
        }

        return $receiptTemplate;
    }
}
