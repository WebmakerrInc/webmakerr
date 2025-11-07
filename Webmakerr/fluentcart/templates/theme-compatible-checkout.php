<?php
/**
 * Template Name: FluentCart Theme Compatible Checkout
 * Template Post Type: page
 * Description: Dedicated FluentCart checkout experience that aligns with the theme layout while using FluentCart assets.
 */

declare(strict_types=1);

use FluentCart\Api\StoreSettings;

if (! defined('ABSPATH')) {
    exit;
}

$pageTitle = get_the_title();
$pageIntro = '';

if (have_posts()) {
    the_post();
    $pageTitle = get_the_title();
    $rawContent = trim(get_the_content(''));
    if ($rawContent !== '') {
        $pageIntro = apply_filters('the_content', $rawContent);
    }
}
wp_reset_postdata();

$storeSettings = class_exists(StoreSettings::class) ? new StoreSettings() : null;
$storeName = $storeSettings ? (string) $storeSettings->get('store_name', get_bloginfo('name')) : get_bloginfo('name');
$storeLogo = $storeSettings ? $storeSettings->get('store_logo') : '';
$storeLogoUrl = '';
$themeLogoId = function_exists('get_theme_mod') ? (int) get_theme_mod('custom_logo') : 0;
$themeLogoHtml = $themeLogoId ? wp_get_attachment_image(
    $themeLogoId,
    'full',
    false,
    [
        'class' => 'fct-checkout-brand__logo',
        'alt' => get_bloginfo('name')
    ]
) : '';

if (is_array($storeLogo) && ! empty($storeLogo['url'])) {
    $storeLogoUrl = (string) $storeLogo['url'];
} elseif (is_string($storeLogo) && filter_var($storeLogo, FILTER_VALIDATE_URL)) {
    $storeLogoUrl = $storeLogo;
}

$supportEmail = sanitize_email((string) get_option('admin_email'));
$siteLocale = function_exists('determine_locale') ? determine_locale() : get_locale();
$localeLabel = strtoupper(str_replace('_', '-', $siteLocale));

if (class_exists('Locale')) {
    try {
        $displayLocale = \Locale::getDisplayLanguage($siteLocale, $siteLocale);
        $displayRegion = \Locale::getDisplayRegion($siteLocale, $siteLocale);
        $localeLabel = trim($displayLocale . ($displayRegion ? ' (' . $displayRegion . ')' : '')) ?: $localeLabel;
    } catch (\Throwable $e) {
        $localeLabel = strtoupper(str_replace('_', '-', $siteLocale));
    }
}

if (! function_exists('webmakerr_render_checkout_assurance_section')) {
    function webmakerr_render_checkout_assurance_section()
    {
        ?>
        <section class="fct-checkout-assurance" aria-label="<?php esc_attr_e('Checkout assurances', 'webmakerr'); ?>">
            <h2 class="screen-reader-text"><?php esc_html_e('Checkout assurances', 'webmakerr'); ?></h2>
            <ul class="fct-checkout-assurance__list" role="list">
                <li class="fct-checkout-assurance__item" role="listitem">
                    <span class="fct-checkout-assurance__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 9V6a6 6 0 1 1 12 0v3" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 10h14v8.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 5 18.5V10Z" />
                        </svg>
                    </span>
                    <span class="fct-checkout-assurance__content">
                        <span class="fct-checkout-assurance__title"><?php esc_html_e('SSL secured checkout', 'webmakerr'); ?></span>
                        <span class="fct-checkout-assurance__desc"><?php esc_html_e('Protected with 256-bit encryption and PCI-compliant gateways.', 'webmakerr'); ?></span>
                    </span>
                </li>
                <li class="fct-checkout-assurance__item" role="listitem">
                    <span class="fct-checkout-assurance__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 12h8l2-5 6 10" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v3" />
                        </svg>
                    </span>
                    <span class="fct-checkout-assurance__content">
                        <span class="fct-checkout-assurance__title"><?php esc_html_e('Instant order confirmation', 'webmakerr'); ?></span>
                        <span class="fct-checkout-assurance__desc"><?php esc_html_e('Get access to your purchase right away once the payment is complete.', 'webmakerr'); ?></span>
                    </span>
                </li>
                <li class="fct-checkout-assurance__item" role="listitem">
                    <span class="fct-checkout-assurance__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h7M5 19h14" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.5 16H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4.5" />
                        </svg>
                    </span>
                    <span class="fct-checkout-assurance__content">
                        <span class="fct-checkout-assurance__title"><?php esc_html_e('VAT-ready invoices', 'webmakerr'); ?></span>
                        <span class="fct-checkout-assurance__desc"><?php esc_html_e('Receive compliant receipts with every completed order.', 'webmakerr'); ?></span>
                    </span>
                </li>
            </ul>
        </section>
        <?php
    }
}

add_action('fluent_cart/after_order_notes_field', 'webmakerr_render_checkout_assurance_section');

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo esc_html(wp_get_document_title()); ?></title>
    <?php wp_head(); ?>
    <style>
        :root {
            --fct-theme-shell-bg: var(--fct-checkout-secondary-bg-color, #f5f7fb);
            --fct-theme-card-bg: var(--fct-checkout-summary-bg-color, #ffffff);
            --fct-theme-border-color: var(--fct-checkout-border-color, #d6dae1);
            --fct-theme-primary-text: var(--fct-checkout-primary-text-color, #2f3448);
            --fct-theme-secondary-text: var(--fct-checkout-secondary-text-color, #5b6270);
            --fct-theme-primary-bg: var(--fct-checkout-primary-bg-color, #253241);
            --fct-theme-accent: var(--fct-checkout-btn-bg-color, #2563eb);
        }

        body.fct-theme-compatible-checkout {
            margin: 0;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--fct-theme-shell-bg);
            color: var(--fct-theme-primary-text);
            -webkit-font-smoothing: antialiased;
        }

        .fct-checkout-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .fct-checkout-container {
            width: min(100%, 1280px);
            margin: 0 auto;
            padding: 24px 24px;
        }

        @media (min-width: 640px) {
            .fct-checkout-container {
                padding: 32px 32px;
            }
        }

        @media (min-width: 1024px) {
            .fct-checkout-container {
                padding: 40px 32px;
            }
        }

        .fct-checkout-header .fct-checkout-container {
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0 24px;
        }

        @media (min-width: 640px) {
            .fct-checkout-header .fct-checkout-container {
                padding: 0 32px;
            }
        }

        .fct-checkout-header {
            background: #ffffff;
            color: var(--fct-theme-primary-text);
            border-bottom: 1px solid var(--fct-theme-border-color);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
            height: 45px;
        }

        .fct-checkout-header__inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            height: 100%;
        }

        .fct-checkout-header__top {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            width: 100%;
        }

        .fct-checkout-brand {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1 1 auto;
            min-width: 0;
        }

        .fct-checkout-brand__logo {
            max-height: 28px;
            width: auto;
            display: block;
        }

        .fct-checkout-brand__name {
            font-size: clamp(1.1rem, 3vw, 1.4rem);
            font-weight: 600;
            letter-spacing: -0.01em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .fct-checkout-locale {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid var(--fct-theme-border-color);
            background: var(--fct-theme-shell-bg);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--fct-theme-primary-text);
            flex-shrink: 0;
        }

        .fct-checkout-locale svg {
            width: 18px;
            height: 18px;
            color: var(--fct-theme-accent);
        }

        .fct-checkout-assurance {
            margin-top: 16px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            background: #ffffff;
            padding: 16px;
        }

        .fct-checkout-assurance__list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .fct-checkout-assurance__item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .fct-checkout-assurance__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--fct-theme-shell-bg);
            color: var(--fct-theme-accent);
            box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.12);
        }

        .fct-checkout-assurance__icon svg {
            width: 20px;
            height: 20px;
        }

        .fct-checkout-assurance__content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .fct-checkout-assurance__title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--fct-theme-primary-text);
        }

        .fct-checkout-assurance__desc {
            font-size: 0.85rem;
            line-height: 1.5;
            color: var(--fct-theme-secondary-text);
        }

        .fct-checkout-main {
            flex: 1 1 auto;
            padding-block: clamp(16px, 4vw, 48px);
        }

        .fct-checkout-main__inner {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .fct-checkout-surface {
            background: var(--fct-theme-card-bg);
            border-radius: 5px;
            padding: clamp(24px, 4vw, 40px);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(15, 23, 42, 0.06);
        }

        .fct-checkout-surface [data-fluent-cart-checkout-page-checkout-form],
        .fct-checkout-surface [data-fluent-cart-checkout-page-cart-items-wrapper],
        .fct-checkout-surface [data-fluent-cart-checkout-page-shipping-methods-wrapper] {
            border-radius: 5px;
        }

        .fct-checkout-surface button[data-fluent-cart-checkout-page-checkout-button] {
            background-color: #000;
            border: 1px solid #000;
            color: #fff;
            border-radius: 5px;
            padding: 16px 28px;
            font-weight: 600;
            font-size: 1rem;
            line-height: 1.2;
            transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }

        .fct-checkout-surface button[data-fluent-cart-checkout-page-checkout-button]:hover,
        .fct-checkout-surface button[data-fluent-cart-checkout-page-checkout-button]:focus {
            background-color: #111;
            color: #fff;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
        }

        .fct-checkout-surface button[data-fluent-cart-checkout-page-checkout-button][disabled],
        .fct-checkout-surface button[data-fluent-cart-checkout-page-checkout-button][aria-disabled="true"] {
            opacity: 0.6;
            cursor: not-allowed;
            box-shadow: none;
        }

        @media (max-width: 767px) {
            body.fct-theme-compatible-checkout {
                padding-bottom: calc(96px + env(safe-area-inset-bottom));
            }

            .fct-checkout-surface button[data-fluent-cart-checkout-page-checkout-button] {
                position: fixed;
                left: 16px;
                right: 16px;
                bottom: calc(16px + env(safe-area-inset-bottom));
                width: auto;
                display: block;
                z-index: 1000;
                box-shadow: 0 16px 32px rgba(0, 0, 0, 0.22);
            }
        }

        .fct-checkout-surface > .fluent-cart-checkout-page {
            margin: 0;
        }

        .fct-checkout-intro {
            max-width: 720px;
        }

        .fct-checkout-intro h1 {
            margin: 0 0 12px;
            font-size: clamp(2rem, 2.4vw + 1.2rem, 2.75rem);
            font-weight: 600;
            color: var(--fct-theme-primary-text);
        }

        .fct-checkout-intro p {
            margin: 0;
            font-size: 1rem;
            line-height: 1.65;
            color: var(--fct-theme-secondary-text);
        }

        .fct-checkout-footer {
            background: #ffffff;
            border-top: 1px solid var(--fct-theme-border-color);
            padding-block: clamp(32px, 6vw, 48px);
        }

        .fct-checkout-footer__inner {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .fct-checkout-footer__grid {
            display: grid;
            gap: 24px;
        }

        @media (min-width: 768px) {
            .fct-checkout-footer__grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                align-items: start;
            }
        }

        .fct-checkout-footer__support {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            font-size: 0.95rem;
            color: var(--fct-theme-secondary-text);
            background: var(--fct-theme-shell-bg);
            border-radius: 18px;
            padding: 18px 20px;
            box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.08);
        }

        .fct-checkout-footer__support svg {
            width: 22px;
            height: 22px;
            color: var(--fct-theme-accent);
            flex-shrink: 0;
        }

        .fct-checkout-footer__support a {
            color: var(--fct-theme-accent);
            font-weight: 600;
            text-decoration: none;
        }

        .fct-checkout-footer__support a:hover,
        .fct-checkout-footer__support a:focus {
            text-decoration: underline;
        }

        .fct-checkout-footer__badges {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .fct-checkout-footer__badge {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .fct-checkout-footer__badge-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--fct-theme-shell-bg);
            color: var(--fct-theme-accent);
        }

        .fct-checkout-footer__badge-icon svg {
            width: 20px;
            height: 20px;
        }

        .fct-checkout-footer__badge strong {
            display: block;
            font-size: 0.95rem;
            color: var(--fct-theme-primary-text);
        }

        .fct-checkout-footer__badge span {
            display: block;
            font-size: 0.82rem;
            color: var(--fct-theme-secondary-text);
            line-height: 1.5;
        }

        .fct-checkout-footer__payments {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .fct-checkout-footer__payments-label {
            font-weight: 600;
            color: var(--fct-theme-primary-text);
            font-size: 0.95rem;
        }

        .fct-checkout-footer__payments-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .fct-checkout-footer__payments-list li {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid var(--fct-theme-border-color);
            background: #ffffff;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--fct-theme-secondary-text);
        }

        .fct-checkout-footer__payments-list svg {
            width: 24px;
            height: auto;
        }

        .fct-checkout-footer__bottom {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        @media (min-width: 768px) {
            .fct-checkout-footer__bottom {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .fct-checkout-footer__links {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 0.85rem;
        }

        .fct-checkout-footer__links a {
            color: var(--fct-theme-primary-text);
            font-weight: 600;
            text-decoration: none;
        }

        .fct-checkout-footer__links a:hover,
        .fct-checkout-footer__links a:focus {
            color: var(--fct-theme-accent);
        }

        .fct-checkout-footer__legal {
            font-size: 0.8rem;
            color: var(--fct-theme-secondary-text);
        }
    </style>
</head>
<body <?php body_class('fct-theme-compatible-checkout'); ?>>
<?php wp_body_open(); ?>
<div class="fct-checkout-shell">
    <header class="fct-checkout-header" role="banner">
        <div class="fct-checkout-container">
            <div class="fct-checkout-header__inner">
                <div class="fct-checkout-header__top">
                    <div class="fct-checkout-brand">
                        <?php if ($storeLogoUrl) : ?>
                            <img class="fct-checkout-brand__logo" src="<?php echo esc_url($storeLogoUrl); ?>" alt="<?php echo esc_attr($storeName); ?>" />
                        <?php elseif ($themeLogoHtml) : ?>
                            <?php echo wp_kses_post($themeLogoHtml); ?>
                        <?php else : ?>
                            <span class="fct-checkout-brand__name"><?php echo esc_html($storeName); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="fct-checkout-locale" aria-label="<?php esc_attr_e('Current language', 'webmakerr'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3a9 9 0 1 0 9 9" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h18" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3a17.5 17.5 0 0 1 4.5 9 17.5 17.5 0 0 1-4.5 9 17.5 17.5 0 0 1-4.5-9 17.5 17.5 0 0 1 4.5-9Z" />
                        </svg>
                        <span><?php echo esc_html($localeLabel); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="fct-checkout-main" role="main">
        <div class="fct-checkout-container">
            <div class="fct-checkout-main__inner">
                <div class="fct-checkout-intro">
                    <h1 class="screen-reader-text"><?php echo esc_html($pageTitle ?: __('Checkout', 'webmakerr')); ?></h1>
                    <?php if ($pageIntro) : ?>
                        <div class="fct-checkout-intro__content">
                            <?php echo $pageIntro; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="fct-checkout-surface" data-fct-checkout-surface>
                    <?php echo do_shortcode('[webmakerr_checkout]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
        </div>
    </main>

    <footer class="fct-checkout-footer" role="contentinfo">
        <div class="fct-checkout-container">
            <div class="fct-checkout-footer__inner">
                <div class="fct-checkout-footer__grid">
                    <div class="fct-checkout-footer__support">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636a9 9 0 1 1-12.728 0M12 8v4l2.5 1.5" />
                        </svg>
                        <span>
                            <?php
                            if ($supportEmail) {
                                printf(
                                    /* translators: %s: support email address */
                                    esc_html__('Need a hand? Email our success team at %s', 'webmakerr'),
                                    '<a href="' . esc_url('mailto:' . $supportEmail) . '">' . esc_html($supportEmail) . '</a>'
                                );
                            } else {
                                esc_html_e('Need a hand? Our success team is ready to assist you 24/7.', 'webmakerr');
                            }
                            ?>
                        </span>
                    </div>
                    <div class="fct-checkout-footer__badges">
                        <div class="fct-checkout-footer__badge">
                            <span class="fct-checkout-footer__badge-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m5 13 4 4L19 7" />
                                </svg>
                            </span>
                            <span>
                                <strong><?php esc_html_e('14-day money-back guarantee', 'webmakerr'); ?></strong>
                                <span><?php esc_html_e('Cancel any time within 14 days and receive a full refund—no questions asked.', 'webmakerr'); ?></span>
                            </span>
                        </div>
                        <div class="fct-checkout-footer__badge">
                            <span class="fct-checkout-footer__badge-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18v-4.5A3.5 3.5 0 0 1 9.5 10H15" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m14 6 4 4-4 4" />
                                </svg>
                            </span>
                            <span>
                                <strong><?php esc_html_e('Instant account activation', 'webmakerr'); ?></strong>
                                <span><?php esc_html_e('Jump right into your dashboard—your purchase unlocks access immediately.', 'webmakerr'); ?></span>
                            </span>
                        </div>
                    </div>
                    <div class="fct-checkout-footer__payments">
                        <span class="fct-checkout-footer__payments-label"><?php esc_html_e('We accept', 'webmakerr'); ?></span>
                        <ul class="fct-checkout-footer__payments-list" aria-label="<?php esc_attr_e('Accepted payment methods', 'webmakerr'); ?>">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 40" role="img" aria-label="Visa">
                                    <rect width="64" height="40" rx="8" fill="#1a1f36" />
                                    <path fill="#f2f5ff" d="M23.6 28.2h-4.2l2.6-16.4h4.2l-2.6 16.4Zm6.8 0h-3.9l-2.1-16.4h3.6l1 10.9 5.6-10.9h3.6l-7.8 16.4Zm9.3 0 2.6-16.4h4.1l-2.6 16.4h-4.1Zm14.6-11.8c-.4-1.6-2-2.7-4-2.7-1.1 0-2.3.4-3 .8l-.5.3.6-3.7c.8-.4 2.2-.7 3.6-.7 3.4 0 5.6 1.7 6.2 4.4.6 2.6-1.5 4.1-2.6 5 0 0-1.5 1.2-2.1 1.8-.3.3-.6.6-.6 1.1h5.4l-.4 2.7h-9.3c.1-1.5.9-2.6 2.6-4.1l1.1-.9c1-.8 1.9-1.5 1.6-2.5Z" />
                                </svg>
                                Visa
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 40" role="img" aria-label="Mastercard">
                                    <rect width="64" height="40" rx="8" fill="#1a1f36" />
                                    <circle cx="26" cy="20" r="10" fill="#f28b30" />
                                    <circle cx="38" cy="20" r="10" fill="#eb001b" fill-opacity="0.8" />
                                </svg>
                                Mastercard
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 40" role="img" aria-label="American Express">
                                    <rect width="64" height="40" rx="8" fill="#1a1f36" />
                                    <text x="32" y="24" text-anchor="middle" font-size="10" fill="#f2f5ff" font-family="Arial, sans-serif" font-weight="700">AMEX</text>
                                </svg>
                                Amex
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 40" role="img" aria-label="PayPal">
                                    <rect width="64" height="40" rx="8" fill="#1a1f36" />
                                    <path fill="#f2f5ff" d="M26 28.5h4l.5-2.9h2.5c3.8 0 6.6-2.5 7.2-6.3.6-3.7-1.4-6.3-5.1-6.3h-7.2l-1.9 11.8h-2.9l-.8 3.7c0 0 3.7 0 3.7 0Z" />
                                </svg>
                                PayPal
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="fct-checkout-footer__bottom">
                    <div class="fct-checkout-footer__links">
                        <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php esc_html_e('Privacy policy', 'webmakerr'); ?></a>
                        <a href="<?php echo esc_url(home_url('/terms-of-service')); ?>"><?php esc_html_e('Terms of service', 'webmakerr'); ?></a>
                        <a href="<?php echo esc_url(home_url('/support')); ?>"><?php esc_html_e('Support center', 'webmakerr'); ?></a>
                    </div>
                    <div class="fct-checkout-footer__legal">
                        &copy; <?php echo esc_html((string) gmdate('Y')); ?> <?php echo esc_html($storeName); ?>. <?php esc_html_e('All rights reserved.', 'webmakerr'); ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
