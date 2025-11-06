<?php
/**
 * Template Name: Affiliate Page
 * Description: Highlights the affiliate program with commissions, resources, and FAQs.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('webmakerr_affiliate_icon')) {
    /**
     * Render an SVG icon used on the affiliate template.
     */
    function webmakerr_affiliate_icon($name, $class = 'h-6 w-6')
    {
        $icons = array(
            'megaphone' => '<path d="M3 11V5a2 2 0 0 1 2-2h1v10H5a2 2 0 0 1-2-2Z"></path><path d="M7 9l14-5v12L7 13"></path><path d="M7 19a3 3 0 0 1-3-3v-4"></path>',
            'lifebuoy' => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><path d="m4.93 4.93 2.83 2.83"></path><path d="m16.24 16.24 2.83 2.83"></path><path d="m4.93 19.07 2.83-2.83"></path><path d="m16.24 7.76 2.83-2.83"></path>',
            'layout' => '<rect width="18" height="14" x="3" y="5" rx="2"></rect><path d="M3 12h18"></path><path d="M12 5v14"></path>',
            'video' => '<path d="m22 8-6 4 6 4V8Z"></path><rect width="14" height="12" x="2" y="6" rx="2" ry="2"></rect>',
            'layers' => '<path d="m12 2 9 4.5-9 4.5L3 6.5 12 2Z"></path><path d="m3 11 9 4.5L21 11"></path><path d="m3 15 9 4.5L21 15"></path>',
            'pen' => '<path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>',
            'code' => '<polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline>',
            'target' => '<path d="M21 12h1"></path><path d="M12 3v1"></path><path d="M12 20v1"></path><path d="M3 12h1"></path><circle cx="12" cy="12" r="7"></circle><circle cx="12" cy="12" r="3"></circle>',
            'book' => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M20 22V6"></path><path d="M4 22V4a2 2 0 0 1 2-2h14v17"></path><path d="M4 15h16"></path>',
            'sparkles' => '<path d="M12 3v4"></path><path d="M12 17v4"></path><path d="M3 12h4"></path><path d="M17 12h4"></path><path d="M18.36 5.64 16 8"></path><path d="M8 16 5.64 18.36"></path><path d="m5.64 5.64 2.36 2.36"></path><path d="M16 16l2.36 2.36"></path><circle cx="12" cy="12" r="2"></circle>',
            'chart' => '<path d="M3 3v18h18"></path><path d="M7 13h2v5H7z"></path><path d="M12 9h2v9h-2z"></path><path d="M17 5h2v13h-2z"></path>'
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

<main id="primary" class="bg-white">
  <div class="flex flex-col">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('flex flex-col'); ?>>
        <section class="bg-[#18184d] py-20 text-white sm:py-24">
          <div class="mx-auto flex w-full max-w-6xl flex-col gap-12 px-4 sm:px-6 lg:flex-row lg:items-center lg:gap-16 lg:px-8">
            <div class="flex flex-1 flex-col gap-6">
              <h1 class="text-4xl font-medium tracking-tight [text-wrap:balance] sm:text-5xl lg:text-6xl">
                <?php esc_html_e('Get paid to collaborate as a Webmakerr Affiliate', 'webmakerr'); ?>
              </h1>
              <p class="max-w-xl text-base leading-7 text-white/90 sm:text-lg">
                <?php esc_html_e('Earn commissions by promoting Webmakerr tools and themes.', 'webmakerr'); ?>
              </p>
              <div class="flex flex-col gap-3 sm:flex-row">
                <a class="inline-flex w-full items-center justify-center rounded-[5px] border border-transparent bg-white px-6 py-3 text-sm font-semibold text-zinc-900 shadow-sm transition hover:bg-gray-100 hover:text-zinc-900 !no-underline sm:w-auto" href="<?php echo esc_url(home_url('/affiliate-signup')); ?>">
                  <?php esc_html_e('Join Now', 'webmakerr'); ?>
                </a>
              </div>
            </div>
            <div class="flex flex-1 items-center justify-center">
              <div class="relative w-full max-w-md overflow-hidden rounded-[6px] border border-white/30 bg-white/10 p-8 shadow-lg shadow-primary/20 backdrop-blur">
                <div class="absolute -top-10 -left-12 h-36 w-36 rounded-full bg-white/20 blur-3xl"></div>
                <div class="absolute -bottom-16 -right-10 h-40 w-40 rounded-full bg-dark/20 blur-3xl"></div>
                <div class="relative flex flex-col gap-5">
                  <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold uppercase tracking-[0.3em] text-white/80">
                      <?php esc_html_e('Performance', 'webmakerr'); ?>
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white">
                      <?php esc_html_e('Live', 'webmakerr'); ?>
                      <?php
                      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_affiliate_icon('sparkles', 'h-4 w-4 text-white');
                      ?>
                    </span>
                  </div>
                  <div class="grid gap-4 rounded-[6px] border border-white/20 bg-white/5 p-5">
                    <div class="flex items-center justify-between text-sm text-white/90">
                      <span><?php esc_html_e('Monthly clicks', 'webmakerr'); ?></span>
                      <span class="text-base font-semibold text-white">12,480</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-white/90">
                      <span><?php esc_html_e('Conversions', 'webmakerr'); ?></span>
                      <span class="text-base font-semibold text-white">1,245</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-white/90">
                      <span><?php esc_html_e('Commission earned', 'webmakerr'); ?></span>
                      <span class="text-base font-semibold text-white">$7,560</span>
                    </div>
                  </div>
                  <div class="flex items-center gap-4 rounded-[6px] border border-white/20 bg-white/5 p-5">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white">
                      <?php
                      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_affiliate_icon('chart', 'h-6 w-6 text-white');
                      ?>
                    </div>
                    <div class="flex flex-col">
                      <p class="text-sm font-semibold text-white">
                        <?php esc_html_e('30-day growth up 142%', 'webmakerr'); ?>
                      </p>
                      <p class="text-xs text-white/80">
                        <?php esc_html_e('Keep momentum with weekly payouts and deep analytics.', 'webmakerr'); ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="py-16 sm:py-20 lg:py-24">
          <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
            <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Meet the Products', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Promote a full suite of creation tools built for agencies, freelancers, and marketing teams.', 'webmakerr'); ?>
              </p>
            </header>
            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-3">
              <?php
              $products = array(
                  array(
                      'title' => __('Webmakerr Theme', 'webmakerr'),
                      'description' => __('Pixel-perfect WordPress theme powered by Tailwind design tokens.', 'webmakerr'),
                      'link' => home_url('/theme'),
                  ),
                  array(
                      'title' => __('Pro Services', 'webmakerr'),
                      'description' => __('On-demand experts for design, development, and performance optimization.', 'webmakerr'),
                      'link' => home_url('/services'),
                  ),
                  array(
                      'title' => __('Builder Tools', 'webmakerr'),
                      'description' => __('Drag-and-drop page builder and automation add-ons that launch faster sites.', 'webmakerr'),
                      'link' => home_url('/builder-tools'),
                  ),
              );

              foreach ($products as $product) :
                  ?>
                  <article class="flex h-full flex-col gap-6 rounded-[6px] border border-zinc-200 bg-white p-8 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-[5px] bg-primary/10 text-primary">
                      <?php
                      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_affiliate_icon('layers', 'h-7 w-7');
                      ?>
                    </div>
                    <div class="flex flex-col gap-3">
                      <h3 class="text-xl font-semibold text-zinc-950">
                        <?php echo esc_html($product['title']); ?>
                      </h3>
                      <p class="text-sm leading-6 text-zinc-600">
                        <?php echo esc_html($product['description']); ?>
                      </p>
                    </div>
                    <a class="btn-primary inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($product['link']); ?>">
                      <?php esc_html_e('View More', 'webmakerr'); ?>
                    </a>
                  </article>
                  <?php
              endforeach;
              ?>
            </div>
          </div>
        </section>

        <section class="border-y border-zinc-200 bg-zinc-50 py-16 sm:py-20 lg:py-24">
          <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
            <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Our partners earn fast', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Flexible commission plans reward the exact audiences you serve.', 'webmakerr'); ?>
              </p>
            </header>
            <div class="mt-12 grid gap-8 md:grid-cols-2 xl:grid-cols-3">
              <?php
              $plans = array(
                  array(
                      'title' => __('Marketplace Themes', 'webmakerr'),
                      'bullets' => array(
                          __('30% commission on every first-time purchase', 'webmakerr'),
                          __('Recurring 10% for renewals within 12 months', 'webmakerr'),
                          __('Instant access to new launch assets', 'webmakerr'),
                      ),
                  ),
                  array(
                      'title' => __('Pro Services', 'webmakerr'),
                      'bullets' => array(
                          __('Earn $150 per qualified project lead', 'webmakerr'),
                          __('Co-branded landing pages for your campaigns', 'webmakerr'),
                          __('Priority onboarding with dedicated manager', 'webmakerr'),
                      ),
                  ),
                  array(
                      'title' => __('Builder Tools', 'webmakerr'),
                      'bullets' => array(
                          __('40% revenue share on annual bundles', 'webmakerr'),
                          __('Deep-link tracking for funnel visibility', 'webmakerr'),
                          __('Weekly updates and feature teasers to share', 'webmakerr'),
                      ),
                  ),
              );

              foreach ($plans as $plan) :
                  ?>
                  <article class="flex h-full flex-col gap-6 rounded-[6px] border border-zinc-200 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between">
                      <h3 class="text-2xl font-semibold text-zinc-950">
                        <?php echo esc_html($plan['title']); ?>
                      </h3>
                      <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-primary">
                        <?php esc_html_e('Affiliate', 'webmakerr'); ?>
                      </span>
                    </div>
                    <ul class="flex flex-1 list-disc flex-col gap-3 pl-5 text-sm leading-6 text-zinc-600">
                      <?php foreach ($plan['bullets'] as $bullet) : ?>
                        <li><?php echo esc_html($bullet); ?></li>
                      <?php endforeach; ?>
                    </ul>
                    <a class="btn-primary inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url(home_url('/affiliate-signup')); ?>">
                      <?php esc_html_e('Start Earning', 'webmakerr'); ?>
                    </a>
                  </article>
                  <?php
              endforeach;
              ?>
            </div>
          </div>
        </section>

        <section class="py-16 sm:py-20 lg:py-24">
          <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
            <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Everything you need to succeed', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Launch campaigns faster with curated resources, coaching, and metrics.', 'webmakerr'); ?>
              </p>
            </header>
            <div class="mt-12 grid gap-8 md:grid-cols-3">
              <?php
              $resources = array(
                  array(
                      'icon' => 'megaphone',
                      'title' => __('Marketing Tools', 'webmakerr'),
                      'description' => __('Banners, email copy, and launch kits refreshed monthly for your audience.', 'webmakerr'),
                  ),
                  array(
                      'icon' => 'lifebuoy',
                      'title' => __('Personal Support', 'webmakerr'),
                      'description' => __('Get a dedicated partner manager plus quarterly growth reviews.', 'webmakerr'),
                  ),
                  array(
                      'icon' => 'layout',
                      'title' => __('Dashboard Access', 'webmakerr'),
                      'description' => __('Real-time analytics, payouts, and campaign tracking inside one hub.', 'webmakerr'),
                  ),
              );

              foreach ($resources as $resource) :
                  ?>
                  <article class="flex h-full flex-col gap-5 rounded-[6px] border border-zinc-200 bg-white p-8 shadow-sm">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                      <?php
                      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_affiliate_icon($resource['icon'], 'h-6 w-6');
                      ?>
                    </span>
                    <div class="flex flex-col gap-3">
                      <h3 class="text-xl font-semibold text-zinc-950">
                        <?php echo esc_html($resource['title']); ?>
                      </h3>
                      <p class="text-sm leading-6 text-zinc-600">
                        <?php echo esc_html($resource['description']); ?>
                      </p>
                    </div>
                  </article>
                  <?php
              endforeach;
              ?>
            </div>
          </div>
        </section>

        <section class="border-y border-zinc-200 bg-zinc-50 py-16 sm:py-20 lg:py-24">
          <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
            <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Are you Webmakerr Affiliate Material?', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('Our program is perfect for content creators, agencies, and educators who love powerful WordPress experiences.', 'webmakerr'); ?>
              </p>
            </header>
            <div class="mt-12 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-6">
              <?php
              $profiles = array(
                  array('icon' => 'video', 'label' => __('Creators', 'webmakerr')),
                  array('icon' => 'layers', 'label' => __('Agencies', 'webmakerr')),
                  array('icon' => 'pen', 'label' => __('Bloggers', 'webmakerr')),
                  array('icon' => 'code', 'label' => __('Developers', 'webmakerr')),
                  array('icon' => 'target', 'label' => __('Marketers', 'webmakerr')),
                  array('icon' => 'book', 'label' => __('Educators', 'webmakerr')),
              );

              foreach ($profiles as $profile) :
                  ?>
                  <div class="flex flex-col items-center gap-3 rounded-[6px] border border-white bg-white p-6 text-center shadow-sm">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                      <?php
                      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      echo webmakerr_affiliate_icon($profile['icon'], 'h-6 w-6');
                      ?>
                    </span>
                    <p class="text-sm font-semibold text-zinc-900">
                      <?php echo esc_html($profile['label']); ?>
                    </p>
                  </div>
                  <?php
              endforeach;
              ?>
            </div>
          </div>
        </section>

        <section class="py-16 sm:py-20 lg:py-24">
          <div class="mx-auto w-full max-w-4xl px-4 sm:px-6 lg:px-8">
            <header class="flex flex-col gap-4 text-center">
              <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary">
                <?php esc_html_e('FAQ', 'webmakerr'); ?>
              </span>
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Frequently Asked Questions', 'webmakerr'); ?>
              </h2>
            </header>
            <div class="mt-12 space-y-4">
              <?php
              $faqs = array(
                  array(
                      'question' => __('How do I join the affiliate program?', 'webmakerr'),
                      'answer' => __('Submit the short application, get approved within two business days, and start sharing your unique links instantly.', 'webmakerr'),
                  ),
                  array(
                      'question' => __('When are commissions paid out?', 'webmakerr'),
                      'answer' => __('We process payouts every week via PayPal or bank transfer once you hit the minimum threshold.', 'webmakerr'),
                  ),
                  array(
                      'question' => __('Can I promote multiple Webmakerr products?', 'webmakerr'),
                      'answer' => __('Yes. Bundle products together or promote them individually—tracking follows each link automatically.', 'webmakerr'),
                  ),
                  array(
                      'question' => __('Do you provide creatives or campaign ideas?', 'webmakerr'),
                      'answer' => __('You will receive ready-to-use graphics, copy, and launch calendars updated with every major release.', 'webmakerr'),
                  ),
                  array(
                      'question' => __('Is there a minimum audience size required?', 'webmakerr'),
                      'answer' => __('No. We welcome passionate partners of all sizes and provide strategies tailored to your channels.', 'webmakerr'),
                  ),
              );

              foreach ($faqs as $faq) :
                  ?>
                  <details class="group overflow-hidden rounded-[6px] border border-zinc-200 bg-white shadow-sm">
                    <summary class="flex cursor-pointer items-center justify-between gap-6 px-6 py-4 text-left text-base font-semibold text-zinc-900">
                      <span><?php echo esc_html($faq['question']); ?></span>
                      <span class="flex h-8 w-8 items-center justify-center rounded-full border border-zinc-200 text-zinc-500 transition group-open:rotate-45">
                        <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path d="M8 3.25V12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                          <path d="M12.75 8H3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                      </span>
                    </summary>
                    <div class="px-6 pb-6 text-sm leading-6 text-zinc-600">
                      <?php echo esc_html($faq['answer']); ?>
                    </div>
                  </details>
                  <?php
              endforeach;
              ?>
            </div>
          </div>
        </section>

        <section class="bg-[#18184d] py-16 text-white sm:py-20 lg:py-24">
          <div class="mx-auto flex w-full max-w-4xl flex-col items-center gap-6 px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold tracking-tight sm:text-4xl">
              <?php esc_html_e('Ready to partner up?', 'webmakerr'); ?>
            </h2>
            <p class="max-w-2xl text-base leading-7 text-white sm:text-lg">
              <?php esc_html_e('Register, promote, and start earning commissions today.', 'webmakerr'); ?>
            </p>
            <a class="inline-flex w-full items-center justify-center rounded-[5px] border border-transparent bg-white px-6 py-3 text-sm font-semibold text-zinc-900 shadow-sm transition hover:bg-gray-100 hover:text-zinc-900 !no-underline sm:w-auto" href="<?php echo esc_url(home_url('/affiliate-signup')); ?>">
              <?php esc_html_e('Join Now', 'webmakerr'); ?>
            </a>
          </div>
        </section>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php
get_footer();
