<?php
/**
 * Template Name: Video Production
 * Description: High-converting video services landing page inspired by Loftfilm.de.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit;
}

$popup_settings = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled  = (bool) ($popup_settings['enabled'] ?? false);

$script_handle = 'webmakerr-build-assets-app-js';
$inline_bootstrap = <<<JS
(function() {
    if (window.__webmakerrVideoLandingInitialized) {
        return;
    }
    window.__webmakerrVideoLandingInitialized = true;

    var init = function() {
        var leadButtons = document.querySelectorAll('[data-lead-popup-trigger]');
        var promo = document.getElementById('promo-popup');
        var promoContent = document.getElementById('promoContent');

        if (leadButtons.length && promo) {
            try {
                var storage = window.localStorage;
                if (storage) {
                    storage.removeItem('promoDismissed');
                }
            } catch (error) {
                /* noop */
            }

            var openPromo = function(event) {
                if (event) {
                    event.preventDefault();
                }

                try {
                    var sessionStore = window.sessionStorage;
                    if (sessionStore) {
                        sessionStore.setItem('promoShownSession', 'true');
                    }
                } catch (error) {
                    /* noop */
                }

                promo.classList.remove('hidden');
                promo.setAttribute('aria-hidden', 'false');
                promo.classList.add('opacity-0');

                if (promoContent) {
                    promoContent.classList.add('translate-y-4', 'scale-95', 'opacity-0');
                }

                window.requestAnimationFrame(function() {
                    promo.classList.remove('opacity-0');
                    if (promoContent) {
                        promoContent.classList.remove('translate-y-4', 'scale-95', 'opacity-0');
                    }
                });
            };

            leadButtons.forEach(function(button) {
                button.addEventListener('click', openPromo);
            });
        }

        var animated = document.querySelectorAll('[data-animate]');
        if (animated.length) {
            animated.forEach(function(element) {
                var delay = element.getAttribute('data-animate-delay');
                if (delay) {
                    element.style.transitionDelay = delay + 'ms';
                }
            });

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.remove('opacity-0', 'translate-y-8');
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    observer.unobserve(entry.target);
                });
            }, { threshold: 0.2 });

            animated.forEach(function(element) {
                observer.observe(element);
            });
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
JS;

if (wp_script_is($script_handle, 'enqueued') || wp_script_is($script_handle, 'registered')) {
    wp_add_inline_script($script_handle, $inline_bootstrap);
} else {
    wp_register_script($script_handle, false, [], null, true);
    wp_add_inline_script($script_handle, $inline_bootstrap);
    wp_enqueue_script($script_handle);
}

if (! function_exists('webmakerr_video_template_icon')) {
    function webmakerr_video_template_icon(string $icon): string
    {
        switch ($icon) {
            case 'strategy':
                $path = 'M3.75 6.75l3.5-2.25L10.75 6.75M3.75 17.25l3.5-2.25L10.75 17.25M3.75 12l3.5-2.25L10.75 12M13.25 6.75h6m-6 5.25h6m-6 5.25h6';
                break;
            case 'script':
                $path = 'M4.5 3h11.25a1.5 1.5 0 0 1 1.5 1.5V15l-4.5-3-4.5 3V4.5A1.5 1.5 0 0 1 11.25 3zM4.5 3v15';
                break;
            case 'production':
                $path = 'M4 6.75h16m-16 0a2 2 0 0 0-2 2V17a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8.75a2 2 0 0 0-2-2m-16 0L6.5 3h11L20 6.75M8 12h8';
                break;
            default:
                $path = 'M12 6v12m6-6H6';
                break;
        }

        return '<svg class="h-6 w-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="' . esc_attr($path) . '" /></svg>';
    }
}

get_header();
?>

<main id="primary" class="flex flex-col bg-white">
  <?php while (have_posts()) : the_post();
      $post_id = get_the_ID();

      $hero_headline = get_post_meta($post_id, '_webmakerr_video_hero_headline', true);
      $hero_headline = $hero_headline ? wp_kses_post($hero_headline) : __('Gain More Customers with a Webmakerr Explainer Video', 'webmakerr');

      $hero_subheadline = get_post_meta($post_id, '_webmakerr_video_hero_subheadline', true);
      $hero_subheadline = $hero_subheadline ? wp_kses_post($hero_subheadline) : __('Turn confusion into clarity — and clicks into customers. At Webmakerr, we craft high-converting explainer videos that tell your story in under 90 seconds — so your audience gets it, feels it, and acts on it.', 'webmakerr');

      $hero_primary_label = get_post_meta($post_id, '_webmakerr_video_hero_primary_label', true);
      $hero_primary_label = $hero_primary_label ? sanitize_text_field($hero_primary_label) : __('Free Strategy Call →', 'webmakerr');

      $hero_secondary_label = get_post_meta($post_id, '_webmakerr_video_hero_secondary_label', true);
      $hero_secondary_label = $hero_secondary_label ? sanitize_text_field($hero_secondary_label) : __('See Case Studies →', 'webmakerr');

      $hero_secondary_target = get_post_meta($post_id, '_webmakerr_video_hero_secondary_target', true);
      $hero_secondary_target = $hero_secondary_target ? esc_url($hero_secondary_target) : '#portfolio';

      $lead_capture_link = webmakerr_get_popup_link_attributes('#lead-capture', $popup_enabled);

      $hero_video_id = (int) get_post_meta($post_id, '_webmakerr_video_hero_video', true);
      $hero_video_src = $hero_video_id ? wp_get_attachment_url($hero_video_id) : '';

      $hero_poster_id = (int) get_post_meta($post_id, '_webmakerr_video_hero_poster', true);
      $hero_poster_src = $hero_poster_id ? wp_get_attachment_image_src($hero_poster_id, 'full') : false;
      $hero_poster_url = $hero_poster_src ? $hero_poster_src[0] : '';

      $about_heading = get_post_meta($post_id, '_webmakerr_video_about_heading', true);
      $about_heading = $about_heading ? sanitize_text_field($about_heading) : __('Why Explainer Videos Work', 'webmakerr');

      $about_highlights = get_post_meta($post_id, '_webmakerr_video_about_highlights', true);
      $about_highlights = is_array($about_highlights) ? $about_highlights : [
          [
              'title' => __('Story', 'webmakerr'),
              'copy'  => __('Forget the tired “Meet Tom” scripts. Our professional screenwriters build narratives that make your audience say, “Finally, someone gets me.”', 'webmakerr'),
          ],
          [
              'title' => __('Style', 'webmakerr'),
              'copy'  => __('No generic cartoon cutouts. Every frame is designed to fit your brand — clean, modern, and memorable.', 'webmakerr'),
          ],
          [
              'title' => __('Strategy', 'webmakerr'),
              'copy'  => __('We don’t just create a video; we build a conversion engine and show you exactly how to use it to attract traffic, leads, and sales.', 'webmakerr'),
          ],
      ];

      $process_steps = get_post_meta($post_id, '_webmakerr_video_process_steps', true);
      $process_steps = is_array($process_steps) ? $process_steps : [
          [
              'title' => __('Kick-Off Call', 'webmakerr'),
              'copy'  => __('Tell us about your brand and goals. We’ll align on who you’re targeting and what success looks like. (60 min)', 'webmakerr'),
              'icon'  => 'strategy',
          ],
          [
              'title' => __('Scriptwriting', 'webmakerr'),
              'copy'  => __('We write a conversion-focused script that makes your audience say, “Finally, someone gets me.” (20 min)', 'webmakerr'),
              'icon'  => 'script',
          ],
          [
              'title' => __('Storyboard Review', 'webmakerr'),
              'copy'  => __('Preview the visual flow and messaging before we animate a single frame. (20 min)', 'webmakerr'),
              'icon'  => 'production',
          ],
          [
              'title' => __('Animation & Voiceover', 'webmakerr'),
              'copy'  => __('We handle production, voiceover, and edits—so you stay focused on launch day. (20 min)', 'webmakerr'),
              'icon'  => 'production',
          ],
      ];

      $portfolio_items = get_post_meta($post_id, '_webmakerr_video_portfolio', true);
      $portfolio_items = is_array($portfolio_items) ? $portfolio_items : [
          [
              'title'    => __('“Webmakerr videos bring us 5–10 leads per day.”', 'webmakerr'),
              'category' => '',
              'image'    => 0,
          ],
          [
              'title'    => __('“€500K in revenue from one video.”', 'webmakerr'),
              'category' => '',
              'image'    => 0,
          ],
          [
              'title'    => __('“10× ROI on our explainer video investment.”', 'webmakerr'),
              'category' => '',
              'image'    => 0,
          ],
      ];

      $testimonials = get_post_meta($post_id, '_webmakerr_video_testimonials', true);
      $testimonials = is_array($testimonials) ? $testimonials : [
          [
              'quote'  => __('“The Webmakerr film team translated our complex product into a story our customers instantly understood. Conversions grew 32% in the first week.”', 'webmakerr'),
              'author' => __('Jordan Blake', 'webmakerr'),
              'role'   => __('VP of Marketing, SignalCore', 'webmakerr'),
          ],
          [
              'quote'  => __('“Every deliverable was on-brand and ready for paid campaigns. The crew handled everything from casting to color grade flawlessly.”', 'webmakerr'),
              'author' => __('Priya Desai', 'webmakerr'),
              'role'   => __('Head of Growth, Nova Commerce', 'webmakerr'),
          ],
      ];

      $client_logos = get_post_meta($post_id, '_webmakerr_video_client_logos', true);
      $client_logos = is_array($client_logos) ? $client_logos : [
          [
              'name'  => __('SignalCore', 'webmakerr'),
              'image' => 0,
          ],
          [
              'name'  => __('Nova Commerce', 'webmakerr'),
              'image' => 0,
          ],
          [
              'name'  => __('Brightscale', 'webmakerr'),
              'image' => 0,
          ],
          [
              'name'  => __('Fabrik Labs', 'webmakerr'),
              'image' => 0,
          ],
          [
              'name'  => __('Northwind Retail', 'webmakerr'),
              'image' => 0,
          ],
          [
              'name'  => __('Lumenrise', 'webmakerr'),
              'image' => 0,
          ],
      ];

      $cta_heading = get_post_meta($post_id, '_webmakerr_video_cta_heading', true);
      $cta_heading = $cta_heading ? sanitize_text_field($cta_heading) : __('Let’s make your message unforgettable.', 'webmakerr');

      $cta_copy = get_post_meta($post_id, '_webmakerr_video_cta_copy', true);
      $cta_copy = $cta_copy ? wp_kses_post($cta_copy) : __('Book your free consultation now → and get a custom roadmap for turning attention into revenue.', 'webmakerr');

      $cta_button = get_post_meta($post_id, '_webmakerr_video_cta_button', true);
      $cta_button = $cta_button ? sanitize_text_field($cta_button) : __('Book Your Free Consultation', 'webmakerr');

      $hero_metrics = [
          [
              'label' => __('Projects delivered', 'webmakerr'),
              'value' => __('200+', 'webmakerr'),
          ],
          [
              'label' => __('Average turnaround', 'webmakerr'),
              'value' => __('21 days', 'webmakerr'),
          ],
          [
              'label' => __('Client satisfaction', 'webmakerr'),
              'value' => __('4.9/5', 'webmakerr'),
          ],
      ];
      ?>

    <article <?php post_class('flex flex-col'); ?>>
      <section class="relative overflow-hidden border-b border-zinc-200 bg-gradient-to-b from-white via-white to-light">
        <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-primary/10 via-white/40 to-transparent blur-3xl"></div>
        <div class="relative z-10 mx-auto max-w-screen-xl px-6 pt-20 pb-24 sm:pb-28 lg:px-8 lg:pt-24 lg:pb-32">
          <div class="grid items-center gap-16 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="flex flex-col gap-6 opacity-0 translate-y-8 transition-all duration-700" data-animate>
              <span class="inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
                <?php esc_html_e('Explainer Video Agency', 'webmakerr'); ?>
              </span>
              <h1 class="mt-2 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl lg:text-6xl">
                <?php echo wp_kses_post($hero_headline); ?>
              </h1>
              <p class="max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg">
                <?php echo wp_kses_post($hero_subheadline); ?>
              </p>
              <div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:items-center sm:gap-4">
                <a class="inline-flex w-full justify-center rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url($lead_capture_link['href']); ?>" data-lead-popup-trigger<?php echo $lead_capture_link['attributes']; ?>>
                  <?php echo esc_html($hero_primary_label); ?>
                </a>
                <a class="inline-flex w-full justify-center rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline sm:w-auto" href="<?php echo esc_url($hero_secondary_target); ?>">
                  <?php echo esc_html($hero_secondary_label); ?>
                </a>
              </div>
              <p class="text-xs font-medium uppercase tracking-[0.26em] text-zinc-500 sm:text-sm">
                <?php esc_html_e('★★★★★ 4.9/5 from founders, marketers, and growth teams', 'webmakerr'); ?>
              </p>
              <dl class="grid gap-6 pt-6 sm:grid-cols-3">
                <?php foreach ($hero_metrics as $metric) : ?>
                  <div class="rounded-[5px] border border-zinc-200 bg-white p-4 shadow-sm">
                    <dt class="text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php echo esc_html($metric['label']); ?></dt>
                    <dd class="mt-3 text-2xl font-semibold text-zinc-950 sm:text-3xl"><?php echo esc_html($metric['value']); ?></dd>
                  </div>
                <?php endforeach; ?>
              </dl>
            </div>

            <div class="flex flex-col gap-6 opacity-0 translate-y-8 transition-all duration-700" data-animate data-animate-delay="150">
              <?php if ($hero_video_src || $hero_poster_url || has_post_thumbnail()) : ?>
                <div class="relative overflow-hidden rounded-[5px] border border-zinc-200 bg-light shadow-sm">
                  <?php if ($hero_video_src) : ?>
                    <video class="h-full w-full object-cover" autoplay loop muted playsinline <?php echo $hero_poster_url ? 'poster="' . esc_url($hero_poster_url) . '"' : ''; ?>>
                      <source src="<?php echo esc_url($hero_video_src); ?>" type="<?php echo esc_attr(wp_check_filetype($hero_video_src)['type'] ?? 'video/mp4'); ?>" />
                    </video>
                  <?php elseif ($hero_poster_url) : ?>
                    <img class="h-full w-full object-cover" src="<?php echo esc_url($hero_poster_url); ?>" alt="" />
                  <?php else : ?>
                    <?php the_post_thumbnail('full', ['class' => 'h-full w-full object-cover']); ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <div class="rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                  <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-9.536a.75.75 0 10-1.072-1.05L9 10.879 7.536 9.414a.75.75 0 10-1.061 1.061l2 2a.75.75 0 001.06 0l3-3z" clip-rule="evenodd" /></svg>
                  </span>
                  <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Trusted by', 'webmakerr'); ?></p>
                    <p class="text-base font-medium text-zinc-950"><?php esc_html_e('Product marketing teams worldwide', 'webmakerr'); ?></p>
                  </div>
                </div>
                <ul class="mt-4 grid gap-3 text-sm text-zinc-600 sm:grid-cols-2">
                  <li class="flex items-center gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webmakerr_video_template_icon('strategy'); ?></span>
                    <?php esc_html_e('Strategy-first workshops', 'webmakerr'); ?>
                  </li>
                  <li class="flex items-center gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webmakerr_video_template_icon('script'); ?></span>
                    <?php esc_html_e('Narrative scripting experts', 'webmakerr'); ?>
                  </li>
                  <li class="flex items-center gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webmakerr_video_template_icon('production'); ?></span>
                    <?php esc_html_e('Production & post in-house', 'webmakerr'); ?>
                  </li>
                  <li class="flex items-center gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary"><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo webmakerr_video_template_icon('refresh'); ?></span>
                    <?php esc_html_e('Launch-ready deliverables', 'webmakerr'); ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="about" class="bg-white py-24" aria-labelledby="about-heading">
        <div class="mx-auto grid max-w-screen-xl gap-12 px-6 lg:grid-cols-[minmax(0,_1.1fr)_minmax(0,_0.9fr)] lg:px-8">
          <div class="flex flex-col justify-center gap-6 opacity-0 translate-y-8 transition-all duration-700" data-animate>
            <h2 id="about-heading" class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php echo esc_html($about_heading); ?>
            </h2>
            <div class="prose prose-zinc max-w-none text-zinc-600 sm:prose-lg">
              <?php
              $content = get_the_content();
              if ($content) {
                  the_content();
              } else {
                  echo wp_kses_post(
                      '<p>' . __('Because people don’t buy what they don’t understand.', 'webmakerr') . '</p>' .
                      '<ul class="list-disc space-y-2 pl-5">'
                          . '<li><strong>' . __('Fact 1:', 'webmakerr') . '</strong> ' . __('People only buy what they clearly understand.', 'webmakerr') . '</li>'
                          . '<li><strong>' . __('Fact 2:', 'webmakerr') . '</strong> ' . __('You have about 8 seconds to make them care.', 'webmakerr') . '</li>'
                          . '<li><strong>' . __('Fact 3:', 'webmakerr') . '</strong> ' . __('Text alone can’t explain your offer that fast.', 'webmakerr') . '</li>'
                      . '</ul>' .
                      '<p><strong>' . __('Result:', 'webmakerr') . '</strong> ' . __('Most visitors leave — not because your product is bad, but because they didn’t get it fast enough.', 'webmakerr') . '</p>' .
                      '<p>' . __('That’s where we come in.', 'webmakerr') . '</p>'
                  );
              }
              ?>
            </div>
          </div>

          <div class="grid gap-4 opacity-0 translate-y-8 transition-all duration-700 sm:grid-cols-2" data-animate data-animate-delay="120">
            <?php foreach ($about_highlights as $highlight_index => $highlight) :
                $title = isset($highlight['title']) ? sanitize_text_field($highlight['title']) : '';
                $copy  = isset($highlight['copy']) ? wp_kses_post($highlight['copy']) : '';
                ?>
              <div class="rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <h3 class="text-xl font-semibold text-zinc-950"><?php echo esc_html($title); ?></h3>
                <?php if ($copy) : ?>
                  <p class="mt-2 text-sm leading-6 text-zinc-600"><?php echo $copy; ?></p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section id="process" class="border-t border-zinc-200 bg-light py-24" aria-labelledby="process-heading">
        <div class="mx-auto flex max-w-screen-xl flex-col gap-12 px-6 lg:px-8">
          <div class="max-w-3xl opacity-0 translate-y-8 transition-all duration-700" data-animate>
            <h2 id="process-heading" class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('The Webmakerr Process', 'webmakerr'); ?>
            </h2>
            <p class="mt-4 text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('We handle everything. You invest about 2 hours total.', 'webmakerr'); ?>
            </p>
          </div>

          <div class="grid gap-6 md:grid-cols-3">
            <?php foreach ($process_steps as $index => $step) :
                $title = isset($step['title']) ? sanitize_text_field($step['title']) : '';
                $copy  = isset($step['copy']) ? wp_kses_post($step['copy']) : '';
                $icon  = isset($step['icon']) ? sanitize_key($step['icon']) : '';
                ?>
              <div class="flex h-full flex-col gap-4 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg opacity-0 translate-y-8 duration-700" data-animate data-animate-delay="<?php echo esc_attr($index * 120); ?>">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                  <?php echo wp_kses(webmakerr_video_template_icon($icon), ['svg' => ['class' => true, 'viewbox' => true, 'viewBox' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'aria-hidden' => true], 'path' => ['d' => true]]); ?>
                </span>
                <h3 class="text-lg font-semibold text-zinc-950">
                  <?php echo esc_html($title); ?>
                </h3>
                <?php if ($copy) : ?>
                  <p class="text-sm leading-6 text-zinc-600"><?php echo $copy; ?></p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section id="portfolio" class="border-t border-zinc-200 bg-white py-24" aria-labelledby="portfolio-heading">
        <div class="mx-auto flex max-w-screen-xl flex-col gap-12 px-6 lg:px-8">
          <div class="flex flex-col gap-4 opacity-0 translate-y-8 transition-all duration-700" data-animate>
            <h2 id="portfolio-heading" class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Our Results Speak for Themselves', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('Over 3,500+ successful campaigns and counting.', 'webmakerr'); ?>
            </p>
          </div>

          <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <?php foreach ($portfolio_items as $index => $item) :
                $title    = isset($item['title']) ? sanitize_text_field($item['title']) : '';
                $category = isset($item['category']) ? sanitize_text_field($item['category']) : '';
                $image_id = isset($item['image']) ? (int) $item['image'] : 0;
                ?>
              <div class="group flex h-full flex-col gap-4 rounded-[5px] border border-zinc-200 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-lg opacity-0 translate-y-8 duration-700" data-animate data-animate-delay="<?php echo esc_attr($index * 100); ?>">
                <div class="relative aspect-[4/3] w-full overflow-hidden rounded-[5px] bg-light">
                  <?php
                  if ($image_id) {
                      echo wp_get_attachment_image($image_id, 'large', false, ['class' => 'h-full w-full object-cover transition duration-700 group-hover:scale-105']);
                  } else {
                      echo '<div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-white to-primary/20"></div>';
                  }
                  ?>
                </div>
                <div class="flex flex-col gap-1 px-1 pb-2">
                  <?php if ($category) : ?>
                    <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary"><?php echo esc_html($category); ?></span>
                  <?php endif; ?>
                  <h3 class="text-lg font-semibold text-zinc-950">
                    <?php echo esc_html($title); ?>
                  </h3>
                </div>
                <div class="mt-auto px-1">
                  <a class="inline-flex w-full items-center justify-center gap-2 rounded border border-zinc-200 px-4 py-1.5 text-sm font-semibold text-zinc-950 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($lead_capture_link['href']); ?>" data-lead-popup-trigger<?php echo $lead_capture_link['attributes']; ?>>
                    <?php esc_html_e('See case studies →', 'webmakerr'); ?>
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 11-1.414-1.414L13.586 11H4a1 1 0 110-2h9.586l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="border-t border-zinc-200 bg-light py-24" aria-labelledby="testimonials-heading">
        <div class="mx-auto grid max-w-screen-xl gap-16 px-6 lg:grid-cols-[minmax(0,_1.1fr)_minmax(0,_0.9fr)] lg:px-8">
          <div class="flex flex-col gap-6 opacity-0 translate-y-8 transition-all duration-700" data-animate>
            <h2 id="testimonials-heading" class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Why Brands Choose Webmakerr', 'webmakerr'); ?>
            </h2>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('We’re not just video producers — we’re performance marketers. Our videos are designed to sell, not just look good.', 'webmakerr'); ?>
            </p>
            <p class="text-base leading-7 text-zinc-600 sm:text-lg">
              <?php esc_html_e('That’s why startups and global brands alike trust Webmakerr to turn attention into revenue.', 'webmakerr'); ?>
            </p>

            <div class="grid gap-4 sm:grid-cols-2">
              <?php foreach ($client_logos as $logo_index => $logo) :
                  $logo_id = isset($logo['image']) ? (int) $logo['image'] : 0;
                  $logo_name = isset($logo['name']) ? sanitize_text_field($logo['name']) : '';
                  ?>
                <div class="flex h-20 items-center justify-center rounded-[5px] border border-dashed border-zinc-200 bg-white px-6 shadow-sm opacity-0 translate-y-8 transition-all duration-700" data-animate data-animate-delay="<?php echo esc_attr($logo_index * 60); ?>">
                  <?php
                  if ($logo_id) {
                      echo wp_get_attachment_image($logo_id, 'medium', false, ['class' => 'max-h-10 w-auto object-contain']);
                  } elseif ($logo_name) {
                      echo '<span class="text-sm font-semibold tracking-[0.26em] text-zinc-500">' . esc_html($logo_name) . '</span>';
                  } else {
                      echo '<span class="text-sm font-semibold tracking-[0.26em] text-zinc-400">' . esc_html__('Your Logo', 'webmakerr') . '</span>';
                  }
                  ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="flex flex-col gap-6">
            <?php foreach ($testimonials as $testimonial_index => $testimonial) :
                $quote = isset($testimonial['quote']) ? wp_kses_post($testimonial['quote']) : '';
                $author = isset($testimonial['author']) ? sanitize_text_field($testimonial['author']) : '';
                $role = isset($testimonial['role']) ? sanitize_text_field($testimonial['role']) : '';
                ?>
              <blockquote class="flex h-full flex-col justify-between gap-4 rounded-[5px] border border-zinc-200 bg-white p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-lg opacity-0 translate-y-8 duration-700" data-animate data-animate-delay="<?php echo esc_attr(200 + $testimonial_index * 140); ?>">
                <p class="text-base leading-7 text-zinc-700 sm:text-lg"><?php echo $quote; ?></p>
                <footer class="pt-4">
                  <p class="text-sm font-semibold text-zinc-950"><?php echo esc_html($author); ?></p>
                  <?php if ($role) : ?>
                    <p class="text-xs uppercase tracking-[0.26em] text-zinc-500"><?php echo esc_html($role); ?></p>
                  <?php endif; ?>
                </footer>
              </blockquote>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="relative overflow-hidden border-t border-zinc-200 bg-gradient-to-r from-primary/90 via-dark to-dark py-24" aria-labelledby="cta-heading">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.08),_transparent_60%)]"></div>
        <div class="relative mx-auto grid max-w-screen-xl gap-12 px-6 text-white lg:grid-cols-[minmax(0,_1.1fr)_minmax(0,_0.9fr)] lg:items-center lg:px-8">
          <div class="flex flex-col gap-5 opacity-0 translate-y-8 transition-all duration-700" data-animate>
            <h2 id="cta-heading" class="text-3xl font-semibold text-white sm:text-4xl">
              <?php echo esc_html($cta_heading); ?>
            </h2>
            <p class="text-base leading-7 text-white/80 sm:text-lg">
              <?php echo wp_kses_post($cta_copy); ?>
            </p>
            <div class="flex flex-wrap gap-3">
              <a class="inline-flex items-center justify-center rounded border border-transparent bg-white px-5 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-white/90 !no-underline" href="<?php echo esc_url($lead_capture_link['href']); ?>" data-lead-popup-trigger<?php echo $lead_capture_link['attributes']; ?>>
                <?php echo esc_html($cta_button); ?>
              </a>
              <a class="inline-flex items-center justify-center rounded border border-white/70 bg-transparent px-5 py-2 text-sm font-semibold text-white transition hover:bg-white/10 !no-underline" href="#process">
                <?php esc_html_e('Explore our workflow', 'webmakerr'); ?>
              </a>
            </div>
          </div>

          <div class="opacity-0 translate-y-8 transition-all duration-700" data-animate data-animate-delay="150">
            <div class="rounded-[5px] border border-white/20 bg-white/10 p-6 shadow-sm backdrop-blur">
              <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white">
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2h-4l-4 4v-4H4a2 2 0 01-2-2V5z" /></svg>
                </span>
                <div>
                  <p class="text-xs font-semibold uppercase tracking-[0.26em] text-white/70"><?php esc_html_e('Need a custom quote?', 'webmakerr'); ?></p>
                  <p class="text-sm font-medium text-white"><?php esc_html_e('We respond within one business day.', 'webmakerr'); ?></p>
                </div>
              </div>
              <ul class="mt-4 space-y-3 text-sm text-white/80">
                <li class="flex items-start gap-3">
                  <span class="mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-white/10 text-white">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-7.5 10a.75.75 0 01-1.154.07l-3.5-3.5a.75.75 0 011.06-1.06l2.82 2.82 6.97-9.292a.75.75 0 011.161-.09z" clip-rule="evenodd" /></svg>
                  </span>
                  <span><?php esc_html_e('Full-funnel video strategy workshop', 'webmakerr'); ?></span>
                </li>
                <li class="flex items-start gap-3">
                  <span class="mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-white/10 text-white">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6.267 3.455a2.25 2.25 0 013.182 0l.8.8a.75.75 0 001.061 0l.8-.8a2.25 2.25 0 113.182 3.182l-.8.8a.75.75 0 000 1.06l.8.8a2.25 2.25 0 11-3.182 3.182l-.8-.8a.75.75 0 00-1.061 0l-.8.8a2.25 2.25 0 11-3.182-3.182l.8-.8a.75.75 0 000-1.06l-.8-.8a2.25 2.25 0 010-3.182z" clip-rule="evenodd" /></svg>
                  </span>
                  <span><?php esc_html_e('On-location or remote production crews', 'webmakerr'); ?></span>
                </li>
                <li class="flex items-start gap-3">
                  <span class="mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-white/10 text-white">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5 4a3 3 0 013-3h4a3 3 0 013 3v1h1a3 3 0 013 3v7a3 3 0 01-3 3H4a3 3 0 01-3-3V8a3 3 0 013-3h1V4zm10 1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v1h8z" clip-rule="evenodd" /></svg>
                  </span>
                  <span><?php esc_html_e('Delivery packages for paid, social, and web', 'webmakerr'); ?></span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
    </article>

  <?php endwhile; ?>
</main>

<?php
webmakerr_render_template_popup($popup_settings);

get_footer();
