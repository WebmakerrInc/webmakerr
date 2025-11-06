<?php
/**
 * Field title partial override.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;

if (empty($field->title)) {
        return;
}

$label_classes = 'flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500';
?>
<label class="<?php echo esc_attr($label_classes); ?>" for="field-<?php echo esc_attr($field->id); ?>">
  <span><?php echo wp_kses($field->title, wu_kses_allowed_html()); ?></span>
  <?php if ($field->required) : ?>
    <span class="text-red-500">*</span>
  <?php endif; ?>
  <?php wu_tooltip($field->tooltip); ?>
</label>
