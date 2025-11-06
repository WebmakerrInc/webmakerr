<?php
/**
 * Products field override for checkout.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;

$wrapper_classes = trim($field->wrapper_classes . ' flex flex-col gap-6');
$plans           = wu_get_plans();
?>
<div class="<?php echo esc_attr($wrapper_classes); ?>" <?php $field->print_wrapper_html_attributes(); ?>>
  <?php
  wu_get_template(
          'checkout/fields/partials/field-title',
          [
                  'field' => $field,
          ]
  );
  ?>

  <?php if (! empty($field->desc)) : ?>
    <p class="text-sm leading-6 text-zinc-600"><?php echo wp_kses($field->desc, wu_kses_allowed_html()); ?></p>
  <?php endif; ?>

  <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
    <?php if (empty($plans)) : ?>
      <div class="rounded border border-dashed border-zinc-300 bg-zinc-50 p-8 text-center text-sm font-medium text-zinc-500">
        <?php esc_html_e('No plans available yet. Add products in Ultimate Multisite to display them here.', 'webmakerr'); ?>
      </div>
    <?php endif; ?>

    <?php foreach ($plans as $option) : ?>
      <?php
      $plan_id       = $option->get_id();
      $plan_name     = $option->get_name();
      $plan_price    = $option->get_formatted_amount();
      $plan_recurring = $option->get_recurring_description();
      $plan_desc     = $option->get_description();
      $checked       = in_array($plan_id, (array) $field->value, true) || $plan_id == $field->value;

      $trial_text = '';
      if (method_exists($option, 'has_trial') && $option->has_trial()) {
              $duration = $option->get_trial_duration();
              $unit     = $option->get_trial_duration_unit();

              $trial_text = sprintf(
                      /* translators: 1: number of trial units, 2: trial unit label */
                      _n('%1$d %2$s free trial', '%1$d %2$s free trial', $duration, 'ultimate-multisite'),
                      $duration,
                      function_exists('wu_get_translatable_string')
                              ? wu_get_translatable_string($duration <= 1 ? $unit : $unit . 's')
                              : $unit
              );
      }
      ?>
      <label
        class="relative flex h-full cursor-pointer flex-col gap-4 rounded-2xl border border-zinc-200 bg-white/80 p-6 text-left shadow-sm transition hover:-translate-y-1 hover:border-dark hover:shadow-lg focus-within:border-dark focus-within:ring-2 focus-within:ring-dark/10"
        for="field-products-<?php echo esc_attr($plan_id); ?>"
        v-bind:class="{
          'border-dark ring-2 ring-dark/10 shadow-lg': Array.isArray(products)
            ? products.includes(<?php echo esc_js($plan_id); ?>) || products.includes('<?php echo esc_js((string) $plan_id); ?>')
            : products == <?php echo esc_js($plan_id); ?> || products == '<?php echo esc_js((string) $plan_id); ?>'
        }"
      >
        <input
          id="field-products-<?php echo esc_attr($plan_id); ?>"
          class="sr-only"
          type="checkbox"
          name="products[]"
          value="<?php echo esc_attr($plan_id); ?>"
          <?php checked($checked); ?>
          v-model="products"
        >

        <div class="flex flex-col gap-3">
          <div class="flex flex-col gap-2">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500"><?php echo esc_html($plan_name); ?></p>
            <p class="text-3xl font-semibold text-zinc-950"><?php echo esc_html($plan_price); ?></p>
            <?php if ($plan_recurring && $plan_recurring !== '--') : ?>
              <p class="text-sm font-medium text-zinc-600"><?php echo esc_html($plan_recurring); ?></p>
            <?php endif; ?>
            <?php if (! empty($trial_text)) : ?>
              <span class="inline-flex w-fit items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-primary">
                <?php echo esc_html($trial_text); ?>
              </span>
            <?php endif; ?>
          </div>
          <?php if (! empty($plan_desc)) : ?>
            <div class="text-sm leading-6 text-zinc-600"><?php echo wp_kses_post(wpautop($plan_desc)); ?></div>
          <?php endif; ?>
        </div>

        <span class="inline-flex w-fit items-center justify-center rounded-full border border-zinc-200 bg-zinc-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-600">
          <?php esc_html_e('Select plan', 'webmakerr'); ?>
        </span>
      </label>
    <?php endforeach; ?>
  </div>
</div>
