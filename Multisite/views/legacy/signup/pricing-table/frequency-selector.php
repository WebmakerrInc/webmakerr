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

<ul class="wu-plans-frequency-selector mt-6 flex flex-wrap items-center justify-center gap-3">

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

        <li>
        <a class="inline-flex items-center rounded-full border border-transparent px-4 py-2 text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900 <?php echo $first ? 'active first bg-zinc-900 text-white' : 'bg-white text-zinc-600 hover:bg-zinc-100'; ?>" data-frequency-selector="<?php echo esc_attr($type); ?>" href="#" aria-pressed="<?php echo $first ? 'true' : 'false'; ?>">
                <?php echo esc_html($name); ?>
        </a>
        </li>

		<?php
		$first = false;
endforeach;
	?>

</ul>

<?php endif; ?>
