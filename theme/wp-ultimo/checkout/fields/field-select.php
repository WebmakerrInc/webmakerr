<?php
/**
 * Select field override for checkout.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;

$wrapper_classes = trim($field->wrapper_classes . ' flex flex-col gap-2');
$select_classes  = trim('w-full rounded border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus:border-dark focus:outline-none focus:ring-2 focus:ring-dark/10 ' . $field->classes);
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

  <select
    class="<?php echo esc_attr($select_classes); ?>"
    id="field-<?php echo esc_attr($field->id); ?>"
    name="<?php echo esc_attr($field->id); ?>"
    <?php $field->print_html_attributes(); ?>
  >
    <?php if ($field->placeholder) : ?>
      <option value="" <?php selected(! $field->value); ?> class="text-zinc-500"><?php echo esc_html($field->placeholder); ?></option>
    <?php endif; ?>

    <?php foreach ($field->options as $key => $label) : ?>
      <option value="<?php echo esc_attr($key); ?>" <?php selected($key, $field->value); ?>>
        <?php echo esc_html($label); ?>
      </option>
    <?php endforeach; ?>

    <?php if ($field->options_template) : ?>
      <?php echo wp_kses($field->options_template, wu_kses_allowed_html()); ?>
    <?php endif; ?>
  </select>

  <?php
  wu_get_template(
          'checkout/fields/partials/field-errors',
          [
                  'field' => $field,
          ]
  );
  ?>
</div>
