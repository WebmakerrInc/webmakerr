<?php
/**
 * Displays each individual plan on the pricing table loop
 *
 * This template can be overridden by copying it to yourtheme/wp-ultimo/signup/plan.php.
 *
 * HOWEVER, on occasion Ultimate Multisite will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author      NextPress
 * @package     WP_Ultimo/Views
 * @version     1.0.0
 */

if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

?>


<div id="plan-<?php echo esc_attr($plan->get_id()); ?>" data-plan="<?php echo esc_attr($plan->get_id()); ?>"
<?php

foreach ([1, 3, 12] as $type) {
        $price = $plan->free ? __('Free!', 'ultimate-multisite') : str_replace(wu_get_currency_symbol(), '', wu_format_currency((((float) $plan->{'price_' . $type}) / $type)));
        printf(" data-price-%s='%s'", esc_attr($type), esc_attr($price));
}

?>
        class="<?php echo esc_attr("wu-product-{$plan->get_id()}"); ?> wu-plan flex h-full flex-col rounded-2xl border border-zinc-200 <?php echo $plan->is_featured_plan() ? 'callout border-zinc-900/40 bg-zinc-50 ring-1 ring-zinc-900/10' : 'bg-white'; ?> p-6 text-left shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg focus-within:-translate-y-1 focus-within:shadow-lg">

        <div class="flex flex-col gap-4">

        <?php if ($plan->is_featured_plan()) : ?>

                <h6 class="inline-flex w-fit items-center rounded-full bg-zinc-900/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-900">
                        <?php echo esc_html(apply_filters('wu_featured_plan_label', __('Featured Plan', 'ultimate-multisite'), $plan)); ?>
                </h6>

        <?php endif; ?>

        <h4 class="text-xl font-semibold text-zinc-950"><?php echo esc_html($plan->get_name()); ?></h4>

        <!-- Price -->
        <?php if ($plan->is_free()) : ?>

                <h5 class="text-3xl font-semibold text-zinc-950">
                        <span class="plan-price"><?php esc_html_e('Free!', 'ultimate-multisite'); ?></span>
                </h5>

        <?php elseif ($plan->is_contact_us()) : ?>

                <h5 class="text-3xl font-semibold text-zinc-950">
                        <span class="plan-price-contact-us"><?php echo esc_html(apply_filters('wu_plan_contact_us_price_line', __('--', 'ultimate-multisite'))); ?></span>
                </h5>

        <?php else : ?>

                <h5 class="text-3xl font-semibold text-zinc-950">
                        <?php $symbol_left = in_array(wu_get_setting('currency_position', '%s%v'), ['%s%v', '%s %v'], true); ?>
                        <?php
                        if ($symbol_left) :
                                ?>
                                <sup class="superscript text-sm font-semibold text-zinc-600"><?php echo esc_html(wu_get_currency_symbol()); ?></sup><?php endif; ?>
                        <span class="plan-price"><?php echo esc_html(str_replace(wu_get_currency_symbol(), '', wu_format_currency($plan->price_1))); ?></span>
                        <sub class="text-base font-medium text-zinc-500"> <?php echo esc_html((! $symbol_left ? wu_get_currency_symbol() : '') . ' ' . __('/mo', 'ultimate-multisite')); ?></sub>
                </h5>

        <?php endif; ?>
        <!-- end Price -->

        <?php if ($plan->get_description()) : ?>
                <p class="text-sm leading-6 text-zinc-600"><?php echo esc_html($plan->get_description()); ?></p>
        <?php endif; ?>

        </div>

        <!-- Feature List Begins -->
        <ul class="mt-6 flex flex-1 flex-col gap-3 text-sm leading-6 text-zinc-600">

        <?php
        /**
         *
         * Display quarterly and Annually plans, to be hidden
         */
        $prices_total = [
                3  => __('every 3 months', 'ultimate-multisite'),
                12 => __('yearly', 'ultimate-multisite'),
        ];

        foreach ($prices_total as $freq => $string) {
                // translators: %1$s: the price, %2$s: the period.
                $text = sprintf(__('%1$s, billed %2$s', 'ultimate-multisite'), wu_format_currency($plan->{"price_$freq"}), $string);

                if ($plan->free || $plan->is_contact_us()) {
                        echo "<li class='total-price total-price-" . esc_attr($freq) . " text-xs font-medium uppercase tracking-[0.2em] text-zinc-500'>-</li>";
                } else {
                        echo "<li class='total-price total-price-" . esc_attr($freq) . " text-xs font-medium uppercase tracking-[0.2em] text-zinc-500'>" . esc_html($text) . '</li>';
                }
        }

        /**
         * Loop and Displays Pricing Table Lines
         */
        foreach ($plan->get_pricing_table_lines() as $key => $line) :
                ?>

                <li class="flex items-start gap-2 <?php echo esc_attr(str_replace('_', '-', $key)); ?>"><span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-zinc-400"></span><span class="flex-1"><?php echo wp_kses_post($line); ?></span></li>

        <?php endforeach; ?>

        </ul>
        <!-- Feature List Begins -->

        <?php
        $button_attributes = apply_filters('wu_plan_select_button_attributes', '', $plan, $current_plan);
        $button_attributes = trim(is_string($button_attributes) ? $button_attributes : '');
        $button_attributes = $button_attributes ? ' ' . $button_attributes : '';
        $button_label      = null != $current_plan && $plan->get_id() == $current_plan->id ? __('This is your current plan', 'ultimate-multisite') : __('Select Plan', 'ultimate-multisite');
        $button_label      = apply_filters('wu_plan_select_button_label', $button_label, $plan, $current_plan);
        ?>

        <div class="mt-6">

        <?php if ($plan->is_contact_us()) : ?>

                <a href="<?php echo esc_attr($plan->contact_us_link); ?>" class="button button-primary inline-flex w-full items-center justify-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900">
                        <?php echo esc_html($plan->get_contact_us_label()); ?>
                </a>

        <?php else : ?>

                <button type="submit" name="plan_id" class="button button-primary button-next inline-flex w-full items-center justify-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900" value="<?php echo esc_attr($plan->get_id()); ?>"<?php echo $button_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                        <?php echo esc_html($button_label); ?>
                </button>

        <?php endif; ?>

        </div>

</div>
