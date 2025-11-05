<?php
/**
 * Template Name: Funnel - Website Design
 * Description: High-conversion funnel page for the Website Design service.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (! function_exists('webmakerr_funnel_icon')) {
    /**
     * Render SVG icons for the funnel template accents.
     */
    function webmakerr_funnel_icon($name, $class = 'h-6 w-6')
    {
        $icons = array(
            'arrow-right' => '<path d="M5 12h14"></path><path d="m13 5 7 7-7 7"></path>',
            'compass' => '<circle cx="12" cy="12" r="10"></circle><path d="m16.24 7.76-2.12 5.09-5.09 2.12 2.12-5.09z"></path><circle cx="12" cy="12" r="1"></circle>',
            'layers' => '<path d="m12 2 9 4.5-9 4.5L3 6.5 12 2Z"></path><path d="m3 11 9 4.5L21 11"></path><path d="m3 15 9 4.5L21 15"></path>',
            'rocket' => '<path d="M4.5 16.5c-1.5-1.5-2.915-5.086-2.915-5.086S5.086 9.5 6.5 8.086C8 6.586 14 2 20 2c0 6-4.586 12-6.086 13.5C12.5 16.914 7.5 20.5 7.5 20.5S6 19 4.5 17.5" ></path><path d="M15 9l-3 3"></path><path d="M9 15l-2.5 2.5"></path><path d="M9.5 12.5 5 8"></path>',
            'sparkle' => '<path d="M12 3v4"></path><path d="M12 17v4"></path><path d="M3 12h4"></path><path d="M17 12h4"></path><path d="M18.36 5.64 16 8"></path><path d="M8 16 5.64 18.36"></path><path d="m5.64 5.64 2.36 2.36"></path><path d="M16 16l2.36 2.36"></path><circle cx="12" cy="12" r="2"></circle>',
            'target' => '<path d="M21 12h1"></path><path d="M12 3v1"></path><path d="M12 20v1"></path><path d="M3 12h1"></path><circle cx="12" cy="12" r="7"></circle><circle cx="12" cy="12" r="3"></circle>',
            'check' => '<path d="M5 12.5 9 16.5 19 6.5"></path><path d="M21 12A9 9 0 1 1 12 3"></path>'
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

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-zinc-900 antialiased'); ?>>
<?php do_action('webmakerr_site_before'); ?>
<?php wp_body_open(); ?>
<div id="page" class="flex min-h-screen flex-col bg-white">
  <?php do_action('webmakerr_header'); ?>

  <div id="content" class="site-content flex flex-1 flex-col">
    <?php do_action('webmakerr_content_start'); ?>

    <main id="primary" class="flex flex-col bg-white pb-32 lg:pb-0">
      <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
          <div class="flex flex-shrink-0 items-center">
            <?php
            if (function_exists('the_custom_logo') && has_custom_logo()) {
                the_custom_logo();
            } else {
                printf(
                    '<a href="%1$s" class="text-lg font-semibold text-slate-900 no-underline">%2$s</a>',
                    esc_url(home_url('/')),
                    esc_html(get_bloginfo('name'))
                );
            }
            ?>
          </div>
          <a class="inline-flex shrink-0 items-center justify-center rounded-[5px] border border-transparent bg-white px-5 py-2.5 text-sm font-semibold text-zinc-900 shadow-sm transition hover:bg-gray-100 hover:text-zinc-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white !no-underline" href="#strategy-call">
            <?php esc_html_e('Book a Free Strategy Call', 'webmakerr'); ?>
          </a>
        </div>
      </header>

      <section class="relative overflow-hidden bg-[#18184d] py-20 text-white sm:py-24">
        <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-b from-white/10 via-transparent to-transparent blur-3xl"></div>
        <div class="relative mx-auto w-full max-w-6xl px-4 lg:px-8">
          <div class="grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="flex flex-col gap-6">
              <span class="inline-flex w-fit items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-white/80">
                <?php esc_html_e('Website Design Services', 'webmakerr'); ?>
              </span>
              <h1 class="max-w-3xl text-4xl font-medium tracking-tight [text-wrap:balance] sm:text-5xl lg:text-6xl">
                <?php esc_html_e('Get a Website That Converts Visitors Into Customers', 'webmakerr'); ?>
              </h1>
              <p class="max-w-2xl text-base leading-7 text-white/90 sm:text-lg">
                <?php esc_html_e('We craft conversion-optimized websites that elevate your credibility, sharpen your message, and deliver measurable growth.', 'webmakerr'); ?>
              </p>
              <div class="flex flex-col items-start gap-3 sm:flex-row">
                <a class="inline-flex items-center justify-center rounded-[5px] border border-transparent bg-white px-6 py-3 text-sm font-semibold text-zinc-900 shadow-sm transition hover:bg-gray-100 hover:text-zinc-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white !no-underline" href="#strategy-call">
                  <?php esc_html_e('Book a Free Strategy Call', 'webmakerr'); ?>
                </a>
              </div>
              <p class="text-xs font-medium uppercase tracking-[0.26em] text-white/80 sm:text-sm">
                <?php esc_html_e('Trusted by growth teams across SaaS, ecommerce, and professional services', 'webmakerr'); ?>
              </p>
            </div>

            <div class="rounded-[6px] border border-white/20 bg-white/10 p-8 shadow-lg shadow-black/20 backdrop-blur">
              <ul class="flex flex-col gap-6 text-left text-sm text-white/90">
                <li class="flex items-start gap-4">
                  <span class="mt-0.5 text-primary">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webmakerr_funnel_icon('check', 'h-5 w-5 text-primary');
                    ?>
                  </span>
                  <span><?php esc_html_e('Strategic positioning, story, and UX mapped to every buying journey.', 'webmakerr'); ?></span>
                </li>
                <li class="flex items-start gap-4">
                  <span class="mt-0.5 text-primary">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webmakerr_funnel_icon('sparkle', 'h-5 w-5 text-primary');
                    ?>
                  </span>
                  <span><?php esc_html_e('Tailored design system using Playfair Display & Roboto for premium clarity.', 'webmakerr'); ?></span>
                </li>
                <li class="flex items-start gap-4">
                  <span class="mt-0.5 text-primary">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webmakerr_funnel_icon('target', 'h-5 w-5 text-primary');
                    ?>
                  </span>
                  <span><?php esc_html_e('Launch-ready builds with technical SEO, performance, and analytics baked in.', 'webmakerr'); ?></span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <section class="mx-auto w-full max-w-6xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
        <div class="mx-auto flex max-w-3xl flex-col items-center gap-4 text-center">
          <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-primary">
            <?php esc_html_e('Why it matters', 'webmakerr'); ?>
          </span>
          <h2 class="text-3xl font-semibold text-slate-900 sm:text-4xl">
            <span class="inline-flex items-center gap-3">
              <?php
              // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_funnel_icon('target', 'h-7 w-7 text-primary');
              ?>
              <?php esc_html_e('Stop Losing Clients to Outdated Websites.', 'webmakerr'); ?>
            </span>
          </h2>
          <p class="mt-2 text-base leading-7 text-slate-600 sm:text-lg">
            <?php esc_html_e('Pair persuasive storytelling with a high-performance site experience. We transform dated layouts into conversion engines that win trust and book more calls.', 'webmakerr'); ?>
          </p>
        </div>
      </section>

      <section class="bg-slate-50">
        <div class="mx-auto w-full max-w-6xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
          <div class="mx-auto flex max-w-3xl flex-col items-center gap-4 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-primary">
              <?php esc_html_e('Process', 'webmakerr'); ?>
            </span>
            <h2 class="text-3xl font-semibold text-slate-900 sm:text-4xl">
              <span class="inline-flex items-center gap-3">
                <?php
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webmakerr_funnel_icon('compass', 'h-7 w-7 text-primary');
                ?>
                <?php esc_html_e('Our 3-Step Process', 'webmakerr'); ?>
              </span>
            </h2>
          </div>
          <div class="mt-12 grid gap-6 md:grid-cols-3">
            <?php
            $process_steps = [
              [
                'title'       => __('Discovery', 'webmakerr'),
                'description' => __('Deep-dive strategy sessions uncover your audience, offers, and conversion goals.', 'webmakerr'),
                'icon'        => 'sparkle',
              ],
              [
                'title'       => __('Design', 'webmakerr'),
                'description' => __('We create premium visuals, messaging, and flows that build trust on every page.', 'webmakerr'),
                'icon'        => 'layers',
              ],
              [
                'title'       => __('Launch', 'webmakerr'),
                'description' => __('Development, performance optimization, and QA deliver a seamless go-live.', 'webmakerr'),
                'icon'        => 'rocket',
              ],
            ];

            foreach ($process_steps as $step) :
                ?>
              <div class="flex h-full flex-col gap-5 rounded-[6px] border border-slate-200 bg-white p-6 shadow-sm">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                  <?php
                  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  echo webmakerr_funnel_icon($step['icon'], 'h-6 w-6 text-primary');
                  ?>
                </span>
                <h3 class="text-xl font-semibold text-slate-900">
                  <?php echo esc_html($step['title']); ?>
                </h3>
                <p class="text-base leading-7 text-slate-600">
                  <?php echo esc_html($step['description']); ?>
                </p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="mx-auto w-full max-w-6xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
        <div class="mx-auto flex max-w-3xl flex-col items-center gap-4 text-center">
          <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-primary">
            <?php esc_html_e('Outcomes', 'webmakerr'); ?>
          </span>
          <h2 class="text-3xl font-semibold text-slate-900 sm:text-4xl">
            <span class="inline-flex items-center gap-3">
              <?php
              // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              echo webmakerr_funnel_icon('arrow-right', 'h-7 w-7 text-primary');
              ?>
              <?php esc_html_e('Proof That Design Moves Metrics', 'webmakerr'); ?>
            </span>
          </h2>
          <p class="mt-2 text-base leading-7 text-slate-600 sm:text-lg">
            <?php esc_html_e('Fast launches, measurable results. Here’s how Webmakerr websites outperform outdated builds.', 'webmakerr'); ?>
          </p>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
          <?php
          $case_studies = [
            [
              'title'   => __('Tech Startup', 'webmakerr'),
              'result'  => __('+64% demo requests in six weeks.', 'webmakerr'),
              'summary' => __('Streamlined narrative, faster UX, and proof-driven pages accelerated pipeline growth.', 'webmakerr'),
              'icon'    => 'sparkle',
            ],
            [
              'title'   => __('Ecommerce Brand', 'webmakerr'),
              'result'  => __('42% revenue lift post-launch.', 'webmakerr'),
              'summary' => __('Conversion-led product storytelling and optimized checkout increased average order value.', 'webmakerr'),
              'icon'    => 'layers',
            ],
            [
              'title'   => __('Professional Services', 'webmakerr'),
              'result'  => __('3× qualified consultations booked.', 'webmakerr'),
              'summary' => __('Authority-building layouts and social proof re-established trust for high-ticket clients.', 'webmakerr'),
              'icon'    => 'rocket',
            ],
          ];

          foreach ($case_studies as $case) :
              ?>
            <div class="flex h-full flex-col gap-5 rounded-[6px] border border-slate-200 bg-white p-6 shadow-sm">
              <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                <?php
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webmakerr_funnel_icon($case['icon'], 'h-6 w-6 text-primary');
                ?>
              </span>
              <div class="flex flex-col gap-2">
                <h3 class="text-xl font-semibold text-slate-900">
                  <?php echo esc_html($case['title']); ?>
                </h3>
                <p class="text-base font-semibold text-slate-900">
                  <?php echo esc_html($case['result']); ?>
                </p>
              </div>
              <p class="text-base leading-7 text-slate-600">
                <?php echo esc_html($case['summary']); ?>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <section id="strategy-call" class="bg-slate-50">
        <div class="mx-auto w-full max-w-4xl px-4 py-20 text-center sm:px-6 lg:px-8 lg:py-24">
          <div class="mx-auto flex max-w-2xl flex-col gap-4">
            <span class="inline-flex items-center gap-2 self-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-primary">
              <?php esc_html_e('Book a call', 'webmakerr'); ?>
            </span>
            <h2 class="text-3xl font-semibold text-slate-900 sm:text-4xl">
              <?php esc_html_e('Book Your Free Website Strategy Call', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-slate-600 sm:text-lg">
              <?php esc_html_e('We’ll review your goals, identify conversion wins, and outline the roadmap for your next launch.', 'webmakerr'); ?>
            </p>
          </div>
          <div class="mx-auto mt-12 max-w-2xl rounded-[6px] border border-slate-200 bg-white p-6 shadow-sm">
            <?php echo do_shortcode('[fluent_booking id="1"]'); ?>
          </div>
        </div>
      </section>

      <section class="py-16 sm:py-20 lg:py-24">
        <div class="mx-auto w-full max-w-4xl px-4 sm:px-6 lg:px-8">
          <header class="flex flex-col gap-4 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary">
              <?php esc_html_e('FAQ', 'webmakerr'); ?>
            </span>
            <h2 class="text-3xl font-semibold text-slate-900 sm:text-4xl">
              <?php esc_html_e('Frequently Asked Questions', 'webmakerr'); ?>
            </h2>
          </header>
          <div class="mt-12 space-y-4">
            <?php
            $faqs = [
              [
                'question' => __('How long does a project take?', 'webmakerr'),
                'answer'   => __('Most custom website projects launch within 6–8 weeks. You’ll have a dedicated team, weekly updates, and crystal-clear milestones.', 'webmakerr'),
              ],
              [
                'question' => __('What investment should we expect?', 'webmakerr'),
                'answer'   => __('High-conversion builds start at $6K. Every scope includes strategy, design, development, and launch support tailored to your goals.', 'webmakerr'),
              ],
              [
                'question' => __('Do you help with content, SEO, and hosting?', 'webmakerr'),
                'answer'   => __('Yes—our team guides copy, assets, technical SEO, and hosting so your new site launches fast, secure, and ready to scale.', 'webmakerr'),
              ],
            ];

            foreach ($faqs as $faq) :
                ?>
              <details class="group overflow-hidden rounded-[6px] border border-slate-200 bg-white shadow-sm">
                <summary class="flex cursor-pointer items-center justify-between gap-6 px-6 py-4 text-left text-base font-semibold text-slate-900">
                  <span class="flex items-center gap-3">
                    <span class="text-primary">
                      <?php
                      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_funnel_icon('arrow-right', 'h-5 w-5 text-primary');
                      ?>
                    </span>
                    <?php echo esc_html($faq['question']); ?>
                  </span>
                  <span class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition group-open:rotate-45">
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M8 3.25V12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M12.75 8H3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </span>
                </summary>
                <div class="px-6 pb-6 text-sm leading-6 text-slate-600">
                  <?php echo esc_html($faq['answer']); ?>
                </div>
              </details>
              <?php
            endforeach;
            ?>
          </div>
        </div>
      </section>
    </main>

    <?php do_action('webmakerr_content_end'); ?>
  </div>

  <?php do_action('webmakerr_content_after'); ?>

  <div class="sm:hidden">
    <div class="fixed inset-x-0 bottom-0 z-40 bg-white/95 px-6 pb-6 pt-4 shadow-[0_-8px_24px_rgba(15,23,42,0.12)] backdrop-blur">
      <a class="inline-flex w-full items-center justify-center rounded-[5px] border border-transparent bg-white px-6 py-3 text-sm font-semibold text-zinc-900 shadow-sm transition hover:bg-gray-100 hover:text-zinc-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white !no-underline" href="#strategy-call">
        <?php esc_html_e('Book a Free Strategy Call', 'webmakerr'); ?>
      </a>
    </div>
  </div>

  <footer class="bg-[#f9fafb]">
    <div class="mx-auto w-full max-w-screen-xl px-6 py-6">
      <p class="text-center text-sm text-slate-500" style="font-family: 'Roboto', sans-serif;">
        &copy; <?php echo esc_html(date('Y')); ?> <?php esc_html_e('Webmakerr. All rights reserved.', 'webmakerr'); ?>
      </p>
    </div>
  </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
