<?php
/**
 * The Template for displaying the signup flow for the end user
 *
 * This template can be overridden by copying it to yourtheme/wp-ultimo/signup/signup-header.php.
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

// Exit if accessed directly
defined('ABSPATH') || exit;

/** WordPress Administration Screen API */
require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';
require_once ABSPATH . 'wp-admin/includes/screen.php';

// Load the admin actions removed in WordPress 6.0
$admin_actions = [
	'admin_print_scripts'        => [
		'print_head_scripts' => 20,
	],
	'admin_print_styles'         => [
		'print_admin_styles' => 20,
	],
	'admin_head'                 => [
		'wp_color_scheme_settings' => 10,
		'wp_admin_canonical_url'   => 10,
		'wp_site_icon'             => 10,
		'wp_admin_viewport_meta'   => 10,
	],
	'admin_print_footer_scripts' => [
		'_wp_footer_scripts' => 10,
	],
];

foreach ($admin_actions as $action => $handlers) {
	foreach ($handlers as $handler => $priority) {
		if ( ! has_action($action, $handler) && function_exists($handler)) {
			add_action($action, $handler, $priority);
		}
	}
}

do_action('wu_checkout_scripts');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

	<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>
		<?php // translators: %s title of the current site ?>
		<?php echo esc_html(apply_filters('wu_signup_page_title', sprintf(__('%s - Signup', 'ultimate-multisite'), get_bloginfo('Name'), get_bloginfo('Name')))); ?>
	</title>

	<?php // Signup do action, like the default ?>
	<?php do_action('signup_header'); ?>
	<?php do_action('login_enqueue_scripts'); ?>
	<?php do_action('wu_signup_enqueue_scripts'); ?>
	<?php do_action('admin_print_scripts'); ?>
	<?php do_action('admin_print_styles'); ?>

	<?php // do_action('admin_head'); ?>

	</head>

        <body class="wu-legacy-signup-body bg-slate-50 text-zinc-900">

	<?php
	while (have_posts()) :
		the_post();
		?>

                <div class="wu-setup min-h-screen py-10">

		<?php
			/**
			 * Fires right after the start body tag is printed
			 *
			 * @since 1.6.2
			 */
			do_action('wu_signup_header');

		?>

                <div class="wu-legacy-signup__container mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">

                        <div class="text-center">
                        <h1 id="wu-setup-logo" class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
                        <a class="text-inherit no-underline hover:text-zinc-700" href="<?php echo esc_attr(get_site_url(get_current_site()->site_id)); ?>">
                                <?php // translators: %s title of the current site ?>
                                <?php printf(esc_html__('%s - Signup', 'ultimate-multisite'), esc_html(get_bloginfo('Name'))); ?>
                        </a>
                        </h1>
                        </div>

			<?php
			/**
			 * Fires before the site sign-up form.
			 */
			do_action('wu_before_signup_form');

			?>

                        <div class="wu-setup-content wu-content-<?php echo esc_attr(wu_request('step', $signup->step ?? 'default')); ?> mt-10 rounded-2xl bg-white p-8 shadow-xl ring-1 ring-zinc-200">

                        <div class="wu-legacy-signup__form space-y-8">

				<?php the_content(); ?>

			</div>

			</div>

			<?php
			/**
			 * Fires after the sign-up forms, before signup-footer
			 */
			do_action('wu_after_signup_form');

			?>

                        <?php
                        /**
                         * Nav Links
                         */
                        wu_get_template('legacy/signup/signup-nav-links', ['signup' => $signup]);
                        ?>

                </div>

                <div class="mx-auto mt-12 w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                        <?php
                        /**
                         * Navigation Steps
                         */
                        wu_get_template('legacy/signup/signup-steps-navigation', ['signup' => $signup]);
                        ?>
                </div>

		<?php
			/**
			 * Fires right after the start body tag is printed
			 *
			 * @since 1.6.2
			 */
			do_action('wu_signup_footer');

		?>

		</div>

	<?php endwhile; ?>

	<?php

		global $wp_scripts;

		// $wp_scripts will output and format the tag correctly and safely.
		echo $wp_scripts->get_inline_script_tag('wu-checkout'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	?>

	<?php
		/**
		 * We also need to print the footer admin scripts, to make sure we are enqueing some of the scripts dependencies
		 * our scripts need in order to function properly
		 */
		do_action('admin_print_footer_scripts');
	?>

	</body>

</html>
