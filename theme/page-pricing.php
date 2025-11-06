<?php
/**
 * Template Name: Pricing
 * Description: Pricing page that renders plan products from the Multisite plugin.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

$plans          = [];
$product_class  = '\\WP_Ultimo\\Models\\Product';
$has_product_cls = class_exists($product_class);

if (function_exists('wu_get_plans') && $has_product_cls) {
    $plans = wu_get_plans([
        'orderby' => 'list_order',
        'order'   => 'ASC',
    ]);

    $plans = array_filter(
        $plans,
        static function ($plan) use ($product_class) {
            return is_a($plan, $product_class) && $plan->is_active() && $plan->get_type() === 'plan';
        }
    );
}

$featured_plan_id = null;

foreach ($plans as $plan) {
    if (method_exists($plan, 'is_featured_plan') && $plan->is_featured_plan()) {
        $featured_plan_id = $plan->get_id();
        break;
    }
}

if (null === $featured_plan_id && $plans) {
    $first_plan = reset($plans);
    if ($has_product_cls && is_a($first_plan, $product_class)) {
        $featured_plan_id = $first_plan->get_id();
    }
}

?>

<main id="primary" class="bg-zinc-50 text-zinc-900">
  <section class="px-4 pt-14 pb-10 text-center sm:px-6 lg:px-8">
    <div class="mx-auto max-w-3xl">
      <h1 class="text-3xl font-semibold leading-snug sm:text-4xl"><?php esc_html_e('Simple pricing based on your needs', 'webmakerr'); ?></h1>
      <p class="mt-4 text-sm text-zinc-600 sm:text-base">
        <?php esc_html_e('Use Cal.com for your team or organization, or extend it into a platform tailored to your users.', 'webmakerr'); ?>
      </p>
    </div>
    <div class="mt-6 flex w-full justify-center">
      <div class="flex items-center space-x-2 rounded-full border border-zinc-200 bg-white px-2 py-1 text-sm font-medium shadow-sm">
        <button type="button" class="rounded-full bg-dark px-4 py-1 text-white shadow focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"><?php esc_html_e('Individuals', 'webmakerr'); ?></button>
        <button type="button" class="rounded-full px-4 py-1 text-zinc-600 transition hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"><?php esc_html_e('Teams', 'webmakerr'); ?></button>
        <button type="button" class="rounded-full px-4 py-1 text-zinc-600 transition hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"><?php esc_html_e('Organizations', 'webmakerr'); ?></button>
        <button type="button" class="rounded-full px-4 py-1 text-zinc-600 transition hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark"><?php esc_html_e('Enterprise', 'webmakerr'); ?></button>
      </div>
    </div>
  </section>

  <?php if (! empty($plans)) : ?>
    <section class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 pb-20 sm:grid-cols-2 lg:grid-cols-4 sm:px-6 lg:px-8">
      <?php
      foreach ($plans as $plan) {
          $is_featured  = $featured_plan_id && $plan->get_id() === $featured_plan_id;
          $card_classes = $is_featured ? 'bg-zinc-900 text-white border border-zinc-800' : 'bg-white border border-zinc-200 text-zinc-900';
          $amount_label = $plan->get_formatted_amount();
          $amount_label = is_string($amount_label) ? preg_replace('/!$/', '', $amount_label) : '';
          $billing_copy = '';

          if ($plan->get_pricing_type() === 'contact_us') {
              $billing_copy = '';
          } elseif ($plan->is_free()) {
              $billing_copy = '';
          } elseif ($plan->is_recurring()) {
              $billing_copy = sprintf(
                  /* translators: %s: recurring description (e.g. every month). */
                  esc_html__('Billed %s', 'webmakerr'),
                  $plan->get_recurring_description()
              );
          } else {
              $billing_copy = esc_html__('One-time payment', 'webmakerr');
          }

          $description = trim((string) $plan->get_description());

          $features = [];
          if (method_exists($plan, 'get_pricing_table_lines')) {
              $features = array_filter((array) $plan->get_pricing_table_lines());
          }

          $button_label = apply_filters('webmakerr_pricing_plan_button_label', __('Get Started', 'webmakerr'), $plan);
          $plan_slug    = sanitize_title($plan->get_slug());
          $button_url   = apply_filters(
              'webmakerr_pricing_plan_button_url',
              add_query_arg(
                  'plan',
                  $plan_slug,
                  home_url('/register/')
              ),
              $plan
          );
          ?>
          <article class="flex flex-col rounded-2xl p-6 shadow-sm sm:p-8 <?php echo esc_attr($card_classes); ?>">
            <div class="flex flex-col gap-1">
              <h3 class="text-sm font-medium uppercase tracking-wide <?php echo $is_featured ? 'text-white/70' : 'text-zinc-600'; ?>"><?php echo esc_html($plan->get_name()); ?></h3>
              <p class="text-3xl font-bold">
                <?php echo esc_html($amount_label); ?>
              </p>
              <?php if ($billing_copy) : ?>
                <p class="text-xs <?php echo $is_featured ? 'text-zinc-300' : 'text-zinc-500'; ?>">
                  <?php echo esc_html($billing_copy); ?>
                </p>
              <?php endif; ?>
            </div>

            <?php if ($description) : ?>
              <p class="mt-4 text-sm <?php echo $is_featured ? 'text-zinc-200' : 'text-zinc-600'; ?>">
                <?php echo esc_html(wp_strip_all_tags($description)); ?>
              </p>
            <?php endif; ?>

            <a
              class="mt-6 inline-flex w-full items-center justify-center rounded px-4 py-2 text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 <?php echo $is_featured ? 'bg-white text-zinc-900 hover:bg-zinc-100 focus-visible:outline-white' : 'bg-dark text-white hover:bg-dark/90 focus-visible:outline-dark'; ?>"
              href="<?php echo esc_url($button_url); ?>"
            >
              <?php echo esc_html($button_label); ?>
            </a>

            <?php if (! empty($features)) : ?>
              <ul class="mt-6 space-y-2 text-sm <?php echo $is_featured ? 'text-zinc-200' : 'text-zinc-600'; ?>">
                <?php
                foreach ($features as $feature) {
                    $feature_text = wp_strip_all_tags((string) $feature, true);
                    if ('' === $feature_text) {
                        continue;
                    }
                    ?>
                    <li><?php echo esc_html($feature_text); ?></li>
                    <?php
                }
                ?>
              </ul>
            <?php endif; ?>
          </article>
          <?php
      }
      ?>
    </section>
  <?php else : ?>
    <section class="mx-auto max-w-4xl px-4 pb-20 text-center sm:px-6 lg:px-8">
      <div class="rounded-2xl border border-zinc-200 bg-white px-6 py-10 shadow-sm">
        <h2 class="text-2xl font-semibold text-zinc-900 sm:text-3xl"><?php esc_html_e('Plans are coming soon', 'webmakerr'); ?></h2>
        <p class="mt-3 text-sm text-zinc-600 sm:text-base"><?php esc_html_e('We’re preparing new plans for you. Please check back later.', 'webmakerr'); ?></p>
      </div>
    </section>
  <?php endif; ?>

  <section class="border-t border-zinc-200 py-10">
    <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-center gap-8 opacity-70 px-4 sm:px-6 lg:px-8">
      <img src="https://dummyimage.com/100x30/ccc/000&text=Vercel" class="h-6" alt="Vercel" />
      <img src="https://dummyimage.com/100x30/ccc/000&text=Notion" class="h-6" alt="Notion" />
      <img src="https://dummyimage.com/100x30/ccc/000&text=Rho" class="h-6" alt="Rho" />
      <img src="https://dummyimage.com/100x30/ccc/000&text=Deel" class="h-6" alt="Deel" />
      <img src="https://dummyimage.com/100x30/ccc/000&text=Ramp" class="h-6" alt="Ramp" />
    </div>
  </section>

  <section class="border-t border-zinc-200 bg-white py-20">
    <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-zinc-900 sm:text-3xl"><?php esc_html_e('Self-host Cal.com', 'webmakerr'); ?></h2>
      <p class="mt-4 text-sm text-zinc-600 sm:text-base">
        <?php esc_html_e('The self-hosted version of Cal.com offers the same pricing and advanced plans as our cloud version. Use it to build your own SaaS or internal tools.', 'webmakerr'); ?>
      </p>
      <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
        <a class="inline-flex items-center justify-center rounded bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark" href="#">
          <?php esc_html_e('Self-host Instructions', 'webmakerr'); ?>
        </a>
        <a class="inline-flex items-center justify-center rounded border border-zinc-300 px-5 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark" href="#">
          <?php esc_html_e('Purchase Enterprise License', 'webmakerr'); ?>
        </a>
      </div>
    </div>
  </section>

  <section class="bg-zinc-100 py-20">
    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-zinc-900 sm:text-3xl"><?php esc_html_e('Feature breakdown', 'webmakerr'); ?></h2>
      <p class="mt-3 text-sm text-zinc-600 sm:text-base"><?php esc_html_e('Compare our Free and Teams plans to see why Cal.com is the better choice.', 'webmakerr'); ?></p>
      <a class="mt-6 inline-flex items-center justify-center rounded bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark" href="#">
        <?php esc_html_e('Get started', 'webmakerr'); ?>
      </a>
    </div>
    <div class="mt-10 overflow-x-auto px-4 sm:px-6 lg:px-8">
      <table class="mx-auto w-full max-w-5xl border-separate border-spacing-y-2 text-left text-sm">
        <thead>
          <tr class="text-xs font-semibold uppercase tracking-wide text-zinc-500">
            <th class="w-1/3 rounded-l-lg bg-white px-3 py-2 text-left text-zinc-600"><?php esc_html_e('Scheduling Features', 'webmakerr'); ?></th>
            <th class="bg-white px-3 py-2 text-center font-medium text-zinc-900">
              <span class="mb-1 inline-block rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-green-700"><?php esc_html_e('Best Value', 'webmakerr'); ?></span>
              <div class="rounded border-l-4 border-green-400 bg-green-50 py-1 text-sm font-semibold text-green-700"><?php esc_html_e('Cal.com', 'webmakerr'); ?></div>
            </th>
            <th class="bg-white px-3 py-2 text-center text-sm font-medium text-zinc-600"><?php esc_html_e('Calendly', 'webmakerr'); ?></th>
            <th class="rounded-r-lg bg-white px-3 py-2 text-center text-sm font-medium text-zinc-600"><?php esc_html_e('SavvyCal', 'webmakerr'); ?></th>
          </tr>
        </thead>
        <tbody class="text-zinc-700">
          <?php
          $comparison_rows = [
              [__('Unlimited calendar connections', 'webmakerr'), true, false, false],
              [__('Unlimited event types', 'webmakerr'), true, true, false],
              [__('Multiple duration options', 'webmakerr'), true, true, true],
              [__('Minimum notice', 'webmakerr'), true, true, true],
              [__('Booking frequency limits', 'webmakerr'), true, false, false],
              [__('Automated workflows', 'webmakerr'), true, false, false],
              [__('Built-in video conferencing', 'webmakerr'), true, false, false],
              [__('Routing forms', 'webmakerr'), true, true, false],
              [__('Self-hosting', 'webmakerr'), true, false, false],
              [__('White-labeling', 'webmakerr'), true, false, false],
          ];

          foreach ($comparison_rows as $row) {
              [$feature_name, $cal, $calendly, $savvycal] = $row;
              ?>
              <tr class="rounded-lg bg-white shadow-sm">
                <td class="rounded-l-lg px-3 py-3 text-sm font-medium text-zinc-700"><?php echo esc_html($feature_name); ?></td>
                <td class="px-3 py-3 text-center text-sm font-semibold text-green-600"><?php echo $cal ? esc_html__('✔', 'webmakerr') : esc_html__('✖', 'webmakerr'); ?></td>
                <td class="px-3 py-3 text-center text-sm text-zinc-500"><?php echo $calendly ? esc_html__('✔', 'webmakerr') : esc_html__('✖', 'webmakerr'); ?></td>
                <td class="rounded-r-lg px-3 py-3 text-center text-sm text-zinc-500"><?php echo $savvycal ? esc_html__('✔', 'webmakerr') : esc_html__('✖', 'webmakerr'); ?></td>
              </tr>
              <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <section class="border-t border-zinc-200 bg-white py-16">
    <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-zinc-900 sm:text-3xl"><?php esc_html_e('Smarter, simpler scheduling', 'webmakerr'); ?></h2>
      <a class="mt-6 inline-flex items-center justify-center rounded bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark" href="#">
        <?php esc_html_e('Get started', 'webmakerr'); ?>
      </a>
    </div>
  </section>
</main>

<?php
get_footer();
