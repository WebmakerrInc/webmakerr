<?php
/**
 * Displays the frequency selector for the pricing tables
 *
 * This template can be overridden by copying it to yourtheme/wp-ultimo/signup/pricing-table/frequency-selector.php.
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

<?php if (wu_get_setting('enable_price_3', true) || wu_get_setting('enable_price_12', true)) : ?>

<ul class="wu-plans-frequency-selector inline-flex items-center gap-1 rounded-full border border-white/60 bg-white/90 p-1.5 shadow-[0_20px_44px_rgba(15,23,42,0.12)]">

        <?php

        $prices = [
		1  => __('Monthly', 'ultimate-multisite'),
		3  => __('Quarterly', 'ultimate-multisite'),
		12 => __('Yearly', 'ultimate-multisite'),
	];

	$first = true;

	foreach ($prices as $type => $name) :
		if ( ! wu_get_setting('enable_price_' . $type, true)) {
			continue;
		}

		?>

        <li class="list-none">
        <a class="<?php echo $first ? 'active first' : ''; ?> inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-semibold text-zinc-500 transition hover:bg-primary/10 hover:text-zinc-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 focus-visible:ring-offset-white" data-frequency-selector="<?php echo esc_attr($type); ?>" href="#">
                <?php echo esc_html($name); ?>
        </a>
        </li>

                <?php
                $first = false;
endforeach;
	?>

</ul>

<?php endif; ?>
