<?php
/**
 * Radio field override for checkout.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;

$wrapper_classes = trim($field->wrapper_classes . ' flex flex-col gap-3');
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

  <div class="flex flex-col gap-3">
    <?php foreach ($field->options as $option_value => $option_name) : ?>
      <label class="flex items-center gap-3 rounded border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-700 shadow-sm transition hover:border-dark focus-within:border-dark focus-within:ring-2 focus-within:ring-dark/10" for="field-<?php echo esc_attr($field->id); ?>-<?php echo esc_attr($option_value); ?>">
        <input
          id="field-<?php echo esc_attr($field->id); ?>-<?php echo esc_attr($option_value); ?>"
          class="h-4 w-4 border border-zinc-300 text-dark focus:ring-dark/40"
          type="radio"
          name="<?php echo esc_attr($field->id); ?>"
          value="<?php echo esc_attr($option_value); ?>"
          <?php $field->print_html_attributes(); ?>
          <?php checked($field->value == $option_value); ?>
        >
        <span class="flex-1 text-left text-sm font-medium text-zinc-800"><?php echo esc_html($option_name); ?></span>
      </label>
    <?php endforeach; ?>
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
