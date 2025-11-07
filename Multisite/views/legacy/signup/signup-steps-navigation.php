<?php
/**
 * Displays the navigation part on the bottom of the page
 *
 * This template can be overridden by copying it to yourtheme/wp-ultimo/signup/signup-steps-navigation.php.
 *
 * HOWEVER, on occasion Ultimate Multisite will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author      NextPress
 * @package     WP_Ultimo/Views
 * @version     1.4.0
 */

if ( ! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if ( ! $signup) {
	return;
}

?>

<?php
/**
 * Displays the Steps Bar on the bottom of the page
 */
$ouput_steps = $signup->get_steps(false);
$count       = count($ouput_steps);
$step_keys   = array_keys($signup->steps);
$current_key = array_search($signup->step, $step_keys, true);

if (false === $current_key) {
        $current_key = 0;
}

$progress = 0;

if ($count > 1) {
        $progress = ($current_key / max(1, $count - 1)) * 100;
} elseif (1 === $count) {
        $progress = 100;
}

?>

?><div class="relative">
        <div class="pointer-events-none absolute left-0 right-0 top-[26px] h-px bg-gradient-to-r from-transparent via-zinc-200 to-transparent sm:top-1/2"></div>
        <div class="pointer-events-none absolute left-0 top-[26px] h-px bg-primary transition-all duration-500 sm:top-1/2" style="width: <?php echo esc_attr(min(100, max(0, $progress))); ?>%;"></div>

        <ol class="relative z-10 flex flex-col gap-6 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">

        <?php
        $index = 0;
        foreach ($ouput_steps as $step) :
                $step_key = $step['id'];
                $step_index = array_search($step_key, $step_keys, true);

                if (false === $step_index) {
                        $step_index = 0;
                }

                $state = 'upcoming';

                if ($signup->step === $step_key) {
                        $state = 'current';
                } elseif ($current_key > $step_index) {
                        $state = 'complete';
                }

                $badge_classes = [
                        'complete' => 'border-primary bg-primary text-white shadow-[0_16px_48px_rgba(51,102,255,0.35)]',
                        'current'  => 'border-primary bg-white text-primary shadow-[0_16px_48px_rgba(51,102,255,0.18)]',
                        'upcoming' => 'border-zinc-200 bg-white text-zinc-400',
                ];

                $text_classes = [
                        'complete' => 'text-zinc-900',
                        'current'  => 'text-zinc-900',
                        'upcoming' => 'text-zinc-400',
                ];

                ?>

                <li class="flex flex-col items-center gap-3 text-center sm:flex-1">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full border text-base font-semibold transition <?php echo esc_attr($badge_classes[$state] ?? $badge_classes['upcoming']); ?>">
                                <?php echo esc_html($index + 1); ?>
                        </span>
                        <span class="text-sm font-semibold uppercase tracking-[0.16em] <?php echo esc_attr($text_classes[$state] ?? $text_classes['upcoming']); ?>">
                                <?php echo esc_html($step['name']); ?>
                        </span>
                </li>

        <?php
        ++$index;
        endforeach;
        ?>

        </ol>
</div>
<?php $prev_link = $signup->get_prev_step_link(); ?>
<?php if ($prev_link) : ?>

        <div class="mt-10 flex justify-center">

        <a class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-5 py-2 text-sm font-semibold text-zinc-600 shadow-sm transition hover:border-zinc-300 hover:text-zinc-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40" href="<?php echo esc_attr($prev_link); ?>">

                <span aria-hidden="true">&larr;</span>
                <?php esc_html_e('Back to previous step', 'ultimate-multisite'); ?>

        </a>

        </div>

<?php endif; ?>
