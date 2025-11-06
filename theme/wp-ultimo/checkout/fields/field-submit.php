<?php
/**
 * Submit field override for checkout.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;
/** @var $field \WP_Ultimo\UI\Field */

$wrapper_classes = trim($field->wrapper_classes . ' flex flex-col');
$button_classes  = trim('inline-flex w-full justify-center rounded bg-dark px-4 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark ' . $field->classes);
?>
<div class="<?php echo esc_attr($wrapper_classes); ?>" <?php $field->print_wrapper_html_attributes(); ?>>
  <button
    id="<?php echo esc_attr($field->id); ?>-btn"
    type="submit"
    name="<?php echo esc_attr($field->id); ?>-btn"
    class="<?php echo esc_attr($button_classes); ?>"
    <?php $field->print_html_attributes(); ?>
  >
    <?php echo wp_kses($field->title, wu_kses_allowed_html()); ?>
  </button>
</div>
