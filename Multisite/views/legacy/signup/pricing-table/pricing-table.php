<?php
/**
 * Displays the pricing tables
 *
 * This template can be overridden by copying it to yourtheme/wp-ultimo/signup/princing-table/princing-table.php.
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

<div class="wu-setup-content wu-content-<?php echo isset($is_shortcode) && $is_shortcode ? 'shortcode-plan' : 'plan'; ?>">

<?php

/**
 * Display the frequency selector
 */
if ( ! isset($is_shortcode) || ! $is_shortcode || $atts['show_selector']) {
	wu_get_template('/legacy/signup/pricing-table/frequency-selector');
}

/**
 * Displays error message if there are no plans
 */

if (empty($plans)) {
	wu_get_template('legacy/signup/pricing-table/no-plans');
} else {
	?>

	<form id="signupform" method="post">

	<?php

	/**
	 * Required: Prints the essential fields necessary to this form to work properly
	 */
	$signup->form_fields($current_plan);

	?>

        <div class="layer plans mt-10">

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                <?php

                /**
                 * Display the plan table
                 */

                $count   = count($plans);
                $columns = 5 === $count ? '2-4' : 12 / $count;

                foreach ($plans as $plan) {
                        wu_get_template(
                                'legacy/signup/pricing-table/plan',
                                [
                                        'plan'         => $plan,
                                        'count'        => $count,
                                        'columns'      => $columns,
                                        'current_plan' => $current_plan,
                                ]
                        );
                }

                ?>

                </div>

        </div>

	</form>

<?php } // end if no-plans; ?>

</div>



<?php
wp_enqueue_script('wu-pricing-table', wu_get_asset('pricing-table.js', 'js'), ['jquery'], wu_get_version(), true);
wp_add_inline_script('wu-pricing-table', 'var wu_default_pricing_option = "' . esc_js(wu_get_setting('default_pricing_option', 1)) . '";', 'before');
wp_add_inline_script(
        'wu-pricing-table',
        "jQuery(function($){\n        $(document).on('click', '.wu-plans-frequency-selector a', function(){\n                var $link = $(this);\n                var $group = $link.closest('.wu-plans-frequency-selector');\n                $group.find('a')\n                        .attr('aria-pressed', 'false')\n                        .removeClass('active bg-zinc-900 text-white')\n                        .addClass('bg-white text-zinc-600 hover:bg-zinc-100');\n                $link\n                        .attr('aria-pressed', 'true')\n                        .addClass('active bg-zinc-900 text-white')\n                        .removeClass('bg-white text-zinc-600 hover:bg-zinc-100');\n        });\n});",
        'after'
);
?>
