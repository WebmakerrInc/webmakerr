<?php
/**
 * Single checkbox field override for checkout.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;

$wrapper_classes = trim($field->wrapper_classes . ' flex flex-col gap-2');
?>
<div class="<?php echo esc_attr($wrapper_classes); ?>" <?php $field->print_wrapper_html_attributes(); ?>>
  <div class="rounded border border-zinc-200 bg-white px-4 py-3 shadow-sm">
    <label class="flex items-start gap-3 text-sm text-zinc-700" for="field-<?php echo esc_attr($field->id); ?>">
      <input
        id="field-<?php echo esc_attr($field->id); ?>"
        class="mt-0.5 h-4 w-4 rounded border border-zinc-300 text-dark focus:ring-dark/40"
        type="checkbox"
        name="<?php echo esc_attr($field->id); ?>"
        value="1"
        <?php $field->print_html_attributes(); ?>
        <?php checked($field->value); ?>
      >
      <span class="flex-1">
        <?php echo wp_kses($field->title, wu_kses_allowed_html()); ?>
        <?php wu_tooltip($field->tooltip); ?>
      </span>
    </label>
    <?php if ($field->desc) : ?>
      <p class="mt-2 text-sm leading-6 text-zinc-600"><?php echo wp_kses($field->desc, wu_kses_allowed_html()); ?></p>
    <?php endif; ?>
  </div>

  <?php
  wu_get_template(
          'checkout/fields/partials/field-errors',
          [
                  'field' => $field,
          ]
  );
  ?>
</div>
