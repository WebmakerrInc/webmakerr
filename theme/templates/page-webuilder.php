<?php
/**
 * Template Name: WebBuilder Page
 */

if (! defined('ABSPATH')) {
    exit;
}

$popup_settings = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled  = (bool) ($popup_settings['enabled'] ?? false);

if (! function_exists('webbuilder_render_icon')) {
    function webbuilder_render_icon($name, $class = 'w-6 h-6 text-primary mb-3')
    {
        $icons = array(
            'layout' => '<path d="M3 4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4H3z"></path><path d="M3 8h18v6H3z"></path><path d="M9 14v6"></path><path d="M3 14v6"></path><path d="M21 14v6"></path>',
            'zap' => '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>',
            'palette' => '<path d="M17.5 6.5a9 9 0 1 0-7.75 15 1.5 1.5 0 0 0 2.25-1.32v-1.68a1.5 1.5 0 0 1 2.56-1.06l1.09 1.09a1.5 1.5 0 0 0 1.92.2 6 6 0 0 0 2.43-6.8"></path><circle cx="12" cy="7" r="1"></circle><circle cx="7.5" cy="10.5" r="1"></circle><circle cx="16.5" cy="11.5" r="1"></circle><circle cx="8.5" cy="15.5" r="1"></circle>',
            'puzzle' => '<path d="M14 4h2a2 2 0 0 1 2 2v2h-1a2 2 0 0 0 0 4h1v2a2 2 0 0 1-2 2h-2v-1a2 2 0 0 0-4 0v1H8a2 2 0 0 1-2-2v-2h1a2 2 0 0 0 0-4H6V6a2 2 0 0 1 2-2h2v1a2 2 0 0 0 4 0z"></path>',
            'monitor' => '<rect width="20" height="14" x="2" y="3" rx="2"></rect><path d="M12 17v4"></path><path d="M8 21h8"></path>',
            'gift' => '<rect x="3" y="8" width="18" height="4" rx="1"></rect><path d="M12 8v13"></path><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>',
            'sparkles' => '<path d="M12 3v4"></path><path d="M12 17v4"></path><path d="M3 12h4"></path><path d="M17 12h4"></path><path d="M18.36 5.64 16 8"></path><path d="M8 16 5.64 18.36"></path><path d="m5.64 5.64 2.36 2.36"></path><path d="M16 16l2.36 2.36"></path><circle cx="12" cy="12" r="2"></circle>'
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

$download_url = home_url('/download-webbuilder');
$showcase_url = home_url('/webbuilder-showcase');

$download_link = webmakerr_get_popup_link_attributes($download_url, $popup_enabled);
$showcase_link = webmakerr_get_popup_link_attributes($showcase_url, $popup_enabled);
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
                <?php esc_html_e('WebBuilder Plugin', 'webmakerr'); ?>
              </span>
              <h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl">
                <?php esc_html_e('Build Beautiful Pages in Minutes — No Code Needed', 'webmakerr'); ?>
              </h1>
              <p class="max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg">
                <?php esc_html_e('WebBuilder gives you total design freedom with an intuitive drag-and-drop builder that works with any WordPress theme, and looks perfect with Webmakerr.', 'webmakerr'); ?>
              </p>
              <div class="mt-10 flex flex-col items-center gap-3 sm:flex-row sm:items-center sm:gap-4">
                <a class="inline-flex w-full justify-center rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url($download_link['href']); ?>"<?php echo $download_link['attributes']; ?>>
                  <?php esc_html_e('Download WebBuilder Free', 'webmakerr'); ?>
                </a>
                <a class="inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline sm:w-auto" href="<?php echo esc_url($showcase_link['href']); ?>"<?php echo $showcase_link['attributes']; ?>>
                  <?php esc_html_e('Preview WebBuilder Live', 'webmakerr'); ?>
                </a>
              </div>
              <p class="mt-3 text-xs font-medium text-zinc-500 sm:text-sm">
                <?php esc_html_e('★★★★★ Loved by 6,500+ creative teams building pixel-perfect sites', 'webmakerr'); ?>
              </p>
            </header>
            <div class="relative isolate rounded-[5px] border border-white/60 bg-white/80 p-6 shadow-xl shadow-primary/10 backdrop-blur">
              <div class="absolute -left-10 -top-12 h-40 w-40 rounded-full bg-primary/10 blur-3xl"></div>
              <div class="absolute -bottom-10 -right-10 h-32 w-32 rounded-full bg-dark/5 blur-3xl"></div>
              <div class="relative flex flex-col gap-4">
                <div class="rounded-[5px] border border-zinc-200 bg-white/80 p-6 shadow-sm">
                  <p class="text-xs font-semibold uppercase tracking-[0.3em] text-primary">
                    <?php esc_html_e('Design Anything Visually', 'webmakerr'); ?>
                  </p>
                  <p class="mt-2 text-sm text-zinc-600">
                    <?php esc_html_e('Drag, drop, and refine every element with a builder that feels instantly familiar.', 'webmakerr'); ?>
                  </p>
                </div>
                <ul class="grid gap-3 text-sm text-zinc-600">
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webbuilder_render_icon('layout'); ?></span>
                    <span><?php esc_html_e('Visual canvas updates in real time so you see every change instantly.', 'webmakerr'); ?></span>
                  </li>
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webbuilder_render_icon('zap'); ?></span>
                    <span><?php esc_html_e('Lightweight Tailwind foundation keeps every page blazing fast.', 'webmakerr'); ?></span>
                  </li>
                  <li class="flex items-center gap-3 rounded-[5px] border border-zinc-200 bg-white px-4 py-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webbuilder_render_icon('sparkles'); ?></span>
                    <span><?php esc_html_e('Starter patterns and components help you launch polished layouts in minutes.', 'webmakerr'); ?></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-white p-8 shadow-sm sm:p-10">
          <header class="mx-auto flex max-w-3xl flex-col gap-4 text-center">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Every Tool You Need to Design Without Limits', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('WebBuilder pairs intuitive editing with powerful controls so you can craft immersive experiences faster than ever.', 'webmakerr'); ?>
            </p>
          </header>
          <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            $features = array(
                array(
                    'icon' => 'layout',
                    'title' => __('Drag-and-Drop Simplicity', 'webmakerr'),
                    'description' => __('Design visually without touching code and keep full control of every module.', 'webmakerr'),
                ),
                array(
                    'icon' => 'zap',
                    'title' => __('Lightning Performance', 'webmakerr'),
                    'description' => __('Built with Tailwind utilities to deliver lean, modern pages that load instantly.', 'webmakerr'),
                ),
                array(
                    'icon' => 'palette',
                    'title' => __('Full Design Control', 'webmakerr'),
                    'description' => __('Customize sections, fonts, and colors with pixel-level precision.', 'webmakerr'),
                ),
                array(
                    'icon' => 'puzzle',
                    'title' => __('Works with Any Theme', 'webmakerr'),
                    'description' => __('Drop WebBuilder into any WordPress setup and blend seamlessly with your styling.', 'webmakerr'),
                ),
                array(
                    'icon' => 'monitor',
                    'title' => __('Responsive by Default', 'webmakerr'),
                    'description' => __('Preview and perfect every breakpoint so your pages look stunning everywhere.', 'webmakerr'),
                ),
                array(
                    'icon' => 'gift',
                    'title' => __('Completely Free', 'webmakerr'),
                    'description' => __('Unlock the full builder with zero paywalls, upsells, or limitations.', 'webmakerr'),
                ),
            );

            foreach ($features as $feature) :
                ?>
                <article class="flex h-full flex-col items-center rounded-[5px] border border-zinc-200 bg-zinc-50 p-6 text-center shadow-sm transition hover:border-primary/40 hover:shadow-md">
                  <div class="flex flex-col items-center">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webbuilder_render_icon($feature['icon']);
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
                <?php esc_html_e('WebBuilder Makes WordPress Design Effortless', 'webmakerr'); ?>
              </h2>
              <p class="text-base leading-7 text-zinc-600">
                <?php esc_html_e('Empower your creativity with a builder that feels native, fast, and flexible. WebBuilder is optimized for creators, developers, and businesses who want complete control without complexity.', 'webmakerr'); ?>
              </p>
            </header>
            <ul class="grid gap-3 text-sm text-zinc-600">
              <li class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 px-4 py-3">
                <span class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webbuilder_render_icon('monitor'); ?></span>
                <span><?php esc_html_e('Live responsive controls make it effortless to fine-tune desktop, tablet, and mobile views.', 'webmakerr'); ?></span>
              </li>
              <li class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 px-4 py-3">
                <span class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webbuilder_render_icon('puzzle'); ?></span>
                <span><?php esc_html_e('Integrate with any theme and enhance your stack with Webmakerr-optimized templates.', 'webmakerr'); ?></span>
              </li>
              <li class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-zinc-50 px-4 py-3">
                <span class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo webbuilder_render_icon('zap'); ?></span>
                <span><?php esc_html_e('Smart performance defaults deliver optimized markup, clean CSS, and instant publishing.', 'webmakerr'); ?></span>
              </li>
            </ul>
          </div>
          <div class="relative isolate">
            <div class="relative flex aspect-[4/3] w-full items-center justify-center overflow-hidden rounded-[5px] border border-dashed border-primary/30 bg-gradient-to-br from-primary/5 via-white to-primary/10 shadow-inner">
              <span class="text-sm font-semibold uppercase tracking-[0.4em] text-primary/70">
                <?php esc_html_e('WebBuilder Interface Preview', 'webmakerr'); ?>
              </span>
            </div>
          </div>
        </section>

        <section class="rounded-[5px] border border-zinc-200 bg-gradient-to-br from-primary/5 via-white to-white p-10 text-center shadow-sm sm:p-12">
          <div class="mx-auto max-w-2xl">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Design Faster with WebBuilder', 'webmakerr'); ?>
            </h2>
            <p class="mt-4 text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('Join thousands of WordPress users building modern, responsive sites using WebBuilder and the free Webmakerr Theme.', 'webmakerr'); ?>
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
              <a class="inline-flex items-center justify-center rounded border border-transparent bg-white px-5 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-white/90 !no-underline" href="<?php echo esc_url($download_link['href']); ?>"<?php echo $download_link['attributes']; ?>>
                <?php esc_html_e('Get WebBuilder Free', 'webmakerr'); ?>
              </a>
              <span class="text-sm text-zinc-500">
                <?php esc_html_e('Works seamlessly with Webmakerr Theme • Updates included', 'webmakerr'); ?>
              </span>
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
?>
