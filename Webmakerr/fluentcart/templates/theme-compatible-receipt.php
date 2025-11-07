<?php
/**
 * Template Name: FluentCart Theme Compatible Receipt
 * Template Post Type: page
 * Description: Dedicated FluentCart receipt experience that mirrors the custom checkout template styling.
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
            --fct-theme-positive: #16a34a;
            --fct-theme-warning: #f59e0b;
        }

        html {
            background: var(--fct-theme-shell-bg) !important;
        }

        body.fct-theme-compatible-receipt {
            margin: 0;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--fct-theme-shell-bg) !important;
            color: var(--fct-theme-primary-text);
            -webkit-font-smoothing: antialiased;
        }

        body.fct-theme-compatible-receipt .site-header,
        body.fct-theme-compatible-receipt #masthead,
        body.fct-theme-compatible-receipt .site-footer,
        body.fct-theme-compatible-receipt #colophon,
        body.fct-theme-compatible-receipt .entry-header,
        body.fct-theme-compatible-receipt .page-header,
        body.fct-theme-compatible-receipt .entry-title,
        body.fct-theme-compatible-receipt .page-title,
        body.fct-theme-compatible-receipt .wp-site-blocks > header,
        body.fct-theme-compatible-receipt .wp-site-blocks > footer {
            display: none !important;
        }

        body.fct-theme-compatible-receipt .wp-site-blocks > main,
        body.fct-theme-compatible-receipt .wp-site-blocks .entry-content {
            margin: 0 !important;
            padding: 0 !important;
        }

        .fct-receipt-shell {
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

        .fct-receipt-main {
            flex: 1 1 auto;
            padding-block: clamp(24px, 4vw, 56px);
        }

        .fct-receipt-main__inner {
            display: flex;
            flex-direction: column;
            gap: clamp(28px, 5vw, 48px);
        }

        .fct-receipt-intro {
            max-width: 760px;
            display: grid;
            gap: 16px;
        }

        .fct-receipt-intro h1 {
            margin: 0;
            font-size: clamp(2rem, 2.4vw + 1.2rem, 2.75rem);
            font-weight: 600;
            color: var(--fct-theme-primary-text);
        }

        .fct-receipt-intro__status {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(22, 163, 74, 0.12);
            color: var(--fct-theme-positive);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .fct-receipt-intro__status svg {
            width: 18px;
            height: 18px;
        }

        .fct-receipt-intro p {
            margin: 0;
            font-size: 1rem;
            line-height: 1.65;
            color: var(--fct-theme-secondary-text);
        }

        .fct-receipt-meta {
            display: grid;
            gap: 16px;
        }

        @media (min-width: 640px) {
            .fct-receipt-meta {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }

        .fct-receipt-meta__card {
            background: rgba(255, 255, 255, 0.6);
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, 0.06);
            padding: 16px 18px;
            display: grid;
            gap: 6px;
        }

        .fct-receipt-meta__label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--fct-theme-secondary-text);
        }

        .fct-receipt-meta__value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--fct-theme-primary-text);
        }

        .fct-receipt-surface {
            background: transparent;
            border-radius: 18px;
            padding: clamp(24px, 4vw, 40px);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(15, 23, 42, 0.06);
            background-image: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(245, 247, 251, 0.6));
        }

        .fct-receipt-surface h2,
        .fct-receipt-surface h3,
        .fct-receipt-surface h4 {
            color: var(--fct-theme-primary-text);
        }

        .fct-receipt-surface p,
        .fct-receipt-surface td,
        .fct-receipt-surface th,
        .fct-receipt-surface li,
        .fct-receipt-surface span {
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
            color: var(--fct-theme-secondary-text) !important;
        }

        .fct-receipt-surface strong {
            color: var(--fct-theme-primary-text) !important;
        }

        .fct-receipt-surface a {
            color: var(--fct-theme-accent);
            text-decoration: none;
        }

        .fct-receipt-surface a:hover,
        .fct-receipt-surface a:focus {
            text-decoration: underline;
        }

        .fct-receipt-surface .fct-receipt-page,
        .fct-receipt-surface .fct-receipt-page-inner,
        .fct-receipt-surface .fc-email-template-content,
        .fct-receipt-surface .fc-email-template-content-inner {
            max-width: 100% !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .fct-receipt-surface .fct-receipt-page-inner {
            border-radius: 0 !important;
        }

        .fct-receipt-surface table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .fct-receipt-surface table td,
        .fct-receipt-surface table th {
            border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
            padding: 12px 0 !important;
            font-size: 0.95rem !important;
        }

        .fct-receipt-surface table tr:last-child td,
        .fct-receipt-surface table tr:last-child th {
            border-bottom: none !important;
        }

        .fct-receipt-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: clamp(24px, 4vw, 40px);
        }

        @media (min-width: 640px) {
            .fct-receipt-actions {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .fct-receipt-actions__links {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .fct-receipt-actions__link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 10px;
            border: 1px solid var(--fct-theme-border-color);
            background: #fff;
            color: var(--fct-theme-primary-text);
            font-weight: 600;
            font-size: 0.92rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .fct-receipt-actions__link svg {
            width: 18px;
            height: 18px;
            color: var(--fct-theme-accent);
        }

        .fct-receipt-actions__link:hover,
        .fct-receipt-actions__link:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.14);
            text-decoration: none;
        }

        .fct-receipt-actions__note {
            margin: 0;
            font-size: 0.88rem;
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
<body <?php body_class('fct-theme-compatible-receipt'); ?>>
<?php wp_body_open(); ?>
<div class="fct-checkout-shell fct-receipt-shell" data-fct-theme-receipt-shell>
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

    <main class="fct-checkout-main fct-receipt-main" role="main">
        <div class="fct-checkout-container">
            <div class="fct-receipt-main__inner">
                <section class="fct-receipt-intro" aria-labelledby="fct-receipt-title">
                    <span class="fct-receipt-intro__status">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m5 13 4 4L19 7" />
                        </svg>
                        <?php esc_html_e('Order confirmed', 'webmakerr'); ?>
                    </span>
                    <h1 id="fct-receipt-title" class="screen-reader-text"><?php echo esc_html($pageTitle ?: __('Order receipt', 'webmakerr')); ?></h1>
                    <?php if ($pageIntro) : ?>
                        <div class="fct-receipt-intro__content">
                            <?php echo $pageIntro; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php else : ?>
                        <p><?php esc_html_e('Thank you for your purchase. Your receipt and order details are below for your records.', 'webmakerr'); ?></p>
                    <?php endif; ?>
                    <div class="fct-receipt-meta" aria-label="<?php esc_attr_e('Order follow-up options', 'webmakerr'); ?>">
                        <div class="fct-receipt-meta__card">
                            <span class="fct-receipt-meta__label"><?php esc_html_e('Email confirmation', 'webmakerr'); ?></span>
                            <span class="fct-receipt-meta__value"><?php esc_html_e('Sent instantly after checkout', 'webmakerr'); ?></span>
                        </div>
                        <div class="fct-receipt-meta__card">
                            <span class="fct-receipt-meta__label"><?php esc_html_e('Account access', 'webmakerr'); ?></span>
                            <span class="fct-receipt-meta__value"><?php esc_html_e('Manage orders from your dashboard anytime', 'webmakerr'); ?></span>
                        </div>
                        <div class="fct-receipt-meta__card">
                            <span class="fct-receipt-meta__label"><?php esc_html_e('Need assistance?', 'webmakerr'); ?></span>
                            <span class="fct-receipt-meta__value"><?php echo $supportEmail ? esc_html($supportEmail) : esc_html__('Our support team is ready to help', 'webmakerr'); ?></span>
                        </div>
                    </div>
                </section>

                <section class="fct-checkout-surface fct-receipt-surface" aria-label="<?php esc_attr_e('Receipt details', 'webmakerr'); ?>">
                    <?php echo do_shortcode('[webmakerr_receipt type="receipt"]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </section>

                <section class="fct-receipt-actions" aria-label="<?php esc_attr_e('Order actions', 'webmakerr'); ?>">
                    <div class="fct-receipt-actions__links">
                        <a class="fct-receipt-actions__link" href="javascript:window.print();">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 9V4h12v5" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 18v4H8v-4M8 14h8" />
                            </svg>
                            <?php esc_html_e('Print receipt', 'webmakerr'); ?>
                        </a>
                        <a class="fct-receipt-actions__link" href="<?php echo esc_url(home_url('/')); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9.75 12 4l9 5.75V20a1 1 0 0 1-1 1h-5.25v-5.25h-5.5V21H4a1 1 0 0 1-1-1V9.75Z" />
                            </svg>
                            <?php esc_html_e('Return to homepage', 'webmakerr'); ?>
                        </a>
                    </div>
                    <p class="fct-receipt-actions__note">
                        <?php esc_html_e('You can revisit this page anytime using the secure link in your confirmation email.', 'webmakerr'); ?>
                    </p>
                </section>
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
