<?php
/**
 * Theme footer template.
 *
 * @package Webmakerr
 */

?>
        </main>

        <?php do_action('webmakerr_content_end'); ?>
    </div>

    <?php do_action('webmakerr_content_after'); ?>

    <footer
        id="colophon"
        class="mt-16 border-t border-neutral-200 bg-neutral-50 text-neutral-900"
        role="contentinfo"
    >
        <div class="mx-auto w-full max-w-6xl px-6 py-12 lg:px-8 lg:py-16">
            <?php do_action('webmakerr_footer'); ?>

            <div class="mb-12 hidden gap-8 border-b border-neutral-200 pb-8 text-center text-sm text-neutral-600 md:grid md:grid-cols-4 md:text-left">
                <div class="flex flex-col items-center gap-2 md:items-start">
                    <div class="flex items-center gap-2 text-neutral-900">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-6 w-6"
                            aria-hidden="true"
                        >
                            <path d="M2.25 7.5A1.5 1.5 0 013.75 6h8.5a1.5 1.5 0 011.5 1.5V16h-6" />
                            <path d="M13.75 9.5h4.05a1.5 1.5 0 011.2.6l2.5 3.4a1.5 1.5 0 01.3.9V16a1.5 1.5 0 01-1.5 1.5H18" />
                            <circle cx="7.25" cy="17.25" r="1.75" />
                            <circle cx="17" cy="17.25" r="1.75" />
                        </svg>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-neutral-900"><?php esc_html_e('Free delivery', 'webmakerr'); ?></span>
                    </div>
                    <p class="text-xs font-medium text-neutral-500"><?php esc_html_e('On all orders', 'webmakerr'); ?></p>
                </div>
                <div class="flex flex-col items-center gap-2 md:items-start">
                    <div class="flex items-center gap-2 text-neutral-900">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-6 w-6"
                            aria-hidden="true"
                        >
                            <path d="M16.25 8h4.5V3.5" />
                            <path d="M2.25 12a9.75 9.75 0 0115.02-7.6L21 7.75" />
                            <path d="M7.75 16H3.25V20.5" />
                            <path d="M21.75 12a9.75 9.75 0 01-15.02 7.6L3 16.25" />
                        </svg>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-neutral-900"><?php esc_html_e('Free returns', 'webmakerr'); ?></span>
                    </div>
                    <p class="text-xs font-medium text-neutral-500"><?php esc_html_e('No questions asked return policy', 'webmakerr'); ?></p>
                </div>
                <div class="flex flex-col items-center gap-2 md:items-start">
                    <div class="flex items-center gap-2 text-neutral-900">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-6 w-6"
                            aria-hidden="true"
                        >
                            <path d="M2.25 6.75v-2.5A1.5 1.5 0 013.75 2.75h2.5a1.5 1.5 0 011.47 1.21l.9 4.5a1.5 1.5 0 01-.86 1.64l-1.05.45a11.25 11.25 0 006.06 6.06l.45-1.05a1.5 1.5 0 011.64-.86l4.5.9a1.5 1.5 0 011.21 1.47v2.5a1.5 1.5 0 01-1.5 1.5H17.25c-8.28 0-15-6.72-15-15z" />
                        </svg>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-neutral-900"><?php esc_html_e('Need help? +123 456 7890', 'webmakerr'); ?></span>
                    </div>
                    <p class="text-xs font-medium text-neutral-500"><?php esc_html_e('Call us on a toll-free phone number', 'webmakerr'); ?></p>
                </div>
                <div class="flex flex-col items-center gap-2 md:items-start">
                    <div class="flex items-center gap-2 text-neutral-900">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-6 w-6"
                            aria-hidden="true"
                        >
                            <path d="M4.5 6.75v4.05c0 5.17 3.3 9.6 7.88 10.9 4.58-1.3 7.87-5.73 7.87-10.9V6.75a1.5 1.5 0 00-.96-1.4l-6.3-2.52a1.5 1.5 0 00-1.12 0l-6.3 2.52a1.5 1.5 0 00-.97 1.4z" />
                            <path d="M9 12l2.25 2.25L15.75 9.5" />
                        </svg>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-neutral-900"><?php esc_html_e('Money back guarantee', 'webmakerr'); ?></span>
                    </div>
                    <p class="text-xs font-medium text-neutral-500"><?php esc_html_e('Worry-free shopping', 'webmakerr'); ?></p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-10 md:grid-cols-4">
                <div class="hidden text-sm text-neutral-600 md:block">
                    <h3 class="text-base font-semibold uppercase tracking-[0.18em] text-neutral-900"><?php esc_html_e('Contact', 'webmakerr'); ?></h3>
                    <ul class="mt-4 space-y-2 leading-relaxed">
                        <li><span class="font-medium text-neutral-900"><?php esc_html_e('Phone:', 'webmakerr'); ?></span> <span class="text-neutral-600">(888) 888 88 88</span></li>
                        <li>
                            <span class="font-medium text-neutral-900"><?php esc_html_e('Email:', 'webmakerr'); ?></span>
                            <a class="ml-1 inline-flex items-center text-primary transition hover:text-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline" href="mailto:support@webmakerr.com">support@webmakerr.com</a>
                        </li>
                        <li class="text-neutral-600"><?php esc_html_e('101 California Street, Suite 2710, San Francisco, CA 94111', 'webmakerr'); ?></li>
                    </ul>
                </div>

                <div>
                    <button
                        type="button"
                        class="footer-toggle flex w-full items-center justify-between border-b border-neutral-200 pb-3 text-left text-base font-semibold uppercase tracking-[0.18em] text-neutral-900 transition md:cursor-default md:border-none md:pb-0"
                        data-footer-toggle
                        aria-expanded="false"
                        aria-controls="footer-company"
                    >
                        <span><?php esc_html_e('Company info', 'webmakerr'); ?></span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-200 md:hidden"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            data-footer-toggle-icon
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul
                        id="footer-company"
                        class="hidden flex flex-col gap-2 pt-4 text-sm text-neutral-600 md:pt-5 md:text-base md:text-neutral-600 md:flex"
                        data-footer-panel
                    >
                        <li><a href="/about" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('About us', 'webmakerr'); ?></a></li>
                        <li><a href="/contact" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Contact us', 'webmakerr'); ?></a></li>
                        <li><a href="/blog" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Blog', 'webmakerr'); ?></a></li>
                        <li><a href="/privacy-policy" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Privacy policy', 'webmakerr'); ?></a></li>
                        <li><a href="/terms" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Terms &amp; conditions', 'webmakerr'); ?></a></li>
                    </ul>
                </div>

                <div>
                    <button
                        type="button"
                        class="footer-toggle flex w-full items-center justify-between border-b border-neutral-200 pb-3 text-left text-base font-semibold uppercase tracking-[0.18em] text-neutral-900 transition md:cursor-default md:border-none md:pb-0"
                        data-footer-toggle
                        aria-expanded="false"
                        aria-controls="footer-purchase"
                    >
                        <span><?php esc_html_e('Purchase info', 'webmakerr'); ?></span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-200 md:hidden"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            data-footer-toggle-icon
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul
                        id="footer-purchase"
                        class="hidden flex flex-col gap-2 pt-4 text-sm text-neutral-600 md:pt-5 md:text-base md:text-neutral-600 md:flex"
                        data-footer-panel
                    >
                        <li><a href="/faq" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Frequently asked questions', 'webmakerr'); ?></a></li>
                        <li><a href="/payment-methods" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Payment methods', 'webmakerr'); ?></a></li>
                        <li><a href="/shipping" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Shipping &amp; delivery', 'webmakerr'); ?></a></li>
                        <li><a href="/refunds" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Refunds &amp; returns policy', 'webmakerr'); ?></a></li>
                        <li><a href="/tracking" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Tracking', 'webmakerr'); ?></a></li>
                    </ul>
                </div>

                <div>
                    <button
                        type="button"
                        class="footer-toggle flex w-full items-center justify-between border-b border-neutral-200 pb-3 text-left text-base font-semibold uppercase tracking-[0.18em] text-neutral-900 transition md:cursor-default md:border-none md:pb-0"
                        data-footer-toggle
                        aria-expanded="false"
                        aria-controls="footer-follow"
                    >
                        <span><?php esc_html_e('Follow us', 'webmakerr'); ?></span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-200 md:hidden"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            data-footer-toggle-icon
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul
                        id="footer-follow"
                        class="hidden flex flex-col gap-2 pt-4 text-sm text-neutral-600 md:pt-5 md:text-base md:text-neutral-600 md:flex"
                        data-footer-panel
                    >
                        <li><a href="#" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Facebook', 'webmakerr'); ?></a></li>
                        <li><a href="#" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Instagram', 'webmakerr'); ?></a></li>
                        <li><a href="#" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Twitter', 'webmakerr'); ?></a></li>
                        <li><a href="#" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('Pinterest', 'webmakerr'); ?></a></li>
                        <li><a href="#" class="transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline"><?php esc_html_e('YouTube', 'webmakerr'); ?></a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 flex flex-col gap-6 border-t border-neutral-200 pt-6 text-xs text-neutral-500 md:flex-row md:items-center md:justify-between md:text-sm">
                <div class="flex flex-col items-center gap-2 text-center md:flex-row md:gap-3 md:text-left">
                    <span class="font-semibold uppercase tracking-[0.18em] text-neutral-900"><?php esc_html_e('Payment methods:', 'webmakerr'); ?></span>
                    <div class="flex items-center gap-3 text-neutral-900">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 64 24"
                            class="h-6 w-auto fill-current md:h-7"
                            aria-hidden="true"
                        >
                            <path d="M12.6 5h12.2c3.7 0 6.3 2.4 6.3 5.7 0 3.6-2.8 6-6.7 6h-4.5l-.9 5.3h-6.3L12.6 5z" />
                            <path d="M29 5.6h8.6c3.3 0 5.6 2.1 5.6 5.1 0 3.1-2.4 5.8-5.9 5.8h-4.3l-.9 5.1h-5.8l2.3-12.8A2.1 2.1 0 0129 5.6z" opacity=".65" />
                        </svg>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 64 24"
                            class="h-6 w-auto fill-current md:h-7"
                            aria-hidden="true"
                        >
                            <path d="M6.5 5l3.6 14h4.2l4.6-14h-4.1l-2.8 9.6L9 5H6.5z" />
                            <path d="M24.5 5h3.5l-1.4 14h-3.5L24.5 5z" />
                            <path d="M33.7 6.7c1.2-.7 2.6-1 4-1 1.6 0 2.9.3 3.9 1 .8.6 1.3 1.4 1.3 2.4 0 1.7-1.2 2.8-3.6 3.3-1.3.3-1.9.5-2.2.7-.3.2-.4.4-.4.7 0 .5.6.9 1.7.9 1.1 0 2.2-.2 3.4-.7l.9 2.7a11 11 0 01-4.6.8c-3.6 0-5.5-1.4-5.5-3.7 0-1.6 1-2.7 3.2-3.3 1.1-.3 1.8-.5 2-.6.3-.2.4-.4.4-.6 0-.6-.6-.9-1.6-.9a7.8 7.8 0 00-3.3.7l-.7-2.4z" />
                            <path d="M46.8 5h3.6l5 14h-3.9l-.7-2h-5.5l-.7 2h-3.7L46.8 5zm2.2 8.1L48 8.3l-1.3 4h2.3z" />
                        </svg>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 64 24"
                            class="h-6 w-auto fill-current md:h-7"
                            aria-hidden="true"
                        >
                            <circle cx="20" cy="12" r="7" opacity=".75" />
                            <circle cx="28" cy="12" r="7" opacity=".4" />
                            <path d="M24 5a7 7 0 010 14 7 7 0 010-14z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-2 text-center md:flex-row md:gap-3 md:text-left">
                    <span class="font-semibold uppercase tracking-[0.18em] text-neutral-900"><?php esc_html_e('Buy with confidence:', 'webmakerr'); ?></span>
                    <div class="flex items-center gap-3 text-neutral-900">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 64 24"
                            class="h-6 w-auto md:h-7"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M11 20.25h42" />
                            <path d="M14 18V10h36v8" />
                            <path d="M11 10l22-8 22 8H11z" />
                            <path d="M25 12v6" />
                            <path d="M41 12v6" />
                        </svg>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 64 24"
                            class="h-6 w-auto fill-current md:h-7"
                            aria-hidden="true"
                        >
                            <path d="M17 9.4c1.3-.8 3-1.3 4.9-1.3 3.2 0 5.2 1.6 5.2 4.1v8.3h-3.6v-1.6c-.7 1.1-1.8 1.8-3.3 1.8-2.4 0-4-1.4-4-3.5 0-2.6 2.1-3.8 5.8-3.8h1.5V13c0-.9-.6-1.4-1.8-1.4-1 0-2.2.3-3.2.9L17 9.4z" />
                            <path d="M32.7 8.5h3.7V21h-3.7z" />
                            <path d="M39.6 10.7h3.6V21h-3.6z" />
                            <path d="M39.6 8.5h3.6v1.8h-3.6z" />
                            <path d="M46.8 10.7h3.6V21h-3.6z" />
                            <path d="M55.8 10.1c1.4 0 2.6.4 3.5 1V8.3a8 8 0 00-3.1-.6c-3.2 0-5.3 1.6-5.3 4.4v8.9h3.6v-7.4c0-1.6 1-2.8 2.3-2.8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mt-8 space-y-2 text-center text-xs text-neutral-500 md:text-sm">
                <p>
                    &copy; <?php echo esc_html(date_i18n('Y')); ?>
                    <span class="font-medium text-neutral-900"><?php echo esc_html(get_bloginfo('name')); ?></span>.
                    <?php esc_html_e('All rights reserved.', 'webmakerr'); ?>
                </p>
                <p class="text-neutral-500">www.webmakerr.com</p>
            </div>
        </div>
    </footer>

    <div aria-hidden="true" class="md:hidden h-[110px]"></div>
</div>

<?php
$mobile_cta_url        = apply_filters('webmakerr_mobile_cta_url', home_url('/get-started'));
$mobile_cta_attributes = '';
$footer_button_text    = __('Get Started, It’s Free', 'webmakerr');

$current_template = get_page_template_slug();
if ($current_template) {
    $form_config_path = get_template_directory() . '/templates/config/popup-content.php';
    if (is_readable($form_config_path)) {
        $forms             = include $form_config_path;
        $template_basename = basename($current_template);

        if (isset($forms[$template_basename]) && is_array($forms[$template_basename]) && isset($forms[$template_basename]['form_id']) && absint($forms[$template_basename]['form_id']) > 0) {
            $mobile_cta_url        = '#ff-popup';
            $mobile_cta_attributes = ' data-popup-trigger aria-controls="ff-popup"';
        }
    }
}

if (is_page_template('templates/page-thankslead.php')) {
    $mobile_cta_url        = home_url('/book-free-call');
    $mobile_cta_attributes = '';
    $footer_button_text    = __('Book Free Call', 'webmakerr');
}
?>

<div
    class="fixed bottom-0 left-0 right-0 z-50 bg-dark text-white shadow-[0_-12px_24px_rgba(0,0,0,0.18)] md:hidden"
    role="complementary"
    aria-label="<?php esc_attr_e('Get started call to action', 'webmakerr'); ?>"
>
    <div
        class="mx-auto flex w-full max-w-6xl flex-col gap-2 px-6 py-4"
        style="padding-bottom: calc(1rem + env(safe-area-inset-bottom));"
    >
        <a
            class="inline-flex w-full items-center justify-center rounded bg-primary px-6 py-3 text-base font-semibold text-white transition hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white !no-underline animate-mobile-cta-glow md:animate-none"
            href="<?php echo esc_url($mobile_cta_url); ?>"<?php echo $mobile_cta_attributes; ?>
        >
            <?php echo esc_html($footer_button_text); ?>
        </a>
        <p class="w-full text-center text-sm font-medium text-white/70">
            <?php esc_html_e('No credit card required · Instant setup', 'webmakerr'); ?>
        </p>
    </div>
</div>

<!-- ================= Cookie Banner + Modal ================= -->
<div
    id="cookie-banner"
    class="fixed bottom-[calc(7rem+env(safe-area-inset-bottom))] left-0 right-0 z-[60] hidden border-t border-neutral-200 bg-neutral-50 shadow-lg shadow-black/5 md:bottom-0"
>
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-4 px-6 py-4 text-sm text-neutral-700 md:flex-row md:items-center md:justify-between">
        <div class="flex-1 text-center leading-relaxed md:text-left">
            <p>
                <?php esc_html_e('We use cookies to improve your browsing experience, analyze traffic, and serve personalized content.', 'webmakerr'); ?>
                <?php esc_html_e('By clicking “Accept,” you consent to our use of cookies.', 'webmakerr'); ?>
                <?php esc_html_e('Read more in our', 'webmakerr'); ?>
                <a href="/privacy-policy" class="text-primary underline-offset-2 transition hover:text-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"><?php esc_html_e('Privacy Policy', 'webmakerr'); ?></a>.
            </p>
        </div>
        <div class="flex flex-col justify-center gap-3 md:flex-row md:justify-end">
            <button
                id="moreCookies"
                class="rounded border border-neutral-300 px-5 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
                type="button"
            >
                <?php esc_html_e('More', 'webmakerr'); ?>
            </button>
            <button
                id="declineCookies"
                class="rounded border border-neutral-300 px-5 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
                type="button"
            >
                <?php esc_html_e('Decline', 'webmakerr'); ?>
            </button>
            <button
                id="acceptCookies"
                class="rounded bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
                type="button"
            >
                <?php esc_html_e('Accept', 'webmakerr'); ?>
            </button>
        </div>
    </div>
</div>

<!-- Cookie Modal -->
<div id="cookie-modal" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-neutral-950/60 px-4">
    <div class="relative w-full max-w-xl rounded border border-neutral-200 bg-neutral-50 p-6 shadow-xl">
        <button
            id="closeModal"
            class="absolute right-4 top-4 text-lg text-neutral-500 transition hover:text-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
            type="button"
        >
            &times;
        </button>
        <h2 class="text-lg font-semibold text-neutral-900"><?php esc_html_e('Cookie preferences', 'webmakerr'); ?></h2>
        <p class="mt-3 text-sm text-neutral-600 leading-relaxed">
            <?php esc_html_e('Cookies help us enhance your experience and improve our website’s performance. Below is a quick overview of the cookie categories we use:', 'webmakerr'); ?>
        </p>
        <ul class="mt-4 space-y-3 text-sm text-neutral-600">
            <li>
                <strong class="text-neutral-900"><?php esc_html_e('Necessary cookies:', 'webmakerr'); ?></strong>
                <?php esc_html_e('Enable core functionality such as security, network management, and accessibility.', 'webmakerr'); ?>
            </li>
            <li>
                <strong class="text-neutral-900"><?php esc_html_e('Analytics cookies:', 'webmakerr'); ?></strong>
                <?php esc_html_e('Help us understand how visitors interact with our website, allowing us to improve content and usability.', 'webmakerr'); ?>
            </li>
            <li>
                <strong class="text-neutral-900"><?php esc_html_e('Marketing cookies:', 'webmakerr'); ?></strong>
                <?php esc_html_e('Used to deliver relevant ads and measure the effectiveness of our campaigns.', 'webmakerr'); ?>
            </li>
            <li>
                <strong class="text-neutral-900"><?php esc_html_e('Functional cookies:', 'webmakerr'); ?></strong>
                <?php esc_html_e('Remember your preferences and settings for a personalized experience.', 'webmakerr'); ?>
            </li>
        </ul>
        <div class="mt-6 flex flex-col justify-end gap-3 md:flex-row">
            <button
                id="modalDecline"
                class="rounded border border-neutral-300 px-5 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
                type="button"
            >
                <?php esc_html_e('Decline all', 'webmakerr'); ?>
            </button>
            <button
                id="modalAccept"
                class="rounded bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
                type="button"
            >
                <?php esc_html_e('Accept all', 'webmakerr'); ?>
            </button>
        </div>
    </div>
</div>

<!-- Promotional Popup -->
<div
    id="promo-popup"
    class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-neutral-950/70 px-4 opacity-0 transition-opacity duration-300 ease-out"
    role="dialog"
    aria-modal="true"
    aria-hidden="true"
>
    <div
        id="promoContent"
        class="relative w-full max-w-2xl transform overflow-hidden rounded border border-neutral-200 bg-neutral-50 shadow-[0_40px_80px_-40px_rgba(24,24,27,0.35)] translate-y-4 scale-95 opacity-0 transition-all duration-300 ease-out"
    >
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-dark/5"></div>
        <button
            id="closePromo"
            data-promo-close
            class="absolute right-5 top-5 flex h-10 w-10 items-center justify-center rounded border border-neutral-200 bg-white/80 text-lg text-neutral-500 transition hover:scale-105 hover:text-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
            type="button"
            aria-label="<?php esc_attr_e('Close promotion popup', 'webmakerr'); ?>"
        >
            &times;
        </button>

        <div class="relative grid gap-8 p-6 md:grid-cols-[1.15fr,0.85fr] md:p-10">
            <div class="flex flex-col justify-center">
                <span class="inline-flex w-fit items-center gap-2 rounded bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
                    <?php esc_html_e('Webmakerr Exclusive', 'webmakerr'); ?>
                </span>
                <h2 class="mt-4 text-2xl font-semibold text-neutral-900 md:text-3xl">
                    <?php esc_html_e('Unlock 20% off your first order today', 'webmakerr'); ?>
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-neutral-600 md:text-base">
                    <?php esc_html_e('Join the Webmakerr insider list for curated trends, early product drops, and members-only rewards crafted to elevate your everyday moments.', 'webmakerr'); ?>
                </p>
                <ul class="mt-5 space-y-3 text-sm text-neutral-700 md:text-base">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 flex h-6 w-6 items-center justify-center rounded bg-primary/10 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-7.25 7.25a1 1 0 0 1-1.414 0l-3-3a1 1 0 1 1 1.414-1.414L8.5 11.586l6.543-6.543a1 1 0 0 1 1.414 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span><?php esc_html_e('Instant 20% welcome voucher on your first purchase.', 'webmakerr'); ?></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 flex h-6 w-6 items-center justify-center rounded bg-primary/10 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-7.25 7.25a1 1 0 0 1-1.414 0l-3-3a1 1 0 1 1 1.414-1.414L8.5 11.586l6.543-6.543a1 1 0 0 1 1.414 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span><?php esc_html_e('VIP previews of drops, restocks, and seasonal collections.', 'webmakerr'); ?></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 flex h-6 w-6 items-center justify-center rounded bg-primary/10 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-7.25 7.25a1 1 0 0 1-1.414 0l-3-3a1 1 0 1 1 1.414-1.414L8.5 11.586l6.543-6.543a1 1 0 0 1 1.414 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span><?php esc_html_e('Priority access to tailored offers that match your lifestyle.', 'webmakerr'); ?></span>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col justify-center rounded border border-neutral-200 bg-white/90 p-6 shadow-inner">
                <form id="promoForm" class="flex flex-col gap-4">
                    <label class="text-sm font-medium text-neutral-900" for="promoEmail"><?php esc_html_e('Email address', 'webmakerr'); ?></label>
                    <input
                        id="promoEmail"
                        type="email"
                        required
                        placeholder="<?php esc_attr_e('you@example.com', 'webmakerr'); ?>"
                        class="w-full rounded border border-neutral-300 px-4 py-3 text-sm text-neutral-900 transition focus:border-dark focus:outline-none focus:ring-2 focus:ring-dark/20"
                    />
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded bg-dark px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
                    >
                        <?php esc_html_e('Claim my 20% off', 'webmakerr'); ?>
                    </button>
                </form>
                <button
                    id="promoDismiss"
                    type="button"
                    class="mt-4 text-center text-sm font-medium text-neutral-500 underline-offset-2 transition hover:text-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"
                >
                    <?php esc_html_e('No thanks, maybe later', 'webmakerr'); ?>
                </button>
                <p class="mt-5 text-center text-xs leading-relaxed text-neutral-500">
                    <?php esc_html_e('We respect your privacy and only send thoughtfully curated updates. Unsubscribe with one click at any time.', 'webmakerr'); ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ================= Scripts ================= -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const footerToggles = document.querySelectorAll('[data-footer-toggle]');

    if (footerToggles.length) {
        const updateFooterToggles = () => {
            footerToggles.forEach((toggle) => {
                const panel = toggle.nextElementSibling;
                if (!panel) {
                    return;
                }

                if (!panel.dataset.mobileOpen) {
                    panel.dataset.mobileOpen = (!panel.classList.contains('hidden')).toString();
                }

                const icon = toggle.querySelector('[data-footer-toggle-icon]');

                if (window.innerWidth >= 768) {
                    panel.classList.remove('hidden');
                    toggle.setAttribute('aria-expanded', 'true');
                    if (icon) {
                        icon.classList.remove('rotate-180');
                    }
                } else {
                    const isOpen = panel.dataset.mobileOpen === 'true';
                    panel.classList.toggle('hidden', !isOpen);
                    toggle.setAttribute('aria-expanded', isOpen.toString());
                    if (icon) {
                        icon.classList.toggle('rotate-180', isOpen);
                    }
                }
            });
        };

        footerToggles.forEach((toggle) => {
            toggle.addEventListener('click', () => {
                if (window.innerWidth >= 768) {
                    return;
                }

                const panel = toggle.nextElementSibling;
                if (!panel) {
                    return;
                }

                panel.classList.toggle('hidden');
                const isHidden = panel.classList.contains('hidden');
                const isOpen = !isHidden;
                panel.dataset.mobileOpen = isOpen.toString();
                toggle.setAttribute('aria-expanded', isOpen.toString());

                const icon = toggle.querySelector('[data-footer-toggle-icon]');
                if (icon) {
                    icon.classList.toggle('rotate-180', isOpen);
                }
            });
        });

        updateFooterToggles();
        window.addEventListener('resize', updateFooterToggles);
    }

    const storage = (() => {
        try {
            const key = '__webmakerr_storage_test__';
            window.localStorage.setItem(key, '1');
            window.localStorage.removeItem(key);
            return window.localStorage;
        } catch (error) {
            return null;
        }
    })();

    const sessionStore = (() => {
        try {
            const key = '__webmakerr_session_test__';
            window.sessionStorage.setItem(key, '1');
            window.sessionStorage.removeItem(key);
            return window.sessionStorage;
        } catch (error) {
            return null;
        }
    })();

    const banner = document.getElementById('cookie-banner');
    const modal = document.getElementById('cookie-modal');

    const handleConsent = (value) => {
        if (storage) {
            storage.setItem('cookieConsent', value);
        }
        if (banner) {
            banner.classList.add('hidden');
        }
        if (modal) {
            modal.classList.add('hidden');
        }
    };

    if (banner) {
        const acceptBtn = document.getElementById('acceptCookies');
        const declineBtn = document.getElementById('declineCookies');
        const moreBtn = document.getElementById('moreCookies');
        const closeModalBtn = document.getElementById('closeModal');
        const modalAccept = document.getElementById('modalAccept');
        const modalDecline = document.getElementById('modalDecline');

        const consent = storage ? storage.getItem('cookieConsent') : null;
        if (!consent) {
            banner.classList.remove('hidden');
        }

        if (acceptBtn) {
            acceptBtn.addEventListener('click', () => handleConsent('accepted'));
        }
        if (declineBtn) {
            declineBtn.addEventListener('click', () => handleConsent('declined'));
        }
        if (modalAccept) {
            modalAccept.addEventListener('click', () => handleConsent('accepted'));
        }
        if (modalDecline) {
            modalDecline.addEventListener('click', () => handleConsent('declined'));
        }
        if (moreBtn && modal) {
            moreBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });
        }
        if (closeModalBtn && modal) {
            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        }
        if (modal) {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }
    }

    const promo = document.getElementById('promo-popup');
    if (promo) {
        const promoForm = document.getElementById('promoForm');
        const promoDismiss = document.getElementById('promoDismiss');
        const promoContent = document.getElementById('promoContent');
        const persistentKey = 'promoDismissed';
        const sessionKey = 'promoShownSession';

        let promoDismissed = storage ? storage.getItem(persistentKey) === 'true' : false;
        let promoShownThisSession = sessionStore ? sessionStore.getItem(sessionKey) === 'true' : false;
        let isPromoAnimating = false;

        const completePromoHide = (persist) => {
            promo.classList.add('hidden');
            promo.setAttribute('aria-hidden', 'true');
            promoShownThisSession = true;
            promoDismissed = promoDismissed || persist;

            if (persist && storage) {
                storage.setItem(persistentKey, 'true');
            }
            if (sessionStore) {
                sessionStore.setItem(sessionKey, 'true');
            }
            window.removeEventListener('scroll', handleScroll);
            isPromoAnimating = false;
        };

        const hidePromo = (persist = false) => {
            if (promo.classList.contains('hidden')) {
                if (persist) {
                    promoDismissed = true;
                    if (storage) {
                        storage.setItem(persistentKey, 'true');
                    }
                    if (sessionStore) {
                        sessionStore.setItem(sessionKey, 'true');
                    }
                }
                return;
            }

            if (isPromoAnimating) {
                return;
            }

            isPromoAnimating = true;

            const handleTransitionEnd = (event) => {
                if (event.target !== promo) {
                    return;
                }
                promo.removeEventListener('transitionend', handleTransitionEnd);
                completePromoHide(persist);
            };

            promo.addEventListener('transitionend', handleTransitionEnd);

            promo.classList.add('opacity-0');
            if (promoContent) {
                promoContent.classList.add('translate-y-4', 'scale-95', 'opacity-0');
            }

            window.setTimeout(() => {
                if (!isPromoAnimating) {
                    return;
                }
                promo.removeEventListener('transitionend', handleTransitionEnd);
                completePromoHide(persist);
            }, 350);
        };

        const showPromo = () => {
            if (promoDismissed || promoShownThisSession) {
                return;
            }

            promo.classList.remove('hidden');
            promo.setAttribute('aria-hidden', 'false');
            promoShownThisSession = true;
            if (sessionStore) {
                sessionStore.setItem(sessionKey, 'true');
            }

            promo.classList.add('opacity-0');
            if (promoContent) {
                promoContent.classList.add('translate-y-4', 'scale-95', 'opacity-0');
            }

            requestAnimationFrame(() => {
                promo.classList.remove('opacity-0');
                if (promoContent) {
                    promoContent.classList.remove('translate-y-4', 'scale-95', 'opacity-0');
                }
            });
        };

        const handleScroll = () => {
            if (promoDismissed || promoShownThisSession) {
                window.removeEventListener('scroll', handleScroll);
                return;
            }

            const scrollPosition = window.scrollY + window.innerHeight;
            const threshold = document.body.offsetHeight * 0.7;

            if (scrollPosition >= threshold) {
                showPromo();
                window.removeEventListener('scroll', handleScroll);
            }
        };

        if (!promoDismissed && !promoShownThisSession) {
            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();
        }

        if (promoDismiss) {
            promoDismiss.addEventListener('click', () => {
                hidePromo(true);
            });
        }

        promo.addEventListener('click', (event) => {
            if (event.target === promo) {
                hidePromo(true);
                return;
            }

            if (event.target.closest('[data-promo-close]')) {
                event.preventDefault();
                hidePromo(true);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !promo.classList.contains('hidden')) {
                hidePromo(true);
            }
        });

        if (promoForm) {
            promoForm.addEventListener('submit', (event) => {
                event.preventDefault();
                hidePromo(true);
            });
        }
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
