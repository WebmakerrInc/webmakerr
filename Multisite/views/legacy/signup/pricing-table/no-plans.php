<?php
/**
 * Displays the error message in case there are no plans availabe for subscription
 *
 * This template can be overridden by copying it to yourtheme/wp-ultimo/signup/no-plan.php.
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

<div class="wu-setup-content-error rounded-2xl border border-red-200/70 bg-red-50/80 p-6 text-center shadow-[0_20px_44px_rgba(239,68,68,0.18)]">
        <p class="text-base font-semibold text-red-700"><?php esc_html_e('There are no Plans created in the platform.', 'ultimate-multisite'); ?></p>
</div>
