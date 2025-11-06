<?php
/**
 * Password field override for checkout.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;

$wrapper_classes = trim($field->wrapper_classes . ' flex flex-col gap-2');
$input_classes   = trim('w-full rounded border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus:border-dark focus:outline-none focus:ring-2 focus:ring-dark/10 ' . $field->classes);
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

  <input
    class="<?php echo esc_attr($input_classes); ?>"
    id="field-<?php echo esc_attr($field->id); ?>"
    name="<?php echo esc_attr($field->id); ?>"
    type="<?php echo esc_attr($field->type); ?>"
    placeholder="<?php echo esc_attr($field->placeholder); ?>"
    value="<?php echo esc_attr($field->value); ?>"
    <?php $field->print_html_attributes(); ?>
  >

  <?php if ($field->meter) : ?>
    <span class="mt-1 inline-flex rounded border border-zinc-200 bg-zinc-50 px-3 py-1 text-xs font-medium text-zinc-600">
      <span id="pass-strength-result"><?php esc_html_e('Strength Meter', 'ultimate-multisite'); ?></span>
    </span>
  <?php endif; ?>

  <?php
  wu_get_template(
          'checkout/fields/partials/field-errors',
          [
                  'field' => $field,
          ]
  );
  ?>
</div>
