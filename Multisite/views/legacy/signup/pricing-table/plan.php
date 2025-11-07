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
        $price = $plan->free ? __('Free!', 'ultimate-multisite') : str_replace(wu_get_currency_symbol(), '', wu_format_currency(((float) $plan->{'price_' . $type}) / $type));
        printf(" data-price-%s='%s'", esc_attr($type), esc_attr($price));
}
?>
        class="<?php echo esc_attr("wu-product-{$plan->get_id()}"); ?> group relative flex h-full flex-col overflow-hidden rounded-2xl border border-white/60 bg-white/90 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.12)] transition duration-200 hover:-translate-y-2 hover:border-primary/50 hover:shadow-[0_32px_80px_rgba(44,127,255,0.2)] wu-plan plan-tier <?php echo $plan->is_featured_plan() ? 'callout ring-2 ring-primary/60 ring-offset-2 ring-offset-white' : ''; ?>">

        <?php if ($plan->is_featured_plan()) : ?>

        <div class="mb-4 inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
                <span class="h-2 w-2 rounded-full bg-primary"></span>
                <?php echo esc_html(apply_filters('wu_featured_plan_label', __('Featured Plan', 'ultimate-multisite'), $plan)); ?>
        </div>

        <?php endif; ?>

        <div class="flex flex-col gap-5">
                <div class="space-y-3">
                        <h4 class="text-xl font-semibold text-zinc-950"><?php echo esc_html($plan->get_name()); ?></h4>

                        <!-- Price -->
                        <?php if ($plan->is_free()) : ?>

                        <h5 class="flex items-baseline gap-2 text-4xl font-semibold text-zinc-950">
                                <span class="plan-price"><?php esc_html_e('Free!', 'ultimate-multisite'); ?></span>
                        </h5>

                        <?php elseif ($plan->is_contact_us()) : ?>

                        <h5 class="flex items-baseline gap-2 text-3xl font-semibold text-zinc-950">
                                <span class="plan-price-contact-us"><?php echo esc_html(apply_filters('wu_plan_contact_us_price_line', __('--', 'ultimate-multisite'))); ?></span>
                        </h5>

                        <?php else : ?>

                        <h5 class="flex items-baseline gap-2 text-4xl font-semibold text-zinc-950">
                                <?php $symbol_left = in_array(wu_get_setting('currency_position', '%s%v'), ['%s%v', '%s %v'], true); ?>
                                <?php if ($symbol_left) : ?>
                                        <sup class="superscript -translate-y-1 text-sm font-semibold text-zinc-500"><?php echo esc_html(wu_get_currency_symbol()); ?></sup>
                                <?php endif; ?>
                                <span class="plan-price leading-none"><?php echo esc_html(str_replace(wu_get_currency_symbol(), '', wu_format_currency($plan->price_1))); ?></span>
                                <sub class="text-sm font-medium text-zinc-500"><?php echo esc_html((! $symbol_left ? wu_get_currency_symbol() : '') . ' ' . __('/mo', 'ultimate-multisite')); ?></sub>
                        </h5>

                        <?php endif; ?>
                        <!-- end Price -->

                        <p class="early-adopter-price text-sm leading-6 text-zinc-600"><?php echo esc_html($plan->get_description()); ?>&nbsp;</p>
                </div>

                <!-- Feature List Begins -->
                <ul class="mt-2 flex flex-col gap-3 text-sm leading-6 text-zinc-600">

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
                                echo "<li class='total-price total-price-" . esc_attr($freq) . " text-xs font-medium text-zinc-500'>-</li>";
                        } else {
                                echo "<li class='total-price total-price-" . esc_attr($freq) . " text-xs font-medium text-zinc-500'>" . esc_html($text) . '</li>';
                        }
                }

                /**
                 * Loop and Displays Pricing Table Lines
                 */
                foreach ($plan->get_pricing_table_lines() as $key => $line) :
                        ?>

                        <li class="feature-line flex items-start gap-3 <?php echo esc_attr(str_replace('_', '-', $key)); ?>">
                                <span class="mt-1 flex h-5 w-5 flex-none items-center justify-center rounded-full bg-primary/10 text-primary">
                                        <svg aria-hidden="true" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.01 7.062a1 1 0 0 1-1.423.01L3.29 8.78a1 1 0 1 1 1.414-1.414l4.004 4.004 6.303-6.35a1 1 0 0 1 1.414-.01z" clip-rule="evenodd" />
                                        </svg>
                                </span>
                                <span class="flex-1"><?php echo wp_kses_post($line); ?></span>
                        </li>

                <?php endforeach; ?>

                <?php
                $button_attrubutes = trim(apply_filters('wu_plan_select_button_attributes', '', $plan, $current_plan));
                $button_label      = null != $current_plan && $plan->get_id() == $current_plan->id ? __('This is your current plan', 'ultimate-multisite') : __('Select Plan', 'ultimate-multisite');
                $button_label      = apply_filters('wu_plan_select_button_label', $button_label, $plan, $current_plan);
                ?>

                <?php if ($plan->is_contact_us()) : ?>

                        <li class="wu-cta mt-6">
                        <a href="<?php echo esc_attr($plan->contact_us_link); ?>" class="button button-primary inline-flex w-full items-center justify-center rounded-full bg-primary px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 focus-visible:ring-offset-white !no-underline">
                                <?php echo esc_html($plan->get_contact_us_label()); ?>
                        </a>
                        </li>

                <?php else : ?>

                        <li class="wu-cta mt-6">
                        <button type="submit" name="plan_id" class="button button-primary button-next inline-flex w-full items-center justify-center rounded-full bg-primary px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 focus-visible:ring-offset-white" value="<?php echo esc_attr($plan->get_id()); ?>"<?php echo $button_attrubutes ? ' ' . $button_attrubutes : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                <?php echo esc_html($button_label); ?>
                        </button>
                        </li>

                <?php endif; ?>

                </ul>
                <!-- Feature List Begins -->
        </div>

</div>
