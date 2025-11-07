<?php
/**
 * Template Name: Pricing
 * Description: Displays pricing tiers with feature comparisons and call-to-action blocks.
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

<main id="primary" class="bg-white py-16 sm:py-20 lg:py-24">
  <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('flex flex-col gap-16'); ?>>
        <?php
        $plan_cta_url  = get_post_meta(get_the_ID(), '_webmakerr_pricing_cta_link', true);
        $plan_cta_link = webmakerr_get_popup_link_attributes($plan_cta_url ?: '', $popup_enabled);
        ?>
        <header class="flex flex-col gap-4 text-center">
          <p class="text-sm font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Pricing', 'webmakerr'); ?></p>
          <?php the_title('<h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl">', '</h1>'); ?>
          <p class="mx-auto max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg"><?php echo wp_kses_post(get_post_meta(get_the_ID(), '_webmakerr_pricing_intro', true)); ?></p>
        </header>

        <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
          <?php
          $plans = get_post_meta(get_the_ID(), '_webmakerr_pricing_plans', true);
          if (! empty($plans) && is_array($plans)) :
              foreach ($plans as $plan) :
                  $title       = isset($plan['title']) ? sanitize_text_field($plan['title']) : '';
                  $price       = isset($plan['price']) ? sanitize_text_field($plan['price']) : '';
                  $description = isset($plan['description']) ? wp_kses_post($plan['description']) : '';
                  ?>
                  <div class="flex h-full flex-col gap-6 rounded border border-zinc-200 bg-white p-8 text-left shadow-sm">
                    <div class="flex flex-col gap-2">
                      <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500"><?php echo esc_html($title); ?></p>
                      <p class="text-3xl font-semibold text-zinc-950">
                        <?php echo esc_html($price); ?>
                      </p>
                      <div class="text-sm leading-6 text-zinc-600"><?php echo $description; ?></div>
                    </div>
                    <a class="mt-4 inline-flex rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline" href="<?php echo esc_url($plan_cta_link['href']); ?>"<?php echo $plan_cta_link['attributes']; ?>>
                      <?php esc_html_e('Choose plan', 'webmakerr'); ?>
                    </a>
                  </div>
                  <?php
              endforeach;
          else :
              ?>
              <div class="rounded border border-dashed border-zinc-300 bg-zinc-50 p-8 text-center text-sm font-medium text-zinc-500">
                <?php esc_html_e('Add pricing plans in the page editor to display them here.', 'webmakerr'); ?>
              </div>
              <?php
          endif;
          ?>
        </section>

        <div class="prose max-w-none text-zinc-700 sm:prose-lg">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php
webmakerr_render_template_popup($popup_settings);

get_footer();
