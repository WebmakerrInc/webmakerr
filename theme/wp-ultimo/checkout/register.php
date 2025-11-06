<?php
/**
 * Registration page template override.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;

$page_id    = get_queried_object_id();
$page_title = $page_id ? get_the_title($page_id) : __('Create your account', 'webmakerr');
$intro_text = '';

if ($page_id) {
        $excerpt = get_post_field('post_excerpt', $page_id);

        if ($excerpt) {
                $intro_text = $excerpt;
        } else {
                $content = get_post_field('post_content', $page_id);

                if ($content) {
                        $intro_text = wp_trim_words(wp_strip_all_tags($content), 32, '');
                }
        }
}

$intro_text = apply_filters('webmakerr_register_intro_text', $intro_text, $page_id);
?>
<section class="bg-white py-16 sm:py-20 lg:py-24">
  <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-3xl text-center">
      <p class="text-sm font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Get started', 'webmakerr'); ?></p>
      <h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl"><?php echo esc_html($page_title); ?></h1>
      <?php if (! empty($intro_text)) : ?>
        <p class="mt-4 text-base leading-7 text-zinc-600 sm:text-lg"><?php echo wp_kses_post($intro_text); ?></p>
      <?php endif; ?>
    </div>

    <div class="mt-16 flex flex-col gap-12">
      <form
        id="wu_form"
        method="post"
        class="flex flex-col gap-12"
        <?php echo isset($checkout_form_action) ? 'action="' . esc_attr($checkout_form_action) . '"' : ''; ?>
      >
        <?php
        $order_form = new \WP_Ultimo\UI\Form(
                'product-fields',
                $product_fields,
                [
                        'title'                 => false,
                        'views'                 => 'checkout/fields',
                        'classes'               => 'flex flex-col gap-12',
                        'field_wrapper_classes' => 'flex flex-col gap-4',
                ]
        );

        $order_form->render();

        $submit = new \WP_Ultimo\UI\Form(
                'submit-fields',
                $submit_fields,
                [
                        'views'                 => 'checkout/fields',
                        'classes'               => 'flex flex-col gap-6 rounded border border-zinc-200 bg-white p-6 shadow-sm sm:p-8',
                        'field_wrapper_classes' => 'flex flex-col gap-4',
                ]
        );

        $submit->render();

        wp_nonce_field('wu_checkout');
        ?>
      </form>
    </div>
  </div>
</section>
