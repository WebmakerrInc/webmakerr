<?php
/**
 * Template Name: Case Study
 */

if (! defined('ABSPATH')) {
    exit;
}

$popup_settings      = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled       = (bool) ($popup_settings['enabled'] ?? false);
$strategy_call_url   = home_url('/contact');
$strategy_call_link  = webmakerr_get_popup_link_attributes($strategy_call_url, $popup_enabled);

get_header();
?>

<main id="primary" class="bg-white">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('flex flex-col gap-24 pb-24'); ?>>
      <section class="relative overflow-hidden border-b border-zinc-200 bg-gradient-to-br from-white via-white to-primary/5">
        <div class="absolute inset-y-0 left-0 hidden w-1/3 bg-gradient-to-r from-primary/10 via-transparent to-transparent lg:block"></div>
        <div class="container mx-auto grid gap-12 px-6 py-20 lg:grid-cols-[1.1fr_0.9fr] lg:px-8 lg:py-24">
          <div class="relative z-10 flex flex-col gap-6">
            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
              <?php esc_html_e('Case Study', 'webmakerr'); ?>
            </span>
            <h1 class="text-4xl font-semibold text-zinc-950 sm:text-5xl lg:text-6xl">
              <?php esc_html_e('Launchfuel SaaS Growth Transformation', 'webmakerr'); ?>
            </h1>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('Rearchitecting the marketing site, funnel experience, and positioning to create a unified growth engine.', 'webmakerr'); ?>
            </p>
            <div class="grid gap-6 sm:grid-cols-2">
              <div class="rounded-[5px] border border-primary/20 bg-white px-5 py-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.26em] text-primary"><?php esc_html_e('Industry', 'webmakerr'); ?></p>
                <p class="mt-2 text-base font-medium text-zinc-950"><?php esc_html_e('B2B SaaS', 'webmakerr'); ?></p>
              </div>
              <div class="rounded-[5px] border border-primary/20 bg-white px-5 py-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.26em] text-primary"><?php esc_html_e('Services', 'webmakerr'); ?></p>
                <p class="mt-2 text-base font-medium text-zinc-950"><?php esc_html_e('Website Redesign, Funnel Build, CRO', 'webmakerr'); ?></p>
              </div>
            </div>
          </div>
          <div class="relative z-10 flex items-center justify-center">
            <div class="mx-auto w-full max-w-xl overflow-hidden rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-xl ring-1 ring-black/5 md:mx-0">
              <svg class="h-auto w-full" viewBox="0 0 420 320" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Data visualization showing compound growth metrics">
                <defs>
                  <linearGradient id="heroGradient" x1="64" y1="36" x2="360" y2="292" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#FFFFFF" />
                    <stop offset="1" stop-color="#F4F4F5" />
                  </linearGradient>
                  <linearGradient id="accentGradient" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#2563EB" />
                    <stop offset="1" stop-color="#0EA5E9" />
                  </linearGradient>
                  <linearGradient id="barGradient" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#1E293B" stop-opacity="0.12" />
                    <stop offset="1" stop-color="#1E293B" stop-opacity="0.04" />
                  </linearGradient>
                  <clipPath id="chartClip">
                    <rect x="84" y="96" width="236" height="132" rx="16" />
                  </clipPath>
                </defs>
                <rect x="36" y="28" width="348" height="264" rx="28" fill="url(#heroGradient)" stroke="#D4D4D8" stroke-width="1.5" />
                <rect x="60" y="56" width="300" height="212" rx="22" fill="#FFFFFF" stroke="#E4E4E7" stroke-width="1.5" />
                <g clip-path="url(#chartClip)">
                  <rect x="84" y="96" width="236" height="132" rx="16" fill="#F8FAFC" />
                  <path d="M108 204H304" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" />
                  <path d="M108 180H304" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" stroke-dasharray="4 8" />
                  <path d="M108 156H304" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" />
                  <path d="M108 132H304" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" stroke-dasharray="4 8" />
                  <path d="M132 108V228" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" />
                  <path d="M168 108V228" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" />
                  <path d="M204 108V228" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" />
                  <path d="M240 108V228" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" />
                  <path d="M276 108V228" stroke="#E4E4E7" stroke-width="1.5" stroke-linecap="round" />
                  <path d="M116 212L156 192L192 202L228 170L260 150L292 128" stroke="url(#accentGradient)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M292 128L312 146L320 124" stroke="#2563EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                  <circle cx="156" cy="192" r="5" fill="#2563EB" />
                  <circle cx="228" cy="170" r="5" fill="#2563EB" />
                  <circle cx="292" cy="128" r="6" fill="#2563EB" stroke="#FFFFFF" stroke-width="2" />
                </g>
                <rect x="84" y="246" width="84" height="40" rx="12" fill="#FFFFFF" stroke="#E4E4E7" stroke-width="1.5" />
                <rect x="180" y="246" width="84" height="40" rx="12" fill="#FFFFFF" stroke="#E4E4E7" stroke-width="1.5" />
                <rect x="276" y="246" width="84" height="40" rx="12" fill="#111827" fill-opacity="0.92" stroke="#0F172A" stroke-width="1.5" />
                <text x="102" y="270" fill="#0F172A" font-family="'Roboto', 'Inter', sans-serif" font-size="12" font-weight="600">Visitors</text>
                <text x="198" y="270" fill="#0F172A" font-family="'Roboto', 'Inter', sans-serif" font-size="12" font-weight="600">SQLs</text>
                <text x="290" y="270" fill="#FFFFFF" font-family="'Roboto', 'Inter', sans-serif" font-size="12" font-weight="600">Wins</text>
                <text x="102" y="286" fill="#4B5563" font-family="'Roboto', 'Inter', sans-serif" font-size="11" font-weight="500">+182%</text>
                <text x="198" y="286" fill="#4B5563" font-family="'Roboto', 'Inter', sans-serif" font-size="11" font-weight="500">+94%</text>
                <text x="290" y="286" fill="#FFFFFF" font-family="'Roboto', 'Inter', sans-serif" font-size="11" font-weight="500">+38%</text>
                <g>
                  <rect x="96" y="72" width="62" height="44" rx="12" fill="#111827" fill-opacity="0.04" stroke="#D4D4D8" stroke-width="1.5" />
                  <text x="108" y="94" fill="#0F172A" font-family="'Roboto', 'Inter', sans-serif" font-size="11" font-weight="600">ARR Trend</text>
                  <text x="108" y="108" fill="#2563EB" font-family="'Playfair Display', 'Georgia', serif" font-size="18" font-weight="600">$2.4M</text>
                </g>
                <g>
                  <rect x="176" y="72" width="110" height="44" rx="12" fill="#111827" fill-opacity="0.04" stroke="#D4D4D8" stroke-width="1.5" />
                  <text x="188" y="94" fill="#0F172A" font-family="'Roboto', 'Inter', sans-serif" font-size="11" font-weight="600">Acquisition Velocity</text>
                  <path d="M192 104H222" stroke="#2563EB" stroke-width="3" stroke-linecap="round" />
                  <path d="M232 104H268" stroke="#CBD5F5" stroke-width="3" stroke-linecap="round" />
                </g>
                <g>
                  <rect x="304" y="72" width="56" height="44" rx="12" fill="#2563EB" fill-opacity="0.12" stroke="#2563EB" stroke-width="1.5" />
                  <path d="M316 104L326 92L338 112" stroke="#2563EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                  <circle cx="326" cy="92" r="4" fill="#2563EB" />
                </g>
                <g>
                  <rect x="108" y="180" width="24" height="48" rx="8" fill="url(#barGradient)" stroke="#CBD5F5" stroke-width="1.5" />
                  <rect x="148" y="168" width="24" height="60" rx="8" fill="url(#barGradient)" stroke="#CBD5F5" stroke-width="1.5" />
                  <rect x="188" y="152" width="24" height="76" rx="8" fill="url(#barGradient)" stroke="#CBD5F5" stroke-width="1.5" />
                  <rect x="228" y="132" width="24" height="96" rx="8" fill="url(#barGradient)" stroke="#CBD5F5" stroke-width="1.5" />
                  <rect x="268" y="116" width="24" height="112" rx="8" fill="url(#barGradient)" stroke="#CBD5F5" stroke-width="1.5" />
                </g>
                <g>
                  <rect x="246" y="40" width="112" height="32" rx="16" fill="#111827" fill-opacity="0.9" />
                  <text x="262" y="62" fill="#FFFFFF" font-family="'Roboto', 'Inter', sans-serif" font-size="12" font-weight="600">Conversion Rate</text>
                  <text x="358" y="62" fill="#A5B4FC" font-family="'Roboto', 'Inter', sans-serif" font-size="12" font-weight="600">+4.8%</text>
                </g>
              </svg>
            </div>
          </div>
        </div>
      </section>

      <section class="container mx-auto grid gap-10 px-6 lg:grid-cols-[0.45fr_0.55fr] lg:items-center lg:px-8">
        <div class="flex items-center justify-center">
          <div class="flex h-full w-full max-w-xs flex-col items-center justify-center gap-4 rounded-2xl border border-zinc-200 bg-white/90 p-8 text-center shadow-sm">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-primary">
              <span class="text-xl font-semibold">LF</span>
            </div>
            <p class="text-base font-medium text-zinc-950"><?php esc_html_e('Launchfuel', 'webmakerr'); ?></p>
            <p class="text-sm leading-6 text-zinc-600"><?php esc_html_e('Venture-backed SaaS platform for marketing automation teams.', 'webmakerr'); ?></p>
          </div>
        </div>
        <div class="flex flex-col gap-4">
          <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
            <?php esc_html_e('About the Client', 'webmakerr'); ?>
          </h2>
          <p class="text-base leading-7 text-zinc-600 sm:text-lg">
            <?php esc_html_e('Launchfuel equips distributed marketing teams with an automation layer that helps them orchestrate campaigns faster. Rapid growth exposed cracks in their messaging, sales collateral, and product-story alignment.', 'webmakerr'); ?>
          </p>
          <p class="text-base leading-7 text-zinc-600 sm:text-lg">
            <?php esc_html_e('They came to Webmakerr for a conversion-first rebuild: unifying brand narrative, rebuilding the funnel, and delivering a scalable system their team could own.', 'webmakerr'); ?>
          </p>
        </div>
      </section>

      <section class="container mx-auto flex flex-col gap-6 px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
          <?php esc_html_e('The Challenge', 'webmakerr'); ?>
        </h2>
        <p class="max-w-3xl text-base leading-7 text-zinc-600 sm:text-lg">
          <?php esc_html_e('A dated site structure forced buyers through disconnected pages, while inconsistent copy undercut Launchfuel’s category leadership. Product tours were buried, demo requests were low intent, and teams struggled to track performance.', 'webmakerr'); ?>
        </p>
      </section>

      <section class="container mx-auto flex flex-col gap-6 px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
          <?php esc_html_e('The Solution', 'webmakerr'); ?>
        </h2>
        <ol class="max-w-4xl list-decimal space-y-4 pl-6 text-base leading-7 text-zinc-600 sm:text-lg">
          <li><?php esc_html_e('Architected a modular site map anchored in the buyer journey with clear conversion milestones.', 'webmakerr'); ?></li>
          <li><?php esc_html_e('Developed narrative-driven copy and Playfair-led headings to reinforce premium positioning.', 'webmakerr'); ?></li>
          <li><?php esc_html_e('Implemented rapid CRO testing: hero variants, pricing experiments, and retargeting pages.', 'webmakerr'); ?></li>
          <li><?php esc_html_e('Integrated CRM automations, analytics dashboards, and lead-scoring workflows.', 'webmakerr'); ?></li>
        </ol>
      </section>

      <section class="container mx-auto flex flex-col gap-8 px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
          <?php esc_html_e('The Results', 'webmakerr'); ?>
        </h2>
        <div class="grid gap-6 sm:grid-cols-3">
          <div class="rounded-[5px] border border-zinc-200 bg-white p-6 text-center shadow-sm">
            <p class="text-3xl font-semibold text-primary">218%</p>
            <p class="mt-2 text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Increase in Qualified Demos', 'webmakerr'); ?></p>
          </div>
          <div class="rounded-[5px] border border-zinc-200 bg-white p-6 text-center shadow-sm">
            <p class="text-3xl font-semibold text-primary">3.8x</p>
            <p class="mt-2 text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Pipeline ROI', 'webmakerr'); ?></p>
          </div>
          <div class="rounded-[5px] border border-zinc-200 bg-white p-6 text-center shadow-sm">
            <p class="text-3xl font-semibold text-primary">42%</p>
            <p class="mt-2 text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Growth in Paid Conversions', 'webmakerr'); ?></p>
          </div>
        </div>
      </section>

      <section class="container mx-auto flex flex-col gap-8 px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
          <?php esc_html_e('Visual Proof', 'webmakerr'); ?>
        </h2>
        <?php
        get_template_part('templates/partials/case-study-visual-proof');
        ?>
      </section>

        <section class="container mx-auto px-6 lg:px-8">
          <div class="relative overflow-hidden rounded-[5px] border border-zinc-900/20 bg-zinc-950 px-8 py-16 text-center text-white shadow-lg sm:px-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.08),_transparent_60%)]"></div>
            <div class="relative mx-auto flex max-w-3xl flex-col gap-6">
              <span class="text-xs font-semibold uppercase tracking-[0.26em] text-white/70"><?php esc_html_e('Want results like this?', 'webmakerr'); ?></span>
              <h2 class="text-3xl font-semibold sm:text-4xl">
                <?php esc_html_e('Book your free call and get a tailored growth roadmap.', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-white/80 sm:text-lg">
                <?php esc_html_e('We’ll audit your funnel, uncover the conversion gaps, and map your next launch so you can scale with confidence.', 'webmakerr'); ?>
              </p>
              <div class="flex justify-center">
                <a class="inline-flex items-center justify-center rounded bg-white px-5 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-white/90 !no-underline" href="<?php echo esc_url($strategy_call_link['href']); ?>"<?php echo $strategy_call_link['attributes']; ?>>
                  <?php esc_html_e('Book Free Call', 'webmakerr'); ?>
                </a>
              </div>
              <p class="text-xs font-medium uppercase tracking-[0.26em] text-white/60"><?php esc_html_e('Spots fill quickly — secure your time in under 60 seconds.', 'webmakerr'); ?></p>
            </div>
          </div>
        </section>
    </article>
  <?php endwhile; ?>
</main>

<?php
webmakerr_render_template_popup($popup_settings);
get_footer();
