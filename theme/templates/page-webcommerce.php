<?php
/**
 * Template Name: WebCommerce Page
 */

if (! defined('ABSPATH')) {
    exit;
}

$popup_settings = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled  = (bool) ($popup_settings['enabled'] ?? false);

get_header();

$buy_url             = home_url('/buy-webcommerce');
$demo_url            = home_url('/webcommerce-demo');
$performance_anchor  = '#performance';
$product_anchor      = '#product-types';
$scalability_anchor  = '#scalability';
$branding_anchor     = '#branding';
$analytics_anchor    = '#analytics';
$developer_anchor    = '#developer';
$payments_anchor     = '#payments';
$migration_anchor    = '#migration';

$primary_cta_link   = webmakerr_get_popup_link_attributes($buy_url, $popup_enabled);
$secondary_cta_link = webmakerr_get_popup_link_attributes($demo_url, $popup_enabled);

$performance_stats = array(
    array(
        'icon' => 'zap',
        'label' => __('3× Faster order processing', 'webmakerr'),
    ),
    array(
        'icon' => 'activity',
        'label' => __('25% Fewer server resources', 'webmakerr'),
    ),
    array(
        'icon' => 'brain-circuit',
        'label' => __('Smart caching & database optimization', 'webmakerr'),
    ),
);

$product_types = array(
    array(
        'icon' => 'package',
        'title' => __('Physical Products', 'webmakerr'),
        'description' => __('Variations, stock automation, smart recommendations', 'webmakerr'),
    ),
    array(
        'icon' => 'cloud-download',
        'title' => __('Digital Products', 'webmakerr'),
        'description' => __('Instant file delivery via AWS S3, license generation, access control', 'webmakerr'),
    ),
    array(
        'icon' => 'repeat',
        'title' => __('Subscriptions', 'webmakerr'),
        'description' => __('Built-in recurring billing and analytics', 'webmakerr'),
    ),
);

$scalability_points = array(
    array(
        'icon' => 'layers',
        'label' => __('Large-catalog performance', 'webmakerr'),
    ),
    array(
        'icon' => 'shopping-cart',
        'label' => __('Optimized checkout flow', 'webmakerr'),
    ),
    array(
        'icon' => 'server',
        'label' => __('Low server usage', 'webmakerr'),
    ),
);

$branding_highlights = array(
    __('Gutenberg compatible', 'webmakerr'),
    __('Responsive', 'webmakerr'),
    __('CSS ready', 'webmakerr'),
);

$analytics_cards = array(
    array(
        'icon' => 'bar-chart',
        'title' => __('Orders', 'webmakerr'),
        'description' => __('Track new orders, repeat customers, and fulfillment speeds in real time.', 'webmakerr'),
    ),
    array(
        'icon' => 'key',
        'title' => __('Licenses', 'webmakerr'),
        'description' => __('Monitor active licenses, renewals, and expirations without add-ons.', 'webmakerr'),
    ),
    array(
        'icon' => 'refresh',
        'title' => __('Refunds', 'webmakerr'),
        'description' => __('Spot refund trends instantly and protect revenue with proactive actions.', 'webmakerr'),
    ),
);

$developer_points = array(
    array(
        'icon' => 'api',
        'title' => __('API-first foundation', 'webmakerr'),
        'description' => __('REST endpoints, webhooks, and filters let you orchestrate complex workflows.', 'webmakerr'),
    ),
    array(
        'icon' => 'code',
        'title' => __('Modern tooling', 'webmakerr'),
        'description' => __('Type-safe models, structured hooks, and documentation keep shipping fast.', 'webmakerr'),
    ),
    array(
        'icon' => 'plug',
        'title' => __('Seamless integrations', 'webmakerr'),
        'description' => __('Connect headless frontends or internal systems without compromising speed.', 'webmakerr'),
    ),
);

function webcommerce_render_icon($name, $class = 'h-6 w-6')
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
?>

<main id="primary" class="flex flex-col bg-white">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('flex flex-col'); ?>>
      <section class="relative overflow-hidden border-b border-zinc-200 bg-gradient-to-b from-white via-white to-light">
        <div class="relative z-10 mx-auto max-w-screen-xl px-6 py-12 lg:px-8 lg:py-20">
          <div class="grid items-center gap-16 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="flex flex-col gap-6">
              <span class="inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
                <?php esc_html_e('WebCommerce Plugin', 'webmakerr'); ?>
              </span>
              <h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl">
                <?php esc_html_e('The New Standard for WordPress eCommerce', 'webmakerr'); ?>
              </h1>
              <p class="max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Build, sell, and scale faster than ever. WebCommerce turns WordPress into a powerful, high-performance store engine — no bloat, no limits.', 'webmakerr'); ?>
              </p>
              <div class="mt-10 flex flex-col items-center gap-3 sm:flex-row sm:items-center">
                <a class="inline-flex w-full justify-center rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url($primary_cta_link['href']); ?>"<?php echo $primary_cta_link['attributes']; ?>>
                  <?php esc_html_e('Buy WebCommerce Now', 'webmakerr'); ?>
                </a>
              </div>
              <p class="mt-3 text-xs font-medium text-zinc-500 sm:text-sm">
                <?php esc_html_e('★★★★★ Powering 9,800+ stores with $180M in annual transactions', 'webmakerr'); ?>
              </p>
            </div>
            <div class="relative isolate overflow-hidden rounded-[5px] border border-white/60 bg-white/80 p-8 shadow-xl shadow-primary/10 backdrop-blur">
              <div class="absolute -left-16 -top-16 h-48 w-48 rounded-full bg-primary/10 blur-3xl"></div>
              <div class="relative flex flex-col gap-6">
                <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-6 shadow-sm">
                  <p class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Optimized workflows', 'webmakerr'); ?></p>
                  <p class="mt-2 text-sm text-zinc-600"><?php esc_html_e('Independent tables, instant checkout, and modern APIs deliver enterprise-grade speed.', 'webmakerr'); ?></p>
                </div>
                <ul class="grid gap-3 text-sm text-zinc-600">
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webcommerce_render_icon('zap', 'h-5 w-5'); ?></span>
                    <?php esc_html_e('Checkout under 1 second, even at peak volume.', 'webmakerr'); ?>
                  </li>
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webcommerce_render_icon('layers', 'h-5 w-5'); ?></span>
                    <?php esc_html_e('Modular architecture made for product growth.', 'webmakerr'); ?>
                  </li>
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webcommerce_render_icon('check', 'h-5 w-5'); ?></span>
                    <?php esc_html_e('Ready to ship with Webmakerr theme styling on day one.', 'webmakerr'); ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="performance" class="bg-white py-12 lg:py-20">
        <div class="mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div class="flex flex-col gap-6">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Speed is Money. Keep Both.', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('WebCommerce is engineered for raw speed and scalability. Every request, every order, every checkout happens faster — keeping your store smooth and your customers happy.', 'webmakerr'); ?>
              </p>
              <a class="mt-6 inline-flex rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($performance_anchor); ?>">
                <?php esc_html_e('See How It Performs', 'webmakerr'); ?>
              </a>
            </div>
            <div class="grid gap-4 sm:grid-cols-3">
              <?php foreach ($performance_stats as $stat) : ?>
                <div class="flex flex-col gap-3 rounded-[5px] border border-zinc-200 bg-light/60 p-6 text-sm text-zinc-600 shadow-sm">
                  <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-primary">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webcommerce_render_icon($stat['icon'], 'h-5 w-5');
                    ?>
                  </span>
                  <p class="font-semibold text-zinc-950"><?php echo esc_html($stat['label']); ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>

      <section id="product-types" class="border-t border-b border-zinc-200 bg-light py-12 lg:py-20">
        <div class="mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="mx-auto flex max-w-3xl flex-col items-center gap-4 text-center">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('One Plugin. Infinite Possibilities.', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('Physical goods, digital downloads, software licenses, subscriptions — all from one dashboard. No duct-taped extensions. No setup hassle. Just plug in and sell.', 'webmakerr'); ?>
            </p>
          </div>
          <div class="mt-12 grid gap-6 md:grid-cols-3">
            <?php foreach ($product_types as $type) : ?>
              <div class="flex h-full flex-col gap-4 rounded-[5px] border border-zinc-200 bg-white p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                  <?php
                  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon($type['icon'], 'h-6 w-6');
                  ?>
                </span>
                <h3 class="text-xl font-semibold text-zinc-950"><?php echo esc_html($type['title']); ?></h3>
                <p class="text-sm leading-6 text-zinc-600"><?php echo esc_html($type['description']); ?></p>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="mt-10 flex justify-center">
            <a class="inline-flex rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($product_anchor); ?>">
              <?php esc_html_e('Explore Product Types', 'webmakerr'); ?>
            </a>
          </div>
        </div>
      </section>

      <section id="scalability" class="bg-white py-12 lg:py-20">
        <div class="mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="grid gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
            <div class="flex flex-col gap-6">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Built for Stores That Expect to Grow', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Whether you’re selling 10 products or 10,000, WebCommerce keeps pace. Independent database tables and dynamic resource allocation mean you scale without lag or downtime.', 'webmakerr'); ?>
              </p>
            </div>
            <ul class="grid gap-4 text-sm text-zinc-600">
              <?php foreach ($scalability_points as $point) : ?>
                <li class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-light/60 px-5 py-4">
                  <span class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-full bg-white text-primary">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webcommerce_render_icon($point['icon'], 'h-5 w-5');
                    ?>
                  </span>
                  <span class="font-semibold text-zinc-950"><?php echo esc_html($point['label']); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </section>

      <section id="branding" class="border-t border-zinc-200 bg-light py-12 lg:py-20">
        <div class="mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="grid gap-12 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
            <div class="flex flex-col gap-6">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Your Brand. Your Store. Your Rules.', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Customize every block — checkout, pricing, or product layouts — directly inside WordPress. Stay 100% on-brand without touching a line of code.', 'webmakerr'); ?>
              </p>
              <a class="mt-6 inline-flex rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($branding_anchor); ?>">
                <?php esc_html_e('Explore Store Design', 'webmakerr'); ?>
              </a>
            </div>
            <div class="flex flex-wrap gap-3">
              <?php foreach ($branding_highlights as $highlight) : ?>
                <span class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.26em] text-zinc-600">
                  <?php
                  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon('check', 'h-4 w-4');
                  ?>
                  <?php echo esc_html($highlight); ?>
                </span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>

      <section id="analytics" class="bg-white py-12 lg:py-20">
        <div class="mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Every Sale. Every Customer. Every Insight.', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('WebCommerce gives you real-time analytics for revenue, refunds, and renewals — all without add-ons. Make better decisions faster with live performance data.', 'webmakerr'); ?>
            </p>
          </div>
          <div class="mt-12 grid gap-6 md:grid-cols-3">
            <?php foreach ($analytics_cards as $card) : ?>
              <div class="flex h-full flex-col gap-4 rounded-[5px] border border-zinc-200 bg-light/60 p-6 shadow-sm">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-primary">
                  <?php
                  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon($card['icon'], 'h-6 w-6');
                  ?>
                </span>
                <h3 class="text-xl font-semibold text-zinc-950"><?php echo esc_html($card['title']); ?></h3>
                <p class="text-sm leading-6 text-zinc-600"><?php echo esc_html($card['description']); ?></p>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="mt-10 flex justify-center">
            <a class="inline-flex rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($analytics_anchor); ?>">
              <?php esc_html_e('View Analytics', 'webmakerr'); ?>
            </a>
          </div>
        </div>
      </section>

      <section id="developer" class="border-t border-b border-zinc-200 bg-light py-12 lg:py-20">
        <div class="mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="grid gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
            <div class="flex flex-col gap-6">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Build Anything with WebCommerce APIs', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('WebCommerce is open-source and extensible. Create custom workflows, integrate third-party apps, or go fully headless with REST APIs — while keeping your backend secure and fast.', 'webmakerr'); ?>
              </p>
              <a class="mt-6 inline-flex rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($developer_anchor); ?>">
                <?php esc_html_e('Explore Developer Docs', 'webmakerr'); ?>
              </a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2">
              <?php foreach ($developer_points as $item) : ?>
                <div class="flex h-full flex-col gap-3 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm">
                  <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webcommerce_render_icon($item['icon'], 'h-6 w-6');
                    ?>
                  </span>
                  <h3 class="text-xl font-semibold text-zinc-950"><?php echo esc_html($item['title']); ?></h3>
                  <p class="text-sm leading-6 text-zinc-600"><?php echo esc_html($item['description']); ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>

      <section id="payments" class="bg-white py-12 lg:py-20">
        <div class="mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div class="flex flex-col gap-6">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Get Paid Your Way — No Platform Fees', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Accept global payments instantly with Stripe and PayPal. Or integrate any local gateway with our developer-friendly payment API. No transaction fees. No revenue sharing. Ever.', 'webmakerr'); ?>
              </p>
              <a class="mt-6 inline-flex rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($payments_anchor); ?>">
                <?php esc_html_e('Explore Payments', 'webmakerr'); ?>
              </a>
            </div>
            <div class="rounded-[5px] border border-zinc-200 bg-light/60 p-8 shadow-sm">
              <p class="text-sm font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Payment stack highlights', 'webmakerr'); ?></p>
              <ul class="mt-4 grid gap-3 text-sm text-zinc-600">
                <li class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon('check', 'h-4 w-4'); ?></span>
                  <?php esc_html_e('Stripe, PayPal, and custom gateways', 'webmakerr'); ?>
                </li>
                <li class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon('check', 'h-4 w-4'); ?></span>
                  <?php esc_html_e('Tokenized storage and secure webhooks', 'webmakerr'); ?>
                </li>
                <li class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon('check', 'h-4 w-4'); ?></span>
                  <?php esc_html_e('Instant payouts with zero platform fees', 'webmakerr'); ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <section id="migration" class="border-t border-zinc-200 bg-light py-12 lg:py-20">
        <div class="mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="grid gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
            <div class="flex flex-col gap-6">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Switch in One Click. Sell Instantly.', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Already selling elsewhere? Migrate your products, orders, and customers with one click. WebCommerce makes migration effortless so you can get back to business fast.', 'webmakerr'); ?>
              </p>
              <a class="mt-6 inline-flex rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($migration_anchor); ?>">
                <?php esc_html_e('Switch to WebCommerce', 'webmakerr'); ?>
              </a>
            </div>
            <div class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm">
              <p class="text-sm font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Migration includes', 'webmakerr'); ?></p>
              <ul class="mt-4 grid gap-3 text-sm text-zinc-600">
                <li class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-light/80 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon('check', 'h-4 w-4'); ?></span>
                  <?php esc_html_e('Product catalogs with variations and media', 'webmakerr'); ?>
                </li>
                <li class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-light/80 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon('check', 'h-4 w-4'); ?></span>
                  <?php esc_html_e('Customer accounts and order history', 'webmakerr'); ?>
                </li>
                <li class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-light/80 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webcommerce_render_icon('check', 'h-4 w-4'); ?></span>
                  <?php esc_html_e('Automated redirects and analytics sync', 'webmakerr'); ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <section class="relative overflow-hidden bg-gradient-to-r from-primary/90 via-dark to-dark py-12 lg:py-20">
        <div class="relative mx-auto max-w-screen-xl px-6 lg:px-8">
          <div class="mx-auto flex max-w-3xl flex-col gap-6 text-center text-white">
            <h2 class="text-3xl font-semibold text-white sm:text-4xl">
              <?php esc_html_e('Faster. Lighter. Smarter.', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-white/80 sm:text-lg">
              <?php esc_html_e('The future of WordPress eCommerce starts with WebCommerce.', 'webmakerr'); ?>
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
              <a class="inline-flex items-center justify-center rounded border border-transparent bg-white px-5 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-white/90 !no-underline" href="<?php echo esc_url($primary_cta_link['href']); ?>"<?php echo $primary_cta_link['attributes']; ?>>
                <?php esc_html_e('Buy Now', 'webmakerr'); ?>
              </a>
              <a class="inline-flex items-center justify-center rounded border border-white/70 bg-transparent px-5 py-2 text-sm font-semibold text-white transition hover:bg-white/10 !no-underline" href="<?php echo esc_url($secondary_cta_link['href']); ?>"<?php echo $secondary_cta_link['attributes']; ?>>
                <?php esc_html_e('View Demo', 'webmakerr'); ?>
              </a>
            </div>
            <p class="text-sm text-white/70">
              <?php esc_html_e('Join thousands of creators and developers building faster, more profitable stores with WebCommerce.', 'webmakerr'); ?>
            </p>
          </div>
        </div>
      </section>
    </article>
  <?php endwhile; ?>
</main>

<?php
webmakerr_render_template_popup($popup_settings);

get_footer();
?>
