<?php
defined('ABSPATH') || exit;

wp_add_inline_script(
        'wu-checkout',
        "(function(){\n  window.wuScrollToSignupForm = function(){\n    var card = document.getElementById('wu-signup-card');\n    if (!card) {\n      return;\n    }\n    window.requestAnimationFrame(function(){\n      card.scrollIntoView({ behavior: 'smooth', block: 'start' });\n    });\n  };\n})();",
        'after'
);

$order_form = new \WP_Ultimo\UI\Form(
        'product-fields',
        $product_fields,
        [
                'title' => __('Products', 'ultimate-multisite'),
                'views' => 'checkout/fields',
        ]
);

$form_fields = $order_form->get_fields();

$pricing_field = null;
$additional_fields = [];

foreach ($form_fields as $field_slug => $field_object) {
        $wrapper_attributes = $field_object->wrapper_html_attr;

        if (! isset($wrapper_attributes['id'])) {
                $wrapper_attributes['id'] = "wrapper-field-$field_slug";

                $field_object->set_attribute('wrapper_html_attr', $wrapper_attributes);
        }

        if (null === $pricing_field && $field_object->type === 'pricing_table') {
                $pricing_field = [
                        'slug'  => $field_slug,
                        'field' => $field_object,
                ];

                continue;
        }

        $additional_fields[] = [
                'slug'  => $field_slug,
                'field' => $field_object,
        ];
}

$render_field = static function ($field_data) {
        if (! $field_data) {
                return;
        }

        $field       = $field_data['field'];
        $field_slug  = $field_data['slug'];
        $template    = $field->get_template_name();

        wu_get_template(
                "checkout/fields/field-{$template}",
                [
                        'field_slug' => $field_slug,
                        'field'      => $field,
                ],
                'checkout/fields/field-text'
        );
};

?>

<section class="wu-register-flow bg-slate-100">
        <div class="mx-auto w-full max-w-screen-xl px-6 py-20">
                <div class="mx-auto max-w-3xl text-center">
                        <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                                <?php esc_html_e('Choose the plan that fits you best', 'ultimate-multisite'); ?>
                        </p>
                        <p class="mt-4 text-3xl font-semibold leading-tight text-slate-900 sm:text-4xl">
                                <?php esc_html_e('Pick your plan and finalize your account in minutes.', 'ultimate-multisite'); ?>
                        </p>
                </div>

                <form id="wu_form" method="post" class="wu-styling wu-relative mt-16 space-y-16">
                        <?php echo $order_form->before; ?>
                        <?php if ($pricing_field) : ?>
                                <div class="mx-auto grid max-w-screen-lg grid-cols-1 gap-8 md:grid-cols-3">
                                        <?php $render_field($pricing_field); ?>
                                </div>
                        <?php else : ?>
                                <?php $order_form->render(); ?>
                        <?php endif; ?>

                        <?php if ($pricing_field && $additional_fields) : ?>
                                <div
                                        id="wu-signup-card"
                                        class="mx-auto w-full max-w-2xl space-y-8 rounded-3xl border border-slate-200 bg-white p-8 shadow-2xl shadow-slate-900/5 transition-all duration-500 sm:p-10"
                                        v-cloak
                                        v-show="products && products.length"
                                >
                                        <div class="space-y-10">
                                                <div class="text-center sm:text-left">
                                                        <h2 class="text-2xl font-semibold text-slate-900">
                                                                <?php esc_html_e('Complete Your Account Setup', 'ultimate-multisite'); ?>
                                                        </h2>
                                                        <p class="mt-2 text-sm text-slate-500">
                                                                <?php esc_html_e('Enter your details below to secure your selected plan and launch your site.', 'ultimate-multisite'); ?>
                                                        </p>
                                                </div>

                                                <?php foreach ($additional_fields as $field_data) : ?>
                                                        <?php $render_field($field_data); ?>
                                                <?php endforeach; ?>
                                        </div>

                                        <div class="border-t border-slate-200 pt-6">
                                                <?php
                                                $submit = new \WP_Ultimo\UI\Form('submit-fields', $submit_fields, ['views' => 'checkout/fields']);
                                                $submit->render();
                                                ?>
                                        </div>
                                </div>
                        <?php elseif ($pricing_field) : ?>
                                <div class="mx-auto w-full max-w-2xl space-y-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-2xl shadow-slate-900/5 sm:p-10">
                                        <div class="text-center">
                                                <h2 class="text-2xl font-semibold text-slate-900">
                                                        <?php esc_html_e('Complete Your Account Setup', 'ultimate-multisite'); ?>
                                                </h2>
                                                <p class="mt-2 text-sm text-slate-500">
                                                        <?php esc_html_e('Enter your details below to secure your selected plan and launch your site.', 'ultimate-multisite'); ?>
                                                </p>
                                        </div>
                                        <?php
                                        $submit = new \WP_Ultimo\UI\Form('submit-fields', $submit_fields, ['views' => 'checkout/fields']);
                                        $submit->render();
                                        ?>
                                </div>
                        <?php endif; ?>

                        <?php if (! $pricing_field) : ?>
                                <div class="mx-auto w-full max-w-2xl space-y-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-2xl shadow-slate-900/5 sm:p-10">
                                        <div class="text-center">
                                                <h2 class="text-2xl font-semibold text-slate-900">
                                                        <?php esc_html_e('Complete Your Account Setup', 'ultimate-multisite'); ?>
                                                </h2>
                                                <p class="mt-2 text-sm text-slate-500">
                                                        <?php esc_html_e('Enter your details below to secure your selected plan and launch your site.', 'ultimate-multisite'); ?>
                                                </p>
                                        </div>
                                        <?php
                                        $submit = new \WP_Ultimo\UI\Form('submit-fields', $submit_fields, ['views' => 'checkout/fields']);
                                        $submit->render();
                                        ?>
                                </div>
                        <?php endif; ?>

                        <?php echo $order_form->after; ?>

                        <?php
                        /**
                         * Add a security nonce field.
                         */
                        wp_nonce_field('wu_checkout');
                        ?>
                </form>
        </div>
</section>
