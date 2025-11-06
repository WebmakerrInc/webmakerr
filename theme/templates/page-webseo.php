<?php
/**
 * Template Name: WebSEO Landing Page
 */

if (! defined('ABSPATH')) {
    exit;
}

$popup_settings = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled  = (bool) ($popup_settings['enabled'] ?? false);

if (! function_exists('webseo_render_icon')) {
    function webseo_render_icon($name, $class = 'w-6 h-6 text-primary mb-3')
    {
        $icons = array(
            'cog' => '<path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"></path><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"></path>',
            'zap' => '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>',
            'code' => '<polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline>',
            'sparkles' => '<path d="M12 3v4"></path><path d="M12 17v4"></path><path d="M3 12h4"></path><path d="M17 12h4"></path><path d="M18.36 5.64 16 8"></path><path d="M8 16 5.64 18.36"></path><path d="m5.64 5.64 2.36 2.36"></path><path d="M16 16l2.36 2.36"></path><circle cx="12" cy="12" r="2"></circle>',
            'file-text' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line>',
            'diagram' => '<circle cx="6" cy="6" r="2"></circle><circle cx="18" cy="6" r="2"></circle><circle cx="12" cy="18" r="2"></circle><path d="M8 6h8"></path><path d="M12 8v6"></path>',
            'redirect' => '<path d="M3 7h7"></path><path d="M10 7V3"></path><path d="m10 3 4 4-4 4"></path><path d="M14 17h7"></path><path d="M14 17v4"></path><path d="m14 21-4-4 4-4"></path>',
            'image' => '<rect x="3" y="4" width="18" height="16" rx="2"></rect><circle cx="8" cy="9" r="1.5"></circle><path d="m21 15-5-5-4 4-3-3-4 4"></path>',
            'sitemap' => '<rect x="3" y="4" width="6" height="6" rx="1"></rect><rect x="9" y="14" width="6" height="6" rx="1"></rect><rect x="15" y="4" width="6" height="6" rx="1"></rect><path d="M6 10v2a2 2 0 0 0 2 2h2"></path><path d="M18 10v2a2 2 0 0 1-2 2h-2"></path><path d="M12 14v-2"></path>',
            'breadcrumbs' => '<circle cx="6" cy="12" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="18" cy="12" r="2"></circle><path d="M8 12h2"></path><path d="M14 12h2"></path>',
            'brackets' => '<path d="M7 4 3 12l4 8"></path><path d="M17 4l4 8-4 8"></path>',
            'rss' => '<path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>',
            'rocket' => '<path d="M4 13c-1.1-.4-2.1-.9-3-1.5 1.2-2.8 3.2-5.2 5.7-6.8A16 16 0 0 1 13 2l2 2-3.5 3.5"></path><path d="M12 12a2 2 0 1 1 4 0 2 2 0 0 1-4 0"></path><path d="m9 15-3 6 6-3a9 9 0 0 0 6-6l3-3-6-6"></path><path d="M15 9h3"></path>',
            'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path><path d="m9 12 2 2 4-4"></path>',
            'message' => '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7A8.38 8.38 0 0 1 8.7 19L3 21l1.2-5.3A8.5 8.5 0 1 1 21 11.5Z"></path><path d="M8 11h8"></path><path d="M8 15h5"></path>',
            'globe' => '<path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path><path d="M3.5 9h17"></path><path d="M3.5 15h17"></path><path d="M12 3a14.5 14.5 0 0 1 0 18"></path><path d="M12 3a14.5 14.5 0 0 0 0 18"></path>',
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

get_header();
?>

<?php
$cta_primary_link  = webmakerr_get_popup_link_attributes('#get-webseo', $popup_enabled);
$cta_upgrade_link  = webmakerr_get_popup_link_attributes('#upgrade-webseo', $popup_enabled);
$cta_purchase_link = webmakerr_get_popup_link_attributes('#purchase-webseo', $popup_enabled);
?>

<main id="primary" class="bg-white py-16 sm:py-20 lg:py-24">
  <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('flex flex-col gap-16'); ?>>
        <section class="relative overflow-hidden rounded-[5px] border border-zinc-200 bg-gradient-to-br from-white via-white to-primary/5 px-6 py-14 sm:px-10 sm:py-16 lg:px-16">
          <div class="absolute -left-24 -top-24 h-64 w-64 rounded-full bg-primary/10 blur-3xl"></div>
          <div class="absolute -bottom-32 -right-10 h-72 w-72 rounded-full bg-dark/5 blur-3xl"></div>
          <div class="relative grid gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <header class="flex flex-col gap-6">
              <span class="inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
                <?php esc_html_e('WebSEO — Fast & Automated WordPress SEO Plugin', 'webmakerr'); ?>
              </span>
              <h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl">
                <?php esc_html_e('Automated SEO That Works While You Sleep', 'webmakerr'); ?>
              </h1>
              <p class="max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('WebSEO instantly optimizes your WordPress website for higher rankings — no technical setup, no SEO jargon. Just install, activate, and start ranking.', 'webmakerr'); ?>
              </p>
              <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row sm:items-center sm:gap-4">
                <a class="inline-flex w-full items-center justify-center rounded-[5px] bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url($cta_primary_link['href']); ?>"<?php echo $cta_primary_link['attributes']; ?>>
                  <?php esc_html_e('Get WebSEO Now', 'webmakerr'); ?>
                </a>
                <a class="inline-flex w-full items-center justify-center rounded-[5px] border border-zinc-200 px-5 py-2 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline sm:w-auto" href="#demo-webseo">
                  <?php esc_html_e('Try Live Demo', 'webmakerr'); ?>
                </a>
              </div>
              <p class="mt-3 text-xs font-medium text-zinc-500 sm:text-sm">
                <?php esc_html_e('★★★★★ 4.9/5 from SEO pros — 18,000+ sites optimized on autopilot', 'webmakerr'); ?>
              </p>
            </header>
            <div class="relative isolate rounded-[5px] border border-white/60 bg-white/80 p-6 shadow-xl shadow-primary/10 backdrop-blur">
              <div class="absolute -left-10 -top-12 h-40 w-40 rounded-full bg-primary/10 blur-3xl"></div>
              <div class="absolute -bottom-10 -right-10 h-32 w-32 rounded-full bg-dark/5 blur-3xl"></div>
              <div class="relative flex flex-col gap-4">
                <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-6 shadow-sm">
                  <p class="text-xs font-semibold uppercase tracking-[0.3em] text-primary">
                    <?php esc_html_e('Always-On Optimization', 'webmakerr'); ?>
                  </p>
                  <p class="mt-2 text-sm text-zinc-600">
                    <?php esc_html_e('Meta tags, schema, redirects, and image SEO automatically update in the background — 24/7.', 'webmakerr'); ?>
                  </p>
                </div>
                <ul class="grid gap-3 text-sm text-zinc-600">
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webseo_render_icon('cog'); ?></span>
                    <span><?php esc_html_e('Zero configuration required — activate and your site starts optimizing itself.', 'webmakerr'); ?></span>
                  </li>
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webseo_render_icon('zap'); ?></span>
                    <span><?php esc_html_e('Lightweight architecture keeps your pages loading fast and scoring higher.', 'webmakerr'); ?></span>
                  </li>
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webseo_render_icon('code'); ?></span>
                    <span><?php esc_html_e('Built by veteran WordPress developers with 15+ years of technical SEO experience.', 'webmakerr'); ?></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm sm:p-10">
          <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Why WebSEO', 'webmakerr'); ?></span>
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Built for Simplicity. Engineered for Results.', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('SEO shouldn’t feel like rocket science — or slow down your site. WebSEO makes optimization automatic, lightweight, and effortless.', 'webmakerr'); ?>
            </p>
          </header>
          <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <?php
            $why_features = array(
                array(
                    'icon' => 'cog',
                    'title' => __('Zero Configuration', 'webmakerr'),
                    'description' => __('Install and go — every essential SEO task is automated.', 'webmakerr'),
                ),
                array(
                    'icon' => 'zap',
                    'title' => __('Super Lightweight', 'webmakerr'),
                    'description' => __('Runs 2× faster than bloated SEO plugins for instant performance.', 'webmakerr'),
                ),
                array(
                    'icon' => 'code',
                    'title' => __('High-Quality Code', 'webmakerr'),
                    'description' => __('Crafted by veteran WordPress developers with 15+ years of expertise.', 'webmakerr'),
                ),
                array(
                    'icon' => 'sparkles',
                    'title' => __('Full-Featured', 'webmakerr'),
                    'description' => __('Handles meta tags, schema, images, redirects, and more automatically.', 'webmakerr'),
                ),
            );

            foreach ($why_features as $feature) :
                ?>
                <article class="flex h-full flex-col items-start rounded-[5px] border border-zinc-200 bg-zinc-50 p-6 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                  <?php
                  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webseo_render_icon($feature['icon']);
                  ?>
                  <h3 class="text-xl font-semibold text-zinc-950">
                    <?php echo esc_html($feature['title']); ?>
                  </h3>
                  <p class="mt-3 text-sm leading-6 text-zinc-600">
                    <?php echo esc_html($feature['description']); ?>
                  </p>
                </article>
                <?php
            endforeach;
            ?>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm sm:p-10">
          <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('What WebSEO Does For You', 'webmakerr'); ?></span>
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Automated SEO Tools, Ready from Day One', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('Every critical SEO feature is included out of the box so your site stays optimized without manual effort.', 'webmakerr'); ?>
            </p>
          </header>
          <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            $capabilities = array(
                array(
                    'icon' => 'file-text',
                    'title' => __('Meta Tags', 'webmakerr'),
                    'description' => __('Automatically optimized titles, descriptions, Open Graph, and Twitter tags.', 'webmakerr'),
                ),
                array(
                    'icon' => 'diagram',
                    'title' => __('Schema (Structured Data)', 'webmakerr'),
                    'description' => __('Unified schema types for posts, products, and reviews — no setup needed.', 'webmakerr'),
                ),
                array(
                    'icon' => 'redirect',
                    'title' => __('Redirection', 'webmakerr'),
                    'description' => __('Fix broken links fast and protect rankings with simple redirect tools.', 'webmakerr'),
                ),
                array(
                    'icon' => 'image',
                    'title' => __('Image Alt Text', 'webmakerr'),
                    'description' => __('Auto-adds missing alt text for accessibility and search visibility.', 'webmakerr'),
                ),
                array(
                    'icon' => 'sitemap',
                    'title' => __('XML Sitemap', 'webmakerr'),
                    'description' => __('Instantly generates and submits your sitemap so crawlers stay up to date.', 'webmakerr'),
                ),
                array(
                    'icon' => 'breadcrumbs',
                    'title' => __('Breadcrumbs', 'webmakerr'),
                    'description' => __('Built-in hierarchy shows visitors and Google exactly where they are.', 'webmakerr'),
                ),
                array(
                    'icon' => 'brackets',
                    'title' => __('Header & Footer Code', 'webmakerr'),
                    'description' => __('Add tracking scripts like GTM, Analytics, or Pixel without touching files.', 'webmakerr'),
                ),
                array(
                    'icon' => 'rss',
                    'title' => __('RSS Feed', 'webmakerr'),
                    'description' => __('Protects your content with automatic backlinks in every feed item.', 'webmakerr'),
                ),
            );

            foreach ($capabilities as $tool) :
                ?>
                <article class="flex h-full flex-col rounded-[5px] border border-zinc-200 bg-zinc-50 p-6 shadow-sm">
                  <div class="flex items-start gap-4">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webseo_render_icon($tool['icon']);
                    ?>
                    <div>
                      <h3 class="text-lg font-semibold text-zinc-950">
                        <?php echo esc_html($tool['title']); ?>
                      </h3>
                      <p class="mt-2 text-sm leading-6 text-zinc-600">
                        <?php echo esc_html($tool['description']); ?>
                      </p>
                    </div>
                  </div>
                </article>
                <?php
            endforeach;
            ?>
          </div>
        </section>

        <section class="grid gap-10 rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm lg:grid-cols-2 lg:items-center lg:gap-16 lg:p-12">
          <div class="flex flex-col gap-6">
            <header class="flex flex-col gap-4">
              <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Why Users Switch to WebSEO', 'webmakerr'); ?></span>
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('From Overwhelmed to Optimized. Instantly.', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600">
                <?php esc_html_e('Thousands of users replace their bloated plugins with WebSEO every month — because it just works.', 'webmakerr'); ?>
              </p>
            </header>
            <ul class="grid gap-3 text-sm text-zinc-600">
              <?php
              $reasons = array(
                  array(
                      'icon' => 'rocket',
                      'copy' => __('Fast to Install – Up and running in under a minute.', 'webmakerr'),
                  ),
                  array(
                      'icon' => 'shield',
                      'copy' => __('Secure & Lightweight – Minimal load, maximum performance.', 'webmakerr'),
                  ),
                  array(
                      'icon' => 'message',
                      'copy' => __('Beginner-Friendly – No SEO background required.', 'webmakerr'),
                  ),
                  array(
                      'icon' => 'globe',
                      'copy' => __('Fully Automated – You focus on content, we handle optimization.', 'webmakerr'),
                  ),
              );

              foreach ($reasons as $reason) :
                  ?>
                  <li class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 px-4 py-3">
                    <span class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webseo_render_icon($reason['icon'], 'w-5 h-5 text-primary'); ?></span>
                    <span class="text-sm leading-6 text-zinc-700"><?php echo esc_html($reason['copy']); ?></span>
                  </li>
                  <?php
              endforeach;
              ?>
            </ul>
            <div class="mt-6">
              <a class="inline-flex items-center justify-center rounded-[5px] bg-primary px-5 py-2 text-sm font-semibold text-white transition hover:bg-primary/90 !no-underline" href="<?php echo esc_url($cta_primary_link['href']); ?>"<?php echo $cta_primary_link['attributes']; ?>>
                <?php esc_html_e('Start with WebSEO Free', 'webmakerr'); ?>
              </a>
            </div>
          </div>
          <div class="relative isolate overflow-hidden rounded-[5px] border border-dashed border-primary/30 bg-gradient-to-br from-primary/5 via-white to-primary/10 p-8 shadow-inner">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(37,99,235,0.08),_transparent)]"></div>
            <div class="relative flex flex-col gap-4 text-sm text-zinc-700">
              <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary/80">
                <?php esc_html_e('Built for performance-first teams', 'webmakerr'); ?>
              </p>
              <p>
                <?php esc_html_e('Switching from heavyweight SEO plugins unlocks faster load times, better stability, and a dramatically simpler workflow.', 'webmakerr'); ?>
              </p>
              <p>
                <?php esc_html_e('WebSEO keeps your stack lean, gives you automation you can trust, and makes it effortless to scale search visibility across every property.', 'webmakerr'); ?>
              </p>
            </div>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm sm:p-10">
          <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Introducing WebSEO Pro', 'webmakerr'); ?></span>
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Take Control with WebSEO Pro', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('Unlock advanced tools to scale your SEO performance.', 'webmakerr'); ?>
            </p>
          </header>
          <div class="mt-10 grid gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div class="grid gap-4 rounded-[5px] border border-zinc-200 bg-zinc-50 p-6 shadow-sm">
              <?php
              $pro_features = array(
                  array(
                      'icon' => 'diagram',
                      'title' => __('Visual Schema Builder', 'webmakerr'),
                      'description' => __('Build custom schemas with an easy, visual interface. No code required.', 'webmakerr'),
                  ),
                  array(
                      'icon' => 'redirect',
                      'title' => __('Internal Link Manager', 'webmakerr'),
                      'description' => __('Monitor and optimize internal links automatically for authority flow.', 'webmakerr'),
                  ),
                  array(
                      'icon' => 'message',
                      'title' => __('Writing Assistant', 'webmakerr'),
                      'description' => __('Real-time content optimization tips to boost engagement and visibility.', 'webmakerr'),
                  ),
              );

              foreach ($pro_features as $feature) :
                  ?>
                  <div class="flex gap-4 rounded-[5px] border border-zinc-200 bg-white p-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-[5px] bg-primary/10 text-primary">
                      <?php
                      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webseo_render_icon($feature['icon']);
                      ?>
                    </div>
                    <div class="flex flex-col">
                      <h3 class="text-lg font-semibold text-zinc-950">
                        <?php echo esc_html($feature['title']); ?>
                      </h3>
                      <p class="mt-2 text-sm leading-6 text-zinc-600">
                        <?php echo esc_html($feature['description']); ?>
                      </p>
                    </div>
                  </div>
                  <?php
              endforeach;
              ?>
            </div>
            <div class="flex flex-col items-center gap-4 rounded-[5px] border border-zinc-200 bg-white p-6 text-center shadow-sm">
              <p class="text-sm uppercase tracking-[0.4em] text-primary">
                <?php esc_html_e('Upgrade Anytime', 'webmakerr'); ?>
              </p>
              <p class="max-w-xs text-sm leading-6 text-zinc-600">
                <?php esc_html_e('Start free and upgrade when you’re ready for advanced automation, deeper insights, and collaborative workflows.', 'webmakerr'); ?>
              </p>
              <a class="inline-flex items-center justify-center rounded-[5px] bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline" href="<?php echo esc_url($cta_upgrade_link['href']); ?>"<?php echo $cta_upgrade_link['attributes']; ?>>
                <?php esc_html_e('Upgrade to WebSEO Pro', 'webmakerr'); ?>
              </a>
            </div>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm sm:p-10">
          <header class="flex flex-col gap-4 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Customer Reviews', 'webmakerr'); ?></span>
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('What Our Users Say', 'webmakerr'); ?>
            </h2>
          </header>
          <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            $testimonials = array(
                array(
                    'quote' => __('“WebSEO replaced three plugins on my client sites. Simple, fast, and accurate.”', 'webmakerr'),
                    'author' => __('— David M.', 'webmakerr'),
                ),
                array(
                    'quote' => __('“The performance boost is noticeable. Finally, an SEO plugin that doesn’t slow WordPress down.”', 'webmakerr'),
                    'author' => __('— Simon B.', 'webmakerr'),
                ),
                array(
                    'quote' => __('“Perfect for beginners. It automates everything but still gives me full control.”', 'webmakerr'),
                    'author' => __('— Alan G.', 'webmakerr'),
                ),
            );

            foreach ($testimonials as $testimonial) :
                ?>
                <figure class="flex h-full flex-col gap-4 rounded-[5px] border border-zinc-200 bg-zinc-50 p-6 text-left shadow-sm">
                  <p class="text-lg font-semibold text-primary"><?php esc_html_e('⭐️⭐️⭐️⭐️⭐️', 'webmakerr'); ?></p>
                  <blockquote class="text-sm leading-6 text-zinc-700">
                    <?php echo esc_html($testimonial['quote']); ?>
                  </blockquote>
                  <figcaption class="text-sm font-medium text-zinc-500">
                    <?php echo esc_html($testimonial['author']); ?>
                  </figcaption>
                </figure>
                <?php
            endforeach;
            ?>
          </div>
          <div class="mt-8 flex justify-center">
            <a class="inline-flex items-center justify-center rounded-[5px] border border-zinc-200 px-5 py-2 text-sm font-semibold text-zinc-950 transition hover:border-primary hover:text-primary !no-underline" href="#reviews-webseo">
              <?php esc_html_e('View More Reviews', 'webmakerr'); ?>
            </a>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm sm:p-10">
          <header class="flex flex-col gap-4 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Blog / Learning', 'webmakerr'); ?></span>
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Learn, Improve, Rank Higher', 'webmakerr'); ?>
            </h2>
          </header>
          <div class="mt-10 grid gap-6 sm:grid-cols-3">
            <?php
            $blog_items = array(
                array(
                    'title' => __('🚀 Introducing the SEO Analyzer Extension', 'webmakerr'),
                    'description' => __('Analyze pages right from your browser and uncover quick wins.', 'webmakerr'),
                ),
                array(
                    'title' => __('✍️ Writing Assistant in WebSEO Pro', 'webmakerr'),
                    'description' => __('Write for users and search engines at the same time.', 'webmakerr'),
                ),
                array(
                    'title' => __('🧩 Structured Data Made Simple', 'webmakerr'),
                    'description' => __('Understand schema the easy way with actionable guides.', 'webmakerr'),
                ),
            );

            foreach ($blog_items as $item) :
                ?>
                <article class="flex h-full flex-col gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 p-6 shadow-sm">
                  <h3 class="text-lg font-semibold text-zinc-950">
                    <?php echo esc_html($item['title']); ?>
                  </h3>
                  <p class="text-sm leading-6 text-zinc-600">
                    <?php echo esc_html($item['description']); ?>
                  </p>
                </article>
                <?php
            endforeach;
            ?>
          </div>
          <div class="mt-8 flex justify-center">
              <a class="inline-flex items-center justify-center rounded-[5px] bg-primary px-5 py-2 text-sm font-semibold text-white transition hover:bg-primary/90 !no-underline" href="#blog-webseo">
              <?php esc_html_e('Read the Blog', 'webmakerr'); ?>
            </a>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm sm:p-10">
          <header class="flex flex-col gap-4 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('FAQ', 'webmakerr'); ?></span>
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Frequently Asked Questions', 'webmakerr'); ?>
            </h2>
          </header>
          <div class="mt-10 grid gap-6 lg:grid-cols-2">
            <?php
            $faqs = array(
                array(
                    'question' => __('Do I need SEO knowledge?', 'webmakerr'),
                    'answer' => __('No. WebSEO automates all key SEO tasks out of the box.', 'webmakerr'),
                ),
                array(
                    'question' => __('Will it slow down my site?', 'webmakerr'),
                    'answer' => __('Absolutely not — WebSEO is built for speed, tested on large WordPress sites.', 'webmakerr'),
                ),
                array(
                    'question' => __('Can I migrate from other SEO plugins?', 'webmakerr'),
                    'answer' => __('Yes, WebSEO automatically imports your existing SEO data.', 'webmakerr'),
                ),
                array(
                    'question' => __('Do I need to configure it?', 'webmakerr'),
                    'answer' => __('No setup required — install and you’re fully optimized.', 'webmakerr'),
                ),
            );

            foreach ($faqs as $faq) :
                ?>
                <article class="flex flex-col gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 p-6 shadow-sm">
                  <h3 class="text-lg font-semibold text-zinc-950">
                    <?php echo esc_html($faq['question']); ?>
                  </h3>
                  <p class="text-sm leading-6 text-zinc-600">
                    <?php echo esc_html($faq['answer']); ?>
                  </p>
                </article>
                <?php
            endforeach;
            ?>
          </div>
        </section>

        <section id="get-webseo" class="rounded-[5px] border border-zinc-200 bg-gradient-to-br from-white via-white to-primary/5 p-8 text-center shadow-sm sm:p-10">
          <div class="mx-auto flex max-w-3xl flex-col gap-6">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Start Ranking Faster with WebSEO', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('Automate SEO. Increase visibility. Save time. WebSEO does the hard work for you — effortlessly.', 'webmakerr'); ?>
            </p>
            <div class="mt-4 flex flex-col items-center justify-center gap-4 sm:flex-row">
              <a class="inline-flex items-center justify-center rounded-[5px] bg-dark px-6 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline" href="<?php echo esc_url($cta_purchase_link['href']); ?>"<?php echo $cta_purchase_link['attributes']; ?>>
                <?php esc_html_e('Get WebSEO Now', 'webmakerr'); ?>
              </a>
              <a id="demo-webseo" class="inline-flex items-center justify-center rounded-[5px] border border-zinc-200 px-6 py-2 text-sm font-semibold text-zinc-950 transition hover:border-primary hover:text-primary !no-underline" href="#demo">
                <?php esc_html_e('Try Live Demo', 'webmakerr'); ?>
              </a>
            </div>
          </div>
        </section>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php
webmakerr_render_template_popup($popup_settings);

get_footer();
