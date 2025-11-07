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

$theme_stylesheet       = trailingslashit(get_stylesheet_directory()) . 'build/assets/app.css';
$theme_stylesheet_uri   = trailingslashit(get_stylesheet_directory_uri()) . 'build/assets/app.css';
$webmakerr_override     = trailingslashit(WP_ULTIMO_PLUGIN_DIR) . 'assets/css/webmakerr-legacy-signup.css';
$webmakerr_override_uri = trailingslashit(WP_ULTIMO_PLUGIN_URL) . 'assets/css/webmakerr-legacy-signup.css';

$has_theme_stylesheet = file_exists($theme_stylesheet);

if ($has_theme_stylesheet) {
        wp_enqueue_style(
                'webmakerr-legacy-signup-theme',
                $theme_stylesheet_uri,
                [],
                (string) filemtime($theme_stylesheet)
        );
}

if (file_exists($webmakerr_override)) {
        $deps = $has_theme_stylesheet ? ['webmakerr-legacy-signup-theme'] : [];

        wp_enqueue_style(
                'wu-legacy-signup-webmakerr',
                $webmakerr_override_uri,
                $deps,
                (string) filemtime($webmakerr_override)
        );
}

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

        <body class="login wp-core-ui wu-legacy-signup-body antialiased bg-gradient-to-b from-[#eef2ff] via-white to-white text-zinc-950">

        <?php
        while (have_posts()) :
                the_post();
                ?>

                <div class="wu-setup relative flex min-h-screen flex-col">

                <?php
                        /**
                         * Fires right after the start body tag is printed
                         *
                         * @since 1.6.2
                         */
                        do_action('wu_signup_header');

                ?>

                <main class="relative flex flex-1 flex-col">
                        <section class="relative isolate flex-1 overflow-hidden py-16 sm:py-20 lg:py-24">
                                <div class="pointer-events-none absolute inset-0 -z-10">
                                        <div class="absolute left-1/2 top-[-240px] h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-[radial-gradient(circle_at_top,_rgba(79,165,255,0.28),_transparent_65%)] blur-3xl"></div>
                                        <div class="absolute bottom-[-160px] right-[-120px] h-[420px] w-[420px] rounded-full bg-[radial-gradient(circle_at_bottom,_rgba(255,107,214,0.25),_transparent_60%)] blur-3xl"></div>
                                        <div class="absolute bottom-24 left-[-160px] hidden h-64 w-64 rounded-[48px] border border-white/30 bg-white/30 backdrop-blur-xl lg:block"></div>
                                </div>

                                <div class="relative mx-auto w-full max-w-screen-xl px-6 lg:px-8">
                                        <div id="login" class="grid gap-12 lg:grid-cols-[minmax(0,_0.55fr)_minmax(0,_0.45fr)] lg:items-center">
                                                <div class="flex flex-col gap-6">
                                                        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-primary/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-primary">
                                                                <span class="h-2 w-2 rounded-full bg-primary"></span>
                                                                <?php esc_html_e('Create your Webmakerr account', 'ultimate-multisite'); ?>
                                                        </span>
                                                        <h1 id="wu-setup-logo" class="text-3xl font-semibold tracking-tight text-zinc-950 [text-wrap:balance] sm:text-4xl lg:text-5xl">
                                                                <a class="no-underline text-inherit" href="<?php echo esc_attr(get_site_url(get_current_site()->site_id)); ?>">
                                                                        <?php // translators: %s title of the current site ?>
                                                                        <?php printf(esc_html__('%s – Signup', 'ultimate-multisite'), esc_html(get_bloginfo('Name'))); ?>
                                                                </a>
                                                        </h1>
                                                        <p class="max-w-xl text-base leading-7 text-zinc-600 sm:text-lg">
                                                                <?php echo esc_html__('Join the Webmakerr platform to launch your site with the same conversion-focused system used across our templates. Complete the steps to unlock your workspace, billing, and template selection.', 'ultimate-multisite'); ?>
                                                        </p>
                                                        <ul class="grid gap-3 text-sm text-zinc-600 sm:text-base">
                                                                <li class="flex items-start gap-3">
                                                                        <span class="mt-2 h-2.5 w-2.5 flex-none rounded-full bg-primary"></span>
                                                                        <span><?php echo esc_html__('Secure checkout with flexible subscription options.', 'ultimate-multisite'); ?></span>
                                                                </li>
                                                                <li class="flex items-start gap-3">
                                                                        <span class="mt-2 h-2.5 w-2.5 flex-none rounded-full bg-primary"></span>
                                                                        <span><?php echo esc_html__('Access premium templates, automations, and onboarding guides.', 'ultimate-multisite'); ?></span>
                                                                </li>
                                                                <li class="flex items-start gap-3">
                                                                        <span class="mt-2 h-2.5 w-2.5 flex-none rounded-full bg-primary"></span>
                                                                        <span><?php echo esc_html__('Collaborate with your team using the unified Webmakerr dashboard.', 'ultimate-multisite'); ?></span>
                                                                </li>
                                                        </ul>
                                                </div>

                                                <div class="relative">
                                                        <div class="absolute -right-4 -top-6 h-16 w-16 rounded-full bg-white/60 blur-2xl"></div>
                                                        <div class="absolute -bottom-10 left-6 h-24 w-24 rounded-full bg-primary/20 blur-2xl"></div>
                                                        <div class="relative overflow-hidden rounded-[18px] border border-white/60 bg-white/80 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.12)] backdrop-blur">
                                                                <?php
                                                                /**
                                                                 * Fires before the site sign-up form.
                                                                 */
                                                                do_action('wu_before_signup_form');

                                                                ?>

                                                                <div class="wu-setup-content wu-content-<?php echo esc_attr(wu_request('step', $signup->step ?? 'default')); ?>">

                                                                <div name="loginform" id="loginform" class="space-y-6">

                                                                        <?php the_content(); ?>

                                                                </div>

                                                                </div>

                                                                <?php
                                                                /**
                                                                 * Fires after the sign-up forms, before signup-footer
                                                                 */
                                                                do_action('wu_after_signup_form');

                                                                ?>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </section>

                        <section class="relative z-10 pb-12">
                                <div class="mx-auto w-full max-w-screen-xl px-6 lg:px-8">
                                <?php
                                /**
                                 * Nav Links
                                 */
                                wu_get_template('legacy/signup/signup-nav-links', ['signup' => $signup]);
                                ?>
                                </div>
                        </section>

                        <section class="relative z-10 border-t border-white/60 bg-white/70 py-12 backdrop-blur">
                                <div class="mx-auto w-full max-w-screen-xl px-6 lg:px-8">
                                <?php
                                /**
                                 * Navigation Steps
                                 */
                                wu_get_template('legacy/signup/signup-steps-navigation', ['signup' => $signup]);
                                ?>
                                </div>
                        </section>
                </main>

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
