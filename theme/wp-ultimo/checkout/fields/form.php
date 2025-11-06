<?php
/**
 * Form fields wrapper override for Ultimate Multisite checkout.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;
/** @var $form \WP_Ultimo\UI\Form */

$wrapper_classes = trim(
        ($form->classes ?: 'flex flex-col gap-8') .
        (isset($form->step->classes) && $form->step->classes ? ' ' . $form->step->classes : '')
);
?>
<?php if ($form->wrap_in_form_tag) : ?>
  <form id="<?php echo esc_attr($form_slug); ?>" method="<?php echo esc_attr($form->method); ?>" <?php $form->print_html_attributes(); ?>>
<?php else : ?>
  <<?php echo esc_attr($form->wrap_tag); ?> class="<?php echo esc_attr($wrapper_classes); ?>" <?php $form->print_html_attributes(); ?>>
<?php endif; ?>
    <?php if ($form->title) : ?>
      <h3 class="text-left text-2xl font-semibold text-zinc-900"><?php echo esc_html($form->title); ?></h3>
    <?php endif; ?>

    <?php $form->render_fields(); ?>
<?php if ($form->wrap_in_form_tag) : ?>
  </form>
<?php else : ?>
  </<?php echo esc_attr($form->wrap_tag); ?>>
<?php endif; ?>
