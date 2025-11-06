<?php
/**
 * Template for the front page.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit;
}

$popup_settings = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled  = (bool) ($popup_settings['enabled'] ?? false);

if (! function_exists('webmakerr_frontpage_icon')) {
    /**
     * Render service icons for the homepage.
     */
    function webmakerr_frontpage_icon(string $icon, string $class = 'h-12 w-12 text-primary')
    {
        $icons = array(
            'website' => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5V18.5A2.5 2.5 0 0 1 17.5 21h-11A2.5 2.5 0 0 1 4 18.5zm2.5-.5A.5.5 0 0 0 6 5.5v2.75h12V5.5a.5.5 0 0 0-.5-.5zM6 10.25v8.25a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5v-8.25z"></path><path d="M9 14h6"></path><path d="M9 17h3.5"></path>',
            'funnel'  => '<path d="M5 4h14l-5.5 7.5v5.25a1.75 1.75 0 0 1-2.48 1.58l-1.54-.74A1.75 1.75 0 0 1 8.5 15.96v-4.46z"></path>',
            'plugin'  => '<path d="M13 3v3.5h2A2.5 2.5 0 0 1 17.5 9v1.5H21v3h-3.5V15A2.5 2.5 0 0 1 15 17.5h-2V21h-3v-3.5H8A2.5 2.5 0 0 1 5.5 15v-1.5H2v-3h3.5V9A2.5 2.5 0 0 1 8 6.5h2V3z"></path>',
            'landing' => '<rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 11h18"></path><path d="M9 8h6"></path><path d="M9 16h4"></path>',
            'shield'  => '<path d="M12 3.25 5 6v6c0 4.28 2.86 7.42 7 8.75 4.14-1.33 7-4.47 7-8.75V6z"></path><path d="M9.5 12.25 11.25 14l3.25-3.5"></path>',
            'growth'  => '<path d="M4 17h16"></path><path d="M7 13.5 11.5 9l2.5 2.5L17 8"></path><path d="M18 8h-3V5"></path><path d="M6 17V11"></path><path d="M10 17v-5"></path><path d="M14 17v-3"></path>',
            'handshake' => '<path d="m12.5 9.5 2-2.5a2.5 2.5 0 0 1 3.5-.38l1.88 1.51a2.5 2.5 0 0 1 .37 3.52l-3.25 3.9a2.5 2.5 0 0 1-3.56.27l-.82-.74"></path><path d="M11.5 14.5 9 17a2.5 2.5 0 0 1-3.56-.27L2.13 13a2.5 2.5 0 0 1 .37-3.52l2.13-1.72a2.5 2.5 0 0 1 3.5.29l2.37 2.7"></path><path d="M16 12.5H8.5"></path>',
            'quote'   => '<path d="M10.5 7A3.5 3.5 0 0 1 7 10.5V13a2 2 0 0 1-2 2H4v-2a5 5 0 0 1 5-5z"></path><path d="M20.5 7A3.5 3.5 0 0 1 17 10.5V13a2 2 0 0 1-2 2h-1v-2a5 5 0 0 1 5-5z"></path>',
        );

        if (! isset($icons[$icon])) {
            return '';
        }

        return sprintf(
            '<svg class="%1$s" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%2$s</svg>',
            esc_attr($class),
            $icons[$icon]
        );
    }
}

if (! function_exists('webmakerr_frontpage_logo')) {
    /**
     * Render trust badge logos.
     */
    function webmakerr_frontpage_logo(string $logo, string $class = 'h-12 w-auto')
    {
        $logos = array(
            'growthlab'  => '
                <defs>
                  <linearGradient id="growthlabGradient" x1="12" y1="4" x2="108" y2="36" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#1D4ED8" />
                    <stop offset="1" stop-color="#22D3EE" />
                  </linearGradient>
                  <linearGradient id="growthlabAccent" x1="24" y1="10" x2="96" y2="30" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#E0F2FE" />
                    <stop offset="1" stop-color="#C7D2FE" />
                  </linearGradient>
                </defs>
                <rect x="2" y="4" width="116" height="32" rx="12" fill="#F8FAFC" />
                <path d="M24 30C26 20.5 38.5 14 52 14C65.5 14 78 20.5 80 30" fill="url(#growthlabAccent)" />
                <path d="M36 26C38 18.5 45 14 52 14C59 14 66 18.5 68 26" fill="#FFFFFF" />
                <path d="M24 30C26.3 20 36 12 52 12C68 12 78.5 20 80 30" stroke="url(#growthlabGradient)" stroke-width="4" stroke-linecap="round" />
                <circle cx="52" cy="16" r="6" fill="#0F172A" />
                <path d="M48 18.5L52 24L56 18.5" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            ',
            'launchpad'  => '
                <defs>
                  <linearGradient id="launchpadTrail" x1="12" y1="8" x2="108" y2="32" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#A855F7" />
                    <stop offset="1" stop-color="#6366F1" />
                  </linearGradient>
                  <linearGradient id="launchpadGlow" x1="40" y1="6" x2="80" y2="34" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#F5F3FF" />
                    <stop offset="1" stop-color="#E0E7FF" />
                  </linearGradient>
                </defs>
                <rect x="2" y="4" width="116" height="32" rx="12" fill="#F5F3FF" />
                <path d="M30 28C34 20 46 14 60 14C74 14 86 20 90 28" stroke="url(#launchpadTrail)" stroke-width="4" stroke-linecap="round" />
                <path d="M60 10C65.5 16 69 23 69 29C69 30.2 68.9 31.3 68.8 32H51.2C51.1 31.3 51 30.2 51 29C51 23 54.5 16 60 10Z" fill="#1E1B4B" />
                <path d="M60 12C56.7 16 54 22 54 27.5C54 29.6 54.2 31.5 54.5 33H65.5C65.8 31.5 66 29.6 66 27.5C66 22 63.3 16 60 12Z" fill="url(#launchpadGlow)" />
                <circle cx="60" cy="18" r="4" fill="#312E81" />
                <path d="M44 30L60 20L76 30" stroke="#C4B5FD" stroke-width="2" stroke-linecap="round" />
                <circle cx="44" cy="30" r="3" fill="#C4B5FD" />
                <circle cx="76" cy="30" r="3" fill="#C4B5FD" />
            ',
            'convertix'  => '
                <defs>
                  <linearGradient id="convertixGradient" x1="12" y1="8" x2="108" y2="32" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#0EA5E9" />
                    <stop offset="1" stop-color="#2563EB" />
                  </linearGradient>
                </defs>
                <rect x="2" y="4" width="116" height="32" rx="12" fill="#F0F9FF" />
                <path d="M26 11L52 28" stroke="#0284C7" stroke-width="4" stroke-linecap="round" />
                <path d="M94 11L68 28" stroke="#2563EB" stroke-width="4" stroke-linecap="round" />
                <circle cx="40" cy="19" r="9" fill="#38BDF8" opacity="0.2" />
                <circle cx="80" cy="19" r="9" fill="#2563EB" opacity="0.2" />
                <path d="M40 12H80" stroke="url(#convertixGradient)" stroke-width="4" stroke-linecap="round" />
                <path d="M48 32H72" stroke="#0F172A" stroke-width="3" stroke-linecap="round" opacity="0.4" />
                <circle cx="40" cy="19" r="4" fill="#0EA5E9" />
                <circle cx="80" cy="19" r="4" fill="#2563EB" />
            ',
            'scale'      => '
                <defs>
                  <linearGradient id="scaleGradient" x1="24" y1="8" x2="92" y2="32" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#16A34A" />
                    <stop offset="1" stop-color="#22C55E" />
                  </linearGradient>
                </defs>
                <rect x="2" y="4" width="116" height="32" rx="12" fill="#ECFDF5" />
                <rect x="28" y="14" width="8" height="14" rx="3" fill="#BBF7D0" />
                <rect x="46" y="10" width="10" height="18" rx="3" fill="#86EFAC" />
                <rect x="66" y="8" width="12" height="20" rx="3" fill="#4ADE80" />
                <rect x="88" y="6" width="12" height="22" rx="3" fill="#22C55E" />
                <path d="M26 30H94" stroke="#A7F3D0" stroke-width="4" stroke-linecap="round" />
                <path d="M26 24C40 16 62 12 94 14" stroke="url(#scaleGradient)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                <circle cx="88" cy="14" r="4" fill="#15803D" />
            ',
            'brightwave' => '
                <defs>
                  <linearGradient id="brightwaveGradient" x1="16" y1="8" x2="104" y2="32" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#38BDF8" />
                    <stop offset="1" stop-color="#6366F1" />
                  </linearGradient>
                </defs>
                <rect x="2" y="4" width="116" height="32" rx="12" fill="#EEF2FF" />
                <path d="M20 26C32 18 44 14 60 14C76 14 90 18 100 26" stroke="url(#brightwaveGradient)" stroke-width="4" stroke-linecap="round" />
                <path d="M20 22C32 16 44 12 60 12C76 12 90 16 100 22" stroke="#A5B4FC" stroke-width="2" stroke-linecap="round" opacity="0.6" />
                <circle cx="36" cy="20" r="3" fill="#38BDF8" />
                <circle cx="60" cy="18" r="4" fill="#2563EB" />
                <circle cx="84" cy="20" r="3" fill="#6366F1" />
                <path d="M26 30H94" stroke="#C7D2FE" stroke-width="3" stroke-linecap="round" />
            ',
        );

        if (! isset($logos[$logo])) {
            return '';
        }

        return sprintf(
            '<svg class="%1$s" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">%2$s</svg>',
            esc_attr($class),
            $logos[$logo]
        );
    }
}

get_header();

$strategy_call_url  = home_url('/contact');
$portfolio_url      = home_url('/portfolio');
$case_study_url     = home_url('/case-study');
$toolkit_url        = home_url('/conversion-toolkit');

$strategy_call_link = webmakerr_get_popup_link_attributes($strategy_call_url, $popup_enabled);
$toolkit_link       = webmakerr_get_popup_link_attributes($toolkit_url, $popup_enabled);
?>

<main id="primary" class="flex flex-col bg-white">
  <?php while (have_posts()) : the_post(); ?>
    <section class="relative overflow-hidden border-b border-zinc-200 bg-gradient-to-b from-white via-white to-light">
      <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-primary/10 via-white/40 to-transparent blur-3xl"></div>
      <div class="relative z-10 mx-auto max-w-screen-xl px-6 pt-20 pb-24 sm:pb-28 lg:px-8 lg:pt-24 lg:pb-32">
        <div class="mx-auto flex max-w-3xl flex-col items-center gap-6 text-center">
          <span class="inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
            <?php esc_html_e('Revenue-Focused Web Partner', 'webmakerr'); ?>
          </span>
          <h1 class="mt-2 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl lg:text-6xl">
            <?php esc_html_e('We Design, Redesign, and Build Funnels That Scale Revenue.', 'webmakerr'); ?>
          </h1>
          <p class="max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg">
            <?php esc_html_e('Your growth deserves more than a brochure site—we craft conversion-led website redesigns, launch bespoke funnels, and keep your digital sales machine running 24/7.', 'webmakerr'); ?>
          </p>
          <div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:items-center sm:gap-4">
            <a class="inline-flex w-full justify-center rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url($strategy_call_link['href']); ?>"<?php echo $strategy_call_link['attributes']; ?>>
              <?php esc_html_e('Schedule Your Strategy Call', 'webmakerr'); ?>
            </a>
            <a class="inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline sm:w-auto" href="<?php echo esc_url($portfolio_url); ?>">
              <?php esc_html_e('Preview Our Results', 'webmakerr'); ?>
            </a>
          </div>
          <p class="text-xs font-medium uppercase tracking-[0.26em] text-zinc-500 sm:text-sm">
            <?php esc_html_e('Preferred by marketing leaders, founders, and teams ready to scale.', 'webmakerr'); ?>
          </p>
        </div>
      </div>
    </section>

    <section class="container mx-auto px-6 py-24 lg:px-8">
      <div class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
        <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">
          <?php esc_html_e('Services Engineered for Growth', 'webmakerr'); ?>
        </span>
        <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl lg:text-5xl">
          <?php esc_html_e('Website & Funnel Systems Built to Convert', 'webmakerr'); ?>
        </h2>
        <p class="text-base leading-7 text-zinc-600 sm:text-lg">
          <?php esc_html_e('Revenue teams rely on Webmakerr to rethink their web presence, align messaging, and deploy funnels that turn traffic into customers.', 'webmakerr'); ?>
        </p>
      </div>

      <div class="mt-14 grid gap-8 sm:grid-cols-2 xl:grid-cols-4">
        <?php
        $services = array(
            array(
                'icon'        => 'website',
                'title'       => __('Website Redesign & Conversion Makeovers', 'webmakerr'),
                'description' => __('Rearchitect your flagship pages with deep research, premium UI, and measurable lifts in pipeline.', 'webmakerr'),
            ),
            array(
                'icon'        => 'funnel',
                'title'       => __('Custom Funnel Development & Automation', 'webmakerr'),
                'description' => __('Design, test, and automate buyer journeys that move prospects from first click to closed revenue.', 'webmakerr'),
            ),
            array(
                'icon'        => 'plugin',
                'title'       => __('Website Design Systems & Integrations', 'webmakerr'),
                'description' => __('Launch modular design systems, connect your tech stack, and ensure every touchpoint stays on-brand and trackable.', 'webmakerr'),
            ),
            array(
                'icon'        => 'landing',
                'title'       => __('High-Converting Campaign Landing Pages', 'webmakerr'),
                'description' => __('Deploy data-backed landing pages engineered for launches, promos, and paid traffic that demands fast ROI.', 'webmakerr'),
            ),
        );

        foreach ($services as $service) :
            ?>
          <article class="flex h-full flex-col gap-6 rounded-[5px] border border-zinc-200 bg-white p-8 text-left shadow-sm">
            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-primary/10">
              <?php
              // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_frontpage_icon($service['icon'], 'h-8 w-8 text-primary');
              ?>
            </span>
            <div class="flex flex-col gap-3">
              <h3 class="text-xl font-semibold text-zinc-950">
                <?php echo esc_html($service['title']); ?>
              </h3>
              <p class="text-sm leading-6 text-zinc-600">
                <?php echo esc_html($service['description']); ?>
              </p>
            </div>
            <a class="mt-auto inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url(home_url('/contact-us')); ?>">
              <?php esc_html_e('Start a Project', 'webmakerr'); ?>
            </a>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="bg-light py-24">
      <div class="container mx-auto grid items-center gap-12 px-6 lg:grid-cols-[1fr_0.85fr] lg:px-8">
        <div class="flex flex-col gap-5">
          <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">
            <?php esc_html_e('Client Growth Snapshot', 'webmakerr'); ?>
          </span>
          <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl lg:text-5xl">
            <?php esc_html_e('How a SaaS Redesign Unlocked 218% More Qualified Demos.', 'webmakerr'); ?>
          </h2>
          <p class="text-base leading-7 text-zinc-600 sm:text-lg">
            <?php esc_html_e('A venture-backed SaaS company partnered with Webmakerr to overhaul their positioning, rebuild critical pages, and streamline their funnel—resulting in a 218% surge in qualified demos within six weeks.', 'webmakerr'); ?>
          </p>
          <a class="inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline sm:w-auto" href="<?php echo esc_url($case_study_url); ?>" data-case-study-modal-trigger>
            <?php esc_html_e('See the Full Case Study', 'webmakerr'); ?>
          </a>
        </div>
        <div class="relative overflow-hidden rounded-[5px] border border-zinc-200 bg-white p-8 shadow-lg">
          <div class="absolute -right-16 -top-16 h-32 w-32 rounded-full bg-primary/10 blur-2xl"></div>
          <div class="absolute -bottom-20 -left-12 h-40 w-40 rounded-full bg-dark/5 blur-3xl"></div>
          <div class="relative flex flex-col gap-6">
            <div class="flex flex-col gap-2 rounded-[5px] border border-zinc-200 bg-zinc-50 p-5">
              <p class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">
                <?php esc_html_e('Performance Highlights', 'webmakerr'); ?>
              </p>
              <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-[5px] border border-white bg-white p-4 shadow-sm">
                  <p class="text-2xl font-semibold text-zinc-950">218%</p>
                  <p class="text-xs uppercase tracking-[0.26em] text-zinc-500">
                    <?php esc_html_e('Increase in Demo Requests', 'webmakerr'); ?>
                  </p>
                </div>
                <div class="rounded-[5px] border border-white bg-white p-4 shadow-sm">
                  <p class="text-2xl font-semibold text-zinc-950">3.8x</p>
                  <p class="text-xs uppercase tracking-[0.26em] text-zinc-500">
                    <?php esc_html_e('Pipeline Efficiency ROI', 'webmakerr'); ?>
                  </p>
                </div>
              </div>
            </div>
            <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-5">
              <p class="text-sm leading-6 text-zinc-600">
                <?php esc_html_e("“Webmakerr reframed our narrative, redesigned the entire experience, and our pipeline hasn't slowed down since launch.”", 'webmakerr'); ?>
              </p>
              <p class="mt-4 text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500">
                <?php esc_html_e('Maya Ellis — VP Marketing, Launchfuel', 'webmakerr'); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="container mx-auto px-6 py-24 lg:px-8">
      <div class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
        <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">
          <?php esc_html_e('Why Teams Choose Webmakerr', 'webmakerr'); ?>
        </span>
        <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl lg:text-5xl">
          <?php esc_html_e('Strategy-Led Execution Built for Scale', 'webmakerr'); ?>
        </h2>
        <p class="text-base leading-7 text-zinc-600 sm:text-lg">
          <?php esc_html_e('We blend research, design, and funnel engineering to accelerate conversions, improve retention, and unlock new revenue streams.', 'webmakerr'); ?>
        </p>
      </div>
      <div class="mt-14 grid gap-8 lg:grid-cols-3">
        <?php
        $pillars = array(
            array(
                'icon'  => 'shield',
                'title' => __('Strategy First — Every Decision Backed by Data.', 'webmakerr'),
                'copy'  => __('We audit analytics, customer journeys, and competitive messaging before we design the first component.', 'webmakerr'),
            ),
            array(
                'icon'  => 'growth',
                'title' => __('Conversion Engineered — Built for Measurable Growth.', 'webmakerr'),
                'copy'  => __('Modular funnels, relentless testing, and CRO best practices are embedded into every milestone.', 'webmakerr'),
            ),
            array(
                'icon'  => 'handshake',
                'title' => __('Partnership Driven — Momentum Beyond Launch.', 'webmakerr'),
                'copy'  => __('We integrate with your team post-launch to optimize campaigns, improve ops, and keep revenue climbing.', 'webmakerr'),
            ),
        );

        foreach ($pillars as $pillar) :
            ?>
          <div class="flex h-full flex-col gap-5 rounded-[5px] border border-zinc-200 bg-white p-8 text-center shadow-sm">
            <span class="mx-auto inline-flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
              <?php
              // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_frontpage_icon($pillar['icon'], 'h-9 w-9 text-primary');
              ?>
            </span>
            <h3 class="text-lg font-semibold text-zinc-950">
              <?php echo esc_html($pillar['title']); ?>
            </h3>
            <p class="text-sm leading-6 text-zinc-600">
              <?php echo esc_html($pillar['copy']); ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="container mx-auto px-6 py-24 lg:px-8">
      <div class="relative overflow-hidden rounded-[5px] border border-zinc-900/20 bg-zinc-950 px-8 py-16 text-center text-white shadow-lg sm:px-12">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.08),_transparent_60%)]"></div>
        <div class="relative mx-auto flex max-w-3xl flex-col gap-6">
          <span class="text-xs font-semibold uppercase tracking-[0.26em] text-white/70">
            <?php esc_html_e('Take the Next Step', 'webmakerr'); ?>
          </span>
          <h2 class="text-3xl font-semibold sm:text-4xl">
            <?php esc_html_e("Let's Build Your Highest-Converting Website Yet.", 'webmakerr'); ?>
          </h2>
          <p class="text-base leading-7 text-white/80 sm:text-lg">
            <?php esc_html_e('Book a strategy session to receive a tailored roadmap covering website design, redesign opportunities, and funnel plays built for your goals.', 'webmakerr'); ?>
          </p>
          <div class="flex justify-center">
            <a class="inline-flex items-center justify-center rounded border border-transparent bg-white px-5 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-white/90 !no-underline" href="<?php echo esc_url($strategy_call_link['href']); ?>"<?php echo $strategy_call_link['attributes']; ?>>
              <?php esc_html_e('Claim Your Strategy Session', 'webmakerr'); ?>
            </a>
          </div>
          <p class="text-xs font-medium uppercase tracking-[0.26em] text-white/60">
            <?php esc_html_e('Limited availability — reserve your session in under 60 seconds.', 'webmakerr'); ?>
          </p>
        </div>
      </div>
    </section>

    <section class="container mx-auto px-6 py-24 lg:px-8">
      <div class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
        <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">
          <?php esc_html_e('Client Proof', 'webmakerr'); ?>
        </span>
        <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl lg:text-5xl">
          <?php esc_html_e('What Growth Leaders Say About Webmakerr', 'webmakerr'); ?>
        </h2>
        <p class="text-base leading-7 text-zinc-600 sm:text-lg">
          <?php esc_html_e('Real teams rely on Webmakerr to relaunch websites, orchestrate funnels, and keep qualified leads flowing in.', 'webmakerr'); ?>
        </p>
      </div>
      <div class="mt-14 grid gap-8 md:grid-cols-3">
        <?php
        $testimonials = array(
            array(
                'quote' => __('“In four weeks our refreshed funnel generated 137% more booked calls. The Webmakerr crew tracked every lever.”', 'webmakerr'),
                'name'  => __('Jordan Blake', 'webmakerr'),
                'role'  => __('Founder, GrowthLab Media', 'webmakerr'),
            ),
            array(
                'quote' => __('“Our ecommerce redesign plus automation rollout pushed revenue up 62% and gave us clear visibility into every stage.”', 'webmakerr'),
                'name'  => __('Elena Ruiz', 'webmakerr'),
                'role'  => __('CMO, Brightwave Living', 'webmakerr'),
            ),
            array(
                'quote' => __('“They plugged into our team like seasoned operators—strategic, proactive, and accountable to growth metrics.”', 'webmakerr'),
                'name'  => __('Marcus Lee', 'webmakerr'),
                'role'  => __('Head of Demand Gen, Convertix', 'webmakerr'),
            ),
        );

        foreach ($testimonials as $testimonial) :
            ?>
          <figure class="flex h-full flex-col gap-6 rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
              <?php
              // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_frontpage_icon('quote', 'h-5 w-5 text-primary');
              ?>
            </span>
            <blockquote class="text-sm leading-6 text-zinc-600">
              <?php echo esc_html($testimonial['quote']); ?>
            </blockquote>
            <figcaption class="text-left">
              <p class="text-sm font-semibold text-zinc-950">
                <?php echo esc_html($testimonial['name']); ?>
              </p>
              <p class="text-xs uppercase tracking-[0.26em] text-zinc-500">
                <?php echo esc_html($testimonial['role']); ?>
              </p>
            </figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="bg-light py-24">
      <div class="container mx-auto grid gap-12 px-6 text-center lg:grid-cols-[1.1fr_0.9fr] lg:px-8 lg:text-left">
        <div class="flex flex-col gap-5">
          <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">
            <?php esc_html_e('Conversion Toolkit', 'webmakerr'); ?>
          </span>
          <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl lg:text-5xl">
            <?php esc_html_e('Get the Website Conversion Toolkit We Use With Clients.', 'webmakerr'); ?>
          </h2>
          <p class="text-base leading-7 text-zinc-600 sm:text-lg">
            <?php esc_html_e('Steal the checklists, templates, and CRO frameworks our strategists deploy on every website and funnel engagement.', 'webmakerr'); ?>
          </p>
          <div class="flex flex-col items-center gap-4 sm:flex-row sm:justify-start">
            <a class="inline-flex w-full justify-center rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url($toolkit_link['href']); ?>"<?php echo $toolkit_link['attributes']; ?>>
              <?php esc_html_e('Access the Free Toolkit', 'webmakerr'); ?>
            </a>
            <p class="text-xs uppercase tracking-[0.26em] text-zinc-500">
              <?php esc_html_e('Instant download • 100% actionable', 'webmakerr'); ?>
            </p>
          </div>
        </div>
        <div class="relative overflow-hidden rounded-[5px] border border-zinc-200 bg-white p-8 shadow-lg">
          <div class="absolute -left-12 -top-16 h-32 w-32 rounded-full bg-primary/10 blur-3xl"></div>
          <div class="absolute -bottom-16 -right-16 h-36 w-36 rounded-full bg-dark/5 blur-3xl"></div>
          <div class="relative flex flex-col gap-4 text-left">
            <h3 class="text-sm font-semibold uppercase tracking-[0.26em] text-primary">
              <?php esc_html_e('Inside the Toolkit', 'webmakerr'); ?>
            </h3>
            <ul class="grid gap-3 text-sm leading-6 text-zinc-600">
              <li class="flex items-start gap-3">
                <span class="mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary">
                  <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 7 5.5 9.5 11 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
                <span><?php esc_html_e('Funnel blueprints for webinars, launches, and SaaS demos that convert.', 'webmakerr'); ?></span>
              </li>
              <li class="flex items-start gap-3">
                <span class="mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary">
                  <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 7 5.5 9.5 11 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
                <span><?php esc_html_e('Optimization scorecards to prioritize the highest-impact improvements fast.', 'webmakerr'); ?></span>
              </li>
              <li class="flex items-start gap-3">
                <span class="mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary">
                  <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 7 5.5 9.5 11 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
                <span><?php esc_html_e('Messaging and copy frameworks aligned to every buyer stage.', 'webmakerr'); ?></span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; ?>
</main>

<?php
get_template_part('templates/partials/case-study-modal');
webmakerr_render_template_popup($popup_settings);
get_footer();
