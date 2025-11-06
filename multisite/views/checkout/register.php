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

<section class="wu-bg-[#fafafa] wu-text-gray-900">
        <div class="wu-mx-auto wu-max-w-6xl wu-px-4 wu-py-14 sm:wu-py-16">
                <div class="wu-text-center">
                        <h1 class="wu-text-3xl wu-font-bold wu-leading-tight sm:wu-text-4xl">
                                <?php esc_html_e('Simple pricing based on your needs', 'ultimate-multisite'); ?>
                        </h1>
                        <p class="wu-mt-4 wu-text-sm wu-text-gray-500 sm:wu-text-base">
                                <?php esc_html_e('Choose a plan to unlock the site creation form. You can upgrade or downgrade whenever your needs change.', 'ultimate-multisite'); ?>
                        </p>
                </div>

                <form id="wu_form" method="post" class="wu-styling wu-relative wu-mt-12 wu-space-y-12">
                        <?php echo $order_form->before; ?>
                        <?php if ($pricing_field) : ?>
                                <div class="wu-grid wu-grid-cols-1 wu-gap-6 sm:wu-grid-cols-2 xl:wu-grid-cols-3">
                                        <?php $render_field($pricing_field); ?>
                                </div>
                        <?php else : ?>
                                <?php $order_form->render(); ?>
                        <?php endif; ?>

                        <?php if ($pricing_field && $additional_fields) : ?>
                                <div
                                        id="wu-signup-card"
                                        class="wu-rounded-3xl wu-border wu-border-gray-200 wu-bg-white wu-p-6 wu-shadow-xl wu-transition-all wu-duration-500 sm:wu-p-10"
                                        v-cloak
                                        v-show="products && products.length"
                                >
                                        <div class="wu-space-y-6">
                                                <?php foreach ($additional_fields as $field_data) : ?>
                                                        <?php $render_field($field_data); ?>
                                                <?php endforeach; ?>
                                        </div>

                                        <div class="wu-mt-8 wu-border-t wu-border-gray-100 wu-pt-6">
                                                <?php
                                                $submit = new \WP_Ultimo\UI\Form('submit-fields', $submit_fields, ['views' => 'checkout/fields']);
                                                $submit->render();
                                                ?>
                                        </div>
                                </div>
                        <?php elseif ($pricing_field) : ?>
                                <?php
                                $submit = new \WP_Ultimo\UI\Form('submit-fields', $submit_fields, ['views' => 'checkout/fields']);
                                $submit->render();
                                ?>
                        <?php endif; ?>

                        <?php if (! $pricing_field) : ?>
                                <?php
                                $submit = new \WP_Ultimo\UI\Form('submit-fields', $submit_fields, ['views' => 'checkout/fields']);
                                $submit->render();
                                ?>
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
