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
<div class="grid grid-cols-1 gap-6 md:grid-cols-3 <?php echo esc_attr(trim($classes)); ?>">

        <?php foreach ($products as $product) : ?>
                <?php /** @var \WP_Ultimo\Models\Product $product */ ?>

                <?php
                $is_featured            = $product->is_featured_plan();
                $is_contact             = $product->get_pricing_type() === 'contact_us';
                $is_free                = $product->get_pricing_type() === 'free';
                $card_classes           = 'group relative flex h-full flex-col rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:border-gray-300 hover:shadow-lg focus-within:-translate-y-1 focus-within:shadow-lg';
                $muted_text_class       = 'text-sm text-gray-500';
                $feature_text_class     = 'text-gray-600';
                $button_classes         = 'button button-primary inline-flex w-full items-center justify-center gap-2 px-5 py-3 text-sm font-semibold';
                $price_label            = $is_free ? __('Free', 'ultimate-multisite') : ($is_contact ? __('Contact us', 'ultimate-multisite') : $product->get_formatted_amount());
                $recurring_description  = $product->get_recurring_description();
                ?>

                <label
                        id="wu-product-<?php echo esc_attr($product->get_id()); ?>"
                        class="<?php echo esc_attr($card_classes); ?>"
                        :class="$parent.has_product(<?php echo esc_attr($product->get_id()); ?>) || $parent.has_product('<?php echo esc_attr($product->get_slug()); ?>') ? 'border-transparent shadow-xl' : ''"
                        :style="$parent.has_product(<?php echo esc_attr($product->get_id()); ?>) || $parent.has_product('<?php echo esc_attr($product->get_slug()); ?>') ? { borderColor: 'var(--wp--preset--color--primary, currentColor)', boxShadow: '0 18px 40px -24px color-mix(in srgb, var(--wp--preset--color--primary, currentColor) 35%, transparent)' } : {}"
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
                        <span class="absolute left-6 top-6 inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide" style="background-color: color-mix(in srgb, var(--wp--preset--color--primary, currentColor) 12%, transparent); color: var(--wp--preset--color--primary, currentColor);">
                                <?php esc_html_e('Popular', 'ultimate-multisite'); ?>
                        </span>
                <?php endif; ?>

                <span
                        class="selected-badge absolute right-6 top-6 hidden items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide"
                        :class="$parent.has_product(<?php echo esc_attr($product->get_id()); ?>) || $parent.has_product('<?php echo esc_attr($product->get_slug()); ?>') ? 'inline-flex' : 'hidden'"
                        style="background-color: color-mix(in srgb, var(--wp--preset--color--primary, currentColor) 15%, transparent); color: var(--wp--preset--color--primary, currentColor);"
                >
                        <?php esc_html_e('Selected', 'ultimate-multisite'); ?>
                </span>

                <div class="flex flex-1 flex-col">
                        <div class="flex items-baseline justify-between gap-4">
                                <div>
                                        <h3 class="text-lg font-semibold">
                                                <?php echo esc_html($product->get_name()); ?>
                                        </h3>
                                        <?php if ($product->get_description()) : ?>
                                                <p class="mt-1 <?php echo esc_attr($muted_text_class); ?>">
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
                                <ul class="mt-6 space-y-3 text-sm <?php echo esc_attr($feature_text_class); ?>">
                                        <?php foreach ($feature_lines as $line) : ?>
                                                <li class="flex items-start gap-3">
                                                        <span class="mt-0.5 flex h-5 w-5 items-center justify-center rounded-full" style="background-color: color-mix(in srgb, var(--wp--preset--color--primary, currentColor) 18%, transparent); color: var(--wp--preset--color--primary, currentColor);">
                                                                <span class="sr-only"><?php esc_html_e('Included feature', 'ultimate-multisite'); ?></span>
                                                                <svg aria-hidden="true" class="h-3 w-3" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.5 8.5 2 6l1-1 1.5 1.5L9 2l1 1-5.5 5.5z" fill="currentColor" />
                                                                </svg>
                                                        </span>
                                                        <span class="leading-relaxed"><?php echo wp_kses($line, wu_kses_allowed_html()); ?></span>
                                                </li>
                                        <?php endforeach; ?>
                                </ul>
                        <?php endif; ?>

                        <div class="mt-10">
                                <span
                                        class="<?php echo esc_attr($button_classes); ?>"
                                        :class="$parent.has_product(<?php echo esc_attr($product->get_id()); ?>) || $parent.has_product('<?php echo esc_attr($product->get_slug()); ?>') ? 'is-selected' : ''"
                                >
                                        <span class="flex items-center gap-2">
                                                <svg
                                                        class="h-4 w-4 opacity-0 transition-opacity duration-200"
                                                        :class="$parent.has_product(<?php echo esc_attr($product->get_id()); ?>) || $parent.has_product('<?php echo esc_attr($product->get_slug()); ?>') ? 'opacity-100' : 'opacity-0'"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                >
                                                        <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.25 7.36a1 1 0 0 1-1.436.012L3.29 9.042A1 1 0 1 1 4.71 7.624l3.58 3.56 6.532-6.613a1 1 0 0 1 1.414-.006Z" clip-rule="evenodd" />
                                                </svg>
                                                <span v-if="$parent.has_product(<?php echo esc_attr($product->get_id()); ?>) || $parent.has_product('<?php echo esc_attr($product->get_slug()); ?>')">
                                                        <?php esc_html_e('Selected', 'ultimate-multisite'); ?>
                                                </span>
                                                <span v-else>
                                                        <?php echo esc_html($is_contact ? __('Contact sales', 'ultimate-multisite') : __('Select Plan', 'ultimate-multisite')); ?>
                                                </span>
                                        </span>
                                </span>
                        </div>
                </div>

                </label>

        <?php endforeach; ?>

</div>
