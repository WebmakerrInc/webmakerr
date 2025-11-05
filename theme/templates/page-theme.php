<?php
/**
 * Template Name: Theme Overview
 * Description: Highlights the core theme features with a hero section and flexible content area.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$popup_settings = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled  = (bool) ($popup_settings['enabled'] ?? false);

get_header();
?>

<main id="primary" class="flex flex-col bg-white">
  <?php while (have_posts()) : the_post(); ?>
    <?php
    if (! function_exists('webmakerr_theme_render_icon')) {
        /**
         * Render a themed icon consistent with WebCommerce template styling.
         */
        function webmakerr_theme_render_icon($name, $class = 'h-6 w-6')
        {
            $icons = array(
                'zap' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>',
                'activity' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>',
                'brain-circuit' => '<path d="M6 8a3 3 0 0 1 3-3"></path><path d="M9 5V3"></path><path d="M9 12V9"></path><path d="M15 5a3 3 0 0 1 3 3"></path><path d="M15 3v2"></path><path d="M15 12V9"></path><path d="M9 12H5a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2"></path><path d="M5 17v2"></path><path d="M15 12h4a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2"></path><path d="M19 17v2"></path>',
                'package' => '<path d="m21 16-9 5-9-5V8l9-5 9 5z"></path><path d="M3.3 7.3 12 12l8.7-4.7"></path><path d="M12 22V12"></path>',
                'cloud-download' => '<path d="M8 17l4 4 4-4"></path><path d="M12 12v9"></path><path d="M20 16.58A5 5 0 0 0 18 7h-1.26A8 8 0 1 0 4 15.25"></path>',
                'repeat' => '<path d="m17 2 4 4-4 4"></path><path d="m7 22-4-4 4-4"></path><path d="M21 6H12a3 3 0 0 0-3 3v1"></path><path d="M3 18h9a3 3 0 0 0 3-3v-1"></path>',
                'layers' => '<polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline>',
                'shopping-cart' => '<circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>',
                'server' => '<rect x="2" y="2" width="20" height="8" rx="2"></rect><rect x="2" y="14" width="20" height="8" rx="2"></rect><path d="M6 6h.01"></path><path d="M6 18h.01"></path>',
                'bar-chart' => '<path d="M3 3v18h18"></path><rect x="7" y="8" width="3" height="7" rx="1"></rect><rect x="12" y="5" width="3" height="10" rx="1"></rect><rect x="17" y="12" width="3" height="5" rx="1"></rect>',
                'key' => '<path d="M21 2l-2 2"></path><path d="M15 8l-2 2"></path><path d="M21 8l-9.8 9.8a4 4 0 1 1-5.7-5.7L15.3 4.3a2 2 0 1 1 2.8 2.8L8 17"></path>',
                'refresh' => '<path d="M3 2v6h6"></path><path d="M21 12A9 9 0 0 1 6 19.5L3 17"></path><path d="M21 22v-6h-6"></path><path d="M3 12a9 9 0 0 1 15-7.5L21 7"></path>',
                'api' => '<path d="M4 7h16"></path><path d="M4 17h16"></path><path d="M9 7v10"></path><path d="M15 7v10"></path>',
                'code' => '<polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline>',
                'plug' => '<path d="M6 7h12"></path><path d="M9 7V3"></path><path d="M15 7V3"></path><path d="M12 16v5"></path><path d="M7 11a5 5 0 0 0 10 0"></path>',
                'check' => '<path d="M20 6 9 17l-5-5"></path>',
                'quote' => '<path d="M5 19h5l1-4H8a4 4 0 0 1 4-4V5a8 8 0 0 0-8 8z"></path><path d="M15 19h5l1-4h-3a4 4 0 0 1 4-4V5a8 8 0 0 0-8 8z"></path>',
            );

            if (! isset($icons[$name])) {
                return '';
            }

            return sprintf(
                '<svg class="%1$s" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%2$s</svg>',
                esc_attr($class),
                $icons[$name]
            );
        }
    }

    $intro              = trim((string) get_post_meta(get_the_ID(), '_webmakerr_theme_intro', true));
    $intro_default      = __('Webmakerr is the 100% free Tailwind WordPress theme built to launch high-converting sites at top speed with effortless customization.', 'webmakerr');
    $primary_cta_url    = get_post_meta(get_the_ID(), '_webmakerr_theme_cta_primary_url', true) ?: home_url('/download');
    $primary_cta_text   = get_post_meta(get_the_ID(), '_webmakerr_theme_cta_primary_label', true) ?: __('Download Webmakerr Free', 'webmakerr');
    $secondary_cta_url  = get_post_meta(get_the_ID(), '_webmakerr_theme_cta_secondary_url', true) ?: home_url('/docs');
    $secondary_cta_text = get_post_meta(get_the_ID(), '_webmakerr_theme_cta_secondary_label', true) ?: __('Build with Webmakerr', 'webmakerr');

    $primary_cta_link   = webmakerr_get_popup_link_attributes($primary_cta_url, $popup_enabled);
    $secondary_cta_link = webmakerr_get_popup_link_attributes($secondary_cta_url, $popup_enabled);

    $feature_cards = array(
      array(
        'icon'        => 'layers',
        'title'       => __('Modern Tailwind foundation', 'webmakerr'),
        'description' => __('Responsive patterns, utility presets, and polished UI tokens create a premium experience from day one.', 'webmakerr'),
      ),
      array(
        'icon'        => 'activity',
        'title'       => __('Performance engineered', 'webmakerr'),
        'description' => __('Lightweight markup, Vite bundling, and Core Web Vitals optimizations keep every page loading instantly.', 'webmakerr'),
      ),
      array(
        'icon'        => 'zap',
        'title'       => __('Built for marketers', 'webmakerr'),
        'description' => __('Prebuilt funnels, campaign-ready layouts, and block-friendly copy zones convert visitors into customers.', 'webmakerr'),
      ),
      array(
        'icon'        => 'package',
        'title'       => __('Design tokens included', 'webmakerr'),
        'description' => __('Unified colors, spacing, and typography create on-brand pages without manual configuration.', 'webmakerr'),
      ),
      array(
        'icon'        => 'refresh',
        'title'       => __('SEO and accessibility ready', 'webmakerr'),
        'description' => __('Structured content, semantic markup, and WCAG-friendly defaults boost visibility and trust.', 'webmakerr'),
      ),
      array(
        'icon'        => 'code',
        'title'       => __('Developer-first workflow', 'webmakerr'),
        'description' => __('Tailwind, Vite, lint-ready configs, and readable PHP templates streamline custom builds.', 'webmakerr'),
      ),
    );

    $integration_groups = array(
      array(
        'icon'        => 'shopping-cart',
        'title'       => __('Growth-ready commerce', 'webmakerr'),
        'description' => __('Launch landing pages that connect to carts, checkout, and product feeds in minutes.', 'webmakerr'),
        'items'       => array('WooCommerce', 'Shopify Storefront API', 'Snipcart', 'Paddle'),
      ),
      array(
        'icon'        => 'bar-chart',
        'title'       => __('Marketing automation', 'webmakerr'),
        'description' => __('Embed analytics, CRM syncs, and personalization tools without bloated plugins.', 'webmakerr'),
        'items'       => array('Google Analytics', 'Segment', 'HubSpot', 'Mailchimp'),
      ),
      array(
        'icon'        => 'brain-circuit',
        'title'       => __('Content workflow', 'webmakerr'),
        'description' => __('Automate publishing, sync data sources, and keep marketing content fresh without hacks.', 'webmakerr'),
        'items'       => array('Notion', 'Airtable', 'Zapier', 'Make'),
      ),
    );

    $testimonial_quotes = array(
      array(
        'quote'  => __('“We replaced our legacy theme with a conversion-ready homepage in three days. The free Tailwind setup saved us weeks.”', 'webmakerr'),
        'author' => __('Sasha Morgan', 'webmakerr'),
        'role'   => __('Growth Lead, Launchpad', 'webmakerr'),
      ),
      array(
        'quote'  => __('“Organic traffic jumped after launch. Webmakerr’s SEO defaults and fast load times gave us immediate ranking gains.”', 'webmakerr'),
        'author' => __('Lena Ortiz', 'webmakerr'),
        'role'   => __('Marketing Director, BrightNorth', 'webmakerr'),
      ),
      array(
        'quote'  => __('“The codebase is clean and documented. We extend sections freely without breaking performance budgets.”', 'webmakerr'),
        'author' => __('Caleb Johnson', 'webmakerr'),
        'role'   => __('Engineering Manager, VelocityHQ', 'webmakerr'),
      ),
    );
    ?>

    <article <?php post_class('flex flex-col'); ?>>
      <section class="relative overflow-hidden border-b border-zinc-200 bg-gradient-to-b from-white via-white to-light">
        <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-primary/10 via-white/40 to-transparent blur-3xl"></div>
        <div class="relative z-10 mx-auto max-w-screen-xl px-6 pt-20 pb-24 sm:pb-28 lg:px-8 lg:pt-24 lg:pb-32">
          <div class="grid items-center gap-16 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="flex flex-col gap-6">
              <span class="inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
                <?php esc_html_e('Free Tailwind WordPress Theme', 'webmakerr'); ?>
              </span>
              <?php the_title('<h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl">', '</h1>'); ?>
              <p class="max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg">
                <?php echo esc_html($intro ?: $intro_default); ?>
              </p>
              <div class="mt-10 flex flex-col items-center gap-3 sm:flex-row sm:items-center sm:gap-4">
                <a class="inline-flex w-full justify-center rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url($primary_cta_link['href']); ?>"<?php echo $primary_cta_link['attributes']; ?>>
                  <?php echo esc_html($primary_cta_text); ?>
                </a>
                <a class="inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline sm:w-auto" href="<?php echo esc_url($secondary_cta_link['href']); ?>"<?php echo $secondary_cta_link['attributes']; ?>>
                  <?php echo esc_html($secondary_cta_text); ?>
                </a>
              </div>
              <p class="mt-3 text-xs font-medium text-zinc-500 sm:text-sm">
                <?php esc_html_e('★★★★★ 4.9/5 on WordPress.org — 12,000+ teams ship with Webmakerr', 'webmakerr'); ?>
              </p>
              <dl class="grid gap-6 pt-6 sm:grid-cols-3">
                <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-4 shadow-sm">
                  <dt class="text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Free forever', 'webmakerr'); ?></dt>
                  <dd class="mt-3 text-2xl font-semibold text-zinc-950 sm:text-3xl"><?php esc_html_e('100%', 'webmakerr'); ?></dd>
                </div>
                <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-4 shadow-sm">
                  <dt class="text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Faster build cycles', 'webmakerr'); ?></dt>
                  <dd class="mt-3 text-2xl font-semibold text-zinc-950 sm:text-3xl"><?php esc_html_e('2x', 'webmakerr'); ?></dd>
                </div>
                <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-4 shadow-sm">
                  <dt class="text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Ready-made sections', 'webmakerr'); ?></dt>
                  <dd class="mt-3 text-2xl font-semibold text-zinc-950 sm:text-3xl"><?php esc_html_e('40+', 'webmakerr'); ?></dd>
                </div>
              </dl>
            </div>

            <div class="relative isolate overflow-hidden rounded-[5px] border border-white/60 bg-white/80 p-8 shadow-xl shadow-primary/10 backdrop-blur">
              <div class="absolute -left-20 -top-16 h-48 w-48 rounded-full bg-primary/10 blur-3xl sm:-left-24 sm:-top-20 sm:h-64 sm:w-64"></div>
              <div class="relative flex flex-col gap-6">
                <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-6 shadow-sm">
                  <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Instant layout library', 'webmakerr'); ?></p>
                    <p class="mt-2 text-base font-medium text-zinc-950"><?php esc_html_e('Launch polished pages with copy, CTAs, and responsive defaults baked in.', 'webmakerr'); ?></p>
                  </div>
                  <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[5px] border border-zinc-200 bg-white p-4">
                      <p class="text-sm font-semibold text-zinc-950"><?php esc_html_e('Conversion heroes', 'webmakerr'); ?></p>
                      <p class="mt-2 text-xs text-zinc-600"><?php esc_html_e('Pair high-impact messaging with primary CTAs that drive signups.', 'webmakerr'); ?></p>
                    </div>
                    <div class="rounded-[5px] border border-zinc-200 bg-white p-4">
                      <p class="text-sm font-semibold text-zinc-950"><?php esc_html_e('Flexible feature grids', 'webmakerr'); ?></p>
                      <p class="mt-2 text-xs text-zinc-600"><?php esc_html_e('Showcase benefits with mobile-first cards that adapt to any story.', 'webmakerr'); ?></p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-4 rounded-[5px] border border-zinc-200 bg-white/90 px-6 py-6 shadow-sm">
                  <p class="text-sm font-semibold text-zinc-950"><?php esc_html_e('Built-in utilities', 'webmakerr'); ?></p>
                  <ul class="grid gap-3 text-xs text-zinc-600 sm:grid-cols-2">
                    <li class="flex items-center gap-3">
                      <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span>
                      <?php esc_html_e('Performance presets', 'webmakerr'); ?>
                    </li>
                    <li class="flex items-center gap-3">
                      <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span>
                      <?php esc_html_e('SEO-ready schema', 'webmakerr'); ?>
                    </li>
                    <li class="flex items-center gap-3">
                      <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span>
                      <?php esc_html_e('Reusable layout tokens', 'webmakerr'); ?>
                    </li>
                    <li class="flex items-center gap-3">
                      <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span>
                      <?php esc_html_e('Developer documentation', 'webmakerr'); ?>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="border-b border-zinc-200 bg-white py-16">
        <div class="mx-auto flex max-w-screen-xl flex-col items-center gap-8 px-6 text-center lg:px-8">
          <p class="text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Teams growing with Webmakerr', 'webmakerr'); ?></p>
          <div class="grid w-full max-w-4xl grid-cols-2 items-center justify-center gap-6 sm:grid-cols-3 lg:grid-cols-6">
            <?php
            $logos = array('Alpine', 'Cloudline', 'Nordic Labs', 'Studio Fable', 'Gradient', 'Summit Co.');
            foreach ($logos as $logo) :
              ?>
              <div class="flex items-center justify-center rounded-[5px] border border-dashed border-zinc-200 px-4 py-3 text-sm font-semibold uppercase tracking-[0.26em] text-zinc-400">
                <?php echo esc_html($logo); ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section id="features" class="bg-light py-24">
        <div class="mx-auto flex max-w-screen-xl flex-col gap-12 px-6 lg:px-8">
          <div class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl"><?php esc_html_e('Turn growth ideas into live pages fast', 'webmakerr'); ?></h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg"><?php esc_html_e('Webmakerr delivers a free, production-ready toolkit for SEO, performance, and on-brand storytelling—no heavy plugins required.', 'webmakerr'); ?></p>
          </div>

          <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($feature_cards as $feature) : ?>
              <div class="flex h-full flex-col gap-4 rounded-[5px] border border-zinc-200 bg-white p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webmakerr_theme_render_icon($feature['icon'], 'h-5 w-5'); ?></span>
                <h3 class="text-xl font-semibold text-zinc-950"><?php echo esc_html($feature['title']); ?></h3>
                <p class="text-sm leading-6 text-zinc-600"><?php echo esc_html($feature['description']); ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="border-y border-zinc-200 bg-white py-24">
        <div class="mx-auto grid max-w-screen-xl gap-16 px-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-start lg:px-8">
          <div class="flex flex-col gap-6 lg:sticky lg:top-24 lg:h-fit">
            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary"><?php esc_html_e('Integrations', 'webmakerr'); ?></span>
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl"><?php esc_html_e('Plug Webmakerr into your growth stack', 'webmakerr'); ?></h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg"><?php esc_html_e('Ship faster with API-ready snippets, documented hooks, and clean separation of data, presentation, and business logic.', 'webmakerr'); ?></p>
            <ul class="mt-2 grid gap-3 text-sm text-zinc-600">
              <li class="flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span>
                <?php esc_html_e('Funnel templates optimized for commerce and lifecycle tools.', 'webmakerr'); ?>
              </li>
              <li class="flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span>
                <?php esc_html_e('REST and webhook helpers keep integrations maintainable.', 'webmakerr'); ?>
              </li>
              <li class="flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span>
                <?php esc_html_e('Copy-paste starter code with inline developer guidance.', 'webmakerr'); ?>
              </li>
            </ul>
          </div>

          <div class="grid gap-8">
            <?php foreach ($integration_groups as $group) : ?>
              <div class="flex flex-col gap-5 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <div class="flex flex-col gap-3">
                  <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webmakerr_theme_render_icon($group['icon'], 'h-5 w-5'); ?></span>
                  <h3 class="text-xl font-semibold text-zinc-950"><?php echo esc_html($group['title']); ?></h3>
                  <p class="text-sm leading-6 text-zinc-600"><?php echo esc_html($group['description']); ?></p>
                </div>
                <ul class="grid gap-3 text-sm font-semibold text-zinc-950 sm:grid-cols-2">
                  <?php foreach ($group['items'] as $item) : ?>
                    <li class="flex items-center justify-between rounded-[5px] border border-dashed border-zinc-200 px-4 py-2 text-left text-sm font-semibold text-zinc-700">
                      <span class="flex items-center gap-2">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        echo webmakerr_theme_render_icon('plug', 'h-4 w-4'); ?></span>
                        <?php echo esc_html($item); ?>
                      </span>
                      <span aria-hidden="true">→</span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="bg-light py-24">
        <div class="mx-auto flex max-w-screen-xl flex-col gap-12 px-6 lg:px-8">
          <div class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl"><?php esc_html_e('High-performing teams choose Webmakerr', 'webmakerr'); ?></h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg"><?php esc_html_e('Founders, marketers, and developers rely on our free theme for fast launches, SEO wins, and effortless customization.', 'webmakerr'); ?></p>
          </div>

          <div class="grid gap-8 lg:grid-cols-3">
            <?php foreach ($testimonial_quotes as $testimonial) : ?>
              <figure class="flex h-full flex-col gap-6 rounded-[5px] border border-zinc-200 bg-white p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webmakerr_theme_render_icon('quote', 'h-5 w-5'); ?></span>
                <blockquote class="text-base leading-7 text-zinc-700 sm:text-lg">
                  <?php echo esc_html($testimonial['quote']); ?>
                </blockquote>
                <figcaption class="flex flex-col gap-1">
                  <span class="text-sm font-semibold text-zinc-950"><?php echo esc_html($testimonial['author']); ?></span>
                  <span class="text-xs uppercase tracking-[0.26em] text-zinc-500"><?php echo esc_html($testimonial['role']); ?></span>
                </figcaption>
              </figure>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="border-t border-zinc-200 bg-white py-24">
        <div class="mx-auto grid max-w-screen-xl gap-12 px-6 lg:grid-cols-[1.2fr_0.8fr] lg:px-8">
          <div class="flex flex-col gap-4">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl"><?php esc_html_e('Scale your site without technical debt', 'webmakerr'); ?></h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg"><?php esc_html_e('Start with our conversion-tested layouts, then evolve every pixel as your brand grows—all while keeping performance and maintainability locked in.', 'webmakerr'); ?></p>
            <p class="text-sm text-zinc-500"><?php esc_html_e('Developers get clear structure, marketers get flexible content controls, and everyone ships faster with clean Tailwind components.', 'webmakerr'); ?></p>
          </div>
          <div class="rounded-[5px] border border-zinc-200 bg-light/80 p-8 shadow-inner">
            <h3 class="text-xl font-semibold text-zinc-950"><?php esc_html_e('What’s included for free', 'webmakerr'); ?></h3>
            <ul class="mt-4 grid gap-3 text-sm text-zinc-700">
              <li class="flex items-start gap-4"><span class="mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span><?php esc_html_e('Conversion-optimized home, pricing, and landing page templates.', 'webmakerr'); ?></li>
              <li class="flex items-start gap-4"><span class="mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span><?php esc_html_e('Theme.json tokens tuned for SEO, accessibility, and brand consistency.', 'webmakerr'); ?></li>
              <li class="flex items-start gap-4"><span class="mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span><?php esc_html_e('Utility classes for cards, media modules, and interactive callouts.', 'webmakerr'); ?></li>
              <li class="flex items-start gap-4"><span class="mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_theme_render_icon('check', 'h-4 w-4'); ?></span><?php esc_html_e('Inline documentation plus ready-to-edit Tailwind and PHP examples.', 'webmakerr'); ?></li>
            </ul>
          </div>
        </div>
      </section>

      <section class="border-t border-zinc-200 bg-white py-24">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
          <div class="prose max-w-none text-zinc-700 sm:prose-lg">
            <?php the_content(); ?>
          </div>
        </div>
      </section>

      <section class="relative overflow-hidden bg-gradient-to-r from-primary/90 via-dark to-dark py-24">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.08),_transparent_60%)]"></div>
        <div class="relative mx-auto flex max-w-screen-xl flex-col items-center gap-6 px-6 text-center text-white lg:px-8">
          <span class="text-xs font-semibold uppercase tracking-[0.26em] text-white/70"><?php esc_html_e('Open-source & always improving', 'webmakerr'); ?></span>
          <h2 class="text-3xl font-semibold text-white sm:text-4xl"><?php esc_html_e('Launch a performance-first site with Webmakerr', 'webmakerr'); ?></h2>
          <p class="max-w-2xl text-base leading-7 text-white/80 sm:text-lg"><?php esc_html_e('Download the free theme, benefit from regular updates, and ship blazing-fast pages optimized for search, accessibility, and growth.', 'webmakerr'); ?></p>
          <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a class="inline-flex items-center justify-center rounded border border-transparent bg-white px-5 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-white/90 !no-underline" href="<?php echo esc_url($primary_cta_link['href']); ?>"<?php echo $primary_cta_link['attributes']; ?>>
              <?php echo esc_html($primary_cta_text); ?>
            </a>
            <a class="inline-flex items-center justify-center rounded border border-white/70 bg-transparent px-5 py-2 text-sm font-semibold text-white transition hover:bg-white/10 !no-underline" href="<?php echo esc_url($secondary_cta_link['href']); ?>"<?php echo $secondary_cta_link['attributes']; ?>>
              <?php esc_html_e('Preview the components', 'webmakerr'); ?>
            </a>
          </div>
        </div>
      </section>
    </article>
  <?php endwhile; ?>
</main>

<?php
webmakerr_render_template_popup($popup_settings);

get_footer();
