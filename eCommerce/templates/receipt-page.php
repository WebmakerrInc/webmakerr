<?php
/**
 * Template for rendering the FluentCart receipt page without theme wrappers.
 */

defined('ABSPATH') || exit();

ob_start();
while (have_posts()) {
    the_post();
    the_content();
}
$rawReceiptMarkup = trim(ob_get_clean());

$bodyMarkup = $rawReceiptMarkup;
$afterBodyMarkup = '';

if ($rawReceiptMarkup && preg_match('/<body[^>]*>(.*?)<\/body>/is', $rawReceiptMarkup, $bodyMatches)) {
    $bodyMarkup = trim($bodyMatches[1]);
    if (preg_match('/<\/body>(.*?)<\/html>/is', $rawReceiptMarkup, $afterBodyMatches)) {
        $afterBodyMarkup = trim($afterBodyMatches[1]);
    }
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <style>
        :root {
            --fc-receipt-shell-bg: radial-gradient(circle at top, rgba(59, 130, 246, 0.18), transparent 65%), #f8fafc;
            --fc-receipt-max-width: 960px;
            --fc-receipt-content-bg: #ffffff;
            --fc-receipt-border: rgba(15, 23, 42, 0.08);
            --fc-receipt-text: #1f2937;
            --fc-receipt-muted: #6b7280;
            --fc-receipt-radius: 5px;
        }

        body.fluent-cart-receipt-page {
            margin: 0;
            background: var(--fc-receipt-shell-bg);
            min-height: 100vh;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--fc-receipt-text);
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .fluent-cart-receipt-shell {
            width: 100%;
            max-width: var(--fc-receipt-max-width);
            padding: 32px 16px 48px;
            box-sizing: border-box;
        }

        .fluent-cart-receipt-card {
            position: relative;
            border-radius: var(--fc-receipt-radius);
            background: var(--fc-receipt-content-bg);
            border: 1px solid var(--fc-receipt-border);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .fluent-cart-receipt-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(59, 130, 246, 0.08), transparent 45%);
            pointer-events: none;
        }

        .fluent-cart-receipt-content {
            position: relative;
            z-index: 1;
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .fluent-cart-receipt-content > * {
            margin: 0;
        }

        .fluent-cart-receipt-content .fluent_cart_order_confirmation,
        .fluent-cart-receipt-content .fluent_cart_pdf_content {
            width: 100% !important;
        }

        .fluent-cart-receipt-content .fluent_cart_pdf_content {
            padding: 0 !important;
            box-sizing: border-box;
        }

        .fluent-cart-receipt-content [style*="width: 100%; padding: 32px"],
        .fluent-cart-receipt-content [style*="padding: 32px; width: 100%"] {
            width: 100% !important;
            padding: 0 !important;
        }

        .fluent-cart-receipt-content h1,
        .fluent-cart-receipt-content h2,
        .fluent-cart-receipt-content h3,
        .fluent-cart-receipt-content h4,
        .fluent-cart-receipt-content h5,
        .fluent-cart-receipt-content h6 {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.75em;
        }

        .fluent-cart-receipt-content p,
        .fluent-cart-receipt-content li,
        .fluent-cart-receipt-content span {
            color: var(--fc-receipt-muted);
            line-height: 1.7;
        }

        .fluent-cart-receipt-content table {
            width: 100% !important;
            border-collapse: collapse !important;
            border-radius: var(--fc-receipt-radius);
            overflow: hidden;
            background: #ffffff;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.25);
        }

        .fluent-cart-receipt-content th,
        .fluent-cart-receipt-content td {
            padding: 14px 18px !important;
            text-align: left !important;
            border-bottom: 1px solid rgba(148, 163, 184, 0.35) !important;
            color: var(--fc-receipt-text);
        }

        .fluent-cart-receipt-content thead th {
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            background: rgba(59, 130, 246, 0.06) !important;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #0f172a !important;
        }

        .fluent-cart-receipt-content tbody tr:last-child td {
            border-bottom: none !important;
        }

        .fluent-cart-receipt-content a {
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 500;
        }

        .fluent-cart-receipt-content a:hover,
        .fluent-cart-receipt-content a:focus {
            color: #1e40af;
        }

        .fluent-cart-receipt-content .fc-button,
        .fluent-cart-receipt-content button,
        .fluent-cart-receipt-content .button,
        .fluent-cart-receipt-content input[type="submit"],
        .fluent-cart-receipt-content input[type="button"],
        .fluent-cart-receipt-content a.button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            border-radius: var(--fc-receipt-radius) !important;
            background: #111827;
            color: #ffffff !important;
            border: none;
            padding: 10px 18px !important;
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
        }

        .fluent-cart-receipt-content .fc-button:hover,
        .fluent-cart-receipt-content button:hover,
        .fluent-cart-receipt-content .button:hover,
        .fluent-cart-receipt-content input[type="submit"]:hover,
        .fluent-cart-receipt-content input[type="button"]:hover,
        .fluent-cart-receipt-content a.button:hover {
            background: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.18);
        }

        .fluent-cart-receipt-content .fc-muted,
        .fluent-cart-receipt-content small {
            color: var(--fc-receipt-muted);
        }

        @media (min-width: 640px) {
            .fluent-cart-receipt-shell {
                padding: 48px 24px 72px;
            }

            .fluent-cart-receipt-content {
                padding: 48px 40px;
            }
        }

        @media (min-width: 1024px) {
            body.fluent-cart-receipt-page {
                align-items: center;
            }

            .fluent-cart-receipt-shell {
                padding: 64px 32px 96px;
            }

            .fluent-cart-receipt-content {
                padding: 56px 48px;
            }
        }
    </style>
</head>
<body <?php body_class('fluent-cart-receipt-page'); ?>>
<?php wp_body_open(); ?>
<div class="fluent-cart-receipt-shell">
    <div class="fluent-cart-receipt-card">
        <div class="fluent-cart-receipt-content">
            <?php echo $bodyMarkup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
    </div>
</div>
<?php echo $afterBodyMarkup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php wp_footer(); ?>
</body>
</html>
