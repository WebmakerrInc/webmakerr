<?php
/**
 * Template Name: Booking Page
 */

if (! defined('ABSPATH')) {
    exit;
}

$popup_settings = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled  = (bool) ($popup_settings['enabled'] ?? false);

if (! function_exists('webbooking_render_icon')) {
    function webbooking_render_icon($name, $class = 'w-6 h-6 text-primary mb-3')
    {
        $icons = array(
            'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle>',
            'calendar' => '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path>',
            'clock' => '<path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle>',
            'zap' => '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>',
            'layout-dashboard' => '<rect width="7" height="9" x="3" y="3" rx="1"></rect><rect width="7" height="5" x="14" y="3" rx="1"></rect><rect width="7" height="9" x="14" y="12" rx="1"></rect><rect width="7" height="5" x="3" y="16" rx="1"></rect>',
            'gift' => '<rect x="3" y="8" width="18" height="4" rx="1"></rect><path d="M12 8v13"></path><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>',
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

$download_url = home_url('/download-webbooking');
$demo_url     = home_url('/webbooking-demo');

$download_link = webmakerr_get_popup_link_attributes($download_url, $popup_enabled);
$demo_link     = webmakerr_get_popup_link_attributes($demo_url, $popup_enabled);
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
                <?php esc_html_e('WebBooking Plugin', 'webmakerr'); ?>
              </span>
              <h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl">
                <?php esc_html_e('The Smartest Way to Schedule in WordPress', 'webmakerr'); ?>
              </h1>
              <p class="max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('WebBooking lets you manage bookings, teams, and calendar sync — fast, reliable, and built beautifully for Webmakerr.', 'webmakerr'); ?>
              </p>
              <div class="mt-10 flex flex-col items-center gap-3 sm:flex-row sm:items-center sm:gap-4">
                <a class="inline-flex w-full justify-center rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url($download_link['href']); ?>"<?php echo $download_link['attributes']; ?>>
                  <?php esc_html_e('Get WebBooking Free', 'webmakerr'); ?>
                </a>
                <a class="inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline sm:w-auto" href="<?php echo esc_url($demo_link['href']); ?>"<?php echo $demo_link['attributes']; ?>>
                  <?php esc_html_e('See WebBooking in action', 'webmakerr'); ?>
                </a>
              </div>
              <p class="mt-3 text-xs font-medium text-zinc-500 sm:text-sm">
                <?php esc_html_e('★★★★★ 4.8/5 support score — 35,000+ appointments booked each day', 'webmakerr'); ?>
              </p>
            </header>
            <div class="relative isolate rounded-[5px] border border-white/60 bg-white/80 p-6 shadow-xl shadow-primary/10 backdrop-blur">
              <div class="absolute -left-10 -top-12 h-40 w-40 rounded-full bg-primary/10 blur-3xl"></div>
              <div class="absolute -bottom-10 -right-10 h-32 w-32 rounded-full bg-dark/5 blur-3xl"></div>
              <div class="relative flex flex-col gap-4">
                <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-6 shadow-sm">
                  <p class="text-xs font-semibold uppercase tracking-[0.3em] text-primary">
                    <?php esc_html_e('Instantly keep teams in sync', 'webmakerr'); ?>
                  </p>
                  <p class="mt-2 text-sm text-zinc-600">
                    <?php esc_html_e('Route bookings to the perfect teammate, sync calendars, and send confirmations automatically.', 'webmakerr'); ?>
                  </p>
                </div>
                <ul class="grid gap-3 text-sm text-zinc-600">
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webbooking_render_icon('users'); ?></span>
                    <span><?php esc_html_e('Assign appointments automatically based on expertise or availability.', 'webmakerr'); ?></span>
                  </li>
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webbooking_render_icon('calendar'); ?></span>
                    <span><?php esc_html_e('Two-way calendar sync keeps every calendar updated in real time.', 'webmakerr'); ?></span>
                  </li>
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webbooking_render_icon('clock'); ?></span>
                    <span><?php esc_html_e('Smart buffers prevent double-booking and protect focus time.', 'webmakerr'); ?></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm sm:p-10">
          <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Build a frictionless scheduling experience your clients love', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('Every touchpoint is optimized for speed, clarity, and control so you can convert more visitors into confirmed bookings.', 'webmakerr'); ?>
            </p>
          </header>
          <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            $features = array(
                array(
                    'icon' => 'users',
                    'title' => __('Team Scheduling Simplified', 'webmakerr'),
                    'description' => __('Clients auto-book the right teammate every time with smart routing rules.', 'webmakerr'),
                ),
                array(
                    'icon' => 'calendar',
                    'title' => __('Calendar Sync', 'webmakerr'),
                    'description' => __('Connect Google, Outlook, iCloud, and more with one click.', 'webmakerr'),
                ),
                array(
                    'icon' => 'clock',
                    'title' => __('Smart Availability', 'webmakerr'),
                    'description' => __('Dynamic scheduling windows keep your team protected from double bookings.', 'webmakerr'),
                ),
                array(
                    'icon' => 'zap',
                    'title' => __('Lightning Fast Setup', 'webmakerr'),
                    'description' => __('Install, connect calendars, and launch your booking page in under two minutes.', 'webmakerr'),
                ),
                array(
                    'icon' => 'layout-dashboard',
                    'title' => __('Works with Any Theme', 'webmakerr'),
                    'description' => __('Beautiful out of the box on Webmakerr and fully responsive everywhere else.', 'webmakerr'),
                ),
                array(
                    'icon' => 'gift',
                    'title' => __('Free Forever', 'webmakerr'),
                    'description' => __('Own your booking system with no subscriptions, upsells, or limits.', 'webmakerr'),
                ),
            );

            foreach ($features as $feature) :
                ?>
                <article class="flex h-full flex-col items-center rounded-[5px] border border-zinc-200 bg-zinc-50 p-6 text-center shadow-sm transition hover:border-primary/40 hover:shadow-md">
                  <div class="flex flex-col items-center">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webbooking_render_icon($feature['icon']);
                    ?>
                    <h3 class="text-xl font-semibold text-zinc-950">
                      <?php echo esc_html($feature['title']); ?>
                    </h3>
                  </div>
                  <p class="mt-3 text-sm leading-6 text-zinc-600">
                    <?php echo esc_html($feature['description']); ?>
                  </p>
                </article>
                <?php
            endforeach;
            ?>
          </div>
        </section>

        <section class="grid gap-10 rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm lg:grid-cols-2 lg:items-center lg:gap-16 lg:p-12">
          <div class="flex flex-col gap-6">
            <header class="flex flex-col gap-4">
              <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                <?php esc_html_e('Showcase bookings with branded, high-converting pages', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600">
                <?php esc_html_e('Customize availability, fields, and follow-up messaging — all without leaving WordPress.', 'webmakerr'); ?>
              </p>
            </header>
            <ul class="grid gap-3 text-sm text-zinc-600">
              <li class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 px-4 py-3">
                <span class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webbooking_render_icon('layout-dashboard'); ?></span>
                <span><?php esc_html_e('Embed your booking form anywhere and keep styling aligned with your brand.', 'webmakerr'); ?></span>
              </li>
              <li class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 px-4 py-3">
                <span class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webbooking_render_icon('users'); ?></span>
                <span><?php esc_html_e('Create team pages that spotlight expertise while letting visitors choose instantly.', 'webmakerr'); ?></span>
              </li>
              <li class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 px-4 py-3">
                <span class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webbooking_render_icon('zap'); ?></span>
                <span><?php esc_html_e('Automate reminders, buffers, and follow-ups so nothing falls through the cracks.', 'webmakerr'); ?></span>
              </li>
            </ul>
          </div>
          <div class="relative isolate">
            <div class="relative flex aspect-[4/3] w-full items-center justify-center overflow-hidden rounded-[5px] border border-dashed border-primary/30 bg-gradient-to-br from-primary/5 via-white to-primary/10 shadow-inner">
              <span class="text-sm font-semibold uppercase tracking-[0.4em] text-primary/70">
                <?php esc_html_e('Booking UI Preview', 'webmakerr'); ?>
              </span>
              <div class="absolute inset-4 rounded-[5px] border border-white/40 bg-white/40 backdrop-blur"></div>
            </div>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-gradient-to-br from-primary/5 via-white to-white p-10 text-center shadow-sm sm:p-12">
          <header class="mx-auto flex max-w-3xl flex-col gap-4">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Ready to Book Smarter?', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600">
              <?php esc_html_e('Join professionals using WebBooking to automate scheduling and save hours every week.', 'webmakerr'); ?>
            </p>
          </header>
          <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a class="inline-flex items-center justify-center rounded border border-transparent bg-white px-5 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-white/90 !no-underline" href="<?php echo esc_url($download_link['href']); ?>"<?php echo $download_link['attributes']; ?>>
              <?php esc_html_e('Download WebBooking Free', 'webmakerr'); ?>
            </a>
            <p class="text-sm text-zinc-500">
              <?php esc_html_e('Self-hosted freedom • No subscriptions • Unlimited bookings', 'webmakerr'); ?>
            </p>
          </div>
        </section>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php
webmakerr_render_template_popup($popup_settings);

get_footer();
