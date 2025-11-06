<?php
/**
 * List Template field view.
 *
 * @since 2.0.0
 */
defined('ABSPATH') || exit;


/**
 * Deal with different pricing options
 */
foreach ($products as $index => &$_product) {
	$_product = wu_get_product($_product['id']);

	$product_variation = $_product->get_as_variation($duration, $duration_unit);

	if (false === $product_variation && ! $force_different_durations) {
		unset($products[ $index ]);

		$_product = $product_variation;
	}
}

?>
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3 <?php echo esc_attr(trim($classes)); ?>">

        <?php foreach ($products as $product) : ?>
                <?php /** @var \WP_Ultimo\Models\Product $product */ ?>

                <?php
                $is_featured            = $product->is_featured_plan();
                $is_contact             = $product->get_pricing_type() === 'contact_us';
                $is_free                = $product->get_pricing_type() === 'free';
                $card_classes           = 'group relative flex h-full flex-col rounded-2xl border p-6 shadow-sm transition-all duration-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-gray-900 focus-within:ring-offset-2';
                $card_classes          .= $is_featured ? ' bg-gray-900 border-gray-900 text-white shadow-xl' : ' bg-white border-gray-200 text-gray-900 hover:border-gray-300 hover:shadow-md';
                $muted_text_class       = $is_featured ? 'text-white/70' : 'text-gray-500';
                $feature_text_class     = $is_featured ? 'text-white/80' : 'text-gray-600';
                $button_classes         = $is_featured ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-black';
                $selected_ring_classes  = $is_featured ? 'border-white ring-2 ring-white ring-offset-2 ring-offset-gray-900 shadow-2xl' : 'border-gray-900 ring-2 ring-gray-900 ring-offset-2 ring-offset-gray-50 shadow-2xl';
                $price_label            = $is_free ? __('Free', 'ultimate-multisite') : ($is_contact ? __('Contact us', 'ultimate-multisite') : $product->get_formatted_amount());
                $recurring_description  = $product->get_recurring_description();
                ?>

                <label
                        id="wu-product-<?php echo esc_attr($product->get_id()); ?>"
                        class="<?php echo esc_attr($card_classes); ?>"
                        :class="$parent.has_product(<?php echo esc_attr($product->get_id()); ?>) || $parent.has_product('<?php echo esc_attr($product->get_slug()); ?>') ? '<?php echo esc_attr($selected_ring_classes); ?>' : ''"
                >

                <input
                        v-if="<?php echo wp_json_encode($product->get_pricing_type() !== 'contact_us'); ?>"
                        v-on:click="$parent.add_plan(<?php echo esc_attr($product->get_id()); ?>); window.wuScrollToSignupForm && window.wuScrollToSignupForm();"
                        type="checkbox"
                        name="products[]"
                        value="<?php echo esc_attr($product->get_id()); ?>"
                        class="screen-reader-text sr-only"
                >

                <input
                        v-else
                        v-on:click="$parent.open_url('<?php echo esc_url($product->get_contact_us_link()); ?>', '_blank'); window.wuScrollToSignupForm && window.wuScrollToSignupForm();"
                        type="checkbox"
                        name="products[]"
                        value="<?php echo esc_attr($product->get_id()); ?>"
                        class="screen-reader-text sr-only"
                >

                <?php if ($is_featured) : ?>
                        <span class="absolute left-6 top-6 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white/80">
                                <?php esc_html_e('Most popular', 'ultimate-multisite'); ?>
                        </span>
                <?php endif; ?>

                <div class="flex flex-1 flex-col">
                        <div class="flex items-baseline justify-between gap-3">
                                <div>
                                        <h3 class="text-lg font-semibold">
                                                <?php echo esc_html($product->get_name()); ?>
                                        </h3>
                                        <?php if ($product->get_description()) : ?>
                                                <p class="mt-1 text-sm <?php echo esc_attr($muted_text_class); ?>">
                                                        <?php echo wp_kses($product->get_description(), wu_kses_allowed_html()); ?>
                                                </p>
                                        <?php endif; ?>
                                </div>
                                <div class="text-right">
                                        <p class="text-3xl font-bold">
                                                <?php echo esc_html($price_label); ?>
                                        </p>
                                        <?php if (! $is_free && ! $is_contact && $recurring_description) : ?>
                                                <p class="mt-1 text-xs <?php echo esc_attr($muted_text_class); ?>">
                                                        <?php echo esc_html($recurring_description); ?>
                                                </p>
                                        <?php endif; ?>
                                </div>
                        </div>

                        <?php $feature_lines = array_filter((array) $product->get_pricing_table_lines()); ?>
                        <?php if ($feature_lines) : ?>
                                <ul class="mt-6 space-y-2 text-sm <?php echo esc_attr($feature_text_class); ?>">
                                        <?php foreach ($feature_lines as $line) : ?>
                                                <li class="flex items-start gap-2">
                                                        <span class="mt-0.5 text-base">•</span>
                                                        <span class="leading-relaxed"><?php echo wp_kses($line, wu_kses_allowed_html()); ?></span>
                                                </li>
                                        <?php endforeach; ?>
                                </ul>
                        <?php endif; ?>

                        <div class="mt-8">
                                <span class="inline-flex w-full items-center justify-center rounded-md px-4 py-2 text-sm font-semibold <?php echo esc_attr($button_classes); ?>">
                                        <?php echo esc_html($is_contact ? __('Contact sales', 'ultimate-multisite') : __('Get started', 'ultimate-multisite')); ?>
                                </span>
                        </div>
                </div>

                </label>

        <?php endforeach; ?>

</div>
